<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">

<style type="text/css"> 
  .divfilterdate {
    display: none; 
    border: 1px solid #0073b7; 
    padding: 4px; 
    margin: 5px 0px;
  }
  .table-main thead th, .table-main tbody td {
    color: #000;
    text-align: center;
  }
  .table-main {
    margin-top: 10px; 
    margin-bottom: 0px; 
    border: 1px solid #000;
  }
  .table-main>thead>tr>th, 
  .table-main>tbody>tr>td {
    font-size: 14px;
    padding: 2px 2px !important;
    border: 1px solid #000;
  }
  .table-main > tbody > tr > td, .table-main > thead > tr > th {
    word-break: break-all; 
    white-space: nowrap; 
  }

  @media (min-width: 768px){
      .form-group label.left {
        float: left;
        width: 80px;
        padding: 5px 15px 5px 5px;
      }
      .form-group { margin-bottom: 10px; }
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
              <h4 class="modal-title">DETAIL CONTENT</h4>
          </div>
          <div class="modal-body">
            <div class="detailcontentAjax" id="detailcontent"></div>
          </div>
      </div>
    </div>
  </div>

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
      <div class="box-header">
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="1"><i class="fa fa-fw fa-print"></i> Print</button>
          <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>
          <div class="col-md-12 divfilterdate">
            <form role="form" action="<?php echo current_url();?>" method="post" >
              <div class="col-md-6">
                <div class="form-group">
                  <label class="left">Month</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control input-sm" autocomplete="off" name="datestart" id="datestart">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <button type="submit" class="btn btn-primary pull-center">Submit</button>
              </div>
            </form>
          </div>
          <div class="col-md-12" style="overflow-x: auto; padding: 0px;">
            
          </div>
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered " style="width: 100% !important;">
          <thead>
            <tr>
              <th>Invoice ID</th>
              <th>Sales</th>
              <th>Due Date</th>
              <th>Payment Date</th>
              <th>Invoice Amount</th>
              <th>PV Amount</th>
              <th>Penalty</th>
              <th>PV Total</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
            // echo count($content);
            if (isset($content['main'])) {
                foreach ($content['main'] as $row => $list) { ?>
                <tr>
                  <td><?php echo $list['INVID'];?></td>
                  <td><?php echo $list['fullname'];?></td>
                  <td><?php echo $list['due_date'];?></td>
                  <td><?php echo $list['BankTransactionDate'];?></td>
                  <td class="alignRight"><?php echo number_format($list['PriceBeforeTax'],2);?></td>
                  <td class="alignRight"><?php echo number_format($list['PV_total'],3);?></td>
                  <td class="alignRight"><?php echo number_format($list['PV_penalty'],2);?></td>
                  <td class="alignRight"><?php echo number_format($list['PV_final'],3);?></td>
                  <td>
                    <button type="button" class="btn btn-primary btn-xs detail" title="DETAIL" inv="<?php echo $list['INVID']; ?>"  data-toggle="modal" data-target="#modal-detail"><i class="fa fa-fw fa-search"></i></button>
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
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
<?php echo "SO LAMA";?>