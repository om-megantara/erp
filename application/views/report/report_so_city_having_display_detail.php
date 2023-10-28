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
      <th>Customer Name</th>
      <th>SOID</th>
      <th>ProductID</th>
      <th>Quantity</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($content as $row => $list) { 
    ?>
        <tr>
            <td class="alignleft"><?php echo $list['Customer'];?></td>
            <td class="alignCenter"><?php echo $list['SOID'];?></td>
            <td class="alignleft"><?php echo $list['ProductName'];?></td>
            <td class="alignCenter"><?php echo number_format($list['ProductQty']);?></td>
        </tr>
    <?php } ?>
  </tbody>
</table>