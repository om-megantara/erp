<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/dataTables.checkboxes.css">
<style type="text/css"> 
  #divhideshow, #divsearch, #divexport { 
    display: none; 
    /*border-bottom: 1px solid #0073b7; */
    padding: 5px;
    margin-top: 5px;
    margin-bottom: 5px;
    width: 100%;
  }
  .rowlist, .rowtext { margin-top: 6px; }
  table.dataTable tr th.select-checkbox.selected::after {
      content: "✔";
      margin-top: -11px;
      margin-left: -4px;
      text-align: center;
      text-shadow: rgb(176, 190, 217) 1px 1px, rgb(176, 190, 217) -1px -1px, rgb(176, 190, 217) 1px -1px, rgb(176, 190, 217) -1px 1px;
  }
  @media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 100px;
      padding: 5px 15px 5px 5px;
    }
    .form-group span.left2 {
      display: block;
      overflow: hidden;
    }
    .form-group { margin-bottom: 10px; }
  }
  .radio { display: inline-block !important; margin: 3px 10px !important; }
  .notActive { background: #999999 !important; }
  .div-generate-result > * {
    vertical-align: top !important;
    display: inline-block;
    margin: 10px 10px 0px 0px;
  }
</style>

<?php
$category = $content['category'];
$brand = $content['brand'];
$atribute = $content['atribute'];
?>

<div class="content-wrapper">

  <div class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row rowtext">
            <div class="col-xs-4">
              <input type="hidden" class="form-control input-sm atributeid" name="atributeid[]" readonly>
              <input type="text" class="form-control input-sm atributetype" name="atributetype[]" readonly>
            </div>
            <div class="col-xs-8">
              <div class="input-group input-group-sm">                
                <input type="text" class="form-control input-sm atributevalue" name="atributevalue[]" required="">
                <span class="input-group-btn input-group-atributeConn">
                  <select name="atributeConn[]" class="form-control input-sm atributeConn">
                      <option value="or ">OR</option>
                      <option value="and">AND</option>
                  </select>
                </span>
                <span class="input-group-btn">
                  <button type="button" class="btn btn-primary  add_field" onclick="$(this).closest('.rowtext').remove();">-</button>
                </span>
              </div>
            </div>
          </div>
          <div class="row rowlist">
            <div class="col-xs-4">
              <input type="hidden" class="form-control input-sm atributeid" name="atributeid[]" readonly>
              <input type="text" class="form-control input-sm atributetype" name="atributetype[]" readonly>
            </div>
            <div class="col-xs-8">
              <div class="input-group input-group-sm">
                <select class="form-control input-sm atributevalue" name="atributevalue[]" required>
                  <option value="0">--TOP--</option>
                </select>
                <span class="input-group-btn input-group-atributeConn">
                  <select name="atributeConn[]" class="form-control input-sm atributeConn">
                      <option value="or ">OR</option>
                      <option value="and">AND</option>
                  </select>
                </span>
                <span class="input-group-btn">
                  <button type="button" class="btn btn-primary  add_field" onclick="$(this).closest('.rowlist').remove();">-</button>
                </span>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="content-header">
    <h1>
      <?php echo $PageTitle.' - '. $MainTitle; ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank" title="HELP"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>

  <section class="content">
    <div class="box box-solid">
      <div class="box-header">

        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTdLast="1" removeTdFirst="1"><i class="fa fa-fw fa-print"></i> Print</button>
        <a title="ADD PRODUCT" href="<?php echo base_url();?>master/product_add" id="addProduct" class="btn btn-primary btn-xs addProduct" target="_blank"><b>+</b> Add Product</a>
        <a href="#" id="hideshow" class="btn btn-primary btn-xs hideshow">Hide/Show column</a>
        <a href="#" id="batch_formula" class="btn btn-primary btn-xs check">Batch Edit Formula</a>
        <a href="#" id="batch_detail" class="btn btn-primary btn-xs check">Batch Edit Detail</a>
        <a href="#" id="batch_shop" class="btn btn-primary btn-xs check">Batch Edit SHOP</a>
        <a href="#" id="export_stock_online" class="btn btn-primary btn-xs check">Export Stock Online</a>
        <button class="btn btn-primary btn-xs" id="searchProduct" title=""><i class="fa fa-search"></i> Filter</button>
        <!-- <button class="btn btn-primary btn-xs" id="CopyProductACZ">Copy Product to ACZ</button> -->
        
        <div id="divhideshow" style="border: 1px solid #0073b7;">
          Hide/Show Column :
          <!-- <a class="toggle-vis" data-column="1">ID</a>  -->
          <a class="btn btn-primary btn-xs toggle-vis" data-column="3">Name</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="4">Code</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="5">Price</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="6">Category</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="7">Brand</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="8">Stock</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="9">CodeBar</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="10">Atribute</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="11">Status</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="12">Category Full</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="13">Brand Full</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="14">ModifiedDate</a>
        </div>
        <div id="divsearch">
          <div class="col-md-12" style="margin-bottom: 10px; border: 1px solid #0073b7; padding: 5px;">
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Price</label>
                <span class="left2">
                  <select class="form-control input-sm" style="width: 100%;" name="price" id="price" required="">
                    <option value="A">All</option>
                    <option value="Z">Zero</option>
                    <option value="NZ">Non Zero</option>
                  </select>
                </span>
              </div>
              <div class="form-group">
                <label class="left">Stock</label>
                <span class="left2">
                  <select class="form-control input-sm" style="width: 100%;" name="stock" id="stock" required="">
                    <option value="0">All</option>
                    <option value="1">Non Zero</option>
                    <option value="2">Zero</option>
                  </select>
                </span>
              </div>
              <div class="form-group">
                <label class="left">For Sale</label>
                <span class="left2">
                  <select class="form-control input-sm" style="width: 100%;" name="forSale" id="forSale" required="">
                    <option value="2">All</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                  </select> 
                </span>
              </div>
              <div class="form-group">
                <label class="left">Category</label>
                <span class="left2">
                  <select class="form-control input-sm select2" style="width: 100%;" name="category" id="category" required="">
                    <option value="0">Empty</option>
                    <?php foreach ($category as $row => $list) { ?>
                    <option value="<?php echo $list['ProductCategoryID'];?>"><?php echo $list['ProductCategoryName'] ;?></option>
                    <?php } ?>
                  </select>
                </span>
              </div>
              <div class="form-group">
                <label class="left">Brand</label>
                <span class="left2">
                  <select class="form-control input-sm select2" style="width: 100%;" name="brand" id="brand" required="">
                    <option value="0">Empty</option>
                    <?php foreach ($brand as $row => $list) { ?>
                    <option value="<?php echo $list['ProductBrandID'];?>"><?php echo $list['ProductBrandName'] ;?></option>
                    <?php } ?>
                  </select>
                </span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Atribute List</label>
                <span class="left2">
                  <div class="input-group input-group-sm">
                      <select class="form-control input-sm atributelist" style="width: 100%;" name="atributelist" required="">
                        <option value="ProductID_text">ProductID</option>
                        <?php foreach ($atribute as $row => $list) { ?>
                        <option value="<?php echo $list['ProductAtributeID'].'_'.$list['ProductAtributeType'];?>"><?php echo $list['ProductAtributeName'] ;?></option>
                        <?php } ?>
                      </select>
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-primary  add_field" onclick="createattribute();">+</button>
                      </span>
                  </div>
                </span>
              </div>
              <label id="atributelabel"></label>
            </div>
            <div class="col-md-12">
              <center style="margin-bottom: 5px;">
                <button type="button" id="btn-filter" class="btn btn-primary btn-sm">Submit</button>
              </center>
            </div>
          </div>
        </div>
        <div id="divexport">
          <div class="col-md-12" style="margin-bottom: 10px; border: 1px solid #0073b7; padding: 5px;">
              <form name="form" action="<?php echo base_url();?>master/import_stock_online" method="post" enctype="multipart/form-data" autocomplete="off" target='_blank'> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="InputFile">Upload Excel List</label>
                      <input type="file" id="excel" name="excel" accept=".xls">
                      <p class="help-block"></p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <button type="submit" class="btn btn-xs btn-primary">Submit</button>
                      <a href="<?php echo base_url();?>master/export_stock_online" class="btn btn-success btn-xs" target="_blank"><i class="fa fa-fw fa-cloud-download"></i>Download Stock for Online</a>
                    </div>
                  </div>
              </form>
        </div>
      </div>

      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
              <tr>
                <th></th>
                <th class=" alignCenter">No</th>
                <th class=" alignCenter">ID</th>
                <th class=" alignCenter">Name</th>
                <th class=" alignCenter">Code</th>
                <th class=" alignCenter">Price2</th>
                <th class=" alignCenter">Category</th>
                <th class=" alignCenter">Brand</th>
                <th class=" alignCenter">Stock</th>
                <th class=" alignCenter">CodeBar</th>
                <th class=" alignCenter">Atribute</th>
                <th class=" alignCenter">Status</th>
                <th class=" alignCenter">Category Full</th>
                <th class=" alignCenter">Brand Full</th>
                <th class=" alignCenter">ModifiedDate</th>
                <th></th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
      </div>

    </div>

    <div class="modal fade" id="modal-product">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Detail Product</h4>
          </div>
          <div class="modal-body">
            <div id="detailcontentAjax"></div>
            <div class="div-generate-result">
              <button class="btn btn-xs btn-primary qrcode-generate">Generate QRCode</button>
              <span id="qrcode-result" class="generate-result"></span>
              <button class="btn btn-xs btn-primary barcode-generate">Generate BarCode</button>
              <img id="barcode-result" class="generate-result"/>
            </div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery11.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.checkboxes.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
var j11 = $.noConflict(true);
j11( document ).ready(function( $ ) {
   
  $('.select2').select2();

  var rows_selected = []; // for adding checkbox
  var rows_selected_id = []; // for adding checkbox
  var initDataTable = true; // 1
  var table = $('#dt_list')
  .on('preXhr.dt', function ( e, settings, data ) {
      if (settings.jqXHR) settings.jqXHR.abort();
  })
  .DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
    "scrollX": true,
    "scrollY": true,
    "aaSorting": [],
    "searchDelay": 2000,
    "processing": true, 
    "language": { processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '}, 
    "serverSide": true, 
    "ajax": {
      "url": "<?php echo site_url('master/product_list_data')?>",
      "type": "POST",
      beforeSend: function(){
        // Here, manually add the loading message.
        $('#dt_list > tbody').html(
          '<tr class="odd">' +
            '<td valign="top" class="dataTables_empty" colspan="100%" style="font-size: large;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></td>' +
          '</tr>'
        );
      },
      "data": function ( data ) {
        data.page = "filter_product2";
        data.initDataTable = initDataTable; //3
        data.category = $('#category').val();
        data.brand = $('#brand').val();
        data.price = $('#price').val();
        data.stockAll = $('#stock').val();
        data.forSale = $('#forSale').val();

        <?php if ($this->auth->cek5('manage_product_konsumtif')) { ?>
          data.forSale = 'not';
        <?php } ?>

        data.atributeid = [];
        data.atributevalue = [];
        data.atributeConn = [];
        $("#divsearch .atributeConn").each(function() {
            data.atributeConn.push($(this).val());
        });
        $("#divsearch .atributeid").each(function() {
            data.atributeid.push($(this).val());
        });
        $("#divsearch .atributevalue").each(function() {
            data.atributevalue.push($(this).val());
        });
      },
      complete: function() {
        uncheckAll()
        if (initDataTable === true) {
          $('#dt_list > tbody').html(
            '<tr class="odd">' +
              '<td valign="top" class="dataTables_empty" colspan="100%" style="font-size: large;"><p>Please input keyword in the search box to continue</p></td>' +
            '</tr>'
          );
          initDataTable = false;
        }
      },
    },
    initComplete : function() {
        var input = $('.dataTables_filter input').unbind(),
            self = this.api(),
            $searchButton = $('<button class="btn btn-flat btn-success ">')
                       .html('<i class="fa fa-fw fa-search">')
                       .click(function() {
                          self.search(input.val()).draw();
                       }),
            $clearButton = $('<button class="btn btn-flat btn-danger ">')
                       .html('<i class="fa fa-fw fa-remove">')
                       .click(function() {
                          input.val('');
                          $searchButton.click(); 
                       }) 
        $('.dataTables_filter').append($searchButton, $clearButton);
        $('.dataTables_filter input').attr('title', 'press ENTER for apply search');
    },

    'columnDefs': [
       {  
          'targets': 0,
          'checkboxes': { 'selectRow': true }
       }
    ],
    'select': {
       'style': 'multi'
    },
    fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {                
        if ( aData[11] == "notActive"){
            jQuery(nRow).addClass('notActive');
        }               
    },
  })

  function uncheckAll() {
    table.columns().checkboxes.deselectAll()
  }
  $('#btn-filter').click(function(){ //button filter event click
      table.ajax.reload();  //just reload table
  });
  $(document).on('keydown', '.dataTables_filter input', function(e){ //enter to search
    if (e.keyCode == 13) {
      table.search($(this).val()).draw();
      // $("#btn-filter").trigger("click");
    }
  });
  // Handle form submission event 
  $('#batch_formula').on('click', function(e){
      var rows_selected = table.column(0).checkboxes.selected();
      var rows_selected2 = []
      var data_selected = []
      var valueBefore = ""
      $.each(rows_selected, function(index, rowId){
        rowId = rowId.split('_')[0];
        rowId = rowId - 1

        var valueCurrent = [] 
        valueCurrent.tdid = table.cell( rowId, 2 ).data();
        valueCurrent.category = table.cell( rowId, 6 ).data();
        valueCurrent.atribut = table.cell( rowId, 10 ).data();
        rows_selected2.push(valueCurrent);

        if (valueBefore === "" || valueBefore === valueCurrent.atribut ) {
          data_selected.push(valueCurrent.tdid);
          valueBefore = valueCurrent.atribut
        } else {
          data_selected.length = 0
          // return false
        }

      });

      if (rows_selected2.length === data_selected.length) {
        var win = window.open('<?php echo base_url();?>master/product_cu_batch_formula?data='+data_selected, '_blank');
        win.focus();
      } else {
        // alert("product yg dipilih bukan dari atributSet yg sama, \n tidak dianjurkan jika merubah nilai atribute.")
        alert("The product selected is not from the same Set attribute, \n it's not allowed change the attribute value.")
        // var win = window.open('<?php echo base_url();?>master/product_cu_batch_formula?data='+data_selected, '_blank');
        // win.focus();
      }
  }); 
  $('#batch_detail').on('click', function(e){
      var rows_selected = table.column(0).checkboxes.selected();
      var rows_selected2 = []
      var data_selected = []
      var valueBefore = ""
      $.each(rows_selected, function(index, rowId){
        rowId = rowId.split('_')[1]; 
        data_selected.push(rowId);
      }); 
      var win = window.open('<?php echo base_url();?>master/product_cu_batch_edit?data='+data_selected, '_blank');
      win.focus();
  });  
  $('#batch_shop').on('click', function(e){
      var rows_selected = table.column(0).checkboxes.selected();
      var rows_selected2 = []
      var data_selected = []
      var valueBefore = ""
      $.each(rows_selected, function(index, rowId){
        rowId = rowId.split('_')[1]; 
        data_selected.push(rowId);
      }); 
      var win = window.open('<?php echo base_url();?>master/product_cu_batch_shop?data='+data_selected, '_blank');
      win.focus();
  });  

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);
  
  $('a.toggle-vis').on( 'click', function (e) {
      e.preventDefault();
      var column = table.column( $(this).attr('data-column') );
      column.visible( ! column.visible() );
      table.columns.adjust().draw();
  } );
  var MenuList = <?php echo json_encode($MenuList) ?>;
  setTimeout( function order() {
    if(MenuList.includes("print_without_header")){
      $('a[data-column="4"]').click();

    } else {
      $('a[data-column="3"]').click();
    }
    $('a[data-column="9"]').click();
    $('a[data-column="11"]').click();
    $('a[data-column="12"]').click();
    $('a[data-column="13"]').click();
    $('a[data-column="14"]').click();
  }, 100) //force to order and fix header width

  $(".addProduct").click(function(){
      $(".form-addProduct").slideToggle();
  });

  $('button.print_dt').on('click', function() {               
      var fvData = table.rows({ search:'applied', page: 'all' }).data(); 
      $('.div_dt_print').empty().append(
         '<table id="dtTablePrint" class="col" border="0">' +
         '<thead>'+
         '<tr>'+
            $.map(table.columns().visible(),
                function(colvisible, colindex){
                   return (colvisible) ? "<th>" + $(table.column(colindex).header()).html() + "</th>" : null;
             }).join("") +
         '</tr>'+
         '</thead>'+
         '<tbody>' +
            $.map(fvData, function(rowdata, rowindex){
               return "<tr>" + $.map(table.columns().visible(),
                  function(colvisible, colindex){
                     return (colvisible) ? "<td class='col"+colindex+"'>" + $('<div/>').text(rowdata[colindex]).text() + "</td>" : null;
                  }).join("") + "</tr>";
            }).join("") +
         '</tbody>' +
         '<tfoot>' +
         '<tr>'+
            $.map(table.columns().visible(),
                function(colvisible, colindex){
                   return (colvisible) ? "<th>" + $(table.column(colindex).footer()).html() + "</th>" : null;
             }).join("") +
         '</tr>'+
         '</tfoot></table>'
      );

      for (var i = 0; i < $('button.print_dt').attr('removeTdFirst'); i++) {
        $("#dtTablePrint th:first-child, #dtTablePrint td:first-child").remove();
      }
      for (var i = 0; i < $('button.print_dt').attr('removeTdLast'); i++) {
        $("#dtTablePrint th:last-child, #dtTablePrint td:last-child").remove();
      }

      var w = window.open();
      var html = $(".div_dt_print").html();
      $(w.document.body).append('<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">');
      $(w.document.body).append("<link href='<?php echo base_url();?>tool/dtPrint.css' rel='stylesheet' type='text/css' />");
      $(w.document.body).append(html);
  });
});

</script>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/qrcode.min.js"></script>
<script src="<?php echo base_url();?>tool/JsBarcode.all.min.js"></script>
<script>
$('#view_product').live('click',function(e){
  var
    par = $(this).parent().parent();
    id  = par.find("td:nth-child(3)").html();
    get(id);
});
$('#view_price_history').live('click',function(e){
  var
    par = $(this).parent().parent();
    id  = par.find("td:nth-child(3)").html();
    get2(id);
}); 
$("#hideshow").click(function(){
  $("#divhideshow").slideToggle();
});
$("#searchProduct").click(function(){
  $("#divsearch").slideToggle();
});
$("#export_stock_online").click(function(){
  $("#divexport").slideToggle();
});
function createattribute() {
  atributelist = $(".atributelist").val().split("_")
  atributename = $(".atributelist option:selected").text()
  if (atributelist[1] === "text") {
      $(".rowtext:first .atributeid").val(atributelist[0]);
      $(".rowtext:first .atributetype").val(atributename);
      $(".rowtext:first").clone().insertBefore('#atributelabel');
  } else {
      $.ajax({
        url: "<?php echo base_url();?>general/get_atribute_detail",
        type : 'GET',
        data : 'id=' + atributelist[0],
        dataType : 'json',
        success : function (response) {
          console.log(response)
              $(".rowlist:first .atributeid").val(response['ProductAtributeID']);
              $(".rowlist:first .atributetype").val(response['ProductAtributeName']);
              valuecode = response['valuecode'].split(",");
              valuename = response['valuename'].split(",");
              $(".rowlist:first .atributevalue").empty();
              
              var codelen = valuename.length;
              for( var x = 0; x<codelen; x++){
                $(".rowlist:first .atributevalue").append("<option value='"+valuecode[x]+"'>"+valuename[x]+"</option>");
              }
              $(".rowlist:first").clone().insertBefore('#atributelabel'); 
        }
      })
  }
}
function get(id) {
  xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>master/get_product_detail"
    url=url+"?a="+id
    xmlHttp.onreadystatechange=stateChanged
    xmlHttp.open("GET",url,true)
    xmlHttp.send(null)
}
function get2(id) {
  xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>master/get_product_price_history"
    url=url+"?a="+id
    xmlHttp.onreadystatechange=stateChanged
    xmlHttp.open("GET",url,true)
    xmlHttp.send(null)
}
function stateChanged(){
    if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
        $(".generate-result").slideUp('fast')
        qrcode.makeCode('https://anghauz.com');
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

$('.view_file').live( 'click', function (e) {
    val = $(this).attr("file")
    var myview = window.open('<?php echo base_url();?>tool/product/'+val, 'view_file', 'width=800,height=600');
});

$('#CopyProductACZ').live('click',function(e){
  $("#modal-loading-ajax").modal({
    show: true,
    backdrop: 'static',
    keyboard: false
  });
  $.ajax({
    url: "<?php echo base_url();?>master/CopyProductACZ",
    dataType : 'json',
    success : function (response) {
      $("#modal-loading-ajax").modal('hide');
      alert(response)
    }
  })
})

// all about qecode
var qrcode = new QRCode(document.getElementById('qrcode-result'), {
  width : 100,
  height : 100
});
$(".qrcode-generate").live("click", function (e) {
    text = $('.ProductCodeBar').text()
    qrcode.makeCode(text);
    $("#qrcode-result").slideDown('fast')
});

$(".barcode-generate").live("click", function (e) {
    text = $('.ProductCodeBar').text()
    JsBarcode("#barcode-result", text, {
      format: "EAN13",
      displayValue: true, 
      height: '60'
    });
    $("#barcode-result").slideDown('fast')
});
// ----------------------------------

</script>