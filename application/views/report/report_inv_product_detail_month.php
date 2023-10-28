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
    padding: 2px 5px !important;
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
        <th class="alignCenter">INV Date</th>
        <th class="alignCenter">Total Invoice </th>
        <th class="alignCenter">Total Customer </th>
        <th class="alignCenter">Total Qty </th>
        <th class="alignCenter">Total Price </th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($content as $row => $list) {
    ?>
        <tr>
          <td class="alignCenter"><?php echo $list['INVDate'];?></td>
          <td class="alignCenter"><?php echo number_format($list['CountCustomer']);?></td>
          <td class="alignCenter"><?php echo number_format($list['CountINV']);?></td>
          <td class="alignCenter"><?php echo number_format($list['ProductQty']);?></td>
          <td class="alignRight"><?php echo number_format($list['PriceTotal']);?></td>
        </tr>
    <?php } ?>
  </tbody>
</table>