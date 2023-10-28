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

  #detailcontent {
    padding: 10px !important;
  }
  .default {cursor: pointer;}

  /*scroll x on top*/
  /*.dataTables_scrollBody {
      transform:rotateX(180deg);
  }
  .dataTables_scrollBody table {
      transform:rotateX(180deg);
  }*/
  /*---------------------*/
  
  .divfilterdate, .divSetFixedColumn, #divhideshow {
    display: none; 
    border: 1px solid #0073b7; 
    padding: 4px;
    overflow: auto;
    margin: 5px 0px;
  }
  .rowlist, .rowtext { margin-top: 6px; }
  .martop-4 { margin-top: 4px; }

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
  
  /*efek load*/
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
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>

  <section class="content">
    
    <div class="box box-solid">
      <div class="box-header">
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="2"><i class="fa fa-fw fa-print"></i> Print</button>
        <a href="#" id="hideshow" class="btn btn-primary btn-xs hideshow" title="HIDE/SHOW COLUMN">Hide/Show Column</a>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>
        <!-- <a href="#" id="setFixedColumn" class="btn btn-primary btn-xs setFixedColumn" title="SET FIXED COLUMN">Set FixedColumn</a> -->

        <div class="divSetFixedColumn">
          <form role="form" action="<?php echo current_url();?>" method="post" >
            <div class="col-md-6">
                <div class="form-group">
                  <label class="left">Fixed Left</label>
                  <span class="left2">
                    <input type="number" min="0" class="form-control input-sm" autocomplete="off" name="FixedLeft" id="FixedLeft" required="">
                  </span>
                </div>
                <div class="form-group">
                  <label class="left">Fixed Right</label>
                  <span class="left2">
                    <input type="number" min="0" class="form-control input-sm" autocomplete="off" name="FixedRight" id="FixedRight" required="">
                  </span>
                </div>
            </div>
            <div class="col-md-6">
              <center>
                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
              </center>
            </div>
          </form>
        </div>

        <div id="divhideshow">
          Hide/Show Column :
          <a class="btn btn-primary btn-xs toggle-vis" data-column="5">So Note</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="6">Ship Address</a>
        </div>

        <div class="divfilterdate">
          <form role="form" action="<?php echo current_url();?>" method="post" >
            <div class="col-md-6"> 
              <div class="form-group">
                <label class="left">Status</label>
                <span class="left2">
                    <select class="form-control input-sm" name="status">
                      <option value="all">All</option>
                      <option value="1_Ready">Ready</option>
                      <option value="2_NotReady">NotReady</option>
                      <option value="0_Cancel">Cancel</option>
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
                        <option value="Company">Customer Name</option>
                        <option value="Sales">Sales Name</option>
                        <option value="Category">Category</option>
                        <option value="ProductID">Product ID</option>
                        <option value="ProductName">Product Name</option>
                        <option value="ShopName">Shop Name</option>
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
              <th>SO ID</th>
              <th>Order</th>
              <th>Company</th>
              <th>Shop</th>
              <th>Sales Name</th>
              <th>Note</th>
              <th>Ship Address</th>
              <th>Type / Minimum DP</th>
              <th>Total</th>
              <th>Deposit Rp</th>
              <th>Deposit (%)</th>
              <th>Payment Rp</th>
              <th>Payment (%)</th>
              <th>Quantity</th>
              <th>DO</th>
              <th>OutStanding</th>
              <th>Category</th>
              <th>INV MP</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
            // echo count($content);
            if (isset($content['main'])) {
                foreach ($content['main'] as $row => $list) { 
                  $ShipAddress  = explode(";",$list['ShipAddress']);
          ?>
                <tr>
                  <td><a class="default detail" title="SO DETAIL" data-toggle="modal" data-target="#modal-detail" soid="<?php echo $list['SOID']; ?>"><?php echo $list['SOID'];?></a></td>
                  <td><?php echo $list['SODate'];?></td>
                  <td><?php echo $list['Company'];?></td>
                  <td><?php echo $list['ShopName'];?></td>
                  <td><?php echo $list['salesname'];?></td>
                  <td><?php echo $list['SONote'];?></td>
                  <td><?php echo $ShipAddress[1].', '.$ShipAddress[2];?></td>
                  <td><?php echo $list['SOType']." / (".$list['DPMinimumPercent']." %) ".number_format($list['DPMinimumAmount']) ;?></td>
                  <td class="alignRight"><?php echo number_format($list['SOTotal'],2);?></td>
                  <td class="alignRight"><?php echo $list['TotalDeposit'];?></td>
                  <td class="alignRight"><?php echo "<b>".$list['TotalDepositPerc']." %</b>";?></td>
                  <td class="alignRight"><?php echo $list['TotalPayment'];?></td>
                  <td class="alignRight"><?php echo "<b>".$list['TotalPaymentPerc']."%</b>";?></td>
                  <td class="alignRight"><?php echo $list['qty'];?></td>
                  <td class="alignRight"><?php echo $list['totaldo'];?></td>
                  <td class="alignRight"><?php echo $list['outstanding'];?></td>
                  <td><?php echo $list['CategoryName'];?></td>
                  <td><?php echo $list['INVMP'];?></td>
                  <td>

                    <?php echo "(".$list['PaymentWay'].") "; ?>
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

                    <?php if ($list['note']>0) { ?>
                      <i class="fa fa-fw fa-sticky-note-o" style="color: green;" title="NOTED"></i>
                      <span style="display:none;">NOTED</span>
                    <?php };  ?>
                    <?php if ($list['ROID']>0) { ?>
                      <i class="fa fa-fw fa-cart-plus" style="color: green;" title="<?php echo $list['ROID'];?> ROID"></i>
                      <span style="display:none;">ROID</span>
                    <?php };  ?>
                    <?php if ($list['POID']>0) { ?>
                      <i class="fa fa-fw fa-cart-plus" style="color: green;" title="<?php echo $list['POID'];?> POID"></i>
                      <span style="display:none;">POID</span>
                    <?php };  ?>
                  </td>
                  <td>
                    <!-- <button type="button" class="btn btn-warning btn-xs printso" title="PRINT" soid="<?php echo $list['SOID'];?>"><i class="fa fa-fw fa-print"></i></button> -->
                    <button type="button" class="btn btn-primary btn-xs detail" title="DETAIL" data-toggle="modal" data-target="#modal-detail" soid="<?php echo $list['SOID']; ?>"><i class="fa fa-fw fa-search"></i></button>
                    <?php if (in_array("report_customer_complaint", $MenuList)) {?>
                    <button type="button" class="btn btn-success btn-xs" onclick="window.open('<?php echo base_url();?>report/report_customer_complaint_add?CustomerID=<?php echo $list['CustomerID'];?>&SOID=<?php echo $list['SOID'];?>', '_blank');" title='Add Complaint'><i class="fa fa-wechat"></i></button>
                    <?php }?>
                    <!-- <button type="button" class="btn btn-primary btn-xs addnote" title="NOTE"  data-toggle="modal" data-target="#modal-note" soid="<?php echo $list['SOID']; ?>"><i class="fa fa-fw fa-edit"></i></button> -->
                  </td>
                </tr>
          <?php } } ?>
          </tbody>
          <tfoot>
              <tr>
                  <th style="text-align:right"></th>
                  <th colspan="7">
                    Total Current Page:<br>
                    Total All Page:<br>
                  </th>
                  <th class="alignRight"></th>
                  <th class="alignRight"></th>
                  <th class="alignRight"></th>
                  <th class="alignRight"></th>
                  <th class="alignRight"></th>
                  <th class="alignRight"></th>
                  <th class="alignRight"></th>
                  <th class="alignRight"></th>
                  <th class="alignRight"></th>
                  <th colspan="3"></th>
              </tr>
          </tfoot>
        </table>
      </div>
    </div>

    <div class="modal fade" id="modal-detail">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Detail SO</h4>
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
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
	 

  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
    
    "order": [[0,'asc']],
    "scrollX": true,
     "scrollY": true,
    "scrollCollapse": true,
    "fixedColumns": {
        leftColumns: 1,
        rightColumns: 2
    }, 
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
        total6 = api
            .column( 7 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        total7 = api
            .column( 8 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        total8 = api
            .column( 9 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        total9 = api
            .column( 10 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        total10 = api
            .column( 11 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        total11 = api
            .column( 12 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        total12 = api
            .column( 13 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        total13 = api
            .column( 14 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        total14 = api
            .column( 15 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        total15 = api
            .column( 16 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Total over this page
        pageTotal6 = api
            .column( 7, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        pageTotal7 = api
            .column( 8, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        pageTotal8 = api
            .column( 9, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        pageTotal9 = api
            .column( 10, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        pageTotal10 = api
            .column( 11, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        pageTotal11 = api
            .column( 12, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        pageTotal12 = api
            .column( 13, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        pageTotal13 = api
            .column( 14, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        pageTotal14 = api
            .column( 15, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        pageTotal15 = api
            .column( 16, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Update footer
        // $( api.column( 6 ).footer() ).html(
        //     pageTotal6.toLocaleString(undefined, {minimumFractionDigits: 2}) +
        //     '<br>'+ total6.toLocaleString(undefined, {minimumFractionDigits: 2})
        // );
        $( api.column( 8 ).footer() ).html(
            pageTotal7.toLocaleString(undefined, {minimumFractionDigits: 2}) +
            '<br>'+ total7.toLocaleString(undefined, {minimumFractionDigits: 2})
        );
        $( api.column( 9 ).footer() ).html(
            pageTotal8.toLocaleString(undefined, {minimumFractionDigits: 2}) +
            '<br>'+ total8.toLocaleString(undefined, {minimumFractionDigits: 2})
        );
        // $( api.column( 9 ).footer() ).html(
        //     pageTotal9.toLocaleString(undefined, {minimumFractionDigits: 2}) +
        //     '<br>'+ total9.toLocaleString(undefined, {minimumFractionDigits: 2})
        // );
        $( api.column( 11 ).footer() ).html(
            pageTotal10.toLocaleString(undefined, {minimumFractionDigits: 2}) +
            '<br>'+ total10.toLocaleString(undefined, {minimumFractionDigits: 2})
        );
        // $( api.column( 11 ).footer() ).html(
        //     pageTotal11.toLocaleString(undefined, {minimumFractionDigits: 2}) +
        //     '<br>'+ total11.toLocaleString(undefined, {minimumFractionDigits: 2})
        // );
        $( api.column( 13 ).footer() ).html(
            pageTotal12.toLocaleString(undefined, {minimumFractionDigits: 2}) +
            '<br>'+ total12.toLocaleString(undefined, {minimumFractionDigits: 2})
        );
        $( api.column( 14 ).footer() ).html(
            pageTotal13.toLocaleString(undefined, {minimumFractionDigits: 2}) +
            '<br>'+ total13.toLocaleString(undefined, {minimumFractionDigits: 2})
        );
        $( api.column( 15 ).footer() ).html(
            pageTotal14.toLocaleString(undefined, {minimumFractionDigits: 2}) +
            '<br>'+ total14.toLocaleString(undefined, {minimumFractionDigits: 2})
        );
        // $( api.column( 15 ).footer() ).html(
        //     pageTotal15.toLocaleString(undefined, {minimumFractionDigits: 2}) +
        //     '<br>'+ total15.toLocaleString(undefined, {minimumFractionDigits: 2})
        // );
    }
  })
  var cek_dt = function() {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);
  
  $('a.toggle-vis').on( 'click', function (e) {
      e.preventDefault();
      var column = table.column( $(this).attr('data-column') );
      column.visible( ! column.visible() );
      table.columns.adjust().draw();
  } );
  setTimeout( function order() {
    $('a[data-column="5"]').click();
    $('a[data-column="6"]').click();
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
  $("#hideshow").click(function(){
    $("#divhideshow").slideToggle();
  });

  $('.detail').live('click',function(e){
      soid = $(this).attr("soid");
      $('.loader').slideDown("fast")
      $('#detailcontentAjax').empty()
      get(soid)
  });

  function get(id) {
    xmlHttp=GetXmlHttpObject()
      var url="<?php echo base_url();?>report/report_so_detail"
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

  var popup;
  function openPopupOneAtATime(x) {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>general/sales_order_print?so='+x;
      } else {
         popup = window.open('<?php echo base_url();?>general/sales_order_print?so='+x, '_blank', 'width=800,height=650,left=200,top=20');     
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
  $('.addnote').live('click',function(e){
    soid = $(this).attr("soid");
    $('.soid').val(soid);
  });
  $('button.print_dt').on('click', function() {               
      var fvData = table.rows({ search:'applied', page: 'all' }).data(); 
      $('.div_dt_print').empty().append(
         '<table id="dtTablePrint" class="col" border="0">' +
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