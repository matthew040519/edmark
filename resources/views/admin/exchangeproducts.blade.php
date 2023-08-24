@extends('layout.layout')
@section('content')
@include('layout.header')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.css">
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
                  Refund Products
                </h2>
              </div>
              <!-- Page title actions -->
              <!-- <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">

                  <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    Add Product
                  </a>
                  <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                  </a>
                </div>
              </div> -->
            </div>
            <form method="POST" action="{{ route('addpurchases') }}">
              {{ csrf_field() }}
            <div class="row mt-3">
              <div class="col-lg-3">
                    <label>Date</label>
                    <input type="date" class="form-control" required="" name="tdate">
                </div>
                <div class="col-lg-3">
                    <label>Customer</label>
                    <select class="form-control" id="customers" name="supplier" required="">
                      <option disabled="" selected="">-- Select Customer --</option>
                      @foreach($params['customer'] as $customers)
                        <option value="{{ $customers->id }}">{{ $customers->firstname." ".$customers->middlename." ".$customers->lastname }}</option>
                      @endforeach
                  </select>
                </div>
                <div class="col-lg-3">
                    <label>Reference</label>
                    <select class="form-control" id="reference" name="reference" required="">
                     
                  </select>
                </div>
                <!-- <div class="col-lg-3">
                    
                </div> -->
                <div class="col-lg-3">
                    <label>Total: </label>
                    <input type="text" class="form-control" id="total" readonly="" value="{{ number_format($params['total'], 2); }}">
                </div>
                <input type="hidden"  value="{{ $params['total']; }}" name="amount">
                <input type="hidden" value="CS" name="voucher">
                <input type="hidden" value="buy-products" name="link">
                 <div class="col-auto ms-auto d-print-none mt-4">
                  <div class="btn-list">

                    
                    <!-- <input type="submit" disabled="" value="Save" class="btn btn-success d-none d-sm-inline-block" name=""> -->

                    <!-- <a href="" data-bs-toggle="modal" data-bs-target="#modal-success" aria-label="Create new report" class="btn btn-success d-none d-sm-inline-block">Save</a>

                    <div class="modal modal-blur fade" id="modal-success" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-body">
                              <div class="modal-title">Are you sure?</div>
                              <div>If you proceed, the data will be save!</div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Cancel</button>
                              <input type="submit" id="savetransaction" value="Yes, Save this data" class="btn btn-success" name="">
                            </div>
                          </div>
                        </div>
                      </div> -->
                    
                  </div>
              </div>
            </div>
            </form>
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
                        <th><button class="table-sort" data-sort="sort-name">Product Name</button></th>
                        <th><button class="table-sort" data-sort="sort-city">Qty</button></th>
                        <th><button class="table-sort" data-sort="sort-city">Amount</button></th>
                        <th><button class="table-sort" data-sort="sort-type">Discount</button></th>
                        <th><button class="table-sort" data-sort="sort-city">Total</button></th>
                        <th><button class="table-sort" data-sort="sort-city">Settings</button></th>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>

                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal modal-blur fade" tabindex="-1" id="modal-danger" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              <div class="modal-status bg-secondary"></div>
                              <div class="modal-body text-center py-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" /><path d="M12 9v4" /><path d="M12 17h.01" /></svg>
                                <h3>Are you sure?</h3>
                                <div class="text-secondary">Do you really want to refund this item?</div>
                              </div>
                              <div class="modal-footer">
                                <div class="w-100">
                                  <div class="row">
                                    <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                                        Cancel
                                      </a></div>
                                    <div class="col"><a href="" id="refund" class="btn btn-secondary w-100">
                                        Refund
                                      </a></div>
                                  </div>
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
      
      <script type="text/javascript">
        
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

            $('#customers').on('change', function() {
                $.ajax({
                 url: '/getReference?customer_id=' + this.value,
                 type: 'get',
                 dataType: 'json',
                 success: function(response){
                  $('#reference').empty();
                  console.log(response);
                   var len = 0;
                   if(response['data'] != null){
                      len = response['data'].length;
                   }

                   if(len > 0){
                      var tr_str1 = "<option disabled selected> -- Select Reference -- </option>";
                      $("#reference").append(tr_str1);
                      for(var i=0; i<len; i++){
                         var reference = response['data'][i].reference;

                          var tr_str = "<option value=" + reference + ">" + reference + "</option>";

                         $("#reference").append(tr_str);
                      }
                      // new DataTable('#example');
                   }
                   else{
                      // var tr_str = "<tr>" +
                      //     "<td align='center' colspan='4'>Search to display.</td>" +
                      // "</tr>";

                      // $("#reference").append(tr_str);
                   }
                 }
               });
            });

            $('#reference').on('change', function() {
                $.ajax({
                 url: '/getProductTransaction?reference_id=' + this.value,
                 type: 'get',
                 dataType: 'json',
                 success: function(response){
                  $('tbody').empty();
                  console.log(response);
                   var len = 0;
                   if(response['data'] != null){
                      len = response['data'].length;
                   }
                   var totalamount = 0;
                   if(len > 0){
                    
                      for(var i=0; i<len; i++){
                         var id = response['data'][i].id;
                         var product_name = response['data'][i].product_name;
                         var free = response['data'][i].free;
                         var PIn = response['data'][i].PIn;
                         var POut = response['data'][i].POut;
                         var amount = response['data'][i].amount;
                         var piso_discount = response['data'][i].piso_discount;
                         var reference = response['data'][i].reference;
                         var product_id = response['data'][i].product_id;
                         var refund = response['data'][i].refund;
                         var total = (amount * POut) - piso_discount;

                         totalamount += amount;

                         var tr_str = "<tr>" +
                           "<td>" + product_name + "</td>" +
                           "<td>" + POut + "</td>" +
                           "<td>" + amount.toFixed(2) + "</td>" +
                           "<td>" + piso_discount.toFixed(2) + "</td>" +
                           "<td>" + total.toFixed(2) + "</td>";
                           if(!refund)
                           {
                               if(!free)
                               {  
                                  $('.modal').attr('id', "modal-danger" + id + "")
                                  $('#refund').attr('href', "/refund?id=" + id +"&link=refund-products&reference_id=" + reference + "&product_id=" + product_id)

                                  tr_str += "<td><a href='' data-bs-toggle='modal' data-bs-target='#modal-danger" + id + "' aria-label='Create new report' class='btn btn-secondary btn-sm'>Refund</a></td>"
                                  
                               }
                               else
                               {
                                  tr_str +="<td>Free</td>"
                               }
                           }
                           else
                           {
                                tr_str +="<td>Refunded</td>"
                           }
                           
                         tr_str +="</tr>";

                         $("tbody").append(tr_str);
                      }


                      $('#total').val(totalamount.toFixed(2));
                      
                   }
                   else{
                      // var tr_str = "<tr>" +
                      //     "<td align='center' colspan='4'>Search to display.</td>" +
                      // "</tr>";

                      // $("#reference").append(tr_str);
                   }
                 }
               });
            });


        });
        
      </script>
      <script src="dist/libs/fslightbox/index.js?1685973381" defer></script>
  @endsection