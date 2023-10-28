<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css">
  .form-addwarehouse, .form-editwarehouse {
    display: none;
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
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap">
            <thead>
              <tr>
                <th class=" alignCenter">ID</th>
                <th class=" alignCenter">Province</th>
                <th class=" alignCenter">City</th>
                <th class=" alignCenter">SEC</th>
                <th class=" alignCenter">Sales</th>
                <th class=" alignCenter">Target Omzet</th>
                <th class=" alignCenter">Target Retailer</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            <?php
                // echo count($content);
                foreach ($content as $row => $list) {?>
                  <tr>
                    <td class=" alignCenter"><?php echo $list['CityID'];?></td>
                    <td><?php echo $list['StateName']."-".$list['ProvinceName'];?></td>
                    <td><?php echo $list['CityName'];?></td>
                    <td><?php echo $list['SEC'];?></td>
                    <td><?php echo $list['Sales'];?></td>
                    <td><?php echo number_format($list['TargetOmzet']);?></td>
                    <td><?php echo $list['TargetCustomer'];?></td>
                    <td><a title="EDIT" href="<?php echo base_url();?>marketing/manage_city_cu?id=<?php echo $list['CityID'];?>" id="edit" class=" btn btn-success btn-xs edit" style="margin: 0px;" ><i class="fa fa-fw fa-edit"></i></a></td>
                  </tr>
            <?php } ?>
        
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
    // "columnDefs": [ {"targets": 6,"orderable": false} ],
    "order": [[ 1, "asc" ]]
  });
  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  };
  $('#dt_list').resize(cek_dt);
});
</script>