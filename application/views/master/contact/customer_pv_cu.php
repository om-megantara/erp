<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">

<style type="text/css">
  .customaddr {font-size: 12px; padding: 0px 3px; font-weight: bold; margin-bottom: 3px;}
  .phone, .email, .employeename, .productcomponent {margin-top: 2px;}
  .add_addr {font-size: 18px; font-weight: bold; color: white; background-color: #5bc0de; padding: 0px 8px;}
  .form-control, .address .form-control { margin-top: 3px; }
  .box-body h6 {display: inline; color: red; font-weight: bold;}

@media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 160px;
      padding: 5px 15px 5px 5px;
    }
    .form-group span.left2 {
      display: block;
      overflow: hidden;
    }
    .form-group { margin-bottom: 7px; }
}
</style>
<?php 
  $sales = $content['sales'];
  ?>
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
      <div class="box-body form_add">
        <form name="form" id="form" action="<?php echo base_url();?>master/customer_pv_cu_act" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <div class="box box-solid">
              <div class="box-body">
                <div class="form-group">
                  <label class="left">Customer Name</label>
                  <span class="left2">
                    <input type="text" class="form-control input-sm" placeholder="Customer Name" autocomplete="off" name="customername" id="customername" readonly="" value="<?php echo $content['Company2'];?>">
                    <input type="hidden" id="customerid" name="customerid" value="<?php echo $content['CustomerID'];?>">
                  </span>
                </div>
                <div class="form-group">
                  <label class="left">Customer PV Multiplier</label>
                  <span class="left2">
                    <input type="text" class="form-control input-sm mask-number" autocomplete="off" name="customerpv" id="customerpv" value="<?php echo $content['CustomerPVMultiplier'];?>">
                  </span>
                </div>
                <div class="form-group">
                  <label class="left">Sales PV Multiplier</label>
                  <span class="left2">
                    <input type="text" class="form-control input-sm mask-number" autocomplete="off" name="sepv" id="sepv" value="<?php echo $sales[0]['SEPVMultiplier'];?>">
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="box-footer" style="text-align: center;">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
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
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.inputmask.bundle.js"></script>
<script>
j8  = jQuery.noConflict();
j8( document ).ready(function( $ ) {
  $('.select2').select2();

  $(".mask-number").inputmask({ 
      alias:"currency", 
      prefix:'', 
      autoUnmask:true, 
      removeMaskOnSubmit:true, 
      showMaskOnHover: true 
  });

  j8('.customerpv').live( "change", function() {
    customerpv = parseFloat( par.find('.customerpv').val() );
    if (customerpv > 0) {
          par.find('.sepv').val(0)
        }
  });
});
</script>