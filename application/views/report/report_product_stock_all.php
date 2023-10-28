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
  .toggle-vis {
    background-color: #0073b7;
    color: white;
    padding: 1px 3px;
    text-align: center;
    text-decoration: none;
    font-size: 12px;
    font-weight: bold;
    cursor: pointer;
  }
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
      width: 100px;
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
      <div class="box-header">
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT"><i class="fa fa-fw fa-print"></i> Print</button>
        <a href="#" id="hideshow" class="btn btn-primary btn-xs hideshow" title="HIDE/SHOW COLUMN">Hide/Show Column</a>
        <button class="btn btn-primary btn-xs" id="searchProduct" title=""><i class="fa fa-search"></i> Filter</button>
        
        <div id="divhideshow" style="border: 1px solid #0073b7;">
          Hide/Show Column :
          <a class="btn btn-primary btn-xs toggle-vis" title="ID" data-column="1">ID</a>
          <a class="btn btn-primary btn-xs toggle-vis" title="CODE" data-column="2">Code</a>
          <a class="btn btn-primary btn-xs toggle-vis" title="NAME" data-column="3">Name</a>
          <a class="btn btn-primary btn-xs toggle-vis" title="QUANTITY" data-column="4">Quality</a>
          <a class="btn btn-primary btn-xs toggle-vis" title="CATEGORY" data-column="5">Category</a>
          <a class="btn btn-primary btn-xs toggle-vis" title="BRAND" data-column="6">Brand</a>
          <a class="btn btn-primary btn-xs toggle-vis" title="STATUS" data-column="19">Status</a>
          <!-- <a class="btn btn-primary btn-xs toggle-vis" data-column="20">a</a> -->
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
                    <option value="STA-Z">Stock All - Zero</option>
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
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered nowrap table-hover" width="100%">
          <thead>
            <tr>
              <th>No</th>
              <th>ID</th>
              <th>Code</th>
              <th>Name</th>
              <th>Quality</th>
              <th>Category</th>
              <th>Brand</th>
              <th>Min</th>
              <th>Max</th>
              <th>Stock</th>
              <th>SO<br>Pending</th>
              <th>RAW<br>Pending</th>
              <th>Ready<br>Stock</th>
              <th>RO<br>Pending</th>
              <th>PO<br>Pending</th>
              <th>Mutation<br>Pending</th>
              <th>Net<br>Stock</th>
              <th>RO<br>Sugestion</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </section>
  <div class="modal fade" id="modal-stock">
    <div class="modal-dialog">
      <center>
        <div class="modal-content" style="width: 55%">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Detail Product Stock</h4>
          </div>
          <div class="modal-body">
            <div id="detailcontentAjax2"></div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </center>
    </div>
  </div>
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
  var initDataTable = true; // 1
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
    "fixedColumns": {
        leftColumns: 2,
        // rightColumns: 1
    },
    "columnDefs": [ 
      {"targets": 1, "width": "1%"},
      {"targets": 2, "width": "1%"},
    ],
    // "aaSorting": [],
    "order":[],
    "searchDelay": 1000,
    "processing": true, 
    "language": { processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '}, 
    "serverSide": true, 
    "ajax": {
      "url": "<?php echo site_url('report/product_stock_list_data')?>",
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
    // $('a[data-column="2"]').click();
    var MenuList = <?php echo json_encode($MenuList) ?>;
      if(MenuList.includes("print_without_header")){
        $('a[data-column="2"]').click();
      } else {
        $('a[data-column="3"]').click();
      }
    $('a[data-column="4"]').click();
    $('a[data-column="5"]').click();
    $('a[data-column="6"]').click();
    $('a[data-column="19"]').click();
    $('a[data-column="20"]').click();
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
$('.ro').live('click', function(e){
    ProductID  = $(this).attr("id")
    $('.loader').slideDown("fast")
    $('#detailcontentAjax').empty()
    get(ProductID, 'ro');
}); 
$('.po').live('click', function(e){
    ProductID  = $(this).attr("id")
    $('.loader').slideDown("fast")
    $('#detailcontentAjax').empty()
    get(ProductID, 'po');
});
$('.mutation').live('click', function(e){
    ProductID  = $(this).attr("id")
    $('.loader').slideDown("fast")
    $('#detailcontentAjax').empty()
    get(ProductID, 'mutation');
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
$('button.detailro').live('click', function(e){
  id  = $(this).attr("detailid")
  $('.detailro2').slideUp("fast")
  if ($('.detailro2[detailid='+id+']').is(':visible')) {
    $('.detailro2[detailid='+id+']').slideUp("fast")
  } else {
    $('.detailro2[detailid='+id+']').slideDown("fast")
  }
});
$('button.detailpo').live('click', function(e){
  id  = $(this).attr("detailid")
  $('.detailpo2').slideUp("fast")
  if ($('.detailpo2[detailid='+id+']').is(':visible')) {
    $('.detailpo2[detailid='+id+']').slideUp("fast")
  } else {
    $('.detailpo2[detailid='+id+']').slideDown("fast")
  }
});
$('button.detailmutation').live('click', function(e){
  id  = $(this).attr("detailid")
  $('.detailmutation2').slideUp("fast")
  if ($('.detailmutation2[detailid='+id+']').is(':visible')) {
    $('.detailmutation2[detailid='+id+']').slideUp("fast")
  } else {
    $('.detailmutation2[detailid='+id+']').slideDown("fast")
  }
});
$('.view_stock').live('click', function(e){
  $('.loader').slideDown("fast")
  $('#detailcontentAjax2').empty()
  id = $(this).attr('id');
  get2(id);
}); 
function get2(product) {
  xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>report/report_product_std_detail"
    url=url+"?product="+product
    xmlHttp.onreadystatechange=stateChanged2
    xmlHttp.open("GET",url,true)
    xmlHttp.send(null)
}
function stateChanged2(){
    if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
        $('.loader').slideUp("fast")
        document.getElementById("detailcontentAjax2").innerHTML=xmlHttp.responseText
    }
} 
</script>