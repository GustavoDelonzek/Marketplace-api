<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UpdateStockProductRequest;
use App\Http\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->productService->getAllProducts();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $created = $this->productService->createProduct(Auth::user(), $validated);

        return response()->json([
            'Message' => 'Product created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $product)
    {
        return response()->json($this->productService->showProduct($product));
    }

    public function indexByCategory(string $category)
    {
        return response()->json($this->productService->getAllProductsByCategory($category));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $product)
    {
        $validated = $request->validated();

        $updated = $this->productService->updateProduct(Auth::user(), $product, $validated);

        return response()->json([
            'message' => 'updated successfully'
        ], 200);
    }

    public function updateStock(UpdateStockProductRequest $request, string $product)
    {
        $validated = $request->validated();

        $updated = $this->productService->updateStock(Auth::user(), $product, $validated);

        return response()->json([
            'message' => 'Stock updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $product)
    {
        $deleted = $this->productService->deleteProduct(Auth::user(), $product);

        return response()->json([
            'message' => 'deleted successfully'
        ], 200);
    }
}
