<?php

namespace AniketIN\Wallet\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Round implements CastsAttributes
{
    /**
     * The decimal count.
     *
     * @var string
     */
    protected $decimal;


    /**
     * Create a new cast class instance.
     *
     * @param  string|null  $decimal
     * @return void
     */
    public function __construct($decimal = 2)
    {
        $this->decimal = $decimal;
    }

    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return round($value, $this->decimal);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return $value;
    }
}
