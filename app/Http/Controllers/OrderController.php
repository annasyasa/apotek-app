<?php

namespace App\Http\Controllers;

use App\Models\order;
use Illuminate\Http\Request;
use App\Models\Medicine;
use Illuminate\Support\facades\Auth;
use Barryvdh\DomPDF\facade\PDF;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\facades\Excel;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $order = Order::where('created_at', 'LIKE', '%'. $request->search.'%')->with('user')->orderBy('created_at', 'DESC')->simplePaginate(5);
        return view ('order.index', compact('order'));
    }

    /**
     * Show the form for creating a new resource.
     */

     public function indexAdmin()
     {
        $order = Order::with('user')->simplePaginate(10);
        return view("order.recapData", compact("order"));
     }



    public function create()
    {
        //
        $medicines = Medicine::all();
        // dd('tes');
        return view('order.create', compact('medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name_customer' => 'required' ,
            'medicines' => 'required'
        ]);
        $hitungJumalahDuplikat = array_count_values($request->medicines);
        $arrayFormat = [];
        foreach ($hitungJumalahDuplikat as $key => $value) {
            $detailObat = Medicine::find($key);

            if ($detailObat['stock'] < $value) {
                $msg = 'Tidak dapat membeli obat ' . $detailObat['name'] . ' sisa stock ' . $detailObat['stock'];
                return redirect()->back()->withInput()->with('failed', $msg);
            }
            $formatObat = [
                "id" => $key,
                "name_medicine" => $detailObat['name'],
                "price" => $detailObat['price'],
                "qty" => $value,
                "sub_price" => $detailObat['price'] * $value,
            ];
            array_push($arrayFormat, $formatObat);
        }

        $totalHarga = 0;
        foreach ($arrayFormat as $key => $value){
            $totalHarga += $value['sub_price'];

        }

        $priceWithPPN = $totalHarga + ($totalHarga * 0.1);

        $tambahOrder = Order::create([
            'user_id' => Auth::user()->id,
            'medicines' => $arrayFormat,
            'name_customer' => $request->name_customer,
            'total_price' =>$priceWithPPN
        ]);
        if ($tambahOrder) {
            foreach ($arrayFormat as $key => $value){
                $obatSebelumnya= Medicine::find($value['id']);
                Medicine::where('id', $value['id'])->update([
                    'stock' => ($obatSebelumnya['stock'] - $value['qty'])
                ]);
            }
            return redirect()->route('orders.show', $tambahOrder['id']);
        }
        else{
            return redirect()->back()->with('failed', 'gagal membuat pembelian!');

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(order $order, String $id)
    {
        $order=Order::find($id);
        return view('order.print', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(order $order)
    {
        //
    }

    public function download($id){
        $order = Order::find($id)->toArray();
        view ()->share('order', $order);
        $pdf = PDF::loadView('order.download', $order);
        return $pdf ->download('receipt.pdf');  
    }

    public function exportExcel()
    {
        $file_name = 'data_pembelian' . '.xlsx';
        return Excel::download(new OrdersExport, $file_name);
    }
}
