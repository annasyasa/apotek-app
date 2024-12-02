<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //menampilkan banyak data atau halaman awal fitur
    public function index()
    {
        // view() : memanggil file blade di folder resources/views
        //tanda . digunakan untuk sub folder
        //gunakan kebab case
        return view('landing-page');
    }

    /**
     * Show the form for creating a new resource.
     */

    //menambahkan formulir tambah data atau membuat data baru
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    //untuk menyimpan data
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    //untuk menampilkan hanya satu data
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    //menampilkan formulir edit
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    //mengubah data di database
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

    //menghapus data di database
    public function destroy(string $id)
    {
        //
    }
}
