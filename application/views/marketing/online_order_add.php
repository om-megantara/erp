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
        <form name="form" id="form" action="<?php echo base_url();?>marketing/online_order_add_act" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">Toko Online</label>
              <span class="left2">
                <select class="form-control toko" name="toko" required="">
                  <option value="">Empty</option>
                  <?php 
                    foreach ($content['shop'] as $row => $list) { 
                  ?>
                  <option value="<?php echo $list['ShopID'];?>"><?php echo $list['ShopName'];?></option>
                  <?php } ?>
                </select>
              </span>
            </div>
            <div class="form-group">
              <label class="left">Invoice Number</label>
              <span class="left2">
                <input type="text" class="form-control input-sm inv" name="inv" required="">
              </span>
            </div> 
            <div class="form-group">
              <label class="left">Customer Name</label>
              <span class="left2">
                <input type="text" class="form-control input-sm customer" name="customer" required="">
              </span>
            </div>
            <div class="form-group">
              <label class="left">Invoice Date</label>
              <span class="left2">
                <input type="text" class="form-control input-sm date" name="date" required="">
              </span>
            </div>
            <div class="form-group">
              <label class="left">Note</label>
              <span class="left2">
                <textarea class="form-control input-sm note" name="note" ></textarea>
              </span>
            </div>
            <div class="form-group">
              <label class="left" for="exampleInputFile">File </label>
              <span class="left2">
                <input type="file" accept=".pdf" class="form-control-file input-file" id="cv" name="cv" required="">
                <p class="help-block">Item type must be PDF and 1Mb maximum size.</p>
              </span>
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
<script src="<?php echo base_url();?>tool/jquery.inputmask.bundle.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
j8 = jQuery.noConflict();
j8( document ).ready(function( $ ) {

  $(".date").datepicker({
    autoclose: true, 
    format: 'yyyy-mm-dd',
    todayBtn:  1,
  }).datepicker("setDate", new Date())

});
j8('.input-file').live('change', function() {
  if (this.files[0].size/1024 > 210000) {
    alert('File size is : ' + this.files[0].size/1024 + "KB, than overload!");
  }
});

</script>