<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Models\Product;
use App\Models\Store;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
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

    public function rent_booking(BookingRequest $request, Product $product) 
    {
        try {
            session()->put('product_id', $product->id);

            // $validator =  Validator::make($request->all(), [
            //     'duration' => ['required', 'integer', 'min:1', 'max:30'],
            //     'store_id' => ['required', 'integer', 'exists:stores,id'],
            //     'started_at' => ['required', 'date', 'after:today'],
            //     'address' =>  ['required', 'string', 'min:8', 'max:300'],
            //     'delivery_type' =>  ['required', 'string', 'in:HOME_DELIVERY,PICKUP'],
            //     'subtotal' => ['required'],
            //     'tax' => ['required'],
            //     'fee' => ['required'],
            //     'total_amount' => ['required'],
            // ]);

            // if ($validator->fails()) {
            //     return redirect()->back()->with('error', $validator->errors());
            // }

            session($request->all());

            return redirect()->route('product.checkout', $product->slug);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses data. '. $e->getMessage());
        }
    }

    public function checkout(Product $product)
    {
        $duration = session('duration');
        $address = session('address');
        $started_at = session('started_at');
        $delivery_type = session('delivery_type');
        $subtotal = session('subtotal');
        $fee = session('fee');
        $tax = session('tax');
        $total_amount = session('total_amount');
        $store_id = session('store_id');
        $title = 'Checkout Now';
        // $booking_data = session()->all();
        // return response()->json(session()->all(),200 );
        // $title = 'Checkout';
        // return view('welcome', compact('title'));
        return view('front.checkout', compact('product', 'title', 'subtotal', 'fee', 'tax', 'total_amount'));
    }
}
