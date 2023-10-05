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
                  Payment
                </h2>
              </div>
              <!-- Page title actions -->
              
            </div>
            <form method="POST" action="{{ route('paydebt') }}">
              {{ csrf_field() }}
            <div class="row mt-3">
              
                <div class="col-lg-3">
                    <label>Customer</label>
                    <select class="form-control" name="supplier" required="" id="customer">
                      <option disabled="" selected=""></option>
                      @foreach($params['customer'] as $customers)
                        <option value="{{ $customers->id }}">{{ $customers->firstname." ".$customers->lastname }}</option>
                      @endforeach
                  </select>
                </div>
                <div class="col-lg-3">
                    <label>Balance: </label>
                    @if(count($params['ledger']) > 0 )
                    <input type="text" class="form-control"  id="total" readonly="" value="{{ number_format($params['balance']->totalbalance, 2) }}">
                    @else
                    <input type="text" class="form-control" id="total" readonly="" value="0.00">
                    @endif
                </div>
         
                <input type="hidden" value="CS" name="voucher">
                <input type="hidden" value="payment-transaction" name="link">
                 <div class="col-lg-3 mt-3">
                    <div class="btn-list">
                      <a class="btn btn-primary d-none d-sm-inline-block" id="preview">Preview</a>
                      @if(count($params['ledger']) > 0 )
                        <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report" id="pay">Pay</a>
                      @endif
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
                <h5 class="modal-title">Pay Debt</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form method="POST" action="{{ route('paydebt') }}">
                  {{ csrf_field() }}
                    <div class="col-lg-12">
                      <label>Date</label>
                      <input type="date" class="form-control" value="{{ $params['tdate'] }}" name="tdate">
                    </div>
                    <div class="col-lg-12">
                        <label>Balance: </label>
                        @if(count($params['ledger']) > 0 )
                        <input type="text" class="form-control" name="balance" id="total" readonly="" value="{{ number_format($params['balance']->totalbalance, 2) }}">
                        <input type="hidden" class="form-control" name="totalbalance" readonly="" value="{{ $params['balance']->totalbalance }}">
                        <input type="hidden" value="{{ $params['customer_name']->id }}" id="" name="id">
                        @else
                        <input type="text" class="form-control" id="total" readonly="" value="0.00">
                        @endif
                      </div>
                    <div class="mb-3 mt-3">

                      <input type="hidden" value="CS" name="voucher">
                      <label class="form-label">Amount</label>
                      <input type="number" class="form-control" value="0" name="amount" placeholder="Peso Discount">
                    </div>
                
              </div>
               
              <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                  Cancel
                </a>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                <input type="submit" class="btn btn-success ms-auto" value="Pay Debt" name="addproduct">
                
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
            @if(count($params['ledger']) > 0 )
            <h2>Customer: {{ $params['customer_name']->firstname.' '.$params['customer_name']->lastname }}</h2>
            <div class="card">
              <div class="card-body">
                <div id="table-default" class="table-responsive">
                  <table class="table" id="example" style="width: 100%;">
                    <thead>
                      <tr>
                        <th><button class="table-sort">Date</button></th>
                        <th><button class="table-sort" data-sort="sort-Reference">Reference</button></th>
                        <th><button class="table-sort" data-sort="sort-Credit">Credit</button></th>
                        <th><button class="table-sort" data-sort="sort-Debit">Debit</button></th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
                      
                        @foreach($params['ledger'] as $ledger)
                        <tr>
                          <td>{{ $ledger->tdate }}</td>
                          <td>{{ $ledger->reference_id }}</td>
                          <td>{{ number_format($ledger->credit, 2) }}</td>
                          <td>{{ number_format($ledger->debit, 2) }}</td>
                        </tr>
                        @endforeach
                      
                    </tbody>

                  </table>
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>
        @include('layout.footer')
      </div>
      <script src="https://code.jquery.com/jquery-3.7.0.js" type="text/javascript"></script>
      <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js" type="text/javascript"></script>
      <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
      <script src="dist/libs/tom-select/dist/js/tom-select.base.min.js?1685973381" defer></script>
      <script type="text/javascript">
        $('#example').dataTable( {
              "aaSorting": []
          } );
      </script>
      <script type="text/javascript">
        $(document).ready(function(){

            // $customer_id = $('#customer');

            $('#customer').on('change', function(){

              $('#preview').attr('href', '/payment-transaction?id=' + $('#customer').val());

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