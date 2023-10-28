<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">

<style type="text/css"> 
  .divfilterdate {
    display: none; 
    overflow: auto;
    border: 1px solid #0073b7; 
    padding: 4px; 
    margin: 5px 0px;
  }
  #detailcontent {
    padding: 10px !important;
    /*background: #3169c6;*/
  }
  .modal-info-warning {
    color: red;
    margin-top: 1px !important;
    margin-bottom: 1px !important;
  }
  @media only screen and (min-width: 760px) {
    .alert-success {
      padding-bottom: 0px;
      margin-bottom: 5px !important;
    }
  }
  .table-main thead th, .table-main tbody td {
    color: #000;
    text-align: center;
  }
  .table-main {
    margin-top: 10px; 
    margin-bottom: 0px;
    border: 1px solid #000;
  }
  .table-main>thead>tr>th, 
  .table-main>tbody>tr>td {
    font-size: 14px;
    padding: 2px 2px !important;
    border: 1px solid #000;
  }
  .table-main > tbody > tr > td, .table-main > thead > tr > th {
    word-break: break-all; 
    white-space: nowrap; 
  }
@media (min-width: 768px){
    .form-group label.left {
      float: left;
      padding: 5px 15px 5px 5px;
    }
    .form-group { margin-bottom: 10px; }
}
</style>
<div class="content-wrapper">

  <div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">DETAIL CONTENT</h4>
          </div>
          <div class="modal-body">
            <div class="detailcontentAjax" id="detailcontent"></div>
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
      <div class="box-header with-border">
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="1"><i class="fa fa-fw fa-print"></i> Print</button>
          <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>
          <div class="divfilterdate">
            <form role="form" action="<?php echo current_url();?>" method="post" >
              <div class="col-md-6">
                <div class="form-group">
                  <label class="left">Month</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control input-sm" autocomplete="off" name="datestart" id="datestart">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <button type="submit" class="btn btn-primary pull-center">Submit</button>
              </div>
            </form>
          </div>
            <div class="col-md-12" style="overflow-x: auto; padding: 0px;">
              <table class="table table-bordered table-responsive table-main">
                <thead>
                  <tr>
                    <th>Month</th>
                    <th>Total Sales</th>
                    <th>Total Omzet</th>
                    <th>Penalty</th>
                    <th>PV Final</th>
                    <th>(PV/Price)%</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $content['month'];?></td>
                        <td><?php echo $content['sales'];?></td>
                        <td><?php echo number_format($content['omzet'],2);?></td>
                        <td><?php echo number_format($content['penalty'],2);?></td>
                        <td><?php echo number_format($content['total'],2);?></td>
                        <td><?php echo number_format( ($content['total']*100)/ max($content['omzet'],1) ,2);?></td>
                    </tr>
                </tbody>
              </table>
            </div>
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered " style="width: 100% !important;">
          <thead>
            <tr>
              <th>Sales Name</th>
              <th>PV x Quantity</th>
              <th>PV Amount</th>
              <th>PV Penalty</th>
              <th>PV Total</th>
              <th>Omzet</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
            // echo count($content);
            if (isset($content['main'])) {
                foreach ($content['main'] as $row => $list) { ?>
                <tr>
                  <td><?php echo $list['fullname'];?></td>
                  <td class="alignRight"><?php echo number_format($list['PV_qty'],3);?></td>
                  <td class="alignRight"><?php echo number_format($list['PV_total'],3);?></td>
                  <td class="alignRight"><?php echo number_format($list['PV_penalty'],2);?></td>
                  <td class="alignRight"><?php echo number_format($list['PV_final'],2);?></td>
                  <td class="alignRight"><?php echo number_format($list['Omzet'],2);?></td>
                  <td>
                    <button type="button" class="btn btn-primary btn-xs detail" title="DETAIL" sales="<?php echo $list['SalesID']; ?>" date="<?php echo $content['date']; ?>" data-toggle="modal" data-target="#modal-detail"><i class="fa fa-fw fa-search"></i></button>
                    <button type="button" class="btn btn-warning btn-xs print" title="PRINT" sales="<?php echo $list['SalesID']; ?>" date="<?php echo $content['date']; ?>"><i class="fa fa-fw fa-print"></i></button>
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
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
   

  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "order": [[0, "asc"]]
  })

  var cek_dt = function() {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);
  
  $("#datestart").datepicker({ 
    format: "yyyy-mm-dd",
    viewMode: "months", 
    minViewMode: "months"
  })
  $(".filterdate").click(function(){
    $(".divfilterdate").slideToggle();
  });

  $('.detail').live('click', function(e){
        sales  = $(this).attr("sales")
        date  = $(this).attr("date")
        get(sales, date);
  }); 
  function get(sales, date) {
    document.getElementById("detailcontent").innerHTML='<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
    xmlHttp=GetXmlHttpObject()
      var url="<?php echo base_url();?>report/pv_inv_detail"
      url=url+"?sales="+sales+"&date="+date
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


  $(".print").live('click', function() {
    sales = $(this).attr("sales")
    date  = $(this).attr("date")
    openPopupOneAtATime(sales, date);
  });
  var popup;
  function openPopupOneAtATime(x,y) {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>report/report_pv_sales_print?sales='+x+"&date="+date;
      } else {
         popup = window.open('<?php echo base_url();?>report/report_pv_sales_print?sales='+x+"&date="+date, '_blank', 'width=860,height=600,left=200,top=20');     
      }
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
});
</script>