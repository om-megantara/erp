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
      <th>Raw ID</th>
      <th>Product Code</th>
      <th>Qty Requested</th>
      <th>Qty Sent</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (isset($content['raw'])) {
      foreach ($content['raw'] as $row => $list) { 
    ?>
        <tr class=" alignCenter">
            <td><?php echo $list['RawID'].'('.$list['ProductID'].')';?></td>
            <td><?php echo $list['RawName'].'<br>('.$list['ParentName'].')';?></td>
            <td><?php echo $list['RawQty'];?></td>
            <td><?php echo $list['RawSent'];?></td>
        </tr>
    <?php } } ?>
  </tbody>
</table>