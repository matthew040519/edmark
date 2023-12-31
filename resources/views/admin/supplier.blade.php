@extends('layout.layout')
@section('content')
@include('layout.header')

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
                  Supplier
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                  
                  <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    Add Supplier
                  </a>
                  <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
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
                <h5 class="modal-title">Add Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form method="POST" action="{{ route('addsupplier') }}" enctype="multipart/form-data">
                  {{ csrf_field() }}
                    <div class="mb-3">
                      <label class="form-label">Supplier Name</label>
                      <input type="text" class="form-control" name="supplier_name" placeholder="Supplier Name">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Contact Number</label>
                      <input type="number" class="form-control" name="contact_number" placeholder="Contact Number">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Address</label>
                      <textarea class="form-control" name="address" rows="3"></textarea>
                    </div>
                
              </div>
               
              <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                  Cancel
                </a>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                <input type="submit" class="btn btn-primary ms-auto" value="Save" name="addsupplier">
                
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
                        <th><button class="table-sort" data-sort="sort-name">Supplier</button></th>
                        <th><button class="table-sort" data-sort="sort-city">Address</button></th>
                        <th><button class="table-sort" data-sort="sort-city">Contact Number</button></th>
                         <th><button class="table-sort" data-sort="sort-date">Settings</button></th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody" >
                     @foreach($supplier as $suppliers)
                      <tr>
                        <td class="sort-score">{{ $suppliers->supplier_name}}</td>
                        <td class="sort-date">{{ $suppliers->address}}</td>
                        <td class="sort-date">{{ $suppliers->contact_number}}</td>
                        <td><a href="" data-bs-toggle="modal" data-bs-target="#modal-primary{{ $suppliers->id }}" aria-label="Create new report" class="btn btn-success">Update</a></td>
                      </tr>
                        <div class="modal modal-blur fade" id="modal-primary{{ $suppliers->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title">Update {{ $suppliers->supplier_name}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <form method="POST" action="{{ route('updatesupplier') }}" enctype="multipart/form-data">
                                      {{ csrf_field() }}
                                        <input type="hidden" value="{{ $suppliers->id }}" name="id">
                                        <div class="mb-3">
                                          <label class="form-label">Supplier Name</label>
                                          <input type="text" class="form-control" value="{{ $suppliers->supplier_name }}" name="supplier_name" placeholder="Supplier Name">
                                        </div>
                                        <div class="mb-3">
                                          <label class="form-label">Contact Number</label>
                                          <input type="number" value="{{ $suppliers->contact_number }}" class="form-control" name="contact_number" placeholder="Contact Number">
                                        </div>
                                        <div class="mb-3">
                                          <label class="form-label">Address</label>
                                          <textarea class="form-control" name="address" rows="3">{{ $suppliers->address }}</textarea>
                                        </div>
                                    
                                  </div>
                                   
                                  <div class="modal-footer">
                                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                                      Cancel
                                    </a>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                    <input type="submit" class="btn btn-primary ms-auto" value="Save" name="addsupplier">
                                    
                                  </div>
                                  </form>
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
      <script src="dist/libs/fslightbox/index.js?1685973381" defer></script>
      <script type="text/javascript">
        new DataTable('#example');
      </script>
  @endsection