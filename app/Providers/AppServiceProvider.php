<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Support\Facades\Route;
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


        Validator::extend('invoice_product_unique', function ($attribute, $value, $parameters, $validator) {
            $inputs = $validator->getData();
            $product_id = $inputs['product_id'];
            $invoice_id = $inputs['invoice_id'];

            $invoice = Invoice::find($invoice_id);

            foreach ($invoice->products as $product) {
                if ($product->id == $product_id) {
                    return false;
                }
            }

            return true;
        });


        Validator::extend('statement_create_month_unique', function ($attribute, $value, $parameters, $validator) {
            $inputs = $validator->getData();
            $client_id = $inputs['client_id'];
            $date = $inputs['date'];

            $year = date('Y', strtotime($date));
            $month = date('F', strtotime($date));


            $client = Client::find($client_id);
            $statements = $client->statements;

            $valid = true;
            foreach ($statements as $statement) {

                $statement_y = date('Y', strtotime($statement->date));
                $statement_m = date('F', strtotime($statement->date));

                if ($statement_y == $year && $statement_m == $month) {
                    $valid = false;
                    break;
                }
            }


            return $valid;
        });

        Validator::extend('statement_update_month_unique', function ($attribute, $value, $parameters, $validator) {

            $inputs = $validator->getData();
            $client_id = $inputs['client_id'];
            $date = $inputs['date'];

            $statement= Route::current()->parameter('statement');


            $year = date('Y', strtotime($date));
            $month = date('F', strtotime($date));

            $statement_year = date('Y', strtotime($statement->date));
            $statement_month = date('F', strtotime($statement->date));

            if($statement_year!=$year ||  $statement_month!= $month){
                return false;
            }

            return true;




             

             


             
        });
    }
}
