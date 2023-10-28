<style type="text/css">
	table tr td, table tr th {white-space: nowrap; padding: 4px;}
	#codeformula, #nameformula, #productcategory, 
	#categorycode, #categoryname, #productbrand, 
  #brandcode, #brandname { margin-top: 5px; padding: 4px !important;}
	table tr td input, table tr td select { padding: 4px !important; font-size: 12px; min-width: 100px ;}
</style>
<?php
// print_r($productdetail['main2']);
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
          <div class="modal-body" id="detaildata">
            <div class="form-group rowtext" style="display: none;">
                <input type="hidden" class="form-control atributeid" name="atributeid[]" readonly="">
                <input type="hidden" class="form-control atributetype" name="atributetype[]" readonly="">
                <input type="text" class="form-control atributevalue" name="atributevalue[]" required="">
            </div>
            <div class="form-group rowlist" style="display: none;">
                <input type="hidden" class="form-control atributeid" name="atributeid[]" readonly="">
                <input type="hidden" class="form-control atributetype" name="atributetype[]" readonly="">
                <select class="form-control atributevalue" name="atributevalue[]" required="">
                  <option value="0">--TOP--</option>
                </select>
            </div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>

		<div class="box">
      <form role="form" class="form-edit" action="<?php echo base_url();?>master/product_cu_batch_act" method="post" >
    		<div class="box-header with-border">
          <div class="col-md-12 form-formadd with-border">
              <div class="box box-primary ">
      					<div class="box-header">
                    <button type="submit" class="btn btn-primary pull-right">Submit</button>
                    <button type="button" class="btn btn-primary pull-right" onclick="generate(); return false;" style="margin-right: 5px;">Generate Name & Code</button>
      					</div>
                <div class="box-body">
    							<div class="col-md-6">
    							  <div class="form-group">
                      <label>Product Category</label>
                      <select class="form-control" name="productcategory" id="productcategory">
                        <option value="0">--TOP--</option>
                        <?php foreach ($productcategory as $row => $list) { ?>
                          <option value="<?php echo $list['ProductCategoryID'];?>"><?php echo $list['ProductCategoryName'];?></option>
                        <?php } ?>
                      </select>
                      <div class="row">
                        <div class="col-xs-12">
                          <input type="text" class="form-control code" placeholder="Category Code" autocomplete="off" name="categorycode" id="categorycode" readonly="">
                        </div>
                      </div>
                      <div class="row ">
                        <div class="col-xs-12">
                          <input type="text" class="form-control name" placeholder="Category Name" autocomplete="off" name="categoryname" id="categoryname" readonly="">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Product Brand</label>
                      <select class="form-control" name="productbrand" id="productbrand">
                        <option value="0">--TOP--</option>
                        <?php foreach ($productbrand as $row => $list) { ?>
                          <option value="<?php echo $list['ProductBrandID'];?>"><?php echo $list['ProductBrandName'];?></option>
                        <?php } ?>
                      </select>
                      <div class="row">
                        <div class="col-xs-12">
                          <input type="text" class="form-control code" placeholder="Brand Code" autocomplete="off" name="brandcode" id="brandcode" readonly="">
                        </div>
                      </div>
                      <div class="row ">
                        <div class="col-xs-12">
                          <input type="text" class="form-control name" placeholder="Brand Name" autocomplete="off" name="brandname" id="brandname" readonly="">
                        </div>
                      </div>
                    </div>
    							</div>
    							<div class="col-md-6">
    								<div class="form-group">
    								    <label>Name & Code formula </label>
    								    <input type="text" class="form-control" id="codeformula" readonly="" placeholder="Code Formula">
    								    <input type="text" class="form-control" id="nameformula" readonly="" placeholder="Name Formula">
    								</div>
    								<div class="form-group customborder">
    								    <label>Product Atribute Set</label>
    								    <select class="form-control" name="productatributeset" id="productatributeset" onchange="build_atribute();">
    								      <option value="0">--TOP--</option>
    								    </select><br>
    								</div>
    							</div>
            		</div>
              </div>
          </div>
    		</div>
    		<div class="box-body " style="overflow-x: auto;">
    		  <table class="table table-responsive table-bordered" style="width:auto; font-size: 14px;">
    		  	<thead>
    		  		<tr>
    			      <th>ID</th>
    			      <th>Product Code</th>
    			      <th>Product Name</th>
                <th>Product Description</th>
    			      <th>Product Quality</th>
    			    </tr>
    		  	</thead>
    		  	<tbody>
    		  		<tr>
    		  		<td><input type="text" class="form-control productid" placeholder="Product ID" name="productid[]" readonly="" width="20"></td>
    		  		<td><input type="text" class="form-control productcode" placeholder="Product Code" name="productcode[]" readonly=""></td>
    		  		<td><input type="text" class="form-control productname" placeholder="Product Name" name="productname[]" readonly=""></td>
              <td><input type="text" class="form-control productdescription" placeholder="Product Description" name="productdescription[]" required=""></td>
    		  		<td><select class="form-control statusquality" name="statusquality[]"></select></td>
    		  		</tr>
    		  	</tbody>
    		  </table>
    		</div>
      </form>

			<div class="box-footer clearfix">
			</div>
		</div>
	</section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script>
j8  = jQuery.noConflict();
var productdetail
var productatribute
j8( document ).ready(function( $ ) {
   
  fill_atribute_set();
  $("input").keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
  
  $("#productcategory").val('<?php if ( isset($productdetail)){ echo $productdetail['main']['0']['ProductCategoryID']; }?>');
  $("#productcategory").trigger('change');
  $("#productbrand").val('<?php if ( isset($productdetail)){ echo $productdetail['main']['0']['ProductBrandID']; }?>');
  $("#productbrand").trigger('change');
  $('#productatributeset').prop('disabled', true)
  $('#productcategory').prop('disabled', true)
  productdetail = $.parseJSON('<?php if ( isset($productdetail['main2'])){ echo $productdetail['main2']; }?>');
  productatribute = $.parseJSON('<?php if ( isset($productdetail['atribute2'])){ echo $productdetail['atribute2']; }?>');
  setTimeout( function order() {
    addlist()
    $('table tbody tr:first-child').remove()
  }, 3000)
  setTimeout( function order() {
    addatribute()
    fill_statusquality();
  }, 5000)
});
function addlist() {
	par 	= $('table tbody tr:first-child')
	for (var i = 0; i < productdetail.length; i++) {
    par.find(".statusquality").empty().append("<option value='"+productdetail[i]['ProductStatusID']+"'>"+productdetail[i]['ProductStatusName']+"</option>");
    par.find(".productid").val(productdetail[i]['ProductID'])
    par.find(".productcode").val(productdetail[i]['ProductCode'])
    par.find(".productname").val(productdetail[i]['ProductName'])
    par.find(".productcode").css('width',par.find(".productcode").val().length * 8)
    par.find(".productname").css('width',par.find(".productname").val().length * 8)
    par.find(".productdescription").val(productdetail[i]['ProductDescription'])
    $('table tbody tr:first-child').clone().insertAfter('table tbody tr:first-child');
	}
}
function addatribute() {
  $('table tbody').find('tr').each(function (i, el) {
      var pid = $(this).find('.productid').val()
      $(this).find('.atributeid').each(function () {
        var aid = $(this).val()
        $(this).parent().find('.atributevalue').first().val(productatribute[pid][aid])
      }) 
  });
}
j8('#productcategory').live('change',function(e){
  var par   = $(this).parent().find(".code").first()
  var par2  = $(this).parent().find(".name").first()
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
  $.ajax({
    url: "<?php echo base_url();?>master/get_category_aribute_set",
    type : 'GET',
    data : 'id=' + $(this).val(),
    dataType : 'json',
    success : function (response) {
      $('#productatributeset').val(response[0]);
      // $('#codeformula').val(response[1]);
      // $('#nameformula').val(response[2]);
      build_atribute();
    }
  })
})
j8('#productbrand').live('change',function(e){
  var par = $(this).parent().find(".code").first()
  var par2 = $(this).parent().find(".name").first()
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
function fill_statusquality() {
  $.ajax({
    url: '<?php echo base_url();?>master/fill_statusquality',
    type: 'post',
    dataType: 'json',
    success:function(response){
      var len = response.length;
      $('table tbody').find('.statusquality').each(function (i, el) {
          for( var i = 0; i<len; i++){
            var ProductStatusID = response[i]['ProductStatusID'];
            var ProductStatusName = response[i]['ProductStatusName'];
            $(this).append("<option value='"+ProductStatusID+"'>"+ProductStatusName+"</option>");
          }
      });
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
function build_atribute() {
  this
  len = $('.rowtext').length;
  for( var i = 1; i<len; i++){
    if ($('.rowtext').length != 1) { $('.rowtext:last').remove();}
  }
  len = $('.rowlist').length;
  for( var i = 1; i<len; i++){
    if ($('.rowlist').length != 1) { $('.rowlist:last').remove();}
  }
  $.ajax({
    url: "<?php echo base_url();?>master/get_atribute_set_detail",
    type : 'GET',
    data : 'id=' + $('#productatributeset').val(),
    dataType : 'json',
    success : function (response) {
      var len = response.length;
      response = response.reverse();
      // console.log(response)
      for( var i = 0; i<$('thead th').length; i++){
  	    if ($('thead th').length != 5) { $('thead th:last').remove();}
        // $('table tbody').find('tr').each(function (i, el) {
        //   if ($(this + 'td').length != 5) { $(this + 'td:last').remove();}
        // });
        if ($('tbody tr:first-child td').length != 5) { $('tbody tr:first-child td:last').remove();}
  	  }
      for( var i = 0; i<len; i++){
      	$('table thead th:last-child').after('<th>'+response[i]['ProductAtributeName']+'</th>');
      	$('table tbody tr:first-child td:last-child').after('<td></td>');
        if (response[i]['ProductAtributeType'] === "text") {
          $(".rowtext:first .atributeid").val(response[i]['ProductAtributeID']);
          $(".rowtext:first .atributetype").val(response[i]['ProductAtributeName']);
          $(".rowtext:first").clone().appendTo('table tbody tr:first-child td:last-child').css('display','block');;
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
          $(".rowlist:first").clone().appendTo('table tbody tr:first-child td:last-child').css('display','block');;
        }
      }
    }
  })
}
function generate() {
  data_all = []
  $('table tbody').find('tr').each(function (i, el) {
    mainname    = $(this).find(".productname")
    maincode    = $(this).find(".productcode")
    nameformula = $("#nameformula").val()
    codeformula = $("#codeformula").val()
    categorycode  = $("#categorycode").val()
    categoryname  = $("#categoryname").val()
    brandcode     = $("#brandcode").val()
    brandname     = $("#brandname").val()
    statusquality = $(this).find(".statusquality option:selected").text()
    productid     = $(this).find(".productid").val()
    productdescription = $(this).find(".productdescription").val()

    atributetype = []
    atributecode = []
    atributename = []
    atributetype.unshift("", "")
    atributecode.unshift("", "")
    atributename.unshift("", "")
    $(this).find(".atributetype").each(function() {
      atributetype.push($(this).val())
    });
    $(this).find(".atributevalue").each(function() {
      atributecode.push($(this).val())
      if( $(this).prop('type') != 'text' ) { 
        atributename.push($("option:selected", this).text())
      } else {
        atributename.push($(this).val())
      }
    });

    data = {}
    data['productid'] = productid
    data['codeformula'] = codeformula
    data['nameformula'] = nameformula
    data['categorycode'] = categorycode
    data['categoryname'] = categoryname
    data['brandcode'] = brandcode
    data['brandname'] = brandname
    data['atributename'] = atributename
    data['atributecode'] = atributecode
    data['atributetype'] = atributetype
    data['statusquality'] = statusquality
    data['productdescription'] = productdescription
    data_all.push(data)
  });
  // console.log(data_all)
  j8.ajax({
    url: "<?php echo base_url();?>master/generatenamecodebatch",
    type : 'POST',
    data : {data_all:data_all},
    dataType : 'json',
    success : function (response) {
      $('table tbody').find('tr').each(function (i, el) {
        productid = $(this).find(".productid").val()
        mainname = $(this).find(".productname")
        maincode = $(this).find(".productcode")
        maincode.val(response[productid][0])
        mainname.val(response[productid][1])
        maincode.css('width',maincode.val().length * 8)
        mainname.css('width',mainname.val().length * 8)
      });
    }
  })
}
j8('.form-edit').live('submit', function() {
    $(this).find(':disabled').removeAttr('disabled');
    $('#productatributeset').prop('disabled', false)
    $('#productcategory').prop('disabled', false)
    $('table tbody').find('tr').each(function (i, el) {
      productid = $(this).find(".productid").val()
      $(this).find('td input[name!="productid[]"]').each(function (i, el) {
        var name = $(this).attr("name").slice(0, -2)
        if (name === "atributetype" || name === "atributevalue" || name === "atributeid") {
          $(this).attr("name", name + "[" + productid + "][]");
        }
      });
      $(this).find('td select').each(function (i, el) {
        var name = $(this).attr("name").slice(0, -2)
        if (name === "atributetype" || name === "atributevalue" || name === "atributeid") {
          $(this).attr("name", name + "[" + productid + "][]");
        }
      });
    });
});
</script>