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
    overflow: auto;}

  /*scroll x on top*/
  /*.dataTables_scrollBody {
      transform:rotateX(180deg);
  }
  .dataTables_scrollBody table {
      transform:rotateX(180deg);
  }*/
  /*---------------------*/

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
  .rowlist, .rowtext { margin-top: 6px; }
  .default {cursor: pointer}
  .toggle-vis {
    background-color: #0073b7;
    color: white;
    padding: 1px 3px;
    text-align: center;
    text-decoration: none;
    font-size: 12px;
    font-weight: bold;
    cursor: pointer;
  }
  @media (min-width: 768px){
      .form-group label.left {
        float: left;
        width: 100px;
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
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>

  <section class="content">
    <div class="box box-solid">
      <div class="box-header">
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="1"><i class="fa fa-fw fa-print"></i> Print</button>
        
        <a href="#" id="column" class="btn btn-primary btn-xs column" title="HIDE/SHOW COLUMN">Hide/Show Column</a>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>

        <div id="divhideshow">
          Hide/Show Column :
          <a class="btn btn-primary btn-xs toggle-vis" data-column="3" title="SALES NAME">Sales Name</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="4" title="INVOICE DATE">Invoice Date</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="6" title="NOTE">Note</a>
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
                        <option value="Company">Customer Name</option>
                        <option value="Sales">Sales Name</option>
                        <option value="ProductID">Product ID</option>
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
              <div class="col-md-12" >
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
              <th class="alignCenter">Invoice ID</th>
              <th class="alignCenter">DO / SO</th>
              <th class="alignCenter">Company Name</th>
              <th class="alignCenter">Sales Name</th>
              <th class="alignCenter">Invoice Date</th>
              <th class="alignCenter">PT</th>
              <th class="alignCenter">Note</th>
              <th class="alignCenter">Due Date</th>
              <th class="alignCenter">Invoice Product</th>
              <th class="alignCenter">Invoice FC</th>
              <th class="alignCenter">Invoice Amount</th>
              <th class="alignCenter">Paid Rp.</th>
              <th class="alignCenter">Paid %</th>
              <th class="alignCenter">Outstanding</th>
              <th class="alignCenter">Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
            if (isset($content['main'])) {
                foreach ($content['main'] as $row => $list) { ?>
                <tr>
                  <?php if (in_array("print_without_header", $MenuList)) {?>
                  <td class="alignCenter"><a class="default printinvn2" title="INV DETAIL" invid="<?php echo $list['INVID'];?>"><?php echo $list['INVID'];?></a></td>
                  <?php } else { ?>
                  <td class="alignCenter"><a class="default printinvn" title="INV DETAIL" invid="<?php echo $list['INVID'];?>"><?php echo $list['INVID'];?></a></td>
                  <?php } ?>
                  <td class="alignCenter"><?php echo $list['DOID']." / ";?><a class="default detail" title="SO DETAIL" data-toggle="modal" data-target="#modal-detail2" soid="<?php echo $list['SOID']; ?>"><?php echo $list['SOID'];?></a></td>
                  <td class="alignleft"><?php echo $list['customer'];?></td>
                  <td class="alignleft"><?php echo $list['sales'];?></td>
                  <td class="alignCenter"><?php echo $list['INVDate'];?></td>
                  <td class="alignCenter"><?php echo ($list['TotalPayment'] < $list['INVTotal'] ? $list['PaymentTerm'] : 0);  ;?></td>
                  <td class="alignleft"><?php echo $list['INVNote'];?></td>
                  <td class="alignCenter"><?php echo $list['due_date']." / ".number_format($list['datediff'])." days";?></td>
                  <td class="alignRight"><?php echo number_format($list['PriceTotal']+$list['FCInclude']+$list['FCTax'],2);?></td>
                  <td class="alignRight"><?php echo number_format($list['FCExclude'],2);?></td>
                  <td class="alignRight"><?php echo number_format($list['INVTotal'],2);?></td>
                  <td class="alignRight"><?php echo number_format($list['TotalPayment'],2);?></td>
                  <td class="alignRight"><?php echo $list['TotalPaymentPerc']."%";?></td>
                  <td class="alignRight"><?php echo number_format($list['INVTotal']-$list['TotalPayment'],2);?></td>
                  <td>
                      <?php if (in_array("print_without_header", $MenuList)) {?>
                      <button type="button" class="btn btn-primary btn-xs printinvn2" title="PRINT INVOICE OFFLINE" invid="<?php echo $list['INVID'];?>"><i class="fa fa-fw fa-print"></i></button>
                      <?php } else {?>
                      <button type="button" class="btn btn-primary btn-xs printinvn" title="PRINT INV NORMAL" invid="<?php echo $list['INVID'];?>"><i class="fa fa-fw fa-print"></i></button>
                      <?php } ?>
                      <?php if ($list['FakturNumber']>0) { ?>
                      <button type="button" class="btn btn-warning btn-xs printfaktur" title="PRINT FAKTUR" invid="<?php echo $list['INVID'];?>"><i class="fa fa-fw fa-print"></i></button>
                      <?php } ?>

                      <button type="button" class="btn btn-primary btn-xs paymenthistory" title="PAYMENT HISTORY" invid="<?php echo $list['INVID'];?>" data-toggle="modal" data-target="#modal-detail" ><i class="fa fa-fw fa-info"></i></button>
                      <button type="button" class="btn btn-primary btn-xs dohistory" title="DO HISTORY" doid="<?php echo $list['DOID'];?>" data-toggle="modal" data-target="#modal-detail" ><i class="fa fa-fw fa-info"></i></button>

                  </td>
                </tr>
          <?php } } ?>
          </tbody>
          <tfoot>
              <tr>
                  <th style="text-align:right">
                  </th>
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
                  <th colspan=""></th>
              </tr>
          </tfoot>
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
    <div class="modal fade" id="modal-detail2">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Detail SO</h4>
          </div>
          <div class="modal-body">
            <div class="loader"></div>
            <div id="detailcontentAjax2"></div>
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
<script src="<?php echo base_url();?>tool/title-numeric.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>

<script>
jQuery( document ).ready(function( $ ) {
	 

  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
    "order": [[ 0, "desc" ]],
    "columnDefs": [
      { "type": 'title-numeric', targets: 8 }
    ],
    "scrollX": true,
     "scrollY": true,
    "scrollCollapse": true,
    "fixedColumns": {
        leftColumns: 1,
        rightColumns: 1,
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
        var MenuList = <?php echo json_encode($MenuList) ?>;
          if(MenuList.includes("check_omzet_inv_global")){
            // Total over all pages
            total8 = api
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            total9 = api
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            total10 = api
                .column( 10 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            total11 = api
                .column( 11 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            total13 = api
                .column( 13 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Total over this page
            pageTotal8 = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            pageTotal9 = api
                .column( 9, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            pageTotal10 = api
                .column( 10, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            pageTotal11 = api
                .column( 11, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            pageTotal13 = api
                .column( 13, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
          } else {
            total8=0;
            total9=0;
            total10=0;
            total11=0;
            total13=0;

            pageTotal8 = 0;
            pageTotal9 = 0;
            pageTotal10 = 0;
            pageTotal11 = 0;
            pageTotal13 = 0;
          }

        // Update footer
        $( api.column( 8 ).footer() ).html(
            pageTotal8.toLocaleString(undefined, {minimumFractionDigits: 2}) +
            // '<br>('+ total8.toLocaleString(undefined, {minimumFractionDigits: 2}) +')'
            '<br>'+ total8.toLocaleString(undefined, {minimumFractionDigits: 2})
        );
        $( api.column( 9 ).footer() ).html(
            pageTotal9.toLocaleString(undefined, {minimumFractionDigits: 2}) +
            // '<br>('+ total9.toLocaleString(undefined, {minimumFractionDigits: 2}) +')'
            '<br>'+ total9.toLocaleString(undefined, {minimumFractionDigits: 2})
        );
        $( api.column( 10 ).footer() ).html(
            pageTotal10.toLocaleString(undefined, {minimumFractionDigits: 2}) +
            // '<br>('+ total10.toLocaleString(undefined, {minimumFractionDigits: 2}) +')'
            '<br>'+ total10.toLocaleString(undefined, {minimumFractionDigits: 2})
        );
        $( api.column( 11 ).footer() ).html(
            pageTotal11.toLocaleString(undefined, {minimumFractionDigits: 2}) +
            // '<br>('+ total11.toLocaleString(undefined, {minimumFractionDigits: 2}) +')'
            '<br>'+ total11.toLocaleString(undefined, {minimumFractionDigits: 2})
        );
        $( api.column( 13 ).footer() ).html(
            pageTotal13.toLocaleString(undefined, {minimumFractionDigits: 2}) +
            // '<br>('+ total13.toLocaleString(undefined, {minimumFractionDigits: 2}) +')'
            '<br>'+ total13.toLocaleString(undefined, {minimumFractionDigits: 2})
        );
    }
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
      var url="<?php echo base_url();?>general/invoice_payment_detail"
      url=url+"?id="+id
    }
    if (info == "dohistory") {
      var url="<?php echo base_url();?>general/do_history"
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
  $('.detail').live('click',function(e){
      soid = $(this).attr("soid");
      $('.loader').slideDown("fast")
      $('#detailcontentAjax2').empty()
      get2(soid)
  });

  function get2(id) {
    xmlHttp=GetXmlHttpObject()
      var url="<?php echo base_url();?>report/report_so_detail"
      url=url+"?id="+id
      xmlHttp.onreadystatechange=stateChanged2
      xmlHttp.open("GET",url,true)
      xmlHttp.send(null)
  }
  function stateChanged2(){
      if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
          $('.loader').slideUp("fast")
          document.getElementById("detailcontentAjax2").innerHTML=xmlHttp.responseText
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
         popup.location.href = '<?php echo base_url();?>general/'+y+'?id='+x;
      } else {
         popup = window.open('<?php echo base_url();?>general/'+y+'?id='+x, '_blank', 'width=800,height=650,left=200,top=20');
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
  function openPopupOneAtATime3(x) {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>transaction/sales_order_print_no?so='+x;
      } else {
         popup = window.open('<?php echo base_url();?>transaction/sales_order_print_no?so='+x, '_blank', 'width=800,height=650,left=200,top=20');
      }
  }
  $(".printinvn").live('click', function() {
    invid = $(this).attr("invid")
    openPopupOneAtATime(invid,"print_invoice");
  });
  $(".printinvn2").live('click', function() {
    invid = $(this).attr("invid")
    openPopupOneAtATime2(invid,"print_invoice_offline");
  });
  $(".printfaktur").live('click', function() {
    invid = $(this).attr("invid")
    openPopupOneAtATime(invid,"print_faktur");
  });
  $(".printso2").live('click', function() {
    soid = $(this).attr("soid")
    openPopupOneAtATime3(soid);
  });
  $(".printso").live('click', function() {
    soid = $(this).attr("soid")
    openPopupOneAtATime3(soid);
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