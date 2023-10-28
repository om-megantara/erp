<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" type="image/ico" href="<?php echo base_url();?>tool/favicon.ico"/> 
  <title>PRODUCT LIST</title>
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
</head>

<style type="text/css"> 
    /*css datatable*/
    /*------------------------*/
  .alert-dismissible h4 {
    margin-bottom: 5px !important;
  }
</style>

<?php
$main = $content['main'];
?>

<div class="content-wrapper" style="margin-left: 0px !important;">
  <section class="content">   
    <div class="box box-solid">
      <div class="box-header">
        <div class="box-body">
          <h3>Detail Product Stock</h3>
        </div>
      </div>
      <div class="box-body">
        <div class="alert alert-info alert-dismissible" style="margin-bottom: 2px;">
            <h4>PRODUCT ID : <?php echo $main[0]['ProductID'];?></h4>
            <h4>PRODUCT NAME : <?php echo $main[0]['ProductCode'];?></h4>
            <h4>PRODUCT CODE : <?php echo $main[0]['ProductName'];?></h4>
            <?php foreach ($main as $row => $list) { ?>
                Stock (<?php echo $list['WarehouseName'];?>) : <?php echo $list['Quantity'];?><br>
            <?php } ?>
          </div>
      </div>
    </div>
  </section>
</div>
