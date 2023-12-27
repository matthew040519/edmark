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
                  Customer Ledger
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
                      <option value="1">All Customer Ledger</option>
                      <option value="2">Ledger by Customer</option>
                  </select>
                </div>

                <div class="col-lg-3">
                  <label>Customer</label>
                    <select class="form-control" name="customer" id="customer">
                      
                    </select>
                </div>

                <div class="col-lg-3 mt-3">
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
              <div id="cl-content">
                
              </div>
              <!-- <div class="card">
                <div class="card-body">
                  <div id="table-default" class="table-responsive">
                    
                     
                  </div>
                </div>
              </div> -->
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
                       url: '/report-customer-ledger?show=1',
                       type: 'get',
                       dataType: 'json',
                       success: function(response){
                        $('#cl-content').empty();
                        console.log(response['customer']);
                         var len = 0;
                         if(response['customer'] != null){
                            len = response['customer'].length;
                            lenledger = response['ledger'].length;
                         }

                         if(len > 0){
                            for(var i=0; i<len; i++){

                              var id = response['customer'][i].id;
                              lenledger = response['ledger'][id].length;

                              var balance = response['ledger']['balance'][id][0].totalbalance;

                              console.log(balance)
                            var tr_str = "<div class='row row-cards mt-3'>"+
                                  "<div class='col-lg-12'>"
                            tr_str += "<div id='alert' class='alert alert-secondary alert-dismissible' role='alert'>"
                                      + "<div class='d-flex'>"
                            tr_str += "<div>" + response['customer'][i].firstname + " " + response['customer'][i].lastname + "</div>" 
                            tr_str += "<div class='col-auto ms-auto d-print-none'>"
                                          + "Balance: " + balance +
                                      "</div>" +
                                      "</div>"
                            tr_str += "</div>"+
                            "</div>"
                            tr_str +=  "<div class='card mt-3'>"+
                                            "<div class='card-body'>"+
                                              "<div id='table-default' class='table-responsive'>"
                              
                            tr_str += "<table class='table' id='example' style='width: 100%;'>"
                            tr_str += "<thead>" +
                                            "<tr>" +
                                              "<th>Date</th>" +
                                              "<th>Reference</th>" +
                                              "<th>Credit</th>" +
                                              "<th>Debit</th>" +
                                            "</tr>"+
                                          "</thead>"+
                                          "<tbody>";
                                           for(var x=0; x<lenledger; x++){

                                                var tdate = response['ledger'][id][x].tdate;
                                                var reference_id = response['ledger'][id][x].reference_id;
                                                var credit = parseInt(response['ledger'][id][x].credit);
                                                var debit = parseInt(response['ledger'][id][x].debit);

                                              tr_str += "<tr>" +
                                                 "<td>" + tdate +  "</td>" +
                                                 "<td>" + reference_id + "</td>" +
                                                 "<td>" + parseFloat(credit.toFixed(2)).toLocaleString("en-US" , 
                                                           {   minimumFractionDigits: 2
                                                          }) + "</td>" +
                                                                                                           "<td>" + parseFloat(debit.toFixed(2)).toLocaleString("en-US" , 
                                                           {   minimumFractionDigits: 2
                                                          }) + "</td>" +
                                              "</tr>"
                                          }
                      
                                            

                                            tr_str += "</tbody>";
                                            tr_str += "</table>";

                                            tr_str += "</div>" +
                                                  "</div>"+
                                                "</div>";

                                            $("#cl-content").append(tr_str);  
                                  }
                                  
                                              

                                            $('#export').attr('href', 'export?process=allcustomerledger');

                         }
                         else{
                            
                         }
                       }
                     });
                }
                else if(rtdvalue == 2)
                {
                    console.log('test');

                    var customer_id = $('#customer').val();
                    
                    $.ajax({
                       url: '/report-customer-ledger?show=1&id=' + customer_id,
                       type: 'get',
                       dataType: 'json',
                       success: function(response){
                        $('#cl-content').empty();
                        console.log(response['customer']);
                         var len = 0;
                         if(response['customer'] != null){
                            len = response['customer'].length;
                            lenledger = response['ledger'].length;
                         }

                         if(len > 0){
                            for(var i=0; i<len; i++){

                              var id = response['customer'][i].id;
                              lenledger = response['ledger'][id].length;

                              var balance = response['ledger']['balance'][id][0].totalbalance;

                              console.log(balance)
                            var tr_str = "<div class='row row-cards mt-3'>"+
                                  "<div class='col-lg-12'>"
                            tr_str += "<div id='alert' class='alert alert-secondary alert-dismissible' role='alert'>"
                                      + "<div class='d-flex'>"
                            tr_str += "<div>" + response['customer'][i].firstname + " " + response['customer'][i].lastname + "</div>" 
                            tr_str += "<div class='col-auto ms-auto d-print-none'>"
                                          + "Balance: " + balance +
                                      "</div>" +
                                      "</div>"
                            tr_str += "</div>"+
                            "</div>"
                            tr_str +=  "<div class='card mt-3'>"+
                                            "<div class='card-body'>"+
                                              "<div id='table-default' class='table-responsive'>"
                              
                            tr_str += "<table class='table' id='example' style='width: 100%;'>"
                            tr_str += "<thead>" +
                                            "<tr>" +
                                              "<th>Date</th>" +
                                              "<th>Reference</th>" +
                                              "<th>Credit</th>" +
                                              "<th>Debit</th>" +
                                            "</tr>"+
                                          "</thead>"+
                                          "<tbody>";
                                           for(var x=0; x<lenledger; x++){

                                                var tdate = response['ledger'][id][x].tdate;
                                                var reference_id = response['ledger'][id][x].reference_id;
                                                var credit = parseInt(response['ledger'][id][x].credit);
                                                var debit = parseInt(response['ledger'][id][x].debit);

                                              tr_str += "<tr>" +
                                                 "<td>" + tdate +  "</td>" +
                                                 "<td>" + reference_id + "</td>" +
                                                 "<td>" + parseFloat(credit.toFixed(2)).toLocaleString("en-US" , 
                                                           {   minimumFractionDigits: 2
                                                          }) + "</td>" +
                                                                                                           "<td>" + parseFloat(debit.toFixed(2)).toLocaleString("en-US" , 
                                                           {   minimumFractionDigits: 2
                                                          }) + "</td>" +
                                              "</tr>"
                                          }
                      
                                            

                                            tr_str += "</tbody>";
                                            tr_str += "</table>";

                                            tr_str += "</div>" +
                                                  "</div>"+
                                                "</div>";

                                            $("#cl-content").append(tr_str);  
                                  }
                                  
                                              

                                            $('#export').attr('href', 'export?process=allcustomerledger&id=' + customer_id);

                         }
                         else{
                            
                         }
                       }
                     });
                }
            } );
            $('#rtd').on('change', function() {
                $('#preview').removeAttr('disabled');

                var rtdvalue = $('#rtd').val();

                if(rtdvalue == 2)
                {
                    $.ajax({
                           url: '/report-customer-ledger?show=2',
                           type: 'get',
                           dataType: 'json',
                           success: function(response){
                              $('#customer').empty();
                              var len = 0;
                             if(response['customer'] != null){
                                len = response['customer'].length;
                             }

                             if(len > 0){

                                for(var i=0; i<len; i++){

                                  var tr_str = "<option value=" + response['customer'][i].id + ">" + response['customer'][i].firstname + ' ' + response['customer'][i].lastname + "</option>"

                                  $("#customer").append(tr_str); 
                                }

                                
                             }
                           }
                    })
                }
                else
                {
                    $('#customer').empty();
                }
            });
        });
      </script>
      
  @endsection