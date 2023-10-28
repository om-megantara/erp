<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">
  .table-main { 
    font-size: 12px; 
    white-space: nowrap; 
  }
  .table-main thead tr{
    background: #49afe3;
    color: #ffffff;
    align-content: center;
  }
  .table-main tbody tr:hover { 
    background: #3c8dbcb0; 
  }
  .table-main tbody tr td { 
    padding: 0px 5px; 
  }
  .productprice { 
    min-width: 80px; 
    padding: 2px 3px; 
  }
  .customborder { 
    border: 1px solid #3c8dbc; 
    padding: 3px;
  }
  @media (min-width: 768px){
    .vcenter {
      /*display: flex;*/
      align-items: center;
    }
  }
  .maincustomer { 
    padding-right: 0px !important; 
    padding-left: 0px !important; 
  }
  .detailcustomer .form-group { 
    /*margin-bottom: 0px !important; */
    /*margin-top: 5px !important */
  }
  .detailso .col-md-12 {
    padding-left: 5px !important;
    padding-right: 0px !important;
  }
  .detailcustomer .col-md-3{
    padding-left: 0px !important;
    padding-right: 0px !important;
  }
  .box-normal .col-md-3 { 
    padding-left: 0px !important; 
  }
  .cellproduct td { 
    vertical-align: middle !important; 
  }
  .cellproduct input { 
    min-width: 80px; 
    padding: 4px 5px !important; 
  }
  .linetotal { width: 90px; }
  .detailso .form-group { 
    margin-bottom: 2px; 
  }
  #shipdate, 
  #sodate, 
  .sales, 
  .socategory { 
    padding-right: 4px; 
    padding-left: 4px; 
  }
  .content-wrapper input, 
  .content-wrapper textarea, 
  .content-wrapper select { 
    padding-top: 5px !important; 
    padding-bottom: 5px !important; 
  }
  .sototal, 
  .sototalbefore { 
    font-size: 20px; 
  }
  .box-sototal .vcenter { 
    padding-left: 0px !important; 
    padding-right: 0px !important;
  }
  .checkPrice { display: none; }
  .inv-late tr td { background-color: #f39c12; }
  .table-price tr td, 
  .inv-late tr td, 
  .table-detail-customer tr td { 
    padding: 2px 5px !important;
    font-size: 12px;
    font-weight: bold;
    margin-top: 10px;
    border: 0px solid ; 
  }
  .table-price tr td:first-child, 
  .inv-late tr td:first-child, 
  .table-detail-customer tr td:first-child { 
    width: 100px;
  }
  .div-table-price, .div-inv-late {
    overflow-x:auto; 
    max-height: 100px;
    margin-bottom: 10px;
  }

  @media (min-width: 768px){
      .form-group label.left {
        float: left;
        width: 100px;
        padding: 5px 15px 0px 5px;
      }
      .form-group span.left2 {
        display: block;
        overflow: hidden;
      }
      .form-group { margin-bottom: 5px; }
  }
  .paymentmethod, 
  .invcategory { 
    padding: 2px; 
  }
  .DueDateProduct { border: 1px solid #3c8dbc; }
  .checkbox_dd {
    display: inline-block;
    margin-left: 20px;
  }
</style>

<?php
$SODepositStandard = $content['SODepositStandard'];
$SODepositCustom = $content['SODepositCustom'];
$shipdate = $content['SOShipDate'];
$shop = $content['shop'];
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <?php echo $PageTitle.' - '. $MainTitle; ?>
    </h1>
    <ol class="breadcrumb">
      <li><a title="HELP" class="btn btn-warning btn-xs" href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
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
                  <div class="ProductName2" title=""></div>
                  <input class="ProductType" name="ProductType[]" type="hidden" readonly="" required="">
                </td>
                <td>
                  <input class="form-control input-sm ProductQty" name="ProductQty[]" type="number" minlength="1" min="1" required="">
                </td>
                <td>
                  <input class="ProductPriceDefault" name="ProductPriceDefault[]" type="hidden" readonly="" required="">
                  <div class="ProductPriceDefault2"></div>
                </td>
                <td>
                  <input class="PricelistName" name="PricelistName[]" type="hidden" readonly="" required="">
                  <input class="PricelistID" name="PricelistID[]" type="hidden" readonly="" required="">
                  <input class="form-control input-sm PricePercent" name="PricePercent[]" type="number" minlength="1" step=".01" required="" title="">
                </td>
                <td>
                  <input class="form-control input-sm PT1Percent" name="PT1Percent[]" type="number" minlength="1" min="0" step=".01" required="" title="TOP">
                  <input class="form-control input-sm PT2Percent" name="PT2Percent[]" type="number" minlength="1" step=".01" min="0" required="" title="CBD">
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
                <td><input class="form-control input-sm linetotal mask-number" name="linetotal[]" type="text" minlength="1" required="" readonly=""></td>
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
          <form name="form" id="form" action="<?php echo base_url();?>transaction/sales_order_add_act" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="col-md-6">
            	<div class="box box-solid detailcustomer">
  		            <div class="box-header with-border">
  		              <h3 class="box-title">CUSTOMER DETAIL</h3>
  		            </div>
  		            <div class="box-body">
  		              <div class="form-group vcenter">
                      <label class="left">Customer</label>
                      <span class="left2">
                        <div class="input-group input-group-sm maincustomer">
                          <select class="form-control customer select2" name="customer" required=""></select>
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-edit" title="EDIT DATA CUSTOMER" onclick="editcustomer();"><i class="fa fa-fw fa-edit"></i></button>
                          </span>
                        </div>
                      </span>
                    </div>
                    <div class="form-group vcenter">
                      <label class="left">SO Date</label>
                      <span class="left2">
                          <input type="text" class="form-control input-sm pull-right" id="sodate" name="sodate" autocomplete="off" required="" >
                      </span>
                    </div>
                    
                    <div class="col-md-12 table-responsive no-padding div-inv-late" style="padding: 0px 5px !important;">
                      <table class="table inv-late">
                        <tbody></tbody>
                      </table>
                    </div>
                    <div class="col-md-12 table-responsive no-padding div-table-price" style="padding: 0px 5px !important;">
                      <table class="table table-price">
                        <tbody></tbody>
                      </table>
                    </div>
  		              <div class="form-group col-md-12" style="padding: 0px 5px !important;">
                      <label class="left">Billing To&emsp;&nbsp;:</label>
                      <span class="left2 billingto">
                        ...
                      </span>
                    </div>
                    <div class="form-group col-md-12" style="padding: 0px 5px !important;">
                      <label class="left">Shipping To :</label>
                      <span class="left2 shippingto">
                        ...
                      </span>
                    </div>
  		            </div>
  		        </div>
            </div>
            
            <div class="col-md-12" style="overflow-x:auto;">
              <table class="table table-bordered table-main table-responsive">
                <thead>
                  <tr>
                    <th class=" alignCenter">Product Code</th>
                    <th class=" alignCenter">Quantity</th>
                    <th class=" alignCenter">Price Default</th>
                    <th class=" alignCenter">Promo</th>
                    <th class=" alignCenter">PT Disc</th>
                    <th class=" alignCenter">Price Promo</th>
                    <th class=" alignCenter">Weight</th>
                    <th class=" alignCenter">FC</th>
                    <th class=" alignCenter">Total</th>
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
                                <option value="INCLUDE">Include</option>
                                <option value="EXCLUDE">Exclude</option>
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
                            <div class="form-group col-md-3"><input type="number" minlength="1" class="form-control input-sm taxrate" name="taxrate" required="" min="0" value="10"></div>
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
product = []
productType = []
pricecategory = []
pricelist = []
promovol = []
curlist = []

j8 = jQuery.noConflict();

j8( document ).ready(function( $ ) {
	 
  j8( ".sotype" ).trigger( "change" );

	currentdate = new Date();
  j8("#sodate").datepicker({ 
    autoclose: true, 
    format: 'yyyy-mm-dd',
    todayBtn:  1,
  })
  .datepicker("setDate", currentdate)
  .on('changeDate', function (selected) {
    shipdate = new Date(selected.date.valueOf());
    shipdate.setDate(shipdate.getDate()+ parseInt(<?php echo $shipdate;?>) );
    j8('#shipdate').datepicker('setDate', shipdate);
  });
 
  shipdate = j8("#sodate").datepicker("getDate")
  shipdate.setDate( shipdate.getDate() + parseInt(<?php echo $shipdate;?>) );
  j8("#shipdate").datepicker({ autoclose: true, format: 'yyyy-mm-dd'}).datepicker("setDate", shipdate);

  paymentmethod   = j8('.paymentmethod').val()
  expeditionprice = parseFloat( j8('.expeditionprice').val() )

  j8(".mask-number").inputmask({ 
      alias:"currency", 
      prefix:'', 
      autoUnmask:true, 
      removeMaskOnSubmit:true, 
      showMaskOnHover: true 
  });

  setTimeout(function(){ //reset so total
    j8('.paymentmethod').trigger("change")
    resetsototal()
  }, 100);
})
j8('.customer').select2({
  width: 'resolve',
  placeholder: 'Input minimum 3 Characters',
  dropdownAutoWidth: true,
  allowClear: true,
  minimumInputLength: 3,
  ajax: {
    url: '<?php echo base_url();?>general/search_customer_city',
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
j8('.customer').on("select2:select", function(e) { 
  j8.when( j8(".table-main tbody").empty() ).done( function(){
    buildcurlist()
    resetsototal()
  })
  CustomerID = j8(this).val()
  CustomerName = j8('.customer option:selected').text().split('(')[0];
  j8(".address").empty()
  j8(".contactid").val("")
  j8(".billing").val("")
  j8(".billingto").text("...")
  j8(".shipping").val("")
  j8(".shippingto").text("...")
  j8(".sales").empty()
  pricecategory = []
  pricelist = []
  promovol = []
  address = []

  j8(".npwp").val("")
  j8(".npwp2").html("...")
  j8(".paymentterm").val("")
  j8(".paymentterm2").html("...")
  j8(".creditavailable").val("")
  j8(".creditavailable2").html("...")

  j8(".secid").val("")
  j8(".sec").html("...")
  j8(".regionid").val("")
  j8(".region").html("...")
  j8(".table-price tbody").empty()
  j8(".inv-late tbody").empty()

  j8.ajax({
    url: "<?php echo base_url();?>transaction/get_customer_address",
    type : 'GET',
    data: {CustomerID:CustomerID, type:"so"},
    dataType : 'json',
    success : function (response) {
      j8(".contactid").val(response['ContactID'])
      address = response['shipping']
      // console.log(address)
      if ("billing" in response && response['cekAllCity']== "1") {
        var len = response['shipping'].length;
        // console.log(response['shipping'])
        j8(".billing").val(CustomerName +";"+ response['billing']['DetailType']+";"+response['billing']['DetailValue'])
        j8(".billingto").html(response['billing']['DetailType']+"<br/>"+response['billing']['DetailValue'])

        for( var i = 0; i<len; i++){
            var addressid = response['shipping'][i]['addressid'];
            var DetailType = response['shipping'][i]['DetailType'];
            var CityID = response['shipping'][i]['CityID'];
            var DetailValue = response['shipping'][i]['DetailValue'];
            j8(".address").append("<option value='"+addressid+"' city='"+CityID+"' addressid='"+addressid+"'>"+DetailType+"</option>");
        }
        j8(".shipping").val( CustomerName +";"+ j8(".address option:first").text() +";"+ address[ j8(".address option:first").val() ]["DetailValue"] )
        j8(".shippingto").html( j8(".address option:first").text() +"<br/>"+ address[ j8(".address option:first").val() ]["DetailValue"]  )
        j8(".expeditionid").val(address[ j8(".address option:first").val() ]["ExpeditionID"])
        j8(".expedition").val("Rp "+address[ j8(".address option:first").val() ]["FCPrice"] +" / "+ address[ j8(".address option:first").val() ]["FCWeight"]+"KG")
        j8(".expeditionprice").val(address[ j8(".address option:first").val() ]["FCPrice"])
        j8(".expeditionweight").val(address[ j8(".address option:first").val() ]["FCWeight"])

        j8(".secid").val(response['SECID'])
        j8(".sec").html(response['SECName'])
        j8(".regionid").val(response['RegionID'])

        j8(".npwp").val(response['NPWP'])
        j8(".paymentterm").val(response['PaymentTerm'])
        j8(".paymentterm2").html(response['PaymentTerm'])
        j8(".creditavailable").val(response['creditavailable'])
        j8(".creditavailable2").html(Number(response['creditavailable']).toLocaleString('en'))

        var len = response['sales'].length;
        for( var i = 0; i<len; i++){
            var SalesName = response['sales'][i]['SalesName'];
            var SalesID = response['sales'][i]['SalesID'];
            j8(".sales").append("<option value='"+SalesID+"'>"+SalesName+"</option>");
        }

        if ("pricename" in response) {
          var len = response['pricename'].length;
          for( var i = 0; i<len; i++){
              j8(".table-price tbody").append("<tr><td>"+response['pricename'][i]['Type']+"</td><td>("+response['pricename'][i]['PricecategoryID']+") "+response['pricename'][i]['PricecategoryName']+"</td></tr>");
          }
        }
        if ("inv_late" in response) {
          var len = response['inv_late'].length;
          j8(".inv-late tbody").append("<tr><td> INV ID </td><td> late </td><td> Outstanding </td></tr>");
          for( var i = 0; i<len; i++){
              j8(".inv-late tbody").append("<tr><td> "+response['inv_late'][i]['INVID']+" </td><td> "+response['inv_late'][i]['date_diff']+"</td><td> "+response['inv_late'][i]['TotalOutstanding']+" </td></tr>");
          }
        }

        expeditionprice = parseFloat(j8('.expeditionprice').val())
        pricecategory = response['pricecategory']
        pricelist = response['pricelist']
        promovol  = response['promovolume']
      } else {
        alert("Customer address doesn't have 'City', please edit ...")
      }
    }
  })
});
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
  if (optionSelected == "CBD") {
    j8('.sopaymentterm').attr("readonly", true).val("0").attr("min",0)
    j8('.PT2Percent').css("display", "block")
    j8('.PT1Percent').css("display", "none")
  } else {
    j8('.sopaymentterm').attr("readonly", false).val("1").attr("min",1)
    j8('.PT2Percent').css("display", "none")
    j8('.PT1Percent').css("display", "block")
  }
  buildcurlist()
  if (curlist.length > 0) {
    countall()
  }
});
function editcustomer() {
  id = j8(".contactid").val()
  if (id != "") {
    window.open('<?php echo base_url();?>master/customer_cu/'+id, '_blank');
    location.reload();
  } else {
    alert("Please select customer first.")
  }
}

function fillproduct(response) {
  if (j8.inArray(response['ProductID'], curlist) < 0) {  //cek jika product exist in list
    j8(".cellproduct:first .ProductID").val(response['ProductID']);
    j8(".cellproduct:first .ProductName").val(response['ProductName']);
    j8(".cellproduct:first .ProductName2").text(response['ProductID']+" : "+response['ProductName']).attr("title",response['ProductType']);
    j8(".cellproduct:first .ProductQty").val("1");
    j8(".cellproduct:first .ProductType").val(response['ProductType']);
    j8(".cellproduct:first .ProductPriceDefault").val(response['ProductPriceDefault']);
    j8(".cellproduct:first .ProductPriceDefault2").text(parseFloat(response['ProductPriceDefault']).toLocaleString("id-ID")).attr('title', response['PricelistName']);
    j8(".cellproduct:first .PricelistID").val(response['PricelistID']);
    j8(".cellproduct:first .PricelistName").val(response['PricelistName']);
    j8(".cellproduct:first .PricePercent").val(response['Promo']);
    j8(".cellproduct:first .PricePercent").attr('title', response['PricelistName']);

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
    buildproductType()
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
  TOP    = parseFloat( par.find('.PT1Percent').val() );
  cbd    = parseFloat( par.find('.PT2Percent').val() );
  final = price - percentage( price, percent )
  if (paymentmethod == "TOP") {
    final = final - percentage(final, TOP)
  }
  if (paymentmethod == "CBD") {
    final = final - percentage(final, cbd)
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
  j8('.fcmethod').val("INCLUDE")
  j8('.fcsuggestion').val("0")
  j8('.fcamount').val("0").attr("readonly", true)
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
function buildproductType() {
  par = j8(".table-main .ProductType")
  productType = []
  for (var i = 0; i < par.length; i++) {
    productType.push(j8(par[i]).val())
  }
  if ( productType.includes("custom") ) {
    j8( ".sotype" ).val("custom").trigger( "change" );
  } else {
    j8( ".sotype" ).val("standard").trigger( "change" );
  }
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
    alert("product is not for Sale!")
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
  buildproductType()
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
            promovol:promovol,  
            ProductPriceDefault:ProductPriceDefault,
            paymentmethod: paymentmethod
          },
    dataType : 'json',
    success : function (response) {

      par.find(".PricelistID").val(response['PriceID'])
      par.find(".PricelistName").val(response['PriceName'])

      paymentmethod = j8('.paymentmethod').val()
      par.find(".ProductPriceDefault").val(response['ProductPriceDefault'])
      par.find(".ProductPriceDefault2").text(response['ProductPriceDefault'])
      par.find(".PricePercent").val(response['Promo'])
      par.find(".PricePercent").attr('title', response['PriceName'])
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
  par   = j8(this).parent().parent();
  par.find('.checkPrice').css("display", "inline-block")
  par.find('.PricelistID').val("")
  par.find('.PricelistName').val("")
  par.find('.PricePercent').val("0")
  par.find('.PricePercent').attr('title', '')
  par.find('.PT1Percent').val("0")
  par.find('.PT1Price').val("0")
  par.find('.PT2Percent').val("0")
  par.find('.PT2Price').val("0")
  par.find('.PricePercent').val("0")
  countline(j8(this))
});
j8('.PricePercent').live( "change", function() {
  countline(j8(this))
});
j8('.PT1Percent').live( "change", function() {
  countline(j8(this))
});
j8('.PT2Percent').live( "change", function() {
  countline(j8(this))
});
j8('.PriceAmount').live( "change", function() {
  par   = j8(this).parent().parent();
  final = parseFloat( j8(this).val() );
  price = parseFloat( par.find('.ProductPriceDefault').val() );
  percent = parseFloat( par.find('.PricePercent').val() );
  TOP    = parseFloat( par.find('.PT1Percent').val() );
  cbd    = parseFloat( par.find('.PT2Percent').val() );
  PriceBefore = final
  if (paymentmethod == "CBD") {
    PriceBefore = (PriceBefore + ((PriceBefore/(100-cbd)) * cbd) )
  } else {
    PriceBefore = (PriceBefore + ((PriceBefore/(100-TOP)) * TOP) )
  }
  percent = 100 - ( PriceBefore / (price/100) )
  par.find('.PricePercent').val(percent.toFixed(2))

  countlinetotal(j8(this))
});
j8('.FreightCharge').live( "change", function() {
  countlinetotal(j8(this))
});
j8('.sotype').live( "change", function() {
  j8('.minimumdp').val( j8(this).find("option:selected").attr('amount') )
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

j8('.shipdays').live( "change", function() {
  shipdate = j8("#sodate").datepicker("getDate")
  shipdate.setDate( shipdate.getDate() + parseInt(j8(this).val()) );
  j8("#shipdate").datepicker({ autoclose: true, format: 'yyyy-mm-dd'}).datepicker("setDate", shipdate);
});

j8(document).on("keypress", "form", function(event) { 
    return event.keyCode != 13;
});
j8("#form").submit(function(e) {
  if (j8('.address').val() < 1) {
    e.preventDefault();
    alert("Shipping address cannot be empty!")
    return false
  }
  if (j8('.table-main .ProductID').length < 1) {
  }

  no = 0
  errorcount  = 0
  errornote   = ""
  paymentmethod = j8(".paymentmethod").val()
  fcmethod = j8(".fcmethod").val()
  fcamount = parseFloat(j8(".fcamount").val())
  sopaymentterm = parseFloat(j8(".sopaymentterm").val())
  paymentterm = parseFloat(j8(".paymentterm").val())
  creditavailable = parseFloat(j8(".creditavailable").val())
  sototal     = parseFloat(j8(".sototal").val())
  socategory  = j8(".socategory").val()
  invcategory = j8(".invcategory").val()
  minimumdp = j8(".sotype").find("option:selected").attr('amount')
  minimumdp2 = j8(".minimumdp").val()
  // console.log(paymentmethod)
  if ($('.inv-late tbody').find('tr').length > 1) {
    errorcount += 1
    errornote += "-There is a late Invoice \n"
  }

  if (socategory != 1) {
      errorcount += 1
      errornote += "-SO not Sales \n"
  }
  if (minimumdp2 < minimumdp ) {
      errorcount += 1
      errornote += "-Minimum DP lebih kecil dari ketentuan \n"
  }
  if (invcategory != 1) {
      errorcount += 1
      errornote += "-Payment SO by Percentage \n"
  }
  if (paymentmethod == "TOP") {
    if (sopaymentterm > paymentterm) {
      errorcount += 1
      errornote += "-Payment term exceeded provisions \n"
    }
    if (sototal > creditavailable) {
      errorcount += 1
      errornote += "-Total SO exceeded provisions \n"
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
      if (PriceAmount < PT1Price) {
        errorcount += 1
        errornote += "-Product no:"+no+" not in accordance with the provisions \n"
      }
    } else {
      if (PriceAmount < PT2Price) {
        errorcount += 1
        errornote += "-Product no:"+no+" not in accordance with the provisions \n"
      }
    }

    if (PricelistID == "") {
      e.preventDefault();
      alert("Product promo not checked yet.")
      return false
    }
  });

  if (j8('.sototal').val() == 0) {
    e.preventDefault();
    alert("Total SO Not yet calculated.")
    return false
  }
  if (fcmethod == "EXCLUDE") {
    if (fcamount == 0) {
      e.preventDefault();
      alert("FC Exclude can't be 0.")
      return false
    }
  }

  if (errorcount > 0) {
    errornote += "This SO will require approval!\n"
    var r = confirm(errornote);
    if (r == false) {
      e.preventDefault();
      return false
    } else {
      $('input.DueDate[type=checkbox]:not(:checked)').each(function () {
          $(this).prop('checked', true).val(0);
      });
    }
  } else {
    $('input.DueDate[type=checkbox]:not(:checked)').each(function () {
        $(this).prop('checked', true).val(0);
    });
  }
  
});

</script>