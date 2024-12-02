@extends('templates.app', ['title'=> 'Edit Obat || APOTEK'])

@section('content-dinamis')
{{-- action route mengirim $item['id'] untuk spesifikasi data di route path{id} --}}
@if (Session::get('failed'))
   <div class="alert alert-danger">{{Session::get('failed')}}</div>
@endif
<form action="{{route('medicines.edit.update', $medicine['id'])}}" method="POST">
    @csrf
    {{-- pacth : http method route utuk mengubah data --}}
    @method('PATCH')
    <div class="d-flex">
        <label for="name" class="form-label">Nama Obat</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $medicine['name']}}">
    </div>

   @error('name')
      <small class="text-danger">{{$message}}</small>>
   @enderror
<div class="d-flex">
    <label for="type" class="form-label">Tipe Obat</label>
    <select name="type" id="type" class="form-select">
        <option value="table" {{$medicine['type'] == 'table' ? 'selected' : ''}}>Tablet</option>
        <option value="sirup" {{$medicine['type'] == 'sirup' ? 'selected' : ''}}>Sirup</option>
        <option value="kapsul" {{$medicine['type'] == 'kapsul' ? 'selected' : ''}}>Kapsul</option>
    </select>
</div>
   @error('type')
       <small class="text-danger">{{$message}}</small>>
   @enderror
<div class="d-flex">
    <label for="price" class="form-label">Harga Obat</label>
    <input type="number" name="price" id="price" class="form-control" value="{{ $medicine['price'] }}">
    @error('price')
        <small class="text-danger"> {{ $message }} </small>
    @enderror
</div>
<div class="d-flex">
    <label for="stock" class="form-label">Stok Obat</label>
    <input type="number" name="stock" id="stock" class="form-control" value="{{ $medicine['stock'] }}">
    @error('stock')
        <small class="text-danger"> {{ $message }} </small>
    @enderror
</div>
<button type="submit" class="btn btn-success mt-3">Kirim Data</button>
</form>
</div>
</form>
@endsection
