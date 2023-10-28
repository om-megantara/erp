<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">

<style type="text/css">
  .divfilterdate {
    display: none; 
    margin: 5px 0px;
    border: 1px solid #0073b7; 
    padding: 4px; 
    overflow: auto;
  }
  .klik {
    cursor: pointer;
  }

@media (min-width: 768px){
  .form-group label.left {
    float: left;
    width: 100px;
    padding: 5px 0px 5px 0px;
  }
  .form-group span.left2 {
    display: block;
    overflow: hidden;
  }
  .form-group { margin-bottom: 10px; }
  td.note {
    min-width: 170px !important;
    white-space: normal !important;
  }
}
</style>

<?php
// print_r($content['category']);
$category = $content['category'];
$brand = $content['brand'];
if(isset($content['main']['agent'])){
$agent = $content['main']['agent'];
}
$Persen=$content['main']['persen'][0];

?>

<div class="content-wrapper">
  <div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
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
  <div class="modal fade" id="modal-product">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Detail Product</h4>
          </div>
          <div class="modal-body">
            <div id="detailcontentAjax"></div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>
  <section class="content-header">
    <h1>
      <?php echo $PageTitle.' - '. $MainTitle; ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-fw fa-info-circle" title="HELP"></i>Help</a></li>
    </ol>
  </section>

  <section class="content">
    
    <div class="box box-solid">
      <div class="box-header">
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="1"><i class="fa fa-fw fa-print"></i> Print</button>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>
        <div class="divfilterdate">
          <form role="form" action="<?php echo current_url();?>" method="post" >
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Product ID</label>
                <span class="left2">
                  <input class="form-control input-sm" type="text" name="productid" id="productid"> 
                </span> 
              </div>
              <div class="form-group">
                <label class="left">Product Name</label>
                <span class="left2">
                  <input class="form-control input-sm" type="text" name="productname" id="productname"> 
                </span> 
              </div>
              <div class="form-group">
                <label class="left">Source Agent</label>
                <span class="left2">
                  <select class="form-control input-sm" style="width: 100%;" name="source" id="source">
                      <option value="">All</option>
                      <?php foreach ($agent as $row => $list) { ?>
                        <option value="<?php echo $list['ProductAtributeValueCode'];?>"><?php echo $list['ProductAtributeValueName']?></option>
                      <?php }?>
                  </select>
                </span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Category</label>
                <span class="left2">
                  <select class="form-control input-sm select2" style="width: 100%;" name="category" id="category">
                    <option value="">EMPTY</option>
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
                    <option value="<?php echo $list['ProductBrandID'].'_'.$list['ProductBrandName'];?>"><?php echo $list['ProductBrandName'] ;?></option>
                    <?php } ?>
                  </select>
                </span>
              </div>
            </div> 
            <div class="col-md-12">
              <center>
                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
              </center>
            </div>
          </form>
        </div>
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered " style="width: 100% !important;">
          <thead>
            <tr>
              <th class=" alignCenter">ID </th>
              <th class=" alignCenter">Product Name</th>
              <th class=" alignCenter">Category</th>
              <th class=" alignCenter">Stock</th>
              <th class=" alignCenter">Price</th>
              <th class=" alignCenter">Days <br>To ED</th>
              <th class=" alignCenter">Ready <br> For Sale</th>
              <th class=" alignCenter">Product <br> Manager</th>
              <th class=" alignCenter">Last <br> Order</th>
              <th class=" alignCenter">Last <br> Check</th>
              <th class=" alignCenter"></th>
            </tr>
          </thead>
          <tbody>
          <?php
            // echo count($content);
            if (isset($content['main']['product'])) {
                foreach ($content['main']['product'] as $row => $list) { 
                  ?>
                <tr>
                  <td class=" alignCenter"><?php echo $list['ProductID'];?></td>
                  <td class="alignleft note"><a class="view_detail klik" type="button" product="<?php echo $list['ProductID'];?>" data-toggle="modal" data-target="#modal-detail"><?php echo $list['ProductName'];?></a></td>
                  <td class="alignleft"><?php echo $list['ProductCategoryName'];?></td>
                  <td class="alignCenter"><?php echo number_format($list['Stock'],0);?></td>
                  <td class=" alignCenter"><?php echo number_format($list['ProductPriceDefault'],0);?></td>
                  <td class=" alignCenter"><?php echo $list['ED'];?></td>
                  <td><?php if($list['forSale']=='1'){echo "Yes";}else{echo "No";};?></a></td>
                  <td><?php echo $list['ProductManager'];?></a></td>
                  <td><?php if($list['LO']!=""){echo $list['LO']." Days";}?></a></td>
                  <td><?php if($list['Last']!=""){echo $list['Last']." Days";}?></a></td>
                  <td>
                    <?php if(!empty($list['Screenshot'])){?>
                    <button type="button" class="btn btn-success btn-xs" onclick="window.open('<?php echo base_url();?>assets/Price_Check/<?php echo $list['Screenshot']; ?>', '_blank');" title="Price Check"><i class="fa fa-fw fa-file-image-o"></i>
                    </button>
                    <?php }?>
                    <button type="button" class="btn btn-success btn-xs" onclick="window.open('<?php echo base_url();?>master/price_check_add?ProductID=<?php echo $list['ProductID']; ?>', '_blank');" title="Price Check"><i class="fa fa-tags"></i>
                    </button>
                  </td>
                </tr>
          <?php } } ?>
          </tbody>
        </table>
      </div>
    </div>

  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
jQuery( document ).ready(function( $ ) {

  $('.select2').select2();

  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "order":[],
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
  })

  var cek_dt = function() {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);
  
  $("#datestart").datepicker({
    format: "yyyy-mm-dd",
    viewMode: "months", 
    minViewMode: "months"
  }).on('changeDate', function (selected) {
    var minDate = new Date(selected.date.valueOf());
    $('#dateend').datepicker('setStartDate', minDate);
  });

  $(document).on('keydown', '.dataTables_filter input', function(e){ //enter to search
    if (e.keyCode == 13) {
      table.search($(this).val()).draw();
      // $("#btn-filter").trigger("click");
    }
  });

  $("#dateend").datepicker({
    format: "yyyy-mm-dd",
    viewMode: "months", 
    minViewMode: "months"
  }).on('changeDate', function (selected) {
    var maxDate = new Date(selected.date.valueOf());
    $('#datestart').datepicker('setEndDate', maxDate);
  });

  $(".filterdate").click(function(){
    $(".divfilterdate").slideToggle();
  });

  $('.view_detail').live('click', function(e){
    $('#detailcontentAjax').empty()
    id = $(this).attr('product');
    get(id);
  });
  function get(id) {
    xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>report/get_product_offline_detail"
    url=url+"?a="+id
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
  $('button.print_dt').on('click', function() {
      var persen = <?php echo $content['main']['persen'][0] ?>;
      var now = Date.now();
      var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      var date = new Date(now);
      var fvData = table.rows({ search:'applied', page: 'all' }).data();
      $('.div_dt_print').empty().append(
         '<table id="dtTablePrint" class="col">' +
         '<thead>'+
         '<tr>'+
            '<td colspan=11><h2>PRICE CHECK LIST '+persen+' % | Date:'+ date.toLocaleDateString("en-US", options)+' '+ date.toLocaleTimeString()+'</h2></td>'+
            '<td></td>'+
         '</tr>'+
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
                     return (colvisible) ? "<td class='col"+colindex+" note'>" + $('<div/>').text(rowdata[colindex]).text() + "</td>" : null;
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
      $(w.document.body).append("<style type='text/css'>h2, table {font-family:Calibri !important;} .footer{font-family:Calibri !important; text-align: center; } h4::after {counter-increment: section; content: 'Page ' counter(section);} td.note {max-width: 200px word-wrap: break-word;}</style>");
      $(w.document.body).append(html);
  });
  function createattribute() {
    productid = $(".productid").val()
    $(".rowtext:first .product").val(productid);
    $(".rowtext:first").clone().insertBefore('#productid');
  }
});
</script>