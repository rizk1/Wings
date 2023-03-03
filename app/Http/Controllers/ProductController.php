<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TransactionDetail;
use App\Models\TransactionHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index() {
        $data = DB::table('products')
        ->select('*', DB::Raw('(CASE
            WHEN discount IS NOT NULL
            THEN (price - (price * discount / 100))
            ELSE price END) as total_price'))
        ->get();

        return view('product.listProduct', compact('data'));
    }

    public function detail($id) {
        $data = Product::select('*', DB::Raw('(CASE
            WHEN discount IS NOT NULL
            THEN (price - (price * discount / 100))
            ELSE price END) as total_price'))
        ->findOrFail($id);

        return view('product.detailProduct', compact('data'));
    }

    public function getCartProduct(Request $request) {
        if ($request->id) {
            $total = 0;

            $data = DB::table('products')
            ->select('*', DB::raw('(CASE WHEN discount IS NOT NULL THEN (price - (price * discount / 100)) ELSE price END) as total_price'))
            ->whereIn('id', $request->id)
            ->get();

            foreach ($data as $key => $value) {
                $total += $value->total_price;
            }

            return view('cart.listCart', compact('data', 'total'));
        }
    }

    public function Checkout(Request $request) {
        DB::beginTransaction();

        try {
            $getLast = TransactionHeader::latest()->first();
            $lastNum = $getLast ? $getLast->id : null;
            $total = 0;
            $p = [];

            for ($i=0; $i < count($request->data); $i++) { 
                $product = Product::select('*', DB::raw('(CASE WHEN discount IS NOT NULL THEN (price - (price * discount / 100)) ELSE price END) as total_price'))
                ->where('id', $request->data[$i]['id'])
                ->first();

                array_push($p, $product);

                $total += (float) $product->total_price * (int) $request->data[$i]['qty'];
            }

            $header = new TransactionHeader();
            $header->document_code = 'TRX';
            $header->document_number = $lastNum ? '00'.($lastNum + 1) : '001';
            $header->user = Auth::user()->user;
            $header->total = $total;
            $header->date = date("Y-m-d");
            $header->save();

            for ($i=0; $i < count($p); $i++) { 
                $detail = new TransactionDetail();
                $detail->document_code = $header->document_code;
                $detail->document_number = $header->document_number;
                $detail->product_code = $p[$i]['product_code'];
                $detail->price = (float) $p[$i]['total_price'];
                $detail->quantity = $request->data[$i]['qty'];
                $detail->unit = $p[$i]['unit'];
                $detail->sub_total = (float) $p[$i]['total_price'] * (int) $request->data[$i]['qty'];
                $detail->currency = $p[$i]['currency'];
                $detail->save();
            }
            
            DB::commit();

            return response()->json([
                'status' => 'success',
                'msg' => 'Checkout berhasil dilakukan!'
            ]);

        } catch (\Throwable $th) {
            DB::rollback();

            return response()->json([
                'status' => 'failed',
                'msg' => $th->getMessage()
            ]);
        }
    }

    public function salesReport() {
        $data = TransactionHeader::with(['detail' => function($query) {
                $query->join('products as p', 'transaction_details.product_code', '=', 'p.product_code')->select('transaction_details.*', 'p.product_name');
            }
        ])
        ->get();

        return view('sales.salesReport', compact('data'));
    }

    public function addProduct(Request $request) {
        $playload = [
            'product_code' => $request->product_code,
            'product_name' => $request->product_name,
            'price' => $request->price,
            'currency' => $request->currency,
            'discount' => $request->discount,
            'dimension' => $request->dimension,
            'unit' => $request->unit,
        ];

        $validator = Validator::make($playload, [
            'product_code' => ['required', 'string', 'max:18'],
            'product_name' => ['required', 'string', 'max:30'],
            'price' => ['required', 'number'],
            'currency' => ['required', 'string', 'max:5'],
            'discount' => ['required', 'number'],
            'dimension' => ['required', 'string', 'max:50'],
            'unit' => ['required', 'string', 'max:5'],
        ]);

        if ($validator->fails()) {
            return redirect('/register')->withErrors($validator)->withInput();
        }
    }
}
