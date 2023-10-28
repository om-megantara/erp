<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">

<style type="text/css"> 
  .Ready { background: #73ba76e0 !important; }
  .ReadySebagian { background: #f2ff6c !important; }
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
        <?php $this->load->view('general/filter_warehouse.php'); ?>
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered " style="width: 100%;">
          <thead>
            <tr>
              <th>ROID</th>
              <th>Date Schedule</th>
              <th>Date Input</th>
              <th>Employee</th>
              <th>Note</th>
              <th>Qty Order</th>
              <th>Qty PO</th>
              <th>Raw Ready</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
                  // echo count($content);
              if (isset($content)) {
                  foreach ($content as $row => $list) { 
                    $RawReady = ($list['stockReady'] == 'NotReady,Ready') ? 'Partial' : $list['stockReady'] ;
            ?>
                  <tr>
                      <td><?php echo $list['ROID'];?></td>
                      <td><?php echo $list['RODate'];?></td>
                      <td><?php echo $list['ModifiedDate'];?></td>
                      <td><?php echo $list['fullname'];?></td>
                      <td><?php echo $list['RONote'];?></td>
                      <td><?php echo $list['qty'];?></td>
                      <td><?php echo $list['qtypo'];?></td>
                      <td><?php echo $RawReady;?></td>
                      <td>
                        <button type="button" class="btn btn-primary btn-xs detailraw" title="DETAIL RAW" roid="<?php echo $list['ROID'];?>" data-toggle="modal" data-target="#modal-detail"><i class="fa fa-fw fa-reorder"></i></button>
                        <button type="button" class="btn btn-success btn-xs" title="CREATE PO" onclick="location.href='<?php echo base_url();?>transaction/purchase_order_add?ro=<?php echo $list['ROID']; ?>';"><i class="fa fa-fw fa-edit"></i></button>
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
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
	 
  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "order": [[ 0, "asc" ]],
    fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {  
        if ( aData[7] === "Ready" ) { 
          jQuery(nRow).addClass('Ready');
        } else if ( aData[7] === "NotReady,Ready" ) {
          jQuery(nRow).addClass('ReadySebagian');
        } else if ( aData[7] === "Partial" ) {
          jQuery(nRow).addClass('ReadySebagian');
        } 
    },
  })
  
  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);
}); 

  $('.detailraw').live('click', function(e){
        roid  = $(this).attr("roid")
        get2(roid);
  }); 
  function get2(roid) {
    document.getElementById("detailcontent").innerHTML='<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
    xmlHttp=GetXmlHttpObject()
      var url="<?php echo base_url();?>transaction/request_order_detail_raw_full"
      url=url+"?roid="+roid
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
</script>