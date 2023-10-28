<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">
.table-main{
  font-size: 12px;
  white-space: nowrap;
}
.table-main thead tr{
  background: #3c8dbc;
  color: #ffffff;
  align-content: center;
}
.table-main tbody tr:hover { background: #3c8dbcb0; }
.table-main tbody tr td { padding: 2px 10px; font-weight: bold; }
.productqtyorder, .productqty, .productqtysent, .productstock {
  min-width: 50px;
  padding: 5px 3px;
  height: 25px;
}
.martop { margin-top: 5px; }

/*efek load*/
.loader {
  margin: auto;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid blue;
  border-bottom: 16px solid blue;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
/*-------------------------------*/

.nonPriority{
  background-color: #ef9d9d;
}
</style>

<?php 
$main 		= $detail['main'];
$product 	= $detail['product'];
$warehouse 	= $detail['warehouse'];
$BillingAddress = str_replace(";", ", ", $main['BillingAddress']);
$ShipAddress = explode(";", $main['ShipAddress']);
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

    <div class="modal fade" id="modal-cell">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <table>
	        	<tr class="cellproduct" dataproduct="">
	               	<td>
	               		<input class="productid" name="productid[]" type="hidden" readonly="" required="">
	               		<div class="productid2"></div>
	               	</td>
	             	<td>
	             		<input class="productcode" name="productcode[]" type="hidden" readonly="" required="">
	               		<div class="productcode2"></div>
	             	</td>
                  	<td>
                  		<input class="productstock" name="productstock[]" type="hidden" required="" readonly="">
	               		<div class="productstock2"></div>
                  	</td>
	              	<td>
	              		<input class="productqtyorder" name="productqtyorder[]" type="hidden" min="0" required="" readonly="">
	               		<div class="productqtyorder2"></div>
	              	</td>
	              	<td>
	              		<input class="productqtysent" name="productqtysent[]" type="hidden" min="1" required="" readonly="">
	               		<div class="productqtysent2"></div>
	              	</td>
                  <td><input class="form-control input-sm productqty" name="productqty[]" type="number" min="1" required=""></td>
                  <td><button type='button' class='btn btn-default btn-xs sopending' data-toggle='modal' data-target='#modal-detail'></button></td>
                    
                  <td>
                    <input class="sopriority" name="sopriority[]" type="hidden" readonly="">
                    <input class="sopriorityQty" name="sopriorityQty[]" type="hidden" readonly="">
                    <span class="sopriority2"></span> / 
                    <span class="sopriorityQty2"></span>
                  </td>
	                <td>
                    <input class="stockable" name="stockable[]" type="hidden" required="">
                    <span class="stockable2"></span>
                  </td>
                  <td>
	                  <button type="button" class="btn btn-danger btn-xs remove"><i class="fa fa-remove"></i></button>
	                </td>
	            </tr>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="box box-solid">
      <div class="box-body">
          <form name="form" id="form" action="<?php echo base_url();?>transaction/delivery_order_add_act" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="col-md-6">
  		        <div class="box box-solid">
  		            <div class="box-header with-border">
  		              <h3 class="box-title">SEND TO</h3>
  		            </div>
  		            <div class="box-body">
  		            	<div class="col-md-12 martop">
	  		            	<div class="col-md-3"><label>Customer</label></div>
	  		            	<div class="col-md-9"><?php echo $BillingAddress; ?></div>
  		            	</div>
  		            	<div class="col-md-12 martop">
	  		            	<div class="col-md-3"><label>Shipping</label></div>
	  		            	<div class="col-md-9"><?php echo $ShipAddress[2]; ?></div>
  		            	</div>
  		            </div>
  		        </div>
            </div>
            <div class="col-md-6">
            	<div class="box box-solid">
		            <div class="box-header with-border">
		              <h3 class="box-title">SEND FROM</h3>
		            </div>
		            <div class="box-body">
			            <div class="col-md-12 martop">
	  		            	<div class="col-md-3"><label>Warehouse</label></div>
	  		            	<div class="col-md-9">
		                        <select class="form-control" style="width: 100%;" name="warehouse" id="warehouse" required="">
		                          <?php foreach ($warehouse as $row => $list) { ?>
		                          <option value="<?php echo $list['WarehouseID'];?>"><?php echo $list['WarehouseName'];?></option>
		                          <?php } ?>
		                        </select> 
	  		            	</div>
			            </div>
			            <div class="col-md-12 martop">
			              	<div class="col-md-3"><label> DO type</label></div>
			              	<div class="col-md-5">
			                	<input class="form-control input-sm" name="type" type="text" placeholder="TYPE" required="" readonly="" value="SO">
			              	</div>
			              	<div class="col-md-4">
			                	<input class="form-control input-sm" name="reff" type="text" placeholder="REFF" required="" readonly="" value="<?php echo $main['SOID']; ?>">
			              	</div>
			            </div>
			            <div class="col-md-12 martop">
			              	<div class="col-md-3"><label> DO Date</label></div>
			              	<div class="col-md-9">
				                <div class="input-group date">
				                  <div class="input-group-addon">
				                    <i class="fa fa-calendar"></i>
				                  </div>
				                  <input type="text" class="form-control" id="date" name="date" autocomplete="off" required="" >
				                </div>
                      </div>
  		            </div>
  		            <div class="col-md-12 martop">
  		              	<div class="col-md-3"><label> DO Notes</label></div>
  		              	<div class="col-md-9">
  		                	<textarea class="form-control" id="note" name="note" placeholder="note" autocomplete="off"></textarea>
  		                </div>
  		            </div>
		            </div>
		        </div>
            </div>
            <div class="col-md-12" style="overflow-x:auto;">
              <table class="table table-bordered table-main table-responsive">
                <thead>
                  <tr>
                    <th>Product ID</th>
                    <th>Product Code</th>
                    <th>Stock</th>
                    <th>Qty order</th>
                    <th>Qty delivered</th>
                    <th>Qty</th>
                    <th>DO Pending</th>
                    <th>Priority (ID/Qty)</th>
                    <th>Stockable</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
            <div class="col-md-12">
              <div class="box-footer" style="text-align: center;">
                <button type="submit" class="btn btn-primary" >Submit</button>
              </div>
            </div>
          </form>
      </div>
    </div>

    <div class="modal fade" id="modal-detail">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Detail</h4>
          </div>
          <div class="modal-body">
            <div class="loader"></div>
            <div id="detailcontentAjax"></div>
          </div>
          <div class="modal-footer"></div>
        </div>
      </div>
    </div>

  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
var product = [];
var SOID = <?php echo $main['SOID'];?>;
jQuery( document ).ready(function( $ ) {
	 
	currentdate = new Date();
  StartDate = new Date(currentdate.getTime() - (3 * 24 * 60 * 60 * 1000));
  $("#date")
  .attr('readonly', true)
  .datepicker({ 
    autoclose: true, 
    format: 'yyyy-mm-dd',
  })
  .datepicker("setDate", currentdate)
  .datepicker('setStartDate', StartDate)
  .datepicker('setEndDate', currentdate);
	product = $.parseJSON('<?php if ( isset($detail['product2'])){ echo $detail['product2']; }?>');
    setTimeout( function order() {
      fillproduct();
    }, 500)
})
function fillproduct() {
	if (product !== null) {
	  for( var i = 0; i<product.length; i++){
	    $(".cellproduct:first .productid").val(product[i]['ProductID']);
	    $(".cellproduct:first .productid2").text(product[i]['ProductID']);
	    $(".cellproduct:first .productcode").val(product[i]['ProductName']);
	    $(".cellproduct:first .productcode2").text(product[i]['ProductName']);
	    $(".cellproduct:first .productqtyorder").val(product[i]['ProductQty']);
	    $(".cellproduct:first .productqtyorder2").text(product[i]['ProductQty']);
	    $(".cellproduct:first .productqtysent").val(product[i]['totaldo']);
      $(".cellproduct:first .productqtysent2").text(product[i]['totaldo']);
      $(".cellproduct:first .productqty").val(product[i]['ProductQty']);
      $(".cellproduct:first .sopending").val(product[i]['ProductID']);
      $(".cellproduct:first .sopending").text(product[i]['pendingDO']);
      $(".cellproduct:first .sopriority").val(product[i]['PriorityID']);
      $(".cellproduct:first .sopriority2").text(product[i]['PriorityType']+" - "+product[i]['PriorityID']);
      $(".cellproduct:first .sopriorityQty").val(product[i]['PriorityQty']);
      $(".cellproduct:first .sopriorityQty2").text(product[i]['PriorityQty']);
      $(".cellproduct:first .stockable").val(product[i]['Stockable']);
      if (product[i]['Stockable'] === '1') {
        $(".cellproduct:first .stockable2").html('<i class="fa fa-check"></i>');
      }
	    $(".cellproduct:first").attr('dataproduct',product[i]['ProductID']);
	    // $(".cellproduct:first .productcode").css('width',$(".cellproduct:first .productcode").val().length * 8);
	    $(".cellproduct:first").clone().appendTo('.table-main>tbody');
      // console.log($(".cellproduct:last .sopriority").val())
      if ($(".cellproduct:last .sopriority").val() != SOID) {
        $(".cellproduct:last").addClass( "nonPriority" )
      }
	    $(".cellproduct:first input").val("");
	  }
	}
  fillstock();
  resize();
}
function resize() {
	$('.table-main').find('input').each(function (i, el) {
	  $(this).css('width',($(this).val().length * 8) + 30);
	});
}
$(".remove").live('click', function() {
	par = $(this).closest("tr").remove();
});
$('.productqty').live( "keyup", function() {
	par  = $(this).parent().parent();
	qty  = parseInt($(this).val());
	qtyorder	= parseInt(par.find('.productqtyorder').val());
	qtysent   = parseInt(par.find('.productqtysent').val());
	qtystock  = parseInt(par.find('.productstock').val());
  if ((qty + qtysent) > qtyorder) {
    alert("qty baru lebih besar dari ketentuan!")
    return false
  }
  // if (qty > qtystock) {
  //   alert("qty baru lebih besar dari STOCK!")
  //   return false
  // }
});
$("#warehouse").live('change', function() {
  fillstock();
  resize();
});
function fillstock() {
  warehouse = $("#warehouse").val();
  product   = [];
  $('.table-main .productid').each(function(){
    par       = $(this).parent().parent();
    par.find(".productstock").val("");
    par.find(".productstock2").text("");
    product.push($(this).val());
  })
  $.ajax({
      url: "<?php echo base_url();?>transaction/get_stock",
      type : 'POST',
      data: {product: product, warehouse: warehouse},
      dataType : 'json',
      success : function (response) {
        $('.table-main .productid').each(function(){
            par   = $(this).parent().parent();
            stock = par.find(".productstock");
            stock2 = par.find(".productstock2");
            stock.val(response[$(this).val()]['stock'])
            stock2.text(response[$(this).val()]['stock'])
            // console.log(response[$(this).val()]['stock'])
        })
      }
    })
}
$("#form").submit(function(e) {
    if ($('.table-main .productid').length < 1) {
      e.preventDefault();
      alert("List Produk Kosong!")
      return false
    }
    errorcount = 0
    errornote  = ""
    $('.table-main .productqty').each(function(){
    		par    = $(this).parent().parent();
    		qty 	 = parseInt($(this).val());
        productid  = parseInt(par.find('.productid').val());
    		qtyorder	= parseInt(par.find('.productqtyorder').val());
    		qtysent	  = parseInt(par.find('.productqtysent').val());
        qtystock  = parseInt(par.find('.productstock').val());
        // pendingRAW = parseInt(par.find('.rawpending').val());
        stockable  = parseInt(par.find('.stockable').val());
        sopriority  = parseInt(par.find('.sopriority').val());
    		sopriorityQty  = parseInt(par.find('.sopriorityQty').val());
        if (qty == 0) {
          e.preventDefault();
          alert("QUANTITY purchase tidak boleh nol")
          return false
        }
        if ((qty + qtysent) > qtyorder) {
          e.preventDefault();
      	  alert("QUANTITY baru lebih besar dari ketentuan!")
          return false
        }
        if (stockable === 1) {
          if ((qty) > qtystock) {
            e.preventDefault();
            alert("QUANTITY baru lebih besar dari STOCK!")
            return false
          }
        }
        if (sopriority != SOID) {
          errorcount += 1
          errornote += "- untuk Product ID "+ productid +" ada SO lain yang lebih Prioritas\n"
        }
        if ( (qtystock-qty) < sopriorityQty) {
          errorcount += 1
          errornote += "- stok Product ID "+ productid +" tidak cukup untuk SO Prioritas\n"
        }

        // if (pendingRAW>0 && (qty) > (qtystock-pendingRAW)) {
        //   errornote += "- untuk Product ID "+ productid +" bagian dari pending RAW\n"
        //   errorcount += 1
        // }
    });

    if (errorcount > 0) {
      errornote += "apakah anda yakin?"
      var r = confirm(errornote);
      if (r == false) {
        e.preventDefault();
        return false
      }
    }
});


function get(product, type) {
  xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>transaction/product_stock_pending"
    url=url+"?product="+product+"&type="+type
    // alert(url);
    xmlHttp.onreadystatechange=stateChanged
    xmlHttp.open("GET",url,true)
    xmlHttp.send(null)
}
function stateChanged(){
    if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
        $('.loader').slideUp("fast")
        document.getElementById("detailcontentAjax").innerHTML=xmlHttp.responseText
    }
}
function GetXmlHttpObject(){
    var xmlHttp=null;
    try{
        xmlHttp=new XMLHttpRequest();
    }catch(e){
        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    return xmlHttp;
}

$('.sopending').live('click', function(e){
    ProductID  = $(this).val()
    $('.loader').slideDown("fast")
    $('#detailcontentAjax').empty()
    get(ProductID, 'so_raw');
}); 
$('button.detailso').live('click', function(e){
  id  = $(this).attr("detailid")
  $('.detailso2').slideUp("fast")
  $('.detailso2[detailid='+id+']').slideDown("fast")
});
</script>