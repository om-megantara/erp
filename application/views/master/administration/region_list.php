<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css"> 
  .form-addregion, .form-editwarehouse {
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
      <div class="box-header">
        <a title="ADD REGION" href="<?php echo base_url();?>master/region_cu" id="addregion" class="btn btn-primary btn-xs addregion"><b>+</b> Add Region</a><br>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
              <tr>
                <th class=" alignCenter">ID</th>
                <th class=" alignCenter">Name</th>
                <th class=" alignCenter">Code</th>
                <th class=" alignCenter">SEC</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            <?php
                // echo count($content);
                foreach ($content as $row => $list) {?>
                  <tr>
                    <td class=" alignCenter"><?php echo $list['RegionID'];?></td>
                    <td><?php echo $list['RegionName'];?></td>
                    <td class=" alignCenter"><?php echo $list['RegionCode'];?></td>
                    <td><?php echo $list['fullname'];?></td>
                    <td><a title="EDIT" href="<?php echo base_url();?>master/region_cu?id=<?php echo $list['RegionID'];?>" id="edit" class="btn btn-success btn-xs edit" style="margin: 0px;" ><i class="fa fa-fw fa-edit"></i></a></td>
                  </tr>
            <?php } ?>
        
            </tbody>
          </table>
      </div>
      <div class="box-footer">
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
    "columnDefs": [ {"targets": 4,"orderable": false} ],
    "order": [[0,"asc"]]
  });
  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  };
  $('#dt_list').resize(cek_dt);
});
</script>