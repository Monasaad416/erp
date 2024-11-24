<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('gtin_length', function ($attribute, $value, $parameters, $validator) {
            $validGtinLengths = [8, 12, 13, 14];
            $gtinLength = strlen((string) $value);
            return in_array($gtinLength, $validGtinLengths);
        });

        Validator::extend('gln_length', function ($attribute, $value, $parameters, $validator) {
            $validGlnLengths = [13];
            $glnLength = strlen((string) $value);
            return in_array($glnLength, $validGlnLengths);
        });

        Validator::extend('tax_num_length', function ($attribute, $value, $parameters, $validator) {
            $validTaxNumLengths = [15];
            $taxNunLength = strlen((string) $value);
            return in_array($taxNunLength, $validTaxNumLengths);
        });
         Validator::extend('building_number_length', function ($attribute, $value, $parameters, $validator) {
            $validTaxNumLengths = [4];
            $taxNunLength = strlen((string) $value);
            return in_array($taxNunLength, $validTaxNumLengths);
        });

        Validator::extend('postal_code_length', function ($attribute, $value, $parameters, $validator) {
            $validTaxNumLengths = [5];
            $taxNunLength = strlen((string) $value);
            return in_array($taxNunLength, $validTaxNumLengths);
        });
    }

}
