@extends('templates.app',  ['title' => 'Landing || APOTEK'])
{{-- extend adalah untuk memanggil file blade biasanya template --}}

@section('content-dinamis')
@if(Session::get('failed'))
<div class="alert alert-success">{{Session::get('failed')}}</div>
@endif
{{-- section adalah untuk mengisi html ke yield yang ada di file extend --}}
    <h1 class="mt-3">selamat datang, {{ Auth::user()->name}}</h1>
@endsection