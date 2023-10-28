<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<div class="content-wrapper"> 
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
        <a title="ADD PENALTY" href="<?php echo base_url();?>master/penalty_add" id="addpenalty" class="btn btn-primary btn-xs addpenalty"><b>+</b> ADD PENALTY NAME</a>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
            <tr>
              <th id="order" class=" alignCenter">ID</th>
              <th class=" alignCenter">Penalty Name</th>
              <th class=" alignCenter">Penalty Type</th>
              <th class=" alignCenter">Point</th>
              <th class=" alignCenter">Penalty Category</th>
              <th class=" alignCenter">Note</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
              if (isset($content)) {
                foreach ($content as $row => $list) {?>
                  <tr>
                    <td class=" alignCenter"><?php echo $list['PenaltyID'];?></td>
                    <td><?php echo $list['PenaltyName'];?></td>
                    <td><?php echo $list['PenaltyType'];?></td>
                    <td><?php echo $list['Quantity'];?></td>
                    <td><?php echo $list['PenaltyCategory'];?></td>
                    <td><?php echo $list['Note'];?></td>
                    <td>
                      <a href="<?php echo base_url();?>master/penalty_edit?PenaltyID=<?php echo $list['PenaltyID'];?>" id="edit" class="btn btn-success btn-xs edit" style="margin: 0px;" target="_blank" title="EDIT"><i class="fa fa-fw fa-edit"></i></a>
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
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
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

  $('#viewDetail').live('click',function(e){
      id = $(this).attr('shopid')
      get(id);
  });
});


function get(id) {
  xmlHttp=GetXmlHttpObject()
  var url="<?php echo base_url();?>master/shop_detail"
  url=url+"?shopid="+id
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