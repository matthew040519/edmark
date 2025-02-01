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
                  Best Buy Products
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
            <form method="POST" action="{{ route('addbestbuypromo') }}" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Package Name</label>
                            <input type="text" class="form-control" name="package_name" placeholder="Package Name" required="">
                          </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Stamp Qty</label>
                            <input type="number" class="form-control" name="stamp_quantity" placeholder="Stamp Qty" required="">
                          </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">DP</label>
                            <input type="number" class="form-control" name="dp" placeholder="DP" required="">
                          </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">SV</label>
                            <input type="number" class="form-control" name="sv" placeholder="SV" required="">
                          </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">BV</label>
                            <input type="number" class="form-control" name="bv" placeholder="BV" required="">
                          </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">CP</label>
                            <input type="number" class="form-control" name="cp" placeholder="CP" required="">
                          </div>
                    </div>
              </div>
            
          </div>
           
          <div class="modal-footer">
            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
              Cancel
            </a>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
            <input type="submit" id="save" class="btn btn-primary ms-auto" value="Save" name="addproduct">
            
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
                        <th><button class="table-sort" data-sort="sort-name">Stamp Name</button></th>
                        <th><button class="table-sort" data-sort="sort-city">Qty</button></th>
                        <th><button class="table-sort" data-sort="sort-city">DP</button></th>
                        <th><button class="table-sort" data-sort="sort-type">SV</button></th>
                        <th><button class="table-sort" data-sort="sort-city">BV</button></th>
                        <th><button class="table-sort" data-sort="sort-city">CP</button></th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody" >
                      @foreach($params['bestBuypromo'] as $bestBuypromo)
                        <tr>
                          <td class="sort-city">{{ $bestBuypromo->stamp_name }}</td>
                          <td class="sort-type">{{ $bestBuypromo->stamp_quantity}}</td>
                          <td class="sort-score">{{ number_format($bestBuypromo->dp, 2)}}</td>
                          <td class="sort-date">{{ number_format($bestBuypromo->sv, 2)}}</td>
                          <td class="sort-date">{{ number_format($bestBuypromo->bv, 2)}}</td>
                          <td class="sort-date">{{ number_format($bestBuypromo->cp, 2)}}</td>
                          {{-- <td><a href="" data-bs-toggle="modal" data-bs-target="#modal-danger{{ $temp_products->id }}" aria-label="Create new report" class="btn btn-danger">Delete</a></td> --}}
                        </tr>
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