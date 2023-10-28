<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css">
  .divuploadata, .divfilter, .divShowGroup {
    margin-top: 5px;
    border: 1px solid #367fa9;
    display: none;
  }
  @media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 130px;
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
  <div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">DETAIL PENALTY</h4>
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
      <li><a title="HELP" class="btn btn-warning btn-xs" href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>

  <section class="content">
    <div class="box box-solid">
      <div class="box-header">
        <div class="form-button">
          <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="1"><i class="fa fa-fw fa-print"></i> Print</button>
          <a href="#" id="filter" class="btn btn-primary btn-xs filter"><i class="fa fa-search"></i> Filter</a>
          <a title="ADD PENALTY" href="<?php echo base_url();?>employee/employee_penalty/0" id="addpenalty" class="btn btn-primary btn-xs addpenalty"><b>+</b> PENALTY ORDER</a>
          <a title="ADD PENALTY POINT" href="<?php echo base_url();?>employee/employee_penalty_point/0"  class="btn btn-primary btn-xs addpenalty"><b>+</b> PENALTY POINT ORDER</a>
        </div>
        <div class="divfilter">
          <div class="box-body">
          <form name="form" action="<?php echo current_url();?>" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Month Start</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm" autocomplete="off" name="datestart" id="datestart" required="">
                </div>
              </div>
              <div class="form-group">
                <label class="left">Month End</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm" autocomplete="off" name="dateend" id="dateend" required="">
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
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
            <tr>
              <th id="order" class=" alignCenter">No</th>
              <th class=" alignCenter">ID</th>
              <th class=" alignCenter">NIP</th>
              <th class=" alignCenter">Name</th>
              <th class=" alignCenter">Job Position</th>
              <th class=" alignCenter">Penalty</th>
              <th class=" alignCenter">Total Nominal</th>
              <th class=" alignCenter"></th>
            </tr>
            </thead>
            <tbody>
            <?php
              if (isset($content['main'])) { $no=0;
                foreach ($content['main'] as $row => $list) {
                  $no++;?>
                  <tr>
                    <td class=" alignCenter"><?php echo $no; ?></td>
                    <td><?php echo $list['EmployeeID']; ?></td>
                    <td><?php echo $list['NIP']; ?></td>
                    <td><?php echo $list['fullname']; ?></td>
                    <td><?php echo $list['LevelName']; ?></td>
                    <td class=" alignCenter"><?php echo $list['penalty']." x"; ?></td>
                    <?php if($list['PenaltyID']!='7'){?>
                      <td class=" alignRight"><?php echo "Rp ".number_format($list['Nominal'])." + ".$list['Note']; ?></td>
                    <?php } else {?>
                      <td class=" alignRight"><?php echo "Rp ".number_format($list['Nominal']); ?></td>
                    <?php } ?>
                    <td>
                      <button type="button" class="btn btn-primary btn-xs detail" title="DETAIL" datestart="<?php echo $list['datestart']; ?>" dateend="<?php echo $list['dateend']; ?>" id="<?php echo $list['EmployeeID']; ?>" data-toggle="modal" data-target="#modal-detail"><i class="fa fa-fw fa-search"></i></button>
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
<script src="<?php echo base_url();?>tool/jquery.inputmask.bundle.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
	 
  $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "columnDefs": [ {
      "targets": 4,
      "orderable": false
    } ],
    "order": [[ 0, "asc" ]]
  });

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  };
  $('#dt_list').resize(cek_dt);

  $(".filter").click(function(){
    $(".divfilter").slideToggle();
  });

  $("#datestart").datepicker({ 
      format: "yyyy-mm-dd",
      autoclose: true, 
      format: 'yyyy-mm-dd',
      // viewMode: "months", 
      // minViewMode: "months"
  }).on('changeDate', function (selected) {
      var minDate = new Date(selected.date.valueOf());
      $('#dateend').datepicker('setStartDate', minDate);
  });
  $("#dateend").datepicker({ 
      format: "yyyy-mm-dd",
      autoclose: true, 
      format: 'yyyy-mm-dd',
      // viewMode: "months", 
      // minViewMode: "months"
  }).on('changeDate', function (selected) {
      var maxDate = new Date(selected.date.valueOf());
      $('#datestart').datepicker('setEndDate', maxDate);
  });
  
  $('.detail').live('click', function(e){
    id  = $(this).attr("id")
    datestart  = $(this).attr("datestart")
    dateend  = $(this).attr("dateend")
    get(id, datestart, dateend);
  });
  function get(id, datestart, dateend) {
    xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>employee/employee_penalty_detail"
    url=url+"?id="+id+"&datestart="+datestart+"&dateend="+dateend
    document.getElementById("detailcontent").innerHTML='<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
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

</script>