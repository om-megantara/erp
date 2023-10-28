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
  .NotReady { background: #fff !important; }
  .Partial { background: #f2ff6c !important; }
</style>
<div class="content-wrapper">
  <div class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row rowtext">
            <div class="input-group input-group-sm">
              <input type="hidden" class="form-control input-sm WarehouseID" name="WarehouseID[]" required="" readonly="">
              <input type="text" class="form-control input-sm WarehouseName" name="WarehouseName[]" required="" readonly="">
              <span class="input-group-btn">
                <button type="button" class="btn btn-danger remove" title="Remove" onclick="$(this).closest('.rowtext').remove();">x</button>
              </span>
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
  <?php $warehouse = $content['warehouse'];?>
  <section class="content">
    
    <div class="box box-solid">
      <div class="box-header with-border">
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="2"><i class="fa fa-fw fa-print"></i> Print</button>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>
        <!-- <a href="#" id="filterCol" class="btn btn-primary btn-xs filterCol" title="FILTER COLUMN">Filter Column</a> -->
        <div id="divfilterCol" class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Column</label>
                <span class="left2">
                      <select class="form-control input-sm ColumnList" name="ColumnList" required="">
                        <option value="1">Order Date</option>
                        <option value="16">Ship Date</option>
                        <option value="17">Category</option>
                      </select>
                </span>
              </div>
              <div class="form-group">
                <label class="left">Text</label>
                <span class="left2">
                  <input type="text" class="form-control input-sm ColumnValue" name="ColumnValue" required="">
                </span>
              </div>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-primary btn-xs searchColumn" title="SEARCH" removeTd="2"><i class="fa fa-fw fa-search"></i> SEARCH</button>
            </div>
        </div>

        <div class="divfilterdate">
          <form role="form" action="<?php echo current_url();?>" method="post">
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Start</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm" autocomplete="off" name="filterstart" id="filterstart">
                </div>
              </div>
              <div class="form-group">
                <label class="left">End</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm" autocomplete="off" name="filterend" id="filterend">
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">INVOICE MP</label>
                <span class="left2">
                  <input class="form-control input-sm" type="text" name="invmp" id="invmp"> 
                </span> 
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
              <th>Order</th>
              <th>Company</th>
              <th>Sales Name</th>
              <th>Category</th>
              <th>Ship Date</th>
              <th>Ready</th>
              <th>INVMP</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
            // echo count($content);
            if (isset($content['main'])) {
                foreach ($content['main'] as $row => $list) {
            ?>
                <tr>
                  <td><?php echo $list['SOID'];?></td>
                  <td><?php echo $list['SODate'];?></td>
                  <td><?php echo $list['Company'];?></td>
                  <td><?php echo $list['salesname'];?></td>
                  <td><?php echo $list['CategoryName'];?></td>
                  <td><?php echo $list['SOShipDate'];?></td>
                  <td><?php if($list['Putat']=="" AND $list['Margo']==""){ echo "NOT READY";}elseif($list['Putat']==""){echo $list['Margo'];}elseif($list['Margo']==""){echo $list['Putat'];}else{echo $list['Putat']." + ".$list['Margo'];}?></td>
                  <td><?php echo $list['INVMP'];?></td>
                  <td>
                    <?php if ($list['SOConfirm1'] == "1") { ?>
                      <i class="fa fa-fw fa-check-square-o" style="color: green;" title="CONFIRM1"></i>
                      <span style="display:none;">CONFIRM1</span>
                    <?php } ?>
                    <?php if ($list['SOConfirm2'] == "1") { ?>
                      <i class="fa fa-fw fa-check-square-o" style="color: green;" title="CONFIRM2"></i>
                      <span style="display:none;">CONFIRM2</span>
                    <?php } ?>
                    <?php if ($list['SOStatus'] == "0") { ?>
                      <i class="fa fa-fw fa-times" style="color: red;" title="CANCEL"></i>
                      <span style="display:none;">CANCEL</span>
                    <?php } ?>
                  </td>
                  <td>
                    <?php if(!empty($list['Label'])){ ?><a href="<?php echo base_url(); ?>assets/PDFLabel/<?php echo $list['Label'];?>" target="_blank" class="btn btn-xs btn-warning PrintLabel" title='PRINT DROPSHIP'><i class="fa fa-fw fa-print"></i></a>
                    <?php } ?>
                    <button type="button" class="btn btn-primary btn-xs detail" title="DETAIL" data-toggle="modal" data-target="#modal-detail" soid="<?php echo $list['SOID']; ?>"><i class="fa fa-fw fa-search"></i></button>
                  </td>
                </tr>
          <?php } } ?>
          </tbody>
          <tfoot>
          </tfoot>
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
    "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };
    },
    fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
        today = new Date();
        today = today.setHours(0,0,0,0)
        shipping = new Date(aData[8]);
        shipping = shipping.setHours(0,0,0,0)

        // conditions = ["complete", "cancel"];
        // status = conditions.some(el => aData[15].includes(el))

        oneDay = 24*60*60*1000 // hours*minutes*seconds*milliseconds
        diffDays = Math.round(Math.abs((today - shipping)/(oneDay)))
        if ( shipping <= today ) { diffDays = (diffDays*-1) }
        // if ( shipping <= today && parseInt(aData[9]) > 0 && !cancel ){
        // if (status=="false") {
          // console.log(aData[15])
          if ( diffDays <= 0){
              jQuery(nRow).addClass('tooLate');
          } else if ( diffDays <= 2) {
              jQuery(nRow).addClass('Late');
          } 
        // }         
    },
  })
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
    $('a[data-column="4"]').click();
    $('a[data-column="5"]').click();
  }, 100) 


  $('.searchColumn').on( 'click', function () {
      filterColumn( $('.ColumnList').val() );
  } );
  function filterColumn ( i ) {
    table.column( i ).search(
        $('.ColumnValue').val(),
        false,
        true
    ).draw();
  }


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


  $("#hideshow").click(function(){
    $("#divhideshow").slideToggle();
  });
  $("#filterCol").click(function(){
    $("#divfilterCol").slideToggle();
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

function createList() {
  WarehouseID = $(".WarehouseList").val()
  WarehouseName = $(".WarehouseList option:selected").text()
  $(".rowtext:first .WarehouseID").val(WarehouseID);
  $(".rowtext:first .WarehouseName").val(WarehouseName);
  $(".rowtext:first").clone().appendTo('.WarehouseListInput'); 
}

</script>