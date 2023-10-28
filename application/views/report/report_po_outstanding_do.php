<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">

<style type="text/css"> 
  /*css fixed column*/
  .DTFC_LeftWrapper thead th, .DTFC_RightWrapper thead th,
  .DTFC_LeftWrapper tbody td, .DTFC_RightWrapper tbody td {
    font-size: 12px !important;
  }
  .DTFC_LeftWrapper tbody td, .DTFC_RightWrapper tbody td {
    padding: 4px !important;
    vertical-align: text-top;
    height: 28px;
  }
  /*.DTFC_LeftBodyLiner { overflow-y:unset !important }*/
  /*.DTFC_RightBodyLiner { overflow-y:unset !important }*/
  /*---------------------*/
 
  .Ready { background: #73ba76e0 !important; }
  .ReadySebagian { background: #f2ff6c !important; }
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
        <?php $this->load->view('general/filter_warehouse.php'); ?>
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered " style="width: 100%;">
          <thead>
            <tr>
              <th class=" alignCenter">RO ID</th>
              <th class=" alignCenter">PO ID</th>
              <th class=" alignCenter">PO Date</th>
              <th class=" alignCenter">Supplier</th>
              <th class=" alignCenter">Employee</th>
              <th class=" alignCenter">Ship Schedule</th>
              <th class=" alignCenter">Qty RAW</th>
              <th class=" alignCenter">Qty Sent</th>
              <th class=" alignCenter">Qty Ready</th>
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
                      <td><?php echo $list['POID'];?></td>
                      <td><?php echo $list['PODate'];?></td>
                      <td><?php echo $list['supplier'];?></td>
                      <td><?php echo $list['employee'];?></td>
                      <td><?php echo $list['ShippingDate'];?></td>
                      <td><?php echo $list['qty'];?></td>
                      <td><?php echo $list['qtysent'];?></td>
                      <td><?php echo $RawReady;?></td>
                      <td>
                        <button type="button" class="btn btn-primary btn-xs printpo" poid="<?php echo $list['POID'];?>" title="PRINT"><i class="fa fa-fw fa-file-text-o"></i></button>
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
    "order": [[ 0, "asc" ]],
    fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {  
        if ( aData[8] === "Ready" ) { 
          jQuery(nRow).addClass('Ready');
        } else if ( aData[8] === "NotReady,Ready" ) {
          jQuery(nRow).addClass('ReadySebagian');
        } else if ( aData[8] === "Partial" ) {
          jQuery(nRow).addClass('ReadySebagian');
        } 
    },
  })

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

  var popup;
  function openPopupOneAtATime(x,y) {
      if (popup && !popup.closed) {
         popup.focus();
         if (y == "po") {
            popup.location.href = '<?php echo base_url();?>transaction/purchase_order_print2?po='+x;
         } else {
            popup.location.href = '<?php echo base_url();?>transaction/sales_order_print?so='+x;
         }
      } else {
         if (y == "po") {
            popup = window.open('<?php echo base_url();?>transaction/purchase_order_print2?po='+x, '_blank', 'width=800,height=650,left=200,top=20');     
         } else {
            popup = window.open('<?php echo base_url();?>transaction/sales_order_print?so='+x, '_blank', 'width=800,height=650,left=200,top=20');     
         }
      }
  }
  function openPopupOneAtATime2(x) {
    if (popup && !popup.closed) {
      popup.focus();
      popup.location.href = '<?php echo base_url();?>transaction/sales_order_print_no?so='+x;
    } else {
      popup = window.open('<?php echo base_url();?>transaction/sales_order_print_no?so='+x, '_blank', 'width=800,height=650,left=200,top=20');     
    }
  }
  $(".printpo").live('click', function() {
    poid = $(this).attr("poid")
    openPopupOneAtATime(poid,"po");
  });
  $(".printso").live('click', function() {
    soid = $(this).attr("soid")
    openPopupOneAtATime(soid,"so");
  });
  $(".printso2").live('click', function() {
    soid = $(this).attr("soid")
    openPopupOneAtATime2(soid,"so");
  });
});
</script>