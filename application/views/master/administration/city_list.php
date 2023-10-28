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
      <div class="box-header with-border"> 
        <a href="#" id="tr-filter" class="btn btn-primary btn-xs tr-filter"><i class="fa fa-search"></i> Filter by Column</a>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap">
            <thead>
              <tr>
                <th class=" alignCenter">ID</th>
                <th class=" alignCenter">Province</th>
                <th class=" alignCenter">City</th>
                <th class=" alignCenter">Expedition</th>
                <th class=" alignCenter">Price /KG</th>
                <th class=" alignCenter">Minimum /KG</th>
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
                    <td><?php echo $list['Expedisi'];?></td>
                    <td><?php echo $list['FCPrice'];?></td>
                    <td><?php echo $list['FCWeight'];?></td>
                    <td><a title="EDIT" href="<?php echo base_url();?>master/city_cu?id=<?php echo $list['CityID'];?>" id="edit" class=" btn btn-success btn-xs edit" style="margin: 0px;" ><i class="fa fa-fw fa-edit"></i></a></td>
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
	
  th_filter_hidden = [0,5,6,7,8]
  $('#dt_list thead tr').clone(true).appendTo( '#dt_list thead' );
  $('#dt_list thead tr:eq(0)').addClass('tr-filter-column')
  $('#dt_list thead tr:eq(0) th').each( function (i) {
    if (th_filter_hidden.indexOf(i) < 0) {
      var title = $(this).text();
      $(this).html( '<input type="text" class="input-filter-column input input-sm" placeholder="Search '+title+'" />' );

      $( 'input', this ).on( 'keyup change', function () {
          if ( table.column(i).search() !== this.value ) {
              table
                  .column(i)
                  .search( this.value )
                  .draw();
          }
      });
    } else {
      $(this).text('')
    }
  });

  $(".tr-filter").click(function(){
    $(".tr-filter-column").slideToggle().focus();
  }); 
  table =$('#dt_list').DataTable({
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