<?php

namespace App\Providers;

use App\Services\DivergePriceService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('diverg', function ($attribute, $value, $parameters,\Illuminate\Validation\Validator $validator) {
            $divergeService = new DivergePriceService();
            $outPrice = request()->get($parameters[0]);

            if (is_null($outPrice)) {
                $validator->messages()->add($parameters[0], "Error attribute!");
                return false;
            }

            if (!$divergeService->diffPrice($value, $outPrice)) {
                $validator->messages()->add($attribute, "Error message!");
                return false;
            }

            return true;
        });
    }
}
