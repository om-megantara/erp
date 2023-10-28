<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
<style type="text/css">
	.divfilterdata {
		display: none;
		border: 1px solid #0073b7; 
		padding: 4px; 
		margin: 10px;
    	overflow: auto;
	}
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
	<section class="content-header">
	    <h1>
      		<?php echo $PageTitle.' - '. $MainTitle; ?>
	    </h1>
	</section>
	<section class="content">
	    <div class="box box-solid">
	    	<div class="box-header">
        		<button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="1"><i class="fa fa-fw fa-print"></i> Print</button>
		        <a href="#" id="filterdata" class="btn btn-primary btn-xs filterdata" title="FILTER"><i class="fa fa-search"></i> Filter</a>
		        <div class="divfilterdata">
		        	<form role="form" action="<?php echo current_url();?>" method="post" >
			            <div class="col-md-6">
			              <div class="form-group">
			                  <label class="left">Start</label>
			                  <div class="input-group">
			                    <div class="input-group-addon">
			                      <i class="fa fa-calendar">
			                      </i>
			                    </div>
			                    <input type="text" class="form-control input-sm" autocomplete="off" name="filterstart" id="filterstart">
			                  </div>
			              </div>
			              <div class="form-group">
			                  <label class="left">End</label>
			                  <div class="input-group">
			                      <div class="input-group-addon">
			                        <i class="fa fa-calendar">
			                        </i>
			                      </div>
			                      <input type="text" class="form-control input-sm" autocomplete="off" name="filterend" id="filterend">
			                  </div>
			              </div>
			            </div>
			            <div class="col-md-12" >
			            	<center>	
			            		<button type="submit" class="btn btn-primary btn-sm pull-center">Submit</button>
			            	</center>
			            </div>
		        	</form>
		        </div>
	      	</div>
			<div class="box-body">
				<table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
					<thead>
					    <tr>
							<th class=" alignCenter"> Retur ID</th>
							<th class=" alignCenter"> Deposit ID</th>
							<th class=" alignCenter"> Customer Name</th>
							<th class=" alignCenter"> Deposit Date</th>
							<th class=" alignCenter"> Retur Date</th>
							<th class=" alignCenter"> Deposit Amount</th>
							<th class=" alignCenter"> Retur Amount</th>
							<th class=" alignCenter"> Create By</th>
							<th> </th>
					    </tr>
				    </thead>
				    <tbody>
				    <?php
				    if (isset($content)) {
				        foreach ($content as $row => $list) { ?>
				        <tr>
				            <td class=" alignCenter"><?php echo $list['ReturID'];?></td>
				            <td class=" alignCenter"><?php echo $list['DepositID'];?></td>
				            <td style="font-weight: bold; color: #00a65a;">
					            <a href="<?php echo base_url();?>finance/customer_deposit_detail?id=<?php echo $list['CustomerID'];?>" target="_blank"><?php echo $list['Customer'];?></a>
					        </td>
				            <td class=" alignCenter"><?php echo date('Y-m-d', strtotime($list['TransferDate']));?></td>
				            <td class=" alignCenter"><?php echo date('Y-m-d', strtotime($list['ReturDate']));?></td>
				            <td class="alignRight"><?php echo number_format($list['DepositAmount'],2);?></td>
				            <td class="alignRight"><?php echo number_format($list['ReturAmount'],2);?></td>
				            <td><?php echo $list['employee'];?></td>
				            <td>
				            	<button type="button" class="btn btn-success btn-xs report" title="REPORT" reff="bank_distribution_print?id=<?php echo $list['DistributionID'];?>"><i class="fa fa-fw fa-print"></i></button>
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
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
var j11 = $.noConflict(true);
j11( document ).ready(function( $ ) {
  var rows_selected = []; // for adding checkbox
  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
    "scrollX": true,
     "scrollY": true,
    "columnDefs": [ 
	    {"targets": 4, "width": "40%"},
    ],
    "order": [[ 0, "desc" ]],
  })

  	var cek_dt = function() {
	    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
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

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script>
var j8 = $.noConflict(true);
j8( document ).ready(function( $ ) {
   
  
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

  $(".filterdata").click(function(){
    $(".divfilterdata").slideToggle();
  });
  var popup;
  function openPopupOneAtATime2(x) {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>finance/'+x;
      } else {
         popup = window.open('<?php echo base_url();?>finance/'+x, '_blank', 'width=780,height=500,left=200,top=100');     
      }
  }
  $(".report").live('click', function() {
    reff = $(this).attr("reff")
    openPopupOneAtATime2(reff);
  });
});

</script>