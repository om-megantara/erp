<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">

<style type="text/css">
  .divfilterdate {
    display: none; 
    margin: 5px 0px;
    border: 1px solid #0073b7; 
    padding: 4px; 
    overflow: auto;
  }
  .btn-header {
    /*margin-top: -25px;*/
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
    width: 100px;
    padding: 5px 15px 5px 5px;
  }
  .form-group span.left2 {
    display: block;
    overflow: hidden;
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
              <h4 class="modal-title">DETAIL</h4>
          </div>
          <div class="modal-body">
            <div class="detailcontentAjax" id="detailcontent" style="background-color: white;">
              
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
        <button type="button" class="btn btn-primary btn-xs btn-header print_dt" title="PRINT" removeTd="1"><i class="fa fa-fw fa-print"></i> Print</button>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs btn-header filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>
        <div class="" style="display: none;">
          <div class="input-group">
            <div class="input-group-addon">
              Category Level
            </div>
            <input type="number" class="form-control input-sm levelCategory" autocomplete="off" name="levelCategory" value="2" min="1">
          </div>
        </div>
        <div class="" style="display: none;">
          <div class="input-group">
            <div class="input-group-addon">
              Brand Level
            </div>
            <input type="number" class="form-control input-sm levelBrand" autocomplete="off" name="levelBrand" value="2" min="1">
          </div>
        </div>

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
            <div class="col-md-12">
              <center>
                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
              </center>
            </div>
          </form>
        </div>
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered " style="width: 100% !important;">
          <thead>
            <tr>
              <th class="alignCenter">Customer ID</th>
              <th class="alignCenter">Customer Name</th>
              <th class="alignCenter">Product Qty</th>
              <th class="alignCenter">Product Price</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          <?php
            // echo count($content);
            if (isset($content['main'])) {
                foreach ($content['main'] as $row => $list) { ?>
                <tr>
                  <td class="alignCenter"><?php echo $list['CustomerID'];?></td>
                  <td class=""><?php echo $list['CustomerName'];?></td>
                  <td class="alignRight"><?php echo number_format($list['ProductQty']);?></td>
                  <td class="alignRight"><?php echo number_format($list['PriceTotal'],2);?></td>
                  <td>
                    <button type="button" class="btn btn-primary btn-xs detailCategory" title="DETAIL CATEOGRY" customer="<?php echo $list['CustomerID']; ?>" datestart="<?php echo $content['month']; ?>" data-toggle="modal" data-target="#modal-detail"><i class="fa fa-fw fa-search"></i></button>
                    <button type="button" class="btn btn-primary btn-xs detailBrand" title="DETAIL BRAND" customer="<?php echo $list['CustomerID']; ?>" datestart="<?php echo $content['month']; ?>" data-toggle="modal" data-target="#modal-detail"><i class="fa fa-fw fa-search"></i></button>
                  </td>
                </tr>
          <?php } } ?>
          </tbody>
          <tfoot>
              <tr>
                  <th colspan="2">
                    Total Current Page:<br>
                    Total All Page:<br>
                  </th>
                  <th class="alignRight"></th>
                  <th class="alignRight"></th>
                  <th></th>
              </tr>
          </tfoot>
        </table>
      </div>
    </div>

  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
   
  $('.select2').select2();

  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "order":[],
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
            total3 = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            total2 = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Total over this page
            pageTotal3 = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            pageTotal2 = api
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
          } else {
            total3= 0;
            total2= 0;

            pageTotal3 = 0;
            pageTotal2 = 0;
          }

        // Update footer
        $( api.column( 3 ).footer() ).html(
            pageTotal3.toLocaleString(undefined, {minimumFractionDigits: 2}) +'<br>'+
            ''+ total3.toLocaleString(undefined, {minimumFractionDigits: 2}) +''
        );
        $( api.column( 2 ).footer() ).html(
            pageTotal2.toLocaleString(undefined, {minimumFractionDigits: 2}) +'<br>'+
            ''+ total2.toLocaleString(undefined, {minimumFractionDigits: 2}) +''
        );
    }
  })

  var cek_dt = function() {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);
  
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

  $('.detailCategory').live('click', function(e){
      customer  = $(this).attr("customer")
      datestart  = $(this).attr("datestart")
      levelCategory = $(".levelCategory").val();
      get(customer, datestart, levelCategory);
  }); 
  $('.detailBrand').live('click', function(e){
      customer  = $(this).attr("customer")
      datestart  = $(this).attr("datestart")
      levelBrand = $(".levelBrand").val();
      get2(customer, datestart, levelBrand);
  }); 

  function get(customer, date) {
    document.getElementById("detailcontent").innerHTML='<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
    xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>report/report_inv_paid_customer_product_category"
    url=url+"?customer="+customer+"&datestart="+datestart+"&levelCategory="+levelCategory
    // alert(url);
    xmlHttp.onreadystatechange=stateChanged
    xmlHttp.open("GET",url,true)
    xmlHttp.send(null)
  }
  function get2(customer, date) {
    document.getElementById("detailcontent").innerHTML='<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
    xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>report/report_inv_paid_customer_product_brand"
    url=url+"?customer="+customer+"&datestart="+datestart+"&levelBrand="+levelBrand
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
});
</script>