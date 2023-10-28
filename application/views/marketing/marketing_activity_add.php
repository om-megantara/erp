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
        <form name="form" id="form" action="<?php echo base_url();?>marketing/marketing_activity_add_act" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">Customer</label>
              <span class="left2">
                <select class="form-control customer" name="customer" required=""></select>
              </span>
            </div> 
            <div class="form-group">
              <label class="left">Date</label>
              <span class="left2">
                <input type="text" class="form-control input-sm date" name="date" required="">
              </span>
            </div> 
            <div class="form-group">
              <label class="left">Type</label>
              <span class="left2">
                <select class="form-control type" name="type" required="">
                  <option value="">Empty</option>
                  <option value="Customer Follow Up (CFU)">Customer Follow Up (CFU)</option>
                  <option value="Customer Visit (CV)">Customer Visit (CV)</option>
                </select>
              </span>
            </div> 
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">Link</label>
              <span class="left2">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-link"></i>
                  </div>
                  <textarea class="form-control pull-right" rows="2" name="link" id="link" required=""></textarea>
                </div>
              </span>
            </div> 
            <div class="form-group">
              <label class="left">Note</label>
              <span class="left2">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-sticky-note-o"></i>
                  </div>
                  <textarea class="form-control pull-right" rows="2" name="note" id="note"></textarea>
                </div>
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
  $(".mask-number").inputmask({ 
      alias:"currency", 
      prefix:'', 
      autoUnmask:true, 
      removeMaskOnSubmit:true, 
      showMaskOnHover: true 
  });

  $(".date").datepicker({ 
    startDate: '-1d',
    autoclose: true, 
    format: 'yyyy-mm-dd',
    todayBtn:  1,
  }).datepicker("setDate", new Date())

  <?php if (isset($content)) { ?>
    var data = {
        id: '<?php echo $content['CustomerID']; ?>',
        text: '<?php echo $content['Company2']; ?>',
    };
    var newOption = new Option(data.text, data.id, false, false);
    $('.customer').append(newOption).trigger('change');
  <?php } ?>
});


j8('.customer').select2({
  placeholder: 'Minimum 3 char, Company',
  minimumInputLength: 3,
  ajax: {
    url: '<?php echo base_url();?>general/search_customer_city_sales',
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
</script>