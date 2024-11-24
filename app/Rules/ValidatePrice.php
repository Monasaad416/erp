<?php

namespace App\Rules\ValidatePrice;



class ValidatePrice implements Rule
{
    protected $treasuryBalance;

    public function __construct($price)
    {
        $this->price = $price;
    }

    public function passes($attribute, $value)
    {
        return $value > $this->treasuryBalance;
    }

    public function message()
    {
        return 'The :attribute must be greater than the treasury balance.';
    }
}