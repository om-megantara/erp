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
        <strong><i class="fa fa-toggle-right margin-r-5"></i> Invoice ID&emsp;&emsp;&nbsp;&nbsp;: <?php echo $main['INVID']; ?> </strong><p></p>
        <strong><i class="fa fa-dollar margin-r-5"></i> Invoice Amount : <?php echo number_format($main['INVTotal'],2);?></strong><p></p>
        <strong><i class="fa fa-dollar margin-r-5"></i> Invoice Balance : <?php echo number_format($main['TotalOutstanding'],2);?></strong><p></p>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-solid">
      <div class="box-body box-profile">
        <strong><i class="fa fa-user margin-r-5"></i> Customer&emsp;&nbsp;&nbsp;&nbsp;: <?php echo $main['Company'];?></strong><p></p>
        <strong><i class="fa fa-calendar-plus-o margin-r-5"></i> Invoice Date : <?php echo $main['INVDate'];?></strong><p></p>
        <strong><i class="fa fa-calendar-plus-o margin-r-5"></i> Due Date&emsp;&nbsp;&nbsp;&nbsp;: <?php echo $main['due_date'];?></strong><p></p>
      </div>
    </div>
  </div>
</div>
<div class="col-md-12" style="background-color: white;">
<?php if (isset($content['detail'])) { ?>
  <table class="table table-bordered table-detail table-responsive">
    <thead>
      <tr>
        <th>Deposit ID</th>
        <th>Amount</th>
        <th>Transfer</th>
        <!-- <th>Date</th> -->
        <th>Created By</th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($content['detail'] as $row => $list) { 
      ?>
          <tr>
              <td class=" alignCenter"><?php echo $list['From'];?></td>
              <td class=" alignCenter"><?php echo number_format($list['Amount'],2);?></td>
              <td class=" alignCenter"><?php echo $list['Transfer'];?></td>
              <!-- <td><?php echo $list['Date'];?></td> -->
              <td class=" alignCenter"><?php echo $list['By'];?></td>
          </tr>
      <?php } ?>
    </tbody>
  </table>
<?php } ?>
</div>