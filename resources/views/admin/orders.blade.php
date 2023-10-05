@extends('layout.layout')
@section('content')
<div class="page">
      <!-- Navbar -->
      @include('layout.header')
      <style type="text/css">
        .flex-1{
          display: none;
        }
      </style>
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
                  {{ $params['title'] }} Orders
                </h2>
              </div>
              <!-- <div class="col-auto ms-auto d-print-none">
                <div class="d-flex">
                  <input type="search" class="form-control d-inline-block w-9 me-3" placeholder="Search Products"/>
                  <a href="#" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                  </a>
                </div>
              </div> -->
            </div>
          </div>
        </div>
        <!-- Page body -->
         <div class="page-body">

            <div class="container-xl">
              @if(session('status'))
            <div class="alert alert-{{ session('color') }} alert-dismissible" role="alert">
                      <div class="d-flex">
                        <div>
                          <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                          @if(session('color') == 'success')
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
   <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
   <path d="M15 19l2 2l4 -4"></path>
</svg>
          @else
          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-cancel" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
   <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5"></path>
   <path d="M19 19m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
   <path d="M17 21l4 -4"></path>
</svg>
@endif
                        </div>
                          

                          
                        <div>
                          {{ session('status') }}
                        </div>
                      </div>
                      <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
            @endif
              @if(count($params['application_id']) > 0 )
              @foreach($params['application_id'] as $applications)
              <div class="row row-cards mt-3">
                <div class="col-lg-12">
                  @if($params['title'] == 'Pending')
                  <div id="alert" class="alert alert-secondary alert-dismissible" role="alert">
                      <div class="d-flex">
                        <div class="mt-3">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
   <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
   <path d="M15 19l2 2l4 -4"></path>
</svg>
  @elseif($params['title'] == 'Approve')
  <div id="alert" class="alert alert-success alert-dismissible" role="alert">
                      <div class="d-flex">
                        <div class="mt-3">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
   <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
   <path d="M15 19l2 2l4 -4"></path>
</svg>
  @elseif($params['title'] == 'Cancelled')
    <div id="alert" class="alert alert-danger alert-dismissible" role="alert">
                      <div class="d-flex">
                        <div class="mt-3">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-cancel" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
   <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5"></path>
   <path d="M19 19m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
   <path d="M17 21l4 -4"></path>
</svg>
  @elseif($params['title'] == 'Completed')
  <div id="alert" class="alert alert-success alert-dismissible" role="alert">
                      <div class="d-flex">
                        <div class="mt-3">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
   <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
   <path d="M15 19l2 2l4 -4"></path>
</svg>
  @endif
                        </div>
                        <div class="mt-3">
                          {{ $applications->firstname.' '.$applications->lastname }}
                        </div>

                        <div style="margin-left: 20px" class="mt-3">
                          <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh-dot" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
   <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"></path>
   <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
</svg>
                        </div>
                        <div class="mt-3">
                          Reference: {{ $applications->application_id }}
                        </div>
                        @if($params['title'] == 'Pending')
                        <div class="col-auto ms-auto d-print-none">
                <div class="d-flex">
                 
                  <button class="btn btn-success btn-md" data-bs-toggle="modal" data-bs-target="#modal-success{{ $applications->application_id }}"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
   <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
   <path d="M15 19l2 2l4 -4"></path>
</svg> Approve</button>

<button class="btn btn-danger btn-md" style="margin-left: 20px" data-bs-toggle="modal" data-bs-target="#modal-danger{{ $applications->application_id }}"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-cancel" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
   <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5"></path>
   <path d="M19 19m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
   <path d="M17 21l4 -4"></path>
</svg> Cancel</button>

                  
                </div>

                <div class="modal modal-blur fade" id="modal-success{{ $applications->application_id }}" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              <div class="modal-status bg-success"></div>
                              <div class="modal-body text-center py-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-success icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" /><path d="M12 9v4" /><path d="M12 17h.01" /></svg>
                                <h3>Are you sure?</h3>
                                <div class="text-secondary">Do you really want to approve this orders?</div>
                              </div>
                              <div class="modal-footer">
                                <div class="w-100">
                                  <div class="row">
                                    <div class="col"><a href="" class="btn w-100" data-bs-dismiss="modal">
                                        Cancel
                                      </a></div>
                                    <div class="col"><a href="/pending-application?application_id={{ $applications->application_id }}&status=1" class="btn btn-success w-100">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
   <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
   <path d="M15 19l2 2l4 -4"></path>
</svg>
                                        Approve
                                      </a></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="modal modal-blur fade" id="modal-danger{{ $applications->application_id }}" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              <div class="modal-status bg-danger"></div>
                              <div class="modal-body text-center py-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" /><path d="M12 9v4" /><path d="M12 17h.01" /></svg>
                                <h3>Are you sure?</h3>
                                <div class="text-secondary">Do you really want to cancel this orders?</div>
                              </div>
                              <div class="modal-footer">
                                <div class="w-100">
                                  <div class="row">
                                    <div class="col"><a href="" class="btn w-100" data-bs-dismiss="modal">
                                        Cancel
                                      </a></div>
                                    <div class="col"><a href="/pending-application?application_id={{ $applications->application_id }}&status=2" class="btn btn-danger w-100">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-cancel" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
   <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5"></path>
   <path d="M19 19m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
   <path d="M17 21l4 -4"></path>
</svg>
                                        Cancel
                                      </a></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

              </div>
              @elseif($params['title'] == 'Approve')
              <div class="col-auto ms-auto d-print-none">
                <div class="d-flex">
                 
                  <button class="btn btn-success btn-md" data-bs-toggle="modal" data-bs-target="#modal-success{{ $applications->application_id }}"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
   <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
   <path d="M15 19l2 2l4 -4"></path>
</svg> Completed</button>

                  
                </div>

                <div class="modal modal-blur fade" id="modal-success{{ $applications->application_id }}" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              <div class="modal-status bg-success"></div>
                              <div class="modal-body text-center py-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-success icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" /><path d="M12 9v4" /><path d="M12 17h.01" /></svg>
                                <h3>Are you sure?</h3>
                                <div class="text-secondary">Do you really want to complete this orders?</div>
                              </div>
                              <div class="modal-footer">
                                <div class="w-100">
                                  <div class="row">
                                    <div class="col"><a href="" class="btn w-100" data-bs-dismiss="modal">
                                        Cancel
                                      </a></div>
                                    <div class="col"><a href="/approve-application?application_id={{ $applications->application_id }}&status=3" class="btn btn-success w-100">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
   <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
   <path d="M15 19l2 2l4 -4"></path>
</svg>
                                        Complete
                                      </a></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

              </div>
              @endif
                      </div>
                    </div>
                    
                  <div class="card">
                    <div class="container">
                        <!-- <form>
                          <div class="row mt-3">
                              <div class="col-lg-4">
                                  <label>Mode of Payment</label>
                                  <select class="form-control" name="mop">
                                    <option disabled="" selected=""> -- Select Mode of Payment --</option>
                                    <option value="Gcash">Gcash</option>
                                    <option value="Cash">Cash</option>
                                  </select>
                              </div>
                          </div>
                        </form> -->
                    </div>
                    
                    <div class="table-responsive">

                    <table
    class="table table-vcenter table-mobile-md card-table mt-3">
                      <thead>
                        <tr>
                          <th>Product</th>
                          <th>Quantity</th>
                          <th>Amount</th>
                          <th class="w-1">Total Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($params['application'][$applications->application_id] as $application)
                        <tr>
                          <td data-label="Product" >
                            <div class="d-flex py-1 align-items-center">
                              <span class="avatar me-2" style="background-image: url('product_image/{{ $application->image }}')"></span>
                              <div class="flex-fill">
                                <div class="font-weight-medium">{{ $application->product_name }}</div>
                                <div class="text-secondary"><a href="#" class="text-reset">{{ $application->product_code }}</a></div>
                              </div>
                            </div>
                          </td>
                          <td data-label="Quantity" >
                            <div>{{ $application->qty }}</div>
                          </td>
                          <td class="text-secondary" data-label="Price" >
                            {{ number_format($application->price, 2) }}
                          </td>
                          <td data-label="Total Price">{{ number_format($application->price * $application->qty, 2) }}</td> 
                        </tr>
                        @endforeach
                        <tr>
                          <td colspan="3">Total</td>
                          <td>{{ number_format($applications->total, 2) }}</td>
                        </tr>
                        <!-- <tr>
                          <td colspan="3"></td>
                          <td><a href="" data-bs-toggle="modal" data-bs-target="#modal-report" class="btn btn-success"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-garden-cart" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M17.5 17.5m-2.5 0a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0 -5 0"></path>
   <path d="M6 8v11a1 1 0 0 0 1.806 .591l3.694 -5.091v.055"></path>
   <path d="M6 8h15l-3.5 7l-7.1 -.747a4 4 0 0 1 -3.296 -2.493l-2.853 -7.13a1 1 0 0 0 -.928 -.63h-1.323"></path>
</svg> Checkout</a></td>
                        </tr> -->
                      </tbody>
                    </table>
                  </div>
                  </div>
                 
                </div>
              </div>
              {{ $params['application_id']->links() }}
               @endforeach
               @else
               <div class="container-xl d-flex flex-column justify-content-center">
                  <div class="empty">
                    <div class="empty-img"><img src="./static/illustrations/undraw_printing_invoices_5r4r.svg" height="128" alt="">
                    </div>
                    <p class="empty-title">No results found</p>
                    <p class="empty-subtitle text-secondary">
                      
                    </p>
                    <!-- <div class="empty-action">
                      <a href="#" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                        Add your first client
                      </a>
                    </div> -->
                  </div>
                </div>
               @endif
            </div>
        </div>
        <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Checkout</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('checkout') }}" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="row">
                  <div class="col-lg-12">
                      <div class="mb-3">
                        <label>Mode of Payment</label>
                                  <select class="form-control" name="mop" >
                                    <option disabled="" selected=""> -- Select Mode of Payment --</option>
                                    <option value="Gcash">Gcash</option>
                                    <option value="Cash">Cash</option>
                                  </select>
                      </div>
                     <!--  <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control" readonly="" id="price" name="price" placeholder="Price">
                      </div> -->
                  </div>
              </div>
                
                 
               
            
          </div>
           
          <div class="modal-footer">
            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
              Cancel
            </a>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
            <input type="submit" id="save" class="btn btn-success ms-auto" value="Checkout" name="addproduct">
            
          </div>
          </form>
        </div>
      </div>
    </div>
        @include('layout.footer')
      </div>
    </div>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript">

        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key')}}', {cluster: 'ap1'});
        const channel = pusher.subscribe('public');

        channel.bind('chat', function (data){
            
            // var application = [];

            
            // for(var x = 0; x < data.data.length; x++)
            // {
            //     application.push(data.data[x].application_id, data.data[x].rownum, data.data[x].status, data.data[x].total);
            // }

            // console.log(application);
            window.top.location = window.top.location
            // $.ajax({  

            //   url: '/pending-application?notif=1',
            //   method: 'GET',
            //   success: function(response){
            //     console.log(response);
            //   }

            // });

          // }).done(function (res){
          //     console.log(res);
          // });
        });

    </script>
@endsection