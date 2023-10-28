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
  .table-history td {
    font-size: 12px;
    padding: 2px 2px !important;
    word-break: break-all; 
    white-space: nowrap; 
  } 
</style>
<div style="overflow-x: auto;">
  <table class="table table-bordered table-detail table-responsive">
    <thead>
      <tr>
        <th>Product ID</th>
        <th>Product Code</th>
        <th>Quantity order</th>
        <th>Detail DOR</th>
        <th>Outstanding</th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($content['product'] as $row => $list) { 
        $ProductID = $list['ProductID'];
      ?>
          <tr>
              <td class=" alignCenter"><?php echo $list['ProductID'];?></td>
              <td><?php echo $list['ProductCode'];?></td>
              <td class=" alignCenter"><?php echo $list['ProductQty'];?></td>
              <td>
                <table class="table table-bordered table-detail2 table-responsive">
                  <thead>
                    <tr>
                      <th>DOR ID</th>
                      <th>DOR Date</th>
                      <th>DOR Quantity</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $totaldor = 0;
                      if (isset($content['dor'][$ProductID])) {
                        foreach ($content['dor'][$ProductID] as $row => $list2) { 
                          $totaldor += $list2['ProductQty'];
                    ?>
                          <tr class=" alignCenter">
                              <td>
                                <?php echo $list2['DORID'];?>
                                <button type="button" class="btn btn-primary btn-xs printdor" dor="<?php echo $list2['DORID'];?>" title="PRINT DOR"><i class="fa fa-fw fa-file-text-o"></i></button>
                              </td>
                              <td><?php echo $list2['DORDate'];?></td>
                              <td><?php echo $list2['ProductQty'];?></td>
                          </tr>
                    <?php } } ?>
                    <tr class="total">
                      <td colspan="2">Total</td>
                      <td><?php echo $totaldor;?></td>
                    </tr>
                  </tbody>
                </table>
              </td>
              <td class=" alignCenter"><?php echo $list['ProductQty'] - $totaldor;?></td>
          </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<div class="col-md-12" style="overflow-x: auto; background-color: white;">
  <table class="table table-responsive">
    <tr>
      <td style="border-right: 1px solid #204d74;">
        <form action="<?php echo base_url();?>report/po_note" id="form_note" method="post" autocomplete="off">
          <div class="form-group">
            <label class="left">Note :</label>
            <span class="left2">
              <div class="input-group">
                <input type="hidden" class="form-control input-sm poid" name="poid" value="<?php echo $content['POID']; ?>">
                <input type="text" class="form-control input-sm ponote" name="ponote" required="">
                <span class="input-group-btn">
                  <button type="submit" class="btn btn-primary btn-sm btn-edit">SUBMIT</button>
                </span>
              </div>
            </span>
          </div>
        </form>
        <?php if (isset($content['history']['note'])) { ?>
          <table class="table table-history">
            <tbody>
              <?php
                foreach ($content['history']['note'] as $row => $list) { 
              ?>
                  <tr>
                      <td style="width: 250px; padding-left: 30px !important;"><?php echo $list['NoteDateTime'];?> / <?php echo $list['NoteBy'];?></td>
                      <td><?php echo $list['NoteText'];?></td>
                  </tr>
              <?php } ?>
            </tbody>
          </table>
        <?php } ?>
      </td>
      <td>
        <?php if (isset($content['SOfile'])) { ?>
          <h4>SO File Attachment</h4>
          <?php
            foreach ($content['SOfile'] as $row => $list) { 
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