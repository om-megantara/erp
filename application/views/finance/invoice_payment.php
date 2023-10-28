<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">
.rowdistribution, .padtop-2 { margin-top: 2px !important; }
.padtop-4 { margin-top: 4px !important; }
.select2 { width: 100% !important; }
.distribution { padding-left: 6px !important; }

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
</style>

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <?php echo $PageTitle.' - '. $MainTitle; ?>
    </h1>
    <ol class="breadcrumb">
      <li><a title="HELP" class="btn btn-warning btn-xs" href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>

<?php 
$main = $content['main']; 
?>

  <section class="content">
    <div class="box box-solid">
      <div class="box-body">
        <form name="form" id="form" action="<?php echo base_url();?>finance/invoice_payment_act" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <div class="col-md-4 padtop-2">
              <label>Invoice ID</label>
            </div>
            <div class="col-md-8 padtop-2">
              <input type="text" class="form-control input-sm" id="id" name="id" readonly="" value="<?php echo $main['INVID'];?>">
              <input type="hidden" class="" id="so" name="so" readonly="" value="<?php echo $main['SOID'];?>">
            </div>
            <div class="col-md-4 padtop-2">
              <label>SO / DO</label>
            </div>
            <div class="col-md-8 padtop-2">
              <input type="text" class="form-control input-sm" readonly="" value="<?php echo $main['SOID'].' / '.$main['DOID'];?>">
            </div>
            <div class="col-md-4 padtop-2">
              <label>Invoice Amount</label>
            </div>
            <div class="col-md-8 padtop-2">
              <input type="text" class="form-control input-sm mask-number" readonly="" value="<?php echo number_format($main['INVTotal'],2);?>">
            </div>
            <div class="col-md-4 padtop-2">
              <label>Invoice Balance</label>
            </div>
            <div class="col-md-8 padtop-2">
              <input type="text" class="form-control input-sm mask-number" id="amount" name="amount" readonly="" value="<?php echo $main['TotalOutstanding'];?>">
            </div>
            <div class="col-md-4 padtop-2">
              <label>Invoice Date</label>
            </div>
            <div class="col-md-8 padtop-2">
              <input type="text" class="form-control input-sm" readonly="" value="<?php echo $main['INVDate'];?>">
            </div>
            <div class="col-md-4 padtop-2">
              <label>Due Date</label>
            </div>
            <div class="col-md-8 padtop-2">
              <input type="text" class="form-control input-sm" readonly="" value="<?php echo $main['due_date'].' / '.$main['datediff'].' days';?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <div class="col-md-3"><label>Customer</label></div>
              <div class="col-md-9">
                <input type="hidden" class="form-control input-sm" id="CustomerID" name="CustomerID" readonly="" value="<?php echo $main['CustomerID'];?>">
                <input type="text" class="form-control input-sm" readonly="" value="<?php echo $main['Company'];?>">
              </div>
            </div><br>
            <div class="col-md-12">
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
                            <td class=" alignCenter"><?php echo $list['From'];?></td>
                            <td class="alignRight"><?php echo number_format($list['Amount'],2);?></td>
                            <td class=" alignCenter"><?php echo $list['Date'];?></td>
                            <td><?php echo $list['By'];?></td>
                        </tr>
                    <?php } ?>
                  </tbody>
                </table>
              <?php } ?>
            </div>
            <div class="row rowdistribution">
              <div class="col-xs-7">
                <select class="form-control distribution" name="distribution[]" required=""></select>
              </div>
              <div class="col-xs-5">
                <div class="input-group rowdistributionamount">
                  <input type="text" class="form-control distributionamount mask-number" name="distributionamount[]" required="" value="<?php echo $main['TotalOutstanding'];?>">
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
	 
  get_rsc()
  $(".mask-number").inputmask({ 
      alias:"currency", 
      prefix:'', 
      autoUnmask:true, 
      removeMaskOnSubmit:true, 
      showMaskOnHover: true 
  });
});

function get_rsc() { 
  j8(".distribution").empty()
  SOID = j8("#so").val()
  j8.ajax({
    url: "<?php echo base_url();?>finance/get_customer_payment_rsc",
    type : 'GET',
    data: {SOID:SOID},
    dataType : 'json',
    success : function (response) {
      var len = response.length;
      for( var i = 0; i<len; i++){
          j8(".distribution").append("<option value='"+response[i]['AllocationID']+"' amount='"+response[i]['AllocationAmount']+"'> Deposit "+response[i]['DepositID']+", Amount = "+response[i]['AllocationAmount2']+"</option>");
          j8(".distribution").trigger("change")
      }
    }
  })
};
// j8( ".distribution" ).live('change',function() {
//   par     = j8(this).parent().parent()
//   amount  = par.find(".distribution option:selected").attr("amount")
//   par.find(".distributionamount").val(amount)
// });

function duplicatedistribution() {
  j8.when( countamount() ).then( function() {
    amount = parseFloat(j8("#amount").val())
    result = amount - totaldistributionamount
    j8(".rowdistribution:last").clone().insertAfter(".rowdistribution:last");
    j8(".distributionamount:last").val(result).inputmask({
        alias:"currency", 
        prefix:'', 
        autoUnmask:true, 
        removeMaskOnSubmit:true, 
        showMaskOnHover: true 
    });
  })
}
function countamount() {
  totaldistributionamount = 0
  j8(".distributionamount").each(function() {
    totaldistributionamount = totaldistributionamount + parseFloat(j8(this).val())
  })
}

j8("form").submit(function(e){
  countamount()
  // console.log(parseFloat(j8("#amount").val()))
  // console.log(totaldistributionamount)
  SourceDistribution = []
  j8(".rowdistribution").each(function() {
    AllocationID = j8(this).find('.distribution option:selected').val();
    amount = j8(this).find('.distribution option:selected').attr('amount');
    distributionamount = parseFloat(j8(this).find('.distributionamount').val());
    if (amount < distributionamount ) {
      e.preventDefault();
      alert("Jumlah Amount dengan Distribution tidak sesuai!")
      return false
    }
    if (distributionamount <= 0 ) {
      e.preventDefault();
      alert("Jumlah Distribution tidak boleh minus!")
      return false
    }
    if (SourceDistribution.includes(AllocationID)) {
      e.preventDefault();
      alert("Deposit tidak boleh sama!")
      return false
    } else {
      SourceDistribution.push(AllocationID)
    }
  })
  if (totaldistributionamount > parseFloat(j8("#amount").val()) ) {
    e.preventDefault();
    alert("Jumlah 'Distribution' tidak boleh lebih besar\ndari 'Invoice Amount' tidak sesuai!")
    return false
  }
});
</script>