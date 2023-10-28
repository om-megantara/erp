<style type="text/css">
  .minstock, .maxstock { 
    width: 50px !important; 
    height: 25px !important; 
    padding: 5px 3px;
  }
  .btn-no { font-weight: bold; color: #fff; }
  .table-main th, .table-main td { padding: 2px !important; }
  .table-main td { 
    text-align: center;
    align-content: center; 
  }
  .table-main th { 
    text-align: center; 
    background-color: #3c8dbc;
    color: white;
  }
  .table-main tr:hover { background-color: #3c8dbc; }
  .table-main .sticky-col {
      border-left: solid 1px #fff;
      border-right: solid 1px #fff;
      left: 0;
      position: sticky;
      top: auto;
      width: 310px;
      background-color: #3c8dbc;
      margin-right: 20px !important;
      padding-right: 20px !important;
  }
  .box-table {
    /*margin-left: 301px;*/
    overflow-x: scroll;
    overflow-y: visible;
    padding-bottom: 5px;
  }
  .SO { background: #e91e63; }
  .PO { background: #3c8dbc; }
  .MUTATION { background: #00a65a; }
</style>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
		  BATCH EDIT PRODUCT 
		</h1>
	</section>
	<section class="content">

		<div class="box box-solid">
      <form role="form" class="form-edit" action="<?php echo base_url();?>transaction/product_minmax_act" method="post" >
    		<div class="box-header with-border">
          <!-- <button type='button' class='btn btn-xs btn-no MUTATION'>MUTATION</button>     -->
          <button type='button' class='btn btn-xs btn-no PO'>PO</button>    
          <button type='button' class='btn btn-xs btn-no SO'>SO</button>    
          <span>|| formula Min = <?php echo $productdetail['main']['StockMin']; ?> x rata2 3bln</span>
          <span>|| formula Max = <?php echo $productdetail['main']['StockMax']; ?> x rata2 3bln</span>

          <button type="submit" class="btn btn-primary pull-right">Submit</button>
    		</div>

    		<div class="box-body box-table" style="overflow-x: auto; max-height: 800px;">
    		  <table class="table table-responsive table-bordered table-main" style="width: 100%; font-size: 14px;">
    		  	<thead>
    		  		<tr>
    			      <th class="sticky-col">ID || Code</th>
                <th>3 mnth</th>
                <th>6 mnth</th>
                <th>9 mnth</th>
                <th>12 mnth</th>
                <th>Min / Max</th>
                <th>Suggestion All</th>
                <th>Suggestion SO</th>
                <th>new Min</th>
                <th>new Max</th>
    			    </tr>
    		  	</thead>
    		  	<tbody>
              <?php
              // echo json_encode($productdetail);
                if (isset($productdetail['detail'])) {
                  foreach ($productdetail['detail'] as $row => $list) {  
                    $sgtMinAll = 0;
                    $sgtMaxAll = 0;
                    $avrgAll = 0;

                    $sgtMinSO = 0;
                    $sgtMaxSO = 0;
                    $avrgSO = 0;
              ?>
      		  		<tr>
                  <td class="sticky-col">
                    <input type="hidden" class="form-control input-sm productid" placeholder="Product ID" name="productid[]" readonly="" value="<?php echo $list['ProductID']; ?>">
                    <input type="text" class="form-control input-sm productcode" placeholder="Product Code" name="productcode[]" readonly="" value="<?php echo $list['ProductID'].' | '.$list['ProductCode']; ?>">    
                  </td>
                  <td>
                    <?php
                      if (isset($list['3bln'])) {
                        foreach ($list['3bln'] as $row => $listd) { 
                    ?>
                        <button type='button' class='btn btn-xs btn-no <?php echo $listd['DOType'];?>' title="<?php echo $listd['DOType']." : ".$listd['ProductQty'];?>"><?php echo $listd['avrg'];?></button>    
                    <?php 
                          $avrgAll += $listd['avrg'];
                          $avrgSO += ($listd['DOType'] == 'SO') ? $listd['avrg'] : 0 ;
                        } 
                      } else { 
                    ?>
                        <button type='button' class='btn btn-xs btn-no' title="none">0</button>    
                    <?php 
                      }
                      $sgtMinAll = round($avrgAll * $productdetail['main']['StockMin']);
                      $sgtMaxAll = round($avrgAll * $productdetail['main']['StockMax']);

                      $sgtMinSO = round($avrgSO * $productdetail['main']['StockMin']);
                      $sgtMaxSO = round($avrgSO * $productdetail['main']['StockMax']);
                    ?>
                  </td>
                  <td>
                    <?php
                      if (isset($list['6bln'])) {
                        foreach ($list['6bln'] as $row => $listd) { 
                    ?>
                        <button type='button' class='btn btn-xs btn-no <?php echo $listd['DOType'];?>' title="<?php echo $listd['DOType']." : ".$listd['ProductQty'];?>"><?php echo $listd['avrg'];?></button>    
                    <?php } } else { ?>
                        <button type='button' class='btn btn-xs btn-no' title="none">0</button>    
                    <?php } ?>  
                  </td>
                  <td>
                    <?php
                      if (isset($list['9bln'])) {
                        foreach ($list['9bln'] as $row => $listd) { 
                    ?>
                        <button type='button' class='btn btn-xs btn-no <?php echo $listd['DOType'];?>' title="<?php echo $listd['DOType']." : ".$listd['ProductQty'];?>"><?php echo $listd['avrg'];?></button>    
                    <?php } } else { ?>
                        <button type='button' class='btn btn-xs btn-no' title="none">0</button>    
                    <?php } ?>
                  </td>
                  <td>
                    <?php
                      if (isset($list['12bln'])) {
                        foreach ($list['12bln'] as $row => $listd) { 
                    ?>
                        <button type='button' class='btn btn-xs btn-no <?php echo $listd['DOType'];?>' title="<?php echo $listd['DOType']." : ".$listd['ProductQty'];?>"><?php echo $listd['avrg'];?></button>    
                    <?php } } else { ?>
                        <button type='button' class='btn btn-xs btn-no' title="none">0</button>    
                    <?php } ?> 
                  </td>
                  <td><?php echo $list['MinStock']." / ".$list['MaxStock']; ?></td>
                  <td><?php echo $sgtMinAll." / ".$sgtMaxAll; ?></td>
                  <td><?php echo $sgtMinSO." / ".$sgtMaxSO; ?></td>
                  <td>
                    <input type="number" min="0" class="form-control input-sm minstock" name="min[]" value="<?php echo $sgtMinSO;?>" required="">    
                  </td>
                  <td>
                    <input type="number" min="0" class="form-control input-sm maxstock" name="max[]" value="<?php echo $sgtMaxSO;?>" required="">    
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
  sum($(this))
});
$(".price").keyup(function() {
  sum($(this))
});
function sum(el) {
  par = el.parent().parent()
  hpp = par.find(".hpp").val()
  persen = par.find(".persen").val()
  price = par.find(".price").val()
  result = ((parseFloat(price) - parseFloat(hpp))/parseFloat(hpp)) * 100;
  if (!isNaN(result)) {
    par.find(".persen").val( result.toFixed(2) )
  }else{
    par.find(".persen").val("0")
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