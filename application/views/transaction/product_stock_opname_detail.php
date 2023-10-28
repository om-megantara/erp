<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">
<style type="text/css">
	@media only print {
	    .print-bt, .divmain {
		    display:none !important;
		}
		.divdetail {
		    display:block !important;
		}
	}
	.divmain, .divdetail, .divhead {
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
		width: 1200px;
		margin: 20px;
	}
	.table-main thead tr th, .table-main tbody tr td, 
	#newTable thead tr th, #newTable tbody tr td {
		font-size: 12px ;
	}

	#newTable thead th {
		background: #3169c6;
		color: #ffffff;
		text-align: center;
		color: white;
	}
	#newTable, 
	#newTable>thead>tr>th, 
	#newTable>tbody>tr>td {
		padding: 4px 10px !important;
	    border-bottom: 1px solid #3169c6;
		word-break: break-all; 
		white-space: nowrap; 
	}
	#newTable { width: 740px; }
  	.div_dt_print, .divdetail { display: none; }
	@media (min-width: 950px) {
		/*for DT info on top*/
		.dataTables_wrapper .dataTables_length {
		  margin-right: 20px;
		  display: inline;
		}
		.dataTables_wrapper .dataTables_info {
		  display: inline-block;
		}
		.dataTables_wrapper .dataTables_filter {
		  float: right;
		}
		.dataTables_wrapper .dataTables_paginate {
		  float: right;
		}
	}
</style>

<div class="divhead">
	<center>
		<h4>Stock Opename Date : <?php echo $content['main']['OpnameDate']; ?></h4>
		<h4>Warehouse : <?php echo $content['main']['WarehouseName']; ?></h4>
		<button class="btn btn-primary btn-xs print-bt" type="button" onclick="">Print</button>
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="0"><i class="fa fa-fw fa-print"></i> Print excel</button>
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="0"><i class="fa fa-fw fa-print"></i> Print excel for adjustment</button>
	</center>
</div>
<div class="divmain">
	<table id="dt_list" class="table table-bordered  table-main" style="width: 100% !important;">
	  <thead>
	    <tr>
	      <th>ID</th>
	      <?php if (in_array("print_without_header", $MenuList)) {?>
			<th>Name</th>
	      <?php } else { ?>
			<th>Code</th>
	      <?php } ?>
	      <!-- <th>WareHouse</th> -->
	      <th>Full Category</th>
	      <th>Full Brand</th>
	      <th>Quantity</th>
	      <th>Adjust</th>
	      <th>Qty Final</th>
	      <th>Custom</th>
	    </tr>
	  </thead>
	  <tbody>
	  <?php
	    // echo count($content);
	    if (isset($content['detail'])) {
	        foreach ($content['detail'] as $row => $list) { ?>
	        <tr>
			<td><?php echo $list['ProductID'];?></td>
			<?php if (in_array("print_without_header", $MenuList)) {?>
				<td><?php echo $list['ProductName'];?></td>
				<?php } else { ?>
				<td><?php echo $list['ProductCode'];?></td>
			<?php } ?>
			<!-- <td><?php echo $list['WarehouseName'];?></td> -->
			<td><?php echo $list['ProductCategoryName'];?></td>
			<td><?php echo $list['ProductBrandName'];?></td>
			<td><?php echo $list['Quantity'];?></td>
			<td><?php echo $list['AdjustQty'];?></td>
			<td><?php echo $list['Quantity'] + $list['AdjustQty'];?></td>
			<td><?php if($list['ProductSTD']=='STD'){echo "Standard";}else{echo "Custom";};?></td>
	        </tr>
	  <?php } } ?>
	  </tbody>
	</table>
</div>

<div class="div_dt_print"></div>
<div class="divdetail"></div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
   

  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "order": [],
    "aaSorting": [],
    "scrollX": true,
     "scrollY": true,
  })

  var cek_dt = function() {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

    // Event handler to get data and generate new table
    $('button.print-bt').on('click', function() {               
        var fvData = table.rows({ search:'applied', page: 'all' }).data(); 
        
        $('.divdetail').empty().append(
           '<table id="newTable" class="col">' +
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
    });

	$( ".print-bt" ).click(function() {
	  	window.print();
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

      for (var i = 0; i < $(this).attr('removeTd'); i++) {
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
