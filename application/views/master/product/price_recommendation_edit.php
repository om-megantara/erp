<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css"> 
@media (min-width: 768px){
  .form-group label.left {
    float: left;
    width: 160px;
    padding: 5px 5px 5px 5px;
  }
  .form-group span.left2 {
    display: block;
    overflow: hidden;
  }
  .form-group { margin-bottom: 10px; }
  .rec {color:red;}
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
        <form name="form" id="form" action="<?php echo base_url();?>master/price_recommendation_edit_act" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">Approval ID</label>
              <label class="left2"><?php echo $content['RecID']; ?></label>
              <input type="hidden" class="form-control pull-right" name="recid" id="recid" value="<?php echo $content['RecID']; ?>">
            </div>
            <div class="form-group">
              <label class="left">ProductID</label>
              <label class="left2"><?php echo $content['ProductID']; ?></label>
              <input type="hidden" class="form-control pull-right" name="productid" id="productid" value="<?php echo $content['ProductID']; ?>">
            </div>
            <div class="form-group">
              <label class="left">Product Name</label>
              <label class="left2"><?php echo wordwrap($content['ProductName'],60,"<br>\n"); ?></label>
            </div>
            <div class="form-group">
              <label class="left">Current Price</label>
              <label class="left2"><?php echo "Rp ".number_format($content['CurrentPrice']);?></label>
              <input type="hidden" class="form-control pull-right" name="currentprice" id="currentprice" value="<?php echo $content['CurrentPrice']; ?>">
            </div>
            <div class="form-group">
              <label class="left">Recomendation Price</label>
              <label class="left2 rec"><?php echo "Rp ".number_format($content['PriceRec']);?></label>
              <input type="hidden" class="form-control pull-right" name="pricerec" id="pricerec" value="<?php echo $content['PriceRec']; ?>">
            </div>
            <div class="form-group">
              <label class="left">Edit Recomendation Price </label>
              <span class="left2">
                <div class="input-group">
                  <div class="input-group-addon">
                    <b>Rp</b>
                  </div>
                  <input type="text" class="form-control pull-right" rows="2" name="pricerecedit" id="pricerecedit" required="">
                </div>
              </span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">Recomendation By </label>
              <label class="left2"><?php echo $content['fullname']; ?></label>
            </div>
            <div class="form-group">
              <label class="left">Price Competitor</label>
              <label class="left2">
                Link Tokopedia <a href="<?php echo $content['Link1'];?>" target='_blank' class="btn btn-success btn-xs"><i class="fa fa-fw fa-link"></i></a>
                Link Shopee <a href="<?php echo $content['Link2'];?>" target='_blank' class="btn btn-warning btn-xs"><i class="fa fa-fw fa-link"></i></a>
                <input type="hidden" class="form-control pull-right" name="link" id="link" value="<?php echo $content['CompetitorLink']; ?>">
              </label>
            </div>
            <div class="form-group">
              <label class="left" >Screenshot</label>
              <label class="left2">
                <a href="<?php echo base_url(); ?>assets/PDFPrice/<?php echo $content['Screenshot'];?>" target="_blank" class="btn btn-xs btn-warning Screenshot" title='Screenshot'><i class="fa fa-fw fa-file-image-o"></i></a>
                <input type="hidden" class="form-control pull-right" name="label" id="label" value="<?php echo $content['Screenshot']; ?>">
              </label>
            </div> 
            <div class="form-group">
              <label class="left">Note </label>
              <label class="left2"><?php echo $content['Note']; ?></label>
              <input type="hidden" class="form-control pull-right" name="note" id="note" value="<?php echo $content['Note']; ?>">
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