@extends('layout.layout')
@section('content')
@include('layout.header')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
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
                  Buy Products
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">

                  <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    Add Product
                  </a>
                  <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                  </a>
                </div>
              </div>
            </div>
            <form method="POST" action="{{ route('addpurchases') }}">
              {{ csrf_field() }}
            <div class="row mt-3">
              <div class="col-lg-3">
                    <label>Date</label>
                    <input type="date" class="form-control" required="" name="tdate">
                </div>
                <div class="col-lg-3">
                    <label>Customer</label>
                    <select class="form-control" name="supplier" required="" id="customer">
                      <option disabled="" selected="">-- Select Customer --</option>
                      @foreach($params['customer'] as $customers)
                        <option value="{{ $customers->id }}">{{ $customers->firstname." ".$customers->lastname }}</option>
                      @endforeach
                  </select>
                </div>
                <div class="col-lg-3">
                    <label>Total: </label>
                    <input type="text" class="form-control" id="total" readonly="" value="{{ number_format($params['total'], 2); }}">
                </div>
                <input type="hidden"  value="{{ $params['total']; }}" name="amount">
                <input type="hidden" value="CS" name="voucher">
                <input type="hidden" value="buy-products" name="link">
                 <div class="col-auto ms-auto d-print-none mt-4">
                  <div class="btn-list">

                    
                    <!-- <input type="submit" disabled="" value="Save" class="btn btn-success d-none d-sm-inline-block" name=""> -->

                    <a href="" data-bs-toggle="modal" data-bs-target="#modal-success" aria-label="Create new report" class="btn btn-success d-none d-sm-inline-block">Save</a>

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
                              <input type="submit" id="savetransaction" value="Yes, Save this data" class="btn btn-success" name="">
                            </div>
                          </div>
                        </div>
                      </div>
                    
                  </div>
              </div>
            </div>
            </form>
          </div>
        </div>
        <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Product</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            @if(Auth::user()->role == '1')
            <form method="POST" action="{{ route('addtempproduct') }}" enctype="multipart/form-data">
            @elseif(Auth::user()->role == '2')
            <form method="POST" action="{{ route('addtempproductcashier') }}" enctype="multipart/form-data">
            @endif
              {{ csrf_field() }}
              <div class="row">
                  <div class="col-lg-6 mb-3">
                      <a data-fslightbox="gallery"  id="photo" href="#">
                      <!-- Photo -->
                        <div class="img-responsive img-responsive-3x1 rounded-3 border" style="height: 100%;" id="divphoto"></div>
                      </a>
                  </div>
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="mb-3">
                          <label class="form-label">Product</label>
                          <select class="form-control" name="product_id" id="product_id">
                            <option disabled="" selected="">-- Select Product --</option>
                            @foreach($params['product'] as $product)
                              <option data-product_amount="{{ $product->price }}" link="{{ $product->image }}" qty="{{ $product->qty }}" value="{{ $product->id }}">{{ $product->product_name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <div class="mb-3">
                          <label class="form-label">Price</label>
                          <input type="number" class="form-control" readonly="" id="price" name="price" placeholder="Price">
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
                
                 
                <input type="hidden" value="CS" name="voucher">
                <input type="hidden" value="buy-products" name="link">
                <div class="mb-3">
                  <label class="form-label">Qty Remaining</label>
                  <input type="number" class="form-control" readonly="" id="qty_remain" name="qty_remain" placeholder="Qty">
                </div>
                <div class="mb-3">
                  <label class="form-label">Qty</label>
                  <input type="number" class="form-control" name="qty" id="qty" placeholder="Quantity">
                </div>

                <div class="mb-3">
                  <label class="form-label">Peso Discount</label>
                  <input type="number" class="form-control" value="0" name="peso_discount" placeholder="Peso Discount">
                </div>

                <div class="mb-3">
                  <label class="form-label"></label>
                  <input type="checkbox" name="free" value="1"> Free Product?
                  <input type="checkbox" name="prv" value="1"> PRV?
                  {{-- <input type="number" class="form-control" value="0" name="peso_discount" placeholder="Peso Discount"> --}}
                </div>
            
          </div>
           
          <div class="modal-footer">
            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
              Cancel
            </a>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
            <input type="submit" disabled="" id="save" class="btn btn-primary ms-auto" value="Save" name="addproduct">
            
          </div>
          </form>
        </div>
      </div>
    </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            @if(session('status'))
            <div class="alert alert-success alert-dismissible" role="alert">
                      <div class="d-flex">
                        <div>
                          <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                        </div>
                        <div>
                          {{ session('status') }}
                        </div>
                      </div>
                      <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
            @endif
            <div class="card">
              <div class="card-body">
                <div id="table-default" class="table-responsive">
                  <table class="table" id="example" style="width: 100%;">
                    <thead>
                      <tr>
                        <th><button class="table-sort" data-sort="sort-name">Product Name</button></th>
                        <th><button class="table-sort" data-sort="sort-city">Qty</button></th>
                        <th><button class="table-sort" data-sort="sort-city">Amount</button></th>
                        <th><button class="table-sort" data-sort="sort-type">Discount</button></th>
                        <th><button class="table-sort" data-sort="sort-city">Total</button></th>
                        <th><button class="table-sort" data-sort="sort-city">Settings</button></th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody" >
                      @foreach($params['temp_product'] as $temp_products)
                        <tr>
                          <td class="sort-city">{{ $temp_products->product_name }} @if($temp_products->free =='1') (Free) @endif</td>
                          <td class="sort-type">{{ $temp_products->POut}}</td>
                          <td class="sort-score">{{ number_format($temp_products->amount, 2)}}</td>
                          <td class="sort-date">{{ number_format($temp_products->piso_discount, 2)}}</td>
                          <td class="sort-date">{{ number_format(($temp_products->amount * $temp_products->POut) - $temp_products->piso_discount, 2)}}</td>
                          <td><a href="" data-bs-toggle="modal" data-bs-target="#modal-danger{{ $temp_products->id }}" aria-label="Create new report" class="btn btn-danger">Delete</a></td>
                        </tr>
                        <div class="modal modal-blur fade" id="modal-danger{{ $temp_products->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              <div class="modal-status bg-danger"></div>
                              <div class="modal-body text-center py-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" /><path d="M12 9v4" /><path d="M12 17h.01" /></svg>
                                <h3>Are you sure?</h3>
                                <div class="text-secondary">Do you really want to remove item?</div>
                              </div>
                              <div class="modal-footer">
                                <div class="w-100">
                                  <div class="row">
                                    <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                                        Cancel
                                      </a></div>
                                    <div class="col">
                                    @if(Auth::user()->role == '1')
                                      <a href="/delete-temp?id={{ $temp_products->id }}&link=buy-products" class="btn btn-danger w-100">
                                      @elseif(Auth::user()->role == '2')
                                      <a href="/cashier-delete-temp?id={{ $temp_products->id }}&link=cashier-buy-products" class="btn btn-danger w-100">
                                    
                                      @endif
                                      Delete
                                      </a></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endforeach
                    </tbody>

                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        @include('layout.footer')
      </div>
      <script src="https://code.jquery.com/jquery-3.7.0.js" type="text/javascript"></script>
      <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js" type="text/javascript"></script>
      <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
      <script src="dist/libs/tom-select/dist/js/tom-select.base.min.js?1685973381" defer></script>
      <script type="text/javascript">
        new DataTable('#example');
      </script>
      <script type="text/javascript">
        $(document).ready(function(){

            var totalamount = $('#total').val();

            if(totalamount == "0.00")
            {
                $('#savetransaction').attr('disabled', true);
            }
            else
            {
                $('#savetransaction').removeAttr('disabled');
            }

            $('#product_id').on('change', function() {
                $('#price').val(($("#product_id").find(':selected').attr('data-product_amount')));
                $('#qty_remain').val(($("#product_id").find(':selected').attr('qty')));
                var link = 'product_image/' + $("#product_id").find(':selected').attr('link');
                // console.log('product_image/' + link);
                $('#photo').attr('href', link);
                $('#divphoto').css('background-image', "url(" + link + ")");
            });
            $("#qty").change(function(){
              // $("input").css("background-color", "yellow");
              var qty_remain = $('#qty_remain').val();
              var qty = $('#qty').val();
              const total = qty_remain - qty;
              console.log(total)
              if(total > 0)
              {
                  $("#qty").css("border-color", "black");
                  $("#save").removeAttr('disabled');
                  console.log('1');
              }
              else
              {
                  console.log('2');
                  $("#qty").css("border-color", "red");
                  $("#save").attr('disabled', true);
              }
            });
        });
        
      </script>
      <script src="dist/libs/fslightbox/index.js?1685973381" defer></script>
      <script>
        // @formatter:off
        document.addEventListener("DOMContentLoaded", function () {
          var el;
          window.TomSelect && (new TomSelect(el = document.getElementById('customer'), {
            copyClassesToDropdown: false,
            dropdownParent: 'body',
            controlInput: '<input>',
            render:{
              item: function(data,escape) {
                if( data.customProperties ){
                  return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                }
                return '<div>' + escape(data.text) + '</div>';
              },
              option: function(data,escape){
                if( data.customProperties ){
                  return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                }
                return '<div>' + escape(data.text) + '</div>';
              },
            },
          }));
        });
        // @formatter:on
      </script>
  @endsection