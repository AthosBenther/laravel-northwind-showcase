<?php

namespace App\Http\Controllers;


use App\Models\Product;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use App\Http\Requests\Order\Index;
use App\Http\Requests\Order\Store;
use App\Http\Requests\Order\Update;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Shipper;
use Illuminate\Support\Facades\DB;

class OrderController extends NorthwindController
{
    /**
     * Lists existing Orders.
     * 
     * Returns a paginated list of Orders.
     * 
     * @param Index $request Default index request parameters.
     * 
     */
    public function index(Index $request): OrderCollection
    {
        return new OrderCollection(Order::paginate($request->per_page ?? 5));
    }

    /**
     * Store a newly created Order.
     */
    public function store(Store $request): OrderResource
    {
        $validated = $request->validated();
        $customer = Customer::find($request->input('CustomerID'));
        $data = [
            ...$validated,
            'OrderDate' => now(),
            'RequiredDate' => $validated['RequiredDate'] ?? null,
            "ShipName" => $validated['ShipName'] ?? $customer->CompanyName,
            "ShipAddress" => $validated['ShipAddress'] ?? $customer->Address,
            "ShipCity" => $validated['ShipCity'] ?? $customer->City,
            "ShipRegion" => $validated['ShipRegion'] ?? $customer->Region,
            "ShipPostalCode" => $validated['ShipPostalCode'] ?? $customer->PostalCode,
            "ShipCountry" => $validated['ShipCountry'] ?? $customer->Country,
        ];
        $order = Order::create($data);

        return new OrderResource($order);
    }

    /**
     * Display the specified Order.
     */
    public function show(Order $order): OrderResource
    {
        return $order->toResource();
    }

    /**
     * Update the specified Order.
     */
    public function update(Update $request, Order $order): OrderResource
    {
        $validated = $request->validated();
        $order->load('details');

        $requestedProductsIDs = collect($validated['Products'])->pluck('ProductID')->toArray();
        $requestedProducts = Product::whereIn('ProductID', $requestedProductsIDs)
            ->get()
            ->keyBy('ProductID');

        $new = collect($validated['Products'])->pluck('Quantity', 'ProductID'); // new

        $delta = $new->map(function ($qty, $id) use ($order) {
            $delta = $qty - ($order->details->where('ProductID', $id)->first()->pivot->Quantity ?? 0);
            if ($delta != 0)
                return $delta;
        })->filter();

        DB::transaction(
            function () use ($validated, $order, $requestedProducts, $delta) {
                $order->update($validated);


                $stockErrors = [];

                foreach ($validated['Products'] as $id => $reqProd) {
                    $product = $requestedProducts->find($reqProd['ProductID']);

                    $reqQty = $reqProd['Quantity'];

                    $existingQty = optional($order->details->firstWhere('ProductID', $reqProd['ProductID']))->pivot->Quantity ?? 0;
                    $availableQty = $product->UnitsInStock + $existingQty;

                    if ($reqQty > $availableQty) {
                        $stockErrors[] = [
                            'ProductID' => $product->ProductID,
                            'ProductName' => $product->ProductName,
                            'QuantityRequested' => $reqProd['Quantity'],
                            'AvailableQuantity' => $availableQty
                        ];
                    }
                }


                if (!empty($stockErrors)) {
                    throw new HttpResponseException(response()->json([
                        'message' => 'One or more products are out of stock for the requested quantities',
                        'errors' => $stockErrors,
                    ], 422));
                }

                if ($delta->isNotEmpty()) {
                    $cases = [];
                    $ids = [];

                    foreach ($delta as $productId => $change) {
                        $product = $requestedProducts[$productId];
                        $newStock = $product->UnitsInStock - $change;
                        $cases[] = "WHEN {$productId} THEN {$newStock}";
                        $ids[] = $productId;
                    }

                    $caseSql = implode(' ', $cases);
                    $idsList = implode(',', $ids);

                    DB::statement("
                                            UPDATE Products
                                            SET UnitsInStock = CASE ProductID
                                                {$caseSql}
                                            END
                                            WHERE ProductID IN ({$idsList})
                                        ");
                }


                $products = collect($validated['Products'] ?? [])
                    ->mapWithKeys(function ($product) use ($requestedProducts) {
                        $productData = $requestedProducts[$product['ProductID']];
                        return [
                            $product['ProductID'] => [
                                'UnitPrice' => $productData->UnitPrice,
                                'Quantity' => $product['Quantity'],
                                'Discount' => $product['Discount'] ?? 0,
                            ],
                        ];
                    })
                    ->toArray();

                $order->details()->sync($products);
            }
        );
        $order->refresh();

        return $order->toResource();
    }

    /**
     * Commits the existing order.
     */
    public function commit(Order $order): OrderResource
    {

        if (!is_null($order->RequiredDate))
            abort(403, 'Order has already been committed.');

        if ($order->Details()->count() == 0)
            abort(400, 'Cannot commit an order with no products.');


        $order->update(
            [
                'RequiredDate' => now(),
                'ShippedDate' => now()->addDays(3),
                'Freight' => fake()->randomFloat(2, 0, 500),
                "ShipVia" => fake()->randomElement(Shipper::pluck('ShipperID')->toArray()),
            ]
        );
        $order->save();

        return $order->toResource();
    }

    public function destroy(Order $order): Response
    {
        if ($order->RequiredDate) {
            abort(403, 'Cannot delete a committed order');
        }

        DB::transaction(function () use ($order) {
            $order->load('details');

            // Collect the quantities to restore
            $restoreData = $order->details->mapWithKeys(function ($detail) {
                return [$detail->ProductID => $detail->pivot->Quantity];
            });

            if ($restoreData->isNotEmpty()) {
                $cases = [];
                $ids = [];

                foreach ($restoreData as $productId => $qty) {
                    $cases[] = "WHEN {$productId} THEN UnitsInStock + {$qty}";
                    $ids[] = $productId;
                }

                $caseSql = implode(' ', $cases);
                $idsList = implode(',', $ids);

                DB::statement("
                UPDATE Products
                SET UnitsInStock = CASE ProductID
                    {$caseSql}
                END
                WHERE ProductID IN ({$idsList})
            ");
            }

            // Delete order details first (pivot cleanup)
            $order->details()->detach();

            // Finally delete the order
            $order->delete();
        });

        return response()->noContent();
    }
}
