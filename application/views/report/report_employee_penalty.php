<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">
	.divuploadata, .divfilter, .divShowGroup {
		margin-top: 5px;
		border: 1px solid #367fa9;
		display: none;
	}

    #dt_list_wrapper td, #dt_list_wrapper th, 
    .table-group td, .table-group th { 
      white-space: nowrap; 
      vertical-align: top !important;
    }
    #dt_list_wrapper td:nth-child(1), #dt_list_wrapper th:nth-child(1) { width: 50px; } 
    #dt_list_wrapper td:nth-child(2), #dt_list_wrapper th:nth-child(2) { width: 80px; } 
    #dt_list_wrapper td:nth-child(3), #dt_list_wrapper th:nth-child(3) { width: 160px; } 
    #dt_list_wrapper tbody td {
      padding-top: 4px;
      padding-bottom: 4px;
      vertical-align: middle;
    }
    #dt_list_wrapper tbody, #dt_list_wrapper thead, #dt_list_wrapper tfoot,
    .table-group tbody, .table-group thead, .table-group tfoot {
      font-size: 12px !important;
      /*font-weight: bold;*/
    }
    .table-group td {
    	padding: 2px 8px !important;
    }
    #dt_list_wrapper select {
	    font-size: 12px;
	    padding: 2px;
	    width: auto;
	    height: 25px;
    }

    .warning { color: red; }
    .freeDay { background-color: #c1c1c1; }
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

	<section class="content-header">
	    <h1>
      		<?php echo $PageTitle.' - '. $MainTitle; ?>
	    </h1>
	</section>
	<section class="content">
	    <div class="box box-solid">
	    	<div class="box-header">
				<div class="form-button"> 
        			<button type="button" class="btn btn-primary btn-xs print_dt" removeTd="1"><i class="fa fa-fw fa-print"></i> Print</button>
        			<a href="#" id="filter" class="btn btn-primary btn-xs filter"><i class="fa fa-search"></i> Filter</a> 
    			</div> 
		        <div class="divfilter">
		        	<div class="box-body">
						<form name="form" action="<?php echo current_url();?>" method="post" enctype="multipart/form-data" autocomplete="off"> 
					  		<div class="col-md-6">
				                <div class="form-group">
				                  <label class="left">Month Start</label>
				                  <div class="input-group">
				                    <div class="input-group-addon">
				                      <i class="fa fa-calendar"></i>
				                    </div>
				                    <input type="text" class="form-control input-sm" autocomplete="off" name="datestart" id="datestart" required="">
				                  </div>
				                </div>
				                <div class="form-group">
				                  <label class="left">Month End</label>
				                  <div class="input-group">
				                    <div class="input-group-addon">
				                      <i class="fa fa-calendar"></i>
				                    </div>
				                    <input type="text" class="form-control input-sm" autocomplete="off" name="dateend" id="dateend" required="">
				                  </div>
				                </div>
							</div>
					  		<div class="col-md-12">
				                <center>
				                  <button type="submit" class="btn btn-primary btn-sm">Submit</button>
				                </center> 
				            </div>
						</form>
					</div>
		        </div>
	      	</div>
    		<div class="box-body table-responsive" style="overflow-x: auto; max-height: 800px;">
		        <table id="dt_list" class="table table-bordered " style="width: 100%;">
		          <thead>
		            <tr>
		              <th>No</th>
		              <th>Employee ID</th>
		              <th>Name</th>
		              <th>Penalty</th>
		              <th>Total Nominal</th>
		              <th></th>
		            </tr>
		          </thead>
		          <tbody>
		            <?php
		              if (isset($content['main'])) {
		              	$no=0;
		                  foreach ($content['main'] as $row => $list) {
		                  	$no++;
		            ?>
		                  <tr>
		                      <td><?php echo $no;?></td>
		                      <td><?php echo $list['EmployeeID'];?></td>
		                      <td><?php echo $list['fullname'];?></td>
		                      <td class="alignRight"><?php echo number_format($list['penalty'])." x";?></td>
		                      <td class="alignRight"><?php echo "Rp ".number_format($list['Nominal']);?></td>
		                      <td>
								<button type="button" class="btn btn-primary btn-xs detail" title="DETAIL" datestart="<?php echo $list['datestart']; ?>" dateend="<?php echo $list['dateend']; ?>" id="<?php echo $list['EmployeeID']; ?>" data-toggle="modal" data-target="#modal-detail"><i class="fa fa-fw fa-search"></i></button>
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
<script src="<?php echo base_url();?>tool/jquery.inputmask.bundle.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script>
var j8 = $.noConflict(true);
j8( document ).ready(function( $ ) {

  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
    "scrollY": true,
    "scrollCollapse": true, 
    "paging":   false,
  })

  var cek_dt = function() {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

  	$('.select2').select2(); 
	$(".filter").click(function(){
		$(".divfilter").slideToggle();
	});  

	$("#datestart").datepicker({ 
	    format: "yyyy-mm-dd",
	    autoclose: true, 
	    format: 'yyyy-mm-dd',
	    // viewMode: "months", 
	    // minViewMode: "months"
	}).on('changeDate', function (selected) {
	    var minDate = new Date(selected.date.valueOf());
	    $('#dateend').datepicker('setStartDate', minDate);
	});
	$("#dateend").datepicker({ 
	    format: "yyyy-mm-dd",
	    autoclose: true, 
	    format: 'yyyy-mm-dd',
	    // viewMode: "months", 
	    // minViewMode: "months"
	}).on('changeDate', function (selected) {
	    var maxDate = new Date(selected.date.valueOf());
	    $('#datestart').datepicker('setEndDate', maxDate);
	});

	$('.detail').live('click', function(e){
	    id  = $(this).attr("id")
	    datestart  = $(this).attr("datestart")
	    dateend  = $(this).attr("dateend")
	    get(id, datestart, dateend);
	});  
	function get(id, datestart, dateend) {
		xmlHttp=GetXmlHttpObject()
		var url="<?php echo base_url();?>report/report_employee_penalty_detail"
		url=url+"?id="+id+"&datestart="+datestart+"&dateend="+dateend
		document.getElementById("detailcontent").innerHTML='<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
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
});

j8('button.print_dt').on('click', function() {               
  // var fvData = table.rows({ search:'applied', page: 'all' }).data(); 
  table = $("#dt_list_wrapper").html();
  $('.div_dt_print').empty().append(
		'<style type="text/css">.warning { color: red; }</style>' +
  		$('div.info_filter').html() + 
	     '<table id="dtTablePrint" class="col">' +
	     '<thead></thead>' +
	     '<tbody></tbody></table>'
  );

	$('#dt_list_wrapper thead').each(function(){
	    var row = $(this).html();
	    $('#dtTablePrint thead').append('<tr>'+row+'</tr>');
	});
	$('#dt_list_wrapper tbody').each(function(){
	    var row = $(this).html();
	    $('#dtTablePrint tbody').append('<tr>'+row+'</tr>');
	});
  	for (var i = 0; i < $('button.print_dt').attr('removeTd'); i++) {
    	$("#dtTablePrint th:first-child, #dtTablePrint td:first-child").remove();
  	}

  var w = window.open();
  var html = $(".div_dt_print").html();
  $(w.document.body).append('<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">');
  $(w.document.body).append("<link href='<?php echo base_url();?>tool/dtPrint.css' rel='stylesheet' type='text/css' />");
  $(w.document.body).append(html);
});
</script>