<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">

.padtop-2 { margin-top: 2px !important; }
.padtop-4 { margin-top: 4px !important; }
.select2 { width: 100% !important; }
.distribution { 
  padding-left: 2px !important; 
  padding-right: 2px !important;
  font-size: 12px !important; 
}
.distributionamount {
  padding-left: 2px !important; 
  padding-right: 2px !important;
  font-size: 12px !important; 
}
.shoplist {
  padding-left: 20px;
  padding-right: 28px;
  margin-top: 4px;
}
</style>

<?php
// echo json_encode($content['shop']);
$main=$content['main'];
$shoplist=$content['shoplist'];
if (isset($content['detail'])) {
  $detail=$content['detail'];
}
?>

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
        <form name="form" id="form" action="<?php echo base_url();?>report/product_shop_act" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-8">
            <div class="col-md-4 padtop-2">
              <label>Product ID</label>
            </div>
            <div class="col-md-8 padtop-2">
              <input type="text" class="form-control" id="ProductID" name="ProductID" readonly value="<?php echo $main['ProductID'];?>">
            </div>
            <div class="col-md-4 padtop-2">
              <label>Product Name</label>
            </div>
            <div class="col-md-8 padtop-2">
              <input type="text" class="form-control" id="ProductName" name="ProductName" readonly value="<?php echo $main['ProductName'];?>">
            </div>
            <?php 
              if (isset($detail)) {
                foreach ($detail as $row2 => $list2) { ?>
                <div class="row rowshop">
                  <div class="col-xs-4 shoplist">
                      <input type="hidden" class="OrderID" name="OrderID[]" value="<?php echo $list2['OrderID'];?>">
                      <select class="form-control shopname" name="shopname[]" required="" disabled="true">
                        <option value="<?php echo $list2['ShopID']; ?>"><?php echo $list2['ShopName']; ?></option>
                        <?php foreach ($shoplist as $row => $list) { ?>
                          <option value="<?php echo $list['ShopID']; ?>"><?php echo $list['ShopName']; ?></option>
                      <?php } ?>
                      </select>
                  </div>
                  <div class="col-xs-8 shoplist">
                    <div class="input-group ">
                      <input type="text" class="form-control LinkText" placeholder="hyperlink" autocomplete="off" name="LinkText[]" value="<?php echo $list2['LinkText']; ?>" required="" readonly>
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-primary add_field" onclick="duplicateshop();">+</button>
                        <button type="button" class="btn btn-primary  add_field" onclick="if ($('.rowshop').length != 1) { $(this).closest('.rowshop').remove();}">-</button>
                      </span>
                    </div>
                  </div>
                </div>  
            <?php 
                } 
              } else { ?>
              <div class="row rowshop">
                <div class="col-xs-4 shoplist">
                  <input type="hidden" class="OrderID" name="OrderID[]" value="0">
                    <select class="form-control shopname" name="shopname[]" required="">
                      <option value="">Shop Name</option>
                      <?php foreach ($shoplist as $row => $list) { ?>
                          <option value="<?php echo $list['ShopID']; ?>"><?php echo $list['ShopName']; ?></option>
                      <?php } ?>
                    </select>
                </div>
                <div class="col-xs-8 shoplist">
                  <div class="input-group ">
                    <input type="text" class="form-control LinkText" placeholder="hyperlink" autocomplete="off" name="LinkText[]" id="LinkText" required="" value="">
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-primary add_field" onclick="duplicateshop();">+</button>
                      <button type="button" class="btn btn-primary add_field" onclick="if ($('.rowshop').length != 1) { $(this).closest('.rowshop').remove();}">-</button>
                    </span>
                  </div>
                </div>
              </div>  
            <?php  }
            ?>
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
<script>
j8 = jQuery.noConflict();
j8( document ).ready(function( $ ) {
});

function duplicateshop() {
    j8(".rowshop:last").clone().insertAfter(".rowshop:last");
    j8(".rowshop:last").find('.OrderID').val('0')
    j8(".rowshop:last").find('.shopname').prop('disabled', false)
    j8(".rowshop:last").find('.LinkText').prop('readonly', false).val('')
}

j8("form").submit(function(e){
  j8("select").prop('disabled', false)
});
</script>