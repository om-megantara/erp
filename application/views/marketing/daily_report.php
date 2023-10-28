<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">
  @media (min-width: 768px){
      .form-group label.left {
        float: left;
        width: 130px;
        /*padding: 5px 15px 5px 5px;*/
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
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>

  <section class="content">
    <div class="box box-solid">
      <div class="box-header with-border">
        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal-add"><b>+</b> Add Report</button>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
              <tr>
                <th>Sales</th>
                <th>Company</th>
                <th>Note</th>
                <th>Last Update</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($content as $row => $list) { ?>
                  <tr>
                    <td><?php echo $list['fullname'];?></td>
                    <td><?php echo $list['Company'];?></td>
                    <td><?php echo $list['Note'];?></td>
                    <td><?php echo $list['LastDate'];?></td>
                    <td>
                      <button type="button" class="btn btn-primary btn-xs detail" title="DETAIL" daily="<?php echo $list['DailyID']; ?>"><i class="fa fa-fw fa-search"></i></button>
                    </td>
                  </tr>
            <?php } ?>
            </tbody>
          </table>
      </div>
    </div>

    <div class="modal fade" id="modal-add">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Add Daily Report</h4>
          </div>
          <div class="modal-body">

            <form role="form" action="<?php echo base_url();?>marketing/daily_report_add_act" method="post" >
              <div class="form-group">
                <label class="left">Customer</label>
                <span class="left2">
                  <select class="form-control input-sm customer" name="customer" required="" style="width: 100% !important;"></select>
                </span>
              </div>
              <div class="form-group">
                <label class="left">Note</label>
                <span class="left2">
                  <textarea class="form-control input-sm" rows="3" name="note">Report Kunjungan Harian</textarea>
                </span>
              </div>
              <button type="submit" class="btn btn-primary pull-right">Submit</button>
            </form>

          </div>
          <div class="modal-footer" style="margin-top: 25px;">
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
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
	 
  var oTable = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
    "columnDefs": [ 
      {"targets": 0,"orderable": false,"width": "1%"},
      {"targets": 2, "width": "40%"},
      {"targets": 4, "width": "1%"}
    ],
    "order": [[ 3, "asc" ]],
    "searchDelay": 2000,
    "processing": true, 
    "language": { processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '}, 
    // "serverSide": false, 
    // "ajax": {
    //   "url": "<?php echo site_url('marketing/daily_report_list')?>",
    //   "type": "POST",
    //   "data": function ( data ) {
    //       data.page = "nothing";
    //   }
    // }
  });

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

  $('.customer').select2({
    placeholder: 'Minimum 3 char, Company',
    minimumInputLength: 3,
    ajax: {
      url: '<?php echo base_url();?>general/search_customer_having_sales',
      dataType: 'json',
      delay: 1000,
      processResults: function (data) {
        return {
          results: data
        };
      },
      cache: true
    }
  });

  $('.detail').live( 'click', function (e) {
      val = $(this).attr("daily")
      var myview = window.open('<?php echo base_url();?>marketing/daily_report_detail?id='+val);
  });
});

</script>