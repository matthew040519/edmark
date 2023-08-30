@extends('layout.layout')
@section('content')
<div class="page">
      <!-- Navbar -->
      @include('layout.header')
      <style type="text/css">
        .flex-1{
          display: none;
        }
      </style>
      <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  Overview
                </div>
                <h2 class="page-title">
                  Order Products
                </h2>
              </div>
              <div class="col-auto ms-auto d-print-none">
                <div class="d-flex">
                  <input type="search" class="form-control d-inline-block w-9 me-3" placeholder="Search Products"/>
                  <a href="#" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Page body -->
         <div class="page-body">
          <div class="container-xl">
            <div class="row row-cards">
              @foreach($params['products'] as $products)
              <div class="col-md-6 col-lg-3">
                <div class="card">
                  <div class="card-body p-4 text-center">
                    <span class="avatar avatar-xl mb-3 rounded" style="background-image: url('product_image/{{ $products->image }}')"></span>
                    <h3 class="m-0 mb-1"><a href="#">{{ $products->product_name }}</a></h3>
                    <div class="text-secondary">&#8369; {{ number_format($products->price, 2) }}</div>
                    <div class="mt-3">
                      <span>{{ $products->product_details }}</span>
                    </div>
                  </div>
                  <div class="d-flex">
                    <a href="/order-product-details?id={{ $products->id }}" class="card-btn"><!-- Download SVG icon from http://tabler-icons.io/i/mail -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
   <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path>
</svg>
                      View </a>
                    
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            {{ $params['products']->links() }}
          </div>
        </div>
        @include('layout.footer')
      </div>
    </div>
   
@endsection