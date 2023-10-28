<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">

<style type="text/css">
  /*css fixed column*/
  .DTFC_LeftWrapper thead th, .DTFC_RightWrapper thead th,
  .DTFC_LeftWrapper tbody td, .DTFC_RightWrapper tbody td,
  .DTFC_LeftWrapper tfoot th, .DTFC_RightWrapper tfoot th {
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
 
  .modal-info-warning {
    color: red;
    margin-top: 1px !important;
    margin-bottom: 1px !important;
  } 
  #divhideshow, .divfilterdate { 
    display: none; 
    margin: 5px 0px; 
    border: 1px solid #0073b7; 
    padding: 5px; 
    overflow: auto;
  }
  .martop-4 { margin-top: 4px; }
  .rowlist, .rowtext { margin-top: 6px; }

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

  input.inputFile {
    width: 100%;
    display: inline-block;
    background: white;
    padding: 3px 0px;
    border: 1px solid #ccc;
    /*text-indent: -100px;*/
    outline: 0 !important;
    cursor: pointer;
  }
  
  .formFile .col-xs-6, .formFileOld .col-xs-6,
  .formFile .col-xs-12, .formFileOld .col-xs-12 {
    padding-bottom: 3px;
  }
</style>
<div class="content-wrapper">

  <div class="modal fade" id="modal-cancel">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">CANCEL SO</h4>
              <h6 class="modal-info-warning">*) Canceling SO will be delete all allocated deposits.</h6>
              <h6 class="modal-info-warning">*) SO cancellation cannot be done if there is already a DO.</h6>
          </div>
          <form action="<?php echo base_url();?>transaction/sales_order_cancel" method="post">
            <div class="modal-body">
              <div class="form-group">
                  <input type="text" class="form-control soid" name="soid" placeholder="SO ID" readonly="">
              </div>
              <div class="form-group">
                <textarea class="form-control cancel-note" rows="3" name="note" placeholder="Cancel Note"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-note">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">SO Permit Note</h4>
          </div>
          <form action="<?php echo base_url();?>transaction/sales_order_permit_note" method="post">
            <div class="modal-body">
              <div class="form-group">
                <input type="text" class="form-control soid" name="soid" placeholder="SO ID" readonly="">
              </div>
              <div class="form-group">
                <textarea class="form-control permit-note" rows="3" name="note" placeholder="Note"></textarea>
              </div>
              <div class="approval_status"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-tax-note">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Tax Address</h4>
          </div>
          <form action="<?php echo base_url();?>transaction/sales_order_tax_note" method="post">
            <div class="modal-body">
              <div class="form-group">
                  <input type="text" class="form-control soid" name="soid" placeholder="SO ID" readonly="">
              </div>
              <div class="form-group">
                  <input type="text" class="form-control name" name="name" placeholder="Name">
              </div>
              <div class="form-group">
                  <input type="text" class="form-control npwp" name="npwp" placeholder="NPWP">
              </div>
              <div class="form-group">
                <textarea class="form-control tax-note" rows="3" name="note" placeholder="Note"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
      </div>
    </div>
  </div>
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
  <div class="modal fade" id="modal-file">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Attach File & Invoice MP</h4>
          </div>
          <div class="modal-body"> 
            <div class="loader"></div>
            <div class="detailcontentAjax" id="detailcontentFile" style="background-color: white;"></div>
          </div>
          <div class="modal-footer">
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
        <a title="ADD SALES ORDER" href="<?php echo base_url();?>transaction/sales_order_add" id="add_sales_order" class="btn btn-primary btn-xs add_sales_order"><b>+</b> Add Sales Order</a>
        <?php if (in_array("sales_order_offline_add", $MenuList)) {?>
        <a title="ADD SALES ORDER OFFLINE" href="<?php echo base_url();?>transaction/sales_order_offline_add" id="add_sales_order" class="btn btn-primary btn-xs add_sales_order"><b>+</b> Add SO Offline</a>
        <?php }?>
        <?php if (in_array("sales_order_online_add", $MenuList)) {?>
        <a title="ADD SALES ORDER ONLINE" href="<?php echo base_url();?>transaction/sales_order_online_add" id="add_sales_order" class="btn btn-primary btn-xs add_sales_order"><b>+</b> Add SO Online</a>
        <?php }?>
        <a href="#" id="hideshow" class="btn btn-primary btn-xs hideshow" title="HIDE/SHOW COLUMN">Hide/Show Column</a>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>
        <div class="divfilterdate">
          <form role="form" action="<?php echo current_url();?>" method="post" >
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Status</label>
                <span class="left2">
                    <select class="form-control input-sm" name="status">
                      <option value="2">All</option>
                      <option value="1">Confirm</option>
                      <option value="0">Not Confirm</option>
                    </select>
                </span>
              </div>
              <div class="form-group">
                <label class="left">Type</label>
                <span class="left2">
                    <select class="form-control input-sm" name="type">
                      <option value="all">All</option>
                      <option value="standard">Standard</option>
                      <option value="custom">Custom</option>
                    </select>
                </span>
              </div>
              <div class="form-group">
                <label class="left">Search</label>
                <span class="left2">
                  <div class="input-group input-group-sm">
                      <select class="form-control input-sm atributelist" style="width: 100%;" name="atributelist" required="">
                        <option value="SOID">SO ID</option>
                        <option value="Company">Customer</option>
                        <option value="Sales">Sales</option>
                        <option value="Category">Category</option>
                        <option value="ProductID">Product ID</option>
                        <option value="ProductName">Product Name</option>
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
                    <input type="text" class="form-control input-sm" autocomplete="off" name="filterstart" id="filterstart" >
                  </div>
                </div>
                <div class="form-group">
                  <label class="left">End</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control input-sm" autocomplete="off" name="filterend" id="filterend" >
                  </div>
                </div>
            </div>
            <div class="col-md-12">
              <center>
                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
              </center>
            </div>
          </form>
        </div>

        <div id="divhideshow">
          Hide/Show Column :
          <a class="btn btn-primary btn-xs toggle-vis" data-column="0">SO ID</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="1">Company</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="2">Sales</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="3">Category</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="4">Total</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="5">Deposit</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="6">Payment (%)</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="7">Order</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="8">Schedule</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="9">Quantity</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="10">DO</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="11">OutStndng</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="12">Status</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="13">Action</a>
        </div>
      </div>

      <div class="box-body">
        <table id="dt_list" class="table table-bordered " style="width: 100% !important;">
          <thead>
            <tr>
              <th class=" alignCenter">SO ID</th>
              <th class=" alignCenter">Company Name</th>
              <th class=" alignCenter">Sales Name</th>
              <th class=" alignCenter">Category</th>
              <th class=" alignCenter">Total</th>
              <th class=" alignCenter">Deposit (%)</th>
              <th class=" alignCenter">Payment (%)</th>
              <th class=" alignCenter">Order</th>
              <th class=" alignCenter">Schedule</th>
              <th class=" alignCenter">Quantity</th>
              <th class=" alignCenter">DO</th>
              <th class=" alignCenter">OutStndng</th>
              <th class=" alignCenter">Invoice MP</th>
              <th class=" alignCenter">Status</th>
              <th class=" alignCenter">Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
            // echo count($content);
            if (isset($content['main'])) {
                foreach ($content['main'] as $row => $list) { ?>
                <tr>
                  <td class=" alignCenter"><?php echo $list['SOID'];?></td>
                  <td><?php echo '('.$list['PaymentWay'].') '.$list['Company'];?></td>
                  <td><?php echo $list['salesname'];?></td>
                  <td><?php echo $list['CategoryName'].' ('.$list['SOType'].')';?></td>
                  <td class="alignRight"><?php echo number_format($list['SOTotal'],2);?></td>
                  <td><?php echo "<b>".$list['TotalDepositPerc']." % /</b> ".number_format($list['TotalDeposit'],2);?></td>
                  <td><?php echo "<b>".$list['TotalPaymentPerc']." % /</b> ".number_format($list['TotalPayment'],2);?></td>
                  <td class=" alignCenter"><?php echo $list['SODate'];?></td>
                  <td class=" alignCenter"><?php echo $list['SOShipDate'];?></td>
                  <td><?php echo $list['qty'];?></td>
                  <td><?php echo $list['totaldo'];?></td>
                  <td><?php echo $list['outstanding'];?></td>
                  <td><?php echo $list['INVMP'];?></td>
                  <td class=" alignCenter">
                    <?php if ($list['SOConfirm1'] == "1") { ?>
                      <i class="fa fa-fw fa-check-square-o" style="color: green;" title="CONFIRM1"></i>
                      <span style="display:none;">CONFIRM1</span>
                    <?php } ?>
                    <?php if ($list['SOConfirm2'] == "1") { ?>
                      <i class="fa fa-fw fa-check-square-o" style="color: green;" title="CONFIRM2"></i>
                      <span style="display:none;">CONFIRM2</span>
                    <?php } ?>
                    <?php if ($list['SOStatus'] == "0") { ?>
                      <i class="fa fa-fw fa-times" style="color: red;" title="CANCEL"></i>
                      <span style="display:none;">CANCEL</span>
                    <?php } ?>
                  </td>
                  <td>

                    <?php if ($list['SOStatus'] == "2") { ?>
                      <button type="button" class="btn btn-success btn-xs goApproval" title="goApproval" so="<?php echo $list['SOID'];?>"><i class="fa fa-fw fa-sign-out"></i></button>
                    <?php } ?>
                    
                    <button type="button" class="btn btn-primary btn-xs attachFile" title="ATTACH FILE & INVOICE MP" soid="<?php echo $list['SOID']; ?>" data-toggle="modal" data-target="#modal-file"><i class="fa fa-fw fa-list-ol"></i></button>
                    <?php if (in_array("print_without_header", $MenuList)) {?>
                    <button type="button" class="btn btn-warning btn-xs printso2" title="PRINT OFFLINE" soid="<?php echo $list['SOID'];?>"><i class="fa fa-fw fa-print"></i></button>
                    <?php } else { ?>
                    <button type="button" class="btn btn-warning btn-xs printso" title="PRINT" soid="<?php echo $list['SOID'];?>"><i class="fa fa-fw fa-print"></i></button>
                    <?php } ?>

                    <!-- <button type="button" class="btn btn-danger btn-xs printsocoba" title="PRINT PDF" soid="<?php echo $list['SOID'];?>"><i class="fa fa-fw fa-print"></i></button> -->
                    <button type="button" class="btn btn-primary btn-xs taxnote" title="TAX NOTE" soid="<?php echo $list['SOID']; ?>" data-toggle="modal" data-target="#modal-tax-note"><i class="fa fa-fw fa-sticky-note-o"></i></button>

                    <?php if ($list['SOStatus'] != "0" ) { ?>

                    <?php if ($list['SOConfirm1'] != 1) { ?>
                      <button type="button" class="btn btn-primary btn-xs note" title="PERMIT NOTE" soid="<?php echo $list['SOID']; ?>" data-toggle="modal" data-target="#modal-note"><i class="fa fa-fw fa-sticky-note-o"></i></button>
                    <?php } ?>

                    <?php if ( (($list['TotalDeposit']+$list['TotalPayment']) < $list['SOTotal']) and $list['countSO']<=0 ) { ?>
                      <button type="button" class="btn btn-success btn-xs" title="SET DEPOSIT" onclick="window.open('<?php echo base_url();?>finance/customer_deposit_detail?id=<?php echo $list['CustomerID']; ?>', '_blank');"><i class="fa fa-fw fa-usd"></i></button>
                      <button type="button" class="btn btn-danger btn-xs complete_deposit" title="COMPLETE DEPOSIT" soid="<?php echo $list['SOID']; ?>"><i class="fa fa-fw fa-usd"></i></button>
                    <?php } ?>

                    <?php if ($list['TotalDeposit']>0 && ($list['TotalDeposit']+$list['TotalPayment']) > $list['SOTotal']) { ?>
                      <button type="button" class="btn btn-warning btn-xs retur_deposit" title="RETUR DEPOSIT" onclick="window.open('<?php echo base_url();?>finance/retur_deposit_so?id=<?php echo $list['SOID']; ?>', '_blank');"><i class="fa fa-fw fa-usd"></i></button>
                    <?php } ?>

                    <?php if ( ($list['INVCategory']==1 and $list['outstanding'] < 0) or ( $list['INVCategory']==2 and $list['countSO']==0 )) {  ?>
                      <?php if ($list['SOCategory']==7) { ?>
                        <button type="button" class="btn btn-warning btn-xs" title="EDIT SO OFFLINE" onclick="window.open('<?php echo base_url();?>transaction/sales_order_offline_edit?so=<?php echo $list['SOID']; ?>', '_blank');"><i class="fa fa-fw fa-edit"></i></button>
                      <?php } else { ?>
                        <button type="button" class="btn btn-success btn-xs" title="EDIT" onclick="window.open('<?php echo base_url();?>transaction/sales_order_edit?so=<?php echo $list['SOID']; ?>', '_blank');"><i class="fa fa-fw fa-edit"></i></button>
                      <?php } ?>
                    <?php } ?>

                    <?php if (( $list['INVCategory']==1 and $list['totaldo'] == "0") or ( $list['INVCategory']==2 and $list['countSO']<=0 )) { ?>
                      <button type="button" class="btn btn-danger btn-xs cancel" title="CANCEL" soid="<?php echo $list['SOID']; ?>" data-toggle="modal" data-target="#modal-cancel"><i class="fa fa-fw fa-trash-o"></i></button>
                    <?php } ?>

                    <?php } ?>
                  </td>
                </tr>
          <?php } } ?>
          </tbody>
        </table>
      </div>
    </div>

  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/jquery-ui.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
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
    "order": [[0,'desc']],
    "scrollX": true,
    "scrollY": true,
    "scrollCollapse": true,
    "fixedColumns":   {
        leftColumns: 1,
        rightColumns: 1
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


  $('.cancel').live('click',function(e){
    soid = $(this).attr("soid");
    $('#modal-cancel').find('.soid').val(soid);
  });
  $('.taxnote').live('click',function(e){
    soid = $(this).attr("soid");
    $('#modal-tax-note').find('.soid').val(soid);
    $.ajax({
      url: "<?php echo base_url();?>transaction/get_sales_order_tax_note",
      type : 'GET',
      data: {soid:soid},
      dataType : 'json',
      success : function (response) {
        $('#modal-tax-note').find('.npwp').val(response['NPWP']);
        if (response['TaxAddress'].length > 2) {
          $('#modal-tax-note').find('.name').val(response['TaxAddress'][0]);
          $('#modal-tax-note').find('.tax-note').val(response['TaxAddress'][2]);
        } else {
          $('#modal-tax-note').find('.name').val(response['BillingAddress'][0]);
          $('#modal-tax-note').find('.tax-note').val(response['BillingAddress'][2]);
        }
      }
    })
  });
  $('.note').live('click',function(e){
    soid = $(this).attr("soid");
    $('#modal-note').find('.soid').val(soid);
    $.ajax({
      url: "<?php echo base_url();?>transaction/get_sales_order_permit_note",
      type : 'GET',
      data: {soid:soid},
      dataType : 'json',
      success : function (response) {
        $('#modal-note').find('.invmp').val(response['invmp']);
        $('#modal-note').find('.permit-note').val(response['PermitNote']);
        $('#modal-note').find('.approval_status').html(response['approval_status']);
      }
    })
  });
  $('.detail').live('click', function(e){
      if( $('#detailcontent').length != 0 ){ 
        $('#detailcontent').remove() 
      } else {
        soid  = $(this).attr("soid")
        $('<tr><td colspan="9" class="detailcontentAjax" id="detailcontent"></td></tr>').insertAfter($(this).closest('tr'));
        get(soid);
      }
  }); 
  $(".complete_deposit").live('click', function() {
    SOID = $(this).attr("soid")
    $.ajax({
      url: "<?php echo base_url();?>transaction/complete_deposit_under",
      type : 'POST',
      data: {SOID: SOID},
      dataType : 'json',
      success : function (response) {
        if (response['result'] === "succes") {
          alert("pelunasan berhasil")
          location.reload();
        } else {
          alert("kekurangan invoice melebihi Rp.100 atau Customer punya Deposit Free")
        }
      }
    })
  })
  function get(soid) {
    xmlHttp=GetXmlHttpObject()
      var url="<?php echo base_url();?>transaction/sales_order_detail_full"
      url=url+"?soid="+soid
      // alert(url);
      xmlHttp.onreadystatechange=stateChanged
      xmlHttp.open("GET",url,true)
      xmlHttp.send(null)
  }
  function stateChanged(){
      if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
        $('.loader').slideUp("fast")
        document.getElementById("detailcontent").innerHTML=xmlHttp.responseText
      }
  }


  $('.remove_field_file').live('click', function(e){
      if ($('.formFile').length != 1) {
        $(this).closest('.formFile').remove()
      }
  });
  $('.attachFile').live('click', function(e){
      soid  = $(this).attr("soid")
      $('.loader').slideDown("fast")
      $('#detailcontentFile').empty()
      get2(soid);
  });
  function get2(soid) {
    xmlHttp=GetXmlHttpObject()
      var url="<?php echo base_url();?>transaction/sales_order_file_attach"
      url=url+"?soid="+soid
      // alert(url);
      xmlHttp.onreadystatechange=detailcontentFile
      xmlHttp.open("GET",url,true)
      xmlHttp.send(null)
  }
  function detailcontentFile(){
      if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
        $('.loader').slideUp("fast")
        document.getElementById("detailcontentFile").innerHTML=xmlHttp.responseText
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

  function duplicatefileU() { 
    $(".formFile:last").clone().insertAfter(".formFile:last"); 
    $(".formFile:last input").val("")
  }
  $('.add_field_file').live('click',function(){
      duplicatefileU()
  });
  $('.fileN').live('change',function(){
      fileName = $(this).val();
      par = $(this).parent().parent().parent()
      if (fileName != "") {
        par.find(".fileT").attr("required", true)
      } else {
        par.find(".fileT").attr("required", false)
      }
  });
  $('.fileT').live('change',function(){
      fileType = $(this).val();
      par = $(this).parent().parent()
      if (fileType != "") {
        par.find(".fileN").attr("required", true)
      } else {
        par.find(".fileN").attr("required", false)
      }
  });

  var popup;
  function openPopupOneAtATime(x) {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>transaction/sales_order_print?so='+x;
      } else {
         popup = window.open('<?php echo base_url();?>transaction/sales_order_print?so='+x, '_blank', 'width=800,height=650,left=200,top=20');     
      }
  }
  function openPopupOneAtATime2(x) {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>transaction/sales_order_print_no?so='+x;
      } else {
         popup = window.open('<?php echo base_url();?>transaction/sales_order_print_no?so='+x, '_blank', 'width=800,height=650,left=200,top=20');     
      }
  }
  $(".printso").live('click', function() {
    soid = $(this).attr("soid")
    openPopupOneAtATime(soid);
  });
  $(".printso2").live('click', function() {
    soid = $(this).attr("soid")
    openPopupOneAtATime2(soid);
  });
  $("#hideshow").click(function(){
    $("#divhideshow").slideToggle();
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

$('.goApproval').live('click',function(e){
  load_modal()
  par = $(this)
  SOID = par.attr('so')
  $.ajax({
      url: '<?php echo base_url();?>transaction/sales_order_goApproval',
      type : 'POST',
      data: {SOID:SOID},
      dataType : 'json',
      success:function(response){
        if (response['result'] == "success") {
          par.replaceWith( '' )
        }
        if ('note' in response) {
          alert(response['note'])
          $("#modal-loading-ajax").modal('hide');
        }
      }
  });
});
function createattribute() {
  atributelist = $(".atributelist").val()
  $(".rowtext:first .atributeid").val(atributelist);
  $(".rowtext:first").clone().insertBefore('#atributelabel');
}
function load_modal() {
  $("#modal-loading-ajax").modal({
    show: true,
    backdrop: 'static',
    keyboard: false
  });
}
</script>