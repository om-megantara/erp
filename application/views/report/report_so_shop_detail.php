<style type="text/css">
  .table-detail thead th,
  .table-detail2 thead th,
  .total {
    background: #3169c6;
    color: #ffffff;
    text-align: center;
    color: white;
  }
  .table-detail, 
  .table-detail>thead>tr>th, 
  .table-detail>tbody>tr>td,
  .table-detail2, 
  .table-detail2>thead>tr>th, 
  .table-detail2>tbody>tr>td {
    border-color: #3169c6 !important;
    padding: 2px 2px !important;
    font-size: 12px;
  }
  .table-detail > tbody > tr > td, .table-detail > thead > tr > th,
  .table-detail2 > tbody > tr > td, .table-detail2 > thead > tr > th { 
    word-break: break-all; 
    white-space: nowrap; 
  }
</style>

 
<table class="table table-bordered table-detail table-responsive">
  <thead>
    <tr>
      <th>No</th>
      <th>Customer</th>
      <th>SO ID</th>
      <th>SO Date</th>
      <th>SO Total</th>
      <th>Completed</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $no=1;
      foreach ($content as $row => $list) {
    ?>
        <tr>
            <td ><?php echo $no;?></td>
            <td ><?php echo $list['Company2'];?></td>
            <td ><a href="#" class="cek_link" SOID="<?php echo $list['SOID'];?>"><?php echo $list['SOID'];?></a></td>
            <td ><?php echo $list['SODate'];?></td>
            <td class="alignRight"><?php echo number_format($list['SOTotal'],2);?></td>
            <td class="alignRight"><?php echo number_format($list['TotalPayment'],2);?></td>
            <td class="alignRight"><?php echo number_format($list['INVTotal'],2);?></td>
        </tr>
    <?php $no++;} ?>
  </tbody>
</table>