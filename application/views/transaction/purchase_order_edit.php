<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">

<style type="text/css">
.table-main,
.table-raw {
  font-size: 12px;
  white-space: nowrap;
}
.table-main thead tr,
.table-raw thead tr {
  background: #3c8dbc;
  color: #ffffff;
  align-content: center;
}
.table-raw thead tr th { padding: 3px; }
.table-main tbody tr:hover {
  background: #3c8dbcb0;
}
.table-main th:first-child, .table-main td:first-child { max-width: 75px !important; }
.table-main td:first-child input { max-width: 60px; }
/*.table-raw { width: 100%; }*/
.table-raw tr td { padding: 2px 5px; }
/*.table-raw tr td:nth-child(2) { width: 600px; }*/
/*.remove { padding: 4px 3px; margin: 2px 2px; }*/
/*.plusraw { padding: 2px 3px; margin: 2px 2px; } */
.productstock, .productqty, .productqtypurchase, .productqtydone,
.rawstock, .rawqtyorder, .productdisc, .rawqtyuse {
  min-width: 50px;
  padding: 2px 3px;
}
.productprice, .productprice2 {
  min-width: 80px;
  padding: 2px 3px;
}
.cellraw .table-raw { background: #fd8686; }
.cellraw td:first-child { text-align: -webkit-left; }
.cellraw table { margin-bottom: 0px !important; }
.cellraw table td { padding: 2px 2px !important; }
.rawid { display: inline; }
.rawcode { min-width: 150 }
.customborder { border: 1px solid #3c8dbc; padding: 3px;}
.supplieraddress { height: 50px; white-space: normal; padding: 3px !important;}
.cellproduct .input-sm, .cellraw .input-sm { height: 22px !important; }
.productcodesupplier { max-width: 400px; display: inline-block; }
.nonStoskable { background-color: #ffd2d2; }
@media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 100px;
      /*padding: 5px 15px 5px 5px;*/
    }
    .form-group span.left2 {
      display: block;
      overflow: hidden;
    }
    .form-group { margin-bottom: 5px; }
}
input.formImport {
  background: #4caf50b8 !important;
  /*display: none;*/
}
</style>

<?php 
$main = $po_detail['main'];
$ROID = $main['ROID'];
$DORQty = $main['DORQty'];
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
                  <input class="Stockable" name="Stockable[]" type="hidden" readonly="" required="">
                  <input class="productid" name="productid[]" type="hidden" readonly="" required="">
                  <div class="productid2"></div>
                </td>
                <td>
                  <input class="productcode" name="productcode[]" type="hidden" readonly="" required="">
                  <div class="productcode2"></div>
                </td>
                <td>
                  <input class="form-control input-sm productcodesupplier" name="productcodesupplier[]" type="text">
                  <button type="button" class="btn btn-danger btn-xs clear-supplier" title="Clear Name Supplier"><i class="fa fa-remove"></i></button>
                </td>
                <td>
                  <input class="productqty" name="productqty[]" type="hidden" min="0" required="" readonly="">
                  <div class="productqty2"></div>
                </td>
                <td>
                  <input class="productqtydone" name="productqtydone[]" type="hidden" min="1" required="" readonly="">
                  <div class="productqtydone2"></div>
                </td>
                <td><input class="form-control input-sm productqtypurchase" name="productqtypurchase[]" type="number" min="1" required=""></td>
                <td>
                  <input class="productdor" name="productdor[]" type="hidden" value="0">
                  <input class="rawdo" name="rawdo[]" type="hidden" value="0">
                  <div class="dor_do"></div>
                </td>
                <td>
                  <input class="form-control input-sm productprice mask-number" name="productprice[]"  type="text" min="0" required="">
                  <input class="form-control input-sm productprice2 mask-number formImport" name="productprice2[]"  type="text" min="0" required="">
                </td>
                <td>
                  <input class="producthpp" name="producthpp[]" type="hidden" readonly="" required="">
                  <div class="producthpp2"></div>
                </td>
                <!-- <td><input class="form-control input-sm productdisc" name="productdisc[]" type="number" required="" min="0" max="100"></td> -->
                <td>
                  <input class="form-control input-sm productpricetotal mask-number" name="productpricetotal[]" type="text" readonly="" required="">
                  <input class="form-control input-sm productpricetotal2 mask-number formImport" name="productpricetotal2[]" type="text" readonly="" required="">
                </td>
                <td>
                  <?php if ($ROID == 0) { ?>
                      <button type="button" class="btn btn-primary btn-xs plusraw"><i class="fa fa-plus"></i> RAW</button>
                  <?php } ?>
                  <button type="button" class="btn btn-danger btn-xs remove"><i class="fa fa-remove"></i></button>
                </td>
              </tr>
              <tr class="cell2raw" dataproduct="">
                <td>
                  <input class="form-control input-sm rawid" name="rawid[]" type="text" readonly="" required="">
                  <input class="form-control input-sm rawproductid" name="rawproductid[]" type="hidden" readonly="" required="">
                </td>
                <td><input class="form-control input-sm rawcode" name="rawcode[]" type="text" readonly="" required=""></td>
                <td><input class="form-control input-sm rawqtyorder" name="rawqtyorder[]" type="text" readonly="" required=""></td>
                <td><input class="form-control input-sm rawqtysent" name="rawqtysent[]" type="text" readonly="" required=""></td>
                <td><input class="form-control input-sm rawqtyuse" name="rawqtyuse[]" type="number" min="0" required=""></td>
                <td><input class="form-control input-sm rawstock" name="rawstock[]" type="text" readonly="" required=""></td>
                <td><input class="form-control input-sm rawstockAll" name="rawstockAll[]" type="text" readonly="" required=""></td>
                
                <td>
                  <?php if ($ROID == 0) { ?>
                    <!-- <button type="button" class="btn btn-danger btn-xs removeRaw"><i class="fa fa-remove"></i></button> -->
                  <?php } ?>
                </td>
              </tr>
              <tr class="cellraw" dataproduct="">
                <td></td>
                <td colspan="5">
                  <table class="table-raw">
                    <thead>
                      <th>ID</th>
                      <th>ProductCode</th>
                      <th>Qty RO</th>
                      <th>Qty Sent</th>
                      <th>Qty use</th>
                      <th>Stock</th>
                      <th>StockAll</th>
                      <th></th>
                    </thead>
                    <tbody></tbody>
                  </table>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="box box-solid">
      <div class="box-body">
          <form name="form" id="form" action="<?php echo base_url();?>transaction/purchase_order_edit_act" method="post" enctype="multipart/form-data" autocomplete="on">
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">PO ID</label>
                <span class="left2">
                  <input type="hidden" class="form-control input-sm" id="ro" name="ro" placeholder="ro" autocomplete="off" readonly="" value="<?php echo $main['ROID'];?>">
                  <input type="text" class="form-control input-sm" id="po" name="po" placeholder="po" autocomplete="off" readonly="" value="<?php echo $main['POID'];?>">
                </span>
              </div>
              <div class="form-group supplier-name">
                <label class="left">
                  Supplier
                </label>
                <span class="left2">
                  <div class="input-group input-group-sm">
                      <input type="hidden" class="contactid" name="contactid" value="">
                      <select class="form-control select2 suppliername" name="supplier" required="">
                        <option value="<?php echo $main['SupplierID'].'_'.$main['suppliername'].'_'.$main['suppliercompany'];?>"><?php echo $main['suppliername'].", ".$main['suppliercompany'] ;?></option>
                        <?php 
                          foreach ($supplier as $row => $list) { 
                            if ($list['isActive'] == 1) {
                        ?>
                        <option value="<?php echo $list['SupplierID'].'_'.$list['fullname'].'_'.$list['Company'];?>"><?php echo $list['fullname'] ;?></option>
                        <?php } } ?>
                      </select>
                      <span class="input-group-btn">
                          <button type="button" class="btn btn-primary btn-xs view-supplier" title="DETAIL"><i class="fa fa-fw fa-reorder"></i></button>
                          <button type="button" class="btn btn-primary btn-xs edit-supplier" title="EDIT" onclick="editsupplier();"><i class="fa fa-fw fa-edit"></i></button>
                      </span>
                  </div>
                </span>
              </div>
              <div class="form-group supplier-detail customborder">
                <div class="form-group">
                  <label class="left">Phone</label>
                  <span class="left2">
                    <select class="form-control input-sm supplierphone" style="width: 100%;" name="supplierphone" required="">
                      <option value="<?php echo $main['supplierphone'];?>"><?php echo $main['supplierphone'] ;?></option>
                    </select>
                  </span>
                </div>
                <div class="form-group">
                  <label class="left">Email</label>
                  <span class="left2">
                    <select class="form-control input-sm supplieremail" style="width: 100%;" name="supplieremail" required="">
                      <option value="<?php echo $main['supplieremail'];?>"><?php echo $main['supplieremail'] ;?></option>
                    </select>
                  </span>
                </div>
                <div class="form-group">
                  <label class="left">Address</label>
                  <span class="left2">
                    <select class="form-control input-sm supplieraddress" style="width: 100%; height: 50px;" name="supplieraddress" required="">
                      <option value="<?php echo $main['supplieraddr'];?>"><?php echo $main['supplieraddr'] ;?></option>
                    </select>
                  </span>
                </div>
              </div><p></p>
              <div class="form-group">
                <label class="left">Pay Term</label>
                <span class="left2">
                  <input class="form-control input-sm paymentterm" name="paymentterm" type="number" min="0" required="" value="<?php echo $main['PaymentTerm'];?>">
                </span>
              </div>
              <div class="form-group">
                <label class="left">PO Date</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm pull-right" id="scheduledate" name="scheduledate" autocomplete="off" required="" value="<?php echo $main['PODate'];?>" readonly="true">
                </div>
              </div>
              <div class="form-group">
                <label class="left">PO Notes</label>
                <span class="left2">
                  <textarea class="form-control input-sm" id="note" name="note"><?php echo $main['PONote'];?></textarea>
                </span>
              </div>
            </div>
            <div class="col-md-6"> 
              <div class="form-group">
                <label class="left">Billing to</label>
                <span class="left2">
                  <select class="form-control select2" style="width: 100%;" name="billingto" required="">
                    <option value="<?php echo $main['CompanyID'];?>"><?php echo $main['CompanyName'];?></option>
                    <?php foreach ($company as $row => $list) { ?>
                    <option value="<?php echo $list['CompanyID'];?>"><?php echo $list['CompanyName'];?></option>
                    <?php } ?>
                  </select>
                </span>
              </div><p></p>
              <div class="form-group">
                <label class="left">Shipping to</label>
                <span class="left2">
                  <select class="form-control select2" style="width: 100%;" name="shippingto" required="">
                    <option value="<?php echo $main['WarehouseID'];?>"><?php echo $main['WarehouseName'];?></option>
                    <?php 
                      if ($main['DORQty'] < 1) {
                        foreach ($warehouse as $row => $list) { 
                    ?>
                        <option value="<?php echo $list['WarehouseID'];?>"><?php echo $list['WarehouseName'];?></option>
                    <?php } } ?>
                  </select>
                </span>
              </div><p></p>
              <div class="form-group">
                <label class="left">Ship Date</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="shippingdate" name="shippingdate" autocomplete="off" required="" value="<?php echo $main['ShippingDate'];?>">
                </div>
              </div>
              <div class="form-group">
                <label class="left">Shipping Alternative</label>
                <span class="left2">
                  <textarea class="form-control input-sm" id="shippingalt" name="shippingalt" autocomplete="off"><?php echo $main['ShippingAlt'];?></textarea>
                </span>
              </div>
              <div class="form-group">
                <label class="left">PO Type</label>
                <span class="left2">
                  <select class="form-control input-sm" name="potype" id="potype" required="">
                    <option value="<?php echo $main['POType'];?>"><?php echo $main['POType'];?></option>
                    <option value="local">local</option>
                    <option value="import">import</option>
                  </select>
                </span>
              </div>
              <div class="form-group customborder divpotype">
                <div class="form-group">
                  <label class="left">Currency</label>
                  <span class="left2">
                      <input type="text" class="form-control pull-right input-sm" id="currency" name="currency" autocomplete="off" placeholder="Rp" value="<?php echo $main['POCurrency'];?>">
                  </span>
                </div>
                <div class="form-group">
                  <label class="left">Currency EX</label>
                  <span class="left2">
                      <input class="form-control input-sm currencyex mask-number" name="currencyex" type="text" required="" value="<?php echo $main['POCurrencyEx'];?>">
                  </span>
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">Attachment</label>
                  <input type="file" class="input-file" id="attachment" name="attachment" accept="application/pdf">
                  <p class="help-block">Harus berbentuk PDF</p>
                </div>
              </div>

              <?php if ($ROID == 0 && $DORQty <1) { ?>
                <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-btn raw">
                        <button type="button" class="btn btn-primary btn-sm" id="open_popup_product">TAMBAH</button>
                      </div>
                      <input type="text" class="form-control input-sm" readonly value="Search Product">
                    </div>
                </div>
              <?php } ?>
            </div>
            <div class="col-md-12" style="overflow-x:auto;">
              <table class="table table-bordered table-main table-responsive">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Product Code</th>
                    <th>Product Code Supplier</th>
                    <th>Qty order</th>
                    <th>Qty Purchased</th>
                    <th>Qty purchase</th>
                    <th>DOR / Raw DO</th>
                    <th>Price</th>
                    <th>HPP</th>
                    <!-- <th>Disc%</th> -->
                    <th>Total</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </div>
            <div class="col-md-6">
              <div class="form-group formImport">
                <label class="left">Tax Result 2</label>
                <span class="left2">
                  <input class="form-control input-sm taxresult2 mask-number formImport" name="taxresult2" type="text" required="" readonly="" value="<?php echo $main['TaxAmount2'];?>">
                </span>
              </div>
              <div class="form-group formImport">
                <label class="left">Before Tax 2</label>
                <span class="left2">
                  <input class="form-control input-sm pricebefore2 mask-number formImport" name="pricebefore2" type="text" required="" readonly="" value="<?php echo $main['PriceBefore2'];?>">
                </span>
              </div>
              <div class="form-group formImport">
                <label class="left">Total Price 2</label>
                <span class="left2">
                  <input class="form-control input-sm totalprice2 mask-number formImport" name="totalprice2" type="text" required="" readonly="" value="<?php echo $main['TotalPrice2'];?>">
                </span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Tax Percent</label>
                <span class="left2">
                  <input class="form-control input-sm taxpercent" name="taxpercent" type="number" min="0" step="0.1" required="" value="<?php echo $main['TaxRate'];?>">
                </span>
              </div>
              <div class="form-group">
                <label class="left">Tax Result</label>
                <span class="left2">
                  <input class="form-control input-sm taxresult mask-number" name="taxresult" type="text" required="" readonly="" value="<?php echo $main['TaxAmount'];?>">
                </span>
              </div>
              <div class="form-group">
                <label class="left">Before Tax</label>
                <span class="left2">
                  <input class="form-control input-sm pricebefore mask-number" name="pricebefore" type="text" required="" readonly="" value="<?php echo $main['PriceBefore'];?>">
                </span>
              </div>
              <div class="form-group">
                <label class="left">Total Price</label>
                <span class="left2">
                  <input class="form-control input-sm totalprice mask-number" name="totalprice" type="text" required="" readonly="" value="<?php echo $main['TotalPrice'];?>">
                </span>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box-footer" style="text-align: center;">
                <button type="submit" class="btn btn-primary submit_form" >Submit</button>
              </div>
            </div>
          </form>
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.inputmask.bundle.js"></script>
<script>
var po_product = [];
var po_raw = [];
ROID = $("#ro").val()
j8 = jQuery.noConflict();
jQuery( document ).ready(function( $ ) {
  $('.select2').select2();
  // $("#scheduledate").datepicker({ autoclose: true, format: 'yyyy-mm-dd'})
  $("#shippingdate").datepicker({ autoclose: true, format: 'yyyy-mm-dd'});
  $(".table-main>thead").click();
  $(".view-supplier").click();
  // jika edit
  if ($("#po").val() !== "") {
    $('#potype').trigger("change");
    po_product = $.parseJSON('<?php if ( isset($po_detail['product2'])){ echo $po_detail['product2']; }?>');
    po_raw = $.parseJSON('<?php if ( isset($po_detail['raw2'])){ echo $po_detail['raw2']; }?>');
    setTimeout( function order() {
      fillproduct();
    }, 1000)
    setTimeout( function order() {
      fillraw();
    }, 2000)
  }
  // ================================

  $(".mask-number").inputmask({ 
      alias:"currency", 
      prefix:'', 
      autoUnmask:true, 
      removeMaskOnSubmit:true, 
      showMaskOnHover: true 
  });
});
j8(".table-main>thead").click(function(){
  // j8(".table-main>tbody").slideToggle();
});
j8(".view-supplier").click(function(){
  j8(".supplier-detail").slideToggle();
});
j8('#potype').live('change',function(e){
  potype = j8('#potype').val()
  if (potype === "local") {
    // console.log(potype)
    j8(".divpotype").slideUp();
    j8(".formImport").slideUp();
  } else {
    j8(".divpotype").slideDown();
    j8(".formImport").slideDown();
  }
})

function fillproduct() {
  if (po_product !== null) {
    for( var i = 0; i<po_product.length; i++){
      ProductPriceHPP = Number(po_product[i]['ProductPriceHPP']).toLocaleString(undefined, {minimumFractionDigits: 2})
      j8(".cellproduct:first .Stockable").val(po_product[i]['Stockable']);
      j8(".cellproduct:first .productid").val(po_product[i]['ProductID']);
      j8(".cellproduct:first .productid2").text(po_product[i]['ProductID']);
      j8(".cellproduct:first .productcode").val(po_product[i]['ProductCode']);
      j8(".cellproduct:first .productcode2").text(po_product[i]['ProductCode']);
      j8(".cellproduct:first .productcodesupplier").val(po_product[i]['ProductSupplierCode']);
      j8(".cellproduct:first .productqty").val(po_product[i]['QtyOrder']);
      j8(".cellproduct:first .productqty2").text(po_product[i]['QtyOrder']);
      j8(".cellproduct:first .productqtydone").val(po_product[i]['QtyPurchased']);
      j8(".cellproduct:first .productqtydone2").text(po_product[i]['QtyPurchased']);
      j8(".cellproduct:first .productqtypurchase").val(po_product[i]['ProductQty']).attr('min',po_product[i]['DORQty']);

      j8(".cellproduct:first .productdor").val(po_product[i]['DORQty']);
      j8(".cellproduct:first .rawdo").val(po_product[i]['RawSent2']);
      j8(".cellproduct:first .dor_do").text(po_product[i]['DORQty']+' / '+po_product[i]['RawSent2']);

      j8(".cellproduct:first .producthpp").val(po_product[i]['ProductPriceHPP']);
      j8(".cellproduct:first .producthpp2").text(ProductPriceHPP);
      j8(".cellproduct:first .productprice").val(po_product[i]['ProductPrice']);
      // j8(".cellproduct:first .productdisc").val(po_product[i]['ProductDisc']);
      j8(".cellproduct:first .productpricetotal").val(po_product[i]['ProductPriceTotal']);

      j8(".cellproduct:first .productprice2").val(po_product[i]['ProductPrice2']);
      j8(".cellproduct:first .productpricetotal2").val(po_product[i]['ProductPriceTotal2']);

      // j8(".cellproduct:first .productstock").val(po_product[i]['stock']);
      j8(".cellproduct:first").attr('dataproduct',po_product[i]['ProductID']);
      // j8(".cellproduct:first .productcode").css('width',j8(".cellproduct:first .productcode").val().length * 8);
      if (po_product[i]['Stockable']=='1') {
        j8(".cellproduct:first").clone().appendTo('.table-main>tbody');
      } else {
        j8(".cellproduct:first").clone().appendTo('.table-main>tbody').addClass( "nonStoskable" );;
      }
      j8(".cellproduct:first input").val("");
    }
    j8(".mask-number").inputmask({ 
        alias:"currency", 
        prefix:'', 
        autoUnmask:true, 
        removeMaskOnSubmit:true, 
        showMaskOnHover: true 
    });
  }
  resize();
}
function fillraw() {
  if (po_raw !== null) {
    for( var i = 0; i<po_raw.length; i++){
      j8(".cell2raw:first .rawproductid").val(po_raw[i]['ProductID']);
      j8(".cell2raw:first .rawid").val(po_raw[i]['RawID']);
      j8(".cell2raw:first .rawcode").val(po_raw[i]['ProductCode']);
      j8(".cell2raw:first .rawstock").val(po_raw[i]['Stock']);
      j8(".cell2raw:first .rawstockAll").val(po_raw[i]['stockAll']);
      j8(".cell2raw:first .rawqtyorder").val(po_raw[i]['QtyOrder']);
      j8(".cell2raw:first .rawqtysent").val(po_raw[i]['RawSent2']);
      j8(".cell2raw:first .rawqtyuse").val(po_raw[i]['RawQty']).attr('min',po_raw[i]['RawSent2']);
      j8(".cell2raw:first").attr('dataproduct',po_raw[i]['ProductID']);

      dataproduct = po_raw[i]['ProductID'];
      len = $('.table-main tbody tr[class="cellraw"][dataproduct='+dataproduct+']').length
      if (len == 0) {
        $(".cellraw:first")
          .clone()
          .insertAfter('.table-main tbody tr.cellproduct[dataproduct='+dataproduct+']:last')
          .attr('dataproduct', dataproduct)
      }
      $(".cell2raw:first").clone().appendTo('.table-main tbody tr.cellraw[dataproduct='+dataproduct+'] .table-raw>tbody');

      // if ( j8(".table-raw .cell2raw:first .rawproductid").val() != 'unefined' && j8(".cell2raw:first .rawproductid").val() != j8(".table-raw .cell2raw:first .rawproductid").val() ) {
      //   copyraw()          
      // } else {
      //   j8(".cell2raw:first").clone().appendTo('.table-raw>tbody');
      // }
    }
    // dataproduct = j8(".table-raw .cell2raw:first .rawproductid").val();
    // j8(".cellraw:first").attr('dataproduct', dataproduct);
    // j8(".cellraw:first").clone().insertAfter('.table-main tbody tr[class="cellproduct"][dataproduct='+dataproduct+']:last');
  }
  resizeraw();
  setTimeout( function order() {
    rawvalidation();
  }, 2500)
  j8(".cellraw:first input").val("");
}
function copyraw() {
  dataproduct = j8(".table-raw .cell2raw:first .rawproductid").val();
  j8(".cellraw:first").attr('dataproduct', dataproduct);
  j8(".cellraw:first").clone().insertAfter('.table-main tbody tr[class="cellproduct"][dataproduct='+dataproduct+']:last');
  j8(".table-raw:first>tbody").empty();
  j8(".cell2raw:first").clone().appendTo('.table-raw>tbody');
}
function resize() {
  j8('.table-main').find('input').each(function (i, el) {
    j8(this).css('width',(j8(this).val().length * 8) + 30);
  });
}
function resizeraw() {
  j8('.cell2raw').find('input').each(function (i, el) {
    j8(this).css('width',(j8(this).val().length * 8) + 30);
  });
}
function rawvalidation() {
  j8('.table-main').find('.cell2raw').each(function (i, el) {
    parent = j8(this).closest("tr.cellraw[dataproduct]").attr('dataproduct');
    if (parent != j8(this).attr('dataproduct')) {
      j8(this).remove();
    }
  });
}

var popup;
function openPopupOneAtATime() {
    if (popup && !popup.closed) {
       popup.focus();
    } else {
       popup = window.open('<?php echo base_url();?>master/product_list_popup2', '_blank', 'width=700,height=500,left=200,top=100');     
    }
}

j8('.currencyex').live( "change", function() {
  j8('.table-main .productprice2').each(function(){
    j8(this).trigger('change')
  });
});
j8('.table-main input').live( "change", function() {
  j8(this).css('width',(j8(this).val().length * 8) + 30);
});
j8(".remove").live('click', function() {
  par       = j8(this).parent().parent();
  productid = par.find('.productid').val();
  productdor = par.find('.productdor').val();
  rawdo = par.find('.rawdo').val();
  if (productdor < 1 && rawdo < 1) {
    j8(".table-main tbody tr[dataproduct="+productid+"]").remove();
    counttotal();
    counttax();
  }
});
j8('.productqtypurchase').live( "change", function() {
  countqty(j8(this))
  countline(j8(this))
});
j8('.productprice').live( "change", function() {
  countline(j8(this))
});
j8('.productprice2').live( "change", function() {
  currency_ex(j8(this))
});
j8('.productdisc').live( "change", function() {
  countline(j8(this))
});
j8('.taxpercent').live( "change", function() {
  counttax()
});
function countqty(el) {
  par    = el.parent().parent();
  qty    = parseInt(par.find('.productqty').val());
  qtyd   = parseInt(par.find('.productqtydone').val());
  qtyp   = parseInt(par.find('.productqtypurchase').val());
  if ((qtyp + qtyd) > qty) {
    if (ROID > 0) {
      alert("qty purchase lebih besar dari kebutuhan!")
    }
  }
}
function countline(el) {
  par    = el.parent().parent();
  qty    = par.find('.productqtypurchase').val();
  price  = par.find('.productprice').val();
  price  = price * qty;
  // disc   = par.find('.productdisc').val();
  total  = par.find('.productpricetotal');
  // result = price * ((100-disc) /100);
  result = price;
  total.val(result).css('width',(total.val().length * 8) + 30);
  // ----------------------------------

  price2  = par.find('.productprice2').val();
  price2  = price2 * qty;
  total2  = par.find('.productpricetotal2');
  result2 = price2;
  total2.val(result2).css('width',(total2.val().length * 8) + 30);
  // ----------------------------------

  setTimeout( function order() {
    counttotal();
  }, 200)
  setTimeout( function order() {
    counttax();
  }, 300)
}
function counttax(){
  taxpercent  = j8('.taxpercent').val();
  pricebefore  = j8('.pricebefore').val();
  taxresult   = pricebefore * (taxpercent/100);
  j8('.taxresult').val(taxresult);
  // ----------------------------------

  pricebefore2  = j8('.pricebefore2').val();
  taxresult2   = pricebefore2 * (taxpercent/100);
  j8('.taxresult2').val(taxresult2);
  // ----------------------------------

  setTimeout( function order() {
    counttotal();
  }, 200)
}
function counttotal() {
  var sum = 0;
  j8('.productpricetotal').each(function(){
      sum += Number(j8(this).val());
  });
  taxresult  = j8('.taxresult').val();
  j8('.pricebefore').val(sum);
  j8('.totalprice').val( sum + Number(taxresult));
  // ----------------------------------

  var sum2 = 0;
  j8('.productpricetotal2').each(function(){
      sum2 += Number(j8(this).val());
  });
  taxresult2  = j8('.taxresult2').val();
  j8('.pricebefore2').val(sum2);
  j8('.totalprice2').val( sum2 + Number(taxresult2));
  // ----------------------------------
}
function currency_ex(el) {
  par = el.parent().parent();
  curEx = $('.currencyex').val();
  productprice2 = par.find('.productprice2').val();
  productprice  = par.find('.productprice');
  productprice.val(productprice2*curEx)
  countline(el)
}
j8('.suppliername').live('change',function(e){
  j8(".contactid").empty();
  j8(".supplieraddress").empty();
  j8(".supplierphone").empty();
  j8(".supplieremail").empty();
  j8.ajax({
    url: "<?php echo base_url();?>master/supplier_list_detail2",
    type : 'GET',
    data : 'SupplierID=' + j8(this).val(),
    dataType : 'json',
    success : function (response) {
      j8(".contactid").val(response['ContactID']);
      if ("alamat" in response) {
        j8(".contactid").val(response['ContactID']);
        j8(".paymentterm").val(response['SupplierPayTerm']);
        shippingdate = new Date(j8("#scheduledate").val());
        shippingdate.setDate(shippingdate.getDate()+parseInt(response['SupplierShipTerm']));
        j8("#shippingdate").datepicker({ autoclose: true, format: 'yyyy-mm-dd'}).datepicker("setDate", shippingdate);

        j8(".supplieraddress").append("<option value='"+response['alamat']+"'>"+response['alamat']+"</option>");
        j8(".supplierphone").append("<option value='"+response['phone']+"'>"+response['phone']+"</option>");
        j8(".supplieremail").append("<option value='"+response['email']+"'>"+response['email']+"</option>");
      } else {
        alert("Supplier tersebut tidak punya billing address, seliahkan edit ...")
      }
    }
  })
})

j8('.clear-supplier').live( "click", function() {
  par = j8(this).parent().parent();
  par.find(".productcodesupplier").val("")
  resize();
});
j8('.rawqtyuse').live( "keyup", function() {
  countraw(j8(this))
});
function countraw(el) {
  par    = el.parent().parent();
  rawqtyuse  = parseInt(par.find('.rawqtyuse').val());
  rawqtysent = parseInt(par.find('.rawqtysent').val());
  rawstock   = parseInt(par.find('.rawstock').val());
  if ( (rawqtyuse-rawqtysent) > rawstock) {
    alert("qty RAW tidak mencukupi!")
  }
}
function editsupplier() {
  id = j8(".contactid").val()
  if (id != "") {
    window.open('<?php echo base_url();?>master/supplier_cu/'+id, '_blank');
  }
}


var popup;
function openPopupOneAtATime() {
    if (popup && !popup.closed) {
       popup.focus();
    } else {
       popup = window.open('<?php echo base_url();?>master/product_list_popup3_hpp', '_blank', 'width=700,height=500,left=200,top=100');     
    }
}
j8("#open_popup_product").on('click', function() {
  $(".cell2raw:first input").val("");
  $(".cell2raw:first").attr('dataproduct',"0");
  openPopupOneAtATime();
});
j8(".plusraw").live('click', function() {
  par       = $(this).parent().parent();
  productid = par.find('.productid').val();
  $(".cell2raw:first .rawproductid").val(productid);
  $(".cell2raw:first").attr('dataproduct',productid);
  openPopupOneAtATime();
});


function buildcurlist() {
  par = $(".table-main .cellproduct .productid")
  curlist = []
  for (var i = 0; i < par.length; i++) {
    curlist.push($(par[i]).val())
  }
}
function ProcessChildMessage(message) {
  // console.log(message)
  if ($(".cell2raw:first .rawproductid").val() === "") {
      buildcurlist()
      if ($.inArray(message['tdid'], curlist) < 0) {  //cek jika product exist in list
        ProductPriceHPP = Number(message['tdhpp']).toLocaleString(undefined, {minimumFractionDigits: 2})
        // tdsupplier = (message['tdsupplier'] === "" ? message['tdname'] : message['tdsupplier']);
        $(".cellproduct:first .Stockable").val(message['stockable']);
        $(".cellproduct:first .productid").val(message['tdid']);
        $(".cellproduct:first .productid2").text(message['tdid']);
        $(".cellproduct:first .productcode").val(message['tdcode']);
        $(".cellproduct:first .productcode2").text(message['tdcode']);
        $(".cellproduct:first .productcodesupplier").val(message['tdsupplier']);
        $(".cellproduct:first .productqty").val(0);
        $(".cellproduct:first .productqty2").text(0);
        $(".cellproduct:first .productqtydone").val(0);
        $(".cellproduct:first .productqtydone2").text(0);
        $(".cellproduct:first .productqtypurchase").val(0);
        $(".cellproduct:first .producthpp").val(message['tdhpp']);
        $(".cellproduct:first .producthpp2").text(ProductPriceHPP);
        $(".cellproduct:first .productprice").val('0');
        $(".cellproduct:first .productdisc").val('0');
        $(".cellproduct:first .productpricetotal").val('0');
        $(".cellproduct:first .productstock").val(message['tdstock']);
        $(".cellproduct:first").attr('dataproduct',message['tdid']);

        if (message['stockable']=='1') {
          $(".cellproduct:first").clone().appendTo('.table-main>tbody');
        } else {
          $(".cellproduct:first").clone().appendTo('.table-main>tbody').addClass( "nonStoskable" );;
        }
        $(".cellproduct:first input").val("");
      }
  } else {
      $(".cell2raw:first .rawid").val(message['tdid']);
      $(".cell2raw:first .rawid2").text(message['tdid']);
      $(".cell2raw:first .rawcode").val(message['tdcode']);
      $(".cell2raw:first .rawcode2").text(message['tdcode']);
      $(".cell2raw:first .rawstock").val(message['tdstock']);
      $(".cell2raw:first .rawstock2").text(message['tdstock']);
      $(".cell2raw:first .rawqtyorder").val(0);
      $(".cell2raw:first .rawqtyorder2").text(0);
      $(".cell2raw:first .rawqtyuse").val(0);

      dataproduct = $(".cell2raw:first .rawproductid").val();
      len = $('tr[class="cellraw"][dataproduct='+dataproduct+']').length
      // alert(len)

      // $(".cellraw:first").attr('dataproduct', dataproduct);
      if (len == 0) {
        $(".cellraw:first")
          .clone()
          .insertAfter('.table-main tbody tr.cellproduct[dataproduct='+dataproduct+']:last')
          .attr('dataproduct', dataproduct)
      }
      $(".cell2raw:first").clone().appendTo('tr.cellraw[dataproduct='+dataproduct+'] .table-raw>tbody');
  } 

  j8(".mask-number").inputmask({ 
      alias:"currency", 
      prefix:'', 
      autoUnmask:true, 
      removeMaskOnSubmit:true, 
      showMaskOnHover: true 
  });
  resize();
}
j8(".removeRaw").live('click', function() {
  j8(this).closest('tr').remove();
});

j8("#form").submit(function(e) {
  if (j8('.table-main .cellproduct').length < 1) {
    e.preventDefault();
    alert("List Produk Kosong!")
    return false
  }
  errorcount  = 0
  errornote   = ""
  j8('.table-main .productqtypurchase').each(function(){
      par    = j8(this).parent().parent();
      ProductID   = parseInt(par.find('.productid').val());
      qty    = parseInt(par.find('.productqty').val());
      qtyd   = parseInt(par.find('.productqtydone').val());
      qtyp   = parseInt(par.find('.productqtypurchase').val());
      if (qtyp == 0) {
        errorcount += 1
        errornote += "-Product:"+ProductID+" Quantity purchase tidak boleh nol \n"
      }
      if ((qtyp + qtyd) > qty) {
        if (ROID > 0) {
          errorcount += 1
          errornote += "-Product:"+ProductID+" Quantity purchase lebih besar dari kebutuhan! \n"
        }
      }
  });
  j8('.table-main .rawqtyuse').each(function(){
      par    = j8(this).parent().parent();
      rawid  = parseInt(par.find('.rawid').val());
      rawqtyuse  = parseInt(par.find('.rawqtyuse').val());
      rawqtysent = parseInt(par.find('.rawqtysent').val());
      rawstock   = parseInt(par.find('.rawstock').val());
      if ((rawqtyuse-rawqtysent) > rawstock) {
          errorcount += 1
          errornote += "-Raw:"+rawid+" tidak mencukupi dari gudang utama! \n"
      }
  });

  if (errorcount > 0) {
    var r = confirm(errornote);
    if (r == false) {
      e.preventDefault();
      return false
    }  
  }  
});
</script>
