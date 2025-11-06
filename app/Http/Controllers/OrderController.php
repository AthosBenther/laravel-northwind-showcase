<?php

namespace App\Http\Controllers;


use Illuminate\Http\Response;
use App\Http\Requests\Order\Index;
use App\Http\Requests\Order\Store;
use App\Http\Requests\Order\Update;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Shipper;

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
        $order->update($validated);

        $products = collect($validated['Products'] ?? [])
            ->mapWithKeys(function ($product) {
                $productData = \App\Models\Product::find($product['ProductID']);
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

        return $order->toResource();
    }

    /**
     * Commits the existing order.
     */
    public function commit(Order $order): OrderResource
    {
        if ($order->Details()->count() == 0)
            abort(400, 'Cannot commit an order with no products.');

        if (!is_null($order->RequiredDate))
            abort(403, 'Order has already been committed.');

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order): Response
    {
        $order->delete();

        return response()->noContent();
    }
}
