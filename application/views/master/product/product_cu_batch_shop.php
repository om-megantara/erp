<style type="text/css">
  table tr td input, table tr td select { 
    padding: 4px !important; 
    font-size: 12px; 
    min-width: 70px; 
    height: 25px !important;
    vertical-align: top;
  }
  input.productid { width: 10px !important; }
  input.productcode, input.productsupplier, input.productdescription { width: 300px !important; }
  .table-main th, .table-main td { 
    padding: 2px 10px !important; 
    text-align: center;
  }
  .table-main th { text-align: center; }
  .table-main tr:hover { background-color: #3c8dbc; }
  .table-main .sticky-col {
      border-left: solid 1px #fff;
      border-right: solid 1px #fff;
      left: 0;
      position: sticky;
      top: auto;
      width: 310px;
      background-color: #fff;
      margin-right: 20px !important;
      padding-right: 20px !important;
  }
  .box-table {
    /*margin-left: 301px;*/
    overflow-x: scroll;
    overflow-y: visible;
    padding-bottom: 5px;
  }
  input[type='checkbox'] {
    -webkit-appearance:none;
    min-width: 15px !important;
    width: 20px !important;
    min-height: 10px !important;
    height: 15px !important;
    background:white;
    border-radius:3px;
    border:1px solid #555;
  }
  input[type='checkbox']:checked {
    background: #3c8dbc;
  }
</style>

<?php
$product = $main['product'];
$shop_main = isset($main['shop_main']) ? $main['shop_main'] : array();
$shop_detail = isset($main['shop_detail']) ? $main['shop_detail'] : array();
?>

<div class="content-wrapper">
	<section class="content-header">
		<h1>
      <?php echo $PageTitle.' - '. $MainTitle; ?>
		</h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank" title="HELP"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
	</section>
	<section class="content">

		<div class="box box-solid">
      <form role="form" class="form-edit" action="<?php echo base_url();?>master/product_cu_batch_shop_act" method="post" >
    		<div class="box-header with-border">
          <button type="submit" class="btn btn-primary pull-right">Submit</button>
    		</div>

    		<div class="box-body box-table" style="overflow-x: auto; max-height: 800px;">
    		  <table class="table table-responsive table-bordered table-main no-wrap" style="width:auto; font-size: 14px;">
    		  	<thead>
    		  		<tr>
    			      <th class="sticky-col">ID || Name</th>
              <?php
                if (isset($shop_main)) {
                  foreach ($shop_main as $row => $list) {  
              ?>
                <th>
                  <?php echo $list['ShopName']; ?> <br>
                  <input type="checkbox" class="cek_all" data="shop_<?php echo $list['ShopID']; ?>">
                </th>
              <?php } } ?>
    			    </tr>
    		  	</thead>
    		  	<tbody>
              <?php
              // echo json_encode($product);
                if (isset($product)) {
                  foreach ($product as $row => $list1) {  
              ?>
      		  		<tr>
                  <td class="sticky-col">
                    <input type="hidden" class="form-control input-sm productid" placeholder="Product ID" name="productid[]" readonly="" value="<?php echo $list1['ProductID']; ?>">
                    <input type="text" class="form-control input-sm productcode" placeholder="Product Code" name="productcode[]" readonly="" value="<?php echo $list1['ProductID'].' | '.$list1['ProductName']; ?>">    
                  </td>
                    <?php
                      if (isset($shop_main)) {
                        foreach ($shop_main as $row => $list2) {  
                    ?>
                      <td>
                        <?php
                          if ( array_key_exists($list2['ShopID'], $shop_detail) && array_key_exists($list1['ProductID'], $shop_detail[$list2['ShopID']]) ) {
                        ?>
                          <input type="checkbox" class="shop_<?php echo $list2['ShopID']; ?>" name="shop_<?php echo $list2['ShopID']; ?>[]" value="1" checked>
                          <input type="hidden" name="shop_<?php echo $list2['ShopID']; ?>_status[]" value="old">

                            <?php
                              if ( $shop_detail[$list2['ShopID']][$list1['ProductID']] != '' ) {
                            ?>
                              <a href="<?php echo $shop_detail[$list2['ShopID']][$list1['ProductID']];?>" class="btn btn-success btn-xs" style="margin: 0px;" target="_blank" title="OPEN LINK"><i class="fa fa-fw fa-link"></i></a>
                            <?php } else { ?>
                              <a href="<?php echo base_url();?>" class="btn btn-info btn-xs" style="margin: 0px;" target="_blank" title="OPEN LINK"><i class="fa fa-fw fa-link"></i></a>
                            <?php } ?>

                        <?php } else { ?>
                          <input type="checkbox" class="shop_<?php echo $list2['ShopID']; ?>" name="shop_<?php echo $list2['ShopID']; ?>[]" value="1" >
                          <input type="hidden" name="shop_<?php echo $list2['ShopID']; ?>_status[]" value="new">
                        <?php } ?>
                      </td>
                    <?php } } ?>
      		  		</tr>
              <?php } } ?>
    		  	</tbody>
    		  </table>
    		</div>
      </form>

		</div>
	</section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/jquery.inputmask.bundle.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
   
});

$('.cek_all').live( 'click', function (e) { 
  data = $(this).attr("data")

 if($(this).is(":checked")) {
    $('.'+data).prop('checked',true)
 } else {
    $('.'+data).prop('checked',false)
 }
});


$("form").submit(function(e){ 
    $('.table-main tbody input[type=checkbox]:not(:checked)').each(function () {
        $(this).prop('checked', true).val(0);
    });
});
</script>