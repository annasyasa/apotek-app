@extends('templates.app', ['title' => 'Tambah Obat || APOTEK'])

@section('content-dinamis')
  <div class="m-auto" style="width: 65%">
    <form class="p-4 mt-2" style="border: 1px solid black" action="{{route('medicines.add.store')}}" method="POST">
        {{-- memunculkan text dari with('failed') --}}
        @if (Session::get('failed'))
            <div class="alert alert-danger">{{Session::get('failed')}}
            </div>
        @endif
        {{-- munculin error dari $request->validate --}}
        @if ($errors->any())
         <div class="alert alert-danger">
            <ol>
                @foreach ($errors->all() as $error)
                  <li>{{$error}}</li>
                @endforeach
            </ol>
         </div>
        @endif
        {{-- aturan form menambahkan/mengubah/mengapus :
        1 method POST
        2 namenya diambil dai nama field di migration
        3 harus ada @csrf dibawah form> : headers token mengirim data POST
        4 form search, action halaman return view, form selain itu isi action hrs berbeda dgn return view
        (bukan ke route yg return view halaman create) --}}
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">Nama Obat</label>
            {{-- old: mengambil isi input sebelum submit --}}
            <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}">
        </div>
        <div class="form-group">
            <label for="name" class="form-label">Tipe Obat</label>
            <select name="type" id="type" class="form-select">
                <option hidden selected disabled>Pilih</option>
                <option value="table" {{old('type')=='table'?'selected': ''}}>Tablet</option>
                <option value="sirup" {{old('type')=='sirup'?'selected': ''}}>Sirup</option>
                <option value="kapsul" {{old('type')=='kapsul'?'selected': ''}}>Kapsul</option>
            </select>
        </div>
        <div class="form-group">
            <label for="price" class="form-label">Harga Obat</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}">
        </div>
        <div class="form-group">
            <label for="stock" class="form-label">Stok Obat</label>
            <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock') }}">
        </div>
        <button type="submit" class="btn btn-success mt-3">Kirim Data</button>
    </form>
</div>
@endsection
