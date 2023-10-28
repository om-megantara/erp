<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">
 
<style type="text/css"> 

  /*.DTFC_LeftBodyLiner{overflow-y:unset !important}*/
  /*.DTFC_RightBodyLiner{overflow-y:unset !important}*/
  /*---------------------*/
  .klik {
    cursor:pointer;
  }
  #detailcontent {
    padding: 10px !important;
  }

  /*scroll x on top*/
  /*.dataTables_scrollBody {
      transform:rotateX(180deg);
  }
  .dataTables_scrollBody table {
      transform:rotateX(180deg);
  }*/
  /*---------------------*/
  
  #divhideshow, .divfilterdate {
    display: none; 
    border: 1px solid #0073b7; 
    padding: 4px;
    overflow: auto;
  }
  @media (min-width: 768px){
      .form-group label.left {
        float: left;
        width: 100px;
      }
      .form-group span.left2 {
        display: block;
        overflow: hidden;
      }
      .form-group { margin-bottom: 5px; }
  }
  
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
</style>
<div class="content-wrapper">
<?php 
$category = $content['category'];
$brand = $content['brand'];
if(isset($content['main']['agent'])){
$agent = $content['main']['agent'];
}

?>
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
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="2"><i class="fa fa-fw fa-print"></i> Print</button>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>

        <div class="divfilterdate">
          <form role="form" action="<?php echo current_url();?>" method="post" >
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Category</label>
                <span class="left2">
                  <select class="form-control select2" style="width: 100%;" name="category" id="category">
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
                  <select class="form-control select2" style="width: 100%;" name="brand" id="brand">
                    <option value="0">EMPTY</option>
                    <?php foreach ($brand as $row => $list) { ?>
                    <option value="<?php echo $list['ProductBrandID'];?>"><?php echo $list['ProductBrandName'] ;?></option>
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
                <label class="left">Start</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm" autocomplete="off" name="filterstart" id="filterstart" >
                </div>
              </div>
              <div class="form-group">
                <label class="left">End</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm" autocomplete="off" name="filterend" id="filterend" >
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <center>
                <button type="submit" class="btn btn-primary btn-sm pull-center">Submit</button>
              </center>  
            </div>
          </form>
        </div>

      </div>

      <div class="box-body">
        <table id="dt_list" class="table table-bordered " style="width: 100% !important;">
          <thead>
            <tr>
              <th rowspan=2>P ID</th>
              <th rowspan=2>Product Name</th>
              <th rowspan=2>MIN</th>
              <th rowspan=2>MAX</th>
              <th rowspan=2>PO Pending</th>
              <th rowspan=2>Stock Ready</th>
              <th rowspan=2>Today</th>
              <th colspan=4> Sales Order</th>
            </tr>
            <tr>
              <th>Qty<br>SO/CT</th>
              <th>Qty<br>Display</th>
              <th>Qty<br>Bonus</th>
              <th>Total<br>Quantity</th>
            </tr>
          </thead>
          <tbody>
          <?php
            // echo count($content);
            if (isset($content['main']['product'])) {
                foreach ($content['main']['product'] as $row => $list) {
          ?>
                <tr>
                  <td><?php echo $list['ProductID'];?></td>
                  <td><?php echo wordwrap($list['ProductName'],55,"<br>\n");?></td>
                  <td><?php echo $list['MinStock'];?></td>
                  <td><?php echo $list['MaxStock'];?></td>
                  <td>
                    <?php if ($list['popending'] != 0) {
                      echo $popending = "<button type='button' class='btn btn-flat btn-default btn-xs po' id='".$list['ProductID']."'  data-toggle='modal' data-target='#modal-detail2'>".$list['popending']."</button>";
                      } else { echo "0";}?>
                  </td>
                  <td><?php echo $list['stockReady'];?></td>
                  <td><a class="view_detail klik" type="button" product="<?php echo $list['ProductID'];?>" data-toggle="modal" data-target="#modal-detail"><?php echo $list['SalesDay'];?></a></td>
                  <!-- <td><?php echo $list['ProductCode'];?></td> -->
                  <td><?php echo $list['Sales'];?></td>
                  <td><?php echo $list['Display'];?></td>
                  <td><?php echo $list['Bonus'];?></td>
                  <td><?php echo $list['TotalQty'];?></td>
                </tr>
          <?php } } ?>
          </tbody>
         
        </table>
      </div>
    </div>
    <div class="modal fade" id="modal-detail2">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Detail PO</h4>
          </div>
          <div class="modal-body">
            <div class="loader"></div>
            <div id="detailcontentAjax2"></div>
          </div>
          <div class="modal-footer"></div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-detail">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Detail SO</h4>
          </div>
          <div class="modal-body">
            <div class="loader"></div>
            <div id="detailcontentAjax"></div>
          </div>
          <div class="modal-footer"></div>
        </div>
      </div>
    </div>

  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
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
    "order": [[ 6, "desc" ]]
  })
  var cek_dt = function() {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);
  
  $("#filterstart").datepicker({ 
    "setDate": new Date(), 
    autoclose: true, 
    format: 'yyyy-mm-dd',
    todayBtn:  1,
  }).on('changeDate', function (selected) {
    var minDate = new Date(selected.date.valueOf());
    $('#filterend').datepicker('setStartDate', minDate);
  });
  $("#filterend").datepicker({ 
    "setDate": new Date(), 
    autoclose: true, 
    format: 'yyyy-mm-dd',
  }).on('changeDate', function (selected) {
    var maxDate = new Date(selected.date.valueOf());
    $('#filterstart').datepicker('setEndDate', maxDate);
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
    var url="<?php echo base_url();?>report/report_so_product_detail"
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

  var popup;
  function openPopupOneAtATime(x) {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>general/sales_order_print?so='+x;
      } else {
         popup = window.open('<?php echo base_url();?>general/sales_order_print?so='+x, '_blank', 'width=800,height=650,left=200,top=20');     
      }
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
  $('button.detailpo').live('click', function(e){
  id  = $(this).attr("detailid")
  $('.detailpo2').slideUp("fast")
    if ($('.detailpo2[detailid='+id+']').is(':visible')) {
      $('.detailpo2[detailid='+id+']').slideUp("fast")
    } else {
      $('.detailpo2[detailid='+id+']').slideDown("fast")
    }
  });
  $('.po').live('click', function(e){
    ProductID  = $(this).attr("id")
    $('.loader').slideDown("fast")
    $('#detailcontentAjax2').empty()
    get2(ProductID, 'po');
  });

  function get2(product, type) {
    xmlHttp=GetXmlHttpObject()
      var url="<?php echo base_url();?>report/product_stock_pending"
      url=url+"?product="+product+"&type="+type
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
});

</script>