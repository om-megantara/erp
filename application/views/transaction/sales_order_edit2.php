<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">
  .table-main{ font-size: 12px; white-space: nowrap; }
  .table-main thead tr{
    background: #49afe3;
    color: #ffffff;
    align-content: center;
  }
  .table-main tbody tr:hover { background: #3c8dbcb0; }
  .table-main tbody tr td { padding: 0px 5px; }
  .customborder { border: 1px solid #3c8dbc; padding: 3px;}
  .supplieraddress { height: 50px; white-space: normal; padding: 3px !important;}
  @media (min-width: 768px){
    .vcenter {
      display: flex;
      align-items: center;
      margin-bottom: 2px;
    }
  }
  .select2 { width: 100% !important;}
  .detailcustomer .form-group { margin-bottom: 0px !important; margin-top: 5px !important }
  .box-normal .col-md-3 { padding-left: 0px !important; }
  .cellproduct td { vertical-align: middle !important; }
  .cellproduct input { min-width: 90px; padding: 4px 5px !important; }
  .linetotal { min-width: 90px !important; padding: 4px 5px !important; }
  .detailso .form-group { margin-bottom: 2px; }
  #shipdate, #sodate, .sales, .socategory { padding-right: 4px; padding-left: 4px; }
  .input-group { padding-left: 15px !important; padding-right: 15px !important; }
  .content-wrapper input, .content-wrapper textarea, .content-wrapper select { padding-top: 5px !important; padding-bottom: 5px !important; }
  .sototal, .sototalbefore { font-size: 20px; }
  .box-sototal .vcenter { padding-left: 0px !important; padding-right: 0px !important; }
  .checkPrice { display: none; }

  .table-price {
    font-size: 12px;
    font-weight: bold;
    margin-top: 10px;
    border: 0px solid ;
  }
  .table-price tr td { padding: 2px 5px !important; }
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

    <div class="modal fade" id="modal-cell">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <table>
            	<tr class="cellproduct" dataproduct="">
                <td>
                  <input class="ProductID" name="ProductID[]" type="hidden" readonly="" required="">
                  <input class="ProductName" name="ProductName[]" type="hidden" readonly="" required="">
                  <div class="ProductName2"></div>
                </td>
                <td>
                  <input class="form-control input-sm ProductQty" name="ProductQty[]" type="number" minlength="1" min="1" required="">
                </td>
                <td>
                  <input class="totaldo" name="totaldo[]" type="hidden">
                  <div class="totaldo2"></div>
                </td>
                <td>
                  <input class="ProductPriceDefault" name="ProductPriceDefault[]" type="hidden" readonly="" required="">
                  <input class="ProductHPP" name="ProductHPP[]" type="hidden" readonly="" required="">
                  <input class="ProductMultiplier" name="ProductMultiplier[]" type="hidden" readonly="" required="">
                  <div class="ProductPriceDefault2"></div>
                </td>
                <td>
                  <input class="PricelistName" name="PricelistName[]" type="hidden" readonly="" required="">
                  <input class="PricelistID" name="PricelistID[]" type="hidden" readonly="" required="">
                  <input class="form-control input-sm PT1Percent" name="PT1Percent[]" type="hidden" minlength="1" min="0" step=".01" required="">
                  <input class="form-control input-sm PricePercent" name="PricePercent[]" type="number" minlength="1" step=".01" required="">
                </td>
                <td>
                  <input class="form-control input-sm PT2Percent" name="PT2Percent[]" type="number" minlength="1" min="0" readonly="" required="">
                </td>
                <td>
                  <input class="PT1Price" name="PT1Price[]" type="hidden" readonly="" required="">
                  <input class="PT2Price" name="PT2Price[]" type="hidden" readonly="" required="">
                  <input class="form-control input-sm PriceAmount mask-number" name="PriceAmount[]" type="text" minlength="1" required="" step="1">
                </td>
                <td>
                  <input class="ProductWeight" name="ProductWeight[]" type="hidden" readonly="" required="">
                  <div class="ProductWeight2"></div>
                </td>
                <td>
                  <input class="form-control input-sm FreightCharge mask-number" name="FreightCharge[]" type="text" required="">
                </td>
                <td><input class="form-control input-sm linetotal mask-number" name="linetotal[]" type="text" required="" readonly=""></td>
                <td>
                  <button type="button" class="btn btn-danger btn-xs remove"><i class="fa fa-remove"></i></button>
                  <button type="button" class="btn btn-primary btn-xs checkPrice" title="check promo"><i class="fa fa-check-square-o"></i></button>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="box box-solid">
      <div class="box-body">
          <form name="form" id="form" action="<?php echo base_url();?>transaction/sales_order_edit_act" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="col-md-6">
            	<div class="box box-solid">
  		            <div class="box-header with-border">
  		              <h3 class="box-title">CUSTOMER DETAIL</h3>
  		            </div>
  		            <div class="box-body">
  		              <div class="form-group col-md-12 vcenter">
                      <div class="col-md-3"><label>Customer</label></div>
                      <div class="input-group col-md-9 maincustomer">
                        <input type="hidden" class="soid" name="soid" required="" readonly="">
                        <input type="hidden" class="CustomerID" name="CustomerID" required="" readonly="">
                        <input type="text" class="form-control input-sm customer" name="customer" required="" readonly="">
                      </div>
                    </div>
                    <div class="form-group col-md-12 vcenter">
                      <div class="col-md-3"><label>Shipping</label></div>
                      <div class="col-md-9 maincustomer">
                        <select class="form-control address input-sm" name="address" required=""></select>
                        <input type="hidden" class="billing" name="billing" required="">
                        <input type="hidden" class="shipping" name="shipping" required="">
                      </div>
                    </div>
                    <div class="form-group col-md-12 vcenter">
                      <div class="col-md-3"><label>Credit Limit</label></div>
                      <div class="col-md-3"><input type="hidden" name="creditlimit" class="creditlimit" required=""><div class="creditlimit2">...</div></div>
                      <div class="col-md-3"><label>Payment Term</label></div>
                      <div class="col-md-3">
                        <input type="hidden" name="npwp" class="npwp" required="">
                        <input type="hidden" name="paymentterm" class="paymentterm" required="">
                        <div class="paymentterm2">...</div>
                      </div>
                    </div>
                    <div class="form-group col-md-12 vcenter">
                      <div class="col-md-3"><label>Credit Available</label></div>
                      <div class="col-md-3"><input type="hidden" name="creditavailable" class="creditavailable" required=""><div class="creditavailable2">...</div></div>
                      <div class="col-md-3"><label>SEC</label></div>
                      <div class="col-md-3">
                        <input type="hidden" name="regionid" class="regionid" required="">
                        <input type="hidden" name="secid" class="secid" required="">
                        <div class="sec">...</div>
                      </div>
                    </div>
                    <div class="col-md-12" style="overflow-x:auto; max-height: 100px;">
                      <table class="table table-responsive table-price">
                        <tbody></tbody>
                      </table>
                    </div>
  		              <div class="form-group col-md-12">
                      <div class="col-md-4"><label>Billing To</label></div>
                      <div class="col-md-8 billingto">...</div>
                    </div>
                    <div class="form-group col-md-12">
                      <div class="col-md-4"><label>Shipping To</label></div>
                      <div class="col-md-8 shippingto">...</div>
                    </div>
  		            </div>
  		        </div>
            </div>
            <div class="col-md-6">
              <div class="box box-normal box-solid detailso">
                  <div class="box-header with-border">
                    <h3 class="box-title">SO DETAIL</h3>
                  </div>
                  <div class="box-body">
                    <div class="form-group col-md-12 vcenter">
                      <div class="col-md-3"><label>Sales</label></div>
                      <div class="form-group col-md-9"><select class="form-control input-sm sales" name="sales" required=""></select></div>
                    </div>
                    <div class="form-group col-md-12 vcenter">
                      <div class="col-md-3"><label>SO Category</label></div>
                      <div class="form-group col-md-9">
                        <select class="form-control input-sm socategory" name="socategory" required="">
                          <option value="1">Sales</option>
                          <option value="2">Consignment</option>
                          <option value="3">Replacement</option>
                          <option value="4">Display</option>
                          <option value="5">Bonus</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group col-md-12 vcenter">
                      <div class="col-md-3"><label>SO Date</label></div>
                      <div class="form-group col-md-3">
                          <input type="text" class="form-control input-sm pull-right" id="sodate" name="sodate" autocomplete="off" required="" >
                      </div>
                      <div class="col-md-3"><label>Ship Date</label></div>
                      <div class="form-group col-md-3">
                          <input type="text" class="form-control input-sm pull-right" id="shipdate" name="shipdate" autocomplete="off" required="" >
                      </div>
                    </div>
                    <div class="form-group col-md-12 vcenter">
                      <div class="col-md-3"><label>Payment Method</label></div>
                      <div class="form-group col-md-3">
                        <select class="form-control input-sm paymentmethod" name="paymentmethod" required="">
                          <option value="CBD">CBD</option>
                          <option value="TOP">TOP</option>
                        </select>
                      </div>
                      <div class="col-md-3"><label>Payment Term Day</label></div>
                      <div class="form-group col-md-3"><input type="number" minlength="1" class="form-control sopaymentterm input-sm" name="sopaymentterm" required="" min="0"></div>
                    </div>
                    <div class="form-group col-md-12 vcenter">
                      <div class="col-md-3"><label>INV Category</label></div>
                      <div class="form-group col-md-9">
                        <select class="form-control input-sm invcategory" name="invcategory" required="">
                          <option value="1">Normal, DO to INV</option>
                          <option value="2">Percent, SO to INV</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group col-md-12 vcenter">
                      <div class="col-md-3"><label>Expedition</label></div>
                      <div class="form-group col-md-9">
                        <input type="hidden" name="expeditionid" class="expeditionid" required="">
                        <input type="hidden" name="expeditionprice" class="expeditionprice" required="" min="0" value="0">
                        <input type="hidden" name="expeditionweight" class="expeditionweight" required="" min="0" value="0">
                        <input type="text" class="form-control input-sm expedition" name="expedition" required="" readonly="">
                      </div>
                    </div>
                    <div class="form-group col-md-12 vcenter">
                      <div class="col-md-3"><label>SO Term</label></div>
                      <div class="form-group col-md-9"><textarea class="form-control input-sm term" name="term" autocomplete="off"></textarea></div>
                    </div>
                    <div class="form-group col-md-12 vcenter">
                      <div class="col-md-3"><label>SO Note</label></div>
                      <div class="form-group col-md-9"><textarea class="form-control input-sm note" name="note" autocomplete="off"></textarea></div>
                    </div>
                    <div class="form-group col-md-12 div_open_product">
                      <div class="input-group">
                        <div class="input-group-btn">
                          <button type="button" class="btn btn-primary" id="open_popup_product">TAMBAH</button>
                        </div>
                        <input type="text" class="form-control" readonly value="Search Product">
                      </div>
                    </div>
                    
                  </div>
              </div>
            </div>
            <div class="col-md-12" style="overflow-x:auto;">
              <table class="table table-bordered table-main table-responsive">
                <thead>
                  <tr>
                    <th>Product Code</th>
                    <th>Quantity</th>
                    <th>DO</th>
                    <th>Price Default</th>
                    <th>Promo</th>
                    <th>PT Disc</th>
                    <th>Price Promo</th>
                    <th>Weight</th>
                    <th>FC</th>
                    <th>Total</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
            <div class="col-md-12">
              <div class="box box-solid box-info box-sototal">
                <div class="box-header">
                  <h3 class="box-title">SO Total</h3>
                </div>
                <div class="box-body">
                  <div class="col-md-6">
                    <div class="box box-solid detailso">
                        <div class="box-body">
                          <div class="form-group col-md-12 vcenter">
                            <div class="col-md-3"><label>Freight Charge</label></div>
                            <div class="form-group col-md-3">
                              <select class="form-control input-sm fcmethod" name="fcmethod" required="">
                                <option value="INCLUDE">INCLUDE</option>
                                <option value="EXCLUDE">EXCLUDE</option>
                              </select>
                            </div>
                            <div class="col-md-3"><label>FC Suggestion</label></div>
                            <div class="form-group col-md-3"><input type="text" minlength="1" class="form-control input-sm fcsuggestion mask-number" name="fcsuggestion" readonly="" required="" min="0"></div>
                          </div>
                          <div class="form-group col-md-12 vcenter">
                            <div class="col-md-3"><label>FC Amount</label></div>
                            <div class="form-group col-md-9"><input type="text" minlength="1" class="form-control input-sm fcamount mask-number" name="fcamount" required="" min="0"></div>
                          </div>
                          <div class="form-group col-md-12 vcenter">
                            <div class="col-md-3"><label>Permit Note</label></div>
                            <div class="form-group col-md-9"><textarea class="form-control input-sm permit" name="permit" autocomplete="off"></textarea></div>
                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="box box-solid detailso">
                        <div class="box-body">
                          <div class="form-group col-md-12 vcenter">
                            <div class="col-md-3"><label>Total Before Tax</label></div>
                            <div class="form-group col-md-9">
                              <input type="text" minlength="1" class="form-control input-sm sototalbefore mask-number" name="sototalbefore" required="" min="0" readonly="">
                            </div>
                          </div>
                          <div class="form-group col-md-12 vcenter">
                            <div class="col-md-3"><label>Tax Rate</label></div>
                            <div class="form-group col-md-3"><input type="number" minlength="1" class="form-control input-sm taxrate" name="taxrate" readonly="" required="" min="0" value="10"></div>
                            <div class="col-md-3"><label>Tax Amount</label></div>
                            <div class="form-group col-md-3"><input type="text" minlength="1" class="form-control input-sm taxamount mask-number" name="taxamount" readonly="" required="" min="0" minlength="1" step=".01"></div>
                          </div>
                          <div class="form-group col-md-12 vcenter">
                            <div class="col-md-3"><label>Total Sales Order</label></div>
                            <div class="form-group col-md-9">
                              <input type="text" minlength="1" class="form-control input-sm sototal mask-number" name="sototal" required="" min="0" readonly="">
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box-footer" style="text-align: center;">
                <button type="button" class="btn btn-success btn-count" onclick="countsototal();">Count Total</button>
                <button type="submit" class="btn btn-primary btn-submit" >Submit</button>
              </div>
            </div>
          </form>
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/jquery.inputmask.bundle.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
product   = []
pricename = []
pricecategory = []
pricelist = []
promovol  = []
curlist   = []

so_main   = [];
so_detail = [];
address   = [];
so_sales  = [];

j8 = jQuery.noConflict();
j8( document ).ready(function( $ ) {
	 

  totaldo   = 0
  so_main   = $.parseJSON('<?php if ( isset($content['so2'])){ echo $content['so2']; }?>');
  so_detail = $.parseJSON('<?php if ( isset($content['detail2'])){ echo $content['detail2']; }?>');
  address   = $.parseJSON('<?php if ( isset($content['shipping2'])){ echo $content['shipping2']; }?>');
  so_sales  = $.parseJSON('<?php if ( isset($content['sales2'])){ echo $content['sales2']; }?>');
  pricename = $.parseJSON('<?php if ( isset($content['pricename2'])){ echo $content['pricename2']; }?>');
  pricecategory = $.parseJSON('<?php if ( isset($content['pricecategory2'])){ echo $content['pricecategory2']; }?>');
  // console.log(pricecategory)
  pricelist = $.parseJSON('<?php if ( isset($content['pricelist2'])){ echo $content['pricelist2']; }?>');
  promovol  = $.parseJSON('<?php if ( isset($content['promovolume2'])){ echo $content['promovolume2']; }?>');
  fillmain()
  fillproduct2()

  CustomerID      = j8('.CustomerID').val()
  CustomerName    = j8('.customer').val()
  paymentmethod   = j8('.paymentmethod').val()
  expeditionprice = parseFloat( j8('.expeditionprice').val() )

  j8(".mask-number").inputmask({ 
      alias:"currency", 
      prefix:'', 
      autoUnmask:true, 
      removeMaskOnSubmit:true, 
      showMaskOnHover: true 
  });
})

j8('.address').change(function () {
  optionSelected = j8(this).find("option:selected");
  addressid      = optionSelected.val();
  valueSelected  = address[addressid]["DetailValue"]
  textSelected   = optionSelected.text();
  j8(".shipping").val( CustomerName +";"+ textSelected +";"+ valueSelected)
  j8(".shippingto").html(textSelected+"<br/>"+valueSelected)
  j8(".expeditionid").val(address[addressid]["ExpeditionID"])
  j8(".expedition").val("Rp "+address[addressid]["FCPrice"]+" / "+address[addressid]["FCWeight"]+"KG")
  j8(".expeditionprice").val(address[addressid]["FCPrice"])
  j8(".expeditionweight").val(address[addressid]["FCWeight"])
  if (curlist.length > 0) {
    countall()
  }
});
j8('.paymentmethod').change(function () {
  optionSelected = j8(this).find("option:selected").val();
    if (typeof totaldo !== 'undefined' && totaldo>0) {
      return false;
    }
    if (optionSelected == "CBD") {
      j8('.sopaymentterm').attr("readonly", true).val("0").attr("min",0)
      j8('.PT2Percent').css("display", "block")
      j8('.PricePercent').val( 0 )
    } else {
      j8('.sopaymentterm').attr("readonly", false).val("1").attr("min",1)
      j8('.PT2Percent').css("display", "none")
      updatePromo()
    }
  buildcurlist()
  if (curlist.length > 0) {
    countall()
  }
});

function fillmain() {
  billingDetail = so_main['BillingAddress'].split(";")
  shipDetail    = so_main['ShipAddress'].split(";")
  j8(".soid").val(so_main['SOID'])
  j8(".CustomerID").val(so_main['CustomerID'])
  j8(".customer").val(billingDetail[0])
  j8(".billing").val(so_main['BillingAddress'])
  j8(".billingto").html(billingDetail[1]+"<br/>"+billingDetail[2])
        
  // console.log(address)
  len = address.length;
  for( i = 0; i<len; i++){
      addressid   = address[i]['addressid'];
      DetailType  = address[i]['DetailType'];
      DetailValue = address[i]['DetailValue'];
      j8(".address").append("<option value='"+addressid+"' addressid='"+addressid+"'>"+DetailType+"</option>");
  }
  j8(".shipping").val(so_main['ShipAddress'])
  j8(".shippingto").html(shipDetail[1]+"<br/>"+shipDetail[2])
  j8(".expeditionid").val(address[ j8(".address option:first").val() ]["ExpeditionID"])
  j8(".expedition").val("Rp "+address[ j8(".address option:first").val() ]["FCPrice"] +" / "+ address[ j8(".address option:first").val() ]["FCWeight"]+"KG")
  j8(".expeditionprice").val(address[ j8(".address option:first").val() ]["FCPrice"])
  j8(".expeditionweight").val(address[ j8(".address option:first").val() ]["FCWeight"])

  j8(".secid").val(so_main['SECID'])
  j8(".sec").html(so_main['secname'])
  j8(".regionid").val(so_main['RegionID'])

  j8(".npwp").val(so_main['NPWP'])
  j8(".paymentterm").val(so_main['PaymentTerm2'])
  j8(".paymentterm2").html(so_main['PaymentTerm2'])
  j8(".creditlimit").val(so_main['CreditLimit'])
  j8(".creditlimit2").html(Number(so_main['CreditLimit']).toLocaleString('en'))
  j8(".creditavailable").val(so_main['creditavailable'])
  j8(".creditavailable2").html(Number(so_main['creditavailable']).toLocaleString('en'))

  j8(".paymentmethod").val(so_main['PaymentWay'])
  j8(".sopaymentterm").val(so_main['PaymentTerm'])
  j8(".invcategory").val(so_main['INVCategory'])
  optionSelected = j8(".paymentmethod").find("option:selected").val();
  if (optionSelected == "CBD") {
    j8('.sopaymentterm').attr("readonly", true)
    j8('.PT2Percent').css("display", "block")
  } else {
    j8('.sopaymentterm').attr("readonly", false)
    j8('.PT2Percent').css("display", "none")
  }

  len = so_sales.length;
  for( i = 0; i<len; i++){
      SalesName = so_sales[i]['SalesName'];
      SalesID = so_sales[i]['SalesID'];
      j8(".sales").append("<option value='"+SalesID+"'>"+SalesName+"</option>");
  }

  var len = pricename.length;
  for( var i = 0; i<len; i++){
      j8(".table-price tbody").append("<tr><td>"+pricename[i]['Type']+"</td><td>("+pricename[i]['PricecategoryID']+") "+pricename[i]['PricecategoryName']+"</td></tr>");
  }

  if (so_main['FreightCharge'] !== "0.00") {
    j8(".fcmethod").val("EXCLUDE")
    j8('.FreightCharge').css("display", "none")
  } else {
    j8(".fcmethod").val("INCLUDE")
    j8('.fcamount').val("0").attr("readonly", true)
    j8('.fcsuggestion').val("0")
    j8('.FreightCharge').css("display", "block")
  }
  j8(".fcamount").val(so_main['FreightCharge'])
  j8(".permit").val(so_main['PermitNote'])
  j8(".sototalbefore").val(so_main['SOTotalBefore'])
  j8(".taxrate").val(so_main['TaxRate'])
  j8(".taxamount").val(so_main['TaxAmount'])
  j8(".sototal").val(so_main['SOTotal'])

  j8(".socategory").val(so_main['SOCategory']).attr("disabled", true)
  j8("#shipdate").val(so_main['SOShipDate']).attr("readonly", true)
  j8("#sodate").val(so_main['SODate']).attr("readonly", true)
  j8(".term").val(so_main['SOTerm'])
  j8(".note").val(so_main['SONote'])
  totaldo = so_main['totaldo']
  if (totaldo > 0) {
    j8(".address").attr("disabled", true)
    j8(".sales").attr("onchange", "this.value = this.getAttribute('data-value');").attr("onfocus", "this.setAttribute('data-value', this.value);")
    j8(".paymentmethod").attr("onchange", "this.value = this.getAttribute('data-value');").attr("onfocus", "this.setAttribute('data-value', this.value);")
    j8(".sopaymentterm").attr("onchange", "this.value = this.getAttribute('data-value');").attr("onfocus", "this.setAttribute('data-value', this.value);")
    j8(".invcategory").attr("onchange", "this.value = this.getAttribute('data-value');").attr("onfocus", "this.setAttribute('data-value', this.value);")
    // j8(".sales").attr("disabled", true)
    // j8(".paymentmethod").attr("disabled", true)
    j8(".term").attr("readonly", true)
    j8(".note").attr("readonly", true)
    j8(".div_open_product").remove()
    j8(".fcmethod").attr("disabled", true)
  }
  j8('.btn-count').css("display","none")
  j8('.btn-submit').css("display","inline-block")
}
function fillproduct2() { //from edit
  len = so_detail.length;
  for( i = 0; i<len; i++){
    // console.log(so_detail[i]['ProductName'])
    j8(".cellproduct:first .ProductID").val(so_detail[i]['ProductID']);
    j8(".cellproduct:first .ProductName").val(so_detail[i]['ProductName']);
    j8(".cellproduct:first .ProductName2").html(so_detail[i]['ProductID']+" : "+so_detail[i]['ProductName']);
    j8(".cellproduct:first .ProductQty").val(so_detail[i]['ProductQty']);
    j8(".cellproduct:first .totaldo").val(so_detail[i]['totaldo']);
    j8(".cellproduct:first .totaldo2").text(so_detail[i]['totaldo']);
    j8(".cellproduct:first .ProductHPP").val(so_detail[i]['ProductHPP']);
    j8(".cellproduct:first .ProductMultiplier").val(so_detail[i]['ProductMultiplier']);
    j8(".cellproduct:first .ProductPriceDefault").val(so_detail[i]['ProductPriceDefault']);
    j8(".cellproduct:first .ProductPriceDefault2").text(so_detail[i]['ProductPriceDefault']);
    j8(".cellproduct:first .PricelistID").val(so_detail[i]['PriceID']);
    j8(".cellproduct:first .PricelistName").val(so_detail[i]['PriceName']);
    j8(".cellproduct:first .PricePercent").val(so_detail[i]['PricePercent']);
    j8(".cellproduct:first .PT1Percent").val(so_detail[i]['PT1Percent']);
    j8(".cellproduct:first .PT2Percent").val(so_detail[i]['PT2Percent']);
    j8(".cellproduct:first .PT1Price").val(so_detail[i]['PT1Price']);
    j8(".cellproduct:first .PT2Price").val(so_detail[i]['PT2Price']);
    j8(".cellproduct:first .PriceAmount").val(so_detail[i]['PriceAmount']);
    j8(".cellproduct:first .ProductWeight").val(so_detail[i]['ProductWeight']);
    j8(".cellproduct:first .ProductWeight2").text(so_detail[i]['ProductWeight']);
    j8(".cellproduct:first .ProductWeight2").text(so_detail[i]['ProductWeight']);
    j8(".cellproduct:first .FreightCharge").val(so_detail[i]['FreightCharge']);
    j8(".cellproduct:first .linetotal").val(so_detail[i]['PriceTotal']);

    if (so_detail[i]['totaldo'] > 0) {
      // j8(".cellproduct:first .remove").css("display", "none");
      // j8(".cellproduct:first .PricePercent").attr("readonly", true);
      // j8(".cellproduct:first .PriceAmount").attr("readonly", true);
      // j8(".cellproduct:first .FreightCharge").attr("readonly", true);
    }
    if (totaldo > 0) {
      j8(".cellproduct:first .PricePercent").attr("readonly", true);
      j8(".cellproduct:first .PriceAmount").attr("readonly", true);
      j8(".cellproduct:first .FreightCharge").attr("readonly", true);
      j8(".cellproduct:first .remove").css("display", "none");
      j8(".cellproduct:first .ProductQty").attr("max",so_detail[i]['ProductQty']);
      j8(".cellproduct:first .ProductQty").attr("min",so_detail[i]['totaldo']);
    }
    
    j8(".cellproduct:first").attr('dataproduct',so_detail[i]['ProductID']);
    j8(".cellproduct:first").clone().appendTo('.table-main>tbody');
    j8(".cellproduct:first input").val("");
    j8(".cellproduct:first .PricePercent").attr("readonly", false);
    j8(".cellproduct:first .PriceAmount").attr("readonly", false);
    j8(".cellproduct:first .FreightCharge").attr("readonly", false);
    j8(".cellproduct:first .ProductName2").text("");
    j8(".cellproduct:first .ProductPriceDefault2").text("");
    j8(".cellproduct:first .checkPrice").css("display", "none")
  }
  j8(".mask-number").inputmask({ 
      alias:"currency", 
      prefix:'', 
      autoUnmask:true, 
      removeMaskOnSubmit:true, 
      showMaskOnHover: true 
  });
}

function fillproduct(response) {
  paymentmethod = j8('.paymentmethod').val()
  if (j8.inArray(response['ProductID'], curlist) < 0) {  //cek jika product exist in list
    j8(".cellproduct:first .ProductID").val(response['ProductID']);
    j8(".cellproduct:first .ProductName").val(response['ProductName']);
    j8(".cellproduct:first .ProductName2").text(response['ProductID']+" : "+response['ProductName']);
    j8(".cellproduct:first .ProductQty").val("1");
    j8(".cellproduct:first .totaldo").val("0");
    j8(".cellproduct:first .totaldo2").text("0");
    j8(".cellproduct:first .ProductPriceDefault").val(response['ProductPriceDefault']);
    j8(".cellproduct:first .ProductPriceDefault2").text(response['ProductPriceDefault']);
    j8(".cellproduct:first .PricelistID").val(response['PricelistID']);
    j8(".cellproduct:first .PricelistName").val(response['PricelistName']);
    if (paymentmethod == "CBD") {
      j8(".cellproduct:first .PricePercent").val(response['PT2Percent']);
    } else {
      j8(".cellproduct:first .PricePercent").val(response['PT1Percent']);
    }

    j8(".cellproduct:first .PT1Percent").val(response['PT1Percent']);
    j8(".cellproduct:first .PT2Percent").val(response['PT2Percent']);
    j8(".cellproduct:first .PT1Price").val(response['PT1Price']);
    j8(".cellproduct:first .PT2Price").val(response['PT2Price']);
    j8(".cellproduct:first .PriceAmount").val(response['PriceAmount']);
    j8(".cellproduct:first .ProductWeight").val(response['ProductWeight']);
    j8(".cellproduct:first .ProductWeight2").text(response['ProductWeight']);
    
    j8(".cellproduct:first").attr('dataproduct',response['ProductID']);
    j8(".cellproduct:first").clone().appendTo('.table-main>tbody');
    j8(".cellproduct:first input").val("");
    j8(".cellproduct:first .ProductName2").text("");
    j8(".cellproduct:first .ProductPriceDefault2").text("");
    j8(".cellproduct:first .checkPrice").css("display", "none")
    countline( j8(".cellproduct:last .ProductQty") )

    j8(".mask-number").inputmask({ 
        alias:"currency", 
        prefix:'', 
        autoUnmask:true, 
        removeMaskOnSubmit:true, 
        showMaskOnHover: true 
    });
  }
}
function countall() {
  j8('.table-main .ProductQty').each(function(){
    countline(j8(this))
  });
}
function countline(el) {
  paymentmethod = j8('.paymentmethod').val()
  par   = el.parent().parent();
  price = parseFloat( par.find('.ProductPriceDefault').val() );
  percent = parseFloat( par.find('.PricePercent').val() );
  pt    = parseFloat( par.find('.PT2Percent').val() );
  final = price
  if (paymentmethod == "TOP") {
    final = final - percentage( price, percent )
  }
  if (paymentmethod == "CBD") {
    final = final - percentage(final, pt)
  }
  par.find('.PriceAmount').val(final)
  countfreight(el)
}
function countfreight(el) {
  expeditionprice = parseFloat(j8('.expeditionprice').val())
  par   = el.parent().parent();
  qty   = parseFloat( par.find('.ProductQty').val() );
  weight= parseFloat( par.find('.ProductWeight').val() );
  fc    = qty * weight * expeditionprice 
  par.find('.FreightCharge').val( fc )
  countlinetotal(el)
}
function countlinetotal(el) {
  par   = el.parent().parent();
  qty   = parseFloat( par.find('.ProductQty').val() );
  final = parseFloat( par.find('.PriceAmount').val() );
  FreightCharge = parseFloat( par.find('.FreightCharge').val() );
  
  fcmethod = j8('.fcmethod').find("option:selected").val();
  if (fcmethod == "INCLUDE") {
    linetotal =(final*qty)+FreightCharge
  } else {
    linetotal =(final*qty)
  }
  par.find('.linetotal').val(linetotal)

  resetsototal()
}
function countsototal() {
  j8('.btn-count').css("display","none")
  j8('.btn-submit').css("display","inline-block")
  total = 0
  buildcurlist()
  if (curlist.length > 0) {
    j8('.table-main .linetotal').each(function(){
      total += parseFloat( j8(this).val() );
    })
  }  
  fc      = parseFloat( j8('.fcamount').val() )
  taxrate = parseFloat( j8('.taxrate').val() )
  totalbefore = total
  taxamount   = percentage(totalbefore, taxrate)
  sototal     = totalbefore + taxamount + fc

  j8('.sototalbefore').val(totalbefore)
  j8('.taxamount').val( Math.ceil(taxamount) )
  j8('.sototal').val( Math.ceil(sototal) )
}
function resetsototal() {
  j8('.btn-count').css("display","inline-block")
  j8('.btn-submit').css("display","none")
  j8('.FreightCharge').css("display", "block")
  // j8('.term').val("FreightCharge include")
  if (totaldo == 0) {
    j8('.fcmethod').val("INCLUDE")
    j8('.fcsuggestion').val("0")
    j8('.fcamount').val("0").attr("readonly", true)
  }
  j8('.sototalbefore').val("0")
  j8('.taxamount').val("0")
  j8('.sototal').val("0")
}
function percentage(num, per) {
  return (num/100)*per;
}
function buildcurlist() {
  par = j8(".table-main .ProductID")
  curlist = []
  for (var i = 0; i < par.length; i++) {
    curlist.push(j8(par[i]).val())
  }
}
function updatePromo() {
    j8('.table-main .PricePercent').each(function(){
      par = j8(this).parent()
      PT1Percent = par.find('.PT1Percent').val()
      j8(this).val( PT1Percent )
    })
}
var popup;
function openPopupOneAtATime() {
    if (popup && !popup.closed) {
       popup.focus();
    } else {
       popup = window.open('<?php echo base_url();?>transaction/product_list_popup_so', '_blank', 'width=700,height=500,left=200,top=100');     
    }
}
function ProcessChildMessage(message) {
  paymentmethod = j8(".paymentmethod").val()
  if (message['forsale']==1) {
    j8.ajax({
      url: "<?php echo base_url();?>transaction/get_product_price",
      type : 'POST',
      data: {message:message, pricecategory:pricecategory, pricelist:pricelist, paymentmethod:paymentmethod },
      dataType : 'json',
      success : function (response) {
        buildcurlist()
        fillproduct(response)
      }
    })
  } else {
    alert("product is not fro Sale!")
  }
}
j8("#open_popup_product").on('click', function() {
  j8(".cellproduct:first input").val("");
  openPopupOneAtATime();
});
j8(".remove").live('click', function() {
  par = j8(this).closest("tr").remove();
  buildcurlist()
  resetsototal()
});
j8(".checkPrice").live('click', function() {
  j8(this).css("display", "none")
  par = j8(this).parent().parent()
  ProductID   = par.find(".ProductID").val()
  ProductQty  = par.find(".ProductQty").val()
  ProductPriceDefault  = par.find(".ProductPriceDefault").val()
  paymentmethod  = j8(".paymentmethod").val()
  j8.ajax({
    url: "<?php echo base_url();?>transaction/get_product_promo",
    type : 'POST',
    data: { ProductID:ProductID, 
            ProductQty:ProductQty, 
            pricelist:pricelist, 
            pricecategory:pricecategory, 
            promovol:promovol,  
            ProductPriceDefault:ProductPriceDefault,
            paymentmethod: paymentmethod
          },
    dataType : 'json',
    success : function (response) {
      par.find(".PricelistID").val(response['PriceID'])
      par.find(".PricelistName").val(response['PriceName'])
      
      par.find(".ProductPriceDefault").val(response['ProductPriceDefault'])
      par.find(".ProductPriceDefault2").text(response['ProductPriceDefault'])
      paymentmethod = j8('.paymentmethod').val()
      if (paymentmethod == "TOP") {
        par.find(".PricePercent").val(response['PT1Percent'])
      }
      if (paymentmethod == "CBD") {
        par.find(".PricePercent").val(response['PT2Percent'])
      }
      par.find(".PT1Percent").val(response['PT1Percent'])
      par.find(".PT2Percent").val(response['PT2Percent'])
      par.find(".PT1Price").val(response['PT1Price'])
      par.find(".PT2Price").val(response['PT2Price'])
      par.find(".PriceAmount").val(response['PriceAmount'])
      countline( par.find(".checkPrice") )
    }
  })
});

j8('.ProductQty').live( "change", function() {
  par = j8(this).parent().parent();
  // console.log(totaldo)
  if (totaldo>0) {
    countline_do(j8(this))
  } else {
    par.find('.checkPrice').css("display", "inline-block")
    par.find('.PricelistID').val("")
    par.find('.PricelistName').val("")
    par.find('.PT1Percent').val("0")
    par.find('.PT1Price').val("0")
    par.find('.PT2Percent').val("0")
    par.find('.PT2Price').val("0")
    par.find('.PricePercent').val("0")
    countline(j8(this))
  }
});
j8('.PricePercent').live( "change", function() {
  countline(j8(this))
});
j8('.PriceAmount').live( "change", function() {
  par   = j8(this).parent().parent();
  final = parseFloat( j8(this).val() );
  price = parseFloat( par.find('.ProductPriceDefault').val() );
  percent = parseFloat( par.find('.PricePercent').val() );
  pt    = parseFloat( par.find('.PT2Percent').val() );
  PriceBefore = final

  if (paymentmethod == "CBD") {
    PriceBefore = (PriceBefore + ((PriceBefore/(100-pt)) * pt) )
  }
  percent = 100 - ( PriceBefore / (price/100) )
  par.find('.PricePercent').val(percent.toFixed(2))

  countlinetotal(j8(this))
});
j8('.FreightCharge').live( "change", function() {
  countlinetotal(j8(this))
});

j8('.fcamount').live( "change", function() {
  countsototal()
});
j8('.fcmethod').change(function () {
  optionSelected = j8(this).find("option:selected").val();
  if (optionSelected == "INCLUDE") {
    // j8('.term').val("FreightCharge include")
    j8('.fcsuggestion').val("0")
    j8('.fcamount').val("0").attr("readonly", true)
    j8('.FreightCharge').css("display", "block")
    if (curlist.length > 0) {
      j8('.table-main .ProductWeight').each(function(){
        countlinetotal2(j8(this))
      })
    }
  } else {
    j8('.term').val("")
    totalweight = 0
    expeditionprice   = parseFloat(j8('.expeditionprice').val())
    expeditionweight  = parseFloat(j8('.expeditionweight').val())
    if (curlist.length > 0) {
      j8('.table-main .ProductWeight').each(function(){
        countlinetotal2(j8(this))
        par = j8(this).parent().parent();
        qty     = parseInt( par.find('.ProductQty').val() );
        weight  = parseInt( par.find('.ProductWeight').val() )
        totalweight = totalweight + (qty*weight)
      })
    }
    if (totalweight < expeditionweight) { 
      totalweight = expeditionweight
    }
    fcexclude = totalweight*expeditionprice
    j8('.fcsuggestion').val( fcexclude )
    j8('.fcamount').val("0").attr("readonly", false)
    j8('.FreightCharge').css("display", "none")
  }
  countsototal()
});
function countlinetotal2(el) {
  par   = el.parent().parent();
  qty   = parseFloat( par.find('.ProductQty').val() );
  final = parseFloat( par.find('.PriceAmount').val() );
  FreightCharge = parseFloat( par.find('.FreightCharge').val() );
  
  fcmethod = j8('.fcmethod').find("option:selected").val();
  if (fcmethod == "INCLUDE") {
    linetotal =(final*qty)+FreightCharge
  } else {
    linetotal =(final*qty)
  }
  par.find('.linetotal').val(linetotal)
}

j8(document).on("keypress", "form", function(event) { 
    return event.keyCode != 13;
});
j8("#form").submit(function(e) {
  if (j8('.table-main .ProductID').length < 1) {
    e.preventDefault();
    alert("List Produk Kosong!")
    return false
  }

  no = 0
  errorcount  = 0
  errornote   = ""
  paymentmethod = j8(".paymentmethod").val()
  fcmethod = j8(".fcmethod").val()
  fcamount = parseFloat(j8(".fcamount").val())
  sopaymentterm = parseFloat(j8(".sopaymentterm").val())
  paymentterm = parseFloat(j8(".paymentterm").val())
  creditlimit = parseFloat(j8(".creditlimit").val())
  creditavailable = parseFloat(j8(".creditavailable").val())
  sototal     = parseFloat(j8(".sototal").val())
  invcategory = j8(".invcategory").val()
  // console.log(paymentmethod)

  if (invcategory != 1) {
      errorcount += 1
      errornote += "-SO Pembayaran by Persentase \n"
  }
  if (paymentmethod == "TOP") {
    if (sopaymentterm > paymentterm) {
      errorcount += 1
      errornote += "-PaymentTerm Melibihi ketentuan \n"
    }
    if (sototal > creditavailable) {
      // console.log(creditavailable)
      errorcount += 1
      errornote += "-SO Total Melibihi ketentuan \n"
    }
  }

  j8('.table-main .ProductQty').each(function(){
    no += 1
    par = j8(this).parent().parent();
    PricelistID  = par.find('.PricelistID').val();
    PT1Price  = parseFloat(par.find('.PT1Price').val());
    PT2Price     = parseFloat(par.find('.PT2Price').val());
    PriceAmount = parseFloat(par.find('.PriceAmount').val());
    if (paymentmethod == "TOP") {
      if (PriceAmount != PT1Price) {
        errorcount += 1
        errornote += "-Product no:"+no+" tidak sesuai dari ketentuan \n"
      }
    } else {
      if (PriceAmount != PT2Price) {
        errorcount += 1
        errornote += "-Product no:"+no+" tidak sesuai dari ketentuan \n"
      }
    }

    if (PricelistID == "") {
      e.preventDefault();
      alert("Promo Product belum di cek.")
      return false
    }
  });

  if (j8('.sototal').val() == 0) {
    e.preventDefault();
    alert("SO Total Belum dihitung.")
    return false
  }
  if (fcmethod == "EXCLUDE") {
    if (fcamount == 0) {
      e.preventDefault();
      alert("FC Exclude tidak boleh 0.")
      return false
    }
  }

  if (errorcount > 0) {
    errornote += "SO ini akan membutuhkan approval!\n"
    var r = confirm(errornote);
    if (r == false) {
      e.preventDefault();
      return false
    } else {
      $("input").prop('disabled', false);
      $("select").prop('disabled', false);
      return true
    }
  } else {
    $("input").prop('disabled', false);
    $("select").prop('disabled', false);
    return true
  }
});

// jika totaldo > 0
function countline_do(el) {
  countfreight_do(el)
}
function countfreight_do(el) {
  expeditionprice = parseFloat(j8('.expeditionprice').val())
  par   = el.parent().parent();
  qty   = parseFloat( par.find('.ProductQty').val() );
  weight= parseFloat( par.find('.ProductWeight').val() );
  fc    = qty * weight * expeditionprice 
  par.find('.FreightCharge').val( fc )
  countlinetotal_do(el)
}
function countlinetotal_do(el) {
  par   = el.parent().parent();
  qty   = parseFloat( par.find('.ProductQty').val() );
  final = parseFloat( par.find('.PriceAmount').val() );
  FreightCharge = parseFloat( par.find('.FreightCharge').val() );
  
  fcmethod = j8('.fcmethod').find("option:selected").val();
  if (fcmethod == "INCLUDE") {
    linetotal =(final*qty)+FreightCharge
  } else {
    linetotal =(final*qty)
  }
  par.find('.linetotal').val(linetotal)

  resetsototal()
}
</script>