<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Services\CategoryService;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    public function __construct(protected CategoryService $categoryService)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->categoryService->getAllCategories();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        $created = $this->categoryService->createCategory(Auth::user(), $validated);

        return response()->json([
            'Message' => 'Category created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $category)
    {
        return response()->json($this->categoryService->showCategory($category), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, int $category)
    {
        $validated = $request->validated();
        
        $updated = $this->categoryService->updateCategory($validated, $category, Auth::user());

        return response()->json([
            'message' => 'Category updated successfully'
        ], 202);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $category)
    {
        $deleted = $this->categoryService->deleteCategory($category, Auth::user());

        return response()->json([
            'message' => 'Category deleted successfully'
        ], 204);
    }
}
