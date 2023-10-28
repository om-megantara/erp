<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">

<style type="text/css"> 
  .empty { background-color: #fbcb5b; }
  .divfilterdate {
    display: none; 
    margin: 5px 0px;
    border: 1px solid #0073b7; 
    padding: 4px;
    overflow: auto;
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
  <div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Customer List </h4>
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
                  <label class="left">Month Start</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control input-sm" autocomplete="off" name="filterstart" id="datestart" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="left">Month End</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control input-sm" autocomplete="off" name="filterend" id="dateend" required="">
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
              <th rowspan=2 class=" alignCenter">No</th>
              <th rowspan=2 class=" alignCenter">City </th>
              <th rowspan=2 class=" alignCenter">Total <br>Customer</th>
              <th rowspan=2 class=" alignCenter">Customer <br>Display</th>
              <th rowspan=2 class=" alignCenter">Omzet Last <br>6 Months</th>
              <th rowspan=2 class=" alignCenter">Last <br>Order</th>
              <th colspan=2 class=" alignCenter">CFU</th>
              <th colspan=2 class=" alignCenter">CV</th>
              <th rowspan=2 class=" alignCenter">Maps</th>
              <th rowspan=2></th>
            </tr>
            <tr>
              <th class=" alignCenter">Month</th>
              <th class=" alignCenter">Year</th>
              <th class=" alignCenter">Month</th>
              <th class=" alignCenter">Year</th>
            </tr>
          </thead>
          <tbody>
          <?php
            // echo count($content);
          // var_dump ($content);
          // die();
           $urut =1;
            if (isset($content)) {
                foreach ($content as $row => $list) {
                  $Omzet1 =$list['Omzet1']/1000000;
                  $Omzet2 =$list['Omzet2']/1000000;
                  $Omzet3 =$list['Omzet3']/1000000;
                  $Omzet4 =$list['Omzet4']/1000000;
                  $Omzet5 =$list['Omzet5']/1000000;
                  $Omzet6 =$list['Omzet6']/1000000;
                  ?>
                <tr>
                  <td class=" alignCenter"><?php echo $urut;?></td>
                  <td class="alignLeft"><?php echo $list['CityName'];?></td>
                  <td class="alignRight"><?php echo $list['TotalCustomer'];?></td>
                  <td class="alignRight"><?php echo $list['display'];?></td>
                  <td class="alignRight">
                    <?php
                      echo number_format($Omzet1, 1)." / ".number_format($Omzet2, 1)." / ".number_format($Omzet3, 1)." / ".number_format($Omzet4, 1)." / ".number_format($Omzet5, 1)." / ".number_format($Omzet6, 1);
                    ?>
                  </td>
                  <?php if ($list['Last'] != '') { ?>
                  <td class="alignCenter">
                  <?php } else { ?>
                  <td class="empty">
                  <?php } ?>
                    <?php echo $list['INVDate']; if ($list['Last'] != ''){echo " (".$list['Last'].")";}else{}?>
                  </td>
                  <td class="alignRight"><?php echo $list['CFUMonth']?></td>
                  <td class="alignRight"><?php echo $list['CFUYear']?></td>
                  <td class="alignRight"><?php echo $list['CVMonth'];?></td>
                  <td class="alignRight"><?php echo $list['CVYear'];?></td>
                  <td class="alignRight"><a href="https://www.google.com/maps/search/<?php echo $list['CityName'];?>+toko+bangunan" target="_blank" class="btn btn-primary btn-xs"><i class="fa fa-fw fa-map-marker"></i> Maps</a></td>
                  <td>
                    <button type="button" class="btn btn-primary btn-xs detail" title="DETAIL" id="<?php echo $list['CityID']; ?>"  cityname="<?php echo $list['CityName']; ?>" data-toggle="modal" data-target="#modal-detail" ><i class="fa fa-fw fa-search"></i></button>
                  </td>
                </tr>
          <?php $urut++;} } ?>
          </tbody>
          <tfoot>
              <tr>
                  <th colspan="2">Total Page:</br>Total All Page:</th>
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
        total2 = api
            .column( 2 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Total over this page
        pageTotal2 = api
            .column( 2, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Update footer
        $( api.column( 2 ).footer() ).html(
            pageTotal2.toLocaleString(undefined, {minimumFractionDigits: 2}) +'<br>'+
            // '('+ total2.toLocaleString(undefined, {minimumFractionDigits: 2}) +')'
            total2.toLocaleString(undefined, {minimumFractionDigits: 2})
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
        CityName  = $(this).attr("CityName")
        id  = $(this).attr("id")
        datestart  = $(this).attr("datestart")
        dateend  = $(this).attr("dateend")
        $('.modal-title').text("Customer List "+CityName)
        get(id, datestart, dateend);
  }); 
  $('.detailmonth').live('click', function(e){
        document.getElementById("detailcontent").innerHTML='<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
        id  = $(this).attr("id")
        datestart  = $(this).attr("datestart")
        dateend  = $(this).attr("dateend")
        get2(id, datestart, dateend);
  }); 

  function get(id, datestart, dateend) {
    xmlHttp=GetXmlHttpObject()
      var url="<?php echo base_url();?>report/report_customer_city_detail"
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