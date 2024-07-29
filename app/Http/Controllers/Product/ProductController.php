<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\ProductListResource;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');

        $query = Product::query()
            ->where('title', 'like', "%{$search}%")
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);

        return ProductListResource::collection($query);
    }


//----------------------------------------------------------------------------------------------------------------------------------------

    public function store(ProductRequest $request)
    {
        try {

        $data = $request->validated();
        $data['created_by'] = auth()->user()->id;
        $data['updated_by'] = auth()->user()->id;

        $image = $data['image'] ?? null;
        if($image){
            $relativePath  = $this->saveImage($image);
            $data['image'] = URL::to(Storage::url($relativePath));
        }
        $product = Product::create($data);

        return response()->json([
                'status' => true,
                'message' => 'Product created successfully',
            ], 201);
        }
        catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function saveImage(UploadedFile $image){
        $path = 'images/' . Str::random();
            if (!Storage::exists($path)) {
                Storage::makeDirectory($path, 0755, true);
            }
            if (!Storage::putFileAs('public/' . $path, $image, $image->getClientOriginalName())) {
                throw new \Exception("Unable to save file \"{$image->getClientOriginalName()}\"");
            }
            return $path . '/' . $image->getClientOriginalName();
    }
//----------------------------------------------------------------------------------------------------------------------------------------


    public function show(Product $product)
    {
        return new ProductResource($product);
    }

//----------------------------------------------------------------------------------------------------------------------------------------

    public function update(ProductRequest $request, Product $product)
    {
        try {

        $data = $request->validated();
        $data['updated_by'] = auth()->user()->id;

        $newImage = $request->file('image');

        // Save the new image if provided
        if ($newImage) {
            $relativePath = $this->saveImage($newImage);
            $data['image'] = URL::to(Storage::url($relativePath));

            // Delete old image and possibly empty directory
            $this->deleteOldImage($product->image);
        } else {
            // If no image provided, delete the existing image
            $this->deleteOldImage($product->image);
            $data['image'] = null; // Clear the image field
        }

        $product->update($data);

        return response()->json([
                'status' => true,
                'message' => 'Product Updated successfully',
                '$product->image' => $product->image
            ], 200);

        }
        catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    private function deleteOldImage($imageUrl)
{
    if ($imageUrl) {
        // Extract the relative path from the URL
        $relativePath = str_replace('/storage', '', parse_url($imageUrl, PHP_URL_PATH));

        // Delete the file
        Storage::disk('public')->delete($relativePath);

        // Extract the directory path
        $directoryPath = dirname($relativePath);

        // Check if directory is empty and delete it if so
        if (count(Storage::disk('public')->files($directoryPath)) === 0) {
            Storage::disk('public')->deleteDirectory($directoryPath);
        }
    }
}

//----------------------------------------------------------------------------------------------------------------------------------------

    public function destroy(Product $product)
    {
        $this->deleteOldImage($product->image);

        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product Deleted Successfully',
        ], 204);
    }

}
