<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="jquery-ui-1.10.3.flat.min.css">
<style type="text/css">
  .table-main { 
    font-size: 12px; 
    white-space: nowrap; 
  }
  .table-main thead tr{
    background: #49afe3;
    color: #ffffff;
    align-content: center;
  }
  .table-main tbody tr:hover { 
    background: #3c8dbcb0; 
  }
  .table-main tbody tr td { 
    padding: 0px 5px; 
  }
  .productprice { 
    min-width: 80px; 
    padding: 2px 3px; 
  }
  .customborder { 
    border: 1px solid #3c8dbc; 
    padding: 3px;
  }
  @media (min-width: 768px){
    .vcenter {
      /*display: flex;*/
      align-items: center;
    }
  }
  .maincustomer { 
    padding-right: 0px !important; 
    padding-left: 0px !important; 
  }
  .detailcustomer .form-group { 
    /*margin-bottom: 0px !important; */
    /*margin-top: 5px !important */
  }
  .detailso .col-md-12 {
    padding-left: 5px !important;
    padding-right: 0px !important;
  }
  .detailcustomer .col-md-3{
    padding-left: 0px !important;
    padding-right: 0px !important;
  }
  .box-normal .col-md-3 { 
    padding-left: 0px !important; 
  }
  .cellproduct td { 
    vertical-align: middle !important; 
  }
  .cellproduct input { 
    min-width: 80px; 
    padding: 4px 5px !important; 
  }
  .linetotal { width: 90px; }
  .detailso .form-group { 
    margin-bottom: 2px; 
  }
  #shipdate, 
  #sodate, 
  .sales, 
  .socategory { 
    padding-right: 4px; 
    padding-left: 4px; 
  }
  .content-wrapper input, 
  .content-wrapper textarea, 
  .content-wrapper select { 
    padding-top: 5px !important; 
    padding-bottom: 5px !important; 
  }
  .sototal, 
  .sototalbefore { 
    font-size: 20px; 
  }
  .box-sototal .vcenter { 
    padding-left: 0px !important; 
    padding-right: 0px !important;
  }
  .checkPrice { display: none; }
  .inv-late tr td { background-color: #f39c12; }
  .table-price tr td, 
  .inv-late tr td, 
  .table-detail-customer tr td { 
    padding: 2px 5px !important;
    font-size: 12px;
    font-weight: bold;
    margin-top: 10px;
    border: 0px solid ; 
  }
  .table-price tr td:first-child, 
  .inv-late tr td:first-child, 
  .table-detail-customer tr td:first-child { 
    width: 100px;
  }
  .div-table-price, .div-inv-late {
    overflow-x:auto; 
    max-height: 100px;
    margin-bottom: 10px;
  }

  @media (min-width: 768px){
      .form-group label.left {
        float: left;
        width: 100px;
        padding: 5px 15px 0px 5px;
      }
      .form-group span.left2 {
        display: block;
        overflow: hidden;
      }
      .form-group { margin-bottom: 5px; }
  }
  .paymentmethod, 
  .invcategory { 
    padding: 2px; 
  }
  .DueDateProduct { border: 1px solid #3c8dbc; }
  .checkbox_dd {
    display: inline-block;
    margin-left: 20px;
  }
</style>

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <?php echo $PageTitle.' - '. $MainTitle; ?>
    </h1>
  </section>
  <section class="content">
    <div class="modal fade" id="modal-cell">
      <div class="modal-dialog">
        <div class="modal-content">

        </div>
      </div>
    </div>
    <div class="box box-solid">
      <div class="box-body">
        <form name="form" id="form" action="<?php echo base_url();?>report/report_cfu_act" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <div class="box box-solid detailcustomer">
              <div class="box-header with-border">
                <h3 class="box-title">CUSTOMER DETAIL</h3>
              </div>
              <div class="box-body">
                <div class="form-group vcenter">
                  <label class="left">CFU Date</label>
                  <label class="left2"><?php echo date('d-m-y');?></label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12" style="overflow-x:auto;">
            <table class="table table-bordered table-main table-responsive">
              <thead>
                <tr>
                  <th class=" alignCenter">No</th>
                  <th class=" alignCenter">Customer</th>
                  <th class=" alignCenter">City</th>
                  <th class=" alignCenter">No telpon</th>
                  <th class=" alignCenter">Link Basecamp</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                  // echo count($content);
                  if (isset($content['main'])) {
                    $no=1;
                      foreach ($content['main'] as $row => $list) { ?>
                      <tr>
                        <td class=" alignCenter"><?php echo $no;?></td>
                        <td><?php echo $list['Customer'];?></td>
                        <td><?php echo $list['City'];?></td>
                        <td><?php echo $list['phone'];;?></td>
                        <td><input type="text" minlength="1" class="form-control input-sm" name="link" required="" min="0"></td>
                        <td class=" alignCenter"> 
                          <button type="button" class="btn btn-danger btn-xs" ><i class="fa fa-fw fa-remove"></i></button>
                        </td>
                      </tr>
                <?php $no++;}  } ?>
              </tbody>
            </table>
          </div>
          <div class="col-md-12">
            <div class="box-footer" style="text-align: center;">
              <button type="submit" class="btn btn-primary btn-submit" >Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/jquery.inputmask.bundle.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">
$(document).ready(function(e){
  $('#date').datepicker({
    dateFormat: 'dd-mm-yy'
  });
});
</script>