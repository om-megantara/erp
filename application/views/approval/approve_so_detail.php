<?php
// echo json_encode($content);
$so     = $content['so'];
$detail = $content['detail'];
$actor  = $content['actor'];

$billing  = explode(";",$so['BillingAddress']);
$shipping = explode(";",$so['ShipAddress']);

?>
<style type="text/css">
  .longLast {
    min-width: 150px !important;
    max-width: 250px !important;
    white-space: break-word !important;
  }
  td.addr { 
    word-break: break-word; 
    min-width: 150px;
  }
  .table-main tr td {
    font-size: 12px;
    padding: 2px 8px !important;
    min-width: 100px;
    max-width: 250px;
    white-space: nowrap !important;
    vertical-align: top;
  }
  .table-detail tr th, .table-solate tr th { background: #49afe3; color: white; }
  .table-detail tr td, .table-detail tr th, 
  .table-solate tr td, .table-solate tr th {
    font-size: 12px;
    padding: 2px 8px !important;
    border-bottom: 1px solid #49afe3;
    white-space: nowrap !important;
  }
  .table-detail tr td:first-child {
    min-width: 250px !important;
    white-space: normal !important;
  }
  .table-result tr td {
    font-size: 12px;
    padding: 2px 8px !important;
    white-space: nowrap !important;
  }
  td.note {
    min-width: 250px !important;
    white-space: normal !important;
  }
  td.note textarea {
    width: 100%;
    height: 100%;
  }
  span.abnormal{
    font-weight: bold;
    color: red;
  }
</style>
<div class="box box-solid">
  <div class="box-body no-padding" style="overflow-x: auto;">
    <table class="table table-hover table-main">
      <tr>
        <td>
          <table>
            <tbody>
              <tr>
                <td>SO ID</td>
                <td>
                  : <?php echo $so['SOID']; ?>
                </td>
              </tr>
              <tr>
                <td>SO Category</td>
                <td> : <?php echo $so['CategoryName']; ?> </td>
              </tr>
              <tr>
                <td>Payment Term</td>
                <td> : <?php echo $so['PaymentWay']." / ".$so['PaymentTerm']; ?> </td>
              </tr>
              <tr>
                <td>SO Date</td>
                <td> : <?php echo $so['SODate']; ?> </td>
              </tr>
              <tr>
                <td>Ship Date</td>
                <td> : <?php echo $so['SOShipDate']; ?> </td>
              </tr>
              <tr>
                <td>SO Term</td>
                <td> : <?php echo $so['SOTerm']; ?></td>
              </tr>
              <tr>
                <td>Marketplace</td>
                <td>: <?php echo $so['MarketPlace']; ?></td>
              </tr>
              <tr>
                <td>SO Note</td>
                <td class="longLast"> : <?php echo $so['SONote']; ?></td>
              </tr>
            </tbody>
          </table>
        </td>
        <td>
          <table>
            <tbody>
              <tr>
                <td>SEC</td>
                <td>: <?php echo $so['secname']; ?></td>
              </tr>
              <tr>
                <td>SE</td>
                <td> : <?php echo $so['salesname']; ?> </td>
              </tr>
              <tr>
                <td>SO Total</td>
                <td> : <?php echo number_format($so['SOTotal'],2); ?></td>
              </tr>
              <tr>
                <td>SO Type</td>
                <td> : <?php echo $so['SOType']; ?></td>
              </tr>
              <tr>
                <td>DP Minimum</td>
                <td> : <?php echo "<b>(".number_format($so['PaymentDeposit'] )."%)</b> ". get_percent2($so['SOTotal'], $so['PaymentDeposit']);?></td>
              </tr>
              <tr>
                <td>DP Allocated</td>
                <td> : <?php echo "(".get_percent($so['SOTotal'], $so['TotalDeposit'])."%) ".number_format($so['TotalDeposit'],2);?></td>
              </tr>
              <tr>
                <td>Invoice MP</td>
                <td> : <?php echo $so['INVMP'];?></td>
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
              <tr>
                <td>Customer PV Mp</td>
                <td>: <?php echo $so['CustomerPVMp']; ?></td>
              </tr>
              <tr>
                <td>Credit / Available</td>
                <td> : <?php echo $so['CreditLimit']." / ".number_format($so['creditavailable'],2);?></td>
              </tr>
              <tr>
                <td>Billing Addr</td>
                <td class="longLast"> : <?php echo $billing[2]; ?></td>
              </tr>
              <tr>
                <td>AWB (No Resi)</td>
                <td>: <?php echo $so['ResiNo']; ?></td>
              </tr>
              <tr>
                <td>Shipping Addr</td>
                <td class="longLast"> : <?php echo $shipping[0]." / ".$shipping[1]."<br>".$shipping[2]; ?></td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </table>
  </div>

  <div class="box-body no-padding" style="overflow-x: auto; margin-top: 20px; border: 1px solid #49afe3;" >
    <table class="table table-hover table-detail ">
      <tr>
        <th>Name</th>
        <th>Detail</th>
        <th>Percent</th>
        <th>Price</th>
        <th>Total</th>
      </tr>
      <?php
        foreach ($detail as $row => $list) {
          $FreightCharge = $list['FreightCharge'];
          if ($so['FreightCharge'] > 0) {
            $FreightCharge = 0;
          }
      ?>
          <tr>
            <td><?php echo "(".$list['ProductID'].") ". $list['ProductName'];?></td>
            <td>
              Quantity SO : <b><?php echo $list['ProductQty'];?></b><br>
              <span style="color: green;">SO Price : <b><?php echo number_format($list['ProductPriceDefault'],2);?></b></span><br>
              End User Price : <b><?php echo number_format($list['PriceEndUser'],2);?></b><br>
              Promo Price : <b><?php echo number_format($list['PriceCategory'],2);?></b><br>
              Promo Percent : <b><?php echo $list['PromoCategory'];?> %</b><br>
              PV Customer : <b><?php echo number_format($list['PVSO'],2);?></b><br>
              Promo Name : <b><?php echo "(".$list['PriceID'].")". $list['PriceName'];?></b><br>
            </td>
            <td>
              <?php 
                if ($so['PaymentWay']=="TOP" && $list['PriceAmount']<$list['PT1Price'] ) {
                  echo '<span class="abnormal">';
                } elseif ($so['PaymentWay']=="CBD" && $list['PriceAmount']<$list['PT2Price']) {
                  echo '<span class="abnormal">';
                } else {
                  echo '<span class="normal">';
                }
              ?>
              Promo : <b><?php echo number_format($list['PricePercent'],2);?></b>&nbsp;
              <?php if ($so['PaymentWay'] == "TOP") { ?>
                TOP % : <b><?php echo number_format($list['PT1Percent'],2);?></b><br>
              <?php } ?>
              <?php if ($so['PaymentWay'] == "CBD") { ?>
                CBD % : <b><?php echo number_format($list['PT2Percent'],2);?></b><br><br>
              <?php } ?>
              </span>
              The Price Should be : -----------------<br>
              Promo : <b><?php echo number_format($list['plPromo'],2);?></b>&nbsp;
              <?php if ($so['PaymentWay'] == "TOP") { ?>
                TOP % : <b><?php echo number_format($list['plPT1Discount'],2);?></b><br>
              <?php } ?>
              <?php if ($so['PaymentWay'] == "CBD") { ?>
                CBD % : <b><?php echo number_format($list['plPT2Discount'],2);?></b><br>
              <?php } ?>
            </td>
            <td>
              <?php 
                if ($so['PaymentWay']=="TOP" && $list['PriceAmount']<$list['PT1Price'] ) {
                  echo '<span class="abnormal">';
                } elseif ($so['PaymentWay']=="CBD" && $list['PriceAmount']<$list['PT2Price']) {
                  echo '<span class="abnormal">';
                } else {
                  echo '<span class="normal">';
                }
              ?>
              Price Amount : <b><?php echo number_format($list['PriceAmount'],2);?></b><br>
              </span>
              ---------------------------------<br>
              <?php if ($so['PaymentWay'] == "TOP") { ?>
                TOP Price : <b><?php echo number_format($list['PriceplPT1Discount'],2);?></b><br>
              <?php } ?>
              <?php if ($so['PaymentWay'] == "CBD") { ?>
                CBD Price : <b><?php echo number_format($list['PriceplPT2Discount'],2);?></b><br>
              <?php } ?>
            </td>
            <td>
              Total : <b><?php echo number_format($list['PriceTotal'],2);?></b><br>
              Freight Charge : <b><?php echo number_format($FreightCharge,2);?></b><br>
            </td>
          </tr>
      <?php } ?>
    </table>
  </div>

  <div class="box-body no-padding" style="overflow-x: auto; margin-top: 20px;">
    <table class="table table-hover table-solate">
      <tr>
        <td rowspan="4" colspan="2" class="note">
          System Note : <br>
          <?php
            $SystemNote = str_replace("//", "<br>", $so['SystemNote']);
            echo $SystemNote."<br>";
          ?>
          Permit Note : <?php echo $so['PermitNote'];?>
          <!-- <br><textarea></textarea> -->
        </td>
        <td>Total Before Tax </td>
        <td>: <b><?php echo number_format($so['SOTotalBefore'],2);?></b></td>
      </tr>
      <tr>
        <td>Tax Amount </td>
        <td>: <b><?php echo number_format($so['TaxAmount'],2);?></b></td>
      </tr>
      <tr>
        <td>Freight Charge </td>
        <td>: <b><?php echo number_format($so['FreightCharge'],2);?></b></td>
      </tr>
      <tr>
        <td>Total Payment Due </td>
        <td>: <b><?php echo number_format($so['SOTotal'],2);?></b></td>
      </tr>
    </table>
  </div>

  <div class="box-footer" style="text-align: center;">
    <?php if ($actor == "") { ?>
      <button type="submit" class="btn btn-primary btn-submit approve" id="<?php echo $content['id'];?>" so=<?php echo $so['SOID'];?>>Approve</button>
      <button type="submit" class="btn btn-danger btn-submit reject" id="<?php echo $content['id'];?>" so=<?php echo $so['SOID'];?>>Reject</button>
    <?php } ?>
  </div>

  <div class="box-body no-padding" style="overflow-x: auto; margin-top: 20px;">
    <?php 
      if (isset($content['invlate'])) { 
        $invlate = $content['invlate'];
    ?>
      <table class="table table-hover table-bordered table-solate ">
        <tr>
          <th colspan="7" style="text-align: center;">Invoice Outstanding</th>
        </tr>
        <tr>
          <th class=" alignCenter">Invoice ID</th>
          <th class=" alignCenter">SO ID</th>
          <th class=" alignCenter">Invoice Date</th>
          <th class=" alignCenter">Due Date</th>
          <th class=" alignCenter">Late</th>
          <th class=" alignCenter">Total Payment</th>
          <th class=" alignCenter">Total Outstanding</th>
        </tr>
        <?php
          foreach ($invlate as $row => $list) { 
        ?>
            <tr>
              <td class=" alignCenter">
                <?php echo $list['INVID'];?>
                <button type="button" class="btn btn-warning btn-xs printinv" title="PRINT" invid="<?php echo $list['INVID'];?>"><i class="fa fa-fw fa-print"></i></button>
              </td>
              <td class=" alignCenter"><?php echo $list['SOID'];?></td>
              <td class=" alignCenter"><?php echo $list['INVDate'];?></td>
              <td class=" alignCenter"><?php echo $list['due_date'];?></td>
              <td class=" alignCenter"><b><?php echo $list['late_date'];?></b> </td>
              <td><b>(<?php echo $list['TotalPaymentPerc'];?>%) </b> <?php echo $list['TotalPayment'];?></td>
              <td class="alignRight"><?php echo $list['TotalOutstanding'];?></td>
              
            </tr>
        <?php } ?>
      </table>
    <?php } ?>
  </div>
  
  <div class="box-body no-padding" style="overflow-x: auto; margin-top: 20px;">
    <?php 
      if (isset($content['solate'])) { 
        $solate = $content['solate'];
    ?>
      <table class="table table-hover table-bordered table-solate ">
        <tr>
          <th colspan="5" style="text-align: center;">SO Outstanding</th>
        </tr>
        <tr>
          <th class=" alignCenter">SO ID</th>
          <th class=" alignCenter">Total SO</th>
          <th class=" alignCenter">Total Deposit</th>
          <th class=" alignCenter">Total Payment</th>
          <th class=" alignCenter">Total Outstanding</th>
        </tr>
        <?php
          foreach ($solate as $row => $list) { 
        ?>
            <tr>
              <td class=" alignCenter">
                <?php echo $list['SOID'];?>
                <?php if (in_array("print_without_header", $MenuList)) {?>
                <button type="button" class="btn btn-warning btn-xs printso2" title="PRINT OFFLINE" soid="<?php echo $list['SOID'];?>"><i class="fa fa-fw fa-print"></i></button>
                <?php } else { ?>
                <button type="button" class="btn btn-warning btn-xs printso" title="PRINT" soid="<?php echo $list['SOID'];?>"><i class="fa fa-fw fa-print"></i></button>
                <?php } ?>
              </td>
              <td class="alignRight"><b><?php echo $list['SOTotal'];?></b> </td>
              <td><b>(<?php echo $list['TotalDepositPerc'];?>%) </b> <?php echo $list['TotalDeposit'];?></td>
              <td><b>(<?php echo $list['TotalPaymentPerc'];?>%) </b> <?php echo $list['TotalPayment'];?></td>
              <td class="alignRight"><?php echo $list['TotalOutstanding'];?></td>
              
            </tr>
        <?php } ?>
      </table>
    <?php } ?>
  </div>


</div>

<?php
function get_percent($num1, $num2)
{
  $result = 0;
  if ($num2 > 0) {
    $percent  = $num1/100;
    $result   = $num2/$percent; 
  }
  return number_format($result,2);
}
function get_percent2($num1, $num2)
{
  $result = 0;
  if ($num1 > 0) {
    if ($num2 > 0) {
      $percent  = $num1/100;
      $result   = ($num1/100) * $num2;
    }
  }
  return number_format($result,2);
}
?>


