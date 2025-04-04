<?php

namespace App\Http\Services;

use App\Http\Repositories\ProductRepository;
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
        return $this->productRepository->getAllProducts();
    }

    public function createProduct(User $user, $productData){
        if($user->role !== 'admin' && $user->role !== 'moderator'){
            throw new HttpResponseException(response()->json([
                'message' => 'Permission denied for this action'
            ], 401));
        }

        if(empty($productData)){
            throw new HttpResponseException(response()->json([
                'message' => 'Nothing to store!'
            ], 400));
        }

        return $this->productRepository->createProduct($productData);
    }

    public function showProduct($productId){
        return $this->productRepository->showProduct($productId);
    }

    public function updateProduct(User $user, $productId, $productData){
        if($user->role !== 'admin' && $user->role !== 'moderator'){
            throw new HttpResponseException(response()->json([
                'message' => 'Permission denied for this action'
            ], 401));
        }

        if(empty($productData)){
            throw new HttpResponseException(response()->json([
                'message' => 'Nothing to update!'
            ], 400));
        }

        return $this->productRepository->updateProduct($productId, $productData);
    }

    public function updateStock(User $user, $productId, $productData){
        if($user->role !== 'admin'){
            throw new HttpResponseException(response()->json([
                'message' => 'Permission denied for this action'
            ], 401));
        }

        if(empty($productData)){
            throw new HttpResponseException(response()->json([
                'message' => 'Nothing to update!'
            ], 400));
        }

        return $this->productRepository->updateProduct($productId, $productData);
    }

    public function deleteProduct(User $user, $productId){
        if($user->role !== 'admin'){
            throw new HttpResponseException(response()->json([
                'message' => 'Permission denied for this action'
            ], 401));
        }

        return $this->productRepository->deleteProduct($productId);
    }

    public function getAllProductsByCategory($categoryId){
        return $this->productRepository->getAllProductsByCategory($categoryId);
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
