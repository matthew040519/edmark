@extends('layout.layout')
@section('content')
@include('layout.header')
<div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  Gross Profit
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <button type="button" class="btn btn-primary" onclick="javascript:window.print();">
                  <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /></svg>
                  Print Gross Profit
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="card card-lg">
              <div class="card-body">
                <div class="row">
                  <div class="col-6">
                    <p class="h3" style="color: green">JO HEALTH & WELLNESS CONSULTANCY SERVICES</p>
                    <address>
                      Rm. 201, Cuenca Gonzaga Bldg.<br>
                      San Juan Street<br>
                      Barangay 12<br>
                      
                    </address>
                  </div>
                  <!-- <div class="col-6 text-end">
                    <p class="h3">Client</p>
                    <address>
                      Street Address<br>
                      State, City<br>
                      Region, Postal Code<br>
                      ctr@example.com
                    </address>
                  </div> -->
                  <div class="col-12 my-5">
                    <h1>Gross Profit</h1>
                  </div>
                </div>
                <table class="table table-transparent table-responsive">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Customer</th>
                      <th>Product Name</th>
                      <th style="width: 1%"></th>
                      <th>Status</th>
                      <th>Amount</th>
                      <th>Total Amount</th>
                    </tr>
                  </thead>
                  @foreach($params['transaction'] as $transactions)
                  <tr>
                    <td>{{ $transactions->tdate }}</td>
                    <td>{{ $transactions->firstname }} {{ $transactions->lastname }}</td>
                    <td>
                      <p class="strong mb-1">{{ $transactions->product_code }}</p>
                      <div class="text-secondary">{{ $transactions->product_name }}</div>
                    </td>
                    <td class="text-center">
                      {{ $transactions->qty }}
                    </td>
                     <td class="text-center">
                      @if($transactions->free)
                      
                          Free
                      
                      @endif
                    </td>
                    <td>
                      @if($transactions->free)
                      
                          0
                      @else
                        {{ number_format($transactions->amount, 2) }}
                      
                      @endif
                     
                    </td>
                     <td>
                       @if($transactions->free)
                      
                          0.00
                      @else
                        {{ number_format($transactions->amount * $transactions->qty, 2) }}
                      @endif
                     
                    </td>
                  </tr>
                  @endforeach
                  <tr>
                    <td colspan="6" class="strong">Total</td>
                    <td>{{ number_format($params['totalSum'], 2) }}</td>
                  </tr>
                </table>
                <p class="text-secondary text-center mt-5">End of Gross Profit</p>
              </div>
            </div>
          </div>
        </div>
        @include('layout.footer')
      </div>
       @endsection