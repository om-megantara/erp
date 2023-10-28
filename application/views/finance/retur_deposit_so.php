<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">
.rowdistribution, .padtop-2 { margin-top: 2px !important; }
.padtop-4 { margin-top: 4px !important; }
.select2 { width: 100% !important; }
.distribution { 
  padding-left: 2px !important; 
  padding-right: 2px !important;
  font-size: 12px !important; 
}
.distributionamount {
  padding-left: 2px !important; 
  padding-right: 2px !important;
  font-size: 12px !important; 
}

.table-detail thead th {
  background: #3169c6;
  color: #ffffff;
  text-align: center;
  color: white;
}
.table-detail { margin-top: 10px; }
.table-detail>thead>tr>th, 
.table-detail>tbody>tr>td {
  font-size: 12px;
  border-color: #3169c6 !important;
  padding: 2px 2px !important;
}
.table-detail > tbody > tr > td, .table-detail > thead > tr > th {
  word-break: break-all; 
  white-space: nowrap; 
}
.distributionlist {
  padding-left: 0px !important;
  padding-right: 0px !important;
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

<?php 
$main = $content['main']; 
$detail = $content['detail']; 
?>

  <section class="content">
    <div class="box box-solid">
      <div class="box-body">
        <form name="form" id="form" action="<?php echo base_url();?>finance/retur_deposit_so_act" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <div class="col-md-4 padtop-2">
              <label>SO ID</label>
            </div>
            <div class="col-md-8 padtop-2">
              <input type="text" class="form-control input-sm" id="id" name="id" readonly="" value="<?php echo $main['SOID'];?>">
            </div>
            <div class="col-md-4 padtop-2">
              <label>Customer</label>
            </div>
            <div class="col-md-8 padtop-2">
              <input type="text" class="form-control input-sm" readonly="" value="<?php echo $main['Company'];?>">
            </div>
            <div class="col-md-4 padtop-2">
              <label>Total Amount</label>
            </div>
            <div class="col-md-8 padtop-2">
              <input type="text" class="form-control input-sm mask-number SOTotal" readonly="" value="<?php echo number_format($main['SOTotal']);?>">
            </div>
            <div class="col-md-4 padtop-2">
              <label>Total Deposit</label>
            </div>
            <div class="col-md-8 padtop-2">
              <input type="text" class="form-control input-sm mask-number TotalDeposit" readonly="" value="<?php echo number_format($main['TotalDeposit'],2);?>">
            </div>
            <div class="col-md-4 padtop-2">
              <label>Total Payment</label>
            </div>
            <div class="col-md-8 padtop-2">
              <input type="text" class="form-control input-sm mask-number TotalPayment" readonly="" value="<?php echo number_format($main['TotalPayment'],2);?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-xs-7">
                DEPOSIT AMOUNT
              </div>
              <div class="col-xs-5"> 
                RETUR AMOUNT
              </div>
            </div>
            <div class="row rowdistribution">
              <div class="col-xs-7 distributionlist">
                <select class="form-control distribution" name="distribution[]" required="">
                  <?php
                    foreach ($content['detail'] as $row => $list) { 
                  ?>
                        <option value="<?php echo $list['AllocationID'];?>" amount="<?php echo $list['AllocationAmount'];?>">
                          <?php echo $list['DepositID'].' - '.number_format($list['AllocationAmount'],2);?>
                        </option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-xs-5">
                <div class="input-group rowdistributionamount">
                  <input type="text" class="form-control distributionamount mask-number" name="distributionamount[]" required="" value="0">
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-primary  add_field" onclick="duplicatedistribution();">+</button>
                    <button type="button" class="btn btn-primary  add_field" onclick="if ($('.rowdistribution').length != 1) { $(this).closest('.rowdistribution').remove();}">-</button>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="box-footer" style="text-align: center;">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/jquery.inputmask.bundle.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
j8 = jQuery.noConflict();
j8( document ).ready(function( $ ) {
  totaldistributionamount = 0
	 
  $(".mask-number").inputmask({ 
      alias:"currency", 
      prefix:'', 
      autoUnmask:true, 
      removeMaskOnSubmit:true, 
      showMaskOnHover: true 
  });
});

function duplicatedistribution() {
  j8(".rowdistribution:last").clone().insertAfter(".rowdistribution:last");
  j8(".distributionamount:last").inputmask({
      alias:"currency", 
      prefix:'', 
      autoUnmask:true, 
      removeMaskOnSubmit:true, 
      showMaskOnHover: true 
  });
}
j8("form").submit(function(e){
  SOTotal = parseFloat(j8('.SOTotal').val());
  TotalDeposit = parseFloat(j8('.TotalDeposit').val());
  TotalPayment = parseFloat(j8('.TotalPayment').val());
  distributionamountTotal = 0
  DepositIDArray = [];
  j8(".rowdistribution").each(function() {
    DepositID = parseFloat(j8(this).find('.distribution option:selected').val());
    outstanding = parseFloat(j8(this).find('.distribution option:selected').attr('amount'));
    distributionamount = parseFloat(j8(this).find('.distributionamount').val());
    distributionamountTotal += distributionamount
    DepositIDArray.push(DepositID);
    if (outstanding !== 0 && outstanding < distributionamount ) {
      e.preventDefault();
      alert("Jumlah amount dengan Distribution tidak sesuai!")
      return false
    }
    // if (distributionamount < 0 ) {
    //   e.preventDefault();
    //   alert("Jumlah Distribution tidak boleh minus!")
    //   return false
    // }
  })

  DepositIDArrayS = DepositIDArray.sort(); 
  var DepositIDArrayDuplicate = [];
  for (var i = 0; i < DepositIDArrayS.length - 1; i++) {
      if (DepositIDArrayS[i + 1] == DepositIDArrayS[i]) {
          DepositIDArrayDuplicate.push(DepositIDArrayS[i]);
      }
  }
  if (DepositIDArrayDuplicate > 0) {
    e.preventDefault();
    alert("Duplicate Distribution!")
    return false
  }

  if (distributionamountTotal < (SOTotal-(TotalDeposit+TotalPayment)) ) {
    e.preventDefault();
    alert("Jumlah Distribution tidak boleh kurang dari Nilai SO!")
    return false
  }
});
</script>