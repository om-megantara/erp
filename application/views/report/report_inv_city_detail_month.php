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
        <th class="alignCenter">INV Date</th>
        <th class="alignCenter">City Name </th>
        <th class="alignCenter">Confirmed</th>
        <th class="alignCenter">Completed</th>
        <th class="alignCenter">Total</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($content as $row => $list) {
    ?>
        <tr>
          <td class="alignCenter"><?php echo $list['INVDate'];?></td>
          <td><?php echo $list['CityName'];?></td>
          <td class="alignRight"><?php echo number_format($list['confirmed'],2);?></td>
          <td class="alignRight"><?php echo number_format($list['completed'],3);?></td>
          <td class="alignRight"><?php echo number_format($list['INVTotal'],3);?></td>
        </tr>
    <?php } ?>
  </tbody>
</table>