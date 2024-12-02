<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //Request $request : mengambil data dari form yg di kirim ke action terhubung dengan func ini
    public function index(Request $request)
    {
        //mengambil data medicines
        //mengambil semua data :NamaModel = ::all()
        //nama model seusai dengan apa yang mau di tampilkan
        //simplepaginate(); membuat pagination dengan jumalh 5 data
        //where() : ('nama_field_migration, 'operator', 'value')
        //operator -> =, !=, <, >, <=, >=, LIKE
        // % di depan :mencari kata di belakang
        // % di belakang : mencari kata di depan
        // %  di depan belakang : mencari kata di depan belakang
        $medicines = Medicine::where('name','LIKE','%'.$request->search_obat.'%')
        ->orderBy('name', 'ASC',)->simplePaginate(5);
        //compact = mengirim data ke blade : compact ('nama variable')
        return view('medicine.index',compact('medicines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('medicine.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'name' => 'required|min:5|max:15' ,
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ], [
            'type.required' => 'Tipe obat harus diisi',
            'name.required' => 'Nama obat harus diisi',
            'price.required' => 'Harga harus diisi',
            'stock.required' => 'Stok harus diisi',
            'stock.numeric' => 'Stok harus berupa angka',
            'price.numeric' => 'Harga harus berupa angka',
            'name.min' => ' Nama Minimal 5 karakter',
            'name.max' => 'Nama Maksimal 15 karakter',
        ]);

        $proses = Medicine::create([
           'type' => $request -> type,
           'name' => $request -> name,
           'price' => $request -> price,
           'stock' => $request -> stock,
        ]);

        if ($proses) {
            return redirect()->route('medicines')->with('success', 'Data obat Berhasil Ditambahkan');
        }else {
            return redirect()->route('medicines.add')->with('failed', 'Gagal menambahkan data obat');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $medicine = Medicine::where('id', $id)->first();
        return view('medicine.edit', compact('medicine'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'type' => 'required',
            'name' => 'required|min:5|max:15',
            'price' => 'required|numeric',
            'stock' => 'required',
        ], [
            'type.required' => 'Jenis Obat wajib diisi',
            'name.required' => 'Nama obat wajib diisi',
            'nama.min' => 'Nama obat minimal 5 karakter',
            'nama.max' => 'Nama obat maksimal 15 karakter',
            'price.required' => 'Harga obat wajib diisi',
            'price.required' => 'harga obat harus berupa angka',
            'stock.required' => 'stok obat wajib diisi',
        ]);

        $medicineBefore = Medicine::where('id', $id)->first();
        if ((int)$request->stock < (int) $medicineBefore->stock){
            return redirect()->back()->with('failed', 'stock baru tidak boleh kurang dari stock sebelumnya!');
        }
        // kalau stok >= dari sebelumnya, data yang di update
        $proses = $medicineBefore->update([
            'type' => $request->type,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);
        if ($proses) {
            return redirect()->route('medicines')->with('success', 'Data obat berhasil di ubah!');
        } else {
            return redirect()->route('medicines.edit', );
        }
    }

        public function stockEdit(Request $request, $id)
    {
        if(!isset($request->stock)) {
            return response()->json(['failed'=>'Stok tidak boleh kosong'], 400);
        }
        $medicine = Medicine::findOrFail($id);
        if ($request->stock < $medicine['stock']){
            return response()->json(['failed'=>'Stok tidak boleh kurang'], 400);
        }
        $medicine->update(['stock' =>$request->stock]);

        return response()->json(['success'=>'Data stok berhasil di ubah'], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proses = Medicine::where('id',$id)->delete();
        if ($proses) {
            return redirect()->route('medicines')->with('success', 'Data obat Berhasil Dihapus');
        }else {
            return redirect()->route('medicines')->with('failed', 'Gagal menghapus data obat');
        }
    }
}