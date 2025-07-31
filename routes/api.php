<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\CountryBrandController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('brands', BrandController::class);

Route::get('countries/{countryCode}/brands', [CountryBrandController::class, 'getBrands']);
Route::post('countries/{countryCode}/brands', [CountryBrandController::class, 'addBrand']);
Route::put('countries/{countryCode}/brands/{brandId}', [CountryBrandController::class, 'updatePosition']);
Route::delete('countries/{countryCode}/brands/{brandId}', [CountryBrandController::class, 'removeBrand']);

Route::get('current-country/brands', [CountryBrandController::class, 'getCurrentCountryBrands']);
