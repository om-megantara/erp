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

  .divfilterdate {
    display: none; 
    border: 1px solid #0073b7; 
    padding: 4px; 
    overflow: auto;
    margin: 5px 0px;
  }
  .martop-4 { margin-top: 4px; }
  .rowlist, .rowtext { margin-top: 6px; }
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
  .Late { background: #ffd28b !important; }
  .tooLate { background: #ffc9c1 !important; }
  .RawOutstanding { background: #73ba76e0 !important; }
</style>
<div class="content-wrapper">

  <div class="modal fade" id="modal-cancel">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">CANCEL PO</h4>
          </div>
          <form action="<?php echo base_url();?>transaction/purchase_order_cancel" id="form_cancel" method="post">
            <div class="modal-body">
              <div class="form-group">
                  <input type="text" class="form-control poid" name="poid" placeholder="PO ID" readonly="">
              </div>
              <div class="form-group">
                <textarea class="form-control" rows="3" id="cancelnote" name="cancelnote" placeholder="Cancel Note" required=""></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-expired">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">EXPIRED PO</h4>
          </div>
          <form action="<?php echo base_url();?>transaction/purchase_order_expired" id="form_expired" method="post">
            <div class="modal-body">
              <div class="form-group">
                  <input type="text" class="form-control poid" name="poid" placeholder="PO ID" readonly="">
              </div>
              <div class="form-group">
                <textarea class="form-control" rows="3" id="note" name="note" placeholder="Note" required=""></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">DETAIL PRODUCT</h4>
          </div>
          <div class="modal-body">
            <div class="detailcontentAjax" id="detailcontent"></div>
          </div>
      </div>
    </div>
  </div>
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
      <li><a title="HELP" class="btn btn-warning btn-xs" href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>

  <section class="content">
    <div class="box box-solid">
      <div class="box-header">
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="2"><i class="fa fa-fw fa-print"></i> Print</button>
        <a title="ADD PURCHASE ORDER" href="<?php echo base_url();?>transaction/request_to_purchase" id="add_purchase_order" class="btn btn-primary btn-xs add_purchase_order"><b>+</b> Add Purchase Order</a>
        <a href="<?php echo base_url();?>transaction/purchase_order_add?ro=0" class="btn btn-primary btn-xs"><b>+</b> Add PO non RO</a>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>
        <!-- <a title="DOR FROM PO" href="<?php echo base_url();?>transaction/purchase_order_dor" id="dorPO" class="btn btn-primary btn-xs">DOR from PO</a> -->

        <div class="divfilterdate">
          <form role="form" action="<?php echo current_url();?>" method="post" >
              <div class="col-md-6">
                <div class="form-group">
                  <label class="left">Status</label>
                  <span class="left2">
                    <select class="form-control input-sm" name="status">
                      <option value="3" >All</option>
                      <option value="0" >Ready</option>
                      <option value="1" >Success</option>
                      <option value="2" >Cancel</option>
                    </select>
                  </span>
                </div>
                <div class="form-group">
                  <label class="left">Search</label>
                  <span class="left2">
                    <div class="input-group input-group-sm">
                        <select class="form-control input-sm atributelist" style="width: 100%;" name="atributelist" required="">
                          <option value="POID">PO ID</option>
                          <option value="ROID">RO ID</option>
                          <option value="PONote">PO Note</option>
                          <option value="Company">Supplier</option>
                          <option value="ProductID">Product ID</option>
                          <option value="RAWID">RAW ID</option>
                        </select>
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-primary  add_field" onclick="createattribute();">+</button>
                        </span>
                    </div>
                  </span>
                  <label id="atributelabel"></label>
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
                      <input type="text" class="form-control input-sm" autocomplete="off" name="input1" id="input1">
                  </div>
                </div>
                <div class="form-group">
                    <label class="left">End</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar">
                          </i>
                        </div>
                        <input type="text" class="form-control input-sm" autocomplete="off" name="input2" id="input2">
                    </div>
                </div>
              </div>
              <div class="col-md-12" style="text-align: center;">
                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
              </div>
          </form>
        </div>
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered " style="width: 100%;">
          <thead>
            <tr>
              <th class=" alignCenter">PO ID</th>
              <th class=" alignCenter">RO ID</th>
              <th class=" alignCenter">Date</th>
              <th class=" alignCenter">Note</th>
              <th class=" alignCenter">Schedule</th>
              <th class=" alignCenter">Supplier</th>
              <th class=" alignCenter">Employee</th>
              <th class=" alignCenter">Quantity</th>
              <th class=" alignCenter">DOR</th>
              <th class=" alignCenter">Outstanding</th>
              <th class=" alignCenter">Outstanding RAW</th>
              <th class=" alignCenter">Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
              if (isset($content['main'])) {
                  foreach ($content['main'] as $row => $list) {
                    // if (isset($content['product'][$list['POID']])) { 
                    //   $list['qty'] = $content['product'][$list['POID']]['qty'];
                    //   $list['qtydor'] = $content['product'][$list['POID']]['qtydor'];
                    // }
                    // if (isset($content['raw'][$list['POID']])) { 
                    //   $list['rawsent'] = $content['raw'][$list['POID']]['rawsent'];
                    // } else { $list['rawsent'] = 0; }
            ?>
                  <tr>
                      <td><?php echo $list['POID'];?></td>
                      <td><?php echo $list['ROID'];?></td>
                      <td><?php echo $list['PODate'];?></td>
                      <td><?php echo $list['PONote'];?></td>
                      <td><?php echo $list['ShippingDate'];?></td>
                      <td><?php echo $list['supplier'];?></td>
                      <td><?php echo $list['employee'];?></td>
                      <td><?php echo $list['qty'];?></td>
                      <td><?php echo $list['qtydor'];?></td>
                      <td><?php echo $list['qty'] - $list['qtydor'] ;?></td>
                      <td><?php echo $list['RawOutstanding'];?></td>
                      <td>
                        <?php if ($list['POExpiredDate'] != null) { ?>
                          <i class="fa fa-fw fa-check-square-o" style="color: green;" title="complete"></i>
                          <i class="fa fa-fw fa-clock-o" style="color: #f39c12;" title="expired"></i>
                        <?php } else if ($list['POStatus'] == "1") { ?>
                          <i class="fa fa-fw fa-check-square-o" style="color: green;" title="complete"></i>
                        <?php } else if ($list['POStatus'] == "2") { ?>
                          <i class="fa fa-fw fa-times" style="color: red;" title="cancel"></i>
                        <?php } ?>
                        <?php if ($list['isApprove'] == "1") { ?>
                          <i class="fa fa-fw fa-check-square-o" style="color: blue;" title="Approved"></i>
                        <?php } ?>
                      </td>
                      <td>
                        <button type="button" class="btn btn-primary btn-xs detail" title="DETAIL" poid="<?php echo $list['POID'];?>" data-toggle="modal" data-target="#modal-detail"><i class="fa fa-fw fa-reorder"></i></button>
                        <button type="button" class="btn btn-primary btn-xs detailraw" title="DETAIL RAW" poid="<?php echo $list['POID'];?>" data-toggle="modal" data-target="#modal-detail"><i class="fa fa-fw fa-reorder"></i></button>

                        <?php if ($list['isApprove'] == "1") { ?>
                          <button type="button" class="btn btn-primary btn-xs printpo" poid="<?php echo $list['POID'];?>" title="PRINT"><i class="fa fa-fw fa-file-text-o"></i></button>
                          <button type="button" class="btn btn-primary btn-xs printpo2" poid="<?php echo $list['POID'];?>" title="PRINT no Price"><i class="fa fa-fw fa-file-text-o"></i></button>
                        <?php } ?>

                        <?php
                        if ($list['POStatus'] == "0") { 
                        // if ($list['POStatus'] != "2" && $list['qtydor'] == "0" && $list['RawSent2'] == "0") { 
                        ?>
                          <button type="button" class="btn btn-success btn-xs" title="EDIT" onclick="window.open('<?php echo base_url();?>transaction/purchase_order_edit?po=<?php echo $list['POID']; ?>', '_blank')"><i class="fa fa-fw fa-edit"></i></button>
                        <?php } ?>
                        <?php if ($list['POStatus'] == "0" && $list['qtydor'] == "0" && $list['RawSent2'] == "0") { ?>
                          <button type="button" class="btn btn-danger btn-xs cancel" title="CANCEL" poid="<?php echo $list['POID']; ?>" data-toggle="modal" data-target="#modal-cancel"><i class="fa fa-fw fa-trash-o"></i></button>
                        <?php } ?>
                        <?php if ($list['POStatus'] == "0") { ?>
                          <button type="button" class="btn btn-warning btn-xs expired" title="EXPIRED" poid="<?php echo $list['POID']; ?>" data-toggle="modal" data-target="#modal-expired"><i class="fa fa-fw fa-clock-o"></i></button>
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
    "scrollCollapse": true,
    "fixedColumns": {
        leftColumns: 1,
        rightColumns: 2
    },
    fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {  
        today = new Date();
        today = today.setHours(0,0,0,0)
        shipping = new Date(aData[4]);
        shipping = shipping.setHours(0,0,0,0)

        conditions = ["complete", "cancel"];
        status = conditions.some(el => aData[11].includes(el))

        RawOutstanding = parseInt(aData[10])
        oneDay = 24*60*60*1000 // hours*minutes*seconds*milliseconds
        diffDays = Math.round(Math.abs((today - shipping)/(oneDay)))
        if ( shipping <= today ) { diffDays = (diffDays*-1) }
        // if ( shipping <= today && parseInt(aData[9]) > 0 && !cancel ){
        if (status=="false") {
          // console.log(status+'+'+aData[0])
          if (RawOutstanding > 0) {
                jQuery(nRow).addClass('RawOutstanding');
          } else {
            if ( diffDays <= 0 && parseInt(aData[9]) > 0){
                jQuery(nRow).addClass('tooLate');
            } else if ( diffDays <= 3 && parseInt(aData[9]) > 0) {
                jQuery(nRow).addClass('Late');
            } 
          }
        }         
    },
  })
  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

  $("#input1").datepicker({ 
    "setDate": new Date(), 
    autoclose: true, 
    format: 'yyyy-mm-dd',
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#input2').datepicker('setStartDate', minDate);
        var date2 = $('#input1').datepicker('getDate');
        $('#input2').datepicker('setDate', date2);
  });
  $("#input2").datepicker({ 
    "setDate": new Date(), 
    autoclose: true, 
    format: 'yyyy-mm-dd',
    }).on('changeDate', function (selected) {
      var maxDate = new Date(selected.date.valueOf());
      $('#input1').datepicker('setEndDate', maxDate);
  });
  $(".filterdate").click(function(){
    $(".divfilterdate").slideToggle();
  });

  var popup;
  function openPopupOneAtATime(x) {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>transaction/purchase_order_print?po='+x;
      } else {
         popup = window.open('<?php echo base_url();?>transaction/purchase_order_print?po='+x, '_blank', 'width=800,height=650,left=200,top=20');     
      }
  }
  function openPopupOneAtATime2(x) {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>transaction/purchase_order_print2?po='+x;
      } else {
         popup = window.open('<?php echo base_url();?>transaction/purchase_order_print2?po='+x, '_blank', 'width=800,height=650,left=200,top=20');     
      }
  }
  function openPopupOneAtATime3(x) {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>transaction/delivery_order_received_print2?dor='+x;
      } else {
         popup = window.open('<?php echo base_url();?>transaction/delivery_order_received_print2?dor='+x, '_blank', 'width=800,height=650,left=200,top=20');     
      }
  }
  $(".printpo").live('click', function() {
    poid = $(this).attr("poid")
    openPopupOneAtATime(poid);
  });
  $(".printpo2").live('click', function() {
    poid = $(this).attr("poid")
    openPopupOneAtATime2(poid);
  });
  $(".printdor").live('click', function() {
    dor = $(this).attr("dor")
    openPopupOneAtATime3(dor);
  });

  $('.cancel').live('click',function(e){
    poid = $(this).attr("poid");
    $('.poid').val(poid);
  });
  $('.expired').live('click',function(e){
    poid = $(this).attr("poid");
    $('.poid').val(poid);
  });

  $('.detail').live('click', function(e){
    $('#detailcontent').empty() 
    poid  = $(this).attr("poid")
    get(poid);
  }); 
  $('.detailraw').live('click', function(e){
    $('#detailcontent').empty() 
    poid  = $(this).attr("poid")
    get2(poid);
  });
  function get(poid) {
    xmlHttp=GetXmlHttpObject()
      var url="<?php echo base_url();?>transaction/purchase_order_detail_full"
      url=url+"?poid="+poid
      // alert(url);
      xmlHttp.onreadystatechange=stateChanged
      xmlHttp.open("GET",url,true)
      xmlHttp.send(null)
  }
  function get2(poid) {
    xmlHttp=GetXmlHttpObject()
      var url="<?php echo base_url();?>transaction/purchase_order_detail_raw_full"
      url=url+"?poid="+poid
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

  function createattribute() {
    atributelist = $(".atributelist").val()
    $(".rowtext:first .atributeid").val(atributelist);
    $(".rowtext:first").clone().insertBefore('#atributelabel');
  }

$("#form_cancel").submit(function(e) {
  var r = confirm("PO akan Cancel!");
  if (r == false) {
    e.preventDefault();
    return false
  }
});
$("#form_expired").submit(function(e) {
  var r = confirm("PO akan dijadikan complete dengan cara expired!");
  if (r == false) {
    e.preventDefault();
    return false
  }
});
</script>