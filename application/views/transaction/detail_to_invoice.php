<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">

<style type="text/css"> 

</style>

<div class="content-wrapper">
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
        <a href="#" id="batchcreateinv" class="btn btn-primary btn-xs batchcreateinv"><i class="fa fa-fw fa-edit"></i> Batch Create INV</a>
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered " style="width: 100%;">
          <thead>
            <tr>
              <th><input name="select_all" id="select_all" value="1" type="checkbox"></th>
              <th class=" alignCenter">DO ID</th>
              <th class=" alignCenter">SO ID</th>
              <th class=" alignCenter">Customer</th>
              <th class=" alignCenter">Sales Name</th>
              <th class=" alignCenter">Date</th>
              <th class=" alignCenter">SO Category</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
              if (isset($content['list1'])) {
                  foreach ($content['list1'] as $row => $list) { ?>
                  <tr>
                      <td></td>
                      <td class=" alignCenter"><?php echo $list['DOID'];?></td>
                      <td class=" alignCenter"><?php echo $list['SOID'];?></td>
                      <td><?php echo $list['Customer'];?></td>
                      <td><?php echo $list['Sales'];?></td>
                      <td class=" alignCenter"><?php echo $list['Date'];?></td>
                      <td class=" alignCenter"><?php echo $list['CategoryName']."-".$list['PaymentWay'];?></td>
                      <td>
                        <button type="button" class="btn btn-success btn-xs" title="CREATE INVOICE" onclick="location.href='<?php echo base_url();?>transaction/invoice_add?do=<?php echo $list['DOID']; ?>';"><i class="fa fa-fw fa-edit"></i></button>
                      </td>
                  </tr>
            <?php } } ?>
            <?php
              if (isset($content['list2'])) {
                  foreach ($content['list2'] as $row => $list) { ?>
                  <tr>
                      <td></td>
                      <td class=" alignCenter"><?php echo $list['DOID'];?></td>
                      <td class=" alignCenter"><?php echo $list['SOID'];?></td>
                      <td><?php echo $list['Customer'];?></td>
                      <td><?php echo $list['Sales'];?></td>
                      <td class=" alignCenter"><?php echo $list['Date'];?></td>
                      <td class=" alignCenter"><?php echo $list['CategoryName']."-".$list['PaymentWay'];?></td>
                      <td>
                        <button type="button" class="btn btn-success btn-xs" title="CREATE INV" onclick="location.href='<?php echo base_url();?>transaction/invoice_add?so=<?php echo $list['SOID']; ?>';"><i class="fa fa-fw fa-edit"></i></button>
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
<!-- <script src="<?php echo base_url();?>tool/jquery8.js"></script> -->
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
  var rows_selected = []; // for adding checkbox
  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
    "scrollX": true,
     "scrollY": true,
    "order": [[ 0, "asc" ]],
    "columnDefs": [ 
      // for adding checkbox
      {'targets': 0,
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
      var rowId = data[1];
      // If row ID is in the list of selected row IDs
      if($.inArray(rowId, rows_selected) >= 0){
        $(row).find('input[type="checkbox"]').prop('checked', true);
        $(row).addClass('selected');
      }
    },
    // ======================
  })

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
      var rowId = data[1];
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

    $('#batchcreateinv').on('click', function(e){
      var data_selected = []; // for collecting data
      var rows_selected2 = rows_selected.sort()
      table.column( 1 ).data().each( function ( value, index ) {
        id = table.cell( index, 1 ).data();
        if($.inArray(id, rows_selected2) >= 0 && !isNaN(id)){
          data_selected.push(id);
        }
      });
      console.log(data_selected)
      if (data_selected.length == rows_selected2.length) {
        var INVAddBatch = confirm(data_selected.length+" INV will be Created.\nDo you really want to Create it?");
        if (INVAddBatch == true) {
          if (data_selected.length > 0) {
            $.post("<?php echo base_url();?>transaction/invoice_add_act_batch", {data: data_selected}, function(result){
              alert( result+' INV has been Created!')
                location.reload()
            });
          }
        }
      } else {
        alert("Batch Create INV hanya untuk INV from DO dan 1SO 1DO!")
      }
    }); 
  // ====================================================================

  
  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);
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
</script>