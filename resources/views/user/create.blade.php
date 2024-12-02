@extends('templates.app', ['title' => 'Akun || APOTEK'])

@section('content-dinamis')
  <div class="m-auto" style="width: 65%">
    <form class="p-4 mt-2" style="border: 1px solid black" action="{{route('users.add.store')}}" method="POST">
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
            <div class="form-group">
                <label for="name" class="form-label">Nama</label>
                {{-- old: mengambil isi input sebelum submit --}}
                <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}">
            </div>
            <label for="email" class="form-label">Email</label>
            {{-- old: mengambil isi input sebelum submit --}}
            <input type="text" name="email" id="email" class="form-control" value="{{old('email')}}">
        </div>
        <div class="form-group">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-select">
                <option hidden selected disabled>Pilih</option>
                <option value="Admin" {{old('role')=='Admin'?'selected': ''}}>Admin</option>
                <option value="Kasir" {{old('role')=='Kasir'?'selected': ''}}>Kasir</option>
            </select>
        </div>
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input type="text" name="password" id="password" class="form-control" value="{{ old('password') }}">
        </div>
        <button type="submit" class="btn btn-success mt-3">Kirim Data</button>
    </form>
</div>
@endsection
