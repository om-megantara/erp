<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">
  .form-group { display: block; margin-bottom: 5px !important; }
  #reject { background-color: #dd4b39; }
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

<?php 
// print_r($content['personal']); 
$actor = $content['actor']['Actor1'] != $EmployeeID ? : "Actor1";
$actor = $content['actor']['Actor2'] != $EmployeeID ? $actor : "Actor2";
$actor = $content['actor']['Actor3'] != $EmployeeID ? $actor : "Actor3";
?>

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
        <?php if ($this->session->userdata('SalesID') != "0") { ?>
          <button type="button" class="btn btn-primary btn-xs" onclick="window.open('<?php echo base_url();?>marketing/marketing_activity_add', '_blank');" title='ADD ACTIVITY'><b>+</b> Add Activity</button>
        <?php } ?>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>
        <div class="divfilterdate">
          <form role="form" action="<?php echo current_url();?>" method="post" >
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Customer</label>
                <span class="left2">
                  <input type="text" class="form-control customer" autocomplete="off" name="customer" id="customer">
                </span>  
              </div>
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
      <div class="box-body form_addcontact">
          <table id="dt_list" class="table table-bordered table-hover nowrap dtapproval" width="100%">
            <thead>
            <tr>
              <th class="alignCenter">ID</th>
              <th class="alignCenter">City</th>
              <th class="alignCenter">Tanggal</th>
              <th class="alignCenter">Customer</th>
              <th class="alignCenter">Category</th>
              <th class="alignCenter">Sales</th>
              <th class="alignCenter">Type</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
              <?php 
                foreach ($content['list'] as $row => $list) { ?>
                  <tr>
                    <td><?php echo $list['ActivityID'];?></td>
                    <td>
                      <a href="#" class="detail" id="<?php echo $list['CityID']; ?>"  cityname="<?php echo $list['CityName']; ?>" data-toggle="modal" data-target="#modal-detail"><?php echo $list['CityName'];?></a>
                    </td>
                    <td><?php echo $list['ActivityDate'];?></td>
                    <td><a href="<?php echo base_url();?>master/customer_cu/<?php echo $list['ContactID'];?>" target="_blank"><?php echo wordwrap($list['customer']." (".$list['customerid'].")", 20,"<br>\n");?></a></td>
                    <td><?php echo $list['CustomercategoryName'];?></td>
                    <td><?php echo wordwrap($list['sales'], 20,"<br>\n");?></td>
                    <td><?php if($list['ActivityType']=="Customer Follow Up (CFU)"){echo "CFU";} else {echo "CV";} ?></td>
                    <td>
                      <a href='#' class='btn btn-danger btn-xs dtbutton' id='cancel' data='<?php echo $actor; ?>' ActivityID='<?php echo $list['ActivityID']?>'>Cancel</a>
                    </td>
                  </tr>
              <?php } ?>
            </tbody>
          </table>
      </div>
    </div>
  </section>
 
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/jquery-ui.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
j8  = jQuery.noConflict();
j8( document ).ready(function( $ ) {
   
  $('#dt_list').DataTable({
    "pageLength": <?php echo '200';?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "columnDefs": [ {
      "targets": 6,
      "orderable": false
    } ],
    "order": [[ 0, "asc" ]]
  });

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
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

  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});

jQuery( document ).ready(function( $ ) {

  // window.setTimeout(function(){location.reload()},60000);
  $('#cancel').live('click',function(e){
    alert('This Activity will be Cancel!\nare you sure?')
    var
      user = $(this).attr('data');
      ActivityID = $(this).attr('ActivityID');
      data = {user:user, ActivityID:ActivityID};
      $.ajax({
        url: "<?php echo base_url();?>approval/cancel_marketing_activity_act",
        type : 'POST',
        data : data,
        success : function (response) {
          window.location.href = "<?php echo current_url(); ?>";
        }
      })
  }); 
  
});   
</script>