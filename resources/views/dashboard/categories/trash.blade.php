@extends('layouts.dashboard')

@section('title', 'Trashed Categories')

@section('content')

    <x-flash-message />


    <div class="mb-4">
        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-outline-primary">
            <i class="fas fa-plus"></i>  New</a>
        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-outline-dark">
            Back</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th></th>
                <th>Name</th>
                <th>Deleted At</th>
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
                <td>{{ $category->deleted_at }}</td>
                <td>
                    <form action="{{ route('dashboard.categories.restore', $category->id) }}" method="post">
                        @csrf
                        @method('patch')
                        <button type="submit" class="btn btn-sm btn-outline-success">Restore</button>
                    </form>
                </td>
                <td>
                    <form action="{{ route('dashboard.categories.force-delete', $category->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i> Delete Forever</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection
