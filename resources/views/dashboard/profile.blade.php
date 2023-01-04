@extends('layouts.dashboard')

@section('title', 'Edit Profile')

@section('content')

<x-flash-message />

<form action="{{ route('dashboard.profile') }}" method="post">
    @csrf
    @method('put')

    <div class="row">
        <div class="col-sm-6">
            <x-form.input label="First Name" name="first_name" id="first_name" :value="$user->profile->first_name" />
        </div>
        <div class="col-sm-6">
            <x-form.input label="Last Name" name="last_name" id="last_name" :value="$user->profile->last_name" />
        </div>
        <div class="col-sm-6">
            <x-form.input label="Birthday" type="date" name="birthday" id="birthday" :value="$user->profile->birthday" />
        </div>
        <div class="col-sm-6">
            <x-form.input label="Address" name="address" id="address" :value="$user->profile->address" />
        </div>
        <div class="col-sm-6">
            <x-form.input label="City" name="city" id="city" :value="$user->profile->city" />
        </div>
        <div class="col-sm-6">
            <x-form.select label="Country" name="country_code" id="country_code" :options="$countries" :value="$user->profile->country_code" />
        </div>
        <div class="col-sm-6 mt-5">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>

</form>

@endsection