<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css"> 
@media (min-width: 768px){
  .form-group label.left {
    float: left;
    width: 130px;
    padding: 5px 15px 5px 5px;
  }
  .form-group span.left2 {
    display: block;
    overflow: hidden;
  }
  .form-group { margin-bottom: 10px; }
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
      <div class="box-body">
        <form name="form" id="form" action="<?php echo base_url();?>marketing/marketing_activity_bonus_add_act" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">Category</label>
              <span class="left2">
                <select class="form-control input-sm" name="Category" id="Category">
                  <option value="0">All</option>   
                  <?php 
                    foreach ($content['Category'] as $row => $list) { 
                  ?>
                  <option value="<?php echo $list['ID'];?>"><?php echo $list['FeeCategory'];?></option>
                  <?php } ?>   
                </select>
              </span>
            </div>
            <div class="form-group">
              <label class="left">Bonus</label>
              <div class="input-group">
                <span class="left2">
                  <input type="text" class="form-control input-sm Bonus" name="Bonus" required="">
                </span>
                <span class="input-group-addon"><b>%</b></span>
              </div>
            </div>
            <!-- <div class="form-group">
              <label class="left">Bonus CFU</label>
              <div class="input-group">
                <span class="input-group-addon"><b>Rp</b></span>
                <span class="left2">
                  <input type="text" class="form-control input-sm CFUUp" name="CFUUp">
                </span>
              </div>
            </div>
            <div class="form-group">
              <label class="left">Bonus CV</label>
              <div class="input-group">
                <span class="input-group-addon"><b>Rp</b></span>
                <span class="left2">
                  <input type="text" class="form-control input-sm CVUp" name="CVUp" required="">
                </span>
              </div>
            </div> -->
            <div class="box-footer" style="text-align: right;">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
          
        </form>
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/jquery.inputmask.bundle.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
j8 = jQuery.noConflict();
j8( document ).ready(function( $ ) {

  $(".date").datepicker({ 
    startDate: '-1d',
    autoclose: true, 
    format: 'yyyy-mm-dd',
    todayBtn:  1,
  }).datepicker("setDate", new Date())

});

</script>