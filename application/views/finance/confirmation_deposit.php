<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
<style type="text/css">
  .divfilterdate, .divbkbm {
    border: 1px solid #0073b7; 
    display: none;
    padding: 4px; 
    margin: 5px 0px;
    overflow: auto;
  }
  .rowlist, .rowtext { margin-top: 6px; }
  .transaction, .transaction2 {margin-top: 2px;}
  .martop-4 {margin-top: 4px;}
  @media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 100px;
      padding: 5px 15px 5px 5px;
    }
    .form-group span.left2 {
      display: block;
      overflow: hidden;
    }
    .form-group { margin-bottom: 5px; }
  }
</style>

<div class="content-wrapper">

  <div class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row rowtext">
            <div class="col-xs-4">
              <input type="text" class="form-control input-sm atributeid" name="atributeid[]" readonly>
            </div>
            <div class="col-xs-8">
              <div class="input-group input-group-sm">                
                <input type="text" class="form-control input-sm atributevalue" name="atributevalue[]" required="">
                <span class="input-group-btn input-group-atributeConn">
                  <select name="atributeConn[]" class="form-control input-sm atributeConn">
                      <option value="or ">OR</option>
                      <option value="and">AND</option>
                  </select>
                </span>
                <span class="input-group-btn">
                  <button type="button" class="btn btn-primary  add_field" onclick="$(this).closest('.rowtext').remove();">-</button>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="content-header">
    <h1>
      <?php echo $PageTitle.' - '. $MainTitle; ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-fw fa-info-circle" title="HELP"></i>Help</a></li>
    </ol>
  </section>
  <section class="content">
    <div class="box box-solid">
      <div class="box-header">
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="1"><i class="fa fa-fw fa-print"></i> Print</button>
        <a href="#" id="bkbm" class="btn btn-primary btn-xs bkbm" title="PRINT BKBM">Print BKBM</a>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>

        <div class="divfilterdate">
          <form role="form" action="<?php echo current_url();?>" method="post">
            <div class="col-md-6">
              <div class="form-group">
                  <label class="left">Bank</label>
                  <span class="left2">
                    <select class="form-control input-sm" name="bank" id="bank">
                      <option value="0" >All</option>
                    </select>
                  </span>
              </div>
              <div class="form-group">
                <label class="left">Search</label>
                <span class="left2">
                  <div class="input-group input-group-sm">
                      <select class="form-control input-sm atributelist" style="width: 100%;" name="atributelist" required="">
                        <option value="BankTransactionID">ID</option>
                        <option value="BankBranch">Branch</option>
                        <option value="BankTransactionNote">Note</option>
                        <option value="Customer">Customer</option>
                      </select>
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-primary  add_field" onclick="createattribute();">+</button>
                      </span>
                  </div>
                </span>
                <label id="atributelabel"></label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  <label class="left">Start</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar">
                      </i>
                    </div>
                    <input type="text" class="form-control input-sm" autocomplete="off" name="filterstart" id="filterstart">
                  </div>
              </div>
              <div class="form-group">
                  <label class="left">End</label>
                  <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar">
                        </i>
                      </div>
                      <input type="text" class="form-control input-sm" autocomplete="off" name="filterend" id="filterend">
                  </div>
              </div>
            </div>
            <div class="col-md-12" style="text-align: center;">
              <button type="submit" class="btn btn-primary btn-sm">Submit</button>
            </div>
          </form>
        </div>
        <div class="divbkbm">
          <form role="form" action="<?php echo base_url();?>finance/print_bkbm" method="post" target="_blank">
              <div class="box box-solid ">
                  <div class="box-header">
                    <h3 class="box-title">PRINT BKBM</h3>
                    <button type="submit" class="btn btn-primary btn-sm pull-right">Submit</button>
                  </div>
                  <div class="box-body">
                      <div class="col-md-6">
                        <div class="form-group">
                        <label class="left">Bank</label>
                        <span class="left2">
                          <select class="form-control input-sm" name="bank" id="bank2"></select>
                        </span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="left">Date</label>
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar">
                            </i>
                          </div>
                          <input type="text" class="form-control input-sm" autocomplete="off" name="bmdate" id="bmdate">
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
          </form>
        </div>
      </div>
      
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
            <tr>
              <th class=" alignCenter">ID</th>
              <th class=" alignCenter"> Date</th>
              <th class=" alignCenter"> Bank</th>
              <th class=" alignCenter"> Branch</th>
              <th class=" alignCenter"> Note</th>
              <th class=" alignCenter"> Amount</th>
              <th class=" alignCenter"> Customer</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
                // echo count($content);
                foreach ($content as $row => $list) {
                  if ($list['fullname'] == "") {
                    $list['fullname'] = "Not Confirmed yet";
                  }; ?>
                  <tr>
                    <td><?php echo $list['BankTransactionID'];?></td>
                    <td><?php echo date('Y-m-d', strtotime($list['BankTransactionDate']));?></td>
                    <td><?php echo $list['BankName'];?></td>
                    <td class=" alignCenter"><?php echo $list['BankBranch'];?></td>
                    <td><?php echo $list['BankTransactionNote'];?></td>
                    <td class="dtAlignRight"><?php echo number_format($list['BankTransactionAmount'],2);?></td>
                    <?php 
                      if ($list['DepositCustomer'] == null) { ?>
                      <td style="font-weight: bold; color: #f39c12;"><?php echo "NotYetConfirmed";?></td>
                    <?php } else { ?>
                      <td style="font-weight: bold; color: #00a65a;">
                        <a href="<?php echo base_url();?>finance/customer_deposit_detail?id=<?php echo $list['CustomerID'];?>" target="_blank"><?php echo $list['fullname'];?></a>
                      </td>
                    <?php }  ?>
                    <td>
                      <?php if ($list['fullname'] == "Not Confirmed yet") { ?>
                        <a href="<?php echo base_url();?>finance/confirmation_deposit_distribution?id=<?php echo $list['BankTransactionID'];?>" class="btn btn-primary btn-xs sale" style="margin: 0px;" title="Confirm To Customer"><i class="fa fa-fw fa-dollar"></i></a>
                      <?php } ?>
                      <?php if ($list['DepositID'] != "") { ?>
                        <a href="#" class="dtbutton button btn-xs btn-primary view_deposit" data-toggle="modal" data-target="#modal-detail" title="VIEW DEPOSIT DISTRIBUTION" deposit="<?php echo $list['DepositID'];?>"><i class="fa fa-fw fa-info"></i></a>
                      <?php } ?>
                    </td>
                  </tr>
            <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5">
                      Total Current Page:<br>
                      Total All Page:<br>
                    </th>
                    <th class="alignRight"></th>
                    <th colspan="2"></th>
                </tr>
            </tfoot>
          </table>
      </div>

      <div class="modal fade" id="modal-detail">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Detail Deposit</h4>
            </div>
            <div class="modal-body">
              <div class="loader"></div>
              <div id="detailcontentAjax"></div>
            </div>
            <div class="modal-footer"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery11.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
var j11 = $.noConflict(true);
j11( document ).ready(function( $ ) {
  var rows_selected = []; // for adding checkbox
  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "columnDefs": [ 
    {"targets": 6, "orderable": false, "width": "1%"},
    {"targets": 0, "width": "1%"},
    ],
    // "aaSorting": [],
    "order": [[ 0, "desc" ]],
    "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };

        // Total over all pages
        total5 = api
            .column( 5 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 ); 

        // Total over this page
        pageTotal5 = api
            .column( 5, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 ); 

        // Update footer
        $( api.column( 5 ).footer() ).html(
            pageTotal5.toLocaleString(undefined, {minimumFractionDigits: 2}) +
            '<br>'+ total5.toLocaleString(undefined, {minimumFractionDigits: 2})
        ); 
    }
  })

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  };
  $('#dt_list').resize(cek_dt);
  $('button.print_dt').on('click', function() {               
      var fvData = table.rows({ search:'applied', page: 'all' }).data(); 
      $('.div_dt_print').empty().append(
         '<table id="dtTablePrint" class="col">' +
         '<thead>'+
         '<tr>'+
            $.map(table.columns().visible(),
                function(colvisible, colindex){
                   return (colvisible) ? "<th>" + $(table.column(colindex).header()).html() + "</th>" : null;
             }).join("") +
         '</tr>'+
         '</thead>'+
         '<tbody>' +
            $.map(fvData, function(rowdata, rowindex){
               return "<tr>" + $.map(table.columns().visible(),
                  function(colvisible, colindex){
                     return (colvisible) ? "<td class='col"+colindex+"'>" + $('<div/>').text(rowdata[colindex]).text() + "</td>" : null;
                  }).join("") + "</tr>";
            }).join("") +
         '</tbody>' +
         '<tfoot>' +
         '<tr>'+
            $.map(table.columns().visible(),
                function(colvisible, colindex){
                   return (colvisible) ? "<th>" + $(table.column(colindex).footer()).html() + "</th>" : null;
             }).join("") +
         '</tr>'+
         '</tfoot></table>'
      );

      for (var i = 0; i < $('button.print_dt').attr('removeTd'); i++) {
        $("#dtTablePrint th:last-child, #dtTablePrint td:last-child").remove();
      }

      var w = window.open();
      var html = $(".div_dt_print").html();
      $(w.document.body).append('<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">');
      $(w.document.body).append("<link href='<?php echo base_url();?>tool/dtPrint.css' rel='stylesheet' type='text/css' />");
      $(w.document.body).append(html);
  });
});
</script>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script>
var j8 = $.noConflict(true);
j8( document ).ready(function( $ ) {
  fill_transaction();
   
  
  $("#filterstart").datepicker({ 
    "setDate": new Date(), 
    autoclose: true, 
    format: 'yyyy-mm-dd',
    todayBtn:  1,
  }).on('changeDate', function (selected) {
      var minDate = new Date(selected.date.valueOf());
      $('#filterend').datepicker('setStartDate', minDate);
  });
  $("#filterend").datepicker({ 
    "setDate": new Date(), 
    autoclose: true, 
    format: 'yyyy-mm-dd',
  }).on('changeDate', function (selected) {
    var maxDate = new Date(selected.date.valueOf());
    $('#filterstart').datepicker('setEndDate', maxDate);
  });
  $("#bmdate").datepicker({ 
    "setDate": new Date(), 
    autoclose: true, 
    format: 'yyyy-mm-dd',
  });
  
  $(".filterdate").click(function(){
    $(".divfilterdate").slideToggle();
  });
  $(".bkbm").click(function(){
    $(".divbkbm").slideToggle();
  });
  $('.edit').live('click',function(e){
    par   = $(this).parent().parent();
    id    = par.find("td:nth-child(1)").html();
    name  = par.find("td:nth-child(2)").html();
    $("#id").val(id);
    $("#name2").val(name);

    len = $('.transaction2').length;
    for( var i = 1; i<len; i++){
      if ($('.transaction2').length != 1) { $('.transaction2:last').remove();}
    }
    $.ajax({
      url: '<?php echo base_url();?>master/get_bank_transaction_value',
      type: 'post',
      data: {id:id},
      dataType: 'json',
      success:function(response){
        len = response.length;
        for( var i = 0; i<len; i++){
          console.log(i);
          $("select.transactionchild2:last").val(response[i]);
          $(".transactionchild2:last").prop("disabled", true);
          $(".transaction2:last").clone().insertAfter(".transaction2:last");
        }
        $('.transaction2:last').remove();
      }
    });
    $( ".form-editbank_transaction" ).slideDown( "slow", function() { });
  });
  $('.form-editbank_transaction form').live('submit', function() {
      $(this).find(':disabled').removeAttr('disabled');
  });

  function fill_transaction() {
    $.ajax({
      url: '<?php echo base_url();?>finance/fill_transaction',
      type: 'post',
      dataType: 'json',
      success:function(response){
        var len = response.length;
        for( var i = 0; i<len; i++){
          var BankName = response[i]['BankName'];
          var BankID = response[i]['BankID'];
          $("#bank").append("<option value='"+BankID+"'>"+BankName+"</option>");
          $("#bank2").append("<option value='"+BankID+"'>"+BankName+"</option>");
        }
      }
    });
  }
});

function createattribute() {
  atributelist = $(".atributelist").val()
  $(".rowtext:first .atributeid").val(atributelist);
  $(".rowtext:first").clone().insertBefore('#atributelabel');
}


j8('.view_deposit').live('click',function(e){
    id  = $(this).attr("deposit");
    $('.loader').slideDown("fast")
    $('#detailcontentAjax').empty()
    get(id)
});

function get(id) {
  xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>finance/customer_deposit_detail_full"
    url=url+"?id="+id
    xmlHttp.onreadystatechange=stateChanged
    xmlHttp.open("GET",url,true)
    xmlHttp.send(null)
}
function stateChanged(){
    if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
        $('.loader').slideUp("fast")
        document.getElementById("detailcontentAjax").innerHTML=xmlHttp.responseText
    }
}
function GetXmlHttpObject(){
    var xmlHttp=null;
    try{
        xmlHttp=new XMLHttpRequest();
    }catch(e){
        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    return xmlHttp;
}
</script>