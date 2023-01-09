@extends('layouts.front')

@section('title', 'Checkout')

@section('breadcrumb')
@parent
<li>Checkout</li>
@endsection

@section('content')
<!--====== Checkout Form Steps Part Start ======-->

<section class="checkout-wrapper section">
    <div class="container">
        <form action="{{ route('checkout') }}" method="post">
            @csrf
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="checkout-steps-form-style-1">
                        <ul id="accordionExample">
                            <li>
                                <h6 class="title" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">Your Personal Details </h6>
                                <section class="checkout-steps-form-content collapse show" id="collapseThree" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="single-form form-default">
                                                <label>User Name</label>
                                                <div class="row">
                                                    <div class="col-md-6 form-input form">
                                                        <x-form.input name="first_name" id="first_name" placeholder="First Name" />
                                                    </div>
                                                    <div class="col-md-6 form-input form">
                                                        <x-form.input name="last_name" id="last_name" placeholder="Last Name" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>Email Address</label>
                                                <div class="form-input form">
                                                    <x-form.input name="email" id="email" type="email" placeholder="Email Address" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>Phone Number</label>
                                                <div class="form-input form">
                                                    <x-form.input name="phone_number" id="phone_number" placeholder="Phone Number" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="single-form form-default">
                                                <label>Mailing Address</label>
                                                <div class="form-input form">
                                                    <x-form.input name="address" id="address" placeholder="Mailing Address" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>City</label>
                                                <div class="form-input form">
                                                    <x-form.input name="city" id="city" placeholder="City" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>Post Code</label>
                                                <div class="form-input form">
                                                    <x-form.input name="postal_code" id="postal_code" placeholder="Post Code" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>Country</label>
                                                <div class="form-input form">
                                                    <x-form.select name="country_code" id="country_code" :options="$countries" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>Region/State</label>
                                                <div class="select-items">
                                                    <x-form.input name="state" id="state" placeholder="Region/State" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="checkout-sidebar">
                        <div class="checkout-sidebar-coupon">
                            <p>Appy Coupon to get discount!</p>
                            <div class="single-form form-default">
                                <div class="form-input form">
                                    <input type="text" placeholder="Coupon Code">
                                </div>
                                <div class="button">
                                    <button class="btn">apply</button>
                                </div>
                            </div>
                        </div>
                        <div class="checkout-sidebar-price-table mt-30">
                            <h5 class="title">Pricing Table</h5>

                            <div class="sub-total-price">
                                @foreach ($cart->get() as $item)
                                <div class="total-price">
                                    <p class="value">{{ $item->product->name }}:</p>
                                    <p class="price">{{ Money::format($item->product->price) }}</p>
                                </div>
                                @endforeach
                            </div>

                            <div class="total-payable">
                                <div class="payable-price">
                                    <p class="value">Subotal Price:</p>
                                    <p class="price">{{ Money::format($cart->total()) }}</p>
                                </div>
                            </div>
                            <div class="price-table-btn button">
                                <button type="submit" class="btn btn-alt">Checkout</button>
                            </div>
                        </div>
                        <div class="checkout-sidebar-banner mt-30">
                            <a href="product-grids.html">
                                <img src="https://via.placeholder.com/400x330" alt="#">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!--====== Checkout Form Steps Part Ends ======-->

@endsection