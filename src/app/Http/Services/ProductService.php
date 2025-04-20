<?php

namespace App\Http\Services;

use App\Http\Repositories\ProductRepository;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ProductService{
    public function __construct(protected ProductRepository $productRepository)
    {
    }

    public function getAllProducts(){
        $products = $this->productRepository->getAllProducts();
        return ProductResource::collection($products);
    }

    public function createProduct($productData){

        if(empty($productData)){
            throw new HttpResponseException(response()->json([
                'message' => 'Nothing to store!'
            ], 400));
        }

        return $this->productRepository->createProduct($productData);
    }

    public function showProduct($productId){
        $product = $this->productRepository->showProduct($productId);
        return new ProductResource($product);
    }

    public function updateProduct($productId, $productData){
        if(empty($productData)){
            throw new HttpResponseException(response()->json([
                'message' => 'Nothing to update!'
            ], 400));
        }

        return $this->productRepository->updateProduct($productId, $productData);
    }

    public function updateStock($productId, $productData){
        if(empty($productData)){
            throw new HttpResponseException(response()->json([
                'message' => 'Nothing to update!'
            ], 400));
        }

        return $this->productRepository->updateProduct($productId, $productData);
    }

    public function deleteProduct( $productId){
        return $this->productRepository->deleteProduct($productId);
    }

    public function getAllProductsByCategory($categoryId){
        $products = $this->productRepository->getAllProductsByCategory($categoryId);
        return ProductResource::collection($products);
    }

    public function updateImage($productId, $image){
        $product = $this->productRepository->showProduct($productId);
        $imageNome = Str::uuid() . '.' . $image->getClientOriginalExtension();


        if($product->image_path){
            Storage::delete($product->image_path);
        }

        $path = Storage::putFileAs('public/products', $image, $imageNome);

        return $this->productRepository->updateProduct($productId, ['image_path' => $path]);
    }

    public function showImage($productId){
        $product = $this->productRepository->showProduct($productId);

        if(!$product->image_path){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Image not found',
                ], 404)
            );
        }

        if(!Storage::exists($product->image_path)){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Image not found',
                ], 404)
            );
        }

        $file = Storage::get($product->image_path);
        $mime = Storage::mimeType($product->image_path);

        return response()->make($file, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline',
        ]);

    }
}
