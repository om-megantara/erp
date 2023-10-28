<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">

<style type="text/css"> 

  #detailcontent { padding: 10px !important; }
  #detailcontent tr td, #detailcontent tr th { font-size: 12px !important; }
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
</style>
<div class="content-wrapper">

  <div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">DETAIL</h4>
          </div>
          <div class="modal-body">
            <div class="detailcontentAjax" id="detailcontent" style="background-color: white;">
              
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
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered " style="width: 100%;">
          <thead>
            <tr>
              <th>RO ID</th>
              <th>SO ID</th>
              <th>Date Schedule</th>
              <th>Employee</th>
              <th>Note</th>
              <th>Quantity</th>
              <th>PO</th>
              <th>DOR</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          <?php
            // echo count($content);
            if (isset($content)) {
                foreach ($content as $row => $list) { ?>
                <tr>
                  <td><?php echo $list['ROID'];?></td>
                  <td><?php echo $list['SOID'];?></td>
                  <td><?php echo $list['RODate'];?></td>
                  <td><?php echo $list['fullname'];?></td>
                  <td><?php echo $list['RONote'];?></td>
                  <td><?php echo $list['qty'];?></td>
                  <td><?php echo $list['qtypo'];?></td>
                  <td><?php echo $list['totaldor'];?></td>
                  <td>
                    <button type="button" class="btn btn-primary btn-xs detail" title="DETAIL" roid="<?php echo $list['ROID'];?>" data-toggle="modal" data-target="#modal-detail"><i class="fa fa-fw fa-reorder"></i></button>
                    <button type="button" class="btn btn-primary btn-xs detailraw" title="DETAIL RAW" roid="<?php echo $list['ROID'];?>" data-toggle="modal" data-target="#modal-detail"><i class="fa fa-fw fa-reorder"></i></button>
                    <button type="button" class="btn btn-primary btn-xs printro" roid="<?php echo $list['ROID'];?>" title="PRINT"><i class="fa fa-fw fa-file-text-o"></i></button>
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
     
    "scrollX": true,
     "scrollY": true,
    "order": [[ 0, "desc" ]]
  })

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

  $('.detail').live('click', function(e){
        roid  = $(this).attr("roid")
        get(roid);
  }); 
  $('.detailraw').live('click', function(e){
        roid  = $(this).attr("roid")
        get2(roid);
  });
  function get(roid) {
    xmlHttp=GetXmlHttpObject()
      document.getElementById("detailcontent").innerHTML='<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
      var url="<?php echo base_url();?>transaction/request_order_detail_full"
      url=url+"?roid="+roid
      // alert(url);
      xmlHttp.onreadystatechange=stateChanged
      xmlHttp.open("GET",url,true)
      xmlHttp.send(null)
  }
  function get2(roid) {
    xmlHttp=GetXmlHttpObject()
      document.getElementById("detailcontent").innerHTML='<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
      var url="<?php echo base_url();?>transaction/request_order_detail_raw_full"
      url=url+"?roid="+roid
      // alert(url);
      xmlHttp.onreadystatechange=stateChanged
      xmlHttp.open("GET",url,true)
      xmlHttp.send(null)
  }
  function stateChanged(){
      if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
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
  $(".printro").live('click', function() {
    roid = $(this).attr("roid")
    openPopupOneAtATime(roid);
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

  var popup;
  function openPopupOneAtATime(x) {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>transaction/request_order_print?ro='+x;
      } else {
         popup = window.open('<?php echo base_url();?>transaction/request_order_print?ro='+x, '_blank', 'width=800,height=650,left=200,top=20');     
      }
  }
  function createattribute() {
    atributelist = $(".atributelist").val()
    $(".rowtext:first .atributeid").val(atributelist);
    $(".rowtext:first").clone().insertBefore('#atributelabel');
  }
</script>