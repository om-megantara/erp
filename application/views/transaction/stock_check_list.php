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
  #detailcontent {
    padding: 10px !important;
    /*background: #3169c6;*/
  }
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

</style>
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
    
    <div class="modal fade" id="modal-note">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="loader"></div>
              <div  class="detailcontentAjax" id="detailcontent"></div>
            </div>
        </div>
      </div>
    </div>

    <div class="box box-solid">
      <div class="box-header">
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="1"><i class="fa fa-fw fa-print"></i> Print</button>
        <a href="<?php echo base_url();?>development/stock_check_add" class="btn btn-primary btn-xs addadjustment">Add Stock Check</a>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>
        <div class="divfilterdate">
          <form role="form" action="<?php echo current_url();?>" method="post" >
            <div class="col-md-6">
                <div class="form-group">
                  <label class="left">Month Start</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control input-sm" autocomplete="off" name="filterstart" id="datestart" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="left">Month End</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control input-sm" autocomplete="off" name="filterend" id="dateend" required="">
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
              <th>ID</th>
              <th>Date</th>
              <th>By</th>
              <th>Note</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          <?php
            if (isset($content)) {
                foreach ($content as $row => $list) { ?>
                <tr>
                  <td><?php echo $list['CheckID'];?></td>
                  <td><?php echo $list['CheckDate'];?></td>
                  <td><?php echo $list['fullname'];?></td>
                  <?php if (empty($list['AdjustmentID'])){ ?>
                    <td><?php echo $list['CheckNote'];?></td>
                  <?php } else { ?>
                    <td><?php echo $list['CheckNote']."   (AdjustmentID ".$list['AdjustmentID'].")";?></td>
                  <?php } ?>
                  <td>
                    <button type="button" class="btn btn-primary btn-xs detail" title="DETAIL" id="<?php echo $list['CheckID']; ?>" data-toggle="modal" data-target="#modal-note"><i class="fa fa-fw fa-search"></i></button>
                      <?php if (empty($list['AdjustmentID']) and $list['isApprove']!=1) { ?>
                      <button type="button" class="btn btn-success btn-xs" title="EDIT" onclick="window.open('<?php echo base_url();?>development/stock_check_add?id=<?php echo $list['CheckID']; ?>', '_blank');"><i class="fa fa-fw fa-edit"></i></button>
                      <button type="button" class="btn btn-success btn-xs approval" title="Approval Submit" CheckID="<?php echo $list['CheckID']; ?>"><i class="fa fa-fw fa-share-square-o"></i></button>
                      <button type="button" class="btn btn-danger btn-xs cancel" title="CANCEL" CheckID="<?php echo $list['CheckID']; ?>"><i class="fa fa-fw fa-trash-o"></i></button>
                    <?php } ?>
                    <?php if ($list['isApprove']==1) { ?>
                      <i class="fa fa-fw fa-check-square-o" style="color: green;" title="CONFIRMED"></i>
                    <?php } ?>
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
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
   

  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
    "order": [[0,'desc']],
    "scrollX": true,
     "scrollY": true,
    "columnDefs": [
      { "width":"60%", "targets":4 }
    ]
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
  
  $("#dateopname").datepicker({ 
    "setDate": new Date(), 
    autoclose: true, 
    format: 'yyyy-mm-dd',
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

  $('.approval').live('click',function(e){
    var
      CheckID = $(this).attr('CheckID');
      data = {CheckID:CheckID};
      var r = confirm("Apa anda yakin ?");
      if (r == true) {
        $.ajax({
          //url: "<?php echo base_url();?>transaction/stock_adjustment_approval_submission",
          url: "<?php echo base_url();?>development/stock_check_approval_submission",
          type : 'POST',
          data : data,
          success : function (response) {
            location.reload();
          }
        })
      }
  });

  $('.cancel').live('click',function(e){
    var
      CheckID = $(this).attr('CheckID');
      data = {CheckID:CheckID};
      var r = confirm("Apa anda yakin akan menghapus?");
      if (r == true) {
        $.ajax({
          // url: "<?php echo base_url();?>transaction/stock_adjustment_cancel",
          url: "<?php echo base_url();?>development/stock_check_cancel",
          type : 'POST',
          data : data,
          success : function (response) {
            location.reload();
          }
        })
      }
  });

  function search_table_detail() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("table_detail");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td");
      tdlength = 3;
      for (x = 0; x < tdlength; x++) {
        if (td[x]) {
          txtValue = td[x].textContent || td[x].innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
            break;
          } else {
            tr[i].style.display = "none";
          }
        }
      }       
    }
  }

  $('.detail').live('click', function(e){
      id    = $(this).attr("id")
      $('.loader').slideDown("fast")
      $('#detailcontent').empty()
      get(id);
  });
  function get(id) {
    xmlHttp=GetXmlHttpObject()
      var url="<?php echo base_url();?>development/stock_check_detail"
      url=url+"?id="+id
      // alert(url);
      xmlHttp.onreadystatechange=stateChanged
      xmlHttp.open("GET",url,true)
      xmlHttp.send(null)
  }
  function stateChanged(){
      if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
        $('.loader').slideUp("fast")
        document.getElementById("detailcontent").innerHTML=xmlHttp.responseText
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