<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<style type="text/css">
  .form-group { display: block; margin-bottom: 5px !important; }
  #reject { background-color: #dd4b39; }
  #approve { background-color: #00a65a; }

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
  <section class="content-header">
    <h1>
      <?php echo $PageTitle.' - '. $MainTitle; ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>

  <section class="content">

    <div class="modal fade" id="modal-note">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">DOR INVR Detail</h4>
            </div>
            <div class="modal-body">
              <div class="loader"></div>
              <div  class="detailcontentAjax" id="detailcontent"></div>
            </div>
        </div>
      </div>
    </div>

    <div class="box box-solid">
      <div class="box-body form_addcontact">
        <div class="col-md-12  no-padding">
          <table id="dt_list" class="table table-bordered table-hover nowrap dtapproval" width="100%">
            <thead>
            <tr>
              <th>No</th>
              <th>Title</th>
              <th>Note</th>
              <th>A1</th>
              <th>A2</th>
              <th>A3</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
              <?php
                if ($content['actor']!= "" && !empty($content['list'])) {
                  foreach ($content['list'] as $row => $list) { 
              ?>
                      <tr>
                        <td><?php echo $list['ApprovalID'];?></td>
                        <td><?php echo $list['Title'];?></td>
                        <td><?php echo $list['Note'];?></td>
                        <td class="alignCenter">
                          <?php if ($list['Actor1ID'] != "") { ?>
                            <i class="fa fa-fw fa-check-square-o" style="color: green;" title="CONFIRM <?php echo $list['Actor1'];?>"></i>
                            <span style="display:none;"><?php echo $list['Actor1'];?></span>
                          <?php }; ?>
                        </td>
                        <td class="alignCenter">
                          <?php if ($list['Actor2ID'] != "") { ?>
                            <i class="fa fa-fw fa-check-square-o" style="color: green;" title="CONFIRM <?php echo $list['Actor2'];?>"></i>
                            <span style="display:none;"><?php echo $list['Actor2'];?></span>
                          <?php }; ?>
                        </td>
                        <td class="alignCenter">
                          <?php if ($list['Actor3ID'] != "") { ?>
                            <i class="fa fa-fw fa-check-square-o" style="color: green;" title="CONFIRM <?php echo $list['Actor3'];?>"></i>
                            <span style="display:none;"><?php echo $list['Actor3'];?></span>
                          <?php }; ?>
                        </td>
                        <td>
                          <button type="button" class="btn btn-success btn-xs detail" title="DETAIL" id="<?php echo $list['ApprovalID'];?>" DORID="<?php echo $list['DORID'];?>" data-toggle="modal" data-target="#modal-note"><i class="fa fa-fw fa-edit"></i></button>
                        </td>
                      </tr>
              <?php } } ?>
            </tbody>
          </table>
        </div>
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
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
j8  = jQuery.noConflict();
j8( document ).ready(function( $ ) {
   
  $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
    "scrollX": true,
     "scrollY": true,
    "order": [[ 0, "desc" ]]
  });

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  };
  $('#dt_list').resize(cek_dt);

});

jQuery( document ).ready(function( $ ) {
  $('.detail').live('click', function(e){
      id = $(this).attr("id")
      DORID  = $(this).attr("DORID")
      $('.loader').slideDown("fast")
      $('#detailcontent').empty()
      get(DORID, id);
  });
  function get(DORID, id) {
    xmlHttp=GetXmlHttpObject()
      var url="<?php echo base_url();?>approval/approve_dor_invr_detail"
      url=url+"?DORID="+DORID+"&id="+id
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
  function GetXmlHttpObject(){
      var xmlHttp=null;
      try{
          xmlHttp=new XMLHttpRequest();
      }catch(e){
          xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      return xmlHttp;
  }

  $('.approve').live('click',function(e){
      DORID = $(this).attr('po');
      id   = $(this).attr('id');
      data = {DORID:DORID, id:id};
      var r = confirm("Apa anda yakin akan Approve?");
      if (r == true) {
        $.ajax({
          url: "<?php echo base_url();?>approval/approve_dor_invr_act/approve",
          type : 'POST',
          data : data,
          success : function (response) {
            window.location.href = "<?php echo current_url(); ?>";
          }
        })
      }
  });
  $('.reject').live('click',function(e){
      DORID = $(this).attr('po');
      id   = $(this).attr('id');
      data = {DORID:DORID, id:id};
      var r = confirm("Apa anda yakin akan Reject ?");
      if (r == true) {
        $.ajax({
          url: "<?php echo base_url();?>approval/approve_dor_invr_act/reject",
          type : 'POST',
          data : data,
          success : function (response) {
            window.location.href = "<?php echo current_url(); ?>";
          }
        })
      }
  });
});

</script>