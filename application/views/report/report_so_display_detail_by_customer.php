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
      <th>SO ID</th>
      <th>SO Date</th>
      <th>Product Name</th>
      <th>Quantity</th>
      <th>Category</th>
      <th>Brand</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($content as $row => $list) { 
    ?>
        <tr>
            <td class=" alignCenter"><?php echo $list['SOID'];?></td>
            <td class=" alignCenter"><?php echo $list['SODate'];?></td>
            <td class="alignleft"><?php echo $list['ProductName'];?></td>
            <td class=" alignCenter"><?php echo $list['ProductQty'];?></td>
            <td class="alignleft"><?php echo $list['ProductCategoryName'];?></td>
            <td class="alignleft"><?php echo $list['ProductBrandName'];?></td>
        </tr>
    <?php } ?>
  </tbody>
</table>