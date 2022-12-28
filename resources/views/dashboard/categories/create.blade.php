@extends('layouts.dashboard')

@section('title', 'Add Category')

@section('content')

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <form action="{{ route('dashboard.categories.store') }}" method="post" enctype="multipart/form-data">
        @include('dashboard.categories._form')
    </form>
@endsection