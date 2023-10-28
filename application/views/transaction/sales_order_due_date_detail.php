<style type="text/css">
  .table-detail, .table-detail2 { width: 100%; }
  .table-detail thead th, .table-detail2 thead th {
    background: #3169c6;
    color: #ffffff;
    text-align: center;
    color: white;
  }
  .table-detail, .table-detail2, 
  .table-detail>thead>tr>th, .table-detail2>thead>tr>th, 
  .table-detail>tbody>tr>td, .table-detail2>tbody>tr>td {
    border-color: #3169c6 !important;
    padding: 2px 2px !important;
    font-size: 12px;
  }
  .table-detail > tbody > tr > td, .table-detail > thead > tr > th ,
  .table-detail2 > tbody > tr > td, .table-detail2 > thead > tr > th { 
    word-break: break-all; 
    white-space: nowrap; 
  }
  .table-detail2 > tbody > tr > td, .table-detail2 > thead > tr > th {
  	width: 25% !important;
  	text-align: center;
  	vertical-align: middle;
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

  .raw {
    background-color: #e1f1a2;
  }
</style>

<?php 
$main = $content['main']; 
$detail = $content['detail'];
?>

<form role="form" action="<?php echo base_url();?>transaction/sales_order_due_date_detail_act" method="post" >
  <div style="overflow-x: auto;">
    <table class="table table-bordered table-detail table-responsive">
      <thead>
        <tr>
          <th>Product</th>
          <th>Qty</th>
          <th>stockReady</th>
          <th>Atribute</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $a=0;
        if (isset($detail)) {
          foreach ($detail as $row => $list) { 
        ?>
            <tr>
                <td><?php echo $list['ProductID'].' - '.$list['ProductName'];?></td>
                <td class="alignCenter"><?php echo $list['ProductQty'];?></td>
                <td class="alignCenter"><?php echo $list['stockReady'];?></td>
                <td><?php echo $list['Atribute'];?></td>
            </tr>
        <?php
            if (isset($content['detailraw'][$list['ProductID']])) {
              foreach ($content['detailraw'][$list['ProductID']] as $row => $list2) {
        ?>
              <tr class="raw">
                <td>RAW <?php echo $list2['RawMaterialID'].' - '.$list2['ProductName'];?></td>
                <td class="alignCenter"><?php echo $list['ProductQty'];?></td>
                <td class="alignCenter"><?php echo $list2['stockReady'];?></td>
                <td><?php echo $list2['Atribute'];?></td>
            </tr>
        <?php
              }
            }
        } } ?>
      </tbody>
    </table>
    <table class="table table-bordered table-detail2 table-responsive">
      <thead>
        <tr>
          <th>DueDate1 / Purchasing</th>
          <th>DueDate2 / Tim Service</th>
          <th>DueDate3 / ... </th>
          <th>DueDate Final</th>
        </tr>
      </thead>
      <tbody>
            <tr>
                <td>
                	<?php if ($main['SOShipDate1Need'] == 1 and $this->auth->cek5('sales_order_due_date_user1')) { ?>
	                  <div class="input-group input-group-sm">
	                    <div class="input-group-addon">
	                      <i class="fa fa-calendar"></i>
	                    </div>
	                  	<input type="text" class="form-control input-sm pull-right fieldDueDate" id="SOShipDate1" name="DueDate1" autocomplete="off" required="" value="<?php echo $main['SOShipDate1'];?>">
		                <span class="input-group-btn">
		                  <button type="button" class="btn btn-success updateDueDate" soid="<?php echo $main['SOID'];?>" user="<?php echo $main['EmployeeID'];?>" data="SOShipDate1" title="UPDATE"><i class="fa fa-fw fa-check"></i></button>
		                </span>
	                  </div>
	                  <span>LastUpdate : <?php echo $main['SOShipDate1Created'];?></span>
                	<?php } else {
                        echo ' <i class="fa fa-fw fa-ban"></i> ';
                    } ?>
                </td>
                <td>
                	<?php if ($main['SOShipDate2Need'] == 1 and $this->auth->cek5('sales_order_due_date_user2')) { ?>
	                  <div class="input-group input-group-sm">
	                    <div class="input-group-addon">
	                      <i class="fa fa-calendar"></i>
	                    </div>
	                  	<input type="text" class="form-control input-sm pull-right fieldDueDate" id="SOShipDate2" name="DueDate2" autocomplete="off" required="" value="<?php echo $main['SOShipDate2'];?>">
		                <span class="input-group-btn">
		                  <button type="button" class="btn btn-success updateDueDate" soid="<?php echo $main['SOID'];?>" user="<?php echo $main['EmployeeID'];?>" data="SOShipDate2" title="UPDATE"><i class="fa fa-fw fa-check"></i></button>
		                </span>
	                  </div>
	                  <span>LastUpdate : <?php echo $main['SOShipDate2Created'];?></span>
                	<?php } else {
                        echo ' <i class="fa fa-fw fa-ban"></i> ';
                    } ?>
                </td>
                <td>
                	<?php if ($main['SOShipDate3Need'] == 1 and $this->auth->cek5('sales_order_due_date_user3')) { ?>
	                  <div class="input-group input-group-sm">
	                    <div class="input-group-addon">
	                      <i class="fa fa-calendar"></i>
	                    </div>
	                  	<input type="text" class="form-control input-sm pull-right fieldDueDate" id="SOShipDate3" name="DueDate3" autocomplete="off" required="" value="<?php echo $main['SOShipDate3'];?>">
		                <span class="input-group-btn">
		                  <button type="button" class="btn btn-success updateDueDate" soid="<?php echo $main['SOID'];?>" user="<?php echo $main['EmployeeID'];?>" data="SOShipDate3" title="UPDATE"><i class="fa fa-fw fa-check"></i></button>
		                </span>
	                  </div>
	                  <span>LastUpdate : <?php echo $main['SOShipDate3Created'];?></span>
                	<?php } else {
                        echo ' <i class="fa fa-fw fa-ban"></i> ';
                    } ?>
                </td>
                <td>
                	<?php if ($this->auth->cek5('sales_order_due_date_final')) { ?>
	                  <div class="input-group input-group-sm">
	                    <div class="input-group-addon">
	                      <i class="fa fa-calendar"></i>
	                    </div>
	                  	<input type="text" class="form-control input-sm pull-right fieldDueDate" id="SOShipDateFinal" name="DueDateFinal" autocomplete="off" required="" value="<?php echo $main['SOShipDateFinal'];?>">
		                <span class="input-group-btn">
		                  <button type="button" class="btn btn-success updateDueDate" soid="<?php echo $main['SOID'];?>" user="<?php echo $main['EmployeeID'];?>" data="SOShipDateFinal" title="UPDATE"><i class="fa fa-fw fa-check"></i></button>
		                </span>
	                  </div>
	                  <span>LastUpdate : <?php echo $main['SOShipDateFinalCreated'];?></span>
                	<?php } ?>

                </td>
            </tr>
      </tbody>
    </table>
    <p>* update 'DueDate Final' akan langsung merubah ke "ShipDate" pada SO.</p>
  </div>
 
</form>
