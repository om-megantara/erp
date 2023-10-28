<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">

<style type="text/css"> 
  #detailcontent {
    padding: 10px !important;
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
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>

  <section class="content">
    <div class="box box-solid">
      <div class="box-header">
        <a href="<?php echo base_url();?>accounting/report_formula_add" id="report_formula_add" class="btn btn-primary btn-xs report_formula_add"><b>+</b> Add Formula</a>
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered " style="width: 100%;">
          <thead>
            <tr>
              <th>Report ID</th>
              <th>Report Name</th>
              <th></th>
            </tr>
          </thead>
          <tbody> 
            <?php
              if (isset($content)) {
                  foreach ($content as $row => $list) { ?>
                  <tr>
                    <td><?php echo $list['ReportID'];?></td>
                    <td><?php echo $list['ReportName'];?></td>
                    <td>
                      <button type="button" class="btn btn-info btn-xs ViewReport" title="VIEW" report="<?php echo $list['ReportID'];?>"><i class="fa fa-fw fa-file-text-o"></i></button>
                      <button type="button" class="btn btn-success btn-xs EditReport" title="EDIT" onclick="location.href='<?php echo base_url();?>accounting/report_formula_add?report=<?php echo $list['ReportID']; ?>';"><i class="fa fa-fw fa-edit"></i></button>
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
    "columnDefs": [
        {"targets": 0, "width": "10%"},
        {"targets": 2, "width": "10%"},
    ],
  })

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);
  
  $('.ViewReport').live('click', function(e){
        ReportID  = $(this).attr("report")
        get(ReportID);
  });
  function get(ReportID) {
      $('#detailcontent').html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>')
      xmlHttp=GetXmlHttpObject()
      var url="<?php echo base_url();?>accounting/report_formula_detail"
      url=url+"?report="+ReportID

      var win = window.open(url, '_blank');
      if (win) {
          win.focus();
      } else {
          alert('Please allow popups for this website');
      }

      // xmlHttp.onreadystatechange=stateChanged
      // xmlHttp.open("GET",url,true)
      // xmlHttp.send(null)
  } 
  function stateChanged(){
      if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
          $('#detailcontent').html(xmlHttp.responseText)
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
 
</script>