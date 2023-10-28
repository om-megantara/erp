<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">

<style type="text/css">
  .filterdate {
    margin: 5px 0px;
  }
  .divfilterdate {
    border: 1px solid #0073b7; 
    display: none;
    overflow: auto;
    padding: 4px; 
    margin: 5px 0px;
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

  .table-main {
    font-weight: bold;
    color: #fff;
    margin-bottom: 0px;
  }
  .table-main tr td {
    padding: 3px !important;
  }
  .table-responsive {
    margin-bottom: 0px;
  }
</style>

<?php
$main = $content['main'];
?>

<div class="content-wrapper">
  <section class="content">   
    <div class="box box-solid">
      <div class="box-header">
          <div class="alert alert-success table-responsive ">
            <table class="table no-border table-main">
              <tr>
                <td>
                  <h4>CUSTOMER ID / COMPANY </h4>
                </td>
                <td>
                  <h4>: <?php echo $main['CustomerID']." / ".$main['Company'];?></h4>
                </td>
              </tr>
              <tr>
                <td>
                  <h4>FREE / ALLOCATED / PAYED </h4>
                </td>
                <td>
                  <h4>: <?php echo number_format($main['TotalBalance'],2)." / ".number_format($main['TotalAllocation'],2)." / ".number_format($main['TotalPayment'],2);?></h4>
                </td>
              </tr>
              <tr>
                <td>
                  <h4>SO / INVOICE </h4>
                </td>
                <td>
                  <h4>: <?php echo number_format($main['SOTotal'],2)." / ".number_format($main['INVTotal'],2);?></h4>
                </td>
              </tr>
            </table>
          </div>
      </div>
      <div class="box-body">
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT"><i class="fa fa-fw fa-print"></i> Print</button>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>
        <div class="divfilterdate">
          <form role="form" action="<?php echo current_url().'?'.$_SERVER['QUERY_STRING'];?>" method="post">
            <div class="col-md-5">
              <div class="form-group">
                  <label class="left">Start</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar">
                      </i>
                    </div>
                    <input type="text" class="form-control input-sm" autocomplete="off" name="filterstart" id="filterstart">
                  </div>
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                  <label class="left">End</label>
                  <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar">
                        </i>
                      </div>
                      <input type="text" class="form-control input-sm" autocomplete="off" name="filterend" id="filterend">
                  </div>
              </div>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary btn-sm">Submit</button>
            </div>
          </form>
        </div>

        <table id="dt_list" class="table table-bordered " style="width: 100%;">
          <thead>
            <tr>
              <th class=" alignCenter">Deposit ID</th>
              <th class=" alignCenter">Transfer Date</th>
              <th class=" alignCenter">Source</th>
              <th class=" alignCenter">Input By</th>
              <th class=" alignCenter">Amount</th>
              <th class=" alignCenter">Allocation</th>
              <th class=" alignCenter">Payment</th>
              <th class=" alignCenter">Retur</th>
              <th class=" alignCenter">Balance</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
              if (isset($content['detail'])) {
                  foreach ($content['detail'] as $row => $list) { ?>
                  <tr>
                      <td class=" alignCenter"><?php echo $list['DepositID'];?></td>
                      <td class=" alignCenter"><?php echo $list['transferdate'];?></td>
                      <td class=" alignCenter"><?php echo $list['SourceType'];?></td>
                      <td><?php echo $list['fullname'];?></td>
                      <td class="alignRight"><?php echo number_format($list['DepositAmount'],2);?></td>
                      <td class="alignRight"><?php echo number_format($list['TotalAllocation'],2);?></td>
                      <td class="alignRight"><?php echo number_format($list['TotalPayment'],2);?></td>
                      <?php if ($list['TotalRetur'] > 0) { ?>
                        <td class="alignRight" style="color: red;"><?php echo number_format($list['TotalRetur'],2);?></td>
                      <?php } else { ?>
                        <td class="alignRight"><?php echo number_format($list['TotalRetur'],2);?></td>
                      <?php } ?>
                      <td class="alignRight"><?php echo number_format($list['TotalBalance'],2);?></td>
                      <td>
                        <?php if ($list['TotalBalance'] > 0) { ?>
                          <a href="#" class="btn btn-xs btn-primary" id="edit" title="EDIT DEPOSIT DISTRIBUTION"><i class="fa fa-fw fa-edit"></i></a>
                          <a href="#" class="btn btn-xs btn-warning" id="retur" title="RETUR DEPOSIT "><i class="fa fa-fw fa-edit"></i></a>
                        <?php } ?>
                        <a href="#" class="btn btn-xs btn-primary" id="view" data-toggle="modal" data-target="#modal-detail" title="VIEW DEPOSIT DISTRIBUTION"><i class="fa fa-fw fa-info"></i></a>
                      </td>
                  </tr>
            <?php } } ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="modal fade" id="modal-detail">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Detail Deposit</h4>
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
     
    "order": [],
    "scrollX": true,
     "scrollY": true,
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


$('#edit').live('click',function(e){
    par = $(this).parent().parent();
    id  = par.find("td:nth-child(1)").html();
    window.open("<?php echo site_url('finance/customer_deposit_distribution?id=')?>"+id, '_self');
});
$('#retur').live('click',function(e){
    par = $(this).parent().parent();
    id  = par.find("td:nth-child(1)").html();
    window.open("<?php echo site_url('finance/customer_deposit_retur?id=')?>"+id, '_self');
});
$('#view').live('click',function(e){
    par = $(this).parent().parent();
    id  = par.find("td:nth-child(1)").html();
    $('.loader').slideDown("fast")
    $('#detailcontentAjax').empty()
    get(id)
});

function get(id) {
  xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>finance/customer_deposit_detail_full"
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
</script>