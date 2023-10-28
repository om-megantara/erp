<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">

<style type="text/css">
  .code, .name, .rowlist, .rowtext, .atributelabel, #nameformula, #codeformula, .rawcomponent { margin-top: 2px; }
  .form-group { display: block; margin-bottom: 5px !important; }
  .customaddr {font-size: 12px; padding: 0px 3px; font-weight: bold; margin-bottom: 3px;}
  .phone, .email {margin-top: 2px;}
  .add_addr {font-size: 18px; font-weight: bold; color: white; background-color: #5bc0de; padding: 0px 8px;}
  .fullname .form-control input-sm, .address .form-control input-sm { margin-top: 3px; }
  .box-body h6 {display: inline; color: red; font-weight: bold;}
  .col-xs-2 input, .rowtext .col-xs-3 input, .rowtext .col-xs-6 input,
  .rowtext .col-xs-3 select, .rowtext .col-xs-6 select,
  .rowlist .col-xs-3 input, .rowlist .col-xs-6 input,
  .rowlist .col-xs-3 select, .rowlist .col-xs-6 select {padding: 3px 6px !important; margin-top: 2px;}
  .select2-selection--single { border-radius: 0px !important; padding: 3px 3px !important; }
  .customborder { border: 1px solid #3c8dbc; padding: 3px;}
  .radio { display: inline-block !important; margin-left: 30px; font-weight: bold;}

  @media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 120px;
      padding: 5px 15px 5px 5px;
    }
    .form-group label.left3 {
      float: left;
      width: 150px;
      padding: 5px 15px 5px 5px;
    }
    .form-group span.left2 {
      display: block;
      overflow: hidden;
    }
    .form-group { margin-bottom: 5px; }
  }


  input.inputFile {
    width: 100%;
    display: inline-block;
    background: white;
    padding: 3px 0px;
    border: 1px solid #ccc;
    /*text-indent: -100px;*/
    outline: 0 !important;
    cursor: pointer;
  }
  .formFile .col-xs-6,
  .formFile .col-xs-12 {
    padding-top: 3px;
    padding-left: 5px;
    padding-right: 5px;
  }
  .input-group-title {
    vertical-align: top;
    width: 150px;
    padding-left: 10px;
  }
</style>

<?php
  $clone = $this->input->get('clone');
  if (isset($clone)) {
    $productdetail['ProductID'] = "0";
  }
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

    <div class="modal fade" id="modal-contact">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <div class="row rowtext">
              <div class="col-xs-4">
                <input type="hidden" class="form-control input-sm atributeid" name="atributeid[]" readonly>
                <input type="text" class="form-control input-sm atributetype" name="atributetype[]" readonly>
              </div>
              <div class="col-xs-8">
                <input type="text" class="form-control input-sm atributevalue" name="atributevalue[]" required="">
              </div>
            </div>
            <div class="row rowlist">
              <div class="col-xs-4">
                <input type="hidden" class="form-control input-sm atributeid" name="atributeid[]" readonly>
                <input type="text" class="form-control input-sm atributetype" name="atributetype[]" readonly>
              </div>
              <div class="col-xs-8">
                <select class="form-control input-sm atributevalue" name="atributevalue[]" required>
                  <option value="0">--TOP--</option>
                </select>
              </div>
            </div>
            <div class="input-group input-group-sm rawcomponent">
              <select class="form-control input-sm" name="raw[]"></select>
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary  add_field" onclick="if ($('.rawcomponent').length != 1) { $(this).closest('div').remove();}">-</button>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="box box-solid">
      <div class="box-body form_addcontact">
          <form name="form" id="form" action="<?php echo base_url();?>master/product_cu" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="col-md-6">
              <div class="box box-solid">
                <div class="box-body">
                  <div class="form-group ">
                    <label class="left">Product ID <h6>*</h6> </label>
                    <span class="left2">
                      <input type="text" class="form-control input-sm productid" placeholder="Product ID" autocomplete="off" name="productid" id="productid" value="<?php if ( isset($productdetail)){ echo $productdetail['ProductID']; }?>">
                      <input type="hidden" class="productid2" name="productid2" value="<?php if ( isset($productdetail)){ echo $productdetail['ProductID']; }?>">
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Product Code <h6>*</h6> </label>
                    <span class="left2">
                      <div class="input-group">
                        <input type="text" class="form-control input-sm" placeholder="Product Code" name="productcode" id="productcode" required="">
                        <div class="input-group-btn raw">
                          <button type="button" class="btn btn-sm btn-primary" title="CHECK CODE" id="cek_code">Check Code</button>
                        </div>
                      </div>
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Product Name <h6>*</h6> </label>
                    <span class="left2">
                      <input type="text" class="form-control input-sm" placeholder="Product Name" name="productname" id="productname" required="">
                    </span>
                  </div>
                  <div class="form-group">
                    <label>Product Supplier Name <h6>*</h6> </label>&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-primary btn-xs copy-nameproduct" title="COPY" onclick="copyto()"><i class="fa fa-fw fa-copy"></i></button>
                    <input type="text" class="form-control input-sm" placeholder="Product Name" name="productsuppliername" id="productsuppliername">
                  </div>
                  <div class="form-group">
                    <label class="left">Description <h6>*</h6> </label>
                    <span class="left2">
                      <textarea class="form-control" placeholder="Product Description" name="productdescription" id="productdescription" required=""></textarea>
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Status Quality</label>
                    <span class="left2">
                      <select class="form-control input-sm" name="statusquality" id="statusquality"></select>
                    </span>
                  </div>
                  <?php if ($this->auth->cek5('manage_product_hpp')) { ?>
                  <div class="customborder">
                    <div class="form-group">
                      <label class="left">Price HPP</label>
                      <span class="left2">
                        <input type="text" class="form-control input-sm mask-number" id="hpp" name="hpp" placeholder="Price HPP" autocomplete="off" min="0" onKeyUp="sum();">
                      </span>
                    </div>
                    <div class="form-group">
                      <label class="left">Percent (%)</label>
                      <span class="left2">
                        <?php if (in_array("edit_price_default", $MenuList)) {?>
                        <input type="number" class="form-control input-sm" id="persen" name="persen" placeholder="Percentage" autocomplete="off" step="0.01" onKeyUp="sumPercent();">
                        <?php } else {?>
                        <input type="number" class="form-control input-sm" id="persen" name="persen" placeholder="Percentage" autocomplete="off" step="0.01" min="0" onKeyUp="sumPercent();">
                        <?php } ?>
                      </span>
                    </div>
                    <div class="form-group">
                      <label class="left">Price Default</label>
                      <span class="left2">
                        <input type="text" class="form-control input-sm mask-number" id="price" name="price" placeholder="Price Default" autocomplete="off" min="0" onKeyUp="sum();">
                      </span>
                    </div>
                    <div class="form-group">
                      <label class="left">Multiplier</label>
                      <span class="left2">
                        <input type="number" class="form-control input-sm" id="multiplier" name="multiplier" placeholder="Multiplier" autocomplete="off" min="0" step="0.1" value="1">
                      </span>
                    </div>
                  </div>
                  <?php } else {  ?>
                    <input type="hidden" class="form-control input-sm mask-number" id="hpp" name="hpp">
                    <input type="hidden" class="form-control input-sm" id="persen" name="persen">
                    <input type="hidden" class="form-control input-sm mask-number" id="price" name="price">
                    <input type="hidden" class="form-control input-sm" id="multiplier" name="multiplier">
                  <?php } ?>
                  <div class="form-group customborder">
                    <div class="input-group" style="margin-bottom: 5px;">
                      <span class="input-group-addon"> <input type="checkbox" id="stockable" name="stockable" checked="" value="1"> </span>
                      <input type="text" class="form-control input-sm" value="STOCKABLE" readonly>
                    </div>
                    <div class="form-group">
                      <label class="left">Max Stock</label>
                      <span class="left2">
                        <input type="number" class="form-control input-sm" id="max" name="max" placeholder="Max Stock" autocomplete="off" min="0">
                      </span>
                    </div>
                    <div class="form-group">
                      <label class="left">Min Stock</label>
                      <span class="left2">
                        <input type="number" class="form-control input-sm" id="min" name="min" placeholder="Min Stock" autocomplete="off" min="0">
                      </span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="left3">Country of Origin</label>
                    <span class="left2">
                      <select class="form-control input-sm" name="country" id="country" required=""></select>
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left3">Product CodeBar</label>
                    <span class="left2">
                      <input type="text" class="form-control input-sm" placeholder="Product Code Bar" name="productcodebar" id="productcodebar" required="">
                    </span>
                  </div>

                  <div class="form-group ">
                    <label style="display: block;">File Upload (Image or Doc)</label>
                    <?php 
                      if (isset($productdetail['file'])) {
                        foreach ($productdetail['file'] as $row => $list) { 
                    ?>
                      <span class="formFile">
                        <div class="col-xs-12">
                          <div class="input-group input-group-sm fileU">
                            <input type="text" class="form-control input-sm fileT" name="fileTold[]" readonly="" value="<?php echo $list['FileType'];?>">
                            <input type="hidden" class="form-control input-sm fileNold" name="fileNold[]" readonly="" value="<?php echo $list['FileName'];?>">
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-primary " onclick="window.open('<?php echo base_url();?>assets/ProductFile/<?php echo $list['FileName'];?>', '_blank')"><i class="fa fa-fw fa-file-image-o"></i></button>
                              <button type="button" class="btn btn-primary  add_field" onclick="if ($('.formFile').length != 1) { $(this).closest('.formFile').remove();}">-</button>
                            </span>
                          </div>
                        </div>
                      </span>
                    <?php } } ?>
                    <span class="formFile">
                      <div class="col-xs-6">
                          <input type="text" class="form-control input-sm fileT toUpperCase" name="fileT[]">
                      </div>
                      <div class="col-xs-6">
                          <div class="input-group input-group-sm fileU">
                            <input class="inputFile fileN" name="fileN[]" onchange="readimage(this);" accept="image/*" type="file"\>
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-primary  add_field" onclick="duplicatefileU();">+</button>
                              <button type="button" class="btn btn-primary  add_field" onclick="if ($('.formFile').length != 1) { $(this).closest('.formFile').remove();}">-</button>
                            </span>
                          </div>
                      </div>
                    </span>
                  </div>
                  <!-- 
                  <div class="form-group">
                    <label for="exampleInputFile">Product Image</label>
                    <input type="file" class="input-file" id="image" name="image" onchange="readimage(this);" accept="image/*">
                    <p class="help-block">Must be in Image file and maximum size of 2MB</p>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Product Document (PDF)</label>
                    <input type="file" class="input-file" id="pdf" name="pdf" onchange="readpdf(this);">
                    <p class="help-block">Must be in PDF file and maximum size of 3MB</p>
                  </div>
                   -->
                  <div class="form-group">
                    <label>For Sale :</label>
                    <div class="radio">
                      <label> <input type="radio" name="forsale" value="0" checked=""> No </label>
                    </div>
                    <div class="radio">
                      <label> <input type="radio" name="forsale" value="1" > Yes </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="left">Stock All</label>
                    <span class="left2">
                      <input type="number" class="form-control input-sm" id="stockAll" name="stockAll" placeholder="Stock All" autocomplete="off" min="0" readonly="">
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Status</label>
                    <span class="left2">
                      <select class="form-control input-sm" name="active" id="active">
                        <option value="1">Active</option>   
                        <option value="0">Non Active</option>   
                      </select>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="box box-solid">
                <div class="box-body">
                  <div class="form-group">
                    <label>Name & Code formula </label>
                    <input type="text" class="form-control input-sm" id="codeformula" readonly placeholder="Code Formula">
                    <input type="text" class="form-control input-sm" id="nameformula" readonly placeholder="Name Formula">
                  </div>
                  <div class="form-group">
                    <label class="left">Category</label>
                    <span class="left2">
                      <select class="form-control input-sm" name="productcategory" id="productcategory" required="">
                        <option value="">--TOP--</option>
                        <?php foreach ($productcategory as $row => $list) { ?>
                          <option value="<?php echo $list['ProductCategoryID'];?>"><?php echo $list['ProductCategoryName'];?></option>
                        <?php } ?>
                      </select>
                    </span>
                    <div class="row">
                      <div class="col-xs-12">
                        <input type="text" class="form-control input-sm code" placeholder="Category Code" autocomplete="off" name="categorycode" id="categorycode" readonly>
                      </div>
                    </div>
                    <div class="row ">
                      <div class="col-xs-12">
                        <input type="text" class="form-control input-sm name" placeholder="Category Name" autocomplete="off" name="categoryname" id="categoryname" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="left">Brand</label>
                    <span class="left2">
                      <select class="form-control input-sm" name="productbrand" id="productbrand" required="">
                        <option value="">--TOP--</option>
                        <?php foreach ($productbrand as $row => $list) { ?>
                          <option value="<?php echo $list['ProductBrandID'];?>"><?php echo $list['ProductBrandName'];?></option>
                        <?php } ?>
                      </select>
                    </span>
                    <div class="row">
                      <div class="col-xs-12">
                        <input type="text" class="form-control input-sm code" placeholder="Brand Code" autocomplete="off" name="brandcode" id="brandcode" readonly>
                      </div>
                    </div>
                    <div class="row ">
                      <div class="col-xs-12">
                        <input type="text" class="form-control input-sm name" placeholder="Brand Name" autocomplete="off" name="brandname" id="brandname" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="form-group customborder">
                    <label class="left">Atribute Set</label>
                    <span class="left2">
                      <select class="form-control input-sm" name="productatributeset" id="productatributeset" onchange="build_atribute();">
                        <option value="0">--TOP--</option>
                      </select>
                    </span><br>
                    <label id="atributelabel">Product Atribute Component</label>
                  </div>
                  <div class="form-group customborder">
                    <div class="input-group">
                      <div class="input-group-btn raw">
                        <button type="button" class="btn btn-sm btn-primary" title="ADD RAW" id="open_popup">Add RAW Material</button>
                      </div>
                      <input type="text" class="form-control input-sm" readonly value="RAW Material">
                    </div><br>
                    <label id="rawmaterial">RAW Component</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box-footer" style="text-align: center;">
                <button type="button" class="btn btn-primary" title="CLONE PRODUCT" onclick="clone(); return false;"><i class="fa fa-fw fa-copy"></i> Clone Product</button>
                <button type="button" class="btn btn-primary" title="GENERATE" onclick="generate(); return false;"><i class="fa fa-fw fa-gears"></i> Generate Name & Code</button>
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/jquery-ui.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url();?>tool/jquery.inputmask.bundle.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/plugins/iCheck/icheck.min.js"></script>
<script>
j8  = jQuery.noConflict();
j8( document ).ready(function( $ ) {
   
  $(".mask-number").inputmask({ 
    alias:"currency", 
    prefix:'', 
    autoUnmask:true, 
    removeMaskOnSubmit:true, 
    showMaskOnHover: true 
  });
  $("input").keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});
var atributedetail = [];
var rawmaterialdetail = [];
jQuery( document ).ready(function( $ ) {
  $(".select2").select2();
  $(".copy-nameproduct").click();
  fill_state()
  fill_statusquality();
  fill_atribute_set();
  // jika edit data
  if ($(".productid").val() !== "") {
    // $(".productid").show();
    if ($(".productid").val() !== "0") {
      $(".productid").attr("readonly", true)
    } else {
      $(".productid").val("")
      $(".productid2").val("")
    }
    $("#form #productcode").val('<?php if ( isset($productdetail)){ echo $productdetail['ProductCode']; }?>');
    $("#form #productname").val('<?php if ( isset($productdetail)){ echo $productdetail['ProductName']; }?>');
    $("#form #productdescription").val('<?php if ( isset($productdetail)){ echo $productdetail['ProductDescription']; }?>');
    $("#form #price").val('<?php if ( isset($productdetail)){ echo $productdetail['ProductPriceDefault']; }?>');
  	$("#form #hpp").val('<?php if ( isset($productdetail)){ echo $productdetail['ProductPriceHPP']; }?>');
    $("#form #persen").val('<?php if ( isset($productdetail)){ echo $productdetail['ProductPricePersentage']; }?>');
  	$("#form #multiplier").val('<?php if ( isset($productdetail)){ echo $productdetail['ProductMultiplier']; }?>');
    $("#form #productsuppliername").val('<?php if ( isset($productdetail)){ echo $productdetail['ProductSupplier']; }?>');
	  $("#form #productcodebar").val('<?php if ( isset($productdetail)){ echo $productdetail['ProductCodeBar']; }?>');
    $("#form #max").val('<?php if ( isset($productdetail)){ echo $productdetail['MaxStock']; }?>');
    $("#form #min").val('<?php if ( isset($productdetail)){ echo $productdetail['MinStock']; }?>');
    $("#form #active").val('<?php if ( isset($productdetail)){ echo $productdetail['isActive']; }?>');
    $("#form #stockAll").attr('value', '<?php if ( isset($productdetail)){ echo $productdetail['stockAll']; }?>');
    var stockable = '<?php if ( isset($productdetail)){ echo $productdetail['Stockable']; }?>';
    if (stockable === '0') {
      $('#stockable').attr('checked', false).trigger("change");
    }

    productatributeset = '<?php if ( isset($productdetail)){ echo $productdetail['ProductAtributeSetID']; }?>'
    // console.log(productatributeset)
    productatributeset2 = productatributeset
    atributedetail = $.parseJSON('<?php if ( isset($productdetail['detail2'])){ echo $productdetail['detail2']; }?>');
    rawmaterialdetail = $.parseJSON('<?php if ( isset($productdetail['raw2'])){ echo $productdetail['raw2']; }?>');
    setTimeout( function order() {
      if ($('#productatributeset option').length > 0) {
        $('#productatributeset').val(productatributeset);
      }
      build_atribute();
    }, 2000)
    $("#form #productcategory").val('<?php if ( isset($productdetail)){ echo $productdetail['ProductCategoryID']; }?>');
    $("#form #productcategory").trigger('change');
    $("#form #productbrand").val('<?php if ( isset($productdetail)){ echo $productdetail['ProductBrandID']; }?>');
    $("#form #productbrand").trigger('change');
    
    $("input[type=radio][name=forsale]").filter("[value=<?php if ( isset($productdetail)){ echo $productdetail['forSale']; } ?>]").prop('checked', true);
	  var forsale = '<?php if ( isset($productdetail)){ echo $productdetail['forSale']; }?>';
    if (forsale === '1') {
      $('#forsale[0]').attr('checked', false).trigger("change");
    }

    setTimeout( function order() {
      fillatributeedit();
      rawmaterialedit();
    }, 5000)
  }
  // ======================

  <?php if ($this->auth->cek5('manage_product_konsumtif')) { ?>
    $("input[name=forsale][value=0]").attr('checked', 'checked');
    $("input[name=forsale][value=1]").parent().parent().remove();
  <?php } ?>
});
function fill_state() {
  $.ajax({
      url: '<?php echo base_url();?>employee/fill_state',
      type: 'post',
      dataType: 'json',
      success:function(response){
        var len = response.length;
        for( var i = 0; i<len; i++){
            var StateName = response[i]['StateName'];
            var StateID = response[i]['StateID'];
            $("#country").append("<option value='"+StateID+"'>"+StateName+"</option>");
        }
        $("#country").val('<?php if ( isset($productdetail)){ echo $productdetail['ProductCountry']; }?>');
      }
  });
}
	
function copyto(){
  var productname = document.getElementById("productname");
  var productsuppliername = document.getElementById("productsuppliername");
  var name = productname.value;
  productsuppliername.value = name
}
	
function sum() {
  var txtFirstNumberValue = document.getElementById('hpp').value;
  var txtSecondNumberValue = document.getElementById('price').value;
  var result = ((parseInt(txtSecondNumberValue) - parseInt(txtFirstNumberValue))/parseInt(txtSecondNumberValue)) * 100;
  if (!isNaN(result)) {
    document.getElementById('persen').value = result.toFixed(2);;
  }else{
    document.getElementById('persen').value = "";
  }
}
function sumPercent() {
  var txtFirstNumberValue = document.getElementById('hpp').value;
  var txtSecondNumberValue = document.getElementById('persen').value;
  var result = parseInt(txtFirstNumberValue) / ( 1 - (parseInt(txtSecondNumberValue)/100 ) );
  if (!isNaN(result)) {
    // var rest = result % 1000; 
    // if(rest < 500) { result = result - rest + 1000; } 
    // result = Math.round(result/1000)*1000;
    document.getElementById('price').value = result.toFixed(0);
  }else{
    document.getElementById('price').value = "";
  }
}
// jika edit data
function fillatributeedit() {
  if (atributedetail !== null) {
    $("#form .rowtext .atributeid").each(function() {
      var par = $(this).parent().parent().find(".atributevalue").first()
      for( var i = 0; i<atributedetail.length; i++){
        if (atributedetail[i]['ProductAtributeID'] === $(this).val()) {
          par.val(atributedetail[i]['AtributeValue'])
        }
      }
    });
    $("#form .rowlist .atributeid").each(function() {
      var par = $(this).parent().parent().find(".atributevalue").first()
      for( var i = 0; i<atributedetail.length; i++){
        if (atributedetail[i]['ProductAtributeID'] === $(this).val()) {
          par.val(atributedetail[i]['AtributeValue'])
        }
      }
    });
  }
}
function rawmaterialedit() {
  if (rawmaterialdetail !== null) {
    for( var i = 0; i<rawmaterialdetail.length; i++){
      $('select.select2:last').val(rawmaterialdetail[i]).trigger('change');
      addraw(rawmaterialdetail[i]['RawMaterialID'], rawmaterialdetail[i]['ProductName']);
    }
  }
}
// ===================

function addraw(id, name) {
  $(".rawcomponent:first select").empty();
  $(".rawcomponent:first select").append("<option value='"+id+"'>"+name+"</option>");
  $(".rawcomponent:first").clone().insertAfter("#rawmaterial"); 
}
function fill_product_list() {
  $.ajax({
      url: '<?php echo base_url();?>master/fill_product_list',
      type: 'post',
      dataType: 'json',
      success:function(response){
        var len = response.length;
        for( var i = 0; i<len; i++){
            var ProductID = response[i]['ProductID'];
            var ProductName = response[i]['ProductName'];
            $("select.select2:last").append("<option value='"+ProductID+"'>"+ProductName+"</option>");
        }
      }
  });
}
function fill_statusquality() {
  $.ajax({
    url: '<?php echo base_url();?>master/fill_statusquality',
    type: 'post',
    dataType: 'json',
    success:function(response){
      var len = response.length;
      for( var i = 0; i<len; i++){
          var ProductStatusID = response[i]['ProductStatusID'];
          var ProductStatusName = response[i]['ProductStatusName'];
          $("#statusquality").append("<option value='"+ProductStatusID+"'>"+ProductStatusName+"</option>");
      }
      $("#statusquality").val('<?php if ( isset($productdetail)){ echo $productdetail['ProductStatusID']; }?>');
    }
  });
}
function fill_atribute_set() {
  $.ajax({
      url: '<?php echo base_url();?>master/fill_atribute_set',
      type: 'post',
      dataType: 'json',
      success:function(response){
        var len = response.length;
        for( var i = 0; i<len; i++){
            var ProductAtributeSetID = response[i]['ProductAtributeSetID'];
            var ProductAtributeSetName = response[i]['ProductAtributeSetName'];
            $("#productatributeset").append("<option value='"+ProductAtributeSetID+"'>"+ProductAtributeSetName+"</option>");
        }
      }
  });
}
j8('#productcategory').live('change',function(e){
  var par   = $(this).parent().parent().find(".code").first()
  var par2  = $(this).parent().parent().find(".name").first()
  $.ajax({
    url: "<?php echo base_url();?>master/get_category_code",
    type : 'GET',
    data : 'id=' + $(this).val(),
    dataType : 'json',
    success : function (response) {
      var len = response.length;
      par.val(response);
    }
  })
  $.ajax({
    url: "<?php echo base_url();?>master/get_category_name",
    type : 'GET',
    data : 'id=' + $(this).val(),
    dataType : 'json',
    success : function (response) {
      var len = response.length;
      par2.val(response);
    }
  })
  $.ajax({
    url: "<?php echo base_url();?>master/fill_category_name_code",
    type : 'GET',
    data : 'id=' + $(this).val(),
    dataType : 'json',
    success : function (response) {
      $('#codeformula').val(response[0]);
      $('#nameformula').val(response[1]);
    }
  })
  if (typeof productatributeset2 != 'undefined') {
    delete productatributeset2
  } else {
    CurrentAttributeSet = $('#productatributeset').val();
    $.ajax({
      url: "<?php echo base_url();?>master/get_category_aribute_set",
      type : 'GET',
      data : 'id=' + $(this).val(),
      dataType : 'json',
      success : function (response) {
        if (CurrentAttributeSet != response[0]) {
          $('#productatributeset').val(response[0]);
          build_atribute();
        }
      }
    })
  }
})
j8('#productbrand').live('change',function(e){
  var par = $(this).parent().parent().find(".code").first()
  var par2 = $(this).parent().parent().find(".name").first()
  $.ajax({
    url: "<?php echo base_url();?>master/get_brand_code",
    type : 'GET',
    data : 'id=' + $(this).val(),
    dataType : 'json',
    success : function (response) {
      var len = response.length;
      par.val(response);
    }
  })
  $.ajax({
    url: "<?php echo base_url();?>master/get_brand_name",
    type : 'GET',
    data : 'id=' + $(this).val(),
    dataType : 'json',
    success : function (response) {
      var len = response.length;
      par2.val(response);
    }
  })
})
function build_atribute() {
  len = $('.rowtext').length;
  for( var i = 1; i<len; i++){
    if ($('.rowtext').length != 1) { $('.rowtext:last').remove();}
  }
  len = $('.rowlist').length;
  for( var i = 1; i<len; i++){
    if ($('.rowlist').length != 1) { $('.rowlist:last').remove();}
  }
  console.log(productatributeset)
  if ($('#productatributeset').val() != null){
    productatributeset = $('#productatributeset').val()
  }
  $.ajax({
    url: "<?php echo base_url();?>master/get_atribute_set_detail",
    type : 'GET',
    data : 'id=' + productatributeset,
    dataType : 'json',
    success : function (response) {
      var len = response.length;
      for( var i = 0; i<len; i++){
        if (response[i]['ProductAtributeType'] === "text") {
          $(".rowtext:first .atributeid").val(response[i]['ProductAtributeID']);
          $(".rowtext:first .atributetype").val(response[i]['ProductAtributeName']);
          $(".rowtext:first").clone().insertBefore('#atributelabel');
        } else {
          $(".rowlist:first .atributeid").val(response[i]['ProductAtributeID']);
          $(".rowlist:first .atributetype").val(response[i]['ProductAtributeName']);
          valuecode = response[i]['valuecode'].split(",");
          valuename = response[i]['valuename'].split(",");
          $(".rowlist:first .atributevalue").empty();
          
          var codelen = valuename.length;
          for( var x = 0; x<codelen; x++){
            $(".rowlist:first .atributevalue").append("<option value='"+valuecode[x]+"'>"+valuename[x]+"</option>");
          }
          $(".rowlist:first").clone().insertBefore('#atributelabel'); 
        }
      }
    }
  })
}
function generate() {
  $("#productname").val("")
  $("#productcode").val("")
  productid = $("#productid").val()
  nameformula = $("#nameformula").val()
  codeformula = $("#codeformula").val()
  categorycode = $("#categorycode").val()
  categoryname = $("#categoryname").val()
  brandcode = $("#brandcode").val()
  brandname = $("#brandname").val()
  statusquality = $("#statusquality option:selected").text()
  productdescription = $("#productdescription").val()

  atributetype = []
  atributecode = []
  atributename = []
  $(".atributetype").each(function() {
    atributetype.push($(this).val())
  });
  $(".atributevalue").each(function() {
    atributecode.push($(this).val())
    if( $(this).prop('type') != 'text' ) { 
      atributename.push($("option:selected", this).text())
    } else {
      atributename.push($(this).val())
    }
  });

  $.ajax({
    url: "<?php echo base_url();?>master/generatenamecode",
    type : 'POST',
    data : { 
            productid : productid,
            codeformula : codeformula,
            nameformula : nameformula,
            categorycode : categorycode,
            categoryname : categoryname,
            brandcode : brandcode,
            brandname : brandname,
            atributename : atributename,
            atributecode : atributecode,
            atributetype : atributetype,
            statusquality : statusquality,
            productdescription : productdescription
          },
    dataType : 'json',
    success : function (response) {
      $("#productcode").val(response[0])
      $("#productname").val(response[1])
      $("#productsuppliername").val(response[1])
    }
  })
}


function readimage(input) {
  if (input.files && input.files[0]) {
    var ext = $(input).val().split('.').pop().toLowerCase(); //get file type
    if (input.files[0].size <= 2000000) { // cek if >2mb
      // if ( $.inArray(ext, ['jpg','jpeg']) >= 0) { // cek if not in list

      // } else {
      //   alert("type file tidak sesuai!!!");
      //   $(input).val(null);
      // }
    } else {
      alert("file melebihi 2MB !!!");
      $(input).val(null);
    }
  }
}
function readpdf(input) {
  if (input.files && input.files[0]) {
    var ext = $(input).val().split('.').pop().toLowerCase(); //get file type
    if (input.files[0].size <= 3000000) { // cek if >2mb
      if ( $.inArray(ext, ['pdf']) >= 0) { // cek if not in list
        
      } else {
        alert("type file tidak sesuai!!!");
        $(input).val(null);
      }
    } else {
      alert("file melebihi 3MB !!!");
      $(input).val(null);
    }
  }
}
function duplicatefileU() { 
  $(".formFile:last").clone().insertAfter(".formFile:last"); 
  $(".formFile:last input").val("")
}
j8('.fileN').live('change',function(){
    fileName = j8(this).val();
    par = j8(this).parent().parent().parent()
    if (fileName != "") {
      par.find(".fileT").attr("required", true)
    } else {
      par.find(".fileT").attr("required", false)
    }
});
j8('.fileT').live('change',function(){
    fileType = j8(this).val();
    par = j8(this).parent().parent()
    if (fileType != "") {
      par.find(".fileN").attr("required", true)
    } else {
      par.find(".fileN").attr("required", false)
    }
});

j8("#form").submit(function(e) {
  if (j8('#form .rowtext').length < 1) {
    e.preventDefault();
    alert("List Produk Kosong!")
    return false
  }
  if ($('#productatributeset').val() == 0) {
    e.preventDefault();
    alert("Atribute Set kosong set Kosong !")
    return false
  }
});
j8('#stockable').change(function() {
  if($(this).is(":checked")) {
    $('#max').attr('readonly', false).val("0")
    $('#min').attr('readonly', false).val("0")
  } else {
    $('#max').attr('readonly', true).val("0")
    $('#min').attr('readonly', true).val("0")
  }
});
j8('#forsale[0]').change(function() {
   if($(this).is(":checked")) {
    $('#persen').attr('readonly', true).val("0")
    $('#hpp').attr('readonly', true).val("0")
   } else {
    $('#persen').attr('readonly', false).val("1")
    $('#hpp').attr('readonly', false).val("1")
   }
});
// j8('#active').change(function(){
//   var lastSel = $("#active option:selected");
//   alert(lastSel)
//   if($('#stockAll').val() != 0) {
//     lastSel.prop("selected", true);
//   }
// });
j8("#cek_code").on('click', function() {
  productcode = $('#productcode').val()
  $.ajax({
    url: "<?php echo base_url();?>master/cek_product_code",
    type : 'POST',
    data: {productcode: productcode},
    dataType : 'json',
    success : function (response) {
      len = response.length;
      note = ""
      if (len>0) {
        note += "Product Code sama dengan Product ID berikut :\n"
        for( var i = 0; i<len; i++){
          note += "-> "+response[i]['ProductID']+", "+response[i]['ProductCode']+"\n"
        }
        alert(note)
      } else {
        alert("tidak sama dengan Product ID manapun.")
      }
    }
  })
});

function clone(){
  var url = window.location.href;
  window.open(url+'&clone=1', '_blank');
  window.top.close();
}


// all about popUp product list
var popup_product_list = null;
j8("#open_popup").on('click', function() {
  popup_product_list = window.open('<?php echo base_url();?>general/product_list_popup', '_blank', 'width=800,height=500,left=200,top=100');
});
var currawlist = []
function buildcurrawlist() {
  currawlist = []
  par = $(".rawcomponent select")
  for (var i = 1; i < par.length; i++) {
    currawlist.push($(par[i]).val())
  }
}
function ProcessChildMessage(message) {
  buildcurrawlist()
  if (typeof message !== 'undefined' && message.length > 0) {
    for( var i = 0; i<message.length; i++){
      if ($.inArray(message[i]['tdid'], currawlist) < 0) {  //cek jika product exist in list
        addraw(message[i]['tdid'], message[i]['tdname']);
      }
    }
  }
}
// ===========================

</script>