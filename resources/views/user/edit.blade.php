@extends('templates.app', ['title'=> 'Edit Akun || APOTEK'])

@section('content-dinamis')
{{-- action route mengirim $item['id'] untuk spesifikasi data di route path{id} --}}
<div class="m-auto" style="width: 65%">
   <form class="p-4 mt-2" style="border: 1px solid black"  action="{{route('users.edit.update', $users['id'])}}" method="POST">
@if (Session::get('failed'))
   <div class="alert alert-danger">{{Session::get('failed')}}</div>
@endif
{{-- <form action="{{route('users.edit.update', $users['id'])}}" method="POST"> --}}
    @csrf
    {{-- pacth : http method route utuk mengubah data --}}
    @method('PATCH')
    <div class="d-flex">
        <label for="name" class="form-label">Nama</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $users['name']}}">
    </div>
   @error('name')
      <small class="text-danger">{{$message}}</small>>
   @enderror
   <div class="d-flex">
   <label for="email" class="form-label">Email</label>
            {{-- old: mengambil isi input sebelum submit --}}
            <input type="text" name="email" id="email" class="form-control" value="{{ $users['email']}}">
        </div>
        @error('email')
        <small class="text-danger">{{$message}}</small>>
     @enderror
     <div class="d-flex">
    <label for="role" class="form-label">Role</label>
    <select name="role" id="role" class="form-select">
        <option hidden selected disabled>Pilih</option>
        <option value="Admin" {{$users['role']=='Admin'?'selected': ''}}>Admin</option>
        <option value="Kasir" {{$users['role']=='Kasir'?'selected': ''}}>Kasir</option>
    </select>
</div>
   @error('role')
       <small class="text-danger">{{$message}}</small>>
   @enderror

<div class="d-flex">
    <label for="password" class="form-label">Password</label>
    <input type="text" name="password" id="password" class="form-control" >
</div>
    @error('password')
        <small class="text-danger"> {{ $message }} </small>
    @enderror
</div>
<button type="submit" class="btn btn-success mt-3">Kirim Data</button>
</form>
</div>
</form>
@endsection
