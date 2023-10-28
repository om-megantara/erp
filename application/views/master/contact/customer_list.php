<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css"> 

</style>
<div class="content-wrapper">
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
      <div class="box-header with-border">
        <a href="<?php echo base_url();?>master/customer_cu/new" id="addEmployee" class="addEmployee" target="_blank"><b>+</b> Add Customer</a>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
            <tr>
              <th id="order" class=" alignCenter">ID Contact</th>
              <th class=" alignCenter">ID Customer</th>
              <th class=" alignCenter">Customer Name</th>
              <th class=" alignCenter">Company</th>
              <th class=" alignCenter">Email</th>
              <th class=" alignCenter">Phone</th>
              <th class=" alignCenter">Category</th>
              <th class=" alignCenter">Status</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
              $no = 0;
              foreach ($content as $row => $list) { $no++;
                $sales = explode(",", $list['sales']); 
                if (in_array($EmployeeID, $sales) || in_array("customer_list_all", $MenuList)) {
                  if ($list['status'] == "Active") { ?>
                      <tr class="mini">
                    <?php } else { ?>
                      <tr class="mini" style="background-color: #cc8585">
                    <?php }; ?>
                  <td class=" alignCenter"><?php echo $list['ContactID'];?></td>
                  <td class=" alignCenter"><?php echo $list['CustomerID'];?></td>
                  <td><?php echo $list['fullname'];?></td>
                  <td><?php echo $list['Company'];?></td>
                  <td><?php echo $list['Email'];?></td>
                  <td><?php echo $list['Phone'];?></td>
                  <td><?php echo $list['CustomercategoryName'];?></td>
                  <td><?php echo $list['status'];?></td>
                  <td><a href="#" class="btn btn-xs" id="view" data-toggle="modal" data-target="#modal-contact" title="DETAIL"><i class="fa fa-fw fa-file-image-o"></i></a></td>
                </tr>
            <?php } } ?>
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
            <h4 class="modal-title">Detail Customer</h4>
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
      "targets": 8,
      "orderable": false
    } ],
    "order": [[ 0, "asc" ]]
  });

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();
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
    document.getElementById("detailcontentAjax").innerHTML='<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
    var url="<?php echo base_url();?>master/customer_list_detail"
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