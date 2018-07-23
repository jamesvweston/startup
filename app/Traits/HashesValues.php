<?php

namespace App\Traits;


trait HashesValues
{

    /**
     * @param mixed $value
     * @return string
     */
    private function encodeValue ($value)
    {
        return app('hashid')->encode($value);
    }

    /**
     * @param mixed $item
     * @return string|null
     */
    private function decodeHash ($item)
    {
        if (is_null($item) || empty($item))
            return null;

        $new_values             = [];
        foreach (explode(',', $item) AS $item)
        {
            $decoded    = collect(app('hashid')->decode($item))->first();
            if (!is_null($decoded))
                $new_values[]     = $decoded;
        }
        $new_values             = sizeof($new_values) == 1 ? $new_values[0] : implode(',', $new_values);
        return $new_values;
    }

}
