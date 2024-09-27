<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
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

    public function detail(Product $product)  
    {
        $title = 'Detail Product';

        return view('front.detail', compact('title', 'product'));
    }

    public function booking(Product $product)
    {
        $stores = Store::get();
        $title = 'Booking Product';
        
        return view('front.booking', compact('stores', 'title', 'product'));
    }

    public function booking_save(Request $request, Product $product) 
    {
        try {
            // $booking_data = $request->only(['duration', 'started_at', 'store_id', 'delivery_type', 'address']);
            $validator =  Validator::make($request->all(), [
                'duration' => ['required', 'integer', 'min:1', 'max:30'],
                'store_id' => ['required', 'integer'],
                'started_at' => ['required', 'date', 'after:today'],
                'address' =>  ['required', 'string', 'min:8', 'max:300'],
                // 'aezakmi' => ["required", 'string'],
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors());
            }

            session($request->only(['duration', 'started_at', 'store_id', 'delivery_type', 'address']));
            
            // return dd($booking_data);
    
            // return redirect('/checkout/'. $product->slug .'/payment');
    
            // return redirect()->back()->with('success', $booking_data);

            // return redirect()->intended('/checkout/'. $product->slug .'/payment');
            return redirect()->route('front.checkout.product', $product->slug);
            // return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses data. '. $request->all());
        } catch (Exception $e) {
            Log::error('Error on rent_booking : '. $e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses data. '. $e->getMessage());
        }
    }

    public function checkout(Product $product)
    {
        $duration = session('duration');
        $address = session('address');
        // return response()->json([$address, $duration], 200);
        $title = 'Checkout';
        return view('welcome', compact('title'));
    }
}
