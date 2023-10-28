<link rel="stylesheet" href="<?php echo base_url();?>assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap-datepicker.min.css">
<style type="text/css">
  @media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 100px;
      padding: 5px;
    }
    .form-group span.left2 {
      display: block;
      overflow: hidden;
    }
    .form-group { margin-bottom: 10px; }
  }
</style>

<div class="modal fade" id="modal-customer" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form role="form" action="<?php echo base_url();?>master_data/customer_cu" method="post">
      <div class="modal-header">
        <h4 class="modal-title">Add / Edit Customer</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row"> 
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">Customer ID</label>
              <span class="left2">
                <input type="text" name="CustomerID" id="CustomerID" class="form-control form-control-sm" readonly="">
              </span>
            </div>
            <div class="form-group">
              <label class="left">Name</label>
              <span class="left2">
                <input type="text" name="CustomerName" id="CustomerName" class="form-control form-control-sm">
              </span>
            </div>
            <div class="form-group">
              <label class="left">Phone</label>
              <span class="left2">
                <input type="phone" name="CustomerPhone" id="CustomerPhone" class="form-control form-control-sm">
              </span>
            </div>
            <div class="form-group">
              <label class="left">Email</label>
              <span class="left2">
                <input type="email" name="CustomerEmail" id="CustomerEmail" class="form-control form-control-sm">
              </span>
            </div>
          </div>
          <div class="col-md-6"> 
            <div class="form-group">
              <label class="left">Birth Date</label>
              <span class="left2">
                <input type="text" name="CustomerBirthDate" id="CustomerBirthDate" class="form-control form-control-sm">
              </span>
            </div>
            <div class="form-group">
              <label class="left">Address</label>
              <span class="left2">
              	<textarea name="CustomerAddress" id="CustomerAddress" class="form-control" rows="4" placeholder="Enter ..."></textarea>
              </span>
            </div> 
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>    

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><?php echo $PageTitle; ?></h1>
      </div> 
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <button class="btn btn-xs btn-info" data-toggle="modal" data-target="#modal-customer" onclick="clear_form();">Add Customer</button>
          </li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="row">
    <div class="col-12"> 
      <div class="card">
        <div class="card-body">
          <table id="dt_list" class="table table-bordered">
            <thead>
	            <tr>
	              <th>Customer ID</th>
	              <th>Name</th>
	              <th>Phone</th>
                <th>BirthDate</th>
	              <th>Address</th>
	              <th></th>
	            </tr>
            </thead>
            <tbody>
              <?php
                if (isset($content)) {
                  foreach ($content as $row => $list) { ?>
                    <tr>
                      <td><?php echo $list['CustomerID'];?></td>
                      <td><?php echo $list['CustomerName'];?></td>
                      <td><?php echo $list['CustomerPhone'];?></td>
                      <td><?php echo $list['CustomerBirthDate'];?></td>
                      <td><?php echo $list['CustomerAddress'];?></td>
                      <td>
                        <button type="button" class="btn btn-success btn-xs btnEditCustomer" CustomerID="<?php echo $list['CustomerID'];?>" title="EDIT" data-toggle="modal" data-target="#modal-customer"><i class="fa fa-fw fa-edit"></i></button>
                      </td>
                    </tr>
              <?php } } ?> 
            </tbody> 
          </table>
        </div>        
      </div>      
    </div>    
  </div>  
</section>

<script src="<?php echo base_url();?>assets/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/adminlte/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="<?php echo base_url();?>assets/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
jQuery( document ).ready(function( $ ) {

  $("#CustomerBirthDate").datepicker({ 
    autoclose: true, 
    format: 'yyyy-mm-dd', 
  });

  $(function () {
    $('#dt_list').DataTable();
  });
});

function clear_form() {
  $('#modal-customer input').val('')
  $('#modal-customer textarea').val('')
}
$('.btnEditCustomer').on( "click", function() {
  CustomerID  = $(this).attr('CustomerID');
  $.ajax({
    url: "<?php echo base_url();?>master_data/get_customer_detail",
    type : 'POST',
    data: {CustomerID: CustomerID},
    dataType : 'json',
    success : function (response) {
		$('#CustomerID').val(response['CustomerID'])
		$('#CustomerName').val(response['CustomerName'])
		$('#CustomerPhone').val(response['CustomerPhone'])
    $('#CustomerEmail').val(response['CustomerEmail'])
		$('#CustomerBirthDate').val(response['CustomerBirthDate'])
		$('#CustomerAddress').val(response['CustomerAddress']) 
    }
  })
});
</script>