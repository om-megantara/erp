<?php
$main     = (array) $content['main'];
$detail   = (array) $content['detail'];
$billing  = explode(";",$main['BillingAddress']);
$shipping = explode(";",$main['ShipAddress']);
  
$TotalItem = 0;
$TotalQty = 0;
$TotalQtyRetur = 0;

function ReversePerc($Price, $Perc)
{
  if ($Perc > 0) {
    if ($Price > 0) {
      $value = ( $Price / (100-$Perc) ) *100;
    } else {
      $value = 0;
    }
  } else {
    if ($Price > 0) {
      $value = $Price;
    } else {
      $value = 0;
    }
  }
  return $value;
}
function PercentValue($Price, $Perc)
{
  if ($Perc > 0) {
    $value = $Price * ($Perc/100);
  } else {
    $value = 0;
  }
  return $value;
}
?>
<head>
  <link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>tool/favicon.png"/> 
  <title><?php echo $PageTitle.' - ' .$MainTitle." - NO ".$main['INVID']; ?></title>
  <style type="text/css">
    @media only print {
      .btn-header, input#size {
        display:none !important;
      } 
      .empty-header { height: 160px !important; }
      .empty-footer { height: 200px !important; }
      .inv-header {
          display: block;
          position: fixed;
          top: 0
      } 
      .inv-footer {
          display: block;
          position: fixed;
          bottom: 0
      } 
      .inv-left {
          display: block;
          position: fixed !important;
          float: left;
          top: 170;
      } 
    }
    @media print {

    }
    @page { size: potrait; }
    .btn-header {
      background-color: #f44336;
      color: white;
      padding: 5px 10px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 14px;
      margin-bottom: 20px;
    }
      
    .content, .inv-header, .inv-footer { width: 750px; }
    .inv-left { width: 200px; position: absolute; }
    .content, .inv-header, .inv-left, .inv-footer { font-family: Calibri; } 
    .content { min-height: 500px; }

    .inv-header { overflow: auto; }
    .inv-header .inv-header1, .inv-header .inv-header2 { height: 150px; vertical-align: text-bottom;}
    .inv-header .inv-header1 { width: 500px; float: left; }
    .inv-header .inv-header1 img { width: 500px; }
    .inv-header .inv-header2 { width: 250px; float: right; position: relative; }
    .inv-header .inv-header2 h3 { margin: 0px; position: absolute; bottom: 0; right: 0; }
    .inv-header .inv-header3 { width: 750px; float: left; text-align: center; }
    .inv-left td { vertical-align: top; font-size: 12px; font-weight: bold; }
    .inv-footer img { width: 150px; margin: 2px 0px; border-top: 1px solid black; }
    .inv-footer-border { border-top: 1px solid black; text-align: center; }
    .inv-footer-sign { height: 155px; width: 100%; }
    .inv-footer-sign td { border-bottom: 1px dotted black; vertical-align: bottom; }
    .inv-footer-sign-title { border-bottom: 0px !important; vertical-align: middle !important; font-weight: bold; font-size: 14px; text-align: center; height: 5%; }


    td { font-size: 12px; }
    .empty-header, .empty-footer { height: 0px; background-color: white;}
    .header-product-list { font-size: 14px; font-weight: bold; }
    .cell1 { vertical-align: top; word-break: break-word; max-width: 148px; }

  </style>
</head>

<body>

<div class="inv-header">
  <div class="inv-header1"><img src="<?php echo base_url();?>tool/logokop2.png"></div>
  <div class="inv-header2"><h3>COMMERCIAL INVOICE. <?php echo $main['INVID']; ?></h3></div>
  <div class="inv-header3">
    <input type="number" name="size" id="size" autocomplete="off" placeholder="Font Size Product List">
    <a href="#" id="noprint" class="btn-header noprint" autofocus>Print</a>
    <a href="#" class="btn-header ShowContentFull" autofocus>Show Full</a>
    <a href="#" class="btn-header ShowContentNonPromo" autofocus>Non Promo</a>
    <a href="#" class="btn-header ShowContentThirdParty" autofocus>Third Party</a>
  </div>
</div>

<div class="inv-left">
  <div class="inv-left1">
    <table border="0">
      <tr>
        <td width="80px">Invoice No</td>
        <td width="120px">: <?php echo $main['INVID']; ?></td>
      </tr>
      <tr>
        <td>Invoice Date</td>
        <td>: <?php echo $main['INVDate']; ?></td>    
      </tr>
      <tr>
        <td>Delivery Order</td>
        <td>: <?php echo $main['DOID']; ?></td>    
      </tr>
      <tr>
        <td>SO ID </td>
        <td>: <?php echo $main['SOID']; ?></td>    
      </tr>
      <tr>
        <td>SO Category </td>
        <td>: <?php echo $main['CategoryName']; ?></td>    
      </tr>
      <tr>
        <td>Payment Term</td>
        <td>: <?php echo $main['PaymentTerm']; ?></td>    
      </tr>
      <tr>
        <td>Due Date</td>
        <td>: <?php echo $main['due_date']; ?></td>    
      </tr>
      <tr>
        <td>Sales Person</td>
        <td>: <?php echo $main['sales']; ?></td>    
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td>Customer No</td>
        <td>: <?php echo $main['CustomerID']; ?></td>
      </tr>
      <tr>
        <td>Name</td>
        <td>: <?php echo $main['fullname']; ?></td>
      </tr>
      <tr>
        <td>HP</td>
        <td>: <?php echo $main['phone']; ?></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">
          BILL TO :<br>
          <?php echo $billing[0]; ?><br>
          <?php echo $billing[2]; ?><br>
          <?php  echo $main['phone']; ?>
        </td>    
      </tr>
      <tr><td colspan="2">&nbsp;</td></tr>
      <tr>
        <td colspan="2">
          SHIP TO :<br>
          <?php echo $shipping[0]; ?><br>
          <?php echo $shipping[2]; ?><br>
        </td>    
      </tr>
    </table>
  </div>
</div>

<div class="content">
  <table border="0">
    <thead> 
      <tr><td colspan="7" class="empty-header"></td></tr>
      <tr class="header-product-list">
        <td><div style="width: 200px;"></div></td>
        <td align="center">Product</td>
        <td align="center">Qty</td>
        <td align="center">Price</td>
        <td align="center">Promo Disc</td>
        <td align="center">PT Disc</td>
        <td align="center">Total</td>
      </tr>
    </thead>
    <tbody>
        <?php 
          $no=1;
          if (isset($content['detail'])) {
            $TotalPriceAmount = 0;
            $dorProductQty = 0;
            if ($main['INVCategory'] == 1) {
              // from do=============================================================
              foreach ($detail as $row => $list) { 
                $ProductPriceDefaultAsal = $list['ProductPriceDefault'];
                $TotalItem += 1;
                $TotalQty += $list['ProductQty'];
                $dorProductQty += $list['dorProductQty'];
                $PTPercent = $list['PTPercent'];

                if ($list['ProductQty'] > 0) {
                  if ($main['FCRetur']==1) {
                    $FCper = $list['FreightCharge']/$list['ProductQty'];
                  } else {
                    $FCper = $list['FreightCharge']/$list['doProductQty'];
                  }
                } else {
                  $FCper = 0;
                }

                $FC = ReversePerc($FCper, $PTPercent);
                $FC = ReversePerc($FC, $list['PromoPercent']);

                // if PT < 0
                $list['PromoPercent'] = ($list['PromoPercent'] < 0) ? 0 : $list['PromoPercent'] ;
                $PTPercent = ($PTPercent < 0) ? 0 : $PTPercent ;
                $list['ProductPriceDefault'] = ReversePerc($list['PriceAmount'], $PTPercent);
                $list['ProductPriceDefault'] = ReversePerc($list['ProductPriceDefault'], $list['PromoPercent']);

                // roundUp
                $PriceTotal1 = ($list['PriceAmount']+$FCper) * $list['doProductQty'];

                $PriceDefault1 = ($list['ProductPriceDefault']-PercentValue($list['ProductPriceDefault'],$list['PromoPercent']) );
                $PriceDefault2 = ( $PriceDefault1-PercentValue($PriceDefault1,$PTPercent) );
                $PriceTotal2 = ( $PriceDefault2 + round($FCper) ) * $list['doProductQty'];

                $PriceTotal3 = ($PriceTotal1-$PriceTotal2);
                if ( $PriceTotal3 < 10 && $PriceTotal3 > -10) {
                  $PriceTotal = $PriceTotal2 ;
                } else {
                  $PriceTotal = ($PriceTotal2 > $PriceTotal1)? $PriceTotal2 : $PriceTotal1 ;
                }
                $TotalPriceAmount += $PriceTotal;
                // ------------------------------------------------------------

                // promo include price------------------------------------------
                if ($list['PromoPercent'] > 0) {
                  $ProductPriceDefault2 = round($list['ProductPriceDefault']+$FC) * (1-($list['PromoPercent']/100));
                } else {
                  $ProductPriceDefault2 = round($list['ProductPriceDefault']+$FC);
                }

                if ($list['FreightCharge'] <= 0) {
                  if ($list['PriceAmount'] < $ProductPriceDefaultAsal) {
                    $list['ProductPriceDefault'] = $ProductPriceDefaultAsal;
                  }
                }
        ?>
                <tr class="content1">
                    <td></td>
                    <td class="ProductID" width="50%"><?php echo $list['ProductName'];?></td>
                    <td align="center" width="10%" ><?php echo $list['doProductQty'];?></td>
                    <td align="right">
                      <?php echo number_format( round($list['ProductPriceDefault']+$FC) );?>
                    </td>
                    <td align="center" width="10%"><?php echo $list['PromoPercent']."%";?></td>
                    <td align="center" width="10%"><?php echo $PTPercent."%";?></td>
                    <td align="right" width="10%">
                      <?php echo number_format( round($PriceTotal) );?>
                    </td>
                </tr>
                <tr class="Content2" style="display: none;">
                    <td></td>
                    <td class="ProductID"><?php echo $list['ProductName'];?></td>
                    <td align="center"><?php echo $list['doProductQty'];?></td>
                    <td align="right">
                      <?php echo number_format(round($ProductPriceDefault2));?>
                    </td>
                    <td align="center">0%</td>
                    <td align="center"><?php echo $PTPercent."%";?></td>
                    <td align="right">
                      <?php echo number_format( round($PriceTotal) );?>
                    </td>
                </tr>
        <?php 
              }
            } elseif ($main['INVCategory'] == 2) {
              // from so=============================================================
              foreach ($detail as $row => $list) { 
                $ProductPriceDefaultAsal = $list['ProductPriceDefault'];
                $TotalItem += 1;
                $TotalQty += $list['ProductQty'];
                $PTPercent = $list['PTPercent'];
                $FCper = $list['FreightCharge']/$list['ProductQty'];
                $FC = ReversePerc($FCper, $list['PTPercent']);
                $FC = ReversePerc($FC, $list['PromoPercent']);

                // if PT < 0
                $PromoPercent = ($list['PromoPercent'] < 0) ? 0 : $list['PromoPercent'] ;
                $PTPercent = ($PTPercent < 0) ? 0 : $PTPercent ; 
                $list['ProductPriceDefault'] = ReversePerc($list['PriceAmount'], $PTPercent);
                $list['ProductPriceDefault'] = ReversePerc($list['ProductPriceDefault'], $list['PromoPercent']);
                
                $PriceTotal = ($list['PriceAmount']+$FCper) * $list['ProductQty'];
                $TotalPriceAmount += $PriceTotal;

                // promo include price--------------------------
                if ($list['PromoPercent'] > 0) {
                  $ProductPriceDefault2 = ($list['ProductPriceDefault']+$FC) * (1-($list['PromoPercent']/100));
                } else {
                  $ProductPriceDefault2 = round($list['ProductPriceDefault']+$FCper);
                }
                // --------------------------------------------------

                if ($list['FreightCharge'] <= 0) {
                  $list['ProductPriceDefault'] = $ProductPriceDefaultAsal;
                  $ProductPriceDefault2 = $ProductPriceDefaultAsal;
                }
        ?>
                  <tr class="Content1">
                    <td></td>
                    <td class="ProductID"><?php echo $list['ProductName'];?></td>
                    <td align="center"><?php echo $list['ProductQty'];?></td>
                    <td align="right">
                      <?php echo number_format($list['ProductPriceDefault']+$FC,2);?>
                    </td>
                    <td align="center"><?php echo $PromoPercent."%";?></td>
                    <td align="center"><?php echo $list['PTPercent']."%";?></td>
                    <td align="right">
                      <?php echo number_format($PriceTotal,2);?>
                    </td>
                  </tr>
                  <tr class="Content2" style="display: none;">
                    <td></td>
                    <td class="ProductID"><?php echo $list['ProductName'];?></td>
                    <td align="center"><?php echo $list['ProductQty'];?></td>
                    <td align="right">
                      <?php echo number_format($ProductPriceDefault2,2);?>
                    </td>
                      <td align="center">0%</td>
                    <td align="center"><?php echo $list['PTPercent']."%";?></td>
                    <td align="right">
                      <?php echo number_format($PriceTotal,2);?>
                    </td>
                  </tr>
        <?php 
              }
            } 
          } 
        ?>
        <tr><td colspan="7"></td></tr>
        <?php 
          $TotalPriceReturned = 0;
          if ($dorProductQty > 0) { 
        ?>
        <tr>
          <td></td>
          <td colspan="6">
            <b style="color: red;">Returned : </b><br>
            <table>
              <thead>
                <tr>
                    <td class="ProductID">Product</td>
                    <td align="center">Qty</td>
                    <td align="right">Amount</td>
                </tr>
              </thead>
              <tbody>
                      <?php
                      if (isset($content['detail'])) {
                          foreach ($detail as $row => $list) { 
                            $TotalQtyRetur += $list['dorProductQty'];
                            if ($list['dorProductQty'] > 0) {
                              if ($main['FCRetur']==1) {
                                $FC = $list['FreightCharge']/max($list['ProductQty'],1);
                                $PriceTotal = ($list['PriceAmount']+$FC) * $list['dorProductQty'];
                              } else {
                                $FC = $list['FreightCharge']/$list['doProductQty'];
                                $PriceTotal = $list['PriceAmount'] * $list['dorProductQty'];
                              }
                            $TotalPriceReturned += $PriceTotal;
                      ?>
                            <tr>
                                <td class="ProductID"><?php echo $list['ProductName'];?></td>
                                <td align="center"><?php echo $list['dorProductQty'];?></td>
                                <td align="right">
                                  <?php echo number_format($PriceTotal,2);?>
                                </td>
                                <td> &nbsp;</td>
                            </tr>
                <?php 
                            }
                          } 
                      } 
                ?>
              </tbody>
            </table>
          </td>
        </tr>
        <?php } ?>
        <tr><td colspan="7"></td></tr>
    </tbody>
    <tfoot>
      <tr><td colspan="7" class="empty-footer"></td></tr>
    </tfoot>
  </table>
</div>

<div class="inv-footer">
  <table width="100%">
    <tr>
      <td width="200px" class="inv-footer-border"><b>SIGN</b></td>
      <td colspan="6" class="inv-footer-border"><b>TOTAL</b></td>
    </tr>
    <tr>
      <td>
        <table class="inv-footer-sign">
          <tr><td>SE</td></tr>
          <tr><td><?php echo $shipping[0]; ?></td></tr>
          <tr><td>Admin</td></tr>
        </table>
      </td>
      <td colspan="6">
        <table border="0" width="100%">
          <tr>
            <td class="cell1" width="45%">
              <?php
                if ($main['INVTerm'] != "") {
                  echo "Term : ".$main['INVTerm']."<br>";
                }
                if ($main['INVNote'] != "") {
                  echo "Note : ".substr(str_replace(array("\r", "\n","\r\n"), " ",$main['INVNote']),0,250)." ... <br><br>";
                }
                if ($main['INVMP'] != "") {
                  echo "INVOICE MP : ".$main['INVMP']."<br>";
                }
                if ($main['TotalPaid'] > 0) {
                  echo "Total Paid : ".number_format($main['TotalPaid'],2)."<br>";
                }
              ?>
            </td>
            <td width="2%">&nbsp;</td>
            <td class="cell2">
              <table width="100%" border="0">
                <tr>
                  <td width="50%">Total Item</td>
                  <td width="1%">:</td>
                  <td width="40%" class="detail right"><?php echo $TotalItem; ?></td>
                </tr>
                <tr>
                  <td width="50%">Total Quantity</td>
                  <td width="1%">:</td>
                  <td width="40%" class="detail right"><?php echo $TotalQty - $TotalQtyRetur; ?></td>
                </tr>
                <tr>
                  <td>Total Price Before Tax</td>
                  <td>:</td>
                  <td class="detail right"><?php echo number_format($TotalPriceAmount, 2); ?></td>
                </tr>
                <tr>
                  <td>Tax Rate</td>
                  <td>:</td>
                  <td class="detail right"><?php echo $main['TaxRate']."%"; ?></td>
                </tr>
                <tr>
                  <td>Tax Price </td>
                  <td>:</td>
                  <td class="detail right">
                    <?php echo number_format( round($TotalPriceAmount * ($main['TaxRate']/100)) ); ?>
                  </td>
                </tr>

                  <?php if ($TotalPriceReturned > 0) { ?>
                  <tr>
                    <td>Returned Amount </td>
                    <td>:</td>
                    <td class="detail right"><?php echo number_format( $TotalPriceReturned+($TotalPriceReturned*0.1), 2); ?></td>
                  </tr>
                  <?php } ?>

                  <?php if ($main['INVCategory']==1) { ?>
                  <?php 
                    $paymentAmount1 = $main['PriceTotal'] + $main['FCInclude'] + $main['FCTax']; 
                    $paymentAmount2 = $TotalPriceAmount + (round($TotalPriceAmount * ($main['TaxRate']/100))) ;
                            $paymentAmount3 = ($paymentAmount1-$paymentAmount2);
                            if ( $paymentAmount3 < 10 && $paymentAmount3 > -10) {
                              $main['paymentAmount'] = $paymentAmount2 ;
                            } else {
                      $main['paymentAmount'] = ($paymentAmount2 > $paymentAmount1) ? $paymentAmount2 : $paymentAmount1 ; 
                            }
                  ?>
                  <tr>
                    <td>Total Payment Due</td><td>:</td><td class="detail right"><?php echo number_format($main['paymentAmount'],2); ?></td>
                  </tr>
                  <?php } elseif ($main['INVCategory']==2) { ?>
                  <tr>
                    <td>Total Invoice</td><td>:</td><td class="detail right"><?php echo number_format($main['PriceTotal']+$main['FCTotal'],2); ?></td>
                  </tr>
                  <?php 
                    if ($main['TotalPaid'] > 0) { 
                      $main['paymentAmount'] = $main['paymentAmount']-$main['TotalPaid'];
                  ?>
                  <tr>
                    <td>Total Paid</td><td>:</td><td class="detail right"><?php echo number_format($main['TotalPaid'],2); ?></td>
                  </tr>
                  <?php } ?>

                  <tr>
                    <td>Total Payment Due</td><td>:</td><td class="detail right"><?php echo number_format(round($main['paymentAmount']),2); ?></td>
                  </tr>
                  <?php } ?>

                  <tr class="ContentThirdParty">
                    <td>Third Party Fees</td>
                    <td>:</td>
                    <td class="detail right"><?php echo number_format(round($main['FCExclude']),2); ?></td>
                  </tr>
                  <tr class="ContentThirdParty">
                    <td>Grand Total Payment Due</td>
                    <td>:</td>
                    <td class="detail right"><?php echo number_format(round($main['paymentAmount'] + $main['FCExclude']),2); ?></td>
                  </tr>
              </table>
            </td>
            <td> &nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" style="text-align: center"></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <div style="background: black;text-align: center;"><img src="<?php echo base_url();?>tool/logoacz.png"></div>
</div>

</body>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script>
$( "#noprint" ).click(function() {
    window.print();
}); 

$( ".showContentFull" ).click(function() {
  $( ".content1" ).slideDown('fast');
  $( ".content2" ).slideUp('fast');
});
$( ".ShowContentNonPromo" ).click(function() {
  $( ".content1" ).slideUp('fast');
  $( ".content2" ).slideDown('fast');
});
$( ".ShowContentThirdParty" ).click(function() {
  if ($('.ContentThirdParty').is(":hidden")) {
      $('.ContentThirdParty').css("display", "table-row");
  } else {
      $('.ContentThirdParty').css("display", "none");
  }
});
$('#size').live( "keyup", function() {
    size  = $(this).val();
    $(".content td").css('font-size',size);
});
</script>