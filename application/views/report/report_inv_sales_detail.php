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
  }
  .table-detail > tbody > tr > td, .table-detail > thead > tr > th,
  .table-detail2 > tbody > tr > td, .table-detail2 > thead > tr > th { 
    word-break: break-all; 
    white-space: nowrap; 
    font-size: 12px;
  }
</style>
<table class="table table-bordered table-detail table-responsive">
  <thead>
    <tr>
      <th>INV Date </th>
      <th>INV ID</th>
      <th>Customer</th>
      <th>Confirmed</th>
      <th>Completed</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($content as $row => $list) {
    ?>
        <tr>
            <td ><?php echo $list['INVDate'];?></td>
            <td class="alignCenter"><?php echo $list['INVID'];?></td>
            <td ><?php echo $list['Company2'];?></td>
            <td class="alignRight"><?php echo number_format($list['TotalOutstanding'],2);?></td>
            <td class="alignRight"><?php echo number_format($list['TotalPayment'],2);?></td>
            <td class="alignRight"><?php echo number_format($list['INVTotal'],2);?></td>
        </tr>
    <?php } ?>
  </tbody>
</table>