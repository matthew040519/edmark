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
                <div id="alert" style="display: none;" class="alert alert-success alert-dismissible" role="alert">
                      <div class="d-flex">
                        <div>
                          <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                        </div>
                        <div>
                          Add to Cart Successfully
                        </div>
                      </div>
                      <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
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
                              <input type="hidden" id="price" value="{{ $params['products']->price }}" name="">
                              <input type="hidden" id="product_id" value="{{ $params['products']->id }}" name="">
                              <label><h3>Remaining: {{ $params['products']->qty }}</h3>  </label><br>
                              <label>Qty to be Order</label>
                              <input type="number" id="qty" style="width: 50%" placeholder="Qty to be Order" value="0" class="form-control" name="">
                              <br>
                              <button class="btn btn-outline-success" id="showaddtocart" data-bs-toggle="modal" data-bs-target="#modal-success"  disabled=""><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-garden-cart" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M17.5 17.5m-2.5 0a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0 -5 0"></path>
   <path d="M6 8v11a1 1 0 0 0 1.806 .591l3.694 -5.091v.055"></path>
   <path d="M6 8h15l-3.5 7l-7.1 -.747a4 4 0 0 1 -3.296 -2.493l-2.853 -7.13a1 1 0 0 0 -.928 -.63h-1.323"></path>
</svg> Add to cart</button>
                        </div>
                    </div>
                   <div class="modal modal-blur fade" id="modal-success" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-body">
                              <div class="modal-title">Are you sure?</div>
                              <div>If you proceed, the data will be save!</div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Cancel</button>
                              <!-- <button type="button" class="btn btn-success">Yes, Save this data</button> -->
                              <!-- <input type="submit" id="addtocart" value="Add to Cart" class="btn btn-success" name=""> -->
                               <button id="addtocart" class="btn btn-success" data-bs-dismiss="modal"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-garden-cart" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M17.5 17.5m-2.5 0a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0 -5 0"></path>
   <path d="M6 8v11a1 1 0 0 0 1.806 .591l3.694 -5.091v.055"></path>
   <path d="M6 8h15l-3.5 7l-7.1 -.747a4 4 0 0 1 -3.296 -2.493l-2.853 -7.13a1 1 0 0 0 -.928 -.63h-1.323"></path>
</svg> Add to Cart</button>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                
                </div>
              </div>
            </div>
            @if(count($params['free_product']) > 0)
             <h2 class="page-title mt-3">
                  Free Products/ Discounted Products
                </h2>
            <div class="row row-cards mt-2">
              @foreach($params['free_product'] as $free_product)
              <div class="col-md-4 col-lg-4">
                <div class="card">
                  <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="product_image/{{ $free_product->image }}">
                        </div>
                        <div class="col-md-9">
                             <h1 class="m-0 mb-1">({{ $free_product->qty }}) {{ $free_product->bproduct }}</h1>
                             <div><h1 class="text-green">&#8369; {{ $free_product->amount }}</h1></div>
                              <div class="mt-3">
                                {{ $free_product->product_details }}
                              </div>
                              
                        </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            @endif
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
                  $("#showaddtocart").removeAttr('disabled');
                  console.log('1');
              }
              else
              {
                  console.log('2');
                  $("#qty").css("border-color", "red");
                  $("#showaddtocart").attr('disabled', true);
              }
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $( "#addtocart" ).on( "click", function() {
                var qty = $('#qty').val();
                var product_id = $('#product_id').val();
                var price = $('#price').val();
                $.ajax({
                 url: '/add-to-cart',
                 type: 'POST',
                 data: {
                    qty: qty,
                    product_id: product_id,
                    price: price
                 },
                 dataType: 'json',
                 success: function(response){
                  console.log(response);
                  if(response.statusCode==200){
                                  // fetchRecords();  
                                  document.getElementById('qty').value = 0;
                                  $('#alert').css('display', 'block');
                                }
                                else if(dataResult.statusCode==201){
                                   alert("Error occured !");
                                }
                  
                 }
               });
            } );
        });
        
      </script>
   
@endsection