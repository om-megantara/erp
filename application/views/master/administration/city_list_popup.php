<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" type="image/ico" href="<?php echo base_url();?>tool/favicon.ico"/> 
  <title>CITY LIST</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/dist/css/AdminLTE.min.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/dist/css/skins/_all-skins.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style type="text/css">
  </style>
</head>
<style type="text/css">
  .view {margin: 0px !important;}
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
  tfoot input {
    width: 100%;
    font-size: 12px !important;
    padding: 3px;
    box-sizing: border-box;
  }
  #divhideshow { display: none; margin-left: 10px; border: 1px solid #0073b7; padding: 5px;}
</style>
<?php
// print_r($content['fullbrand']);
?>
<div class="content-wrapper">
  <section class="content">
    <div class="box box-solid">
      <div class="box-header">
        <a href="#" id="check" class="btn btn-primary btn-xs check" title="SUBMIT DATA">Submit Data</a>
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
          <thead>
            <tr>
              <th><input name="select_all" id="select_all" value="1" type="checkbox"></th>
              <th>ID</th>
              <th>Name</th>
              <th>Abbreviation</th>
              <th>Detail</th>
              <th>Region</th>
            </tr>
          </thead>
          <tfoot> 
            <tr>
              <th></th>
              <th>ID</th>
              <th>Name</th>
              <th>Abbreviation</th>
              <th>Detail</th>
              <th>Region</th>
            </tr>
          </tfoot>
          <tbody>
           <?php
              // echo count($content);
            if (isset($content)) {
              $no = 0;
              foreach ($content as $row => $list) { $no++; ?>
                <tr>
                  <td></td>
                  <td><?php echo $list['CityID'];?></td>
                  <td><?php echo $list['CityName'];?></td>
                  <td><?php echo $list['CityAbbreviation'];?></td>
                  <td><?php echo $list['StateName'].", ".$list['ProvinceName'];?></td>
                  <td><?php echo $list['RegionCode'];?></td>
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
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
var j11 = $.noConflict(true);

j11( document ).ready(function( $ ) {
  // Setup - add a text input to each footer cell
  $('#dt_list tfoot th').each( function () {
      var title = $(this).text();
      $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
  } );

  var rows_selected = []; // for adding checkbox
  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "columnDefs": [ 
    {"targets": 1, "width": "1%"},
    
    // for adding checkbox
    {'targets': 0,
     'searchable': false,
     'orderable': false,
     'width': '1%',
     'className': 'dt-body-center',
     'render': function (data, type, full, meta){ return '<input type="checkbox">'; }
    }
    // ======================

    ],
    // "aaSorting": [],
    "order": [[ 4, "asc" ]],

    // for adding checkbox
    "rowCallback": function(row, data, dataIndex){ 
      // Get row ID
      var rowId = data[1];
      // If row ID is in the list of selected row IDs
      if($.inArray(rowId, rows_selected) >= 0){
        $(row).find('input[type="checkbox"]').prop('checked', true);
        $(row).addClass('selected');
      }
    }
    // ======================
  })
  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
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

    // Handle form submission event
    $('#check').on('click', function(e){
      var data_selected = []; // for collecting data
      var rows_selected2 = rows_selected.sort()
      table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
        if($.inArray(this.data()[1], rows_selected2) > -1){
          var valueToPush = { }
          valueToPush.tdid = this.data()[1]
          valueToPush.tdname = this.data()[2]
          valueToPush.tdabbreviation = this.data()[3]
          valueToPush.tddetail = this.data()[4]
          data_selected.push(valueToPush);
        }
      });

      // send to parent
      window.opener.ProcessChildMessage(data_selected);
      // window.close()
    }); 
  // ====================================================================

  // Apply the search
  table.columns().every( function () {
    var that = this;
    $( 'input', this.footer() ).on( 'keyup change', function () {
      if ( that.search() !== this.value ) {
        that
          .search( this.value )
          .draw();
      }
    } );
  } );
});

function updateDataTableSelectAllCtrl(table){ // for adding checkbox
  var tablenode         = table.table().node();
  var chkbox_all        = j11('tbody input[type="checkbox"]', tablenode);
  var chkbox_checked    = j11('tbody input[type="checkbox"]:checked', tablenode);
  var chkbox_select_all = j11('thead #select_all');
  // If none of the checkboxes are checked
  if(chkbox_checked.length === 0){
    chkbox_select_all.prop("checked", false)
    chkbox_select_all.prop("indeterminate", false)
  // If all of the checkboxes are checked
  } else if (chkbox_checked.length === chkbox_all.length){
    chkbox_select_all.prop("checked", true)
    chkbox_select_all.prop("indeterminate", false)
  // If some of the checkboxes are checked
  } else {
    chkbox_select_all.prop("checked", false)
    chkbox_select_all.prop("indeterminate", true)
  }
}
</script>

