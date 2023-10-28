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
    cursor:pointer;
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
</style>

<?php
// print_r($content['category']);
$category = $content['category'];
$brand = $content['brand'];
if(isset($content['main']['agent'])){
$agent = $content['main']['agent'];
}
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
  <div class="modal fade" id="modal-detail2">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Detail SO</h4>
        </div>
        <div class="modal-body">
          <div class="loader"></div>
          <div id="detailcontentAjax2"></div>
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
                <label class="left">Category</label>
                <span class="left2">
                  <select class="form-control input-sm select2" style="width: 100%;" name="category" id="category">
                    <option value="0">Empty</option>
                    <?php foreach ($category as $row => $list) { ?>
                    <option value="<?php echo $list['ProductCategoryID'];?>"><?php echo $list['ProductCategoryName'] ;?></option>
                    <?php } ?>
                  </select>
                </span>
              </div>
              <div class="form-group">
                <label class="left">Source Agent</label>
                <span class="left2">
                  <select class="form-control input-sm" style="width: 100%;" name="origin" id="origin">
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
                <label class="left">Month Start</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm" autocomplete="off" name="datestart" id="datestart">
                </div>
              </div>
              <div class="form-group">
                <label class="left">Month End</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm" autocomplete="off" name="dateend" id="dateend">
                </div>
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
        <table id="dt_list" class="table table-bordered " style="width: 90% !important;">
          <thead>
            <tr>
              <th class=" alignCenter">ID </th>
              <th class=" alignCenter">Product Name</th>
              <th class=" alignCenter">Stk</th>
              <th class=" alignCenter">STK VAL</th>
              <th class=" alignCenter">Last</th>
              <th class=" alignCenter">DStk<br>Left</th>
              <th class=" alignCenter">QTYSold<br>SO</th>
              <th class=" alignCenter">QTYSold<br>INV</th>
              <th class=" alignCenter">High<br>Price</th>
              <th class=" alignCenter">Low<br>Price</th>
              <th class=" alignCenter">C.<br>Cost</th>
              <th class=" alignCenter">C.<br>Price</th>
              <th class=" alignCenter">A.<br>Price</th>
              <th class=" alignCenter">A.<br>Cost</th>
              <th class=" alignCenter">C.<br>Profit</th>
              <th class=" alignCenter">A.<br>Profit</th>
              <th class=" alignCenter">C.%</th>
              <th class=" alignCenter">A.%</th>
              <th class=" alignCenter">Price<br>Total</th>
              <th class=" alignCenter">Total<br>Profit</th>
              <th class=" alignCenter">Age</th>
              <th class=" alignCenter">A.QTY Sold<br>SO (INV)</th>
              <th class=" alignCenter" style="width: 30px !important;">Category</th>
              <th class=" alignCenter" style="width: 30px !important;">Source</th>
              <th class=" alignCenter">Manager</th>
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
                  <td class="alignleft"><a class="view_detail klik" type="button" product="<?php echo $list['ProductID'];?>" data-toggle="modal" data-target="#modal-detail"><?php echo wordwrap($list['ProductName'],18,"<br>\n");?></a></td>
                  <td class="alignCenter"><?php echo number_format($list['Stok'],0);?></td>
                  <td class="alignCenter"><?php echo number_format($list['STKVAL'],0);?></td>
                  <td class="alignCenter"><?php echo $list['LastOrder'];?></td>
                  <td class="alignCenter"><?php echo number_format($list['DStokLeft'],2);?></td>
                  <td class=" alignCenter"><a class="view_detail2 klik" type="button" product="<?php echo $list['ProductID'];?>" data-toggle="modal" data-target="#modal-detail2"><?php echo number_format($list['QTYSold2'],0);?></a></td>
                  <td class=" alignCenter"><?php echo number_format($list['QTYSold'],0);?></td>
                  <td class="alignRight"><?php echo number_format($list['tertinggi'],0);?></td>
                  <td class=" alignCenter"><?php echo number_format($list['terendah'],0);?></td>
                  <td class=" alignCenter"><?php echo number_format($list['ProductPriceHPP'],2);?></td>
                  <td class=" alignCenter"><?php echo number_format($list['price'],2);?></td>
                  <td class="alignRight"><?php echo number_format($list['APrice'],2);?></td>
                  <td class="alignRight"><?php echo number_format($list['ACost'],2);?></td>
                  <td class="alignRight"><?php echo number_format($list['cprofit'],2);?></td>
                  <td class="alignRight"><?php echo number_format($list['AProfit'],2);?></td>
                  <td class="alignRight"><?php echo number_format($list['cpersen'],2)."%";?></td>
                  <td class="alignRight"><?php echo number_format($list['apersen'],2)."%";?></td>
                  <td class="alignRight"><?php echo number_format($list['totalpenjualan'],2);?></td>
                  <td class="alignRight"><?php echo number_format($list['Profit'],2);?></td>
                  <td class="alignCenter"><?php echo number_format($list['umur'],0);?></td>
                  <td class="alignCenter"><?php echo number_format($list['AQTYSold2'],2)." (".number_format($list['AQTYSold'],2).")";?></td>
                  <td class="alignleft"><?php echo wordwrap($list['ProductCategoryName'],5,"<br>\n");?></td>
                  <td class="alignleft"><?php echo wordwrap($list['SourceAgent'],5,"<br>\n");?></td>
                  <td class="alignleft"><?php echo wordwrap($list['ProductManager'],5,"<br>\n");?></td>
                </tr>
          <?php } } ?>
          </tbody>
          <tfoot>
              <tr>
        
              </tr>
          </tfoot>
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
    // "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "pageLength": <?php echo '1000';?>,
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
    $('.loader').slideDown("fast")
    $('#detailcontentAjax').empty()
    id = $(this).attr('product');
    get(id);
  }); 
  function get(id) {
    xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>report/report_product_kpi_detail"
    url=url+"?product="+id
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
  $('.view_detail2').live('click', function(e){
    $('.loader').slideDown("fast")
    $('#detailcontentAjax2').empty()
    id = $(this).attr('product');
    get2(id);
  }); 
  function get2(id) {
    xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>report/report_product_kpi_so_detail"
    url=url+"?product="+id
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