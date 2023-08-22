@extends('layout.layout')
@section('content')
@include('layout.header')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
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
                  Customer
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                  
                  <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    Add Customer
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
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Customer</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('addcustomer') }}" enctype="multipart/form-data">
              {{ csrf_field() }}
                
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="mb-3">
                        <label class="form-label">First Name</label>
                        <div class="input-group input-group-flat">
                         
                          <input type="text" name="firstname" class="form-control ps-0" autocomplete="off">
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="mb-3">
                       <label class="form-label">Middle Name</label>
                        <div class="input-group input-group-flat">
                         
                          <input type="text" name="middlename" class="form-control ps-0" autocomplete="off">
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="mb-3">
                       <label class="form-label">Last Name</label>
                        <div class="input-group input-group-flat">
                         
                          <input type="text" name="lastname" class="form-control ps-0" autocomplete="off">
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="mb-3">
                       <label class="form-label">Contact Number</label>
                        <div class="input-group input-group-flat">
                         
                          <input type="number" name="contact_number" class="form-control ps-0" autocomplete="off">
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="mb-3">
                       <label class="form-label">Birthdate</label>
                        <div class="input-group input-group-flat">
                         
                          <input type="date" name="bdate" class="form-control ps-0" autocomplete="off">
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div>
                        <label class="form-label">Address</label>
                        <textarea class="form-control" name="address" rows="3"></textarea>
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
                        <th><button class="table-sort" data-sort="sort-name">First Name</button></th>
                        <th><button class="table-sort" data-sort="sort-city">Middle Name</button></th>
                        <th><button class="table-sort" data-sort="sort-city">Last Name</button></th>
                        <th><button class="table-sort" data-sort="sort-type">Contact Number</button></th>
                        <th><button class="table-sort" data-sort="sort-score">Birthdate</button></th>
                        <th><button class="table-sort" data-sort="sort-date">Address</button></th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody" >
                     @foreach($customer as $customers)
                      <tr>
                        
                        <td class="sort-city">{{ $customers->firstname}}</td>
                        <td class="sort-city">{{ $customers->middlename}}</td>
                        <td class="sort-city">{{ $customers->lastname}}</td>
                        <td class="sort-type">{{ $customers->contact_number}}</td>
                        <td class="sort-score">{{ $customers->bday}}</td>
                        <td class="sort-date">{{ $customers->address}}</td>
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
      <script src="dist/libs/fslightbox/index.js?1685973381" defer></script>
      <script type="text/javascript">
        new DataTable('#example');
      </script>
  @endsection