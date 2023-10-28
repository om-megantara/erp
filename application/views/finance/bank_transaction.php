<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
<style type="text/css">
	.divfilterdate, .divuploadata, .form-addbank_transaction, .divdailyreport, .divreCalculate {
		display: none;
		border: 1px solid #0073b7; 
		padding: 4px; 
		margin: 5px 0px;
		overflow: auto;
	}
	.transaction, .transaction2 { margin-top: 2px; }
	.divvalue {	padding: 10px !important; }
	.divvalue td:last-child { padding-right: 20px !important; }
	.divvalue .table-bank td { 
		font-size: 12px;
		padding: 5px 2px;
		font-weight: bold;
	} 
	.divvalue .table-bank td:first-child { 
		/*min-width: 230px; */
		border-left: 1px solid #000; 
		padding-left: 10px !important;
	}
	.divvalue h4 {
		margin-bottom: 2px !important;
		margin-top: 2px !important;
		display: inline-block;
	}
	.form-button .btn { margin: 1px; }
  @media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 130px;
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
	</section>
	<section class="content">
	    <div class="box box-solid">
	    	<div class="box-header">
	    		<div class="col-md-6">
					<div class="form-button">
	        			<button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT"><i class="fa fa-fw fa-print"></i> Print</button>
				        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>
				        <a href="#" id="setasdeposit" class="btn btn-primary btn-xs check" title="SET AS DEPOSIT">SetAs Deposit</a>
				        <a href="#" id="undodeposit" class="btn btn-primary btn-xs check" title="UNDO">UnDo Deposit</a>
				        <a href="#" id="deletetransaction" class="btn btn-primary btn-xs check" title="DELETE">Delete Transaction</a>
		            	<?php if (in_array('bank_transaction_add2', $MenuList)) { ?>
				        <a href="#" id="addbank_transaction" class="btn btn-primary btn-xs addbank_transaction" title="ADD"><b>+</b> Add Bank Transaction</a>
				        <a href="#" id="uploadata" class="btn btn-primary btn-xs uploadata" title="UPLOAD">Upload Excel Bank Transaction</a>
		            	<?php } ?>
		            	<?php if (in_array('bank_transaction_add', $MenuList)) { ?>
				        <a href="#" id="dailyreport" class="btn btn-primary btn-xs dailyreport">Daily Report</a>
				        <a href="#" id="printbankdistribution" class="btn btn-primary btn-xs printbankdistribution"><i class="fa fa-fw fa-print"></i> print BankDistribution</a>
				        <a href="#" id="reCalculate" class="btn btn-primary btn-xs reCalculate">reCalculate</a>
		            	<?php } ?>
	    			</div>
					<div class="form-group" style="margin-top: 5px;">
						<div class="input-group input-group-sm ">
					    	<!-- <input type="text" class="form-control input-sm BankList" data-column="2"> -->
					    	<select class="form-control BankList"></select>
						    <span class="input-group-btn">
						        <button type="button" class="btn btn-primary " onclick="cek_bank();">CEK</button>
						    </span>
						</div>
					</div>
	    		</div>

		        <div class="divvalue col-md-6 table-responsive" style="max-height: 180px; overflow: auto;">
			        	<h4>Saldo Bank</h4>
			        	<table class="table nowrap table-bank" style="margin-bottom: 5px !important;">
				        	<?php 
				        		for ($i=0; $i < count($content['bank']) ; $i++) { 
								    // if ( ($i>1) && !($i % 2) ){ echo "</td><td>"; }
				        	?>
				        			<tr>
				        				<td> <?php echo $content['bank'][$i]['BankName'];?></td>
				        				<td> : </td>
				        				<td class="dtAlignRight"><?php echo "Rp. ".number_format($content['bank'][$i]['BankBalance'],2) ;?></td>
					        		</tr>
				        	<?php } ?>
			        	</table>
		        </div>
		        <div class="divdailyreport">
		        	<div class="box-body">
			          <form role="form" id="formdailyreport" action="<?php echo base_url();?>finance/bank_transaction_daily_report" method="post" target="_blank">
			              <div class="box box-solid ">
			                  <div class="box-header">
			                    <h3 class="box-title">PRINT TRANSACTION DAILY REPORT</h3>
			                    <button type="submit" class="btn btn-primary btn-sm pull-right">Submit</button>
			                  </div>
			                  <div class="box-body">
			                    <div class="col-md-6">
			                        <div class="form-group">
				                        <label class="left">Bank</label>
				                        <span class="left2">
				                          <select class="form-control input-sm" name="bank" id="bank4"></select>
				                        </span>
				                    </div>
				                    <div class="form-group">
				                        <label class="left">Date Start</label>
				                        <div class="input-group date">
				                          <div class="input-group-addon">
				                            <i class="fa fa-calendar">
				                            </i>
				                          </div>
				                          <input type="text" class="form-control input-sm" autocomplete="off" name="bmdateStart" id="bmdate4Start">
				                        </div>
				                    </div>
				                    <div class="form-group">
				                        <label class="left">Date End</label>
				                        <div class="input-group date">
				                          <div class="input-group-addon">
				                            <i class="fa fa-calendar">
				                            </i>
				                          </div>
				                          <input type="text" class="form-control input-sm" autocomplete="off" name="bmdateEnd" id="bmdate4End">
				                        </div>
				                    </div>
			                    </div>
			                    <div class="col-md-6">
						            <div class="row rowAddDetail">
						              <div class="col-xs-7">
					                  	<input type="text" class="form-control input-sm addMain" name="addMain[]">
						              </div>
						              <div class="col-xs-5">
						                <div class="input-group addDetail">
						                  <input type="text" class="form-control input-sm addDetailAmount mask-number" name="addDetailAmount[]" value="0">
						                  <span class="input-group-btn">
						                    <button type="button" class="btn btn-primary btn-sm  add_field" onclick="duplicateRowAdd();">+</button>
						                    <button type="button" class="btn btn-primary btn-sm  add_field" onclick="if ($('.rowAddDetail').length != 1) { $(this).closest('.rowAddDetail').remove();}">-</button>
						                  </span>
						                </div>
						              </div>
						            </div>
			                    </div>
			                  </div>
			              </div>
			          </form>
					</div>
		        </div>
		        <div class="divuploadata">
		        	<div class="box-body">
						<form name="form employee_add" action="<?php echo base_url();?>finance/excel_transaction" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
			 	  	  		<div class="col-md-5">
								<div class="form-group">
									<label class="left">Bank</label>
                					<span class="left2">
										<select class="form-control input-sm" name="bank2" id="bank2">
											<option value="0" >---TOP---</option>
										</select>
									</span>
								</div>
								<div class="form-group">
									<label class="left">Upload Date</label>
									<div class="input-group date">
										<div class="input-group-addon">
											<i class="fa fa-calendar">
											</i>
										</div>
										<input type="text" class="form-control input-sm" autocomplete="off" name="filterupload" id="filterupload">
								  	</div>
								</div>
							</div>
					  		<div class="col-md-5">
								<div class="form-group">
									<label for="exampleInputFile">Upload Transaction</label>
									<input type="file" class="input-file" id="excel" name="excel">
									<p class="help-block"></p>
									<input class="submit" type="submit" value="Submit">
								</div>
							</div>
						</form>
					</div>
		        </div>
		        <div class="divfilterdate">
		        	<form role="form" action="<?php echo base_url();?>finance/bank_transaction" method="post" >
			            <div class="col-md-6">
			              <div class="form-group">
			                  <label class="left">Bank</label>
			                  <span class="left2">
			                    <select class="form-control input-sm" name="bank" id="bank3">
			                      <option value="0" >All</option>
			                    </select>
			                  </span>
			              </div>
			              <div class="form-group">
			                <label class="left">Search</label>
			                <span class="left2">
			                  <div class="input-group input-group-sm">
			                      <select class="form-control input-sm atributelist" style="width: 100%;" name="atributelist" required="">
			                        <option value="BankTransactionID">ID</option>
			                        <option value="BankBranch">Branch</option>
			                        <option value="BankTransactionNote">Note</option>
			                        <option value="Customer">Customer</option>
			                      </select>
			                      <span class="input-group-btn">
			                        <button type="button" class="btn btn-primary  add_field" onclick="createattribute();">+</button>
			                      </span>
			                  </div>
			                </span>
			              </div>
			                <label id="atributelabel"></label>
			            </div>
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
			            <div class="col-md-12" style="text-align: center;">
			              <button type="submit" class="btn btn-primary btn-sm">Submit</button>
			            </div>
		        	</form>
		        </div>
		        <div class="col-md-12 form-addbank_transaction with-border">
		        	<form role="form" action="<?php echo base_url();?>finance/bank_transaction_add" method="post" >
			        	<div class="box box-solid ">
			            	<div class="box-header">
				            	<h3 class="box-title">Add Bank Transaction</h3>
				            	<button type="submit" class="btn btn-primary btn-sm pull-right">Submit</button>
			            	</div>
			            	<div class="box-body">
				              	<div class="col-md-6">
					                <div class="form-group">
					      				<label class="left">Bank</label>
	                					<span class="left2">
						      				<select class="form-control input-sm" name="bank" id="bank"></select>
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
					                <div class="form-group">
					                	<label class="left">Note</label>
	                					<span class="left2">
					                		<textarea class="form-control" rows="3" placeholder="Bank Transaction note" name="bmnote" id="bmnote"></textarea>
					                	</span>
					                </div>
				            	</div>
				            	<div class="col-md-6">
				                	<div class="form-group">
				                  		<label class="left">Type</label>
	                					<span class="left2">
						                  	<select class="form-control input-sm" name="bmtype" id="bmtype">
						        				<option value="credit">Credit</option>
						        				<option value="debit">Debit</option>
						      				</select>
						      			</span>
				                  	</div>
				                 	<div class="form-group">
										<label class="left">Amount</label>
	                					<span class="left2">
											<input type="text" class="form-control mask-number input-sm" placeholder="Bank Transaction Amount" autocomplete="off" name="bmamount" id="bmamount" min="0" step="0.01">
										</span>
				                  	</div>
				            	</div>
			            	</div>
			        	</div>
		          	</form>
		        </div>
		        <div class="divreCalculate">
	            	<div class="box-header">
		            	<h3 class="box-title">Saldo Bank reCalculate</h3>
	            	</div>
		        	<div class="box-body">
						<form name="form" action="<?php echo base_url();?>finance/transaction_recalculate" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
			 	  	  		<div class="col-md-6">
								<div class="form-group">
									<label class="left">Bank</label>
                					<span class="left2">
										<select class="form-control input-sm" name="bank" id="bank5">
										</select>
									</span>
								</div>
				            	<div class="form-group">
				      				<label class="left">Date</label>
			      					<div class="input-group date">
			        					<div class="input-group-addon">
			        						<i class="fa fa-calendar">
			        						</i>
			        					</div>
			      						<input type="text" class="form-control input-sm" autocomplete="off" name="DateCalculate" id="DateCalculate">
			      					</div>
				            	</div> 
							</div>
					  		<div class="col-md-6">
              					<button type="submit" class="btn btn-primary pull-center">Submit</button> 
							</div>
						</form>
					</div>
		        </div>
	      	</div>
			<div class="box-body">
				<table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
					<thead>
					    <tr>
							<th><input name="select_all" id="select_all" value="1" type="checkbox"></th>
							<th id="order" class=" alignCenter">ID</th>
							<th class=" alignCenter"> Date</th>
							<th class=" alignCenter"> Bank Name</th>
							<th class=" alignCenter"> Note</th>
							<th class=" alignCenter"> Type</th>
							<th class=" alignCenter"> Amount</th>
							<th class=" alignCenter"> Balance</th>
							<th class=" alignCenter"> Deposit To</th>
					    </tr>
				    </thead>
				    <tbody>
				    <?php
				        // echo count($content);
				    if (isset($content['main'])) {
				        foreach ($content['main'] as $row => $list) { ?>
				        <tr>
				            <td></td>
				            <td><?php echo $list['BankTransactionID'];?></td>
				            <td><?php echo date('Y-m-d', strtotime($list['BankTransactionDate']));?></td>
				            <td><?php echo $list['BankName'];?></td>
				            <td><?php echo $list['BankTransactionNote'];?></td>
				            <td><?php echo $list['BankTransactionType'];?></td>
				            <td class="dtAlignRight"><?php echo number_format($list['BankTransactionAmount'],2);?></td>
				            <td class="dtAlignRight"><?php echo number_format($list['BankTransactionBalance'],2);?></td>
				            <?php 
				            if ($list['IsDeposit'] == 1 ) { 
				            	if ($list['DepositCustomer'] == null) { ?>
				            	<td style="font-weight: bold; color: #f39c12;"><?php echo "NotYetConfirmed";?></td>
				            <?php } else { ?>
				            	<td style="font-weight: bold; color: #0073b7;"><?php echo $list['fullname'];?></td>
				            <?php } } else { ?>
				            	<td style="font-weight: bold; color: #00a65a;"><?php echo "NotDeposit";?></td>
				            <?php } ?>
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
<script src="<?php echo base_url();?>tool/jquery.inputmask.bundle.js"></script>
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
	    {"targets": 1, "width": "1%"},
	    {"targets": 2, "width": "1%"},
	    {"targets": 5, "width": "40%"},
	    {"targets": 6, "orderable": false, "width": "1%"},
	    {"targets": 7, "orderable": false, "width": "1%"},
	    
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
    "order": [[ 1, "desc" ]],

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
    initComplete: function () {
        this.api().columns(3).every( function () {
            var column = this;
            column.data().unique().sort().each( function ( d, j ) {
                $('.BankList').append( '<option value="'+d+'">'+d+'</option>' )
            } );
        } );
    },
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

    $('#setasdeposit').on('click', function(e){
      var data_selected = []; // for collecting data
      var rows_selected2 = rows_selected.sort()
      table.column( 1 ).data().each( function ( value, index ) {
        id = table.cell( index, 1 ).data();
        type = table.cell( index, 5 ).data();
        if($.inArray(id, rows_selected2) >= 0){
          if (type === "debit" ) {
            data_selected.push(id);
          } else {
            alert("Transaction yg dipilih harus debit !!!")
            data_selected.length = 0
            return false
          }
        }
      });
      if (data_selected.length !== 0 && data_selected.length === rows_selected2.length) {
        alert(data_selected.length+" Transaction dipilih untuk deposit !!!")
        $.post("<?php echo base_url();?>finance/transaction_setasdesposit", {data: data_selected}, function(result){
        	response = jQuery.parseJSON(result);
        	alert(response['TransactionSuccess']+" Transaction sukses,\n"+response['TransactionFail']+" Transaction gagal!!!")
          	location.reload()
        });
      }
    }); 
    $('#undodeposit').on('click', function(e){
      var data_selected = []; // for collecting data
      var rows_selected2 = rows_selected.sort()
      table.column( 1 ).data().each( function ( value, index ) {
        id = table.cell( index, 1 ).data();
        type = table.cell( index, 5 ).data();
        if($.inArray(id, rows_selected2) >= 0){
          if (type === "debit" ) {
            data_selected.push(id);
          } else {
            alert("Transaction yg dipilih harus debit !!!")
            data_selected.length = 0
            return false
          }
        }
      });
      if (data_selected.length !== 0 && data_selected.length === rows_selected2.length) {
        $.post("<?php echo base_url();?>finance/transaction_undodesposit", {data: data_selected}, function(result){
          // console.log(result)
          // location.reload()
        });
      }
    }); 
    $('#deletetransaction').on('click', function(e){
      var data_selected = []; // for collecting data
      var rows_selected2 = rows_selected.sort()
      var bankBefore = ""
      table.column( 1 ).data().each( function ( value, index ) {
        id = table.cell( index, 1 ).data();
        bank = table.cell( index, 3 ).data();
        type = table.cell( index, 8 ).data();
        if($.inArray(id, rows_selected2) >= 0){
          if (type == "NotDeposit" ) {
          	if (bankBefore === "" || bankBefore === bank ) {
            	data_selected.push(id);
            	bankBefore = bank 
          	} else {
	            alert("Transaction yg dipilih harus bank yang sama !!!")
	            data_selected.length = 0
	            return false
	          }
          } else {
            alert("Transaction yg dipilih harus bukan deposit !!!")
            data_selected.length = 0
            return false
          }
        }
      });
      if (data_selected.length !== 0 && data_selected.length === rows_selected2.length) {
      	data_selected = data_selected.sort()
		$.ajax({
		  url: '<?php echo base_url();?>finance/transaction_delete',
		  type: 'post',
		  data: {data: data_selected},
		  dataType: 'json',
		  success:function(response){
	          if (response === 'success') {
	          	alert('success, hapus transaction berhasil!')
	          	location.reload()
				return false
	          } else {
	          	alert('fail!')
	          }
	      } 
		});
      }
    }); 
    $('.printbankdistribution').on('click', function(e){
		var data_selected = []; // for collecting data
     	var rows_selected2 = rows_selected.sort()
      	var valueBefore = ""
      	// $.each(rows_selected, function ( value, index ) {
		table.column( 1 ).data().each( function ( value, index ) {
			id = table.cell( index, 1 ).data();
	        type = table.cell( index, 5 ).data();
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
			var win = window.open('<?php echo base_url();?>finance/bank_distribution_print_all?source=banktransaction&data='+data_selected, '_blank');
			win.focus();
		} else {
			alert("The Distribution selected is not from the same type")
		}
    });  
  // ====================================================================

  $('a.toggle-vis').on( 'click', function (e) {
      e.preventDefault();
      var column = table.column( $(this).attr('data-column') );
      column.visible( ! column.visible() );
      table.columns.adjust().draw();
  } );
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

function cek_bank() {
	j11('#dt_list').dataTable().fnFilter(j11('.BankList').val());
};

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

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.inputmask.bundle.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script>
var j8 = $.noConflict(true);
j8( document ).ready(function( $ ) {
	 
	$(".mask-number").inputmask({ 
	  alias:"currency", 
	  prefix:'', 
	  autoUnmask:true, 
	  removeMaskOnSubmit:true, 
	  showMaskOnHover: true 
	});
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
	$("#bmdate4Start").datepicker({ 
	    "setDate": new Date(), 
	    autoclose: true, 
	    format: 'yyyy-mm-dd',
	    todayBtn:  1,
	  }).on('changeDate', function (selected) {
	      var minDate = new Date(selected.date.valueOf());
	      $('#bmdate4End').datepicker('setStartDate', minDate);
	});
	$("#bmdate4End").datepicker({ 
		"setDate": new Date(), 
		autoclose: true, 
		format: 'yyyy-mm-dd',
		}).on('changeDate', function (selected) {
			var maxDate = new Date(selected.date.valueOf());
			$('#bmdate4Start').datepicker('setEndDate', maxDate);
	});
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
	$('#DateCalculate').daterangepicker({ 
		timePicker: true, 
		singleDatePicker: true,
		startDate: new Date(),
		maxDate: moment(),
		locale: {
		  format: 'YYYY-MM-DD HH:mm:ss'
		}
	})
	fill_transaction();

	$(".addbank_transaction").click(function(){
		$(".form-addbank_transaction").slideToggle();
	});
	$(".filterdate").click(function(){
		$(".divfilterdate").slideToggle();
	});
	$(".uploadata").click(function(){
		$(".divuploadata").slideToggle();
	});
	$(".dailyreport").click(function(){
		$(".divdailyreport").slideToggle();
	});
	$(".reCalculate").click(function(){
		$(".divreCalculate").slideToggle();
	});
	$('.edit').live('click',function(e){
		par   = $(this).parent().parent();
		id    = par.find("td:nth-child(1)").html();
		name  = par.find("td:nth-child(2)").html();
		$("#id").val(id);
		$("#name2").val(name);

		len = $('.transaction2').length;
		for( var i = 1; i<len; i++){
		  if ($('.transaction2').length != 1) { $('.transaction2:last').remove();}
		}
		$.ajax({
		  url: '<?php echo base_url();?>master/get_bank_transaction_value',
		  type: 'post',
		  data: {id:id},
		  dataType: 'json',
		  success:function(response){
		    len = response.length;
		    for( var i = 0; i<len; i++){
		      console.log(i);
		      $("select.transactionchild2:last").val(response[i]);
		      $(".transactionchild2:last").prop("disabled", true);
		      $(".transaction2:last").clone().insertAfter(".transaction2:last");
		    }
		    $('.transaction2:last').remove();
		  }
		});
		$( ".form-editbank_transaction" ).slideDown( "slow", function() { });
	});
	$('.form-editbank_transaction form').live('submit', function() {
	  $(this).find(':disabled').removeAttr('disabled');
	});
});

function duplicatetransaction() { $(".transaction:last").clone().insertAfter(".transaction:last"); }
function duplicatetransaction2() { 
  $(".transaction2:last").clone().insertAfter(".transaction2:last"); 
  $(".transactionchild2:last").prop("disabled", false);
}
function fill_transaction() {
  $.ajax({
    url: '<?php echo base_url();?>finance/fill_transaction',
    type: 'post',
    dataType: 'json',
    success:function(response){
      var len = response.length;
      // $(".categorychild2").empty();
      for( var i = 0; i<len; i++){
        var BankName = response[i]['BankName'];
        var BankID = response[i]['BankID'];
        $("#bank").append("<option value='"+BankID+"'>"+BankName+"</option>");
		$("#bank2").append("<option value='"+BankID+"'>"+BankName+"</option>");
		$("#bank3").append("<option value='"+BankID+"'>"+BankName+"</option>");
		$("#bank4").append("<option value='"+BankID+"'>"+BankName+"</option>");
		$("#bank5").append("<option value='"+BankID+"'>"+BankName+"</option>");
      }
    }
  });
}

function duplicateRowAdd() {
    j8(".rowAddDetail:last").clone().insertAfter(".rowAddDetail:last");
    j8(".addDetailAmount:last").inputmask({
        alias:"currency", 
        prefix:'', 
        autoUnmask:true, 
        removeMaskOnSubmit:true, 
        showMaskOnHover: true 
    });
}
j8("#formdailyreport").submit(function(e) {
	if ($('.rowAddDetail').length > 1) {
		$('.rowAddDetail').find('input').attr('required', true)
	} else {
		$('.rowAddDetail').find('input').attr('required', false)
	}
});

function createattribute() {
	atributelist = $(".atributelist").val()
	$(".rowtext:first .atributeid").val(atributelist);
	$(".rowtext:first").clone().insertBefore('#atributelabel');
}
</script>