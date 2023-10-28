<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">  
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
  .detailcustomer .col-md-3{
    padding-left: 0px !important;
    padding-right: 0px !important;
  }
  .box-normal .col-md-3 { 
    padding-left: 0px !important; 
  } 
  .sales { 
    padding-right: 4px; 
    padding-left: 4px; 
  }
  .content-wrapper input, 
  .content-wrapper textarea, 
  .content-wrapper select { 
    padding-top: 5px !important; 
    padding-bottom: 5px !important; 
  }  
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
        width: 120px;
        padding: 5px 15px 0px 5px;
      }
      .form-group span.left2 {
        display: block;
        overflow: hidden;
      }
      .form-group { margin-bottom: 15px; }
  } 
</style>
     
<?php
$shop = $content['shop'];
$MPfee = $content['MPfee'];
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
 
    <div class="box box-solid">
      <div class="box-body">
          <form name="form" id="form" action="<?php echo base_url();?>transaction/sales_order_upload_act" method="post" enctype="multipart/form-data" autocomplete="off">
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
                      
                      <input type="hidden" class="contactid" name="contactid" required="">
                      <input type="hidden" class="billing" name="billing" required="">
                    </div> 
                    <div class="col-md-12 vcenter table-responsive no-padding" style="padding: 0px 5px !important;">
                      <table class="table table-detail-customer">
                        <tbody>
                          <tr>
                            <td style="width: 150px;">Credit Limit</td>
                            <td> :
                              <span class="creditlimit2">...</span>
                              <input type="hidden" name="creditlimit" class="creditlimit" required="">
                            </td>
                          </tr>
                          <tr>
                            <td>Credit Available</td>
                            <td> :
                              <span class="creditavailable2">...</span>
                              <input type="hidden" name="creditavailable" class="creditavailable" required="">
                            </td>
                          </tr>
                          <tr>
                            <td>Payment Term</td>
                            <td> :
                              <span class="paymentterm2">...</span>
                              <input type="hidden" name="npwp" class="npwp" required="">
                              <input type="hidden" name="paymentterm" class="paymentterm" required="">
                            </td>
                          </tr>
                          <tr>
                            <td>SEC Name</td>
                            <td> :
                              <span class="sec">...</span>
                              <input type="hidden" name="regionid" class="regionid" required="">
                              <input type="hidden" name="secid" class="secid" required="">
                            </td>
                          </tr> 
                        </tbody>
                      </table>
                    </div>
                    <div class="col-md-12 table-responsive no-padding div-inv-late" style="padding: 0px 5px !important;">
                      <table class="table inv-late">
                        <tbody></tbody>
                      </table>
                    </div>
                    <div class="col-md-12 table-responsive no-padding div-table-price" style="padding: 0px 5px !important;">
                      <input type="hidden" name="pricelist" class="pricelist" required="">
                      <input type="hidden" name="promovolume" class="promovolume" required="">
                      <table class="table table-price">
                        <tbody></tbody>
                      </table>
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
                    <div class="form-group">
                      <label class="left">Billing To</label>
                      <span class="left2 billingto">
                        ...
                      </span>
                    </div> 
                    <div class="form-group ">
                      <label class="left">SO Sales Ex</label>
                      <span class="left2">
                        <select class="form-control input-sm sales" name="sales" required=""></select>
                      </span>
                    </div> 
                    <div class="form-group ">
                      <label class="left">Market Place</label>
                      <span class="left2">
                        <select class="form-control input-sm mplace" name="mplace" required="">
                          <option value="tokopedia">tokopedia</option>
                          <option value="shopee">shopee</option>
                        </select>
                      </span>
                    </div>  
                    <div class="form-group ">
                      <label class="left">Shop Name</label>
                      <span class="left2">
                        <select class="form-control input-sm shop" name="shop" required="">
                          <option value="0">EMPTY</option>
                          <?php foreach ($shop as $row => $list) { ?>
                              <option value="<?php echo $list['ShopID']; ?>"><?php echo $list['ShopName']; ?></option>
                          <?php } ?>
                        </select>
                      </span>
                    </div>  
                    <div class="form-group ">
                      <label class="left">MP Fee (%)</label>
                      <span class="left2">
                        <input class="form-control input-sm mpfee" name="mpfee" type="Number" minlength="1" required="" step="0.1" max="<?php echo $MPfee; ?>" required>
                      </span>
                    </div>  
                    <div class="form-group">
                      <div class="form-group">
                        <label class="left" for="exampleInputFile">Upload EXCEL</label>
                        <span class="left2">
                          <input type="file" id="excel" name="excel" accept=".xls" required="">
                        </span>
                      </div>
                    </div>
                    
                  </div>
              </div>
            </div> 
            <div class="col-md-12">
              <div class="box-footer" style="text-align: center;">
                <button type="submit" class="btn btn-primary btn-submit" >Submit</button>
              </div>
            </div>
          </form>
      </div>
    </div>
  </section>
</div>

 
<!-- float -->
<div id=float class=float>
  <span id="closefloat" style="cursor:pointer;"><i class="fa fa-fw fa-close"></i></span>
</div>
<style type="text/css">
  .float {
    width: 200px;
    height: 200px;
    position: fixed;
    float: left;
    z-index: 1000;
    top: 200px;
    right: 20px;
    border: 1px solid black;
    display: none;
  }
  #closefloat {
    float: right;
  }
</style>
<!-- ----------------------------------------- -->

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

$(document).ready(function() { 
  $("#closefloat").click(function(event) {
    event.stopPropagation();
    $("#float").fadeOut();
  })
});

j8 = jQuery.noConflict();
j8( document ).ready(function( $ ) {
  currentdate = new Date(); 
  j8(".mask-number").inputmask({ 
      alias:"currency", 
      prefix:'', 
      autoUnmask:true, 
      removeMaskOnSubmit:true, 
      showMaskOnHover: true 
  });
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
  j8(".pricelist").val("")
  j8(".promovolume").val("")

  j8(".npwp").val("")
  j8(".npwp2").html("...")
  j8(".paymentterm").val("")
  j8(".paymentterm2").html("...")
  j8(".creditlimit").val("")
  j8(".creditlimit2").html("...")
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
 
        j8(".npwp").val(response['NPWP'])
        j8(".paymentterm").val(response['PaymentTerm'])
        j8(".paymentterm2").html(response['PaymentTerm'])
        j8(".creditlimit").val(response['CreditLimit'])
        j8(".creditlimit2").html(Number(response['CreditLimit']).toLocaleString('en'))
        j8(".creditavailable").val(response['creditavailable'])
        j8(".creditavailable2").html(Number(response['creditavailable']).toLocaleString('en'))

        j8(".secid").val(response['SECID'])
        j8(".sec").html(response['SECName'])
        j8(".regionid").val(response['RegionID'])
        
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

        pricecategory = response['pricecategory']
        pricelist = response['pricelist']
        promovol  = response['promovolume']
        j8(".pricelist").val(response['pricelist'].join())
        j8(".promovolume").val(response['promovolume'].join())
      } else {
        alert("Customer address doesn't have 'City', please edit ...")
      }
    }
  })
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
</script>