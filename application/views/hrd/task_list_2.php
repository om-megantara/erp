<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">

<style type="text/css">

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
    <div class="box box-solid">
     <div class="box-header with-border">
        <a href="<?php echo base_url();?>hrd/task_cu/new" id="addtask" class="addtask" target="_blank"><b>+</b> Add Task</a>
      </div>
      <div class="box-body">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_open" data-toggle="tab" aria-expanded="false">OPEN TASK</a></li>
              <li class=""><a href="#tab_close" data-toggle="tab" aria-expanded="false">CLOSE TASK</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_open">
                <table id="dt_list" class="table table-bordered " style="width: 100%;">
                  <thead>
                    <tr>
                      <th>ID</th>
					  <th width="30%">Task Description</th>
					  <th>Created</th>
					  <th>Assigned</th>
					  <th>Cc</th>
					  <th width="7%"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                          // echo count($content);
                      if (isset($content['open'])) {
                          foreach ($content['open'] as $row => $list) {?>
							  <tr>
								<td><?php echo $list['TaskID'];?></td>
								<td><?php echo $list['TaskDescription'];?></td>
								<td><?php echo $list['LevelName']."-".$list['LevelName2'];?></td>
								<td><?php echo $list['LevelAssignedName']."-".$list['LevelAssignedName2'];?></td>
								<td><?php echo $list['LevelCcName']."-".$list['LevelCcName2'];?></td>
								<td><a href="#" id="view" class="dtbutton" style="margin: 0px;" data-toggle="modal" data-target="#modal-contact"><i class="fa fa-fw fa-eye"></i>
								</a>&nbsp;<a href="<?php echo base_url();?>hrd/task_cu/<?php echo $list['TaskID'];?>" id="edit" class="edit" style="margin: 0px; display: <?php echo $list['DisplayEdit']; ?>" target="_blank" title="EDIT"><i class="fa fa-fw fa-edit"></i></a>&nbsp;<a href="<?php echo base_url();?>hrd/task_list_comment/<?php echo $list['TaskID'];?>" id="edit" class="edit" style="margin: 0px;" target="_blank" title="COMMENT"><i class="fa fa-fw fa-edit"></i></a></td>
							  </tr>
                    <?php } } ?>
                  </tbody>
                </table>
              </div>
              <div class="tab-pane" id="tab_close">
                <table id="dt_list2" class="table table-bordered " style="width: 100%;">
                  <thead>
                    <tr>
                      <th>ID</th>
					  <th width="30%">Task Description</th>
					  <th>Created</th>
					  <th>Assigned</th>
					  <th>Cc</th>
					  <th width="7%"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      if (isset($content['close'])) {
                          foreach ($content['close'] as $row => $list) {?>
							  <tr>
								<td><?php echo $list['TaskID'];?></td>
								<td><?php echo $list['TaskDescription'];?></td>
								<td><?php echo $list['LevelName']."-".$list['LevelName2'];?></td>
								<td><?php echo $list['LevelAssignedName']."-".$list['LevelAssignedName2'];?></td>
								<td><?php echo $list['LevelCcName']."-".$list['LevelCcName2'];?></td>
								<td><a href="#" id="view" class="dtbutton" style="margin: 0px;" data-toggle="modal" data-target="#modal-contact"><i class="fa fa-fw fa-eye"></i>
								</a>&nbsp;<a href="<?php echo base_url();?>hrd/task_cu/<?php echo $list['TaskID'];?>" id="edit" class="edit" style="margin: 0px; display: <?php echo $list['DisplayEdit']; ?>" target="_blank" title="EDIT"><i class="fa fa-fw fa-edit"></i></a>&nbsp;<a href="<?php echo base_url();?>hrd/task_list_comment/<?php echo $list['TaskID'];?>" id="edit" class="edit" style="margin: 0px;" target="_blank" title="COMMENT"><i class="fa fa-fw fa-edit"></i></a></td>
							  </tr>
                    <?php } } ?>
                  </tbody>
                </table>
              </div>
            </div>
        </div>
        
      </div>
    </div>
	<div class="modal fade" id="modal-contact">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Detail Task</h4>
          </div>
          <div class="modal-body">
            <div id="detailcontentAjax"></div>
          </div>
          <div class="modal-footer">
          </div>
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
	 
  $('a[data-toggle="tab"]').on( 'click', function (e) {
      setTimeout( function order() {
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
      }, 500)
  } );
  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "order": [[ 0, "desc" ]]
  })
  var table2 = $('#dt_list2').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "order": [[ 0, "desc" ]]
  })

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);
  $('#dt_list2').resize(cek_dt);

  $('#view').live('click',function(e){
    var
      par = $(this).parent().parent();
      id  = par.find("td:nth-child(1)").html();
      get(id);
  });
});
function get(id) {
  xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>hrd/task_list_detail"
    url=url+"?a="+id
    xmlHttp.onreadystatechange=stateChanged
    xmlHttp.open("GET",url,true)
    xmlHttp.send(null)
}
function stateChanged(){
    if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
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
</script>