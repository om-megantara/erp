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
        <button type="button" class="btn btn-primary btn-xs" onclick="window.open('<?php echo base_url();?>marketing/online_order_add', '_blank');" title='ADD OLO'><b>+</b> Add OLO</button>
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
                <th>NO</th>
                <th>OLOID</th>
                <th>Date Invoice</th>
                <th>Date OLO</th>
                <th>Shop</th>
                <th>Note</th>
                <th>Link</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            <?php
              $number=0;
              if (isset($content)) {
               foreach ($content as $row => $list) { 
                $number++;
            ?>
                  <tr>
                    <td class=" alignCenter"><?php echo $number;?></td>
                    <td class=" alignCenter"><?php echo "OLO.".$list['CodeShop'].".".$list['CodeMP'].".".$list['InvoiceMP'].".".$list['Customer'];?></td>
                    <td class=" alignCenter"><?php echo $list['DateINV'];?></td>
                    <td class=" alignCenter"><?php echo $list['DateOLO'];?></td>
                    <td class=" alignCenter"><?php echo $list['ShopName'];?></td>
                    <td class=" alignCenter"><?php echo $list['Note'];?></td>
                    <td class=" alignCenter"><a href="<?php echo base_url()."assets/PDFOLO/".$list['File'];?>" target='_blank' class="btn btn-primary btn-xs"><i class="fa fa-fw fa-file-pdf-o"></i></a></td>
                    <td class=" alignLeft">
                      <?php if ($list['Status'] == "1") { ?>
                          <i class="fa fa-fw fa-check-square-o" style="color: green;" title="complete"></i>
                      <?php } else if ($list['Status'] == "2"){?>
                          <i class="fa fa-fw fa-close" style="color: red;" title="Cancel"></i>
                      <?php } else {?>
                      <a href="online_order_edit?OLOID=<?php echo $list['OLOID'];?>" target='_blank' class="btn btn-warning btn-xs"><i class="fa fa-fw fa-edit"></i></a>   
                      <a href="online_order_delete?OLOID=<?php echo $list['OLOID'];?>" class="btn btn-danger btn-xs Delete"><i class="fa fa-fw fa-trash"></i></a>            
                      <?php 
                      $MenuList = $this->session->userdata('MenuList');
                      if(in_array("online_order_approve", $MenuList)){?>
                      <a href="<?php echo base_url()?>master/contact_cu/new" target='_blank' title="ADD Contact" class="btn btn-Info btn-xs"><i class="fa fa-fw fa-user-plus"></i></a>
                      <a href="<?php echo base_url()?>transaction/sales_order_add" target='_blank' title="ADD SO" class="btn btn-Info btn-xs"><i class="fa fa-fw fa-file"></i></a>
                      <a href="online_order_approve?OLOID=<?php echo $list['OLOID'];?>" class="btn btn-success btn-xs Approve"><i class="fa fa-fw fa-check"></i></a>
                      <?php } } ?>
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

  $(".delete").click(function(e) { 
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

  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "order":[[0, "asc"]],
    "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };
    }
  })

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
  

});
</script>