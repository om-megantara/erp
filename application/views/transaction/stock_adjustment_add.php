<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">
.table-main{
  font-size: 12px;
  white-space: nowrap;
  border: 1px solid #3c8dbc;
}
.table-main thead tr{
  background: #3c8dbc;
  color: #fff ;
  align-content: center;
}
.table-main tbody tr td { padding: 0px 5px; }
.table-main td:first-child input { max-width: 60px; }

@media (min-width: 768px){
  .form-group label.left {
    float: left;
    padding: 5px 15px 5px 5px;
  }
  .form-group span.left2 {
    display: block;
    overflow: hidden;
  }
}
.martop { margin-top: 5px; }
.adjustment, .note2, .diff { height: 25px; padding: 3px 10px; }
.adjustment, .diff { width: 70px; }
.note2 { width: 300px; display: inline-block; }

#table-main tbody tr {
  display: none;
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
                  <td class="productid2"></td>
                  <td class="productcode"></td>
	                <td class="stock"></td>
	                <td>
                    <input class="productid" name="productid[]" type="hidden" readonly="" required="">
                    <input class="warehouseid" name="warehouseid[]" type="hidden" readonly="" required="">
                    <input class="form-control input-sm adjustment" name="adjustment[]" type="number" value="0" required=""> 
                  </td>
                  <td>
                    <input class="form-control input-sm diff" name="diff[]" value="0" readonly="" required="">
                  </td>
	                <td>
                    <input class="form-control input-sm note2" name="note2[]" type="text" value=" ">
                    <button type="button" class="btn btn-danger btn-xs remove" title="REMOVE"><i class="fa fa-fw fa-times"></i></button>
                  </td>
	            </tr>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="box box-solid">
      <div class="box-body">
          <form name="form" id="form" action="<?php echo base_url();?>transaction/stock_adjustment_add_act" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Warehouse</label>
                <span class="left2">

                  <div class="input-group">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-primary btn-sm" id="open_popup_product">+ Product</button>
                    </div>
                    <select class="form-control input-sm select2 warehouse" style="width: 100%;" name="warehouse" required="">
                      <option value=""></option>
                      <?php foreach ($warehouse as $row => $list) { ?>
                      <option value="<?php echo $list['WarehouseID'];?>"><?php echo $list['WarehouseName'];?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <input type="hidden" class="" id="adjustmentid" name="adjustmentid" required="">
                  <input type="hidden" class="" id="opnameid" name="opnameid" required="" value="0">
                </span>
              </div>
              <div class="form-group">
                <label class="left">Load Excel</label>
                <span class="left2">
                  <div class="input-group input-group-sm">
                    <input class="inputFile fileExcel" name="fileExcel" id="files" type="file" accept=".xls,.xlsx"\>

                    <span class="input-group-btn">
                      <button type="button" class="btn btn-success uploadExcel"><i class="fa fa-fw fa-check"></i></button>
                    </span>
                  </div>
                </span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group martop">
                <label class="left">Date</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm pull-right" id="date" name="date" autocomplete="off" required="">
                </div>
              </div>
              <div class="form-group">
                <label class="left">Note</label>
                <span class="left2">
                  <textarea class="form-control" id="note" name="note" placeholder="note" autocomplete="off"></textarea>
                </span>
              </div>
            </div>
            <div class="col-md-12">
                <center><button type="submit" class="btn btn-primary" >Submit</button></center>
            </div>
            <div class="col-md-12" style="overflow-x:auto; margin-top: 10px;">
              <table class="table table-bordered table-main table-responsive" id="table_main">
                <thead>
                  <tr>
                    <th>Product ID</th>
                    <th>Code</th>
                    <th>Stock</th>
                    <th>Adjustment</th>
                    <th>Difference</th>
                    <th>Note</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </form>
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>tool/fancyTable.min.js"></script>
<script>
var product = [];
var productlist = [];
var fancyTable = 0;

j8 = jQuery.noConflict();
j8( document ).ready(function( $ ) {
	 
	currentdate = new Date();
	j8("#date").datepicker({ autoclose: true, format: 'yyyy-mm-dd'}).datepicker("setDate", currentdate);
  product = $.parseJSON('<?php if ( isset($content['detail2'])){ echo $content['detail2']; }?>');
  if (product!=null) {
    j8("#adjustmentid").val('<?php if ( isset($content['detail2'])){ echo $content['main']['AdjustmentID']; }?>')
    j8("#opnameid").val('<?php if ( isset($content['detail2'])){ echo $content['main']['OpnameID']; }?>')
    j8("#date").datepicker("setDate", '<?php if ( isset($content['detail2'])){ echo $content['main']['AdjustmentDate']; }?>');
    j8("#note").val('<?php if ( isset($content['detail2'])){ echo $content['main']['AdjustmentNote']; }?>')
    j8(".warehouse").val('<?php if ( isset($content['detail2'])){ echo $content['main']['WarehouseID']; }?>')

    fillproduct2(product)
    if (fancyTable<1) {
      init()
    }
  }
})

var popup;
function openPopupOneAtATime(x) {
    if (popup && !popup.closed) {
       popup.close();
       popup = window.open('<?php echo base_url();?>general/product_list_popup_opname2?id='+x,'_blank', 'width=700,height=500,left=200,top=100');     
    } else {
       popup = window.open('<?php echo base_url();?>general/product_list_popup_opname2?id='+x,'_blank', 'width=700,height=500,left=200,top=100');     
    }
}
j8("#open_popup_product").on('click', function() {
  id = j8("#opnameid").val();
  if ( parseInt(id) === 0) {
    alert("Tidak ada Stock Opname Baru.")
  } else {
    openPopupOneAtATime(id);
  }
});
function init() {
  j8("#table_main").fancyTable({
    inputStyle: 'color:black;',
    // sortColumn:0,
    pagination: true,
    perPage:50,
    sortable: false,
    // globalSearch:true
  });
  fancyTable +=1
}
function fillproduct(val) {
  // if (val.length > 0) {
    // for( var i = 0; i<val.length; i++){
      j8(".cellproduct:first .productid").val(val['ProductID']);
      j8(".cellproduct:first .productid2").text(val['ProductID']);
      j8(".cellproduct:first .warehouseid").val(val['WarehouseID']);
      j8(".cellproduct:first .productcode").text(val['ProductCode']);
      j8(".cellproduct:first .stock").text(val['Quantity']);
      j8(".cellproduct:first .adjustment").val('0');
      j8(".cellproduct:first .diff").val('0');
      j8(".cellproduct:first .note2").val("");
      j8(".cellproduct:first").attr('dataproduct',val['ProductID']);
      j8(".cellproduct:first").clone().appendTo('.table-main>tbody');
      // j8(".cellproduct:first input").val("");
    // }
  // }
}
function fillproduct2(val) {
  if (val.length > 0) {
	  for( var i = 0; i<val.length; i++){
      productlist.push(val[i]['ProductID'])
      j8(".cellproduct:first .productid").val(val[i]['ProductID']);
      j8(".cellproduct:first .productid2").text(val[i]['ProductID']);
	    j8(".cellproduct:first .warehouseid").val(val[i]['WarehouseID']);
	    j8(".cellproduct:first .productcode").text(val[i]['ProductCode']);
      j8(".cellproduct:first .stock").text(val[i]['Quantity']);
      j8(".cellproduct:first .adjustment").val(val[i]['OpnameQty']);
      j8(".cellproduct:first .diff").val(val[i]['ProductQty']);
	    j8(".cellproduct:first .note2").val(val[i]['Note']);
	    j8(".cellproduct:first").attr('dataproduct',val[i]['ProductID']);
	    j8(".cellproduct:first").clone().appendTo('.table-main>tbody');
	    // j8(".cellproduct:first input").val("");
	  }
	}
}
j8('.warehouse').change( function() {
  id = j8(this).val()
  j8('.table-main tbody').empty()
  j8("#opnameid").val("0")
  j8.ajax({
    url: "<?php echo base_url();?>transaction/get_opname_detail",
    type : 'POST',
    data: {id: id},
    dataType : 'json',
    success : function (response) {
      if( !("error" in response) ) {
        j8("#opnameid").val(response['OpnameID'])
        productlist = [];
        // fillproduct(response['detail'])
        if (fancyTable<1) {
          init()
        }
      } else {
        alert(response['error'])
      }
    }
  })
});
j8(".adjustment").live('change', function() {
  par   = j8(this).parent().parent();
  stock = par.find(".stock").html()
  adjustment = par.find(this).val()
  par.find(".diff").val(adjustment-stock)
});
j8(".remove").live('click', function() {
  j8(this).closest("tr").remove();
});
j8(".uploadExcel").live('click', function() {
  if ($('#opnameid').val() !== "0") {
      WarehouseID = $('.warehouse').val()
      var fd = new FormData();
      var files = $('.fileExcel')[0].files[0];
      fd.append('excel',files);

      j8.ajax({
          url: "<?php echo base_url();?>transaction/upload_excel_adjustment",
          dataType: 'JSON',
          type: 'post',
          data: fd,
          contentType: false,
          processData: false,
          success: function(response){
 
            for( var i = 0; i<response.length; i++){
              if (response[i]['Adjust'] !== 0) {
                  j8(".cellproduct:first .productid").val(response[i]['ProductID']);
                  j8(".cellproduct:first .productid2").text(response[i]['ProductID']);
                  j8(".cellproduct:first .warehouseid").val(WarehouseID);
                  j8(".cellproduct:first .productcode").text(response[i]['ProductCode']);
                  j8(".cellproduct:first .stock").text(response[i]['Quantity']);
                  j8(".cellproduct:first .adjustment").val(response[i]['Quantity'] + response[i]['Adjust']);
                  j8(".cellproduct:first .diff").val(response[i]['Adjust']);
                  j8(".cellproduct:first .note2").val("");
                  j8(".cellproduct:first").attr('dataproduct',response[i]['ProductID']);
                  j8(".cellproduct:first").clone().appendTo('.table-main>tbody');
              }
            }
          },
      });
  } else {
    alert("pilih gudang!")
  }
}) 
function ProcessChildMessage(message) {
  if (! productlist.includes(message['ProductID'])) {
    fillproduct(message)
    productlist.push(message['ProductID'])
    // console.log(productlist)
  }
}
j8("#form").submit(function(e) {
    if (j8('.table-main .productid').length < 1) {
      e.preventDefault();
      alert("List Produk Kosong!")
      return false
    }
    j8('.table-main .diff').each(function(){
      diff = j8(this).val();
      if (diff == 0) {
        e.preventDefault();
        alert("Input 'Difference' tidal boleh 0")
        return false
      }
    });
});
</script>