<script src="<?php echo base_url();?>tool/jquery8.js"></script>
    
<style type="text/css">
</style>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $PageTitle.' - '. $MainTitle; ?>
    </h1>
    <ol class="breadcrumb">
      <!-- <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li> -->
      <!-- <li><a href="#">Layout</a></li> -->
      <!-- <li class="active">Boxed</li> -->
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
      </div>
      <div class="box-body">
      	Transaction
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
      </div>
      <!-- /.box-footer-->
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>

<script>
jQuery( document ).ready(function( $ ) {
	$( "li.menu_transaction" ).addClass( "active" );
});
</script>