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
  .table-detail > tbody > tr:hover { background: #a9c9ff; }
  .table-detail2 { margin-bottom: 0px; }
</style>
<table class="table table-bordered table-detail table-responsive">
  <thead>
    <tr>
      <th>Parent</th>
      <th>RAW</th>
      <th>Qty Requested</th>
      <th>Detail PO</th>
      <th>Outstanding</th>
      <th>Stock All</th>
      <th>Stock Ready</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $prevParent = "";
    if (isset($content['product'] )) {
      foreach ($content['product'] as $row => $list) { 
    ?>
        <tr class="alignCenter">
            <?php
              $countParent = count($content['parent'][$list['ProductID']]);
              if ($prevParent != $list['ProductID']) {
                $prevParent = $list['ProductID'];
            ?>
              <td rowspan="<?php echo $countParent;?>"><?php echo $list['ProductID'];?></td>
            <?php } ?>
            <td>
              <?php echo "(".$list['RawID'].") ".$list['RawName'];?>
              <br>--------------------------------------------------------------<br>
              <?php echo "(".$list['ProductID'].") ".$list['ProductParent'];?>
            </td>
            <td><?php echo $list['RawQty'];?></td>
            <td>
              <table class="table table-bordered table-detail2 table-responsive">
                <thead>
                  <tr>
                    <th>POID</th>
                    <th>PO Date</th>
                    <th>Qty PO</th>
                    <th>Qty Sent</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $totalpo = 0;
                    $totalsent = 0;
                    if (isset($content['po'][$list['ProductID']][$list['RawID']])) {
                      foreach ($content['po'][$list['ProductID']][$list['RawID']] as $row => $list2) { 
                        $totalpo += $list2['qtypo'];
                        $totalsent += $list2['RawSent'];
                  ?>
                        <tr class=" alignCenter">
                            <td><?php echo $list2['POID'];?></td>
                            <td><?php echo $list2['PODate'];?></td>
                            <td><?php echo $list2['qtypo'];?></td>
                            <td><?php echo $list2['RawSent'];?></td>
                        </tr>
                  <?php } } ?>
                  <tr class="total">
                    <td colspan="2">Total</td>
                    <td><?php echo $totalpo;?></td>
                    <td><?php echo $totalsent;?></td>
                  </tr>
                </tbody>
              </table>
            </td>
            
            <?php 
              $outstanding = $list['RawQty']-$totalpo;
              if ( $outstanding > 0) {
            ?>
              <td style="background-color: #ffff00;"><?php echo $outstanding;?></td>
            <?php } else { ?>
              <td><?php echo $outstanding;?></td>
            <?php } ?>
            </td>

            <td><?php echo $list['stock'];?></td>
            <?php if ( $list['stockReady'] > $outstanding) { ?>
              <td style="background-color: #4caf50;">
            <?php } else { ?>
              <td>
            <?php } ?>
            <?php echo $list['stockReady'];?></td>
        </tr>
    <?php } } ?>
  </tbody>
</table>