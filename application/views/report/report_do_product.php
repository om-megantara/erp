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

<?php
// print_r(array_keys($content['main']));
$category = $content['category'];
$socategory = $content['main']['socategory'];
$brand = $content['brand'];
?>

<div class="content-wrapper">

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
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="1"><i class="fa fa-fw fa-print"></i> Print</button>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>
        <div class="divfilterdate">
          <form role="form" action="<?php echo current_url();?>" method="post" >
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Category</label>
                <span class="left2">
                  <select class="form-control input-sm select2" style="width: 100%;" name="category" id="category" required="">
                    <option value="0">Empty</option>
                    <?php foreach ($category as $row => $list) { ?>
                    <option value="<?php echo $list['ProductCategoryID'].'_'.$list['ProductCategoryName'];?>"><?php echo $list['ProductCategoryName'] ;?></option>
                    <?php } ?>
                  </select>
                </span>
              </div>
              <div class="form-group">
                <label class="left">Brand</label>
                <span class="left2">
                  <select class="form-control input-sm select2" style="width: 100%;" name="brand" id="brand" required="">
                    <option value="0">Empty</option>
                    <?php foreach ($brand as $row => $list) { ?>
                    <option value="<?php echo $list['ProductBrandID'].'_'.$list['ProductBrandName'];?>"><?php echo $list['ProductBrandName'] ;?></option>
                    <?php } ?>
                  </select>
                </span>
              </div>
              <div class="form-group">
                <label class="left">Type</label>
                <span class="left2">
                  <select class="form-control input-sm" style="width: 100%;" name="type" id="type" required="">
                    <option value="ALL">ALL</option>
                    <option value="RAW PO">RAW PO</option>
                    <option value="MUTATION">MUTATION</option>
                    <option value="SO">SO</option>
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
                  <input type="text" class="form-control input-sm" autocomplete="off" name="datestart" id="datestart">
                </div>
              </div>
              <div class="form-group">
                <label class="left">Month End</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm" autocomplete="off" name="dateend" id="dateend">
                </div>
              </div>
              <!-- <div class="form-group">
                <label class="left">SO Category</label>
                <span class="left2">
                  <select class="form-control input-sm select2" style="width: 100%;" name="socategory" id="socategory" required="">
                    <option value="0">Empty</option>
                    <?php foreach ($socategory as $row => $list) { ?>
                    <option value="<?php echo $list['CategoryID'];?>"><?php echo $list['CategoryName'] ;?></option>
                    <?php } ?>
                  </select>
                </span>
              </div> -->
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
              <th class=" alignCenter" rowspan=2>Product ID </th>
              <th class=" alignCenter" rowspan=2>Category </th>
              <th class=" alignCenter" rowspan=2>Product Code</th>
              <th class=" alignCenter" rowspan=2>PO Qty</th>
              <th class=" alignCenter" colspan=6>SO Qty</th>
              <th class=" alignCenter" rowspan=2>Mutation Qty</th>
              <th class=" alignCenter" rowspan=2>Total Qty</th>
              <th rowspan=2></th>
            </tr>
            <tr>
              <th class=" alignCenter">Sales/CT</th>
              <th class=" alignCenter">Display</th>
              <th class=" alignCenter">Sample</th>
              <th class=" alignCenter">Bonus</th>
              <th class=" alignCenter">Replacement</th>
              <th class=" alignCenter">Total</th>
            </tr>
          </thead>
          <tbody>
          <?php
            // echo count($content);
            if (isset($content['main']['main'])) {
                foreach ($content['main']['main'] as $row => $list) { ?>
                <tr>
                  <td class=" alignCenter"><?php echo $list['ProductID'];?></td>
                  <td class="alignleft"><?php echo $content['category'][ $list['ProductCategoryID'] ]['ProductCategoryName'];?></td>
                  <td class="alignleft"><?php echo $list['ProductCode'];?></td>
                  <td class=" alignCenter"><?php echo number_format($list['POQty']);?></td>
<!--                   <td class=" alignCenter"></td>
                  <td class=" alignCenter"></td> -->
                  <td class=" alignCenter"><?php echo number_format($list['tsalesqty']);?></td>
                  <td class=" alignCenter"><?php echo number_format($list['tdisplayqty']);?></td>
                  <td class=" alignCenter"><?php echo number_format($list['treplacementqty']);?></td>
                  <td class=" alignCenter"><?php echo number_format($list['tbonusqty']);?></td>
                  <td class=" alignCenter"><?php echo number_format($list['tsampleqty']);?></td>
                  <td class=" alignCenter"><?php echo number_format($list['SOQty']);?></td>
                  <td class=" alignCenter"><?php echo number_format($list['MutationQty']);?></td>
                  <td class=" alignCenter"><?php echo number_format($list['ProductQty']);?></td>
                  <td>
                    <button type="button" class="btn btn-primary btn-xs detail" title="DETAIL" id="<?php echo $list['ProductID']; ?>" datestart="<?php echo $list['DODateStart']; ?>" dateend="<?php echo $list['DODateEnd']; ?>"  data-toggle="modal" data-target="#modal-detail"><i class="fa fa-fw fa-search"></i></button>
                  </td>
                </tr>
          <?php } } ?>
          </tbody>
          <tfoot>
              <tr>
                  <th colspan="3">
                    Total Current Page:<br>
                    Total All Page:
                  </th>
                  <th class=" alignCenter"></th>
                  <th class=" alignCenter"></th>
                  <th class=" alignCenter"></th>
                  <th class=" alignCenter"></th>
                  <th class=" alignCenter"></th>
                  <th class=" alignCenter"></th>
                  <th class=" alignCenter"></th>
                  <th class=" alignCenter"></th>
                  <th class=" alignCenter"></th>
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

        // Total over all pages
        total3 = api
            .column( 3 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        total4 = api
            .column( 4 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        total5 = api
            .column( 5 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        total6 = api
            .column( 6 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        total7 = api
            .column( 7 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
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

        // Total over this page
        pageTotal3 = api
            .column( 3, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        pageTotal4 = api
            .column( 4, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        pageTotal5 = api
            .column( 5, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        pageTotal6 = api
            .column( 6, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        pageTotal7 = api
            .column( 7, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
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

        // Update footer
        $( api.column( 3 ).footer() ).html(
            pageTotal3.toLocaleString(undefined, {minimumFractionDigits: 0}) +'<br>'+
            ''+ total3.toLocaleString(undefined, {minimumFractionDigits: 0}) +''
        );
        $( api.column( 4 ).footer() ).html(
            pageTotal4.toLocaleString(undefined, {minimumFractionDigits: 0}) +'<br>'+
            ''+ total4.toLocaleString(undefined, {minimumFractionDigits: 0}) +''
        );
        $( api.column( 5 ).footer() ).html(
            pageTotal5.toLocaleString(undefined, {minimumFractionDigits: 0}) +'<br>'+
            ''+ total5.toLocaleString(undefined, {minimumFractionDigits: 0}) +''
        );
        $( api.column( 6 ).footer() ).html(
            pageTotal6.toLocaleString(undefined, {minimumFractionDigits: 0}) +'<br>'+
            ''+ total6.toLocaleString(undefined, {minimumFractionDigits: 0}) +''
        );
        $( api.column( 7 ).footer() ).html(
            pageTotal7.toLocaleString(undefined, {minimumFractionDigits: 0}) +'<br>'+
            ''+ total7.toLocaleString(undefined, {minimumFractionDigits: 0}) +''
        );
        $( api.column( 8 ).footer() ).html(
            pageTotal8.toLocaleString(undefined, {minimumFractionDigits: 0}) +'<br>'+
            ''+ total8.toLocaleString(undefined, {minimumFractionDigits: 0}) +''
        );
        $( api.column( 9 ).footer() ).html(
            pageTotal9.toLocaleString(undefined, {minimumFractionDigits: 0}) +'<br>'+
            ''+ total9.toLocaleString(undefined, {minimumFractionDigits: 0}) +''
        );
        $( api.column( 10 ).footer() ).html(
            pageTotal10.toLocaleString(undefined, {minimumFractionDigits: 0}) +'<br>'+
            ''+ total10.toLocaleString(undefined, {minimumFractionDigits: 0}) +''
        );
        $( api.column( 11 ).footer() ).html(
            pageTotal11.toLocaleString(undefined, {minimumFractionDigits: 0}) +'<br>'+
            ''+ total11.toLocaleString(undefined, {minimumFractionDigits: 0}) +''
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

  $('.detail').live('click', function(e){
      document.getElementById("detailcontent").innerHTML='<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
      id  = $(this).attr("id")
      datestart  = $(this).attr("datestart")
      dateend  = $(this).attr("dateend")
      get(id, datestart, dateend);
  }); 

  function get(id, date) {
    xmlHttp=GetXmlHttpObject()
      var url="<?php echo base_url();?>report/report_do_product_detail"
      url=url+"?id="+id+"&datestart="+datestart+"&dateend="+dateend
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