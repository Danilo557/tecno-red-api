<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\ChargeController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StatementController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\api\NumeroALetrasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['auth:api']], function () {
    Route::apiResource("clients", ClientController::class)->names("clients");
    Route::apiResource("statements", StatementController::class)->names("statements");
    Route::apiResource("stores", StoreController::class)->names("stores");
    Route::apiResource("invoices", InvoiceController::class)->names("invoices");
    Route::apiResource("products", ProductController::class)->names("products");
    Route::apiResource("charges", ChargeController::class)->names("charges");
    Route::apiResource("payments", PaymentController::class)->names("payments");
    Route::apiResource("files", FileController::class)->names("files");
    Route::apiResource("brands", BrandController::class)->names("brands");
    
    
    Route::delete('/delete/invoices/{invoice}/products/{product}', [InvoiceController::class, "delete_invoices_products"])->name("delete.invoices.products");
    
    Route::post('/add/invoices/products', [InvoiceController::class, "add_invoices_products"])->name("add.invoices.products");
    Route::put('/edit/invoices/products', [InvoiceController::class, "edit_invoices_products"])->name("edit.invoices.products");
    
    
    Route::get("number_to_letter/{number}", [NumeroALetrasController::class, "toMoney"])->name("toMoney");
    Route::post("number_to_letter_array", [NumeroALetrasController::class, "toMoneyArray"])->name("toMoneyArray");
 
});





 