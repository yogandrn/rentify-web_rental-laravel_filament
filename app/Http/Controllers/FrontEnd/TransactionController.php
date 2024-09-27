<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Store;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function index() 
    {
        $title = 'Transactions';
        return view('front.transaction', compact('title'));
    }

    public function checkout_order(Request $request) 
    {
        try {
            // validate data
            $validator = Validator::make($request->all(), [
                'fullname' => ['required', 'string', 'min:4', 'max:255'],
                'phone_number' => ['required', 'string', 'min:10', 'max:15'],
                'proof' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:1024'],
            ]);

            if ($validator->fails())
            {
                return redirect()->back()->with('error', $validator->errors());
            }

            $booking_data = session()->only(['duration', 'address', 'started_at', 'delivery_type', 'subtotal', 'tax', 'fee', 'total_amount', 'store_id', 'product_id']);
            
            $product = Product::find(session('product_id'));
            if (!$product) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat melakukan sea pada produk tersebut!');
            }

            DB::beginTransaction();
            
            // assign all required data
            $booking_data['fullname'] = $request->fullname;
            $booking_data['phone_number'] = $request->phone_number;
            $booking_data["duration"] = intval(session('duration'));
            $booking_data["started_at"] = Carbon::parse(session('started_at'));
            $booking_data["ended_at"] = $booking_data["started_at"]->copy()->addDays($booking_data["duration"]);
            $booking_data["subtotal"] = intval(session('subtotal'));
            $booking_data["fee"] = intval(session('fee'));
            $booking_data["tax"] = intval(session('tax'));
            $booking_data["total_amount"] = intval(session('total_amount'));
            $booking_data["store_id"] = intval(session('store_id'));
            $booking_data["code"] = Transaction::generateUniqueCode();

            // store file payment proof
            if ($request->hasFile('proof')) {
                $proof_file_path = $request->file('proof')->store('uploads/transactions', 'public');
                $booking_data['proof'] = $proof_file_path;
            }

            // create transaction
            $transaction = Transaction::create($booking_data);

            DB::commit();
            return redirect()->route('transaction.booking.success', $transaction->code);

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat melakukan checkout : '. $e->getMessage());
        } 
    }

    public function success_booking(Transaction $transaction) 
    {
        $title = 'Booking Success';
        return view('front.success-booking', compact('transaction', 'title'));   
    }

    public function transaction_detail(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => ['required', 'string', 'min:10', 'max:15'],
            'code' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors());
        }

        // find transaction
        $transaction = Transaction::where('code', $request->code)
                                    ->where('phone_number', $request->phone_number)
                                    ->with(['store:id,name,address,thumbnail'])
                                    ->first();
        // jika tidak ada data
        if (!$transaction) {
            
            return redirect()->back()->with('error', 'Data transaksi tidak ditemukan');   
        }

        $title = $transaction->code. ' - Booking Detail';

        return view('front.transaction-detail', compact('title', 'transaction'));

    }
}
