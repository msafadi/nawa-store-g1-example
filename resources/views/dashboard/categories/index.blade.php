@extends('layouts.dashboard')

@section('title', 'Categories')

@section('content')

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Parent</th>
            <th>Created At</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->parent_id }}</td>
            <td>{{ $category->created_at }}</td>
            <td></td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
