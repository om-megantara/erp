<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">

<style type="text/css"> 
  /*css fixed column*/
  .DTFC_LeftWrapper thead th, .DTFC_RightWrapper thead th,
  .DTFC_LeftWrapper tbody td, .DTFC_RightWrapper tbody td {
    font-size: 12px !important;
  }
  .DTFC_LeftWrapper tbody td, .DTFC_RightWrapper tbody td {
    padding: 4px !important;
    vertical-align: text-top;
    height: 28px;
  }
  /*.DTFC_LeftBodyLiner{overflow-y:unset !important}*/
  /*.DTFC_RightBodyLiner{overflow-y:unset !important}*/
  /*---------------------*/
 
  #divhideshow, .divfilterdate { 
    display: none; 
    margin: 5px 0px; 
    border: 1px solid #0073b7; 
    padding: 5px; 
    overflow: auto;
  }

  .loader {
    margin: auto;
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid blue;
    border-bottom: 16px solid blue;
    width: 120px;
    height: 120px;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
  }
  @-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
  }
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  /*-------------------------------*/
  
  .rowlist, .rowtext { margin-top: 6px; }
@media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 80px;
      padding: 5px 15px 5px 5px;
    }
    .form-group { margin-bottom: 10px; }
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
      <li><a title="HELP" class="btn btn-warning btn-xs" href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>

  <section class="content">
    <div class="box box-solid">
      <div class="box-header">
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="2"><i class="fa fa-fw fa-print"></i> Print</button>
        <a title="ADD INVOICE" href="<?php echo base_url();?>transaction/detail_to_invoice" id="add_invoice" class="btn btn-primary btn-xs add_invoice"><b>+</b> Add Invoice</a>
        <a href="#" id="column" class="btn btn-primary btn-xs column" title="HIDE/SHOW COLUMN">Hide/Show Column</a>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>

        <div id="divhideshow">
          Hide/Show Column :
          <a class="btn btn-primary btn-xs toggle-vis" data-column="3" title="SALES NAME">Sales Name</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="4" title="INVOICE DATE">Invoice Date</a>
        </div>
        <div class="divfilterdate">
          <form role="form" action="<?php echo current_url();?>" method="post" >
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Search</label>
                <span class="left2">
                  <div class="input-group input-group-sm">
                      <select class="form-control input-sm atributelist" style="width: 100%;" name="atributelist" required="">
                        <option value="INVID">Invoice ID</option>
                        <option value="DOID">DO ID</option>
                        <option value="SOID">SO ID</option>
                        <option value="Company">Customer</option>
                        <option value="Sales">Sales Name</option>
                        <option value="ProductID">Product ID</option>
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
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm" autocomplete="off" name="filterstart" id="filterstart">
                </div>
              </div>
              <div class="form-group">
                <label class="left">End</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm" autocomplete="off" name="filterend" id="filterend">
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <center>
                <button type="submit" class="btn btn-primary btn-sm pull-center">Submit</button>
              </center>
            </div>
          </form>
        </div>     
      </div>
      
      <div class="box-body">
        <table id="dt_list" class="table table-bordered " style="width: 100% !important;">
          <thead>
            <tr>
              <th class=" alignCenter">Invoice</th>
              <th class=" alignCenter">DO / SO</th>
              <th class=" alignCenter">Company</th>
              <th class=" alignCenter">Sales Name</th>
              <th class=" alignCenter">Invoice Date</th>
              <th class=" alignCenter">PT</th>
              <th class=" alignCenter">Due Date</th>
              <th class=" alignCenter">Invoice Product</th>
              <th class=" alignCenter">Invoice FC</th>
              <th class=" alignCenter">Invoice Amount</th>
              <th class=" alignCenter">Paid</th>
              <th class=" alignCenter">Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
            if (isset($content)) {
                foreach ($content as $row => $list) { ?>
                <tr>
                  <td class=" alignCenter"><?php echo $list['INVID'];?></td>
                  <td><?php echo $list['DOID']." / ".$list['SOID'];?></td>
                  <td><?php echo $list['customer'];?></td>
                  <td><?php echo $list['sales'];?></td>
                  <td class=" alignCenter"><?php echo $list['INVDate'];?></td>
                  <td class=" alignCenter"><?php echo ($list['TotalPayment'] < $list['INVTotal'] ? $list['PaymentTerm'] : 0);  ;?></td>
                  <td><?php echo $list['datediff']." days"." / ".$list['due_date'];?></td>
                  <td class="alignRight"><?php echo number_format($list['PriceTotal']+$list['FCInclude']+$list['FCTax'],2);?></td>
                  <td class="alignRight"><?php echo number_format($list['FCExclude'],2);?></td>
                  <td class="alignRight"><?php echo number_format($list['INVTotal'],2);?></td>
                  <td><?php echo $list['TotalPaymentPerc']." % / ".number_format($list['TotalPayment'],2);?></td>
                  <td>
                      <button type="button" class="btn btn-warning btn-xs printfc" title="PRINT FC" invid="<?php echo $list['INVID'];?>"><i class="fa fa-fw fa-print"></i></button>
                      <button type="button" class="btn btn-primary btn-xs printinvn3" title="PRINT INVOICE NEW" invid="<?php echo $list['INVID'];?>"><i class="fa fa-fw fa-print"></i></button>
                      <?php if (in_array("print_without_header", $MenuList)) {?>
                      <button type="button" class="btn btn-primary btn-xs printinvn2" title="PRINT INVOICE OFFLINE" invid="<?php echo $list['INVID'];?>"><i class="fa fa-fw fa-print"></i></button>
                      <?php } else { ?>
                      <button type="button" class="btn btn-primary btn-xs printinvn" title="PRINT INVOICE NORMAL" invid="<?php echo $list['INVID'];?>"><i class="fa fa-fw fa-print"></i></button>
                      <?php } ?>
                      <button type="button" class="btn btn-warning btn-xs printinv" title="PRINT INVOICE" invid="<?php echo $list['INVID'];?>"><i class="fa fa-fw fa-print"></i></button>

                      <?php if ($list['FakturNumber']>0) { ?>
                      <button type="button" class="btn btn-warning btn-xs printfaktur" title="PRINT FAKTUR" invid="<?php echo $list['INVID'];?>"><i class="fa fa-fw fa-print"></i></button>
                      <?php } ?>
                      <!-- <button type="button" class="btn btn-danger btn-xs printinv_coba" title="PRINT INVOICE PDF" invid="<?php echo $list['INVID'];?>"><i class="fa fa-fw fa-print"></i></button> -->

                      <button type="button" class="btn btn-primary btn-xs paymenthistory" title="PAYMENT HISTORY" invid="<?php echo $list['INVID'];?>" data-toggle="modal" data-target="#modal-detail" ><i class="fa fa-fw fa-info"></i></button>
                      <button type="button" class="btn btn-primary btn-xs dohistory" title="DO HISTORY" doid="<?php echo $list['DOID'];?>" data-toggle="modal" data-target="#modal-detail" ><i class="fa fa-fw fa-info"></i></button>

                      <?php if ($list['TotalPayment'] < $list['INVTotal']) { ?>
                        <button type="button" class="btn btn-success btn-xs" title="PAYMENT FROM SO DEPOSIT" onclick="window.open('<?php echo base_url();?>finance/invoice_payment?id=<?php echo $list['INVID']; ?>', '_blank');"><i class="fa fa-fw fa-usd"></i></button>
                        <button type="button" class="btn btn-success btn-xs" title="PAYMENT FROM GENERAL DEPOSIT" onclick="window.open('<?php echo base_url();?>finance/customer_deposit_detail?id=<?php echo $list['CustomerID']; ?>', '_blank');"><i class="fa fa-fw fa-usd"></i></button>
                        <button type="button" class="btn btn-danger btn-xs complete_payment" title="COMPLETE PAYMENT" invid="<?php echo $list['INVID']; ?>"><i class="fa fa-fw fa-usd"></i></button>
                      <?php } ?>
                      <?php if ($list['TotalPayment'] > $list['INVTotal']) { ?>
                        <button type="button" class="btn btn-warning btn-xs retur_payment" title="RETUR PAYMENT" onclick="window.open('<?php echo base_url();?>finance/retur_payment_inv?id=<?php echo $list['INVID']; ?>', '_blank');"><i class="fa fa-fw fa-usd"></i></button>
                      <?php } ?>
                      <!-- <button type="button" class="btn btn-danger btn-xs retur" onclick="window.open('<?php echo base_url();?>transaction/delivery_order_received_add?doid=<?php echo $list['DOID']; ?>', '_blank');" title="RETUR"><i class="fa fa-fw fa-cart-arrow-down"></i></button> -->
                  </td>
                </tr>
          <?php } } ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="modal fade" id="modal-detail">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="loader"></div>
            <div id="detailcontentAjax"></div>
          </div>
          <div class="modal-footer"></div>
        </div>
      </div>
    </div>

  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>

<script>
jQuery( document ).ready(function( $ ) {
	 

  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
    "order": [[ 0, "desc" ]],
    "scrollX": true,
    "scrollY": true,
    "scrollCollapse": true,
    "fixedColumns": {
        leftColumns: 1,
        rightColumns: 1,
    }, 
  })
  $('a.toggle-vis').on( 'click', function (e) {
      e.preventDefault();
      var column = table.column( $(this).attr('data-column') );
      column.visible( ! column.visible() );
      table.columns.adjust().draw();
  } );

  var cek_dt = function() {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);
  

  setTimeout( function order() {
    // $('a[data-column="3"]').click();
    $('a[data-column="4"]').click();
  }, 100)

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
  $(".filterdate").click(function(){
    $(".divfilterdate").slideToggle();
  });
  $("#column").click(function(){
    $("#divhideshow").slideToggle();
  });

  $('.paymenthistory').live('click',function(e){
      INVID = $(this).attr("invid");
      get(INVID, "paymenthistory")
      $('.loader').slideDown("fast")
      $('#detailcontentAjax').empty()
  });
  $('.dohistory').live('click',function(e){
      DOID = $(this).attr("doid");
      get(DOID, "dohistory")
      $('.loader').slideDown("fast")
      $('#detailcontentAjax').empty()
  });

  function get(id,info) {
    xmlHttp=GetXmlHttpObject()
    if (info == "paymenthistory") {
      var url="<?php echo base_url();?>finance/invoice_payment_detail"
      url=url+"?id="+id
    }
    if (info == "dohistory") {
      var url="<?php echo base_url();?>transaction/do_history"
      url=url+"?id="+id
    }
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

  var popup;
  function openPopupOneAtATime(x,y) {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>transaction/'+y+'?id='+x;
      } else {
         popup = window.open('<?php echo base_url();?>transaction/'+y+'?id='+x, '_blank', 'width=800,height=650,left=200,top=20');     
      }
  }
  function openPopupOneAtATime2(x,y) {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>transaction/'+y+'?id='+x;
      } else {
         popup = window.open('<?php echo base_url();?>transaction/'+y+'?id='+x, '_blank', 'width=800,height=650,left=200,top=20');     
      }
  }
  $(".printfc").live('click', function() {
    invid = $(this).attr("invid")
    openPopupOneAtATime(invid,"print_freight_charge");
  });
  $(".printinv").live('click', function() {
    invid = $(this).attr("invid")
    openPopupOneAtATime2(invid,"print_invoice2");
  });
  $(".printinvn2").live('click', function() {
    invid = $(this).attr("invid")
    openPopupOneAtATime2(invid,"print_invoice_offline");
  });
  $(".printinvn3").live('click', function() {
    invid = $(this).attr("invid")
    openPopupOneAtATime2(invid,"print_invoice_offline_new");
  });
  $(".printinvn").live('click', function() {
    invid = $(this).attr("invid")
    openPopupOneAtATime(invid,"print_invoice");
  });
  $(".printfaktur").live('click', function() {
    invid = $(this).attr("invid")
    openPopupOneAtATime(invid,"print_faktur");
  });

  $(".complete_payment").live('click', function() {
    INVID = $(this).attr("invid")
    $.ajax({
      url: "<?php echo base_url();?>transaction/complete_payment_under",
      type : 'POST',
      data: {INVID: INVID},
      dataType : 'json',
      success : function (response) {
        if (response['result'] === "succes") {
          alert("Repayment Successful")
          location.reload();
        } else {
          alert("Less invoice over than Rp.100 or Customer punya deposit")
        }
      }
    })
  });
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
  function createattribute() {
    atributelist = $(".atributelist").val()
    $(".rowtext:first .atributeid").val(atributelist);
    $(".rowtext:first").clone().insertBefore('#atributelabel');
  }
</script>