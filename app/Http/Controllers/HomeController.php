<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Country;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $countryCode = $request->header('CF-IPCountry');

        if (!$countryCode || strlen($countryCode) !== 2) {
            $country = Country::where('is_default', true)->first();

            if (!$country) {
                $brands = Brand::orderBy('rating', 'desc')->get();
                return view('home', ['brands' => $brands, 'country' => null]);
            }
        } else {
            $country = Country::where('country_code', $countryCode)->first();

            if (!$country) {
                $country = Country::where('is_default', true)->first();

                if (!$country) {
                    $brands = Brand::orderBy('rating', 'desc')->get();
                    return view('home', ['brands' => $brands, 'country' => null]);
                }
            }
        }

        $brands = $country->brands()->orderBy('position')->get();

        return view('home', [
            'brands'  => $brands,
            'country' => $country,
        ]);
    }
}
