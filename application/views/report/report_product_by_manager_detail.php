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
      <th class=" alignCenter">ID </th>
      <th class=" alignCenter">Product Name</th>
      <th class=" alignCenter">Category</th>
      <th class=" alignCenter">Manager</th>
      <th class=" alignCenter" style="width: 30px  !important;">Origin</th>
      <th class=" alignCenter">Stock</th>
      <th class=" alignCenter">Price</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($content as $row => $list) {
    ?>
        <tr>
            <td class=" alignCenter"><?php echo $list['ProductID'];?></td>
            <td class="alignleft"><?php echo wordwrap($list['ProductName'],80,"<br>\n");?></td>
            <td class="alignleft"><?php echo wordwrap($list['ProductCategoryName'],45,"<br>\n");?></td>
            <td class="alignleft"><?php echo wordwrap($list['ProductManager'],35,"<br>\n");?></td>
            <td class="alignleft"><?php echo $list['StateName'];?></td>
            <td class="alignCenter"><?php echo number_format($list['Stock'],0);?></td>
            <td class=" alignCenter"><?php echo number_format($list['Price'],0);?></td>
             <td><button type="button" class="btn btn-success btn-xs" onclick="window.open('<?php echo base_url();?>master/price_check_add?ProductID=<?php echo $list['ProductID']; ?>', '_blank');" title="Price Recommendation"><i class="fa fa-tags"></i></button></td>
        </tr>
    <?php } ?>
  </tbody>
</table>