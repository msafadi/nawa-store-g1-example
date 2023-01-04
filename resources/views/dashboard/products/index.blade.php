@extends('layouts.dashboard')

@section('title', 'Products')

@section('content')

    <x-flash-message />

    <div class="mb-4">
        <a href="{{ route('dashboard.products.create') }}" class="btn btn-outline-primary">
            <i class="fas fa-plus"></i>  New</a>
        {{-- <a href="{{ route('dashboard.products.trash') }}" class="btn btn-outline-dark">
            <i class="fas fa-trash"></i>  Trash</a> --}}
    </div>

    <form action="{{ route('dashboard.products.index') }}" method="get" class="row mb-4">
        <div class="col-5">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control">
        </div>
        <div class="col-1">
            <button type="submit" class="btn btn-dark">Search</button>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th></th>
                <th>Name</th>
                <th>Category</th>
                <th>Created At</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>
                    <img src="{{ $product->image_url }}" width="60" alt="">
                </td>
                <td><strong>{{ $product->name }}</strong>
                <br><span class="text-muted">{{ $product->slug }}</span></td>
                <td>{{ $product->category->name }}</td>
                <td>{{ $product->created_at }}</td>
                <td>
                    <a href="{{ route('dashboard.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                </td>
                <td>
                    <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i> Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection
