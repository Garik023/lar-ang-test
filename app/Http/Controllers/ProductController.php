<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function list()
    {
        return response()->json(Product::query()->orderByDesc('id')->get());
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        return response()->json(Product::query()->findOrFail($id));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => ['required', 'string'],
            'price' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            Product::query()->create($request->only('name', 'price'));

            return response()->json(['message' => 'success']);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), [
            'name' => ['required', 'string'],
            'price' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            Product::query()->findOrFail($id)->update($request->only('name', 'price'));

            return response()->json(['message' => 'success']);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        try {
            Product::query()->findOrFail($id)->delete();

            return response()->json(['message' => 'success']);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
