<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css">
  .addproduct_category, .edit, .naming {
    margin: 10px;
    background-color: #0073b7;
    color: white;
    padding: 2px 5px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    font-weight: bold;
  }
  .rowcode .col-xs-2,
  .rowname .col-xs-2 {
    padding-left: 5px !important;
    padding-right: 5px !important;
  }
  .rowcode .col-xs-2 .form-control input-sm,
  .rowname .col-xs-2 .form-control input-sm {
    padding: 6px 4px !important;
  }
  .judul h5 { word-break: break-word; }
</style>
<?php 
// print_r($content); 
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
      <div class="box-header">
        
      </div>
      <div class="box-body">
        <form role="form" action="<?php echo base_url();?>master/productnamingformula_act" method="post" class="form-productnamingformula_act" >
            <div class="box box-solid ">
              <div class="box-header">
                <h3 class="box-title">Add Product Category</h3>
                <button type="submit" class="btn btn-primary pull-right" title="SUBMIT">Submit</button>
                <button class="btn btn-primary pull-right" style="margin-right: 5px;" title="GENERATE" onclick="generate(); return false;">Generate</button>
              </div>
              <div class="box-body">
                <div class="col-md-6 judul">
                  <h5>CURRENT - Product Name&emsp;&emsp;&emsp;&emsp;: 
                  <input type="hidden" class="form-control input-sm" name="id" readonly="" value="<?php echo $content['main']['ProductCategoryID'];?>">
                  <b><?php echo $content['main']['ProductCategoryName'];?></b></h5>
                  <h5>CURRENT - Product Code Formula&ensp;:<br><b> <?php echo $content['main']['ProductCodeFormula'];?></b></h5>
                  <h5>CURRENT - Product Name Formula :<br><b> <?php echo $content['main']['ProductNameFormula'];?></b></h5>
                </div>
                <div class="col-md-6 judul">
                  <h5>... </h5>
                  <h5>NEW - Product Code Formula : 
                  <input type="text" class="form-control input-sm" name="codeformula" id="codeformula" readonly=""></h5>
                  <h5>NEW - Product Name Formula : 
                  <input type="text" class="form-control input-sm" name="nameformula" id="nameformula" readonly=""></h5>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                  <div class="box box-solid ">
                    <div class="box-header">
                      <h3 class="box-title">Product Code Formula</h3>
                    </div>
                    <div class="box-body">
                      <div class="form-group rowcode">
                        <div class="row">
                          <div class="col-xs-8">
                            <select class="form-control input-sm fieldcode" name="code[]">
                              <?php foreach ($content['contentformula'] as $row => $list) { ?>
                                      <option value="<?php echo $list;?>"><?php echo $list;?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="col-xs-2">
                            <select class="form-control input-sm fieldconnectorcode" name="connectorcode[]">
                              <option value=" ">spasi</option>
                              <option value=",">, (comma)</option>
                              <option value="-">- (minus)</option>
                              <option value="X">X (X)</option>
                            </select>
                          </div>
                          <div class="col-xs-2">
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-primary  btn-sm add_field" onclick="duplicaterowcode();">+</button>
                              <button type="button" class="btn btn-primary  btn-sm add_field" onclick="if ($('.rowcode').length != 1) { $(this).closest('.rowcode').remove();}">-</button>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box box-solid ">
                    <div class="box-header">
                      <h3 class="box-title">Product Name Formula</h3>
                    </div>
                    <div class="box-body">
                      <div class="form-group rowname">
                        <div class="row">
                          <div class="col-xs-8">
                            <select class="form-control input-sm fieldname" name="name[]">
                              <?php foreach ($content['contentformula'] as $row => $list) { ?>
                                      <option value="<?php echo $list;?>"><?php echo $list;?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="col-xs-2">
                            <select class="form-control input-sm fieldconnectorname" name="connectorname[]">
                              <option value=" ">spasi</option>
                              <option value=",">, (comma)</option>
                              <option value="-">- (minus)</option>
                              <option value="X">X (X)</option>
                            </select>
                          </div>
                          <div class="col-xs-2">
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-primary  btn-sm add_field" onclick="duplicaterowname();">+</button>
                              <button type="button" class="btn btn-primary  btn-sm add_field" onclick="if ($('.rowname').length != 1) { $(this).closest('.rowname').remove();}">-</button>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </form>
      </div>
      <div class="box-footer">
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
	 
  $('.fieldname').live('change',function(e){
    $.ajax({
      url: "<?php echo base_url();?>master/fill_category_code",
      type : 'GET',
      data : 'id=' + $(this).val(),
      dataType : 'json',
      success : function (response) {
        console.log(response);
      }
    })
  })

  buildcode()
  buildname()
});
function buildcode() {
  var ProductCodeFormula = "<?php echo $content['main']['ProductCodeFormula'];?>"
        // console.log(ProductCodeFormula);
  var arrayCode = ProductCodeFormula.split(/ |,|-|X/)
  arrayCode.pop()

  var arrayCodeCon = ProductCodeFormula.replace(/[^,-X. ]/g,"").replace(/[0-9]/g,"").split('');
  var keepStr = [ '.' , ',' , ' ' , '-' , 'X'];
  arrayCodeCon = arrayCodeCon.filter(function(val){
    return (keepStr.indexOf(val) > -1 ? true : false)
  })
  for (var i = 0; i < arrayCode.length ; i++) {
    $(".rowcode:last").find(".fieldcode").val(arrayCode[i])
    $(".rowcode:last").find(".fieldconnectorcode").val(arrayCodeCon[i])
    duplicaterowcode()
  }
  if (arrayCode.length > 0) {
    $(".rowcode:last").remove()
  }
}
function buildname() {
  var ProductNameFormula = "<?php echo $content['main']['ProductNameFormula'];?>"
  var arrayName = ProductNameFormula.split(/ |,|-|X/)
  arrayName.pop()

  var arrayNameCon = ProductNameFormula.replace(/[^,-X. ]/g,"").replace(/[0-9]/g,"").split('');
  var keepStr = [ '.' , ',' , ' ' , '-' , 'X'];
  arrayNameCon = arrayNameCon.filter(function(val){
    return (keepStr.indexOf(val) > -1 ? true : false)
  })

  for (var i = 0; i < arrayName.length ; i++) {
    $(".rowname:last").find(".fieldname").val(arrayName[i])
    $(".rowname:last").find(".fieldconnectorname").val(arrayNameCon[i])
    duplicaterowname()
  }
  if (arrayName.length > 0) {
    $(".rowname:last").remove()
  }
}

function duplicaterowcode() { $(".rowcode:last").clone().insertAfter(".rowcode:last"); }
function duplicaterowname() { $(".rowname:last").clone().insertAfter(".rowname:last"); }

function generate() {
  $("#codeformula").val(null)
  $("#nameformula").val(null)
  lencode = $('.fieldcode').length
  lenname = $('.fieldname').length
  for (var i = 0; i < lencode; i++) {
    $("#codeformula").val( $("#codeformula").val() + $('select.fieldcode:eq('+i+')').val() + $('select.fieldconnectorcode:eq('+i+')').val() )
  }
  for (var i = 0; i < lenname; i++) {
    $("#nameformula").val( $("#nameformula").val() + $('select.fieldname:eq('+i+')').val() + $('select.fieldconnectorname:eq('+i+')').val() )
  }
  // $(".code").each(function() {
  //   $("#productcode").val($("#productcode").val()+"-"+$(this).val())
  // });
  // $(".name").each(function() {
  //   if( $(this).prop('type') != 'text' ) { 
  //     $("#productname").val($("#productname").val()+"-"+$("option:selected", this).text())
  //   } else {
  //     $("#productname").val($("#productname").val()+"-"+$(this).val())
  //   }
  // });
  // $("#productcode").val($("#productcode").val().substring(1))
  // $("#productname").val($("#productname").val().substring(1))
}


  $('.form-productnamingformula_act form').live('submit', function() {
      $(this).find(':disabled').removeAttr('disabled');
  });
</script>