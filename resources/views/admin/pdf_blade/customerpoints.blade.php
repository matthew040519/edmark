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
                  Customer Points
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <button type="button" class="btn btn-primary" onclick="javascript:window.print();">
                  <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /></svg>
                  Print Customer Points
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
                    <h1>Customer Points</h1>
                  </div>
                </div>
                <table class="table table-transparent table-responsive">
                  <thead>
                    <tr>
                      <th class="text-center" style="width: 1%"></th>
                      <th>Customer Name</th>
                      <th class="text-center" style="width: 1%">Points</th>
                    </tr>
                  </thead>
                  @foreach($customerpoints as $customerpoint)
                  <tr>
                    <td class="text-center"></td>
                    <td>
                      <p class="strong mb-1">{{ $customerpoint->firstname.' '.$customerpoint->lastname }}</p>
                    </td>
                    <td class="text-center">
                      {{ $customerpoint->totalpoints }}
                    </td>
                  </tr>
                  @endforeach
                </table>
                <p class="text-secondary text-center mt-5">End of Customer Points</p>
              </div>
            </div>
          </div>
        </div>
        @include('layout.footer')
      </div>
       @endsection