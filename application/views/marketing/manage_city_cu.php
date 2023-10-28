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
      width: 120px;
      padding: 5px 15px 5px 5px;
    }
    .form-group span.left2 {
      display: block;
      overflow: hidden;
    }
    .form-group { margin-bottom: 7px; }
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
      <div class="box-body form_add">
        <form name="form" id="form" action="<?php echo base_url();?>marketing/manage_city_cu_act" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <div class="box box-solid">
              <div class="box-body">
                <?php if (isset($city_detail)) { ?>
                  <div class="form-group">
                    <label class="left">City ID</label>
                    <span class="left2">
                      <input type="text" class="form-control input-sm" placeholder="City ID" autocomplete="off" name="cityid" id="cityid" readonly="" required="" value="<?php echo $city_detail['CityID']; ?>">
                    </span>
                  </div>
                <?php }; ?>
                <div class="form-group">
                  <label class="left">City Name</label>
                  <span class="left2">
                    <input type="text" class="form-control input-sm" placeholder="City Name" autocomplete="off" name="cityname" id="cityname" required="" readonly="">
                  </span>
                </div>
                <div class="form-group">
                  <label class="left">Abbreviation</label>
                  <span class="left2">
                    <input type="text" class="form-control input-sm" placeholder="City Abbreviation" autocomplete="off" name="cityabbreviation" id="cityabbreviation">
                  </span>
                </div>
                <div class="form-group">
                  <label class="left">Population</label>
                  <span class="left2">
                    <input type="text" class="form-control input-sm mask-number" autocomplete="off" name="Population" id="Population">
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6" id="addedit">
            <div class="box box-solid">
              <div class="box-body"> 
                <div class="form-group">
                  <label class="left">Sales Name</label>
                  <span class="left2">
                    <select class="form-control input-sm select2" name="sales" id="sales">
                      <?php foreach ($sales as $row => $list) { ?>
                        <option value="<?php echo $list['SalesID'];?>"><?php echo $list['Company'];?></option>
                      <?php } ?>
                    </select>
                  </span>
                </div> 
                <div class="form-group">
                  <label class="left">Target Omzet</label>
                  <span class="left2">
                    <input type="text" class="form-control input-sm mask-number" autocomplete="off" name="Omzet" id="Omzet" >
                  </span>
                </div>
                <div class="form-group">
                  <label class="left">Target Retailer</label>
                  <span class="left2">
                    <input type="number" class="form-control input-sm" min="0" autocomplete="off" name="Retailer" id="Retailer" >
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
  if ($("#cityid").length != 0) {
    $("#form #cityname").val('<?php if ( isset($city_detail)){ echo $city_detail['CityName']; }?>');
    $("#form #cityabbreviation").val('<?php if ( isset($city_detail)){ echo $city_detail['CityAbbreviation']; }?>');
    $("#form #sales").val('<?php if ( isset($city_detail)){ echo $city_detail['SalesID']; }?>').trigger('change');
    $("#form #Omzet").val('<?php if ( isset($city_detail)){ echo $city_detail['TargetOmzet']; }?>');
    $("#form #Retailer").val('<?php if ( isset($city_detail)){ echo $city_detail['TargetCustomer']; }?>');
    $("#form #Population").val('<?php if ( isset($city_detail)){ echo $city_detail['Population']; }?>');

  }
});
</script>