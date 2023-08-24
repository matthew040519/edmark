@extends('layout.layout')
@section('content')
@include('layout.header')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.css">
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
                  Inventory Report
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                  <a class="btn btn-primary" href="{{ URL::to('/customer/pdf') }}">Export to PDF</a>
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
                     
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label">Free/Discounted Product</label>
                  <select class="form-control" id="product" name="free_product_id">
                      
                  </select>
                </div>
                 <div class="col-lg-12">
                      <div class="mb-3">
                       <label class="form-label">Quantity</label>
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
                      </tr>
                    </thead>
                    <tbody class="table-tbody" >
                     
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