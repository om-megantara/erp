<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css">
  #form-filter {
    border: 1px solid #0073b7; 
    padding: 4px;
    padding-top: 20px; 
    display: none;
  }
  tfoot input {
    width: 100%;
    padding: 1px;
    box-sizing: border-box;
    font-size: 12px !important;
  }
  td.note {
    min-width: 350px !important;
    white-space: normal !important;
  }
  td.note textarea {
    width: 100%;
    height: 100%;
  }
</style>
<style type="text/css">
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
    <div class="box box-solid">
      <div class="box-header with-border">
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="1"><i class="fa fa-fw fa-print"></i> Print</button>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
              <tr>
                <th>ProductID</th>
                <th>Product Name</th>
                <th>Source Agent</th>
                <th>Manager</th>
                <th>COO</th>
                <th>PShop</th>
                <th>IShop Assigned</th>
                <th></th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>ProductID</th>
                <th>Product Name</th>
                <th>Source Agent</th>
                <th>Manager</th>
                <th>COO</th>
                <th>PShop</th>
                <th>IShop Assigned</th>
                <th></th>
              </tr>
            </tfoot>
            <tbody>
              
            <?php
              foreach ($content as $row => $list) { ;?>
                <tr>
                  <td><?php echo $list['ProductID'];?></td>
                  <td class="note"><?php echo $list['ProductName'];?></td>
                  <td><?php echo $list['SourceAgent'];?></td>
                  <td><?php echo $list['ProductManager'];?></td>
                  <td><?php echo $list['StateName'];?></td>
                  <td><?php echo $list['Shop'];?></td>
                  <td><?php echo $list['CountShop'];?></td>
                  <td>
                    <a href="<?php echo base_url().'report/product_shop?productid='.$list['ProductID'];?>" class="btn btn-flat btn-success btn-xs edit " target="_blank" title="EDIT LINK"><i class="fa fa-fw fa-edit"></i></a>
                    <?php if (in_array("koreksi_produk_view_all", $MenuList)) { ?>
                      <a href="<?php echo base_url().'master/product_add?id='.$list['ProductID'];?>" id="edit" class="btn btn-flat btn-primary btn-xs edit view" style="margin: 0px;" target="_blank" title="EDIT PRODUCT"><i class="fa fa-fw fa-edit"></i></a>
                    <?php } ?>
                  </td>
                </tr>
            <?php } ?>
            </tbody>
          </table>
      </div>
      <div class="box-footer">
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
<script>
jQuery( document ).ready(function( $ ) {
   
  $('#dt_list tfoot th').each( function () {
      var title = $(this).text();
      $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
  } );

  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "columnDefs": [ 
      { "targets": 1, "width": "20%" },
    ],
    "order": [[ 0, "asc" ]]
  });

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

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);
  
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