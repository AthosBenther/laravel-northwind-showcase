<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class BlobImageCast implements CastsAttributes
{
    /**
     * Cast the value when reading from the database.
     */
    public function get($model, string $key, $value, array $attributes)
    {
        if ($value === null) {
            return null;
        }

        // Handle SQLite returning a stream instead of string
        if (is_resource($value)) {
            $value = stream_get_contents($value);
        }

        // Detect MIME type dynamically
        $mime = finfo_buffer(finfo_open(), $value, FILEINFO_MIME_TYPE);

        // Return as base64 Data URI for direct <img src="...">
        return "data:{$mime};base64," . base64_encode($value);
    }

    /**
     * Prepare the value for storage in the database.
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if ($value === null) {
            return null;
        }

        // If we get a data URI, strip the prefix
        if (str_starts_with($value, 'data:')) {
            [, $value] = explode(',', $value, 2);
            $value = base64_decode($value);
        }

        return $value; // raw binary
    }
}
