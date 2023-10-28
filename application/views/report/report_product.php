<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">
<style type="text/css"> 
  /*css fixed column*/
  .DTFC_LeftWrapper thead th, .DTFC_RightWrapper thead th,
  .DTFC_LeftWrapper tbody td, .DTFC_RightWrapper tbody td {
    font-size: 12px !important;
  }
  .DTFC_LeftWrapper tbody td, .DTFC_RightWrapper tbody td {
    padding: 4px !important;
    vertical-align: text-top;
    height: 28px;
  }
  /*.DTFC_LeftBodyLiner{overflow-y:unset !important}*/
  /*.DTFC_RightBodyLiner{overflow-y:unset !important}*/
  /*---------------------*/

  .view_file, .view_detail { margin-right: 3px; }

  /*efek load*/
  .loader {
    margin: auto;
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid blue;
    border-bottom: 16px solid blue;
    width: 120px;
    height: 120px;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
  }
  @-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
  }
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  /*-------------------------------*/

  #detailcontentAjax { min-height: 200px; }
  #divhideshow, #divsearch { 
    display: none; 
    /*border-bottom: 1px solid #0073b7; */
    /*padding: 5px;*/
    margin-top: 5px;
    margin-bottom: 5px;
    width: 100%;
  }
  .rowlist, .rowtext { margin-top: 6px; }
  .table-atribute { font-size: 12px !important; }
  .table-atribute td { padding: 4px !important; max-width: 200px;}

@media (min-width: 768px){
  .form-group label.left {
    float: left;
    width: 130px;
    padding: 5px 15px 5px 5px;
  }
  .form-group span.left2 {
    display: block;
    overflow: hidden;
  }
  .form-group { margin-bottom: 10px; }
}
  .radio { display: inline-block !important; margin-left: 10px; }
  .notActive { background: #999999 !important; }
  .max {
    max-width: 200px;
    white-space: normal !important;
    word-break: break-all;
  }
</style>

<?php
$category = $content['category'];
$brand = $content['brand'];
$warehouse = $content['warehouse'];
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
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>
  <section class="content">
    <div class="box box-solid">
      <div class="box-header with-border">
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="1"><i class="fa fa-fw fa-print"></i> Print</button>
        <button class="btn btn-primary btn-xs" id="hideshow" class="hideshow" title="HIDE/SHOW COLUMN">Hide/Show Column</button>
        <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal-atribute" title="ATRIBUTE LIST">Atribute List</button>
        <button class="btn btn-primary btn-xs" id="searchProduct" title=""><i class="fa fa-search"></i> Filter</button>
        
        <div id="divhideshow" style="border: 1px solid #0073b7; padding: 5px;">
            Hide/Show Column :
            <button class="toggle-vis btn btn-primary btn-xs" data-column="2">Name</button>
            <button class="toggle-vis btn btn-primary btn-xs" data-column="3">Code</button>
            <button class="toggle-vis btn btn-primary btn-xs" data-column="4">Stock All</button>
            <button class="toggle-vis btn btn-primary btn-xs" data-column="5">Stock W</button>
            <button class="toggle-vis btn btn-primary btn-xs" data-column="6">Price</button>
            <button class="toggle-vis btn btn-primary btn-xs" data-column="7">PV</button>
            <button class="toggle-vis btn btn-primary btn-xs" data-column="8">Update Time</button>
            <button class="toggle-vis btn btn-primary btn-xs" data-column="9">Status</button>
            <button class="toggle-vis btn btn-primary btn-xs" data-column="10">Supplier Name</button>
            <button class="toggle-vis btn btn-primary btn-xs" data-column="11">Description</button>
            <button class="toggle-vis btn btn-primary btn-xs" data-column="14">Min</button>
            <button class="toggle-vis btn btn-primary btn-xs" data-column="15">Max</button>
        </div>
        <div id="divsearch">
          <div class="col-md-12" style="margin-bottom: 10px; border: 1px solid #0073b7; padding: 5px;">
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Stock</label>
                <span class="left2">
                  <select class="form-control input-sm" style="width: 100%;" name="stock" id="stock" required="">
                    <option value="0">All</option>
                    <option value="STW-NZ">Stock Warehouse - Non Zero</option>
                    <option value="STA-NZ">Stock All - Non Zero</option>
                    <option value="STA-Z">Stock All - Zero</option>
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
              <div class="form-group">
                <label class="left">Warehouse</label>
                <span class="left2">
                  <select class="form-control input-sm" style="width: 100%;" name="warehouse" id="warehouse" required="">
                    <option value="0">Empty</option>
                    <?php foreach ($warehouse as $row => $list) { ?>
                    <option value="<?php echo $list['WarehouseID'];?>"><?php echo $list['WarehouseName'] ;?></option>
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
                <button type="button" id="btn-filter" class="btn btn-primary btn-sm" title="FILTER">Submit</button>
              </center>
            </div>
          </div>
        </div>
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
          <thead>
            <tr>
              <th class=" alignCenter">No</th>
              <th class=" alignCenter">ID</th>
              <th class=" alignCenter">Product Name</th>
              <th class=" alignCenter">Product Code</th>
              <th class=" alignCenter">Stock All</th>
              <th class=" alignCenter">Stock W</th>
              <th class=" alignCenter">Price</th>
              <th class=" alignCenter">PV</th>
              <th class=" alignCenter">Update time</th>
              <th class=" alignCenter">Status</th>
              <th class=" alignCenter">Supplier Name</th>
              <th class=" alignCenter">Description</th>
              <th class=" alignCenter">Category</th>
              <th class=" alignCenter">Brand</th>
              <th class=" alignCenter">Min</th>
              <th class=" alignCenter">Max</th>
              <th></th>
            </tr>
          </thead>
          <tbody></tbody>
          <tfoot>
              <tr>
                  <th style="text-align:right">Total:</th>
                  <th class=" alignCenter"></th>
                  <th class=" alignCenter"></th>
                  <th class=" alignCenter"></th>
                  <th class=" alignCenter"></th>
                  <th class=" alignCenter"></th>
                  <th class=" alignCenter"></th>
                  <th class=" alignCenter"></th>
                  <th class=" alignCenter"></th>
                  <th class=" alignCenter"></th>
                  <th class=" alignCenter"></th>
                  <th class=" alignCenter"></th>
                  <th class=" alignCenter"></th>
                  <th class=" alignCenter"></th>
                  <th class=" alignCenter"></th>
                  <th class=" alignCenter"></th>
                  <th class=" alignCenter"></th>
              </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </section>

  <div class="modal fade" id="modal-detail">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Detail Product</h4>
        </div>
        <div class="modal-body">
          <div class="loader"></div>
          <div id="detailcontentAjax"></div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-atribute">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Atribute List</h4>
        </div>
        <div class="modal-body">
          <table class="table table-bordered table-hover table-atribute" style="background-color: white;">
            <tr>
                <?php 
                if (isset($content)) {
                  $main = $content['atributelist']['main'];
                  $detail = $content['atributelist']['detail'];
                  for ($i=0; $i < count($main) ; $i++) { 
                    if ( ($i>1) && !($i % 2) ){ echo "</tr><tr>"; }
                    echo "<td><b>".$main[$i]['ProductAtributeName']."</b><br>";
                    $ProductAtributeID = $main[$i]['ProductAtributeID'];
                    if (isset($detail[$ProductAtributeID])) {
                      for ($x=0; $x < count($detail[$ProductAtributeID]) ; $x++) {
                        echo $detail[$ProductAtributeID][$x]['ProductAtributeValueName']." - ";
                        echo $detail[$ProductAtributeID][$x]['ProductAtributeValueCode']."<br>";
                      } 
                    }
                    echo "</td>";
                  }
                }  
                ?>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url();?>tool/jquery11.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
var j11 = $.noConflict(true);
j11( document ).ready(function( $ ) {
   
  $('.select2').select2();
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
    "scrollCollapse": true, 
    // "fixedColumns": {
        // leftColumns: 2,
        // rightColumns: 1
    // },
    "columnDefs": [ 
      {"targets": 2, "width": "1%"},
      {"targets": 1, "width": "1%"},
    ],
    "order": [[1,"asc"]],
    "searchDelay": 1000,
    "processing": true, 
    "language": { processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '}, 
    "serverSide": true, 
    "ajax": {
      "url": "<?php echo site_url('report/report_product_list')?>",
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
          data.join = "stock_warehouse";
          data.category = $('#category').val();
          data.brand = $('#brand').val();
          data.warehouse = $('#warehouse').val();
          data.stock = $('#stock').val();

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

          if (localStorage.getItem("parse_report_product_list") !== null) {
            var parseData = JSON.parse(localStorage.getItem("parse_report_product_list"));
            if (parseData['type'] === 'category') {
              data.category = parseData['id']
              $('#category').val(parseData['id']).trigger('change')
            } else {
              data.brand = parseData['id']
              $('#brand').val(parseData['id']).trigger('change')
            }
            localStorage.removeItem('parse_report_product_list');
            initDataTable = false;
            data.initDataTable = false; //3
          }
          if (localStorage.getItem("parse_report_product_general") !== null) {
            var parseData = JSON.parse(localStorage.getItem("parse_report_product_general"));
            type = parseData['type'] 
            value = parseData['value'] 
            for (var i = type.length - 1; i >= 0; i--) {
              data[type[i]].push(value[i]);
            }
            localStorage.removeItem('parse_report_product_general');
            initDataTable = false; //pertama kali running halaman
            data.initDataTable = false;
          }
      },
      complete: function() {
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
            $searchButton = $('<button class="btn btn-flat btn-success ">">')
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
    "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };

        // Total over all pages
        total4 = api
            .column( 4 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        total5 = api
            .column( 5 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        total6 = api
            .column( 6 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        // Total over this page
        pageTotal4 = api
            .column( 4, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        pageTotal5 = api
            .column( 5, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        pageTotal6 = api
            .column( 6, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Update footer
        $( api.column( 4 ).footer() ).html(
            // pageTotal4.toLocaleString(undefined, {minimumFractionDigits: 2}) +
            '('+ total4.toLocaleString(undefined, {minimumFractionDigits: 2}) +')'
        );
        $( api.column( 5 ).footer() ).html(
            // pageTotal5.toLocaleString(undefined, {minimumFractionDigits: 2}) +
            '('+ total5.toLocaleString(undefined, {minimumFractionDigits: 2}) +')'
        );
        $( api.column( 6 ).footer() ).html(
            // pageTotal5.toLocaleString(undefined, {minimumFractionDigits: 2}) +
            '('+ total6.toLocaleString(undefined, {minimumFractionDigits: 2}) +')'
        );
    },
    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
      if ( aData[11] == "notActive"){
            jQuery(nRow).addClass('notActive');
        }               
    },
  })

  $('#btn-filter').click(function(){ //button filter event click
      table.ajax.reload();  //just reload table
  });
  $(document).on('keydown', '.dataTables_filter input', function(e){ //enter to search
    if (e.keyCode == 13) {
      table.search($(this).val()).draw();
      // $("#btn-filter").trigger("click");
    }
  });

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

  $('button.toggle-vis').on( 'click', function (e) {
      e.preventDefault();
      var column = table.column( $(this).attr('data-column') );
      column.visible( ! column.visible() );
      table.columns.adjust().draw();
  } );
  setTimeout( function order() {
    var MenuList = <?php echo json_encode($MenuList) ?>;
      if(MenuList.includes("print_without_header")){
        $('button[data-column="3"]').click();
      } else {
        $('button[data-column="2"]').click();
      }
    $('button[data-column="8"]').click();
    $('button[data-column="9"]').click();
    $('button[data-column="10"]').click();
    $('button[data-column="11"]').click();
    $('button[data-column="14"]').click();
    $('button[data-column="15"]').click();
  }, 100) //force to order and fix header width
  $("#hideshow").click(function(){
    $("#divhideshow").slideToggle();
  });
  $("#searchProduct").click(function(){
    $("#divsearch").slideToggle();
  });
  $('button.print_dt').on('click', function() {               
      var fvData = table.rows({ search:'applied', page: 'all' }).data(); 
      $('.div_dt_print').empty().append(
         '<table id="dtTablePrint" class="col">' +
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

      for (var i = 0; i < $('button.print_dt').attr('removeTd'); i++) {
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
<script>

$('.history').live('click', function(e){
    product   = $(this).attr('product');
    openPopupOneAtATime(product);
});

var popup;
function openPopupOneAtATime(x) {
  if (popup && !popup.closed) {
     popup.focus();
     popup.location.href = '<?php echo base_url();?>transaction/product_stock_history?product='+x;
  } else {
     popup = window.open('<?php echo base_url();?>transaction/product_stock_history?product='+x, '_blank', 'width=850,height=600,left=200,top=20');     
  }
}

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

$('.view_file').live('click', function(e){
  file = $(this).attr('file');
  win = window.open('<?php echo base_url();?>tool/product/'+file, 'view_file', 'width=800,height=600');
  if (win) {
      win.focus();
  } else {
      alert('Please allow popups for this website');
  }
}); 

$('.view_detail').live('click', function(e){
  $('.loader').slideDown("fast")
  $('#detailcontentAjax').empty()
  id = $(this).attr('id');
  get(id);
});

function get(product) {
  xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>report/report_product_detail"
    url=url+"?product="+product
    xmlHttp.onreadystatechange=stateChanged
    xmlHttp.open("GET",url,true)
    xmlHttp.send(null)
}
function stateChanged(){
    if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
        $('.loader').slideUp("fast")
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

</script>