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
.table-detail { margin-top: 10px; }
.table-detail2 { margin-bottom: 0px !important; }
.table-detail tbody tr td,
.table-detail2 tbody tr td,
.table-detail2 tfoot tr td {
  font-size: 12px;
  border-color: #3169c6 !important;
  padding: 2px 2px !important;
  word-break: break-all; 
  white-space: nowrap; 
  text-align: center;
}
.table-history td,
.table-history th,
.table-history-2 th,
.table-history-2 td {
  font-size: 12px;
  padding: 2px 2px !important;
  word-break: break-all; 
  white-space: nowrap; 
}
.table-history-2 th,
.table-history-2 td {
  text-align: center;
}
.table-main { margin-bottom: 5px !important; }
.table-main tbody>tr>td {
  font-size: 12px;
  padding: 2px 12px !important;
  /*word-break: break-all; */
  white-space: nowrap; 
  word-wrap: break-word;
  max-width: 400px;
  vertical-align: top;
}
.table-main td.longLast  {
  white-space: normal !important;
  word-wrap: break-word !important;
}
</style>

<?php
$main = $content['product']['main'];
$billing  = explode(";",$main['BillingAddress']);
$shipping = explode(";",$main['ShipAddress']);
?>

<div class="col-md-12" style="overflow-x: auto; background-color: white;">
  <table class="table table-main table-responsive nowrap">
    <tbody>
      <tr>
        <td>
          <table>
            <tbody>
              <tr>
                <td>SO ID</td>
                <td>
                  : <?php echo $main['SOID']; ?>
                  <?php if (in_array("print_without_header", $MenuList)) {?>
                  <button type="button" class="btn btn-warning btn-xs printso2" title="PRINT OFFLINE" soid="<?php echo $main['SOID'];?>"><i class="fa fa-fw fa-print"></i></button>
                  <?php } else { ?>
                  <button type="button" class="btn btn-warning btn-xs printso" title="PRINT" soid="<?php echo $main['SOID'];?>"><i class="fa fa-fw fa-print"></i></button>
                  <?php } ?>
                  <br> 
                </td>
              </tr>
              <tr>
                <td>SO Category</td>
                <td> : <?php echo $main['CategoryName']; ?> </td>
              </tr>
              <tr>
                <td>SO Type</td>
                <td> : <?php echo $main['SOType']; ?></td>
              </tr>
              <tr>
                <td>Minimum DP</td>
                <td> : <?php echo $main['PaymentDeposit']; ?>%</td>
              </tr>
              <tr>
                <td>SO Date</td>
                <td> : <?php echo $main['SODate']; ?> </td>
              </tr>
              <tr>
                <td>Ship Date</td>
                <td> : <?php echo $main['SOShipDate']; ?> </td>
              </tr>
              <tr>
                <td>Shop Name</td>
                <td> : <?php echo $main['ShopName']; ?> </td>
              </tr>
              <tr>
                <td>INV MP</td>
                <td> : <?php echo $main['INVMP']; ?> </td>
              </tr>
            </tbody>
          </table>
        </td>
        <td>
          <table>
            <tbody>
              <tr>
                <td>SEC</td>
                <td>: <?php echo $main['secname']; ?></td>
              </tr>
              <tr>
                <td>SE</td>
                <td> : <?php echo $main['salesname']; ?> </td>
              </tr>
              <tr>
                <td>Payment Term</td>
                <td> : <?php echo $main['PaymentWay']." / ".$main['PaymentTerm']; ?> </td>
              </tr>
              <tr>
                <td>SO Total</td>
                <td> : <?php echo number_format($main['SOTotal'],2); ?></td>
              </tr>
              <tr>
                <td>SO Term</td>
                <td> : <?php echo $main['SOTerm']; ?></td>
              </tr>
              <tr>
                <td>SO Note</td>
                <td class="longLast"> : <?php echo $main['SONote']; ?></td>
              </tr>
              <tr>
                <td>Permit Note</td>
                <td class="longLast"> : <?php echo $main['PermitNote']; ?></td>
              </tr>
            </tbody>
          </table>
        </td>
        <td>
          <table>
            <tbody>
              <tr>
                <td>Customer</td>
                <td>: <?php echo $billing[0]; ?></td>
              </tr>
              <tr>
                <td>NPWP</td>
                <td> : <?php echo $main['NPWP']; ?></td>
              </tr>
              <tr>
                <td>Billing Addr</td>
                <td class="longLast"> : <?php echo $billing[2]; ?></td>
              </tr>
              <tr>
                <?php if($main['ResiNo']==""){?>
                <td>Shipping Addr</td>
                <td class="longLast"> : <?php echo $shipping[0]." / ".$shipping[1]."<br>".$shipping[2]; ?></td>
                <?php } else { ?>
                <td>Econcierge </td>
                <td class="longLast"> : <a href="<?php echo base_url(); ?>assets/PDFLabel/<?php echo $main['label'];?>" target="_blank" class="btn btn-xs btn-warning PrintLabel" title='PRINT Econcierge'><i class="fa fa-fw fa-print"></i></a></td>
                <?php } ?>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
</div>

<div class="col-md-12" style="overflow-x: auto; background-color: white;">
<?php if (isset($content['product'])) { ?>
  <table class="table table-bordered table-detail table-responsive nowrap">
    <thead>
      <tr>
        <th>ID</th>
        <th>Product Code</th>
        <th>Order</th>
        <th>O/S</th>
        <th>Stock</th>
        <th>DO</th>
        <th>INV</th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($content['product']['product'] as $row => $list) { 
      ?>
          <tr>
              <td><?php echo $list['ProductID'];?></td>
              <td><?php echo wordwrap($list['ProductName'],75,"<br>\n")."<br>".$list['ProductCode'];?></td>
              <td><?php echo $list['ProductQty'];?></td>
              <td><?php echo $list['ProductQty']-$list['totaldo'];?></td>
              <td>
                <?php 
                if (isset($content['product']['stock'][$list['ProductID']])) { 
                  foreach ($content['product']['stock'][$list['ProductID']] as $row => $list2) { 
                    echo $list2['WarehouseName']." : ".$list2['Quantity']."<br>";
                  } 
                }
                ?>
              </td>
              <td>
                <table class="table table-bordered table-detail2 table-responsive nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Date</th>
                      <th>Quantity</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $totaldo = 0;
                      if (isset($content['product']['do'][$list['ProductID']][$list['SalesOrderDetailID']])) {
                        foreach ($content['product']['do'][$list['ProductID']][$list['SalesOrderDetailID']] as $row => $list2) { 
                          $totaldo += $list2['ProductQty'];
                    ?>
                          <tr class=" alignCenter">
                              <td><?php echo $list2['DOID'];?></td>
                              <td><?php echo $list2['DODate'];?></td>
                              <td><?php echo $list2['ProductQty'];?></td>
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
              <td>
                <table class="table table-bordered table-detail2 table-responsive nowrap">
                  <thead>
                    <tr>
                      <th>INV</th>
                      <th>DO</th>
                      <th>Date</th>
                      <th>Quantity</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $totalinv = 0;
                      if (isset($content['product']['inv'][$list['ProductID']][$list['SalesOrderDetailID']])) {
                        foreach ($content['product']['inv'][$list['ProductID']][$list['SalesOrderDetailID']] as $row => $list3) { 
                          $totalinv += $list3['ProductQty'];
                          if ($list3['ProductID'] == $list['ProductID'] and 
                              $list3['SalesOrderDetailID'] == $list['SalesOrderDetailID']) {
                    ?>
                          <tr class=" alignCenter">
                              <td><?php echo $list3['INVID'];?></td>
                              <td><?php echo $list3['DOID'];?></td>
                              <td><?php echo $list3['INVDate'];?></td>
                              <td><?php echo $list3['ProductQty'];?></td>
                          </tr>
                    <?php } } } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="3">Total</td>
                      <td><?php echo $totalinv;?></td>
                    </tr>
                  </tfoot>
                </table>
              </td>
          </tr>
      <?php } ?>
    </tbody>
  </table>
<?php } ?>
</div>


<div class="col-md-12" style="overflow-x: auto; background-color: white;">
  <table class="table table-responsive">
    <tr>
      <td style="width: 70%; border-right: 1px solid #3169c6;">

          <?php if (count($content['history']['payment']) > 0) { ?>
            <table class="table table-history-2 table-responsive">
              <thead>
                <th>Transfer Date</th>
                <th>Allocation Date</th>
                <th>Allocation Amount</th>
              </thead>
              <tbody>
                <?php
                  foreach ($content['history']['payment'] as $row => $list) { 
                ?>
                    <tr>
                        <td><?php echo $list['TransferDate'];?></td>
                        <td><?php echo $list['PaymentDate'];?></td>
                        <td><?php echo number_format($list['PaymentAmount'],2);?></td>
                    </tr>
                <?php } ?>
              </tbody>
            </table>
          <?php } ?>
          <br>
          <?php if (isset($content['history']['transaction'])) { ?>
            <table class="table table-history table-responsive">
              <thead>
                <th>Type / ID</th>
                <th>Note</th>
                <th>Date</th>
                <th>By</th>
              </thead>
              <tbody>
                <?php
                  foreach ($content['history']['transaction'] as $row => $list) { 
                ?>
                    <tr>
                        <!-- <td><?php echo $list['spacing']." ".$list['type']." ".$list['id'];?></td> -->
                        <td><?php echo $list['type']." ".$list['id'];?></td>
                        <td><?php echo $list['note'];?></td>
                        <td><?php echo $list['date'];?></td>
                        <td><?php echo $list['fullname'];?></td>
                    </tr>
                <?php } ?>
                <tr><td colspan="4"><br><br></td></tr>
                <?php
                  foreach ($content['history']['transaction3'] as $row => $list) {
                ?>
                    <tr>
                        <td><?php echo $list['type']." ".$list['id'];?></td>
                        <td><?php echo $list['note'];?></td>
                        <td><?php echo $list['date'];?></td>
                        <td><?php echo $list['fullname'];?></td>
                    </tr>
                <?php } ?>
                <tr><td colspan="4"><br><br></td></tr>
                <?php
                  foreach ($content['history']['transaction2'] as $row => $list) { 
                ?>
                    <tr>
                        <td><?php echo $list['spacing']." ".$list['type']." ".$list['id'];?></td>
                        <td></td>
                        <td><?php echo $list['date'];?></td>
                        <td><?php echo $list['fullname'];?></td>
                    </tr>
                <?php } ?>
              </tbody>
            </table>
          <?php } ?>

      </td>
      <td>
          <?php if (isset($content['product']['shipDate'])) { ?>
            <table class="table table-history-2 table-responsive">
              <thead>
                <th>ShipDate</th>
                <th>Changed Date</th>
                <th>Changed By</th>
              </thead>
              <tbody>
                <?php
                  foreach ($content['product']['shipDate'] as $row => $list) { 
                ?>
                    <tr>
                        <td><?php echo $list['SOShipDate'];?></td>
                        <td><?php echo $list['CreatedDate'];?></td>
                        <td><?php echo $list['fullname'];?></td>
                    </tr>
                <?php } ?>
              </tbody>
            </table>
          <?php } ?>
          
          <?php if (isset($content['product']['SOfile'])) { ?>
            <h4>SO File Attachment</h4>
            <?php
              foreach ($content['product']['SOfile'] as $row => $list) { 
            ?>
              <div class="form-group">
                <div class="input-group input-group-sm fileU">
                  <input type="text" class="form-control input-sm fileT" name="fileTold[]" readonly="" value="<?php echo $list['FileType'];?>">
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-primary " onclick="window.open('<?php echo base_url();?>tool/so/<?php echo $list['SOID'].'/'.$list['FileName'];?>', '_blank')"><i class="fa fa-fw fa-file-image-o" title="<?php echo $list['FileName'];?>"></i></button>
                  </span>
                </div>
              </div>
            <?php } ?>
          <?php } ?>
      </td>
    </tr>
  </table>
</div>


<div class="col-md-12" style="overflow-x: auto; background-color: white;">
<?php if (isset($content['history']['note'])) { ?>
  Note :
  <!-- <button type="button" class="btn btn-primary btn-xs addnote" title="NOTE" soid="<?php echo $main['SOID']; ?>"><i class="fa fa-fw fa-edit"></i></button> -->
  <!-- <button type="button" class="btn btn-primary btn-xs addnote" title="NOTE"  data-toggle="modal" data-target="#modal-note" soid="<?php echo $main['SOID']; ?>"><i class="fa fa-fw fa-edit"></i></button> -->
  <?php if ($this->auth->cek5('report_so_note')) { ?>

    <form action="<?php echo base_url();?>report/so_note" id="form_note" method="post" autocomplete="off">
      <div class="form-group">
        <div class="input-group input-sm">
          <input type="hidden" class="form-control input-sm soid" name="soid" value="<?php echo $main['SOID']; ?>">
          <input type="text" class="form-control input-sm sonote" name="sonote" required="">
          <span class="input-group-btn">
            <button type="submit" class="btn btn-primary btn-sm btn-edit">SUBMIT</button>
          </span>
        </div>
      </div>
    </form>
  <?php } ?>
  <table class="table table-history">
    <tbody>
      <?php
        foreach ($content['history']['note'] as $row => $list) { 
      ?>
          <tr>
              <td><?php echo $list['NoteDateTime'];?></td>
              <td><?php echo $list['NoteBy'];?></td>
              <td><?php echo $list['NoteText'];?></td>
          </tr>
      <?php } ?>
    </tbody>
  </table>
<?php } ?>
</div>