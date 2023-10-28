<style type="text/css">
.table-detail thead th {
  background: #3169c6;
  color: #ffffff;
  text-align: center;
  color: white;
}
.table-detail { margin-top: 10px; }
.table-detail>thead>tr>th, 
.table-detail>tbody>tr>td {
  font-size: 12px;
  border-color: #3169c6 !important;
  padding: 2px 2px !important;
}
.table-detail > tbody > tr > td, .table-detail > thead > tr > th {
  word-break: break-all; 
  white-space: nowrap; 
}
</style>

<?php 
$main = $content['main']; 
// $detail = $content['detail']; 
// print_r($main);
?>

<div class="col-md-12" style="background-color: white;">
<?php if (isset($content['main'])) { ?>
  <h5><b>Delivery Order</b></h5>
  <table class="table table-bordered table-detail table-responsive">
    <thead>
      <tr>
        <th>Product ID</th>
        <th>Product Code</th>
        <th>Quantity</th>
        <th>Warehouse</th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($main as $row => $list) { 
      ?>
          <tr>
              <td class=" alignCenter"><?php echo $list['ProductID'];?></td>
              <td><?php echo $list['ProductCode'];?></td>
              <td class=" alignCenter"><?php echo $list['ProductQty'];?></td>
              <td class=" alignCenter"><?php echo $list['WarehouseName'];?></td>
          </tr>
      <?php } ?>
    </tbody>
  </table>
<?php } ?>
</div>

<div class="col-md-12">
<?php if (isset($content['detail'])) { ?>
  <h5>Delivery Order Received</h5>
  <table class="table table-bordered table-detail table-responsive">
    <thead>
      <tr>
        <th>DOR</th>
        <th>ID</th>
        <th>Code</th>
        <th>Quantity</th>
        <th>Warehouse</th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($content['detail'] as $row => $list) { 
      ?>
          <tr>
              <td><?php echo $list['DORID'];?></td>
              <td><?php echo $list['ProductID'];?></td>
              <td><?php echo $list['ProductCode'];?></td>
              <td><?php echo $list['ProductQty'];?></td>
              <td><?php echo $list['WarehouseName'];?></td>
          </tr>
      <?php } ?>
    </tbody>
  </table>
<?php } ?>
</div>