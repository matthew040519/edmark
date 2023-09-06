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
                  Inventory Report
                </h2>
              </div>
              <!-- Page title actions -->
              <!-- <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                  <a class="btn btn-primary" href="{{ URL::to('/customer/pdf') }}">Export to PDF</a>
                  <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    Add Product
                  </a>
                  <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                  </a>
                </div>
              </div> -->
              <form method="POST" action="{{ route('addpurchases') }}">
              {{ csrf_field() }}
            <div class="row mt-3">
              
                <div class="col-lg-3">
                    <label>Reports to View</label>
                    <select class="form-control" id="rtd"  name="rtd" required="">
                      <option disabled="" selected="">-- Select Report --</option>
                      <option value="1">Inventory</option>
                  </select>
                </div>

                

                <div class="col-lg-3 mt-4">
                    <button type="button" id="preview" disabled="" class="btn btn-primary">Preview</button>
                     <a id="export" href="#" target="_blank" class="btn btn-primary">Print</a>
                </div>
                <div class="col-lg-3 mt-4">
                   
                </div>
                <input type="hidden"   name="amount">
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
        </div>
        
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
              <div class="card">
              <div class="card-body">
                <div id="table-default" class="table-responsive">
                  <table class="table" id="example" style="width: 100%;">
                    <!-- <thead>
                      <tr>
                        <th><button class="table-sort" data-sort="sort-name">Product Name</button></th>
                        <th><button class="table-sort" data-sort="sort-city">Qty Remaining</button></th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
                      
                    </tbody> -->

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
      <script src="dist/libs/fslightbox/index.js?1685973381" defer></script>
      <script type="text/javascript">
        $(document).ready(function(){
            $( "#preview" ).on( "click", function() {
                var rtdvalue = $('#rtd').val();
                if(rtdvalue == 1)
                {
                    $.ajax({
                       url: '/showinventory',
                       type: 'get',
                       dataType: 'json',
                       success: function(response){
                        $('table').empty();
                        console.log(response);
                         var len = 0;
                         if(response['data'] != null){
                            len = response['data'].length;
                         }

                         if(len > 0){
                            var tr_str = "<thead>" +
                                            "<tr>" +
                                              "<th>Product Name</th>" +
                                              "<th>Product Qty</th>" +
                                            "</tr>"+
                                          "</thead>"+
                                          "<tbody>";
                                           for(var i=0; i<len; i++){

                                                var product_name = response['data'][i].product_name;
                                                var qty = response['data'][i].qty;

                                              tr_str += "<tr>" +
                                                 "<td>" + product_name + "</td>" +
                                                 "<td>" + qty + "</td>" +
                                              "</tr>"

                    
                                            }

                                            tr_str += "</tbody>";

                                            $("table").append(tr_str);    

                                            $('#export').attr('href', 'export?process=inventory');
                         }
                         else{
                            // var tr_str = "<tr>" +
                            //     "<td align='center' colspan='4'>Search to display.</td>" +
                            // "</tr>";

                            // $("#reference").append(tr_str);
                         }
                       }
                     });
                }
            } );
            $('#rtd').on('change', function() {
                $('#preview').removeAttr('disabled');
            });
        });
      </script>
      
  @endsection