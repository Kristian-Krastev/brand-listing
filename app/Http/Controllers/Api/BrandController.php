<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return response()->json($brands);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'brand_name'  => 'required|string|max:255',
                'brand_image' => 'required|string|max:255',
                'rating'      => 'required|integer|min:1|max:10',
            ]);

            $brand = Brand::create($validated);

            return response()->json($brand, Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create brand'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(string $id)
    {
        try {
            $brand = Brand::findOrFail($id);
            return response()->json($brand);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Brand not found'], Response::HTTP_NOT_FOUND);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $brand = Brand::findOrFail($id);

            $validated = $request->validate([
                'brand_name'  => 'sometimes|required|string|max:255',
                'brand_image' => 'sometimes|required|string|max:255',
                'rating'      => 'sometimes|required|integer|min:1|max:10',
            ]);

            $brand->update($validated);

            return response()->json($brand);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Brand not found or failed to update'], Response::HTTP_NOT_FOUND);
        }
    }

    public function destroy(string $id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $brand->delete();

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Brand not found'], Response::HTTP_NOT_FOUND);
        }
    }
}
