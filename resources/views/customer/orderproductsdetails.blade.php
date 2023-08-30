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
                  {{ $params['products']->product_name }}
                </h2>
              </div>
            </div>
          </div>
        </div>
        <!-- Page body -->
         <div class="page-body">
          <div class="container">
            <div class="row row-cards">
              <div class="col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="product_image/{{ $params['products']->image }}">
                        </div>
                        <div class="col-md-9">
                             <h1 class="m-0 mb-1">{{ $params['products']->product_name }}</h1>
                             <br>
                              <div><h1 class="text-green">&#8369; {{ number_format($params['products']->price, 2) }}</h1></div>
                              <div class="mt-3">
                                {{ $params['products']->product_details }}
                              </div>
                              <br>
                              <input type="hidden" id="remain" value="{{ $params['products']->qty }}" name="">
                              <label><h3>Remaining: {{ $params['products']->qty }}</h3>  </label><br>
                              <label>Qty to be Order</label>
                              <input type="number" id="qty" style="width: 50%" placeholder="Qty to be Order" value="0" class="form-control" name="">
                              <br>
                              <button class="btn btn-outline-success" id="addtocart" disabled=""><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-garden-cart" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M17.5 17.5m-2.5 0a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0 -5 0"></path>
   <path d="M6 8v11a1 1 0 0 0 1.806 .591l3.694 -5.091v.055"></path>
   <path d="M6 8h15l-3.5 7l-7.1 -.747a4 4 0 0 1 -3.296 -2.493l-2.853 -7.13a1 1 0 0 0 -.928 -.63h-1.323"></path>
</svg> Add to cart</button>
                        </div>
                    </div>
                   
                  </div>
                
                </div>
              </div>
            </div>
          </div>
        </div>
        @include('layout.footer')
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            $("#qty").change(function(){
              // $("input").css("background-color", "yellow");
              var qty_remain = $('#remain').val();
              var qty = $('#qty').val();
              const total = qty_remain - qty;
              console.log(total)
              if(total > 0)
              {
                  $("#qty").css("border-color", "black");
                  $("#addtocart").removeAttr('disabled');
                  console.log('1');
              }
              else
              {
                  console.log('2');
                  $("#qty").css("border-color", "red");
                  $("#addtocart").attr('disabled', true);
              }
            });
        });
        
      </script>
   
@endsection