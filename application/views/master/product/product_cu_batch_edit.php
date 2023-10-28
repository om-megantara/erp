<style type="text/css">
  table tr td input, table tr td select { 
    padding: 4px !important; 
    font-size: 12px; 
    min-width: 70px; 
    height: 25px !important;
  }
  input.productid { width: 10px !important; }
  input.productcode, input.productsupplier, input.productdescription { width: 300px !important; }
  .forsale, .isactive, .copyabove { min-width: 20px !important; height: 15px !important; margin: 2px !important; }
  .table-main th, .table-main td { padding: 2px !important; }
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
    width:10px;
    height:10px;
    background:white;
    border-radius:3px;
    border:1px solid #555;
  }
  input[type='checkbox']:checked {
    background: #3c8dbc;
  }
</style>
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
      <form role="form" class="form-edit" action="<?php echo base_url();?>master/product_cu_batch_edit_act" method="post" >
    		<div class="box-header with-border">
          <button type="submit" class="btn btn-primary pull-right">Submit</button>
    		</div>

    		<div class="box-body box-table" style="overflow-x: auto; max-height: 800px;">
    		  <table class="table table-responsive table-bordered table-main" style="width:auto; font-size: 14px;">
    		  	<thead>
    		  		<tr>
    			      <th class="sticky-col">ID || Code</th>
                <th>Description</th>
                <th>Supplier Name</th>
                <th>Price Purchase</th>
                <th>Price HPP</th>
                <th>Price Percent</th>
                <th>Price Default</th>
                <th>Multiplier</th>
                <th>Copy</th>
                <th>for Sale</th>
                <th>is Active</th>
    			    </tr>
    		  	</thead>
    		  	<tbody>
              <?php
              // echo json_encode($product);
                if (isset($product['main'])) {
                  foreach ($product['main'] as $row => $list) {  
              ?>
      		  		<tr>
                  <td class="sticky-col">
                    <input type="hidden" class="form-control input-sm productid" placeholder="Product ID" name="productid[]" readonly="" value="<?php echo $list['ProductID']; ?>">
                    <input type="text" class="form-control input-sm productcode" placeholder="Product Code" name="productcode[]" readonly="" value="<?php echo $list['ProductID'].' | '.$list['ProductCode']; ?>">    
                  </td>
                  <td>
                    <input type="text" class="form-control input-sm productdescription" placeholder="Product Description" name="productdescription[]" value="<?php echo $list['ProductDescription']; ?>">    
                  </td>
                  <td>
                    <input type="hidden" class="form-control input-sm productname" placeholder="Product Name" name="productname[]" readonly="" value="<?php echo $list['ProductName']; ?>">    

                    <div class="input-group input-group-xs">
                      <input type="text" class="form-control input-sm productsupplier" placeholder="Product Supplier Name" name="productsupplier[]" value="<?php echo $list['ProductSupplier']; ?>">    
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-primary btn-sm copyDesc"><i class="fa fa-fw fa-copy" title="COPY"></i></button>
                      </span>
                    </div>
                  </td>
                  <td>
                    <?php if ($this->auth->cek5('manage_product_purchase')) { ?>
                    <input type="text" class="form-control input-sm mask-number purchase" name="purchase[]" placeholder="PRICE PURCHASE" autocomplete="off" required="" value="<?php echo $list['ProductPricePurchase']; ?>">
                    <?php } ?>
                  </td>
                  <td>
                    <?php if ($this->auth->cek5('manage_product_hpp')) { ?>
                    <input type="text" class="form-control input-sm mask-number hpp" name="hpp[]" placeholder="PRICE HPP" autocomplete="off" required="" value="<?php echo $list['ProductPriceHPP']; ?>">
                    <?php } ?>
                  </td>
                  <td>
                    <?php if ($this->auth->cek5('manage_product_hpp')) { ?>
                      <?php if (in_array("edit_price_default", $MenuList)) {?>
                      <input type="number" class="form-control input-sm persen" name="persen[]" placeholder="Percentage" autocomplete="off" step="0.01" value="<?php echo $list['ProductPricePercent']; ?>">
                      <?php } else {?>
                      <input type="number" class="form-control input-sm persen" name="persen[]" placeholder="Percentage" autocomplete="off" min="0" step="0.01" value="<?php echo $list['ProductPricePercent']; ?>">
                      <?php } ?>
                    <?php } ?>
                  </td>
                  <td>
                    <input type="text" class="form-control input-sm mask-number price" name="price[]" placeholder="PRICE Default" autocomplete="off" required="" value="<?php echo $list['ProductPriceDefault']; ?>">
                  </td>
                  <td>
                      <input type="number" class="form-control input-sm multiplier" name="multiplier[]" placeholder="Multiplier" autocomplete="off" min="0" step="0.1" required="" value="<?php echo $list['ProductMultiplier']; ?>">
                  </td>
                  <td>
                    <input type="checkbox" class="copyabove" name="copyabove">
                  </td>
                  <td>
                    <input type="checkbox" class="forsale" name="forsale[]" value="1" <?php echo ($list['forSale']==1 ? 'checked' : '');?> >
                  </td>
                  <td>
                    <input type="checkbox" class="isactive" name="isactive[]" value="1" <?php echo ($list['isActive']==1 ? 'checked' : '');?> >
                  </td>
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
   
  $(".mask-number").inputmask({ 
      alias:"currency", 
      prefix:'', 
      autoUnmask:true, 
      removeMaskOnSubmit:true, 
      showMaskOnHover: true 
  });

  setTimeout( function() {
    $( ".copyabove:first" ).css( "display", "none" );
  }, 5000) //force to order and fix header width
});
$(".hpp").keyup(function() {
  sum($(this))
});
$(".persen").keyup(function() {
  sumPercent($(this))
});
$(".price").keyup(function() {
  sum($(this))
});
function sum(el) {
  par = el.parent().parent()
  hpp = par.find(".hpp").val()
  persen = par.find(".persen").val()
  price = par.find(".price").val()
  result = ((parseFloat(price) - parseFloat(hpp))/parseFloat(price)) * 100;
  if (!isNaN(result)) {
    par.find(".persen").val( result.toFixed(2) )
  }else{
    par.find(".persen").val("0")
  }
}
function sumPercent(el) {
  par = el.parent().parent()
  hpp = par.find(".hpp").val()
  persen = par.find(".persen").val()
  price = par.find(".price").val()
  result = parseInt(hpp) / ( 1 - (parseInt(persen)/100 ) );
  if (!isNaN(result)) {
    // var rest = result % 1000; 
    // if(rest < 500) { result = result - rest + 1000; } 
    // result = Math.round(result/1000)*1000;
    par.find(".price").val( result.toFixed(0) )
  }else{
    par.find(".price").val("0")
  }
}
$(".copyDesc").click(function() {
  name = $(this).closest("td").find("input.productname").val()
  $(this).closest("td").find(".productsupplier").val(name)
})
$('.copyabove').live( 'click', function (e) { 
  trBefore = $(this).closest("tr").prev()
  hppBefore = trBefore.find("input.hpp").val()
  priceBefore = trBefore.find("input.price").val()
  persenBefore = trBefore.find("input.persen").val()
  multiplierBefore = trBefore.find("input.multiplier").val()

  hpp = $(this).closest("tr").find("input.hpp")
  price = $(this).closest("tr").find("input.price")
  persen = $(this).closest("tr").find("input.persen")
  multiplier = $(this).closest("tr").find("input.multiplier")

 if($(this).is(":checked")) {
    hpp.val(hppBefore)  
    price.val(priceBefore)  
    persen.val(persenBefore)  
    multiplier.val(multiplierBefore)  
 } else {
    hpp.val(0)  
    price.val(0)  
    persen.val(0)  
    multiplier.val(0)  
 }
});


$("form").submit(function(e){
  $("table tbody tr").each(function() {
    persen = parseFloat( $(this).find('.persen').val() );
    if (persen < 0) {
      e.preventDefault();
      alert("Harga End User tidak boleh lebih kecil dari HPP!")
      return false
    }

    $(this).find('.forsale').each(function () {
      if ( $(this).prop("checked") === false ) {
        $(this).css("display", "none")
        $(this).attr('value', '0');
        $(this).prop('checked', true);
      }
    });
    $(this).find('.isactive').each(function () {
      if ( $(this).prop("checked") === false ) {
        $(this).css("display", "none")
        $(this).attr('value', '0');
        $(this).prop('checked', true);
      }
    });
  })
});
</script>