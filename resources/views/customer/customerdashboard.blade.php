@extends('layout.layout')
@section('content')
<div class="page">
      <!-- Navbar -->
      @include('layout.header')
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
                  Dashboard
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                  <span class="d-none d-sm-inline">
                    <a href="#" class="btn">
                      Points: {{ $params['points']->totalpoints }}
                    </a>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="col-12">
                <div class="row row-cards">
                  <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-secondary text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-pause" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
   <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5"></path>
   <path d="M17 17v5"></path>
   <path d="M21 17v5"></path>
</svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                              Pending Orders
                            </div>
                            <div class="text-secondary">
                              {{ $params['countPending'] }}
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-success text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
   <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
   <path d="M15 19l2 2l4 -4"></path>
</svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                              Approve Orders
                            </div>
                            <div class="text-secondary">
                              {{ $params['countApprove'] }}
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                   <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-danger text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-cancel" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
   <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5"></path>
   <path d="M19 19m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
   <path d="M17 21l4 -4"></path>
</svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                              Cancelled Orders
                            </div>
                            <div class="text-secondary">
                              {{ $params['countCancel'] }}
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-green text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/shopping-cart -->
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-star" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
   <path d="M6 21v-2a4 4 0 0 1 4 -4h.5"></path>
   <path d="M17.8 20.817l-2.172 1.138a.392 .392 0 0 1 -.568 -.41l.415 -2.411l-1.757 -1.707a.389 .389 0 0 1 .217 -.665l2.428 -.352l1.086 -2.193a.392 .392 0 0 1 .702 0l1.086 2.193l2.428 .352a.39 .39 0 0 1 .217 .665l-1.757 1.707l.414 2.41a.39 .39 0 0 1 -.567 .411l-2.172 -1.138z"></path>
</svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                              Completed Orders
                            </div>
                            <div class="text-secondary">
                              {{ $params['countComplete'] }}
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <br>
              <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
               <!--  <div class="page-pretitle">
                  
                </div> -->
                <h2 class="page-title">
                  Edmark Products
                </h2>
              </div>
              <!-- Page title actions -->
              <!-- <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                  <span class="d-none d-sm-inline">
                    <a href="#" class="btn">
                      Points: {{ $params['points']->totalpoints }}
                    </a>
                  </span>
                </div>
              </div> -->
            </div>
            <br>
            <div class="row row-cards">
              @foreach($params['products'] as $products)
              <div class="col-md-6 col-lg-3">
                <div class="card">
                  <div class="card-body p-4 text-center">
                    <span class="avatar avatar-xl mb-3 rounded" style="background-image: url('product_image/{{ $products->image }}')"></span>
                    <h3 class="m-0 mb-1"><a href="#">{{ $products->product_name }}</a></h3>
                    @if($params['customer_type'] === 2)
                    <div class="text-secondary">&#8369; {{ number_format($products->price, 2) }}</div>
                    @elseif($params['customer_type'] == 1)
                    <div class="text-secondary">&#8369; {{ number_format($products->member_price, 2) }}</div>
                    @elseif($params['customer_type'] == 3)
                    <div class="text-secondary">&#8369; {{ number_format($products->stockies_price, 2) }}</div>
                    @endif
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