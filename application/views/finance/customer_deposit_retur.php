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
?>

  <section class="content">
    <div class="box box-solid">
      <div class="box-body">
        <form name="form" id="form" action="<?php echo base_url();?>finance/customer_deposit_retur_act" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <div class="col-md-4 padtop-2">
              <label>Deposit ID</label>
            </div>
            <div class="col-md-8 padtop-2">
              <input type="text" class="form-control input-sm" id="id" name="id" readonly="" value="<?php echo $main['DepositID'];?>">
            </div>
            <div class="col-md-4 padtop-2">
              <label>Deposit Amount</label>
            </div>
            <div class="col-md-8 padtop-2">
              <input type="text" class="form-control input-sm mask-number" readonly="" value="<?php echo number_format($main['DepositAmount'],2);?>">
            </div>
            <div class="col-md-4 padtop-2">
              <label>Deposit Balance</label>
            </div>
            <div class="col-md-8 padtop-2">
              <input type="text" class="form-control input-sm mask-number" id="amount" name="amount" readonly="" value="<?php echo $main['TotalBalance'];?>">
            </div>
            <div class="col-md-4 padtop-2">
              <label>Transfer Date</label>
            </div>
            <div class="col-md-8 padtop-2">
              <input type="text" class="form-control input-sm" readonly="" value="<?php echo $main['TransferDate'];?>">
            </div>
            <div class="col-md-4 padtop-2">
              <label>Insert Date</label>
            </div>
            <div class="col-md-8 padtop-2">
              <input type="text" class="form-control input-sm" readonly="" value="<?php echo $main['InsertDate'];?>">
            </div>
            <div class="col-md-4 padtop-2">
              <label>Insert By</label>
            </div>
            <div class="col-md-8 padtop-2">
              <input type="text" class="form-control input-sm" readonly="" value="<?php echo $main['InsertBy'];?>">
            </div>
            <!-- <div class="form-group"> -->
            <div class="col-md-4 padtop-2">
              <label>Transfer Note</label>
            </div>
              <textarea class="form-control" rows="3" name="note" id="note"><?php echo $main['DepositNote'];?></textarea>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <div class="col-md-3"><label>Customer</label></div>
              <div class="col-md-9">
                <input type="hidden" class="form-control" id="CustomerID" name="CustomerID" readonly="" value="<?php echo $main['CustomerID'];?>">
                <input type="hidden" class="form-control" id="ContactID" name="ContactID" readonly="" value="<?php echo $main['ContactID'];?>">
                <input type="text" class="form-control input-sm" readonly="" name="ContactName" value="<?php echo $main['Company'];?>">
              </div>
            </div><br>
            <?php if (isset($content['detail'])) { ?>
              <table class="table table-bordered table-detail table-responsive">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>By</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    foreach ($content['detail'] as $row => $list) { 
                  ?>
                      <tr>
                          <td><?php echo $list['Dst'];?></td>
                          <td><?php echo number_format($list['Amount'],2);?></td>
                          <td><?php echo $list['Date'];?></td>
                          <td><?php echo $list['By'];?></td>
                      </tr>
                  <?php } ?>
                </tbody>
              </table>
            <?php } ?>
            <div class="row rowdistribution">
              <div class="col-md-6">
                <select class="form-control input-sm DistributionTypeID" style="width: 100%;" name="type" required="">
                  <option value=""></option>
                </select>  
              </div>
              <div class="col-md-6">
                  <input type="text" class="form-control returamount input-sm mask-number" name="returamount" required="" value="<?php echo $main['TotalBalance'];?>">
              </div>
            </div>
            <div class="form-group">
              <label>Retur Note</label>
              <textarea class="form-control input-sm" rows="3" name="returnote" id="returnote"></textarea>
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
	 
  $(".mask-number").inputmask({ 
      alias:"currency", 
      prefix:'', 
      autoUnmask:true, 
      removeMaskOnSubmit:true, 
      showMaskOnHover: true 
  });
  fill_bank_distribution_type()
});

function fill_bank_distribution_type() {
  var par = $('.DistributionTypeID')
  $.ajax({
    url: "<?php echo base_url();?>finance/fill_bank_distribution_type",
    type : 'POST',
    data: {CompanyID: 0},
    dataType : 'json',
    success : function (response) {
      // console.log(response)
      var len = response.length;
      par.empty();
      par.append("<option value='0'></option>");
      for( var i = 0; i<len; i++){
          var DistributionTypeID = response[i]['DistributionTypeID'];
          var DistributionTypeName = response[i]['DistributionTypeName'];
          par.append("<option value='"+DistributionTypeID+"'>"+DistributionTypeName+"</option>");
      }
    }
  })
};

j8("form").submit(function(e){
  if (parseFloat(j8(".returamount").val()) <= 0 ) {
    e.preventDefault();
    alert("Jumlah Retur tidak boleh nol")
    return false
  }
  if (parseFloat(j8(".returamount").val()) > parseFloat(j8("#amount").val()) ) {
    e.preventDefault();
    alert("Jumlah Retur lebih besar dari Deposit Balance")
    return false
  }

});
</script>