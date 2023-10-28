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

  .insert_data {margin: 2px !important;}
  .view {margin: 0px !important;} 
  tfoot input {
    width: 100%;
    font-size: 12px !important;
    padding: 3px;
    box-sizing: border-box;
  }
  #divhideshow, #divsearch { 
    display: none; 
    /*border-bottom: 1px solid #0073b7; */
    padding: 5px;
    margin-top: 5px;
    margin-bottom: 5px;
    width: 100%;
  }
  .rowlist, .rowtext { margin-top: 6px; }
  
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
  @media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 120px;
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
</style>
<?php 
$category = $content['category'];
$brand = $content['brand'];
?>

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
    <div class="box box-solid">
      <div class="box-header">
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT"><i class="fa fa-fw fa-print"></i> Print</button>
        <a href="#" id="hideshow" class="btn btn-primary btn-xs hideshow" title="HIDE/SHOW COLUMN">Hide/Show Column</a>
        <button class="btn btn-primary btn-xs" id="searchProduct" title=""><i class="fa fa-search"></i> Filter</button>
        
        <div id="divhideshow" style="border: 1px solid #0073b7;">
          Hide/Show Column :
          <a class="btn btn-primary btn-xs toggle-vis" title="ID" data-column="0">ID</a>
          <a class="btn btn-primary btn-xs toggle-vis" title="CODE" data-column="1">Code</a>
          <a class="btn btn-primary btn-xs toggle-vis" title="NAME" data-column="2">Name</a>
          <a class="btn btn-primary btn-xs toggle-vis" title="NAME" data-column="8">StockWarehouse</a>
          <a class="btn btn-primary btn-xs toggle-vis" title="NAME" data-column="9">Description</a>
        </div>
        <div id="divsearch">
          <div class="col-md-12" style="margin-bottom: 10px; border: 1px solid #0073b7; padding: 5px;">
            <div class="col-md-6"> 
              <div class="form-group">
                <label class="left">Stock</label>
                <span class="left2">
                  <select class="form-control input-sm" style="width: 100%;" name="stock" id="stock" required="">
                    <option value="0">All</option>
                    <!-- <option value="STW-NZ">Stock Warehouse - Non Zero</option> -->
                    <option value="STR-NZ">Stock Ready - Non Zero</option>
                    <option value="STA-NZ">Stock All - Non Zero</option>
                  </select>
                </span>
              </div>
              <div class="form-group">
                <label class="left">Category</label>
                <span class="left2">
                  <select class="form-control input-sm select2" style="width: 100%;" name="category" id="category" required="">
                    <option value="0">EMPTY</option>
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
                    <option value="0">EMPTY</option>
                    <?php foreach ($brand as $row => $list) { ?>
                    <option value="<?php echo $list['ProductBrandID'];?>"><?php echo $list['ProductBrandName'] ;?></option>
                    <?php } ?>
                  </select>
                </span>
              </div>
              <div class="form-group">
                <!-- <label class="left">Custom Search</label> -->
                <span class="left2">
                  <input class="form-control input-sm" style="width: 100%;" name="custom_filter" id="custom_filter" type="hidden" value="SSP" required="">
                  </input>
                </span>
              </div> 

              <center style="margin-bottom: 5px;">
                <button type="button" id="btn-filter" class="btn btn-primary btn-sm">Filter</button>
              </center>
            </div>
            <div class="col-md-6"> 

            </div>
          </div>
        </div>
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered nowrap table-hover" width="100%">
          <thead>
            <tr>
              <th>ID</th>
              <th>Code</th>
              <th>Name</th>
              <th>Stock<br>All</th>
              <th>SO<br>Pending</th>
              <th>RAW<br>Pending</th>
              <th>Stock<br>Ready</th>
              <th>SO_Pending<br>NonConfirm</th>
              <th>Stock<br>Warehouse</th>
              <th>Description</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </section>

  <div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Detail</h4>
        </div>
        <div class="modal-body">
          <div class="loader"></div>
          <div id="detailcontentAjax"></div>
        </div>
        <div class="modal-footer"></div>
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
  var table = $('#dt_list')
  .on('preXhr.dt', function ( e, settings, data ) {
    if (settings.jqXHR) settings.jqXHR.abort();
  })
  .DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "order": [],
    "scrollX": true,
     "scrollY": true,
    "scrollCollapse": true,
    // "fixedColumns": {
    //     leftColumns: 1,
    //     rightColumns: 1
    // },
    "columnDefs": [ 
      {"targets": 1, "width": "1%"},
      {"targets": 2, "width": "1%"},
    ],
    "searchDelay": 1000,
    "processing": true, 
    "serverSide": true,
    "language": { processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '}, 
    "ajax": {
      "url": "<?php echo site_url('development/perbaikan_report_product_stock_ready_data')?>",
      "type": "POST",
      beforeSend: function(){
        // Here, manually add the loading message.
        $('#dt_list > tbody').html(
          '<tr class="odd">' +
            '<td valign="top" class="dataTables_empty"><span class="sr-only">Loading...</span></td>' +
          '</tr>'
        );
      },
      "data": function ( data ) {
        data.page = "filter_product2";
        data.category = $('#category').val();
        data.brand = $('#brand').val();
        data.stock = $('#stock').val();
        data.custom_filter = $('#custom_filter').val();
      }
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
    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {                
        if ( aData[19] == "notActive"){
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

  $('a.toggle-vis').on( 'click', function (e) {
      e.preventDefault();
      var column = table.column( $(this).attr('data-column') );
      column.visible( ! column.visible() );
      table.columns.adjust().draw();
  } );

  setTimeout( function order() {
    $('a[data-column="2"]').click();
    $('a[data-column="8"]').click();
    $('a[data-column="9"]').click();
  }, 100) //force to order and fix header width
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
$("#hideshow").click(function(){
  $("#divhideshow").slideToggle();
});
$("#searchProduct").click(function(){
  $("#divsearch").slideToggle();
}); 

$('.history').live('click', function(e){
    product   = $(this).attr('product');
    openPopupOneAtATime(product);
}); 
var popup;
function openPopupOneAtATime(x) {
  if (popup && !popup.closed) {
     popup.focus();
     popup.location.href = '<?php echo base_url();?>report/product_stock_history?product='+x;
  } else {
     popup = window.open('<?php echo base_url();?>report/product_stock_history?product='+x, '_blank', 'width=720,height=650,left=200,top=20');     
  }
}

$('.so').live('click', function(e){
    ProductID  = $(this).attr("id")
    $('.loader').slideDown("fast")
    $('#detailcontentAjax').empty()
    get(ProductID, 'so');
}); 
$('.raw').live('click', function(e){
    ProductID  = $(this).attr("id")
    $('.loader').slideDown("fast")
    $('#detailcontentAjax').empty()
    get(ProductID, 'raw');
}); 
$('.so_pending_non_confirm').live('click', function(e){
    ProductID  = $(this).attr("id")
    $('.loader').slideDown("fast")
    $('#detailcontentAjax').empty()
    get(ProductID, 'so_pending_non_confirm');
});  
function get(product, type) {
  xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>report/product_stock_pending"
    url=url+"?product="+product+"&type="+type
    // alert(url);
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

$('button.detailso').live('click', function(e){
  id  = $(this).attr("detailid")
  $('.detailso2').slideUp("fast")
  if ($('.detailso2[detailid='+id+']').is(':visible')) {
    $('.detailso2[detailid='+id+']').slideUp("fast")
  } else {
    $('.detailso2[detailid='+id+']').slideDown("fast")
  }
});
$('button.detailraw').live('click', function(e){
  id  = $(this).attr("detailid")
  $('.detailraw2').slideUp("fast")
  if ($('.detailraw2[detailid='+id+']').is(':visible')) {
    $('.detailraw2[detailid='+id+']').slideUp("fast")
  } else {
    $('.detailraw2[detailid='+id+']').slideDown("fast")
  }
}); 
</script>