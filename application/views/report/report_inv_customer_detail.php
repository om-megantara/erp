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
      <th>Invoice ID</th>
      <th>SO ID</th>
      <th>Invoice Date</th>
      <th>Invoice Late</th>
      <th>Product Name</th>
      <th>Status</th>
      <th>Price</th>
      <th>Quantity</th>
      <th>Promo %</th>
      <th>PT Disc %</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($content as $row => $list) {
    ?>
        <tr>
            <td class="alignCenter"><?php echo $list['INVID'];?></td>
            <td class="alignCenter"><a href="#" class="cek_link" SOID="<?php echo $list['SOID'];?>"><?php echo $list['SOID'];?></a></td>
            <td class="alignCenter"><?php echo $list['INVDate'];?></td>
            <td class="alignCenter"><?php echo $list['late_days'];?></td>
            <td><?php echo $list['ProductName'];?></td>
            <?php if ($list['status'] == 'confirmed') { ?>
              <td class="alignCenter" style="color: blue; font-weight: bold;"><?php echo $list['status'];?></td>
            <?php } else if ($list['status'] == 'completed') { ?>
              <td class="alignCenter" style="color: green; font-weight: bold;"><?php echo $list['status'];?></td>
            <?php } ?>
            <td class="alignRight"><?php echo number_format($list['ProductPriceDefault'],2);?></td>
            <td class="alignCenter"><?php echo $list['ProductQty'];?></td>
            <td class="alignCenter"><?php echo number_format($list['PromoPercent'],2);?></td>
            <td class="alignCenter"><?php echo number_format($list['PTPercent'],2);?></td>
            <td class="alignRight"><?php echo number_format($list['PriceAmount'],2);?></td>
        </tr>
    <?php } ?>
  </tbody>
</table>