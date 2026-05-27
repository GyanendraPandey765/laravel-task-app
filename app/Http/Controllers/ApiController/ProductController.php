<?php

namespace App\Http\Controllers\ApiController;

use Illuminate\Http\Request;
use App\Models\Products;

class ProductController
{
    //
    public function create(Request $request){
    //    echo 1; die;\\

    try {
        //code...
       $validated = $request->validate([
            'name'  => 'required|min:3',
            'price' => 'nullable|numeric|gt:0',
            'stock' => 'numeric|gt:0',
        ]);

        $validated['description'] = $request->description;

        // echo 1; die;
        // Save to database
        $product = Products::create($validated);

        // Return JSON response
        return response()->json([
            'message' => 'Product created successfully',
            'data'    => $product
        ], 201);
    } catch (\Throwable $th) {
        //throw $th;
    }
    }

    public function listProducts() {
        // echo 1; die;
        $products = Products::where('is_active', 1)->get();
        return response()->json([
            'data' => $products,
                'message' => 'Product found successfully',
                
            ], 201);
    }


    public function detail($id) {
        // echo $id; die;
        $products = Products::where('id', $id)->first();
        return response()->json([
            'data' => $products,
                'message' => 'Product found successfully',
                
            ], 201);
    }


   public function update(Request $request, $id)
{
    try {

        $validated = $request->validate([
            'name'  => 'required|min:3',
            'price' => 'nullable|numeric|gt:0',
            'stock' => 'nullable|numeric|gt:0',
        ]);

        $validated['description'] = $request->description;

        // Find product
        $product = Products::findOrFail($id);

        // Update product
        $product->update($validated);

        return response()->json([
            'message' => 'Product updated successfully',
            'data'    => $product
        ], 200);

    } catch (\Throwable $th) {

        return response()->json([
            'message' => 'Something went wrong',
            'error' => $th->getMessage()
        ], 500);
    }
}

    public function delete($id){
    
       Products::where('id', $id)->update(['is_deleted' => 1]);
        return response()->json([
            'message' => 'Product deleted successfully',
        ], 201);
    }
}
