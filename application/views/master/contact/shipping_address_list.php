<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css"> 
  #detailcontentAjax {
    background-color: #dbdbdb;
    padding: 10px;
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
        <a href="<?php echo base_url();?>master/shipping_add" id="addShipping" class="addShipping" target="_blank"><b>+</b> Add Shipping</a>

      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
            <tr>
              <th id="order">ID</th>
              <th>Shipping Name</th>
              <th>Company</th>
              <th>Address</th>
              <th>City</th>
              <th>Phone</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
              $no = 0;
              foreach ($content['main'] as $row => $list) { $no++;
            ?>
                <tr>
                  <td><?php echo $list['SAID'];?></td>
                  <td><?php echo $list['SAName'];?></td>
                  <td><?php echo $list['Company'];?></td>
                  <td><?php echo $list['SAAddress'];?></td>
                  <td><?php echo $list['SACity'];?></td>
                  <td><?php echo $list['SAPhone'];?></td>
                  <!--<td><a href="#" class="dtbutton" id="view">VIEW</a></td>-->
                  <td><a href="#" class="dtbutton" id="view" data-toggle="modal" data-target="#modal-contact"><i class="fa fa-fw fa-file-image-o"></i></a><a href="<?php echo base_url();?>master/shipping_add?id=<?php echo $list['SAID'];?>" class="edit view" id="edit" style="margin: 0px;" target="_blank" title="EDIT"><i class="fa fa-fw fa-edit"></i></a></td>
                </tr>
            <?php } ?>
            </tbody>
          </table>
      </div>
      <div class="box-footer">
      </div>
    </div>
    <div class="modal fade" id="modal-contact">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Detail Shipping</h4>
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
   
  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "columnDefs": [ {
      "targets": 6,
      "orderable": false
    } ],
    "order": [[ 0, "asc" ]]
  });

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

  $('#view').live('click',function(e){
    //if( $('#detail').length ){ $('#detail').remove() }
    var
      par = $(this).parent().parent();
      id  = par.find("td:nth-child(1)").html();
      //$('<tr id="detail"><td colspan="7"><div id="detailcontentAjax"></div></td></tr>').insertAfter($(this).closest('tr'));
      get(id);
  });

});
function get(id) {
  xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>master/shipping_list_detail"
    url=url+"?a="+id
    // alert(url);
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