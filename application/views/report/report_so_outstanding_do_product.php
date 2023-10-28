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
  
  #divhideshow, #divfilterCol, .divfilterdate {
    margin: 5px 0px;
    display: none; 
    border: 1px solid #0073b7; 
    padding: 4px;
    overflow: auto;
  }
  .rowlist, .rowtext { margin-top: 6px; }
  .martop-4 { margin-top: 4px; }

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
  
  .Late { background: #ffd28b !important; }
  .tooLate { background: #ffc9c1 !important; }
  .Ready { background: #73ba76e0 !important; }
  .NotReady { background: #ffc9c1 !important; }
  .Partial { background: #f2ff6c !important; }
  td.note {
    min-width: 170px !important;
    white-space: normal !important;
  }
</style>

<?php $warehouse = $content['warehouse'];?>
<div class="content-wrapper">
  <div class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row rowtext">
            <div class="col-xs-4">
              <input type="text" class="form-control input-sm atributeid" name="atributeid[]" readonly>
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
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" Gudang="<?php echo $content['main'][0]['Gudang']; ?>" removeTd="1"><i class="fa fa-fw fa-print"></i> Print</button>
        <button class="btn btn-primary btn-xs" id="hideshow" class="hideshow" title="HIDE/SHOW COLUMN">Hide/Show Column</button>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>
        <div id="divhideshow" style="border: 1px solid #0073b7; padding: 5px;">
            Hide/Show Column :
            <button class="toggle-vis btn btn-primary btn-xs" data-column="1">SO Date</button>
            <button class="toggle-vis btn btn-primary btn-xs" data-column="3">Category</button>
            <button class="toggle-vis btn btn-primary btn-xs" data-column="5">ProductID</button>
            <button class="toggle-vis btn btn-primary btn-xs" data-column="9">PShop</button>
            <button class="toggle-vis btn btn-primary btn-xs" data-column="10">Warehouse</button>
            <button class="toggle-vis btn btn-primary btn-xs" data-column="12">Resi</button>
        </div>
        <div class="divfilterdate">
          <form role="form" action="<?php echo current_url();?>" method="post">
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Search</label>
                <span class="left2">
                  <div class="input-group input-group-sm">
                      <select class="form-control input-sm atributelist" style="width: 100%;" name="atributelist" required="">
                        <option value="SOID">SO ID</option>
                        <option value="Company">Customer Name</option>
                      </select>
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-primary add_field" onclick="createattribute();">+</button>
                      </span>
                  </div>
                </span>
                <label id="atributelabel"></label>
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
              <th>SO ID</th>
              <th>SO Date</th>
              <th>Ship Date</th>
              <th>Category</th>
              <th>Customer</th>
              <th>ProductID</th>
              <th>Product Name</th>
              <th>Qty</th>
              <th>Stock</th>
              <th>PShop</th>
              <th>Warehouse</th>
              <th>Invoice MP</th>
              <th>Resi</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
            // echo count($content);
            if (isset($content['main'])) {
                foreach ($content['main'] as $row => $list) { 
                  $stockReady = ($list['ProductQty'] <= $list['stock']) ? 'Ready' : 'NotReady';
                  // $ShipAddress  = explode(";",$list['ShipAddress']);
          ?>
                <tr>
                  <td class="alignCenter"><?php echo $list['SOID'];?></td>
                  <td class="alignCenter"><?php echo $list['SODate'];?></td>
                  <td class="alignCenter"><?php echo $list['SOShipDate'];?></td>
                  <td class="alignLeft"><?php echo $list['CategoryName'];?></td>
                  <td><?php echo $list['Company2'];?></td>
                  <td class="alignCenter"><?php echo $list['ProductID'];?></td>
                  <td class="note"><?php echo $list['ProductName'];?></td>
                  <td class="alignRight"><?php echo $list['ProductQty'];?></td>
                  <td class="alignRight <?php echo $stockReady;?>"><?php echo $list['stock'];?></td>
                  <td><?php echo $list['PSHOP'];?></td>
                  <td class="warehouse"><?php echo $list['Gudang'];?></td>
                  <td class="note"><?php echo $list['INVMP'];?></td>
                  <td><?php echo $list['ResiNo'];?></td>
                  <td>
                    <?php echo "(".$list['PaymentWay'].") ";?>
                    <button type="button" class="btn btn-primary btn-xs detail" title="DETAIL" data-toggle="modal" data-target="#modal-detail" soid="<?php echo $list['SOID']; ?>"><i class="fa fa-fw fa-search"></i></button>
                  </td>
                </tr>
          <?php } } ?>
          </tbody> 
        </table>
      </div>
    </div>

    <div class="modal fade" id="modal-detail">
      <div class="modal-dialog modal-lg">
        <div class="modal-content" style="width:1100px">
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
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
	 
  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
    
    "order": [[0,'asc']],
    "scrollX": true,
     "scrollY": true,
    "scrollCollapse": true,
    "fixedColumns": {
        leftColumns: 1,
        rightColumns: 1
    },
  })
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
  setTimeout( 
    function order() {
      $('button[data-column="9"]').click();
      $('button[data-column="10"]').click();
    }
  , 100) //force to order and fix header width
  $("#hideshow").click(function(){
    $("#divhideshow").slideToggle();
  });
  $(".filterdate").click(function(){
    $(".divfilterdate").slideToggle();
  });
  $('.detail').live('click',function(e){
      soid = $(this).attr("soid");
      $('.loader').slideDown("fast")
      $('#detailcontentAjax').empty()
      get(soid)
  });

  function get(id) {
    xmlHttp=GetXmlHttpObject()
      var url="<?php echo base_url();?>report/report_so_detail"
      url=url+"?id="+id
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
  function openPopupOneAtATime2(x) {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>transaction/sales_order_print_no?so='+x;
      } else {
         popup = window.open('<?php echo base_url();?>transaction/sales_order_print_no?so='+x, '_blank', 'width=800,height=650,left=200,top=20');     
      }
  }
  $(".printso").live('click', function() {
    soid = $(this).attr("soid")
    openPopupOneAtATime(soid);
  });
  $(".printso2").live('click', function() {
    soid = $(this).attr("soid")
    openPopupOneAtATime2(soid);
  });
  $('button.print_dt').on('click', function() {
      var now = Date.now();
      var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      var date = new Date(now);
      var fvData = table.rows({ search:'applied', page: 'all' }).data(); 
      var warehouse = $(this).attr("Gudang");
      $('.div_dt_print').empty().append(
         '<table id="dtTablePrint" class="col">' +
         '<thead>'+
         '<tr>'+
            '<td colspan=11><h2>PICKING LIST - FULFILLMENT CENTER: '+ warehouse +' - '+ date.toLocaleDateString("en-US", options)+' '+ date.toLocaleTimeString()+'</h2></td>'+
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
         '<tr>'+
         '<td><h4 class="footer"></h4></td>'+'<td></td>'+
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
      $(w.document.body).append("<style type='text/css'>h2, table {font-family:Calibri !important;} .footer{font-family:Calibri !important; text-align: center; } h4::after {counter-increment: section; content: 'Page ' counter(section);}</style>");
      $(w.document.body).append(html);
  });
});

function createattribute() {
  atributelist = $(".atributelist").val()
  $(".rowtext:first .atributeid").val(atributelist);
  $(".rowtext:first").clone().insertBefore('#atributelabel');
}

</script>