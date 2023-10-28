<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/datatables/media/css/jquery.dataTables.css">
<style type="text/css">  
  #detailcontentAjax {
    background-color: #dbdbdb;
    padding: 10px;
  }
</style>

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <?php echo $PageTitle.' - '. $MainTitle; ?>
    </h1>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <a href="<?php echo base_url();?>master/price_list_cu/new" id="addEmployee" class="addEmployee" target="_blank"><b>+</b> Add Price List</a>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover" width="100%">
            <thead>
            <tr>
              <th id="order">NO</th>
              <th> Pricelist Name</th>
              <th> Pricelist Start</th>
              <th> Pricelist End</th>
              <th> Note</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
              foreach ($content as $row => $list) {?>
                <tr>
                  <td><?php echo $list['PricelistID'];?></td>
                  <td><?php echo $list['PricelistName'];?></td>
                  <td><?php echo $list['DateStart'];?></td>
                  <td><?php echo $list['DateEnd'];?></td>
                  <td><?php echo $list['PricelistNote'];?></td>
                  <td>
                    <a href="#" class="dtbutton" id="view" data-toggle="modal" data-target="#modal-contact"><i class="fa fa-fw fa-eye"></i></a>
                    <a href="<?php echo base_url();?>master/price_list_cu/<?php echo $list['PricelistID'];?>" id="edit" class="edit" style="margin: 0px;" target="_blank" title="EDIT"><i class="fa fa-fw fa-edit"></i></a>
                  </td>
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
            <h4 class="modal-title">Detail Pricelist</h4>
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
<script language="javascript" src="<?php echo base_url();?>tool/datatables/media/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
	$( "li.menu_master" ).addClass( "active" );
  var oTable = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
    "scrollX": true,
     "scrollY": true,
    "columnDefs": [ {
      "targets": 5,
      "orderable": false
    } ],
    "order": [[ 0, "desc" ]]
  });

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);
  
  $('#view').live('click',function(e){
    var
      par = $(this).parent().parent();
      id  = par.find("td:nth-child(1)").html();
      get(id);
  });
});


function get(id) {
  xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>master/price_list_detail"
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