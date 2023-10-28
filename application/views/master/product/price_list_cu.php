<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/datatables/media/css/jquery.dataTables.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">

<style type="text/css">
  .form-pricelistid {display: none;}
  .form-group { display: block; margin-bottom: 5px !important; }
  .customaddr {font-size: 12px; padding: 0px 3px; font-weight: bold; margin-bottom: 3px;}
  .phone, .email, .employeename, .productcomponent {margin-top: 2px;}
  .add_addr {font-size: 18px; font-weight: bold; color: white; background-color: #5bc0de; padding: 0px 8px;}
  .fullname .form-control, .address .form-control { margin-top: 3px; }
  .box-body h6 {display: inline; color: red; font-weight: bold;}
</style>

<?php 
// print_r($content); 
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <?php echo $PageTitle.' - '. $MainTitle; ?>
    </h1>
  </section>

  <section class="content">
   
    <div class="modal fade" id="modal-contact">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
          </div>
          <div class="modal-body">
            <div class="input-group input-group-sm productcomponent">
  				    <div class="col-md-6">
                <select class="form-control selpro" name="product[]"></select>
              </div>
              <div class="col-md-6">
                <input type="number" class="form-control selprice" name="price[]" placeholder="Disc(%)" autocomplete="off" min="0" max="100">
              </div>
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary  add_field" onclick="if ($('.productcomponent').length != 1 ) { $(this).closest('div').remove(); buildcurproductlist();}">-</button>
              </span>
            </div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>
   
    <div class="box">
      <div class="box-header with-border">
      </div>
      <div class="box-body form_addcontact">
        <form name="form" id="form" action="<?php echo base_url();?>master/price_list_cu_act" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
          <div class="col-md-6">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Pricelist Information</h3>
              </div>
              <div class="box-body">
                <div class="form-pricelistid">
                  <label>Pricelist ID</label>
                  <input type="text" class="form-control" placeholder="Pricelist ID" autocomplete="off" name="pricelistid" id="pricelistid" value="<?php echo $content['pricelist']['PricelistID'];?>">
                </div>
                <div class="form-group fullname">
                  <label>Pricelist Name</label>
                  <input type="text" class="form-control" placeholder="Pricelist Name" autocomplete="off" name="pname" id="pname" value="<?php echo $content['pricelist']['PricelistName']; ?>" required="">
                </div>
                <div class="form-group">
                  <label>Pricelist Note</label>
                  <textarea class="form-control" rows="3" placeholder="Pricelist note" name="pnote" id="pnote"><?php echo $content['pricelist']['PricelistNote']; ?></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6" id="addedit">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Pricelist Information Detail</h3>
              </div>
              <div class="box-body">
                <div class="form-group">
                  <label>Price Category</label>
                  <select class="form-control" name="pricecategory" id="pricecategory" required=""></select>
                </div>
                <div class="form-group">
                  <label>Pricelist Start</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control" autocomplete="off" name="pstart" id="pstart" value="<?php echo $content['pricelist']['DateStart']; ?>" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label>Pricelist End</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control" autocomplete="off" name="pend" id="pend" value="<?php echo $content['pricelist']['DateEnd']; ?>" required="">
                  </div>
                </div>
                <div class="form-group customborder">
                  <div class="input-group">
                    <div class="input-group-btn raw">
                      <button type="button" class="btn btn-primary" id="open_popup">TAMBAH</button>
                    </div>
                    <input type="text" class="form-control" readonly value="Product Pricelist">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="box-footer" style="text-align: center;">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
          <div class="col-md-12">
            <label id="rawmaterial">Product Pricelist</label>
          </div>
        </form>
      </div>
      <div class="box-footer">
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/jquery-ui.js"></script>
<script language="javascript" src="<?php echo base_url();?>tool/datatables/media/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script>
j8  = jQuery.noConflict();
j8( document ).ready(function( $ ) {
  $("li.menu_master").addClass( "active" );
  $("#pstart").datepicker({ autoclose: true, format: 'yyyy-mm-dd'});
  $("#pend").datepicker({ autoclose: true, format: 'yyyy-mm-dd'});
  fill_price();
  $("input").keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });	
});
var pricelistd = [];
jQuery( document ).ready(function( $ ) {
  // jika edit data
  if ($("#form #pricelistid").val() !== "") {
    $(".form-pricelistid").show();
    $("#pricelistid").prop("disabled", true)
    if ($("#pstart").val() !== null) { $("#pstart").prop("disabled", true)}
    pricelistd = $.parseJSON('<?php if ( isset($content['pricelistd2'])){ echo $content['pricelistd2']; }?>');
    setTimeout( function order() {
      productcomponentedit();
    }, 3000)
  }
  // ======================
});
function productcomponentedit() {
  if (pricelistd !== null) {
    for( var i = 0; i<pricelistd.length; i++){
      addraw(pricelistd[i]['ProductID'], pricelistd[i]['ProductCode'], pricelistd[i]['PriceValue'], );
    }
  }
}
function addraw(id, name, price) {
  $(".productcomponent:first select").empty();
  $(".productcomponent:first select").append("<option value='"+id+"'>"+name+"</option>");
  $(".productcomponent:first .selprice").val(price);
  $(".productcomponent:first").clone().insertAfter("#rawmaterial"); 
}
function fill_price() {
  $.ajax({
    url: '<?php echo base_url();?>master/fill_price',
    type: 'post',
    dataType: 'json',
    success:function(response){
      var len = response.length;
      for( var i = 0; i<len; i++){
          var PricecategoryID = response[i]['PricecategoryID'];
          var PricecategoryName = response[i]['PricecategoryName'];
          $("#pricecategory").append("<option value='"+PricecategoryID+"'>"+PricecategoryName+"</option>");
      }
      $("#pricecategory").val('<?php if ( isset($content['pricelist']['PricecategoryID'])){ echo $content['pricelist']['PricecategoryID']; }?>');
      if ($("#pricecategory").val() !== null) { $("#pricecategory").prop("disabled", true)}
    }
  });
}
function cek_input_detail() {
  if ($.trim($("#pstart").val()) === "" || $.trim($("#pend").val()) === "" || $.trim($("#pname").val()) === "" || $("#pricecategory").val() === null) {
    alert("input tidak boleh kosong");
    return false;
  }
  if ($('.productcomponent').length < 2) {
    alert("harus menambahkan product walaupun hanya 1 !!!");
    return false;
  }
}
j8('#form').live('submit', function() {
    $(this).find(':disabled').removeAttr('disabled');
});
	
var popup_product_list = null;
j8("#open_popup").on('click', function() {
  popup_product_list = window.open('<?php echo base_url();?>master/product_list_popup', '_blank', 'width=700,height=500,left=200,top=100');
});	

var curproductlist = []
function buildcurproductlist() {
  curproductlist = []
  par = $(".productcomponent select")
  for (var i = 1; i < par.length; i++) {
    curproductlist.push($(par[i]).val())
  }
}

function ProcessChildMessage(message) {
  buildcurproductlist()
  if (typeof message !== 'undefined' && message.length > 0) {
    for( var i = 0; i<message.length; i++){
      if ($.inArray(message[i]['tdid'], curproductlist) < 0 ) {  
        addraw(message[i]['tdid'], message[i]['tdname'], "0" );
      }
    }
  }
  // console.log(curproductlist)
}
</script>