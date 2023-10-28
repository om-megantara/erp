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
      <th>Invoice ID</th>
      <th>Invoice Date</th>
      <th>Customer Name</th>
      <th>Status</th>
      <th>Quantity</th>
      <th>Price</th>
      <th>Promo %</th>
      <th>PT %</th>
      <th>Line Total</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($content as $row => $list) { 
    ?>
        <tr>
            <td class="alignCenter"><?php echo $list['INVID'];?></td>
            <td class="alignCenter"><?php echo $list['INVDate'];?></td>
            <td class="alignleft"><?php echo $list['Company2'];?></td>
            <td class="alignCenter statusinv"><?php echo $list['status'];?></td>
            <td class="alignCenter"><?php echo $list['ProductQty'];?></td>
            <td class="alignRight"><?php echo number_format($list['ProductPriceDefault'],2);?></td>
            <td class="alignRight"><?php echo number_format($list['PromoPercent'],2);?></td>
            <td class="alignRight"><?php echo number_format($list['PTPercent'],2);?></td>
            <td class="alignRight"><?php echo number_format($list['PriceTotal'],2);?></td>
        </tr>
    <?php } ?>
  </tbody>
</table>