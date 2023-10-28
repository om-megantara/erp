<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">

<style type="text/css">
  .divfilterdate {
    margin: 5px 0px;
    display: none; 
    border: 1px solid #0073b7; 
    padding: 4px; 
    overflow: auto;
  }
  #detailcontent {
    padding: 10px !important;
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

  <div class="modal fade" id="modal-cancel">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">CANCEL RO</h4>
          </div>
          <form action="<?php echo base_url();?>transaction/request_order_cancel" method="post">
            <div class="modal-body">
              <div class="form-group">
                  <input type="text" class="form-control" id="roid" name="roid" placeholder="RO ID" readonly="">
              </div>
              <div class="form-group">
                <textarea class="form-control" rows="3" id="cancelnote" name="cancelnote" placeholder="Cancel Note"></textarea>
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
      <div class="box-header">
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="2"><i class="fa fa-fw fa-print"></i> Print</button>
        <a href="<?php echo base_url();?>transaction/request_order_add" id="add_request_order" class="btn btn-primary btn-xs add_request_order"><b>+</b> Add Request Order</a>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate"><i class="fa fa-search"></i> Filter</a>

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
                          <option value="ROID">RO ID</option>
                          <option value="SOID">SO ID</option>
                          <option value="RONote">RO Note</option>
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
                <button type="submit" class="btn btn-primary  btn-sm">Submit</button>
              </div>
          </form>
        </div>
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
              <th>Status</th>
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
                    <?php if ($list['ROStatus'] == "1") { ?>
                      <i class="fa fa-fw fa-check-square-o" style="color: green;"></i>
                    <?php } else if ($list['ROStatus'] == "2") { ?>
                      <i class="fa fa-fw fa-times" style="color: red;"></i>
                    <?php } ?>
                  </td>
                  <td>
                    <button type="button" class="btn btn-primary btn-xs detail" title="DETAIL" roid="<?php echo $list['ROID'];?>" data-toggle="modal" data-target="#modal-detail"><i class="fa fa-fw fa-reorder"></i></button>
                    <button type="button" class="btn btn-primary btn-xs detailraw" title="DETAIL RAW" roid="<?php echo $list['ROID'];?>" data-toggle="modal" data-target="#modal-detail"><i class="fa fa-fw fa-reorder"></i></button>
                      <button type="button" class="btn btn-primary btn-xs printro" roid="<?php echo $list['ROID'];?>" title="PRINT"><i class="fa fa-fw fa-file-text-o"></i></button>
                    
                    <?php if ($list['qtypo'] < $list['qty']) { ?>
                      <button type="button" class="btn btn-success btn-xs" title="EDIT" onclick="location.href='<?php echo base_url();?>transaction/request_order_add?ro=<?php echo $list['ROID']; ?>';"><i class="fa fa-fw fa-edit"></i></button>
                    <?php } ?>
                    <?php if ($list['ROStatus'] == "0" && $list['qtypo'] == "0") { ?>
                      <button type="button" class="btn btn-danger btn-xs cancel" title="CANCEL" roid="<?php echo $list['ROID']; ?>" data-toggle="modal" data-target="#modal-cancel"><i class="fa fa-fw fa-trash-o"></i></button>
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
    "scrollX": true,
     "scrollY": true,
    "order": [[ 0, "desc" ]]
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
  $('.cancel').live('click',function(e){
    roid = $(this).attr("roid");
    $('#roid').val(roid);
  });
  $('.detail').live('click', function(e){
        roid  = $(this).attr("roid")
        get(roid);
  }); 
  $('.detailraw').live('click', function(e){
        roid  = $(this).attr("roid")
        get2(roid);
  });
  function get(roid) {
    document.getElementById("detailcontent").innerHTML='<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
    xmlHttp=GetXmlHttpObject()
      var url="<?php echo base_url();?>transaction/request_order_detail_full"
      url=url+"?roid="+roid
      // alert(url);
      xmlHttp.onreadystatechange=stateChanged
      xmlHttp.open("GET",url,true)
      xmlHttp.send(null)
  }
  function get2(roid) {
    document.getElementById("detailcontent").innerHTML='<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
    xmlHttp=GetXmlHttpObject()
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