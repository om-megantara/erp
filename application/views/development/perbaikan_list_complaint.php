<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">
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
      <!-- <div class="box-header with-border">
        <?php if ($this->session->userdata('SalesID') != "0") { ?>
          <button type="button" class="btn btn-primary btn-xs" onclick="window.open('<?php echo base_url();?>marketing/marketing_activity_add', '_blank');" title='ADD ACTIVITY'><b>+</b> Add Activity</button>
        <?php } ?>
      </div> -->
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
              <tr>
                <th>Code</th>
                <th>CustomerID</th>
                <th>Customer</th>
                <th>Sales</th>
                <th>SOID</th>
                <th>DOID</th>
                <th>Open Date</th>
                <th>Close Date</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            <?php
              if (isset($content)) {
               foreach ($content as $row => $list) { 
            ?>
                  <tr>
                    <td><?php echo $list['ComplaintID'];?></td>
                    <td><?php echo $list['CustomerID'];?></td>
                    <td><?php echo $list['customer'];?></td>
                    <td><?php echo $list['sales'];?></td>
                    <td><?php echo $list['SOID'];?></td>
                    <td><?php echo $list['DOID'];?></td>
                    <td><?php echo $list['OpenDate'];?></td>
                    <td><?php echo $list['CloseDate'];?></td>
                    <td>
                      <a href="<?php echo $list['ComplaintLink'];?>" title="Hyperlink" target='_blank' class="btn btn-primary btn-xs"><i class="fa fa-fw fa-link"></i></a>
                      <?php if ($list['isApprove'] == "1") { ?>
                        <i class="fa fa-fw fa-check-square-o" style="color: green;" title="Approved"></i>
                      <?php } else { ?>
                        <button type="button" class="btn btn-danger btn-xs deleteComplaint" title="Delete" ComplaintID='<?php echo $list['ComplaintID'];?>'><i class="fa fa-fw fa-trash"></i></button>
                      <?php } ?>
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

  $(".deleteComplaint").click(function(e) { 
    ComplaintID = $(this).attr('ComplaintID')
    errornote  = "This Activity will be deleted!\nare you sure?"
    var r = confirm(errornote);
    if (r == false) {
      e.preventDefault();
      return false
    } else {
      location.href = '<?php echo base_url();?>development/list_complaint_delete?ComplaintID='+ComplaintID;
    }
  });
});

</script>