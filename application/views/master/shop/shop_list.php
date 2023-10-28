<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css">  
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
        <a title="ADD SHOP" href="<?php echo base_url();?>master/shop_cu/new" id="addshop" class="btn btn-primary btn-xs addshop"><b>+</b> ADD/EDIT SHOP</a>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
            <tr>
              <th id="order" class=" alignCenter">ID</th>
              <th class=" alignCenter">Shop Name</th>
              <th class=" alignCenter">Note</th>
              <th class=" alignCenter">Sales</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
              if (isset($content)) {
                foreach ($content as $row => $list) {?>
                  <tr>
                    <td class=" alignCenter"><?php echo $list['ShopID'];?></td>
                    <td><?php echo $list['ShopName'];?></td>
                    <td><?php echo $list['ShopNote'];?></td>
                    <td><?php echo $list['SalesName'];?></td>
                    <td>
                      <a href="<?php echo base_url();?>master/shop_cu/<?php echo $list['ShopID'];?>" id="edit" class="btn btn-success btn-xs edit" style="margin: 0px;" target="_blank" title="EDIT"><i class="fa fa-fw fa-edit"></i></a>
                      <a href="<?php echo base_url();?>master/shop_update_link/<?php echo $list['ShopID'];?>" id="edit" class="btn btn-success btn-xs edit" style="margin: 0px;" target="_blank" title="UPDATE LINK"><i class="fa fa-fw fa-link"></i></a>
                      <a href="#" class="btn btn-success btn-xs dtbutton" id="viewDetail" shopid="<?php echo $list['ShopID'];?>" data-toggle="modal" data-target="#modal-info"><i class="fa fa-fw fa-info"></i></a>
                    </td>
                  </tr>
            <?php } } ?>
        
            </tbody>
          </table>
      </div>
    </div>

    <div class="modal fade" id="modal-info">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Detail Shop</h4>
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