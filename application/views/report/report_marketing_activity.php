<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">
  .divfilterdate {
    display: none; 
    margin: 5px 0px;
    border: 1px solid #0073b7; 
    padding: 4px;
    overflow: auto;
  }
  @media (min-width: 768px){
      .form-group label.left {
        float: left;
        width: 130px;
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
        <?php if ($this->session->userdata('SalesID') != "0") { ?>
          <button type="button" class="btn btn-primary btn-xs" onclick="window.open('<?php echo base_url();?>marketing/marketing_activity_add', '_blank');" title='ADD ACTIVITY'><b>+</b> Add Activity</button>
        <?php } ?>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>
        <div class="divfilterdate">
          <form role="form" action="<?php echo current_url();?>" method="post" >
            <div class="col-md-6">
                <div class="form-group">
                  <label class="left">Month Start</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control input-sm" autocomplete="off" name="filterstart" id="datestart" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="left">Month End</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control input-sm" autocomplete="off" name="filterend" id="dateend" required="">
                  </div>
                </div>
            </div>
            <div class="col-md-12">
              <center>
                <button type="submit" class="btn btn-primary btn-sm pull-center">Submit</button>
              </center>
            </div>
          </form>
        </div>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Sales</th>
                <th>Total Activity</th>
                <th>Total Customer</th>
                <th>Total Pending</th>
                <th>Total Approve</th>
                <th>Total Reject</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            <?php
              if (isset($content)) {
                $urut=1;
               foreach ($content as $row => $list) { 
                $SalesID=$list['SalesID'];
                $Month=$list['Month'];
            ?>
                  <tr>
                    <td><?php echo $urut;?></td>
                    <td><?php echo $list['SalesName'];?></td>
                    <td><?php echo "Total CFU = ".$list['CFU'];?><br><?php echo "Total CV = ".$list['CV'];?></td>
                    <td><?php echo "Total Customer CFU = ".$list['CustomerCFU'];?><br><?php echo "Total Customer CV = ".$list['CustomerCV'];?></td>
                    <td><?php if ($EmployeeID==14){?><a href="../approval/approve_marketing_activity"><?php echo "Total CFU Pending = ".$list['CFUNotApprove'];?></a><br><a href="../approval/approve_marketing_activity"><?php echo "Total CV Pending = ".$list['CVNotApprove'];?></a><?php } else { echo "Total CFU Pending = ".$list['CFUNotApprove'];?><br><?php echo "Total CV Pending = ".$list['CVNotApprove']; }?></td>
                    <td><?php echo "Total CFU Approved = ".$list['CFUApprove'];?><br><?php echo "Total CV Approved = ".$list['CVApprove'];?></td>
                    <td><?php echo "Total CFU Reject = ".$list['CFUReject'];?><br><?php echo "Total CV Reject = ".$list['CVReject'];?></td>
                    <td><?php if($list['CFUApprove']!=0 || $list['CVApprove']!=0){ ?><button type="button" class="btn btn-primary btn-xs" onclick="window.open('<?php echo base_url();?>report/marketing_activity_print?SalesID=<?php echo $SalesID;?>&Month=<?php echo $Month;?>', '_blank');" title='PRINT'><i class="fa fa-fw fa-print"></i> Print</button><?php } ?></td>
                  </tr>
            <?php $urut++;} } ?>
            </tbody>
          </table>
      </div>
    </div>
 
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
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
     "scrollY": true, 
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

  $("#datestart").datepicker({ 
    format: "yyyy-mm-dd",
    viewMode: "months", 
    minViewMode: "months"
  }).on('changeDate', function (selected) {
    var minDate = new Date(selected.date.valueOf());
    $('#dateend').datepicker('setStartDate', minDate);
  });
  $("#dateend").datepicker({ 
    format: "yyyy-mm-dd",
    viewMode: "months", 
    minViewMode: "months"
  }).on('changeDate', function (selected) {
    var maxDate = new Date(selected.date.valueOf());
    $('#datestart').datepicker('setEndDate', maxDate);
  });

  $(".filterdate").click(function(){
    $(".divfilterdate").slideToggle();
  });

  $(".deleteActivity").click(function(e) { 
    ActivityID = $(this).attr('ActivityID')
    errornote  = "This Activity will be deleted!\nare you sure?"
    var r = confirm(errornote);
    if (r == false) {
      e.preventDefault();
      return false
    } else {
      location.href = '<?php echo base_url();?>marketing/marketing_activity_delete?ActivityID='+ActivityID;
    }
  });
});

</script>