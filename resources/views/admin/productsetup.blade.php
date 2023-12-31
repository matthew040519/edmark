@extends('layout.layout')
@section('content')
@include('layout.header')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link
      href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
      rel="stylesheet"
    />
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
                  Apply Promo
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
            <form method="POST" action="{{ route('addproductsetup') }}" enctype="multipart/form-data">
              {{ csrf_field() }}
                <div class="mb-3">
                  <label class="form-label">Product</label>
                  <select class="form-control" id="js-example-basic-single" name="product_id">
                      @foreach($params['products'] as $product)
                        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                      @endforeach
                  </select>
                </div>
                <div class="col-lg-12">
                      <div class="mb-3">
                       <label class="form-label">Product Quantity</label>
                        <div class="input-group input-group-flat">
                         
                          <input type="number" name="p_qty" class="form-control ps-0" autocomplete="off">
                        </div>
                      </div>
                    </div>
                <div class="mb-3">
                  <label class="form-label">Free/Discounted Product</label>
                  <select class="form-control" id="product" name="free_product_id">
                      @foreach($params['products'] as $product)
                        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                      @endforeach
                  </select>
                </div>
                 <div class="col-lg-12">
                      <div class="mb-3">
                       <label class="form-label">Free/Discounted Quantity</label>
                        <div class="input-group input-group-flat">
                         
                          <input type="number" name="qty" class="form-control ps-0" autocomplete="off">
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="mb-3">
                       <label class="form-label">Amount</label>
                        <div class="input-group input-group-flat">
                         
                          <input type="number" name="product_price" class="form-control ps-0" autocomplete="off">
                        </div>
                      </div>
                    </div>
            
          </div>
           
          <div class="modal-footer">
            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
              Cancel
            </a>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
            <input type="submit" class="btn btn-primary ms-auto" value="Save" name="addproduct">
            
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
                        <th><button class="table-sort" data-sort="sort-city">Product Name</button></th>
                        <th><button class="table-sort" data-sort="sort-type">Product Name (Free or Discounted)</button></th>
                        <th><button class="table-sort" data-sort="sort-score">Amount</button></th>
                        <th><button class="table-sort" data-sort="sort-date">Quantity</button></th>
                        <th><button class="table-sort" data-sort="sort-city">Settings</button></th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody" >
                     @foreach($params['productsetup'] as $product)
                      <tr>
                        
                        <td class="sort-city">{{ $product->aproduct}}</td>
                        <td class="sort-city">{{ $product->bproduct}}</td>
                        <td class="sort-type">{{ $product->amount}}</td>
                        <td class="sort-score">{{ $product->qty}}</td>
                        <td><a href="" data-bs-toggle="modal" data-bs-target="#modal-danger{{ $product->id }}" aria-label="Create new report" class="btn btn-danger btn-md">Delete</a></td>
                      </tr>
                      <div class="modal modal-blur fade" id="modal-danger{{ $product->id }}" tabindex="-1" role="dialog" aria-hidden="true">
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
                                    <div class="col"><a href="/products-setup?id={{ $product->id }}" class="btn btn-danger w-100">
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
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" type="text/javascript" defer></script>
      <script src="https://code.jquery.com/jquery-3.7.0.js" type="text/javascript"></script>
      <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js" type="text/javascript"></script>
      <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
      <script type="text/javascript">
        new DataTable('#example');
       
        $(document).ready(function() {
             // $('#js-example-basic-single').select2();
        });
      </script>
      <script src="dist/libs/fslightbox/index.js?1685973381" defer></script>
      
      
  @endsection