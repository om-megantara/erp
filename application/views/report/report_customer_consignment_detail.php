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
      <th>Customer ID</th>
      <th>Customer Name</th>
      <th>SOID</th>
      <th>SO Date</th>
      <th>DOID</th>
      <th>DO Date</th>
      <th>Open Days</th>
      <th>Product Name</th>
      <th>Quantity</th>
      <th>Sales</th>
    </tr>
  </thead>
  <tbody>
    <?php
    
      foreach ($content as $row => $list) { 
    ?>
        <tr>
          <td class="alignleft"><?php echo $list['CustomerID'];?></td>
          <td class="alignleft"><?php echo $list['Customer'];?></td>
          <td class="alignCenter"><a href="#" class="cek_link" SOID="<?php echo $list['SOID'];?>"><?php echo $list['SOID'];?></a></td>
          <td class="alignCenter"><?php echo $list['SODate'];?></td>
          <td class="alignCenter"><?php echo $list['DOID'];?></td>
          <td class="alignCenter"><?php echo $list['DODate'];?></td>
          <td class="alignCenter"><?php echo $list['lastday']." Days";?></td>
          <td class="alignleft"><?php echo wordwrap($list['ProductName'],70,"<br>\n");?></td>
          <td class="alignCenter"><?php echo number_format($list['ProductQty']);?></td>

          <td class="alignCenter"><?php echo wordwrap($list['Sales'],30,"<br>\n");?></td>
        </tr>
    <?php } ?>
  </tbody>
</table>