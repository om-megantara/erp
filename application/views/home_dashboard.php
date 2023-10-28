<?php
$link_summary_so_outstanding_do = base_url()."report/report_so_outstanding_do";
$link_summary_do_not_inv = base_url()."report/report_do_not_inv";
$link_summary_inv_unpaid = base_url()."report/report_inv_unpaid";
$link_summary_ro_outstanding = base_url().(($this->auth->cek5('purchase_order_add')) ? "transaction/request_to_purchase" : "report/report_ro_outstanding_po" );
$link_summary_po_outstanding = base_url()."report/report_po_outstanding_dor";
?>


<?php if ($this->auth->cek5('summary_so_outstanding_do')) { ?>
<div class="col-lg-3 col-xs-6">
  <div class="small-box bg-aqua">
    <div class="inner">
      <p><b>SO Outstanding DO</b></p>
      <h3><?php echo $content['summary']['SO_Outstanding_DO']['CountSO'];?></h3>
      <p>SO Late : <?php echo number_format($content['summary']['SO_Outstanding_DO']['SO_late']);?></p>
      <p>Qty Product : <?php echo number_format($content['summary']['SO_Outstanding_DO']['CountQty']);?></p>

    </div>
    <div class="icon">
      <i class="ion ion-bag"></i>
    </div>
    <a href="<?php echo $link_summary_so_outstanding_do;?>" class="small-box-footer" target="_blank">More info <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>
<?php } ?>

<?php if ($this->auth->cek5('summary_do_not_inv')) { ?>
<div class="col-lg-3 col-xs-6">
  <div class="small-box bg-green">
    <div class="inner">
      <p><b>DO not INV</b></p>
      <h3><?php echo $content['summary']['DO_not_INV']['CountDO'];?></h3>
      <p>DO Sales : <?php echo $content['summary']['DO_not_INV']['CountSales'];?></p>
      <p>DO Consignment : <?php echo $content['summary']['DO_not_INV']['CountConsignment'];?></p>
    </div>
    <div class="icon">
      <i class="ion ion-ios-cart"></i>
    </div>
    <a href="<?php echo $link_summary_do_not_inv;?>" class="small-box-footer" target="_blank">More info <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>
<?php } ?>

<?php if ($this->auth->cek5('summary_inv_unpaid')) { ?>
<div class="col-lg-3 col-xs-6">
  <div class="small-box bg-yellow">
    <div class="inner">
      <p><b>INV Unpaid</b></p>
      <h3><?php echo $content['summary']['INV_unpaid']['CountINV'];?></h3>
      <p>INV Late : <?php echo number_format($content['summary']['INV_unpaid']['CountINVLate']);?></p>
      <p>Unpaid Amount : <?php echo number_format($content['summary']['INV_unpaid']['CountUnpaid'],2);?></p>
    </div>
    <div class="icon">
      <i class="ion ion-cash"></i>
    </div>
    <a href="<?php echo $link_summary_inv_unpaid;?>" class="small-box-footer" target="_blank">More info <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>
<?php } ?>

<?php if ($this->auth->cek5('summary_ro_outstanding')) { ?>
<div class="col-lg-3 col-xs-6">
  <div class="small-box bg-purple">
    <div class="inner">
      <p><b>RO Outstanding</b></p>
      <h3><?php echo $content['summary']['RO_Outstanding']['CountRO'];?></h3>
      <p>RAW ready all : <?php echo number_format($content['summary']['RO_Outstanding']['RAW_Ready_all']);?></p>
      <p>RAW ready Partial : <?php echo number_format($content['summary']['RO_Outstanding']['RAW_Ready_Partial']);?></p>
    </div>
    <div class="icon">
      <i class="ion ion-compose"></i>
    </div>
    <a href="<?php echo $link_summary_ro_outstanding;?>" class="small-box-footer" target="_blank">More info <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>
<?php } ?>

<?php if ($this->auth->cek5('summary_po_outstanding')) { ?>
<div class="col-lg-3 col-xs-6">
  <div class="small-box bg-teal">
    <div class="inner">
      <p><b>PO Outstanding</b></p>
      <h3><?php echo $content['summary']['PO_Outstanding']['CountPO'];?></h3>
      <p>RAW not Sent : <?php echo number_format($content['summary']['PO_Outstanding']['RAW_not_sent']);?></p>
      <p>PO late : <?php echo number_format($content['summary']['PO_Outstanding']['PO_late']);?></p>
    </div>
    <div class="icon">
      <i class="ion ion-clipboard"></i>
    </div>
    <a href="<?php echo $link_summary_po_outstanding;?>" class="small-box-footer" target="_blank">More info <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>
<?php } ?>
 