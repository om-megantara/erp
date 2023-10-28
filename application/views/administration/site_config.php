<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">
  
  .siteconfig, .edit {
    margin: 10px;
    background-color: #0073b7;
    color: white;
    padding: 2px 5px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    font-weight: bold;
  }
  .ui-autocomplete {
    z-index: 5;
    float: left;
    display: none;
    min-width: 160px;   
    padding: 4px 0;
    margin: 2px 0 10px 10px;
    list-style: none;
    background-color: #ffffff;
    border-color: #ccc;
    border-style: solid;
    border-width: 1px;
    max-height: 200px; 
    overflow-y: scroll; 
    overflow-x: hidden;
  }
  .form-editapproval .box-body, .form-siteconfig .box-body { display: none; }
  .form-editapproval .col-lg-3 {padding-left: 5px !important; padding-right: 5px !important;}

  @media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 220px;
      padding: 5px 15px 5px 5px;
    }
    .form-group span.left2 {
      display: block;
      overflow: hidden;
    }
    .form-group { margin-bottom: 5px; display: block;}
  }
</style>

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <?php echo $PageTitle.' - '. $MainTitle; ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>

  <section class="content">
    <div class="box box-solid">
      <div class="with-border">

        <div class="col-md-12 form-siteconfig with-border">
          <form role="form" action="<?php echo base_url();?>administration/site_config_edit/site" method="post" onSubmit="return info();" enctype="multipart/form-data" >
            <div class="box box-primary ">
              <div class="box-header">
                <h3 class="box-title"> Application Configuration</h3>
                <button type="submit" class="btn btn-primary pull-right">Submit</button>
              </div>
              <div class="box-body">

                <div class="col-md-6">
                  <div class="box box-solid">
                    <div class="box-body">
                      <div class="form-group">
                        <label class="left">Report Page View</label>
                        <span class="left2">
                          <input type="text" class="form-control input-sm" placeholder="ex: 50,100,200,500" autocomplete="off" name="ReportPaging" id="ReportPaging" maxlength="25" value="<?php echo $content['ReportPaging'];?>">
                        </span>
                      </div>
                      <div class="form-group">
                        <label class="left">Report Page View Default</label>
                        <span class="left2">
                          <input type="number" class="form-control input-sm" placeholder="ex: 50" autocomplete="off" name="ReportPagingDefault" id="ReportPagingDefault" maxlength="4" value="<?php echo $content['ReportPagingDefault'];?>">
                        </span>
                      </div>
                      <div class="form-group">
                        <label class="left">Report Total Result</label>
                        <span class="left2">
                          <input type="number" class="form-control input-sm" placeholder="ex: 100" autocomplete="off" name="ReportResult" id="ReportResult" maxlength="4" value="<?php echo $content['ReportResult'];?>">
                        </span>
                      </div>
                      <div class="form-group">
                        <label class="left">Customer Credit Limit (Rp.)</label>
                        <span class="left2">
                          <input type="text" class="form-control input-sm mask-number" placeholder="ex: 100" autocomplete="off" name="CustomerCreditLimit" id="CustomerCreditLimit" value="<?php echo $content['CustomerCreditLimit'];?>">
                        </span>
                      </div>
                      <div class="form-group">
                        <label class="left">Customer Payment Term (days)</label>
                        <span class="left2">
                          <input type="number" class="form-control input-sm" placeholder="ex: 30" autocomplete="off" name="CustomerPaymentTerm" id="CustomerPaymentTerm" maxlength="4" value="<?php echo $content['CustomerPaymentTerm'];?>">
                        </span>
                      </div>
                      <div class="form-group">
                        <label class="left">SO Standard min DP (%)</label>
                        <span class="left2">
                          <input type="number" class="form-control input-sm" placeholder="ex: 30" autocomplete="off" name="SODepositStandard" id="SODepositStandard" maxlength="4" value="<?php echo $content['SODepositStandard'];?>">
                        </span>
                      </div>
                      <div class="form-group">
                        <label class="left">SO Custom min DP (%)</label>
                        <span class="left2">
                          <input type="number" class="form-control input-sm" placeholder="ex: 30" autocomplete="off" name="SODepositCustom" id="SODepositCustom" maxlength="4" value="<?php echo $content['SODepositCustom'];?>">
                        </span>
                      </div>
                      <div class="form-group">
                        <label class="left">SO Project min DP (%)</label>
                        <span class="left2">
                          <input type="number" class="form-control input-sm" placeholder="ex: 30" autocomplete="off" name="SODepositProject" id="SODepositProject" maxlength="4" value="<?php echo $content['SODepositProject'];?>">
                        </span>
                      </div>
                      <div class="form-group">
                        <label class="left">SO Ship Date (days)</label>
                        <span class="left2">
                          <input type="number" class="form-control input-sm" placeholder="ex: 30" autocomplete="off" name="SOShipDate" id="SOShipDate" maxlength="4" value="<?php echo $content['SOShipDate'];?>">
                        </span>
                      </div>
                      <div class="form-group">
                        <label class="left">SO DP Deviation (%)</label>
                        <span class="left2">
                          <input type="number" class="form-control input-sm" autocomplete="off" name="SODPDeviation" id="SODPDeviation" maxlength="4" step="0.01" value="<?php echo $content['SODPDeviation'];?>">
                        </span>
                      </div>
                      <div class="form-group">
                        <label class="left">INV Late Payment (days)</label>
                        <span class="left2">
                          <input type="number" class="form-control input-sm" placeholder="ex: 30" autocomplete="off" name="INVLatePayment" id="INVLatePayment" maxlength="4" value="<?php echo $content['INVLatePayment'];?>">
                        </span>
                      </div>
                      <div class="form-group">
                        <label class="left">Product Stock Min (%)</label>
                        <span class="left2">
                          <input type="number" class="form-control input-sm" placeholder="ex: 30" autocomplete="off" name="StockMin" id="StockMin" maxlength="4" step="0.1" value="<?php echo $content['StockMin'];?>">
                        </span>
                      </div>
                      <div class="form-group">
                        <label class="left">Product Stock Max (%)</label>
                        <span class="left2">
                          <input type="number" class="form-control input-sm" placeholder="ex: 30" autocomplete="off" name="StockMax" id="StockMax" maxlength="4" step="0.1" value="<?php echo $content['StockMax'];?>">
                        </span>
                      </div>
                      <div class="form-group">
                        <label class="left">SlowMoving Multiply</label>
                        <span class="left2">
                          <input type="number" class="form-control input-sm" placeholder="ex: 30" autocomplete="off" name="SlowMovingMply" id="SlowMovingMply" maxlength="4" step="0.1" value="<?php echo $content['SlowMovingMply'];?>">
                        </span>
                      </div>
                      <div class="form-group">
                        <label class="left">PV (profit/PV)</label>
                        <span class="left2">
                          <input type="number" class="form-control input-sm" placeholder="ex: 30" autocomplete="off" name="PV" id="PV" maxlength="4" value="<?php echo $content['PV'];?>">
                        </span>
                      </div> 
                      <div class="form-group">
                        <label class="left">MarketPlace Fee</label>
                        <span class="left2">
                          <input type="number" class="form-control input-sm" placeholder="ex: 3.5" autocomplete="off" name="MPfee" id="MPfee" maxlength="4" step="0.1" value="<?php echo $content['MPfee'];?>">
                        </span>
                      </div>
                      <div class="form-group">
                        <label class="left">Customer PV Multiplier</label>
                        <span class="left2">
                          <input type="number" class="form-control input-sm" placeholder="ex: 3.5" autocomplete="off" name="customerPV" id="customerPV" maxlength="4" step="0.1" value="<?php echo $content['CustomerPVMultiplier'];?>">
                        </span>
                      </div>
                      <div class="form-group">
                        <label class="left">SE PV Multiplier</label>
                        <span class="left2">
                          <input type="number" class="form-control input-sm" placeholder="ex: 3.5" autocomplete="off" name="SEPV" id="SEPV" maxlength="4" step="0.1" value="<?php echo $content['SEPVMultiplier'];?>">
                        </span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="box box-solid">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="exampleInputFile">Logo Big</label>
                        <input type="file" class="input-file" id="logo_big" name="logo_big" >
                        <p class="help-block">disarankan format png dan size kurang dari 200kb.</p>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputFile">Logo Small</label>
                        <input type="file" class="input-file" id="logo_small" name="logo_small" >
                        <p class="help-block">disarankan format png dan size kurang dari 200kb.</p>
                      </div>
                      <div class="form-group">
                        <label class="left">Title Main Page</label>
                        <span class="left2">
                          <input type="text" class="form-control input-sm" placeholder="Title Main Page" autocomplete="off" name="MainTitle" id="MainTitle" maxlength="40" value="<?php echo $content['MainTitle'];?>">
                        </span>
                      </div>
                      <div class="form-group">
                        <label class="left">Warning Main Page</label>
                        <span class="left2">
                          <textarea class="form-control input-sm" rows="3" placeholder="Info Main Page" name="MainWarning" id="MainWarning"><?php echo $content['MainWarning'];?></textarea>
                        </span>
                      </div>
                      <div class="form-group">
                        <label class="left">Info Main Page</label>
                        <span class="left2">
                          <textarea class="form-control input-sm" rows="3" placeholder="Info Main Page" name="MainInfo" id="MainInfo"><?php echo $content['MainInfo'];?></textarea>
                        </span>
                      </div>
                      <div class="form-group">
                        <label class="left">Header Faktur 1</label>
                        <span class="left2">
                          <textarea class="form-control input-sm" rows="5" placeholder="Header Faktur 1" name="HeaderFaktur1" id="HeaderFaktur1"><?php echo $content['HeaderFaktur1'];?></textarea>
                        </span>
                      </div>
                      <div class="form-group">
                        <label class="left">Header Faktur 2</label>
                        <span class="left2">
                          <textarea class="form-control input-sm" rows="5" placeholder="Header Faktur 2" name="HeaderFaktur2" id="HeaderFaktur2"><?php echo $content['HeaderFaktur2'];?></textarea>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </form>
        </div>

        <div class="col-md-12 form-editapproval with-border">
          <form role="form" action="<?php echo base_url();?>administration/site_config_edit/approval" method="post">
            <div class="box box-primary ">
              <div class="box-header">
                <h3 class="box-title"> List Approval</h3>
                <button type="submit" class="btn btn-primary pull-right">Submit</button>
              </div>
              <div class="box-body">
                <div class="table-responsive no-padding" style="overflow-x: auto;">
                  <table class="table table-hover table-main nowrap">
                    <tr>
                      <td><h6 style="color: red">*) set 'EMPTY' on 'Approval 3' for byPass Approval</h6></td>
                      <td>Approval 1</td>
                      <td>Approval 2</td>
                      <td>Approval 3</td>
                    </tr>
                    <tr>
                      <td><?php echo $content2['approval_cc']['ApprovalNote'];?></td>
                      <td>
                          <select class="form-control input-sm select2 approval_cc1" style="width: 100%;" name="approval_cc1">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 approval_cc2" style="width: 100%;" name="approval_cc2">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 approval_cc3" style="width: 100%;" name="approval_cc3">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                    </tr>
                    <tr>
                      <td><?php echo $content2['approval_so']['ApprovalNote'];?></td>
                      <td>
                          <select class="form-control input-sm select2 approval_so1" style="width: 100%;" name="approval_so1">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 approval_so2" style="width: 100%;" name="approval_so2">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 approval_so3" style="width: 100%;" name="approval_so3">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                    </tr>
                    <tr>
                      <td><?php echo $content2['stock_adjustment']['ApprovalNote'];?></td>
                      <td>
                          <select class="form-control input-sm select2 stock_adjustment1" style="width: 100%;" name="stock_adjustment1">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 stock_adjustment2" style="width: 100%;" name="stock_adjustment2">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 stock_adjustment3" style="width: 100%;" name="stock_adjustment3">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                    </tr>
                    <tr>
                      <td><?php echo $content2['mutation_product']['ApprovalNote'];?></td>
                      <td>
                          <select class="form-control input-sm select2 mutation_product1" style="width: 100%;" name="mutation_product1">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 mutation_product2" style="width: 100%;" name="mutation_product2">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 mutation_product3" style="width: 100%;" name="mutation_product3">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                    </tr>
                    <tr>
                      <td><?php echo $content2['dor_invr']['ApprovalNote'];?></td>
                      <td>
                          <select class="form-control input-sm select2 dor_invr1" style="width: 100%;" name="dor_invr1">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 dor_invr2" style="width: 100%;" name="dor_invr2">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 dor_invr3" style="width: 100%;" name="dor_invr3">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                    </tr>
                    <tr>
                      <td><?php echo $content2['product_price_list']['ApprovalNote'];?></td>
                      <td>
                          <select class="form-control input-sm select2 product_price_list1" style="width: 100%;" name="product_price_list1">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 product_price_list2" style="width: 100%;" name="product_price_list2">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 product_price_list3" style="width: 100%;" name="product_price_list3">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                    </tr>
                    <tr>
                      <td><?php echo $content2['price_recommendation']['ApprovalNote'];?></td>
                      <td>
                          <select class="form-control input-sm select2 price_recommendation1" style="width: 100%;" name="price_recommendation1">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 price_recommendation2" style="width: 100%;" name="price_recommendation2">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 price_recommendation3" style="width: 100%;" name="price_recommendation3">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                    </tr>
                    <tr>
                      <td><?php echo $content2['product_promo_volume']['ApprovalNote'];?></td>
                      <td>
                          <select class="form-control input-sm select2 product_promo_volume1" style="width: 100%;" name="product_promo_volume1">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 product_promo_volume2" style="width: 100%;" name="product_promo_volume2">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 product_promo_volume3" style="width: 100%;" name="product_promo_volume3">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                    </tr>
                    <tr>
                      <td><?php echo $content2['purchase_order']['ApprovalNote'];?></td>
                      <td>
                          <select class="form-control input-sm select2 purchase_order1" style="width: 100%;" name="purchase_order1">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 purchase_order2" style="width: 100%;" name="purchase_order2">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 purchase_order3" style="width: 100%;" name="purchase_order3">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                    </tr>
                    <tr>
                      <td><?php echo $content2['purchase_order_expired']['ApprovalNote'];?></td>
                      <td>
                          <select class="form-control input-sm select2 purchase_order_expired1" style="width: 100%;" name="purchase_order_expired1">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 purchase_order_expired2" style="width: 100%;" name="purchase_order_expired2">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 purchase_order_expired3" style="width: 100%;" name="purchase_order_expired3">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                    </tr>
                    <tr>
                      <td><?php echo $content2['marketing_activity']['ApprovalNote'];?></td>
                      <td>
                          <select class="form-control input-sm select2 marketing_activity1" style="width: 100%;" name="marketing_activity1">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 marketing_activity2" style="width: 100%;" name="marketing_activity2">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 marketing_activity3" style="width: 100%;" name="marketing_activity3">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                    </tr>
                    <tr>
                      <td><?php echo $content2['so_complaint']['ApprovalNote'];?></td>
                      <td>
                          <select class="form-control input-sm select2 so_complaint1" style="width: 100%;" name="so_complaint1">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 so_complaint2" style="width: 100%;" name="so_complaint2">2
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 so_complaint3" style="width: 100%;" name="so_complaint3">3
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                    </tr>
                    <tr>
                      <td><?php echo $content2['employee_overtime']['ApprovalNote'];?></td>
                      <td>
                          <select class="form-control input-sm select2 employee_overtime1" style="width: 100%;" name="employee_overtime1">
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 employee_overtime2" style="width: 100%;" name="employee_overtime2">2
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                      <td>
                          <select class="form-control input-sm select2 employee_overtime3" style="width: 100%;" name="employee_overtime3">3
                            <option value="0">EMPTY</option>
                            <?php foreach ($content3 as $row => $list) { ?>
                            <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                            <?php } ?>
                          </select>
                      </td>
                    </tr>
                  </table>
                </div>

              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/jquery-ui.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.inputmask.bundle.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
  $('.select2').select2()
   
  $(".mask-number").inputmask({ 
    alias:"currency", 
    prefix:'', 
    autoUnmask:true, 
    removeMaskOnSubmit:true, 
    showMaskOnHover: true 
  });
  $(".form-siteconfig .box-header").click(function(){
      $(".form-siteconfig .box-body").slideToggle();
  });
  $(".form-editapproval .box-header").click(function(){
      $(".form-editapproval .box-body").slideToggle();
  });
  $('select.approval_cc1').val('<?php echo $content2['approval_cc']['Actor1'];?>').trigger('change');
  $('select.approval_cc2').val('<?php echo $content2['approval_cc']['Actor2'];?>').trigger('change');
  $('select.approval_cc3').val('<?php echo $content2['approval_cc']['Actor3'];?>').trigger('change');

  $('select.approval_so1').val('<?php echo $content2['approval_so']['Actor1'];?>').trigger('change');
  $('select.approval_so2').val('<?php echo $content2['approval_so']['Actor2'];?>').trigger('change');
  $('select.approval_so3').val('<?php echo $content2['approval_so']['Actor3'];?>').trigger('change');
  
  $('select.stock_adjustment1').val('<?php echo $content2['stock_adjustment']['Actor1'];?>').trigger('change');
  $('select.stock_adjustment2').val('<?php echo $content2['stock_adjustment']['Actor2'];?>').trigger('change');
  $('select.stock_adjustment3').val('<?php echo $content2['stock_adjustment']['Actor3'];?>').trigger('change');
  
  $('select.mutation_product1').val('<?php echo $content2['mutation_product']['Actor1'];?>').trigger('change');
  $('select.mutation_product2').val('<?php echo $content2['mutation_product']['Actor2'];?>').trigger('change');
  $('select.mutation_product3').val('<?php echo $content2['mutation_product']['Actor3'];?>').trigger('change');
  
  $('select.dor_invr1').val('<?php echo $content2['dor_invr']['Actor1'];?>').trigger('change');
  $('select.dor_invr2').val('<?php echo $content2['dor_invr']['Actor2'];?>').trigger('change');
  $('select.dor_invr3').val('<?php echo $content2['dor_invr']['Actor3'];?>').trigger('change');
  
  $('select.product_price_list1').val('<?php echo $content2['product_price_list']['Actor1'];?>').trigger('change');
  $('select.product_price_list2').val('<?php echo $content2['product_price_list']['Actor2'];?>').trigger('change');
  $('select.product_price_list3').val('<?php echo $content2['product_price_list']['Actor3'];?>').trigger('change');

  $('select.price_recommendation1').val('<?php echo $content2['price_recommendation']['Actor1'];?>').trigger('change');
  $('select.price_recommendation2').val('<?php echo $content2['price_recommendation']['Actor2'];?>').trigger('change');
  $('select.price_recommendation3').val('<?php echo $content2['price_recommendation']['Actor3'];?>').trigger('change');
  
  $('select.product_promo_volume1').val('<?php echo $content2['product_promo_volume']['Actor1'];?>').trigger('change');
  $('select.product_promo_volume2').val('<?php echo $content2['product_promo_volume']['Actor2'];?>').trigger('change');
  $('select.product_promo_volume3').val('<?php echo $content2['product_promo_volume']['Actor3'];?>').trigger('change');
  
  $('select.purchase_order1').val('<?php echo $content2['purchase_order']['Actor1'];?>').trigger('change');
  $('select.purchase_order2').val('<?php echo $content2['purchase_order']['Actor2'];?>').trigger('change');
  $('select.purchase_order3').val('<?php echo $content2['purchase_order']['Actor3'];?>').trigger('change');

  $('select.purchase_order_expired1').val('<?php echo $content2['purchase_order_expired']['Actor1'];?>').trigger('change');
  $('select.purchase_order_expired2').val('<?php echo $content2['purchase_order_expired']['Actor2'];?>').trigger('change');
  $('select.purchase_order_expired3').val('<?php echo $content2['purchase_order_expired']['Actor3'];?>').trigger('change');

  $('select.marketing_activity1').val('<?php echo $content2['marketing_activity']['Actor1'];?>').trigger('change');
  $('select.marketing_activity2').val('<?php echo $content2['marketing_activity']['Actor2'];?>').trigger('change');
  $('select.marketing_activity3').val('<?php echo $content2['marketing_activity']['Actor3'];?>').trigger('change');

  $('select.so_complaint1').val('<?php echo $content2['so_complaint']['Actor1'];?>').trigger('change');
  $('select.so_complaint2').val('<?php echo $content2['so_complaint']['Actor2'];?>').trigger('change');
  $('select.so_complaint3').val('<?php echo $content2['so_complaint']['Actor3'];?>').trigger('change');

  $('select.employee_overtime1').val('<?php echo $content2['employee_overtime']['Actor1'];?>').trigger('change');
  $('select.employee_overtime2').val('<?php echo $content2['employee_overtime']['Actor2'];?>').trigger('change');
  $('select.employee_overtime3').val('<?php echo $content2['employee_overtime']['Actor3'];?>').trigger('change');

});
function info() {
  alert("Harus LogOut agar perubahan nya bisa diterapkan...");
  return true;
}
</script>