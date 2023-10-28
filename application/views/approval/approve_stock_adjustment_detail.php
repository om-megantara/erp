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

  input[type='checkbox'] {
    -webkit-appearance:none;
    width:15px;
    height:15px;
    background:white;
    border-radius:3px;
    border:1px solid #555;
  }
  input[type='checkbox']:checked {
    background: #3c8dbc;
  }
</style>

<?php 
$main = $content['main']; 
$actor  = $content['actor'];
?>

<form role="form" action="<?php echo base_url();?>approval/approve_stock_adjustment_act" method="post" >
  <div class="col-md-6">
        <input type="hidden" name="AdjustmentID" value="<?php echo $main['AdjustmentID']; ?>">
        <strong> Adjustment ID : <?php echo $main['AdjustmentID']; ?> </strong><p></p>
        <strong> Adjustment Date : <?php echo $main['AdjustmentDate'];?> </strong><p></p>
        <strong> Adjustment By : <?php echo $main['AdjustmentBy'];?> </strong><p></p>
        <strong> Adjustment Note : <?php echo $main['AdjustmentNote'];?></strong><p></p>
  </div>
  <div class="col-md-6">
        <strong> Opname ID : <?php echo $main['OpnameID']; ?> </strong><p></p>
        <strong> Opname Date : <?php echo $main['OpnameDate'];?></strong><p></p>
        <strong> Opname By : <?php echo $main['OpnameBy'];?></strong><p></p>
        <strong> Opname Note : <?php echo $main['OpnameNote'];?></strong><p></p>
  </div>

  <input type="text" class="form-control input-sm" placeholder="SEARCH CONTENT" onkeyup="search_table_detail();" id="myInput" autocomplete="off">
  <div style="overflow-x: auto;">
    <table class="table table-bordered table-detail table-responsive" id="table_detail">
      <thead>
        <tr>
          <th>ID</th>
          <th>Code</th>
          <th>Warehouse</th>
          <th>Opname Qty</th>
          <th>Adjust Qty</th>
          <th>Result Qty</th>
          <th>Note</th>
          <th>Approve</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $a=0;
        if (isset($content['detail'])) {
          foreach ($content['detail'] as $row => $list) { 
        $a++;
        ?>
            <tr>
                <td class="alignCenter"><?php echo $list['ProductID'];?></td>
                <td><?php echo $list['ProductCode'];?></td>
                <td><?php echo $list['WarehouseName'];?></td>
                <td class="alignCenter"><?php echo $list['OpnameQty'];?></td>
                <td class="alignCenter"><?php echo $list['ProductQty'];?></td>
                <td class="alignCenter"><?php echo $list['OpnameQty'] + $list['ProductQty'];?></td>
                <td><?php echo $list['Note'];?></td>
                <td class="alignCenter">
                  <?php 
                  if ($actor == "") { 
                    if ($list['isApprove'] != "0") {
                  ?>
                    <input type="checkbox" id="<?php echo $list['ProductID'];?>" name="ProductID[]" value="<?php echo $list['ProductID'];?>" checked>
                  <?php } else { ?>
                    <i class="fa fa-fw fa-close"></i>
                  <?php } } ?>
                </td>
            </tr>
        <?php } } ?>
      </tbody>
    </table>
  </div>

  <div style="text-align: center;">
    <?php if ($actor == "") { ?>
      <button type="submit" class="btn btn-primary btn-submit approve">Approve</button>
    <?php } ?>
  </div>
</form>
