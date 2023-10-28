<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
<style type="text/css">
	.form-header>button, .form-header>a {
		/*margin-top: 20px;		*/
	}
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
	      width: 120px;
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
	<div class="modal fade" id="modal-setTransaction">
	    <div class="modal-dialog">
	      <div class="modal-content">
	          <div class="modal-header">
	              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                <span aria-hidden="true">&times;</span>
	              </button>
	              <h4 class="modal-title">Set BankTransactionID</h4>
	          </div>
	          <form action="<?php echo base_url();?>finance/setBankTransactionID" id="form_setBankTransactionID" method="post">
	            <div class="modal-body">
	    			<div class="box box-solid">
	    				<div class="box-body">
							<div class="col-md-6">
								<div class="form-group">
									<label class="left">Distribution ID</label>
									<span class="left2">
										<input type="text" class="form-control input-sm DistributionID" name="DistributionID" readonly="">
									</span>
								</div>
								<div class="form-group">
									<label class="left">Amount</label>
									<span class="left2">
										<input type="text" class="form-control input-sm mask-number DistributionAmount" name="DistributionAmount" readonly="">
									</span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="left">Transaction ID</label>
									<span class="left2">
					                    <div class="input-group input-group-sm">
								  			<input type="text" class="form-control input-sm BankTransactionID" name="BankTransactionID">
					                        <span class="input-group-btn">
					                          <button type="button" class="btn btn-primary  " onclick="cekAmountTransaction();">Cek</button>
					                        </span>
					                    </div>
									</span>
								</div>
								<div class="form-group">
									<label class="left">Amount</label>
									<span class="left2">
								  		<input type="text" class="form-control input-sm mask-number BankTransactionAmount" name="BankTransactionAmount" readonly="">
									</span>
								</div>
							</div>
						</div>
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
	<div class="modal fade" id="modal-inputTransaction">
	    <div class="modal-dialog">
	      <div class="modal-content">
	          <div class="modal-header">
	              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                <span aria-hidden="true">&times;</span>
	              </button>
	              <h4 class="modal-title">Input inTo Bank Transaction</h4>
	          </div>
	          <form action="<?php echo base_url();?>finance/inputIntoBankTransaction" id="form_inputIntoBankTransaction" method="post">
	            <div class="modal-body">
	    			<div class="box box-solid">
	    				<div class="box-body">
			              	<div class="col-md-6">
				                <div class="form-group">
				      				<label class="left">Distribution ID</label>
                					<span class="left2">
                						<input type="text" class="form-control input-sm" name="distribution" id="distribution" readonly="">
					      			</span>
				      			</div>
				                <div class="form-group">
				      				<label class="left">Bank</label>
                					<span class="left2">
					      				<select class="form-control input-sm" name="BankID" id="BankID"></select>
					      			</span>
				      			</div>
				            	<div class="form-group">
				      				<label class="left">Date</label>
			      					<div class="input-group date">
			        					<div class="input-group-addon">
			        						<i class="fa fa-calendar">
			        						</i>
			        					</div>
			      						<input type="text" class="form-control input-sm" autocomplete="off" name="bmdate" id="bmdate">
			      					</div>
				            	</div>
			            	</div>
			            	<div class="col-md-6">
			                	<div class="form-group">
			                  		<label class="left">Type</label>
                					<span class="left2">
					                  	<select class="form-control input-sm" name="bmtype" id="bmtype"></select>
					      			</span>
			                  	</div>
			                 	<div class="form-group">
									<label class="left">Amount</label>
                					<span class="left2">
										<input type="text" class="form-control mask-number input-sm" placeholder="Bank Transaction Amount" autocomplete="off" name="bmamount" id="bmamount" min="0" step="0.01" readonly="">
									</span>
			                  	</div>
				                <div class="form-group">
				                	<label class="left">Note</label>
                					<span class="left2">
				                		<textarea class="form-control" rows="3" placeholder="Bank Transaction note" name="bmnote" id="bmnote"  readonly=""></textarea>
				                	</span>
				                </div>
			            	</div>
						</div>
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
	<div class="modal fade" id="modal-excelTransaction">
	    <div class="modal-dialog">
	      <div class="modal-content">
	          <div class="modal-header">
	              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                <span aria-hidden="true">&times;</span>
	              </button>
	              <h4 class="modal-title">Upload Excel Bank Distribution</h4>
	          </div>
			  <form name="form" action="<?php echo base_url();?>finance/excel_distribution" id="form_excel_distribution" method="post" enctype="multipart/form-data" autocomplete="off">
	            <div class="modal-body">
	    			<div class="box box-solid">
	    				<div class="box-body">
			              	<div class="col-md-6">
				                <div class="form-group">
				      				<label class="left">Bank</label>
                					<span class="left2">
					                  <select class="form-control input-sm company" style="width: 100%;" name="company" required="">
					                    <?php foreach ($fill_company as $row => $list) { ?>
					                    <option value="<?php echo $list['CompanyID'];?>"><?php echo $list['CompanyName'];?></option>
					                    <?php } ?>
					                  </select>  
					                  <input class="CompanyName" type="hidden" name="CompanyName" required="">
					      			</span>
				      			</div>
					            <div class="form-group">
					                <label class="left">Type</label>
					                <span class="left2">
					                  <select class="form-control input-sm DistributionTypeID" style="width: 100%;" name="type" required="">
					                    <option value=""></option>
					                  </select>  
					                </span>
				                  	<input class="bank2" type="hidden" name="bank2" required="">
					            </div>
								<div class="form-group">
									<label class="left">Upload Date</label>
									<div class="input-group date">
										<div class="input-group-addon">
											<i class="fa fa-calendar">
											</i>
										</div>
										<input type="text" class="form-control input-sm" autocomplete="off" name="filterupload" id="filterupload" required="">
								  	</div>
								</div>
			            	</div>
			            	<div class="col-md-6">
					            <div class="form-group">
					                <label class="left">Payment/Deposit</label>
					                <span class="left2">
					                  <select class="form-control input-sm" name="paymentdeposit" required="">
					                    <option value="manual">manual</option>
					                    <option value="auto_mpinv">Auto MPINV</option>
					                    <option value="auto_soinv">Auto SO/INV</option>
					                  </select>  
					                </span>
				                  	<input class="bank2" type="hidden" name="bank2" required="">
					            </div>
								<div class="form-group">
									<label for="exampleInputFile">Upload Transaction</label>
									<input type="file" class="input-file" id="excel" name="excel" required="" accept=".xls,.csv">
									<p class="help-block"></p>
								</div>
			            	</div>
						</div>
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

	<section class="content-header">
	    <h1>
      		<?php echo $PageTitle.' - '. $MainTitle; ?>
	    </h1>
	</section>
	<section class="content">
	    <div class="box box-solid">
	    	<div class="box-header">
		    	<div class="form-header-">
	        		<button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="1"><i class="fa fa-fw fa-print"></i> Print</button>
	        		<button type="button" class="btn btn-primary btn-xs print_all" title="PRINT" removeTd="1"><i class="fa fa-fw fa-print"></i> Print All</button>
			        <a href="<?php echo base_url();?>finance/bank_distribution_add" id="addbank_distribution" class="btn btn-primary btn-xs addbank_distribution"><b>+</b> Add Bank Distribution</a>
			       	<?php if (in_array('bank_transaction', $MenuList)) { ?>
			        	<a href="#" id="uploadata" class="btn btn-primary btn-xs uploadata" title="UPLOAD" data-toggle="modal" data-target="#modal-excelTransaction">Upload Excel Bank Distribution</a>
			        	<a href="#" id="enabledata" class="btn btn-success btn-xs enabledata">Enable Distribution</a>
			        	<a href="#" id="disabledata" class="btn btn-warning btn-xs disabledata">Disable Distribution</a>
			        	<a href="#" id="deletedata" class="btn btn-danger btn-xs deletedata" title="DELETE">Delete Distribution</a>
	            	<?php } ?>
	            	<a href="#" id="filterdata" class="btn btn-primary btn-xs filterdata" title="FILTER"><i class="fa fa-search"></i> Filter</a>
			        <span style="display: none;">
						<div class="form-group" style="margin-top: 5px;">
							<div class="input-group input-group-sm ">
						    	<select class="form-control input-sm CompanyList"></select>
							    <span class="input-group-btn">
							        <button type="button" class="btn btn-primary " onclick="cek_bank();"><i class="fa fa-fw fa-search"></i></button>
							    </span>
							</div>
						</div>
			        </span>
		    	</div>
		        <div class="divfilterdata">
		        	<form role="form" action="<?php echo base_url();?>finance/bank_distribution" method="post" >
			            <div class="col-md-6">
	                        <div class="form-group">
		                        <label class="left">Start</label>
		                        <span class="left2">
					                <div class="input-group">
					                  <div class="input-group-addon">
					                    <i class="fa fa-calendar"></i>
					                  </div>
					                  <input type="text" class="form-control input-sm" autocomplete="off" name="filterstart" id="filterstart">
					                </div>
		                        </span>
		                    </div>
	                        <div class="form-group">
		                        <label class="left">End</label>
		                        <span class="left2">
					                <div class="input-group">
					                  <div class="input-group-addon">
					                    <i class="fa fa-calendar"></i>
					                  </div>
		                  			  <input type="text" class="form-control input-sm" autocomplete="off" name="filterend" id="filterend">
					                </div>
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
				<table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
					<thead>
					    <tr>
							<th><input name="select_all" id="select_all" value="1" type="checkbox"></th>
							<th class=" alignCenter"> ID</th>
							<th class=" alignCenter"> Date</th>
							<th class=" alignCenter"> Company Name</th>
							<th class=" alignCenter"> Type</th>
							<th class=" alignCenter"> Note</th>
							<th class=" alignCenter"> Amount</th>
							<th class=" alignCenter"> Create By</th>
							<th class=" alignCenter"> Divisi</th>
							<th> </th>
					    </tr>
				    </thead>
				    <tbody>
				    <?php
				    if (isset($content)) {
				        foreach ($content as $row => $list) { ?>
				        <tr>
				            <td></td>
				            <td class=" alignCenter"><?php echo $list['DistributionID'];?></td>
				            <td class=" alignCenter"><?php echo date('Y-m-d', strtotime($list['DistributionDate']));?></td>
				            <td><?php echo $list['CompanyName'];?></td>
				            <td><?php echo $list['DistributionTypeName'];?></td>
				            <td><?php echo $list['DistributionNote'];?></td>
				            <td class="alignRight"><?php echo number_format($list['DistributionTotal'],2);?></td>
				            <td><?php echo $list['fullname'];?></td>
				            <td><?php echo $list['DivisiName'];?></td>
				            <td>
				            	<?php if ($list['isActive'] != 0) { ?>
					            	<?php if ($list['BankTransactionID'] != 0) { ?>
	                          			<i class="fa fa-fw fa-check-square-o" style="color: green;" title='<?php echo $list["BankTransactionDate"];?>'></i>
					            	<?php } elseif (in_array('bank_transaction_add', $MenuList)) { ?>
	                      				<button type="button" class="btn btn-primary btn-xs input_transaction" title="input into Transaction" distribution="<?php echo $list['DistributionID'];?>" amount="<?php echo $list['DistributionTotal'];?>" data-toggle="modal" data-target="#modal-inputTransaction"><i class="fa fa-fw fa-usd"></i></button>
					            	<?php } ?>

					            	<?php if ( $list['BankTransactionID'] == 0 && $list['DistributionReff'] == 'manual'  ) { ?>
	                          			<button type="button" class="btn btn-success btn-xs" title="EDIT" onclick="window.open('<?php echo base_url();?>finance/bank_distribution_add?id=<?php echo $list['DistributionID']; ?>');"><i class="fa fa-fw fa-edit"></i></button>
	                          			<button type="button" class="btn btn-danger btn-xs deleteDistribution" title="DELETE" distribution="<?php echo $list['DistributionID']; ?>"><i class="fa fa-fw fa-trash"></i></button>
					            	<?php } ?>

					            	<button type="button" class="btn btn-success btn-xs report" title="Report" reff="bank_distribution_print?id=<?php echo $list['DistributionID'];?>"><i class="fa fa-fw fa-print"></i></button>
				            	<?php } else { ?>
                          			<i class="fa fa-fw fa-minus-square" style="color: maroon;"></i>
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

    "order": [[ 1, "desc" ]],
    initComplete: function () {
        this.api().columns(3).every( function () {
            var column = this;
            column.data().unique().sort().each( function ( d, j ) {
                $('.CompanyList').append( '<option value="'+d+'">'+d+'</option>' )
            } );
        } );
    },

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

    $('.print_all').on('click', function(e){
		var data_selected = []; // for collecting data
     	var rows_selected2 = rows_selected.sort()
      	var valueBefore = ""
      	// $.each(rows_selected, function ( value, index ) {
		table.column( 1 ).data().each( function ( value, index ) {
			id = table.cell( index, 1 ).data();
	        type = table.cell( index, 4 ).data();
	        if($.inArray(id, rows_selected2) >= 0){
	            data_selected.push(id);

		        if (valueBefore === "" || valueBefore === type ) {
					valueBefore = type
				} else {
					data_selected.length = 0
					return false
				}
	        }
		});
		if (rows_selected2.length > 0 && rows_selected2.length === data_selected.length) {
			var win = window.open('<?php echo base_url();?>finance/bank_distribution_print_all?data='+data_selected, '_blank');
			win.focus();
		} else {
			alert("The Distribution selected is not from the same type")
		}
    }); 
  // ====================================================================


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

	$('#deletedata').on('click', function(e){
	  	var data_selected_delete = []; // for collecting data
 	  	var rows_selected2 = rows_selected.sort()
	  	table.column( 1 ).data().each( function ( value, index ) {
		    id = table.cell( index, 1 ).data();
	        if($.inArray(id, rows_selected2) >= 0){
		    	data_selected_delete.push(id);
	        }
	  	});
	  	var deleteDistributionBatch = confirm(data_selected_delete.length+" will be deleted.\nDo you really want to Delete it?");
    	if (deleteDistributionBatch == true) {
		  if (data_selected_delete.length > 0) {
		    $.post("<?php echo base_url();?>finance/distribution_delete_batch", {data: data_selected_delete}, function(result){
		    	alert( result+' distribution telah dihapus!')
		      	location.reload()
		    });
		  }
		}
	}); 
	$('#disabledata').on('click', function(e){
	  	var data_selected_disable = []; // for collecting data
 	  	var rows_selected2 = rows_selected.sort()
	  	table.column( 1 ).data().each( function ( value, index ) {
		    id = table.cell( index, 1 ).data();
	        if($.inArray(id, rows_selected2) >= 0){
		    	data_selected_disable.push(id);
	        }
	  	});
	  	var disableDistributionBatch = confirm(data_selected_disable.length+" will be disable.\nDo you really want to Disable it?");
    	if (disableDistributionBatch == true) {
		  if (data_selected_disable.length > 0) {
		    $.post("<?php echo base_url();?>finance/distribution_disable_batch", {data: data_selected_disable}, function(result){
		    	alert( result+' distribution telah di disable!')
		      	location.reload()
		    });
		  }
		}
	}); 
	$('#enabledata').on('click', function(e){
	  	var data_selected_enable = []; // for collecting data
 	  	var rows_selected2 = rows_selected.sort()
	  	table.column( 1 ).data().each( function ( value, index ) {
		    id = table.cell( index, 1 ).data();
	        if($.inArray(id, rows_selected2) >= 0){
		    	data_selected_enable.push(id);
	        }
	  	});
	  	var enableDistributionBatch = confirm(data_selected_enable.length+" will be enable.\nDo you really want to Enable it?");
    	if (enableDistributionBatch == true) {
		  if (data_selected_enable.length > 0) {
		    $.post("<?php echo base_url();?>finance/distribution_enable_batch", {data: data_selected_enable}, function(result){
		    	alert( result+' distribution telah di enable!')
		      	location.reload()
		    });
		  }
		}
	}); 
});

function cek_bank() {
	j11('#dt_list').dataTable().fnFilter(j11('.CompanyList').val());
};
function updateDataTableSelectAllCtrl(table){ // for adding checkbox
  var $table             = table.table().node();
  var $chkbox_all        = j11('tbody input[type="checkbox"]', $table);
  var $chkbox_checked    = j11('tbody input[type="checkbox"]:checked', $table);
  var chkbox_select_all  = j11('thead #select_all');
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

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url();?>tool/jquery.inputmask.bundle.js"></script>
<script>
var j8 = $.noConflict(true);
j8( document ).ready(function( $ ) {
  	 
    $( ".company" ).trigger( "change" );
  
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
	$(".mask-number").inputmask({ 
	  alias:"currency", 
	  prefix:'', 
	  autoUnmask:true, 
	  removeMaskOnSubmit:true, 
	  showMaskOnHover: true 
	});
	$('#bmdate').daterangepicker({ 
		timePicker: true, 
		singleDatePicker: true,
		startDate: new Date(),
		// minDate: moment().add(-1, 'M').toDate(),
		// minDate: "2018-07-25",
		maxDate: moment(),
		locale: {
		  format: 'YYYY-MM-DD HH:mm:ss'
		}
	})
	$('#filterupload').daterangepicker({ 
		timePicker: true, 
		singleDatePicker: true,
		startDate: new Date(),
		minDate: moment().add(-1, 'M').toDate(),
		// minDate: "2018-07-25",
		maxDate: moment(),
		locale: {
		  format: 'YYYY-MM-DD HH:mm:ss'
		}
	})

	$(".report").live('click', function() {
		reff = $(this).attr("reff")
		openPopupOneAtATime2(reff);
	});
	$('.set_transaction').live('click',function(e){
		distribution = $(this).attr("distribution");
		amount = $(this).attr("amount");
		$('.DistributionID').val(distribution);
		$('.DistributionAmount').val(amount);
	});
	$('.input_transaction').live('click',function(e){
		$('#form_inputIntoBankTransaction input, #form_inputIntoBankTransaction select').empty()
		DistributionID = $(this).attr("distribution");
		$.ajax({
	      url: "<?php echo base_url();?>finance/get_distribution_detail",
	      type : 'POST',
	      data: {DistributionID: DistributionID},
	      dataType : 'json',
	      success : function (response) {
	        console.log(response)
	        $('#distribution').empty().val(response['DistributionID']);
	        $('#BankID').empty().append("<option value='"+response['BankID']+"'>"+response['BankName']+"</option>");
	        $('#bmtype').empty().append("<option value='"+response['DistributionTypeTransaction']+"'>"+response['DistributionTypeTransaction']+"</option>");
	        $('#bmamount').empty().val(response['DistributionTotal']);
	        $('#bmnote').empty().val(response['DistributionNote']);
	      }
	    })
	});
	$(".BankTransactionID").live('change', function() {
		$(".BankTransactionAmount").val(0)
	});
	$("#form_setBankTransactionID").submit(function(e) {
		DistributionAmount = $(".DistributionAmount").val()
		BankTransactionAmount = $(".BankTransactionAmount").val()
		DiffAmount = Math.abs(DistributionAmount - BankTransactionAmount)
		if (DiffAmount !== 0) {
			var r = confirm("Nilai Distribution tidak sama dengan nilai transfer Bank,\n Apakah anda yakin ?");
			if (r == false) {
				e.preventDefault();
				return false
			}
		}
	});

	$('.deleteDistribution').live('click',function(e){
		DistributionID = $(this).attr("distribution");
	  	var deleteDistributionConfirm = confirm("Distribution ID "+DistributionID+" will be deleted.\nDo you really want to Delete it?");
    	if (deleteDistributionConfirm == true) {
			$.ajax({
		      url: "<?php echo base_url();?>finance/bank_distribution_delete",
		      type : 'POST',
		      data: {DistributionID: DistributionID},
		      dataType : 'json',
		      success : function (response) {
		      	if (response === "success") {
		      		alert("Success, hapus Bank Distribution Berhasil")
		      		location.reload();
		      		return false;
		      	} else {
		      		alert("Fail, hapus Bank Distribution gagal!")
		      	}
		      }
		    })
		}
	}); 

});

j8(".company").live('change', function() {
	var par = j8('.DistributionTypeID')
	j8.ajax({
	  url: "<?php echo base_url();?>finance/fill_bank_distribution_type",
	  type : 'POST',
	  data: {CompanyID: j8(this).val()},
	  dataType : 'json',
	  success : function (response) {
	    // console.log(response)
	    var len = response.length;
	    par.empty();
	    par.append("<option value='0'></option>");
	    for( var i = 0; i<len; i++){
	        var DistributionTypeID = response[i]['DistributionTypeID'];
	        var DistributionTypeName = response[i]['DistributionTypeName'];
	        var BankID = response[i]['BankID'];
	        par.append("<option value='"+DistributionTypeID+"' bank='"+BankID+"'>"+DistributionTypeName+"</option>");
	    }
	    $(".CompanyName").val( $(".company option:selected").text() );
	  }
	})
});
j8(".DistributionTypeID").live('change', function() {
    $(".bank2").val( $(".DistributionTypeID option:selected").attr('bank') );
});

function cekAmountTransaction() {
  BankTransactionID = $('.BankTransactionID').val()
  $.ajax({
    url: "<?php echo base_url();?>finance/cekAmountTransaction",
    type : 'POST',
    data: {BankTransactionID: BankTransactionID},
    dataType : 'json',
    success : function (response) {
    	$('.BankTransactionAmount').val(response)
    }
  })
}
</script>