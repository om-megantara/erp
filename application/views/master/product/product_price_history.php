<style type="text/css">
  .table-detail thead th,
  .total {
    background: #3169c6;
    color: #ffffff;
    text-align: center;
    color: white;
  }
  .table-detail, 
  .table-detail>thead>tr>th, 
  .table-detail>tbody>tr>td {
    border-color: #3169c6 !important;
    padding: 2px 2px !important;
    font-size: 12px;
    text-align: center;
  }
  .table-detail > tbody > tr > td, .table-detail > thead > tr > th { 
    word-break: break-all; 
    white-space: nowrap; 
  }
</style>

<table class="table table-bordered table-detail table-responsive">
  <thead>
    <tr>
      <th>Date</th>
      <th>HPP</th>
      <th>End User</th>
      <th>(HPP / End User)%</th>
      <th>Multiplier</th>
      <th>Create By</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($content as $row => $list) { 
    ?>
        <tr>
            <td><?php echo $list['PriceHistoryDate'];?></td>
            <td><?php echo number_format($list['ProductPriceHPP'],2);?></td>
            <td><?php echo number_format($list['ProductPriceDefault'],2);?></td>
            <td><?php echo number_format($list['ProductPricePercent'],2);?> %</td>
            <td><?php echo number_format($list['ProductMultiplier'],2);?> %</td>
            <td><?php echo $list['PriceHistoryBy'];?></td>
        </tr>
    <?php } ?>
  </tbody>
</table>