<style type="text/css">
.table-detail thead th,
.table-detail tfoot td {
  background: #3169c6;
  color: #ffffff;
  border-color: #3169c6 !important;
  text-align: center;
  font-size: 12px;
  color: white;
  word-break: break-all; 
  white-space: nowrap; 
  padding: 1px 8px !important;
}
.table-detail tbody tr td,
.table-detail2 tbody tr td {
  font-size: 12px;
  border-color: #3169c6 !important;
  padding: 2px 2px !important;
  word-break: break-all; 
  white-space: nowrap; 
  text-align: center;
}
.table-detail3 { margin-bottom: 5px !important; }
.detailso2 { display: none; }
.special { background: #ff0; }
</style>
<div class="col-md-12" style="overflow-x: auto; background-color: white;">
<?php
$po = (array_key_exists('po', $content)) ? $content['po'] : '' ;
$so = (array_key_exists('so', $content)) ? $content['so'] : '' ;
$ProductID = $content['ProductID'];
?>

<?php if (isset($po['main'])) { ?>
  <table class="table table-bordered table-detail table-responsive nowrap">
    <thead>
      <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Shipping</th>
        <th>Note</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($po['main'] as $row => $list) { 
      ?>
        <tr>
            <td>PO <?php echo $list['POID'];?></td>
            <td><?php echo $list['PODate'];?></td>
            <td><?php echo $list['ShippingDate'];?></td>
            <td><?php echo $list['PONote'];?></td>
            <td>
              <button type='button' class='btn btn-primary btn-xs detailso' detailid="<?php echo $list['POID'];?>"><i class="fa fa-fw fa-plus-circle"></i></button>
            </td>
        </tr>
        <?php 
        if (is_array($po)) {
          if (isset($po['raw'][$list['POID']] )) { 
        ?>
            <tr detailid="<?php echo $list["POID"]; ?>" class="detailso2">
              <td colspan="6">
                <table class="table table-bordered table-detail2 table-responsive nowrap" >
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
                    if (isset($po['raw'][$list['POID']])) {
                      foreach ($po['raw'][$list['POID']] as $row => $list2) { 
                        if ( $list2['RawID'] == $ProductID ) { 
                      ?>
                          <tr class="special">
                        <?php } else { ?>
                          <tr>
                        <?php } ?>
                            <td><?php echo $list2['RawID'].'('.$list2['ProductID'].')';?></td>
                            <td><?php echo $list2['RawName'].'<br>('.$list2['ParentName'].')';?></td>
                            <td><?php echo $list2['RawQty'];?></td>
                            <td><?php echo $list2['RawSent'];?></td>
                        </tr>
                    <?php } } ?>
                  </tbody>
                </table>
              </td>
            </tr>
        <?php } ?>
      <?php } } ?>
    </tbody>
  </table>
<?php } ?>

<?php 
if (is_array($so)) {
  if (isset($so['main'])) { 
?>
  <table class="table table-bordered table-detail table-responsive nowrap">
    <thead>
      <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Sales</th>
        <th>Customer</th>
        <th>Outstanding</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($so['main'] as $row => $list) { 
      ?>
        <tr>
            <td>SO <?php echo $list['SOID'];?></td>
            <td><?php echo $list['SODate'];?></td>
            <td><?php echo $list['salesname'];?></td>
            <td><?php echo $list['Company'];?></td>
            <td><?php echo $list['outstanding'];?></td>
            <td>
              <button type='button' class='btn btn-primary btn-xs detailso' detailid="<?php echo $list['SOID'];?>"><i class="fa fa-fw fa-plus-circle"></i></button>
            </td>
        </tr>
        <?php 
          if (isset($so['detail'][$list['SOID']] )) { 
        ?>
              <tr detailid="<?php echo $list["SOID"]; ?>" class="detailso2">
                <td colspan="6">
                  <table class="table table-bordered table-detail2 table-responsive nowrap" >
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Qty</th>
                        <th>DO</th>
                        <th>Outstanding</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        foreach ($so['detail'][$list['SOID']] as $row => $list2) { 
                          if ( $list2['ProductID'] == $ProductID ) { 
                      ?>
                          <tr class="special">
                        <?php } else { ?>
                          <tr>
                        <?php } ?>
                            <td><?php echo $list2['ProductID'];?></td>
                            <td><?php echo $list2['ProductName'];?></td>
                            <td><?php echo $list2['ProductQty'];?></td>
                            <td>
                              <table class="table table-bordered table-detail3 table-responsive nowrap">
                                <thead>
                                  <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Qty</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $totaldo = 0;
                                    if (isset($so['do'][$list['SOID']][$list2['ProductID']])) {
                                      foreach ($so['do'][$list['SOID']][$list2['ProductID']] as $row => $list3) { 
                                        $totaldo += $list3['ProductQty'];
                                  ?>
                                        <tr class=" alignCenter">
                                            <td><?php echo $list3['DOID'];?></td>
                                            <td><?php echo $list3['DODate'];?></td>
                                            <td><?php echo $list3['ProductQty'];?></td>
                                        </tr>
                                  <?php } } ?>
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <td colspan="2">Total</td>
                                    <td><?php echo $totaldo;?></td>
                                  </tr>
                                </tfoot>
                              </table>
                            </td>
                            <td><?php echo $list2['ProductQty']-$list2['totaldo'];?></td>
                          </tr> 
                      <?php } ?>
                    </tbody>
                  </table>
                </td>
              </tr>
        <?php } ?>
      <?php } ?>
    </tbody>
  </table>
<?php } } ?>
</div>