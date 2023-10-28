<style type="text/css">
  .table-detail thead th, .total {
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
  }
  .table-detail > tbody > tr > td, .table-detail > thead > tr > th { 
    word-break: break-all; 
    white-space: nowrap; 
  } 
</style>

<input type="text" class="form-control input-sm" placeholder="SEARCH CONTENT" onkeyup="search_table_detail();" id="myInput" autocomplete="off">
<div style="overflow-x: auto;">
  <table class="table table-bordered table-detail table-responsive" id="table_detail">
    <thead>
      <tr>
        <th>ID</th>
        <th>Code</th>
        <th>Warehouse</th>
        <th>Stock Qty</th>
        <th>Note</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($content as $row => $list) { 
      ?>
          <tr>
              <td class=" alignCenter"><?php echo $list['ProductID'];?></td>
              <td><?php echo $list['ProductCode'];?></td>
              <td><?php echo $list['WarehouseName'];?></td>
              <!-- <td class=" alignCenter"><?php echo $list['ProductQty']-$list['OpnameQty'];?></td> -->
              <td class=" alignCenter"><?php echo $list['OpnameQty']+ $list['ProductQty'];?></td>
              <td><?php echo $list['Note'];?></td>
              <td class=" alignCenter">
                <?php if ($list['isApprove']==1) { ?>
                  <i class="fa fa-fw fa-check-square-o" style="color: green;" title="Approved"></i>
                  <span style="display:none;">Approved</span>
                <?php } elseif ($list['isApprove']==2) { ?>
                  <i class="fa fa-fw fa-times" style="color: red;" title="CANCEL"></i>
                  <span style="display:none;">CANCEL</span>
                <?php } ?>
              </td>
          </tr>
      <?php } ?>
    </tbody>
  </table>
</div>