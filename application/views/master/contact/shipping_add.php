<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<style type="text/css">
  #dtshipping_list tbody,
  #dtshipping_list thead,
  #dtshipping_list tfoot{
    font-size: 12px !important;
  }
  #dtshipping_list tbody td { padding: 4px; }
  #addshipping {
    margin: 10px;
    background-color: #00a65a;
    color: white;
    padding: 2px 5px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    font-weight: bold;
  }
  .form-group { display: block; margin-bottom: 5px !important; }
  .customaddr {font-size: 12px; padding: 0px 3px; font-weight: bold; margin-bottom: 3px;}
  .phone, .email {margin-top: 2px;}
  .add_addr {font-size: 18px; font-weight: bold; color: white; background-color: #5bc0de; padding: 0px 8px;}
  .fullname .form-control, .address .form-control { margin-top: 3px; }
  .box-body h6 {display: inline; color: red; font-weight: bold;}
</style>

<?php 
// print_r($content); 
?>
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
      </div>
      <div class="box-body form_addshipping">
          <form name="form" id="form" action="<?php echo base_url();?>master/shipping_cu_act" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
           <?php if (isset($shippingdetail)) { ?>
            <input type="hidden" name="said" id="said" class="said" value="<?php echo $shippingdetail['SAID'];?>">
            <?php }; ?>
            <div class="col-md-6">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Shipping Information</h3>
                </div>
                <div class="box-body">
<!--
                  <?php if (isset($shippingdetail)) { ?>
                  <div class="form-group said" style="display: none;">
                    <label>Product ID <h6>*</h6> </label>
                    <input type="text" class="form-control" placeholder="Shipping Address ID" autocomplete="off" name="said" id="said" value="<?php echo $shippingdetail['SAID'];?>" readonly>
                  </div>
                  <?php }; ?>
-->
                  <div class="form-group">
                    <label>SA Name</label>
                    <input type="text" class="form-control" id="company" name="company" placeholder="Company Name" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label>Customer Name</label>
                    <select class="form-control" name="customer" id="customer"></select>
                  </div>
                  <div class="form-group">
                    <label>SA City</label>
                    <select class="form-control" name="city" id="city"></select>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Shipping Information</h3>
                </div>
                <div class="box-body">
                  <div class="form-group">
                    <label>SA Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone number" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label>SA Address</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="alamat" autocomplete="off">
                  </div>
                  <div class="form-group">
					<label>SA CP</label>
					<input class="form-control" name="cp" id="cp" type="text" readonly>
				  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box-footer" style="text-align: center;">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
      </div>
      <div class="box-footer">
      </div>
    </div>
  </section>
</div>


<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/jquery-ui.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script>
j8  = jQuery.noConflict();
j8( document ).ready(function( $ ) {
   
  fill_city();
  fill_customer();
  $("input").keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});
jQuery( document ).ready(function( $ ) {
  // jika edit data
  if ($(".said") !== "") {
    // alert('ok')
    $("#form #company").val('<?php if ( isset($shippingdetail)){ echo $shippingdetail['Company']; }?>');
    $("#form #customer").val('<?php if ( isset($shippingdetail)){ echo $shippingdetail['CustomerID']; }?>');
    $("#form #city").val('<?php if ( isset($shippingdetail)){ echo $shippingdetail['SACity']; }?>');
    $("#form #phone").val('<?php if ( isset($shippingdetail)){ echo $shippingdetail['SAPhone']; }?>');
  	$("#form #address").val('<?php if ( isset($shippingdetail)){ echo $shippingdetail['SAAddress']; }?>');
  	$("#form #cp").val('<?php if ( isset($shippingdetail)){ echo $shippingdetail['Fullname']; }?>');
	$("#form #said").val('<?php if ( isset($shippingdetail)){ echo $shippingdetail['SAID']; }?>');
  }
  // ======================
});
function fill_city() {
  $.ajax({
      url: '<?php echo base_url();?>master/fill_city',
      type: 'post',
      dataType: 'json',
      success:function(response){
          var len = response.length;
          for( var i = 0; i<len; i++){
              var CityName = response[i]['CityName'];
              var CityID = response[i]['CityID'];
			  $("#city").append("<option value='"+CityID+"'>"+CityName+"</option>");
		  }
		  $("#city").val('<?php if ( isset($shippingdetail)){ echo $shippingdetail['SACity']; }?>');
      }
  });
}
function fill_customer() {
  $.ajax({
      url: '<?php echo base_url();?>master/fill_customer',
      type: 'post',
      dataType: 'json',
      success:function(response){
          var len = response.length;
          for( var i = 0; i<len; i++){
              var Company = response[i]['Company'];
              var CustomerID = response[i]['CustomerID'];
			  $("#customer").append("<option value='"+CustomerID+"'>"+Company+"</option>");
          }
          $("#customer").val('<?php if ( isset($shippingdetail)){ echo $shippingdetail['CustomerID']; }?>');
      }
  });
}

function cek_input_detail() {
  if ($.trim($("#company").val()) === "") {
    alert("input tidak boleh kosong");
    return false;
  }
}
</script>