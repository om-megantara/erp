<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" type="image/ico" href="<?php echo base_url();?>tool/favicon.ico"/> 
  <title>Form FreightCharge</title>
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
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/dataTables.checkboxes.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
</head>
<style type="text/css">
  .content, .table {
    font-size: 12px !important;
    font-weight: bold !important;
  }
  .table { border: 0px !important; }
  .table td { border: 0px !important; padding: 3px !important;}
  @media (min-width: 768px){
      .form-group label.left {
        float: left;
        width: 130px;
        /*padding: 5px 15px 5px 5px;*/
      }
      .form-group span.left2 {
        display: block;
        overflow: hidden;
      }
      .form-group { margin-bottom: 5px; }
  }
</style>

<?php
$do = $content['do'];
// $BillingAddress = explode(";", $do['BillingAddress']);
// $ShipAddress = explode(";", $do['ShipAddress']);
?>

<div class="content-wrapper" style="margin-left: 0px !important;">
  <section class="content">
    <div class="box box-solid">
      <div class="box-body">
        <form name="form" id="form" action="<?php echo base_url();?>transaction/do_fc_add_act" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <table class="table table-responsive">
              <tbody>
                <tr><td>Number / Company</td><td>: <?php echo $do['DOType'].' '.$do['DOReff'];?> / <?php echo $do['company'];?></td></tr>
                <tr><td>FC Total / Not Yet Paid </td><td>: <?php echo number_format($content['FCMain'],2);?> / <?php echo number_format($content['PaymentAmount'],2);?></td></tr>
                <tr><td>DO Number </td><td>: <?php echo $do['DOID'];?></td></tr>
              </tbody>
            </table>
            <div class="form-group">
              <label class="left">Expedition</label>
              <span class="left2">
                <select class="form-control input-sm expedition" name="expedition" required=""></select>
                <input type="hidden" class="form-control input-sm DOID" name="DOID" value="<?php echo $do['DOID'];?>">
                <input type="hidden" class="form-control input-sm ExpeditionID" name="ExpeditionID">
                <input type="hidden" class="form-control input-sm ExpeditionName" name="ExpeditionName">
              </span>
            </div>
            <div class="form-group">
              <label class="left">Kwitansi Number</label>
              <span class="left2">
                <input type="text" class="form-control input-sm ExpeditionReff" name="ExpeditionReff">
              </span>
            </div>
            <div class="form-group">
              <label class="left">FreightCharge Amount</label>
              <span class="left2">
                <input type="number" class="form-control input-sm PaymentAmount" name="PaymentAmount" max="<?php echo $content['PaymentAmount'];?>">
              </span>
            </div>
            <div class="form-group">
              <label class="left">FreightCharge Date</label>
              <span class="left2">
                <input type="text" class="form-control input-sm PaymentDate" name="PaymentDate">
              </span>
            </div>
          </div>
          <div class="box-footer" style="text-align: center;">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery11.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.checkboxes.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
var j11 = $.noConflict(true);

j11( document ).ready(function( $ ) {

  $('.expedition').select2({
    placeholder: 'Minimum 3 char, Company',
    minimumInputLength: 3,
    ajax: {
      url: '<?php echo base_url();?>general/search_expedition',
      dataType: 'json',
      delay: 1000,
      processResults: function (data) {
        return {
          results: data
        };
      },
      cache: true
    }
  });
  $('.expedition').on("select2:select", function(e) { 
    ExpeditionID = $(this).val()
    ExpeditionName = $(".expedition option:selected").text()
    $('.ExpeditionID').val(ExpeditionID)
    $('.ExpeditionName').val(ExpeditionName)
  });

  $(".PaymentDate").datepicker({ 
    "setDate": new Date(), 
    autoclose: true, 
    format: 'yyyy-mm-dd',
  });
  // jeda submit form 10detik
  $("form").submit(function(){
    var el = $(this).find('button[type=submit]');
    el.prop('disabled', true);
    setTimeout(function(){
      el.prop('disabled', false);
    }, 10000);
  });
});
// jeda submit form 10detik

</script>
