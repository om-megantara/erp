<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css"> 
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
  .divfilterdate {
    display: none;
    overflow: auto;
  }
  .divfilterdate, .divuploadata, .divvalue {
    border: 1px solid #0073b7; 
    padding: 4px; 
    margin: 5px 0px;
  }
  .transaction, .transaction2 { margin-top: 2px; }
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
</style>

<?php
$SalesID = $this->session->userdata('SalesID');
?>

<div class="content-wrapper">

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
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER DATE"><i class="fa fa-search"></i> Filter</a>
        
        <div class="divfilterdate">
          <form role="form" action="<?php echo current_url();?>" method="post">
            <div class="col-md-6"> 
              <div class="form-group">
                <label class="left">Customer</label>
                <span class="left2">
                  <select class="form-control customer" name="customer" id="customer"></select>
                </span> 
              </div>
            </div>
            <div class="col-md-6">
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
            <div class="col-md-12" style="text-align: center;">
              <button type="submit" class="btn btn-primary btn-sm">Submit</button>
            </div>
          </form>
        </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
            <tr>
              <th class=" alignCenter">ID</th>
              <th class=" alignCenter"> Transfer Date</th>
              <th class=" alignCenter"> Bank</th>
              <th class=" alignCenter"> Note</th>
              <th class=" alignCenter"> Amount</th>
              <th class=" alignCenter"> Customer</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
                // echo count($content);
                foreach ($content as $row => $list) {
                  if ($list['fullname'] == "") {
                    $list['fullname'] = "Not Confirmed yet";
                  }; ?>
                  <tr>
                    <td class=" alignCenter"><?php echo $list['BankTransactionID'];?></td>
                    <td class=" alignCenter"><?php echo date('Y-m-d', strtotime($list['BankTransactionDate']));?></td>
                    <td><?php echo $list['BankName'];?></td>
                    <td><?php echo $list['BankTransactionNote'];?></td>
                    <td class="alignRight"><?php echo number_format($list['BankTransactionAmount'],2);?></td>
                    <?php 
                      if ($list['DepositCustomer'] == null) { ?>
                      <td style="font-weight: bold; color: #f39c12;"><?php echo "NotYetConfirmed";?></td>
                    <?php } else { ?>
                      <td style="font-weight: bold; color: #00a65a;"><?php echo $list['fullname'];?></td>
                    <?php }  ?>
                    <td>
                        <a href="#" class="btn btn-xs btn-primary" id="viewDetail" deposit="<?php echo $list['DepositID'];?>" data-toggle="modal" data-target="#modal-detail" title="VIEW DEPOSIT DISTRIBUTION"><i class="fa fa-fw fa-info"></i></a>
                    </td>
                  </tr>
            <?php } ?>
        
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
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
var j8 = $.noConflict(true);
j8( document ).ready(function( $ ) {
  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "columnDefs": [ 
    {"targets": 6, "orderable": false, "width": "1%"},
    {"targets": 0, "width": "1%"},
    ],
    // "aaSorting": [],
    "order": [[ 0, "desc" ]],
  })

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
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

j8('#customer').select2({
  placeholder: 'Minimum 4 char, Company',
  minimumInputLength: 4,
  ajax: {
    url: '<?php echo base_url();?>general/search_customer',
    dataType: 'json',
    delay: 1000,
    processResults: function (data) {
      console.log('ok')
      return {
        results: data
      };
    },
    cache: true
  }
});

j8('#viewDetail').live('click',function(e){
    id = $(this).attr('deposit');
    $('.loader').slideDown("fast")
    $('#detailcontentAjax').empty()
    get(id)
});

function get(id) {
  xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>report/report_customer_deposit_detail_full"
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