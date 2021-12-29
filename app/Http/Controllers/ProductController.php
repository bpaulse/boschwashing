<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
	public function getProductServicesList() {
		// Auth::user();
		$user_id = 1;
		$products = Product::where('user_id', $user_id)->get();

		return response()->json(['products' => $products]);

	}
}
