<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">

<style type="text/css">
 /*css fixed column*/
  .DTFC_LeftWrapper thead th, .DTFC_RightWrapper thead th,
  .DTFC_LeftWrapper tbody td, .DTFC_RightWrapper tbody td,
  .DTFC_LeftWrapper tfoot th, .DTFC_RightWrapper tfoot th {
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
  .divfilterdate, .divhideshow {
    display: none; 
    border: 1px solid #0073b7; 
    padding: 4px; 
    overflow: auto;
    margin: 5px 0px;
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
        <a href="<?php echo base_url();?>transaction/detail_to_do" id="add_do" class="btn btn-primary btn-xs add_do"><b>+</b> Add Delivery Order </a>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate"><i class="fa fa-search"></i> Filter</a>
        <a href="#" id="hideshow" class="btn btn-primary btn-xs hideshow">Hide/Show Column</a>
        <a href="#" id="batchdocomplete" class="btn btn-primary btn-xs batchdocomplete"><i class="fa fa-fw fa-check-square-o"></i> Batch DO Complete</a>
        
        <div class="divfilterdate">
          <form role="form" action="<?php echo current_url();?>" method="post" >
              <div class="col-md-6">
                <div class="form-group">
                  <label class="left">Search</label>
                  <span class="left2">
                    <div class="input-group input-group-sm">
                        <select class="form-control input-sm atributelist" style="width: 100%;" name="atributelist" required="">
                          <option value="DOID">DO ID</option>
                          <option value="DOType">DO Type</option>
                          <option value="DOReff">DO Reff</option>
                          <option value="Company">Company Name</option>
                          <option value="Warehouse">Warehouse</option>
                          <option value="ProductID">Product ID</option>
                          <option value="DONote">DO Note</option>
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
                    <label class="left">Status</label>
                    <span class="left2">
                      <select class="form-control input-sm" name="status">
                        <option value="3" >All</option>
                        <option value="0" >Not Complete</option>
                        <option value="1" >Complete</option>
                      </select>
                    </span>
                </div>
                <div class="form-group">
                  <label class="left">Date Start</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar">
                        </i>
                      </div>
                      <input type="text" class="form-control input-sm" autocomplete="off" name="input1" id="input1">
                  </div>
                </div>
                <div class="form-group">
                    <label class="left">Date End</label>
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
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
          </form>
        </div>

        <div class="divhideshow">
          Hide/Show Column :
          <a class="btn btn-primary btn-xs toggle-vis" data-column="7">WareHouse</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="9">Note</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="10">Employee</a>
        </div>
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered " style="width: 100%;">
          <thead>
            <tr>
              <th class=" alignCenter">DO ID</th>
              <th><input name="select_all" id="select_all" value="1" type="checkbox"></th>
              <th class=" alignCenter">DO Reff</th>
              <th class=" alignCenter">Company</th>
              <th class=" alignCenter">Date</th>
              <th class=" alignCenter">SO Category</th>
              <th class=" alignCenter">Shipping Address</th>
              <th class=" alignCenter">WareHouse</th>
              <th class=" alignCenter">Qty</th>
              <th class=" alignCenter">Note</th>
              <th class=" alignCenter">Employee</th>
              <th class=" alignCenter">Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
              if (isset($content)) {
                  foreach ($content as $row => $list) { 
                    $so = strpos($list['Reff'], "SO");
            ?>
                  <tr>
                      <td><?php echo $list['DOID'];?></td>
                      <td></td>
                      <td><?php echo $list['Reff'];?></td>
                      <td><?php echo $list['Company'];?></td>
                      <td><?php echo $list['DODate'];?></td>
                      <td><?php echo $list['CategoryName'];?></td>
                      <td class="ShipAddress"><?php echo $list['ShipAddress'];?></td>
                      <td><?php echo $list['WarehouseName'];?></td>
                      <td><?php echo $list['DOQty'];?></td>
                      <td><?php echo $list['DONote'];?></td>
                      <td><?php echo $list['Employee'];?></td>
                      <td>
                        <?php if ($list['DOStatus'] == "1") { ?>
                          <i class="fa fa-fw fa-check-square-o" style="color: green;"></i>
                        <?php } ?>
                      </td>
                      <td>
                        <a href="<?php echo base_url(); ?>general/contact_print?doid=<?php echo $list['DOID'];?>&company=<?php echo urlencode($list['CompanyOnly']);?>&shipname=<?php echo urlencode($list['ShipName']);?>&address=<?php echo urlencode($list['ShipAddress']);?>" target="_blink" class="btn btn-xs btn-primary PrintLabel" title='PRINT LABEL'><i class="fa fa-fw fa-print"></i></a>
                        <?php if(!empty($list['Label'])){ ?><a href="<?php echo base_url(); ?>assets/PDFLabel/<?php echo $list['Label'];?>" target="_blank" class="btn btn-xs btn-warning PrintLabel" title='PRINT DROPSHIP'><i class="fa fa-fw fa-print"></i></a>
                        <?php } ?>
                        <button type="button" class="btn btn-primary btn-xs printdo" dodet="<?php echo $list['DOID'];?>" reff="<?php echo $list['Reff'];?>" title="PRINT"><i class="fa fa-fw fa-file-text-o"></i></button>
                        <button type="button" class="btn btn-primary btn-xs printdo2" dodet="<?php echo $list['DOID'];?>" reff="<?php echo $list['Reff'];?>" title="PRINT"><i class="fa fa-fw fa-file-text-o"></i></button>
                          <?php if ($list['DOStatus'] == "0") { ?>
                            <button type="button" class="btn btn-success btn-xs" title="EDIT" onclick="window.open('<?php echo base_url();?>transaction/delivery_order_edit?do=<?php echo $list['DOID']; ?>&type=<?php echo $list['type']; ?>&reff=<?php echo $list['ReffOnly']; ?>', '_blank');"><i class="fa fa-fw fa-edit"></i></button>

                            <button type="button" class="btn btn-success btn-xs completedo" dodet="<?php echo $list['DOID'];?>" title="COMPLETE"><i class="fa fa-fw fa-check-square-o"></i></button>

                          <?php } else { ?>
                            <!-- <button type="button" class="btn btn-warning btn-xs retur" onclick="window.open('<?php echo base_url();?>transaction/delivery_order_received_add?doid=<?php echo $list['DOID']; ?>', '_blank');" title="RETUR"><i class="fa fa-fw fa-cart-arrow-down"></i></button> -->
                          <?php } ?>
                        <?php if (array_key_exists('PaymentAmount', $list) ) { ?>
                          <?php if ($list['PaymentAmount'] == "" ) { ?>
                            <button type="button" class="btn btn-success btn-xs addfc" title="ADD FreightCharge"  reff="do_fc_add?do=<?php echo $list['DOID']; ?>&type=<?php echo $list['type']; ?>"><i class="fa fa-fw fa-truck"></i></button>
                          <?php } else { ?>
                            <button type="button" class="btn btn-success btn-xs reportfc" title="Report FreightCharge" reff="do_fc_report?do=<?php echo $list['DOID'];?>"><i class="fa fa-fw fa-print"></i></button>
                          <?php } ?>
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

<script src="<?php echo base_url();?>tool/jquery11.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
	 
  var rows_selected = []; // for adding checkbox
  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip', 
     
    "scrollX": true,
    "scrollY": true,
    "scrollCollapse": true,
    "order": [[ 0, "desc" ]],
    "fixedColumns":   {
        leftColumns: 1,
        rightColumns: 1
    }, 
    "columnDefs": [ 
      // for adding checkbox
      {'targets': 1,
       'searchable': false,
       'orderable': false,
       'width': '1%',
       'className': 'dt-body-center',
       'render': function (data, type, full, meta){ return '<input type="checkbox">'; }
      },
      // ======================
    ], 

    // for adding checkbox
    "rowCallback": function(row, data, dataIndex){ 
      // Get row ID
      var rowId = data[0];
      // If row ID is in the list of selected row IDs
      if($.inArray(rowId, rows_selected) >= 0){
        $(row).find('input[type="checkbox"]').prop('checked', true);
        $(row).addClass('selected');
      }
    },
    // ======================
  })
  $('a.toggle-vis').on( 'click', function (e) {
      e.preventDefault();
      var column = table.column( $(this).attr('data-column') );
      column.visible( ! column.visible() );
      table.columns.adjust().draw();
  } );
  setTimeout( function order() {
    $('a[data-column="7"]').click();
    $('a[data-column="9"]').click();
    $('a[data-column="10"]').click();
  }, 100)
  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

  // all about checkbox dataTables
    // Handle click on "Select all" control
    $('thead input[name="select_all"]', table.table().container()).on('click', function(e){
      if(this.checked){
         $('#dt_list tbody input[type="checkbox"]:not(:checked)').trigger('click');
      } else {
         $('#dt_list tbody input[type="checkbox"]:checked').trigger('click');
      }
      // Prevent click event from propagating to parent
      e.stopPropagation();
    });

    // Handle click on checkbox
    $('#dt_list tbody').on('click', 'input[type="checkbox"]', function(e){
      var $row = $(this).closest('tr');
      // Get row data
      var data = table.row($row).data();
      // Get row ID
      var rowId = data[0];
      // Determine whether row ID is in the list of selected row IDs
      var index = $.inArray(rowId, rows_selected);

      // If checkbox is checked and row ID is not in list of selected row IDs
      if(this.checked && index === -1){
        rows_selected.push(rowId);
      // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
      } else if (!this.checked && index !== -1){
        rows_selected.splice(index, 1);
      }

      if(this.checked){
         $row.addClass('selected');
      } else {
         $row.removeClass('selected');
      }

      // Update state of "Select all" control
      updateDataTableSelectAllCtrl(table);
      // Prevent click event from propagating to parent
      e.stopPropagation();
    });

    // Handle table draw event
    table.on('draw', function(){
      // Update state of "Select all" control
      updateDataTableSelectAllCtrl(table);
    });

    $('#batchdocomplete').on('click', function(e){
      var data_selected = []; // for collecting data
      var rows_selected2 = rows_selected.sort()
      table.column( 0 ).data().each( function ( value, index ) {
        id = table.cell( index, 0 ).data();
        if($.inArray(id, rows_selected2) >= 0){
          data_selected.push(id);
        }
      });
      var CompleteDOBatch = confirm(data_selected.length+" will be Completed.\nDo you really want to Complete it?");
      if (CompleteDOBatch == true) {
        if (data_selected.length > 0) {
          $.post("<?php echo base_url();?>transaction/complete_do_batch", {data: data_selected}, function(result){
            alert( result+' DO is Completed!')
              location.reload()
          });
        }
      }
    }); 
  // ====================================================================

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
  $("#hideshow").click(function(){
    $(".divhideshow").slideToggle();
  });
});

function updateDataTableSelectAllCtrl(table){ // for adding checkbox
  var $table             = table.table().node();
  var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
  var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
  var chkbox_select_all  = $('thead #select_all');
  // If none of the checkboxes are checked
  if($chkbox_checked.length === 0){
    chkbox_select_all.prop("checked", false)
    chkbox_select_all.prop("indeterminate", false)
  // If all of the checkboxes are checked
  } else if ($chkbox_checked.length === $chkbox_all.length){
    chkbox_select_all.prop("checked", true)
    chkbox_select_all.prop("indeterminate", false)
  // If some of the checkboxes are checked
  } else {
    chkbox_select_all.prop("checked", false)
    chkbox_select_all.prop("indeterminate", true)
  }
}

function createattribute() {
  atributelist = $(".atributelist").val()
  $(".rowtext:first .atributeid").val(atributelist);
  $(".rowtext:first").clone().insertBefore('#atributelabel');
}
</script>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script>
var j8 = $.noConflict(true);
j8( document ).ready(function( $ ) {

  var popup;
  function openPopupOneAtATime(x, y, z) {
    result = y.split(' ');
    if (z == 'general') {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>transaction/delivery_order_print?do='+x+'&type='+result[0];
      } else {
         popup = window.open('<?php echo base_url();?>transaction/delivery_order_print?do='+x+'&type='+result[0], '_blank', 'width=800,height=650,left=200,top=20');     
      }
    } else if (z=='special') {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>transaction/delivery_order_print2?do='+x+'&type='+result[0];
      } else {
         popup = window.open('<?php echo base_url();?>transaction/delivery_order_print2?do='+x+'&type='+result[0], '_blank', 'width=800,height=650,left=200,top=20');     
      }
    }
  }
  function openPopupOneAtATime2(x) {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>transaction/'+x;
      } else {
         popup = window.open('<?php echo base_url();?>transaction/'+x, '_blank', 'width=780,height=500,left=200,top=100');     
      }
  }
  $(".printdo").live('click', function() {
    dodet = $(this).attr("dodet")
    reff = $(this).attr("reff")
    openPopupOneAtATime(dodet, reff, 'general');
  });
  $(".printdo2").live('click', function() {
    dodet = $(this).attr("dodet")
    reff = $(this).attr("reff")
    openPopupOneAtATime(dodet, reff, 'special');
  });
  $(".addfc").live('click', function() {
    reff = $(this).attr("reff")
    openPopupOneAtATime2(reff);
  });
  $(".reportfc").live('click', function() {
    reff = $(this).attr("reff")
    openPopupOneAtATime2(reff);
  });

  $(".completedo").live('click', function() {
    dodet = $(this).attr("dodet")
    var r = confirm("Set DO "+dodet+" to Complate.\n Are you sure?");
    if (r == true) {
      location.href='<?php echo base_url();?>transaction/complete_do?do='+dodet
    }
  });
  // $(".PrintLabel").live('click', function() {
  //   ShipAddress = $(this).parent().parent();
  //   localStorage.setItem("ShipAddress", ShipAddress);
  // });
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