<?php
// echo json_encode($content);
$main   = $content['main'];
$detail = $content['detail'];
$actor  = $content['actor'];

?>
<style type="text/css">
  .table-main tr td {
    font-size: 12px;
    padding: 2px 8px !important;
    white-space: nowrap !important;
  }
  .table-detail tr th { background: #49afe3; color: white; }
  .table-detail tr td, .table-detail tr th {
    font-size: 12px;
    padding: 2px 8px !important;
    border-bottom: 1px solid #49afe3;
    white-space: nowrap !important;
  }
</style>
<div class="box box-solid">
  <div class="box-body no-padding" style="overflow-x: auto;">
    <table class="table table-hover table-main">
      <tr>
        <td>Mutation ID</td>
        <td>: <?php echo $main['MutationID'];?></td>
        <td>From</td>
        <td>: <?php echo $main['wFrom'];?></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>Freight Charge</td>
        <td>: <?php echo number_format($main['MutationFC'],2);?></td>
        <td>To</td>
        <td>: <?php echo $main['wTo'];?></td>
        <td>Note</td>
        <td>: <?php echo $main['MutationNote'];?></td>
      </tr>
      </tr>
    </table>
  </div>

  <div class="box-body no-padding" style="overflow-x: auto; margin-top: 20px; border: 1px solid #49afe3;" >
    <table class="table table-hover table-detail ">
      <tr>
        <th>ID</th>
        <th>Code</th>
        <th>Mutation Qty</th>
        <th>Stock W. From</th>
        <th>Stock W. To</th>
      </tr>
      <?php
        foreach ($detail as $row => $list) { 
      ?>
          <tr>
            <td><?php echo $list['ProductID'];?></td>
            <td><?php echo $list['ProductCode'];?></td>
            <td><?php echo $list['ProductQty'];?></td>
            <td><?php echo $list['stock1'];?></td>
            <td><?php echo $list['stock2'];?></td>
          </tr>
      <?php } ?>
    </table>
  </div>

  <div class="box-footer" style="text-align: center;">
    <?php if ($actor == "") { ?>
      <button type="submit" class="btn btn-primary btn-submit approve" id="<?php echo $content['id'];?>" mutation=<?php echo $main['MutationID'];?>>Approve</button>
      <button type="submit" class="btn btn-danger btn-submit reject" id="<?php echo $content['id'];?>" mutation=<?php echo $main['MutationID'];?>>Reject</button>
    <?php } ?>
  </div>
</div>



