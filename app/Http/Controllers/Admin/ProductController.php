<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function fetchProductData(Request $request)
    {
        $input = $request->input('input');
        
        // Retrieve the product data based on the input (code or name)
        $product = Product::where('code', $input)
            ->orWhere('name', $input)
            ->first();
        
        // Return the product data as JSON
        return response()->json([
            'productCode' => $product->code,
            'productName' => $product->name,
            // ...include other product fields as needed
        ]);
    }
}
