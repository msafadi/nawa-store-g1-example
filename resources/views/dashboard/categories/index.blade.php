@extends('layouts.dashboard')

@section('title', 'Categories')

@section('content')

    <x-flash-message />

    <x-alert type="info">
        Info message!
    </x-alert>

    <div class="mb-4">
        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-outline-primary">
            <i class="fas fa-plus"></i>  New</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th></th>
                <th>Name</th>
                <th>Parent</th>
                <th>Created At</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>
                    <img src="{{ $category->image_url }}" width="60" alt="">
                </td>
                <td><strong>{{ $category->name }}</strong>
                <br><span class="text-muted">{{ $category->slug }}</span></td>
                <td>{{ $category->parent_name }}</td>
                <td>{{ $category->created_at }}</td>
                <td>
                    <a href="{{ route('dashboard.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                </td>
                <td>
                    <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="post">
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
