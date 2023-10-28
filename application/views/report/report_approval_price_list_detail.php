<style type="text/css">
  .table-main tr td {
    font-size: 12px;
    padding: 2px 8px !important;
    white-space: nowrap !important;
  }

  .table-display-list { 
    font-size: 12px !important; 
    white-space: nowrap; 
    background: #ffffff;
  }
  .table-display-list td {
    padding: 2px 5px !important;
  }
  #myInput { margin: 10px 0px; }
  .box-body { overflow: auto; }
</style>

<div class="row"> 
  <div class="col-md-12" style="max-height: 300px;">
    <div class="box box-solid">
      <div class="box-body no-padding">
        <input type="text" class="form-control input-sm" placeholder="SEARCH CONTENT" onkeyup="search_modal();" id="myInput" autocomplete="off">
        <div style="overflow-x:auto; max-height:250px;">
          <table class="table table-display-list table-bordered table_modal" id="table_modal">
            <tr>
              <th class=" alignCenter">Product Name</th>
              <th class=" alignCenter">Promo</th>
              <th class=" alignCenter">TOP</th>
              <th class=" alignCenter">CBD</th>
              <th class=" alignCenter">Status</th>
            </tr>
            <?php 
            if (isset($content['product'])) {
              foreach ($content['product'] as $row => $list) { 
            ?>
              <tr>
                <td><?php echo $list['ProductID'];?> : <?php echo $list['ProductCode'];?></td>
                <td class=" alignCenter"><?php echo $list['Promo'];?> %</td>
                <td class=" alignCenter"><?php echo $list['PT1Discount'];?> %</td>
                <td class=" alignCenter"><?php echo $list['PT2Discount'];?> %</td>
                <td class=" alignCenter">
                  <?php if ( ($list['ApprovalBy']!=0) && ($list['isApprove']==1) ) { ?>
                    <i class="fa fa-fw fa-check-square-o" style="color: green;" title="Approved"></i>
                    <span style="display:none;">Approved</span>
                  <?php } elseif ( ($list['ApprovalBy']!=0) && ($list['isApprove']==0) ) { ?>
                    <i class="fa fa-fw fa-times" style="color: red;" title="CANCEL"></i>
                    <span style="display:none;">CANCEL</span>
                  <?php } elseif ( ($list['ApprovalBy']==0) ) {   } ?>
                </td>
              </tr>
            <?php } } ?>
          </table>
          
        </div>
      </div>
    </div>
  </div>
</div>