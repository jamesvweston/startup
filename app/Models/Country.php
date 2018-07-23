<?php

namespace App\Models;


use App\Traits\HashesValues;
use Illuminate\Database\Eloquent\Model;

/**
 * @property    int                             $id
 * @property    string                          $name
 * @property    string                          $code
 */
class Country extends Model
{

    use HashesValues;

    public $timestamps = false;


    /**
     * @return array
     */
    public function toArray()
    {
        $object['id']                   = $this->encodeValue($this->id);
        $object['name']                 = $this->name;
        $object['code']                 = $this->code;

        return $object;
    }

}
