<style type="text/css">
.table-detail thead th {
  background: #3169c6;
  color: #ffffff;
  text-align: center;
  color: white;
}
.table-detail { margin-top: 10px; }
.table-detail>thead>tr>th, 
.table-detail>tbody>tr>td {
  font-size: 12px;
  border-color: #3169c6 !important;
  padding: 2px 2px !important;
}
.table-detail > tbody > tr > td, .table-detail > thead > tr > th {
  word-break: break-all; 
  white-space: nowrap; 
}
</style>

<?php 
$main = $content['main']; 
?>

<div class="row">
  <div class="col-md-6">
    <div class="box box-solid">
      <div class="box-body box-profile">
        <strong><i class="fa fa-toggle-right margin-r-5"></i> Deposit ID&emsp;&emsp;&nbsp;&nbsp;: <?php echo $main['DepositID']; ?> </strong><br>
        <strong><i class="fa fa-dollar margin-r-5"></i> Deposit Amount : </strong>
        <?php echo number_format($main['DepositAmount'],2);?><br>
        <strong><i class="fa fa-dollar margin-r-5"></i> Deposit Balance : </strong>
        <?php echo number_format($main['TotalBalance'],2);?><br>
        <strong><i class="fa fa-sticky-note-o margin-r-5"></i> Note&emsp;&emsp;&emsp;&emsp;&emsp;: </strong>
        <?php echo $main['DepositNote'];?><br>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-solid">
      <div class="box-body box-profile">
        <strong><i class="fa fa-calendar-plus-o margin-r-5"></i> Transfer Date : </strong>
        <?php echo $main['TransferDate'];?><br>
        <strong><i class="fa fa-calendar-plus-o margin-r-5"></i> Input Date&emsp;&nbsp;&nbsp;: </strong>
        <?php echo $main['InsertDate'];?><br>
        <strong><i class="fa fa-user margin-r-5"></i> Input By&emsp;&emsp;&nbsp;&nbsp;&nbsp;: </strong>
        <?php echo $main['InsertBy'];?><br>
      </div>
    </div>
  </div>
</div>
<div class="col-md-12">
<?php if (isset($content['detail'])) { ?>
  <table class="table table-bordered table-detail table-responsive" style="background-color: white;">
    <thead>
      <tr>
        <th>ID</th>
        <th>Amount</th>
        <th>Date</th>
        <th>By</th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($content['detail'] as $row => $list) { 
      ?>
          <tr>
              <td>
                <?php echo $list['Dst'];?>
              <?php if (isset($list['DistributionID'])) { ?>
                  <a href="<?php echo base_url();?>finance/bank_distribution_print?id=<?php echo $list['DistributionID'];?>" target="_blank" class="btn btn-primary btn-xs"><i class="fa fa-fw fa-print"></i></a>
              <?php } ?>
              </td>
              <td class="alignRight"><?php echo number_format($list['Amount'],2);?></td>
              <td class=" alignCenter"><?php echo $list['Date'];?></td>
              <td><?php echo $list['By'];?></td>
          </tr>
      <?php } ?>
    </tbody>
  </table>
<?php } ?>
</div>