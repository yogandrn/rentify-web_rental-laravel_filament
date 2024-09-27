<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() 
    {
        $categories = Category::get();
        $latest_products = Product::latest()->take(4)->get();
        $random_products = Product::inRandomOrder()->take(6)->get();
        $title = env('APP_NAME');

        return view('front.index', compact('categories', 'latest_products', 'random_products', 'title'));
    }

    public function category(Category $category) 
    {
        session()->put('category_id', $category->id);
        $title = 'Category ' . $category->name;

        return view('front.brands', compact('category', 'title'));
    }

    public function brand(Brand $brand)
    {
        $category_id = session()->get('category_id');

        $title =  $brand->name . ' - Products';
        $products = Product::where('brand_id', $brand->id)
            ->where('category_id', $category_id)
            ->latest()
            ->get();
        
            return view('front.gadgets', compact('products', 'brand', 'title'));
    }
}
