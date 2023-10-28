<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<style type="text/css">
  .form-group { display: block; margin-bottom: 5px !important; }
  #reject { background-color: #dd4b39; }
  #approve { background-color: #0073b7; }
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
      <div class="box-body form_addcontact">
          <table id="dt_list" class="table table-bordered table-hover nowrap dtapproval" width="100%">
            <thead>
            <tr>
              <th class="alignCenter">No</th>
              <th class="alignCenter">Code</th>
              <th class="alignCenter">CustomerID</th>
              <th class="alignCenter">Customer</th>
              <th class="alignCenter">Sales</th>
              <th class="alignCenter">SOID</th>
              <th class="alignCenter">DOID</th>
              <th class="alignCenter">Open Date</th>
              <th class="alignCenter">Approval 1</th>
              <th class="alignCenter">Approval 2</th>
              <th class="alignCenter">Approval 3</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
              <?php
                if ($actor != "1" && !empty($content['list'])) {
                  $no = 0;
                  foreach ($content['list'] as $row => $list) { $no++;?>
                      <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $list['ComplaintID'];?></td>
                        <td><?php echo $list['CustomerID'];?></td>
                        <td><?php echo $list['customer'];?></td>
                        <td><?php echo $list['sales'];?></td>
                        <td><?php echo $list['SOID'];?></td>
                        <td><?php echo $list['DOID'];?></td>
                        <td><?php echo $list['OpenDate'];?></td>
                        <td class="alignCenter"><?php echo $list['Actor1'];?></td>
                        <td class="alignCenter"><?php echo $list['Actor2'];?></td>
                        <td class="alignCenter"><?php echo $list['Actor3'];?></td>
                        <td>
                      		<a href="<?php echo $list['ComplaintLink'];?>" target='_blank' class="btn btn-primary btn-xs"><i class="fa fa-fw fa-link"></i></a>
                          <?php 
                            if ($list[$actor] == "") {
                              echo ($content['actor'][$actor] != "") ? "<a href='#' class='btn btn-primary btn-xs dtbutton' id='approve' data='".$actor."' ComplaintID='".$list['ComplaintID']."'><i class='fa fa-fw fa-check-square'></i></a>" : "";
                            }
                          ?>
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
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "columnDefs": [ {
      "targets": 6,
      "orderable": false
    } ],
    "order": [[ 0, "desc" ]]
  });

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  };
  $('#dt_list').resize(cek_dt);

  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});

jQuery( document ).ready(function( $ ) {
  // window.setTimeout(function(){location.reload()},60000);
  $('#approve').live('click',function(e){
    var
      user = $(this).attr('data');
      ComplaintID = $(this).attr('ComplaintID');
      par  = $(this).parent().parent();
      Approval1  = par.find("td:nth-child(4)").html();
      Approval2  = par.find("td:nth-child(5)").html();
      Approval3  = par.find("td:nth-child(6)").html();
      data = {user:user, ComplaintID:ComplaintID, Approval1:Approval1, Approval2:Approval2, Approval3:Approval3 };
      $.ajax({
        url: "<?php echo base_url();?>approval/approve_so_complaint_act/approve",
        type : 'POST',
        data : data,
        success : function (response) {
          window.location.href = "<?php echo current_url(); ?>";
        }
      })
  });   
});   
</script>