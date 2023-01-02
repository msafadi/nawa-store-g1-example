@extends('layouts.dashboard')

@section('title', 'Add Product')

@section('content')
    
    <form action="{{ route('dashboard.products.store') }}" method="post" enctype="multipart/form-data">
        @include('dashboard.products._form')
    </form>
@endsection