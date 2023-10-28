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
      <div class="box-body">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_po" table="dt_list" data-toggle="tab" aria-expanded="false">FROM PO </a></li>
              <li class=""><a href="#tab_mutation" table="dt_list2" data-toggle="tab" aria-expanded="false">FROM MUTATION</a></li>
              <li class=""><a href="#tab_inv" table="dt_list3" data-toggle="tab" aria-expanded="false">FROM INV</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_po">
                <table id="dt_list" class="table table-bordered " style="width: 100%;">
                  <thead>
                    <tr>
                      <th>POID</th>
                      <th>PO Date</th>
                      <th>Supplier</th>
                      <th>Employee</th>
                      <th>Note</th>
                      <th>Shp Schd</th>
                      <th>Status</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                          // echo count($content);
                      if (isset($content)) {
                          foreach ($content as $row => $list) { ?>
                          <tr>
                              <td><?php echo $list['POID'];?></td>
                              <td><?php echo $list['PODate'];?></td>
                              <td><?php echo $list['supplier'];?></td>
                              <td><?php echo $list['employee'];?></td>
                              <td><?php echo $list['PONote'];?></td>
                              <td><?php echo $list['ShippingDate'];?></td>
                              <td>
                                <?php if ($list['POStatus'] == "1") { ?>
                                  <i class="fa fa-fw fa-check-square-o" style="color: green;"></i>
                                <?php } else if ($list['POStatus'] == "2") { ?>
                                  <i class="fa fa-fw fa-times" style="color: red;"></i>
                                <?php } ?>
                              </td>
                              <td>
                                <button type="button" class="btn btn-primary btn-xs printpo" poid="<?php echo $list['POID'];?>" title="PRINT"><i class="fa fa-fw fa-file-text-o"></i></button>
                                
                                <?php if ($list['POStatus'] == "0") { ?>
                                <button type="button" class="btn btn-success btn-xs" title="PROCEED" onclick="location.href='<?php echo base_url();?>transaction/delivery_order_received_add?po=<?php echo $list['POID']; ?>';"><i class="fa fa-fw fa-edit"></i></button>
                                <?php } ?>

                              </td>
                          </tr>
                    <?php } } ?>
                  </tbody>
                </table>
              </div>
              <div class="tab-pane" id="tab_mutation">
                <div class="table-responsive">
                  <table id="dt_list2" class="table table-bordered " style="width: 100%;">
                    <thead>
                      <tr>
                        <th>Mutation ID</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Schedule</th>
                        <th>Input</th>
                        <th>Employee</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        if (isset($content2)) {
                            foreach ($content2 as $row => $list) { ?>
                            <tr>
                                <td><?php echo $list['MutationID'];?></td>
                                <td><?php echo $list['from'];?></td>
                                <td><?php echo $list['to'];?></td>
                                <td><?php echo $list['MutationDate'];?></td>
                                <td><?php echo $list['MutationInput'];?></td>
                                <td><?php echo $list['fullname'];?></td>
                                <td>
                                    <button type="button" class="btn btn-success btn-xs" title="EDIT" onclick="location.href='<?php echo base_url();?>transaction/delivery_order_received_add?mutationid=<?php echo $list['MutationID']; ?>';"><i class="fa fa-fw fa-edit"></i></button>
                                </td>
                            </tr>
                      <?php } } ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane" id="tab_inv">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group ">
                      <div class="input-group">
                        <div class="input-group-btn raw">
                          <button type="button" class="btn btn-sm btn-primary " title="ADD DOR" id="add_dor_inv">ADD DOR FROM INV</button>
                        </div>
                        <input type="text" class="form-control input-sm dor_inv" >
                      </div> 
                    </div>
                  </div>
                </div>
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

  var table1 = $('#dt_list').DataTable({
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

  var popup;
  function openPopupOneAtATime(x) {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>transaction/purchase_order_print2?po='+x;
      } else {
         popup = window.open('<?php echo base_url();?>transaction/purchase_order_print2?po='+x, '_blank', 'width=800,height=650,left=200,top=20');     
      }
  }
  $(".printpo").on('click', function() {
    poid = $(this).attr("poid")
    openPopupOneAtATime(poid);
  });
});

$('#add_dor_inv').on( 'click', function (e) {
    INVID = $(".dor_inv").val()
    window.open('<?php echo base_url();?>transaction/delivery_order_received_add?invid='+INVID);
} );
</script>