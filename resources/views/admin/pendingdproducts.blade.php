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
                  Pending Distributed Products
                </h2>
              </div>
              <!-- Page title actions -->
            
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
                        <th><button class="table-sort" data-sort="sort-name">Date</button></th>
                        <th><button class="table-sort" data-sort="sort-city">Reference</button></th>
                        <th><button class="table-sort" data-sort="sort-city">Branch</button></th>
                        <th><button class="table-sort" data-sort="sort-city">Settings</button></th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
                      @foreach($params['pending-transaction'] as $transaction)
                        <tr>
                          <td class="sort-city">{{ $transaction->tdate }}</td>
                          <td class="sort-type">{{ $transaction->reference}}</td>
                          <td class="sort-score">{{ $transaction->branch_name }}</td>
                          <td><a href="" data-bs-toggle="modal" data-bs-target="#modal-scrollable{{ $transaction->id }}" aria-label="Create new report" class="btn btn-primary btn-md">View</a></td>
                        </tr>
                        <div class="modal modal-blur fade" id="modal-scrollable{{ $transaction->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Products</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="" style="font-weight: bold">Products</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="" style="font-weight: bold">Quantity</label>
                                                </div>
                                            </div>
                                            @foreach($params['pending-products'][$transaction->id] as $pendingproducts)
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="">{{ $pendingproducts->product_name }}</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="">{{ $pendingproducts->Pin}}</label>
                                                    </div>
                                                </div>
                                            @endforeach

                                            
                                                <form action="{{ route('acceptproducts') }}" method="POST" class="mt-3">
                                                    {{ csrf_field() }}
                                                    <div class="mb-3">
                                                        <input type="hidden" name="id" value="{{ $transaction->id }}">
                                                        <label class="form-label">Remarks</label>
                                                        <textarea name="remarks" id="" cols="30" rows="7" class="form-control" style="width: 100%"></textarea>
                                                    </div>
                                                
                                          
                                                        
                                    </div>
                                    <div class="modal-footer">
                                       
                                            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                                            @if(Auth::user()->user_type == '2')
                                            <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Accept</button>
                                            @else
                                            <button type="submit" disabled class="btn btn-success" data-bs-dismiss="modal">Accept</button>
                                            @endif
                                        </form>
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
  @endsection