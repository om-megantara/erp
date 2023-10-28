<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">

<style type="text/css">
  .divfilterdate {
    display: none; 
    margin: 5px 0px;
    border: 1px solid #0073b7; 
    padding: 4px;
    overflow: auto;
  }
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
  .Late { background: #ffd28b !important; }
  .tooLate { background: #ffc9c1 !important; }
</style>
<div class="content-wrapper">
<?php 
$supplier = $content['supplier'];
?>
  <div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">DETAIL PRODUCT</h4>
          </div>
          <div class="modal-body">
            <div class="detailcontentAjax" id="detailcontent" style="background-color: white;"></div>
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
      <div class="box-header with-border">
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="1"><i class="fa fa-fw fa-print"></i> Print</button>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>
        <div class="divfilterdate">
          <form role="form" action="<?php echo current_url();?>" method="post" >
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">PO ID</label>
                <span class="left2">
                  <input type="text" name="poid" class="form-control input-sm" style="width: 100%;">
              </span>
              </div>
              <div class="form-group">
                <label class="left">Supplier</label>
                <span class="left2">
                <select class="form-control select2" style="width: 100%;" name="supplier" id="supplier">
                  <option value="0">EMPTY</option>
                  <?php foreach ($supplier as $row => $list) { ?>
                  <option value="<?php echo $list['SupplierID'];?>"><?php echo $list['Company2'] ;?></option>
                  <?php } ?>
                </select>
              </span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Month Start</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm" autocomplete="off" name="filterstart" id="datestart" >
                </div>
              </div>
              <div class="form-group">
                <label class="left">Month End</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm" autocomplete="off" name="filterend" id="dateend" >
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
        <table id="dt_list" class="table table-bordered " style="width: 100%;">
          <thead>
            <tr>
              <th class=" alignCenter">PO ID</th>
              <th class=" alignCenter">Date</th>
              <th class=" alignCenter">Note</th>
              <th class=" alignCenter">Schedule</th>
              <th class=" alignCenter">Supplier</th>
              <th class=" alignCenter">Employee</th>
              <th class=" alignCenter">Pending DOR</th>
              <th class=" alignCenter">Pending DO</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
              if (isset($content['main'])) {
                  foreach ($content['main'] as $row => $list) {
            ?>
                  <tr>
                      <td><?php echo $list['POID'];?></td>
                      <td><?php echo $list['PODate'];?></td>
                      <td><?php echo $list['PONote'];?></td>
                      <td><?php echo $list['ShippingDate'];?></td>
                      <td><?php echo $list['Company2'];?></td>
                      <td><?php echo $list['Employee'];?></td>
                      <td class=" alignCenter"><?php echo $list['PendingDOR'];?></td>
                      <td class=" alignCenter"><?php echo $list['PendingDO'];?></td>
                      <td class=" alignRight">
                        <?php if ($list['POStatus'] == "1") { ?>
                          <i class="fa fa-fw fa-check-square-o" style="color: green;" title="complete"></i>
                        <?php } else if ($list['POStatus'] == "2") { ?>
                          <i class="fa fa-fw fa-times" style="color: red;" title="cancel"></i>
                        <?php } ?>
                        <?php if ($list['isApprove'] == "1") { ?>
                          <i class="fa fa-fw fa-check-square-o" style="color: blue;" title="Approved"></i>
                        <?php } ?>
                        <button type="button" class="btn btn-primary btn-xs detail" title="DETAIL" poid="<?php echo $list['POID'];?>" data-toggle="modal" data-target="#modal-detail"><i class="fa fa-fw fa-reorder"></i></button>
                        <button type="button" class="btn btn-primary btn-xs detailraw" title="DETAIL RAW" poid="<?php echo $list['POID'];?>" data-toggle="modal" data-target="#modal-detail"><i class="fa fa-fw fa-reorder"></i></button>
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
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
	 
   $('.select2').select2();
  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
    "order": [[0,'desc']],
    "scrollX": true,
     "scrollY": true,
    "scrollCollapse": true,
    "fixedColumns": {
        leftColumns: 1,
        // rightColumns: 2
    },
    "columnDefs": [{
      "visible": false,
      "searchable": false,
    }], 

    fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {  
        today = new Date();
        today = today.setHours(0,0,0,0)
        shipping = new Date(aData[3]);
        shipping = shipping.setHours(0,0,0,0)

        oneDay = 24*60*60*1000 // hours*minutes*seconds*milliseconds
        diffDays = Math.round(Math.abs((today - shipping)/(oneDay)))
        if ( shipping <= today ) { diffDays = (diffDays*-1) }
        // if ( shipping <= today && parseInt(aData[9]) > 0 && !cancel ){
        if (status=="false") {
          // console.log(status+'+'+aData[0])
          if ( diffDays <= 0 && parseInt(aData[11]) > 0){
              jQuery(nRow).addClass('tooLate');
          } else if ( diffDays <= 3 && parseInt(aData[11]) > 0) {
              jQuery(nRow).addClass('Late');
          } 
        }         
    },
  })
  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

  var popup;
  function openPopupOneAtATime(x) {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>transaction/purchase_order_print?po='+x;
      } else {
         popup = window.open('<?php echo base_url();?>transaction/purchase_order_print?po='+x, '_blank', 'width=800,height=650,left=200,top=20');     
      }
  }
  function openPopupOneAtATime2(x) {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>transaction/purchase_order_print2?po='+x;
      } else {
         popup = window.open('<?php echo base_url();?>transaction/purchase_order_print2?po='+x, '_blank', 'width=800,height=650,left=200,top=20');     
      }
  }
  function openPopupOneAtATime3(x) {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>transaction/delivery_order_received_print2?dor='+x;
      } else {
         popup = window.open('<?php echo base_url();?>transaction/delivery_order_received_print2?dor='+x, '_blank', 'width=800,height=650,left=200,top=20');     
      }
  }
  $(".printpo").live('click', function() {
    poid = $(this).attr("poid")
    openPopupOneAtATime(poid);
  });
  $(".printpo2").live('click', function() {
    poid = $(this).attr("poid")
    openPopupOneAtATime2(poid);
  });
  $(".printdor").live('click', function() {
    dor = $(this).attr("dor")
    openPopupOneAtATime3(dor);
  });

  $('.detail').live('click', function(e){
  	document.getElementById("detailcontent").innerHTML='<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
    $('#detailcontent').empty()
    poid  = $(this).attr("poid")
    get(poid);
  }); 
  $('.detailraw').live('click', function(e){
  	document.getElementById("detailcontent").innerHTML='<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
    $('#detailcontent').empty()
    poid  = $(this).attr("poid")
    get2(poid);
  });
  function get(poid) {
    xmlHttp=GetXmlHttpObject()
      var url="<?php echo base_url();?>report/purchase_order_detail_full2"
      url=url+"?poid="+poid
      // alert(url);
      xmlHttp.onreadystatechange=stateChanged
      xmlHttp.open("GET",url,true)
      xmlHttp.send(null)
  }
  function get2(poid) {
    xmlHttp=GetXmlHttpObject()
      var url="<?php echo base_url();?>report/purchase_order_detail_raw_full"
      url=url+"?poid="+poid
      // alert(url);
      xmlHttp.onreadystatechange=stateChanged
      xmlHttp.open("GET",url,true)
      xmlHttp.send(null)
  }
  function stateChanged(){
      if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
          document.getElementById("detailcontent").innerHTML=xmlHttp.responseText
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
  $("#datestart").datepicker({
    format: "yyyy-mm-dd",
    viewMode: "months", 
    minViewMode: "months"
  }).on('changeDate', function (selected) {
    var minDate = new Date(selected.date.valueOf());
    $('#dateend').datepicker('setStartDate', minDate);
  });
  $("#dateend").datepicker({
    format: "yyyy-mm-dd",
    viewMode: "months",
    minViewMode: "months"
  }).on('changeDate', function (selected) {
    var maxDate = new Date(selected.date.valueOf());
    $('#datestart').datepicker('setEndDate', maxDate);
  });
  $(".filterdate").click(function(){
    $(".divfilterdate").slideToggle();
  });
});

</script>