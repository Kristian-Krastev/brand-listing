<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class CountryBrandController extends Controller
{
    public function getBrands(string $countryCode)
    {
        try {
            $country = Country::where('country_code', $countryCode)->firstOrFail();
            $brands = $country->brands()->orderBy('position')->get();

            return response()->json($brands);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Country not found'], Response::HTTP_NOT_FOUND);
        }
    }

    public function getCurrentCountryBrands(Request $request)
    {
        $countryCode = $request->header('CF-IPCountry');

        if (!$countryCode || strlen($countryCode) !== 2) {
            // Use default country if header is missing or invalid
            $country = Country::where('is_default', true)->first();

            if (!$country) {
                return response()->json(['error' => 'No default country configured'], Response::HTTP_NOT_FOUND);
            }
        } else {
            $country = Country::where('country_code', $countryCode)->first();

            if (!$country) {
                $country = Country::where('is_default', true)->first();

                if (!$country) {
                    return response()->json(['error' => 'Country not found and no default country configured'],
                        Response::HTTP_NOT_FOUND);
                }
            }
        }

        $brands = $country->brands()->orderBy('position')->get();

        return response()->json([
            'country' => $country,
            'brands'  => $brands,
        ]);
    }

    public function addBrand(Request $request, string $countryCode)
    {
        try {
            $validated = $request->validate([
                'brand_id' => 'required|exists:brands,id',
                'position' => 'sometimes|integer|min:0',
            ]);

            $country = Country::where('country_code', $countryCode)->firstOrFail();
            $brand = Brand::findOrFail($validated['brand_id']);

            if ($country->brands()->where('brand_id', $brand->id)->exists()) {
                return response()->json(['error' => 'Brand already in country list'], Response::HTTP_CONFLICT);
            }

            $position = $validated['position'] ?? $country->brands()->count();
            $country->brands()->attach($brand->id, ['position' => $position]);

            return response()->json(['message' => 'Brand added to country list'], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add brand to country list'],
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updatePosition(Request $request, string $countryCode, string $brandId)
    {
        try {
            $validated = $request->validate([
                'position' => 'required|integer|min:0',
            ]);

            $country = Country::where('country_code', $countryCode)->firstOrFail();
            $brand = Brand::findOrFail($brandId);

            if (!$country->brands()->where('brand_id', $brand->id)->exists()) {
                return response()->json(['error' => 'Brand not in country list'], Response::HTTP_NOT_FOUND);
            }

            $country->brands()->updateExistingPivot($brand->id, ['position' => $validated['position']]);

            return response()->json(['message' => 'Brand position updated']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update brand position'],
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function removeBrand(string $countryCode, string $brandId)
    {
        try {
            $country = Country::where('country_code', $countryCode)->firstOrFail();
            $brand = Brand::findOrFail($brandId);

            if (!$country->brands()->where('brand_id', $brand->id)->exists()) {
                return response()->json(['error' => 'Brand not in country list'], Response::HTTP_NOT_FOUND);
            }

            $country->brands()->detach($brand->id);

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to remove brand from country list'],
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
