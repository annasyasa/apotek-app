@extends('templates.app', ['title' =>'Login'])

@section('content-dinamis')

@if (Session::get('success'))
   <div class="alert-success">{{ Session::get('success') }}</div>
@endif
<form action="{{route('login.auth')}}" method="POST" class="card w-75 d-block mx-auto my-3">
    @csrf
    @if (Session::get('failed'))
      <div class="alert alert-danger">{{Session::get('failed')}}</div>
    @endif
 <div class="card-body">
    <h3 class="card-title text-center">LOGIN</h3>
    <div class="form-group">
        <label for="email" class="form-label">Email :</label>
        <input type="email" name="email" id="email" class="form-control">
        @error('email')
          <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="password" class="form-label">Password :</label>
        <input type="password" name="password" id="password" class="form-control">
        @error('password')
          <span class="taxt-danger">{{ $message }}</span>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">LOGIN</button>
 </div>
</form>
@endsection
