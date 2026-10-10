<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['products' => function ($query) {
            $query->where('is_active', true);
        }])->get();

        $featuredProducts = Product::with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->take(4)
            ->get();

        // Hero product card takes the first featured product (or first active product)
        $heroProduct = $featuredProducts->first() ?? Product::with('category')->where('is_active', true)->first();

        return view('home', compact('categories', 'featuredProducts', 'heroProduct'));
    }
}
