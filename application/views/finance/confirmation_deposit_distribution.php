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

  <section class="content">

    <div class="box box-solid">
      <div class="box-body">
        <form name="form" id="form" action="<?php echo base_url();?>finance/confirmation_deposit_distribution_act" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <div class="col-md-4 padtop-2">
              <label>Number</label>
            </div>
            <div class="col-md-8 padtop-2">
              <input type="text" class="form-control" id="id" name="id" readonly="" value="<?php echo $content['BankTransactionID'];?>">
            </div>
            <div class="col-md-4 padtop-2">
              <label>Date</label>
            </div>
            <div class="col-md-8 padtop-2">
              <input type="text" class="form-control" id="date" name="date" readonly="" value="<?php echo $content['BankTransactionDate'];?>">
            </div>
            <div class="col-md-4 padtop-2">
              <label>Bank</label>
            </div>
            <div class="col-md-8 padtop-2">
              <input type="text" class="form-control" id="bank" name="bank" readonly="" value="<?php echo $content['BankName'];?>">
            </div>
            <div class="col-md-4 padtop-2">
              <label>Amount</label>
            </div>
            <div class="col-md-8 padtop-2">
              <input type="text" class="form-control mask-number" id="amount" name="amount" readonly="" value="<?php echo $content['BankTransactionAmount'];?>">
            </div>
            <div class="form-group">
              <label>Note</label>
              <textarea class="form-control" rows="3" name="note" id="note"><?php echo $content['BankTransactionNote'];?></textarea>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <div class="col-md-3"><label>Customer</label></div>
              <div class="col-md-9">
                <select class="form-control customer" name="customer" required=""></select>
              </div>
            </div><br>
            <div class="row rowdistribution">
              <div class="col-xs-7 distributionlist">
                <select class="form-control distribution" name="distribution[]" required="">
                  <option value="free">FREE</option>
                </select>
              </div>
              <div class="col-xs-5">
                <div class="input-group rowdistributionamount">
                  <input type="text" class="form-control distributionamount mask-number" autocomplete="off" name="distributionamount[]" required="" value="<?php echo $content['BankTransactionAmount'];?>">
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

j8('.customer').select2({
  placeholder: 'Minimum 3 char, Company',
  minimumInputLength: 3,
  ajax: {
    url: '<?php echo base_url();?>general/search_customer_city',
    dataType: 'json',
    delay: 1000,
    processResults: function (data) {
      return {
        results: data
      };
    },
    cache: true
  }
});
j8('.customer').on("select2:select", function(e) { 
  j8(".distribution").empty().append("<option value='free'>FREE</option>")
  CustomerID = j8(this).val()
  j8.ajax({
    url: "<?php echo base_url();?>finance/get_customer_deposit_dst",
    type : 'GET',
    data: {CustomerID:CustomerID},
    dataType : 'json',
    success : function (response) {
      var len = response.length;
      for( var i = 0; i<len; i++){
        j8(".distribution").append("<option value='"+response[i]['SOID']+"' outstanding='"+response[i]['TotalOutstanding2']+"'>"+response[i]['SOName']+" OutStanding = "+response[i]['TotalOutstanding']+"</option>");
      }
    }
  })
});

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
  j8(".rowdistribution").each(function() {
    outstanding = parseFloat(j8(this).find('.distribution option:selected').attr('outstanding'));
    distributionamount = parseFloat(j8(this).find('.distributionamount').val());
    if (outstanding !== 0 && outstanding < distributionamount ) {
      e.preventDefault();
      alert("Jumlah SO/INV dengan Distribution tidak sesuai!")
      return false
    }
    if (distributionamount <= 0 ) {
      e.preventDefault();
      alert("Jumlah Distribution tidak boleh minus!")
      return false
    }
    if ((outstanding - distributionamount) <= 100 && (outstanding - distributionamount) > 0) {
      alert("SO/INV outstanding kurang dari 100 akan otomatis dilengkapi!")
    }
  })
  if (totaldistributionamount.toFixed(2) !== parseFloat(j8("#amount").val()).toFixed(2) ) {
    e.preventDefault();
    alert("Jumlah Transaction dengan Distribution tidak sesuai! \n "+totaldistributionamount.toFixed(2)+" - "+parseFloat(j8("#amount").val()) )
    return false
  }
});
</script>