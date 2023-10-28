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
  </section>

  <section class="content">

    <div class="box box-solid">
      <div class="box-body">
        <form name="form" id="form" action="<?php echo base_url();?>master/price_recommendation_add_act" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">ProductID</label>
              <label class="left2"><?php echo $content['ProductID']; ?></label>
              <input type="hidden" class="form-control pull-right" name="productid" id="productid" value="<?php echo $content['ProductID']; ?>">
            </div>
            <div class="form-group">
              <label class="left">Product Name</label>
              <label class="left2"><?php echo wordwrap($content['ProductName'],50,"<br>\n"); ?></label>
            </div>
            <div class="form-group">
              <label class="left">Current Price</label>
              <label class="left2"><?php if(empty($content['cbd'])){ $price=$content['ProductPriceDefault']; echo "Rp ".number_format($price); } else { $price=$content['cbd']; echo "Rp ".number_format($price);} ?></label>
              <input type="hidden" class="form-control pull-right" name="currentprice" id="currentprice" value="<?php echo $price; ?>">
            </div>
            <div class="form-group">
              <label class="left">Recomendation Price</label>
              <span class="left2">
                <div class="input-group">
                  <div class="input-group-addon">
                    <b>Rp</b>
                  </div>
                  <input type="text" class="form-control pull-right" rows="2" name="pricerec" id="pricerec" required="">
                </div>
              </span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">Note </label>
              <span class="left2">
                <textarea class="form-control pull-right" rows="2" name="note" id="note" ></textarea>
              </span>
            </div>
            <div class="form-group">
              <label class="left">Price Competitor Link </label>
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
              <label class="left" >Screenshot</label>
              <span class="left2">
                <input type="file" accept="image/jpeg,image/jpg,image/png,.pdf" class="form-control-file input-file" id="label" name="label" required="">
                <p class="help-block">Item type must be JPG, PNG, PDF and 1Mb maximum size.</p>
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
</script>