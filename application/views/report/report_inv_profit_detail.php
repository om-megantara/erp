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

<div>
  <table class="table table-bordered table-detail table-responsive">
    <thead>
      <tr>
        <th>Product ID</th>
        <th>Product Name</th>
        <th>Product Qty</th>
        <th>Product HPP</th>
        <th>Product Price</th>
        <th>Product Profit</th>
        <th>Total Price</th>
        <th>Total Profit</th>
        <th>Profit Percent %</th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($content as $row => $list) { 
      ?>
          <tr>
              <td class="alignCenter"><?php echo $list['ProductID'];?></td>
              <td class="alignCenter"><?php echo $list['ProductName'];?></td>
              <td class="alignCenter"><?php echo $list['ProductQty'];?></td>
              <td class="alignRight"><?php echo number_format($list['ProductHPP'],2);?></td>
              <td class="alignRight"><?php echo number_format($list['ProductPrice'],2);?></td>
              <td class="alignRight"><?php echo number_format($list['ProductProfit'],2);?></td>
              <td class="alignRight"><?php echo number_format($list['PriceTotal'],2);?></td>
              <td class="alignRight"><?php echo number_format($list['ProfitAmount'],2);?></td>
              <td class="alignRight"><?php echo number_format($list['ProfitPercent'],2).' %';?></td>
          </tr>
      <?php } ?>
    </tbody>
  </table>
</div>