<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">
.table-main {
  font-size: 12px;
  white-space: nowrap;
}
.table-main thead tr {
  background: #3c8dbc;
  color: #ffffff;
  align-content: center;
}
.table-main tbody tr:hover {
  background: #eef3f8;
  color: #000;
}
.table-main thead tr td { padding: 2px !important; background: #fff; }
.table-main tbody tr td { padding: 2px !important; }
.ReffType, .ReffTypeMain { width: 80px; }
.ReffNo, .ReffNoMain { width: 80px; }
.notemain, .notedetail { min-width: 400px; }
.amountmain, .amountdetail { width: 120px; }
.select2 { width: 100% !important; min-width: 150px; }
/*.addMainRow, .removerow { margin: 5px; }*/
@media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 110px;
      padding: 5px 15px 5px 5px;
    }
    .form-group span.left2 {
      display: block;
      overflow: hidden;
    }
    .form-group { margin-bottom: 5px; }
}
</style>

<?php 
// print_r($this->session->userdata('DivisiID'));
if (isset($content['main'])) {
  $main = $content['main'];
  $detail = $content['detail'];
}
// echo $main;
?>

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

    <div class="modal fade" id="modal-cell">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <table>
              <tr class="listcompany">
                <td><input class="form-control input-sm ReffType" name="ReffType[]" type="text" required="" readonly=""></td>
                <td><input class="form-control input-sm ReffNo" name="ReffNo[]" type="text" required="" readonly=""></td>
                <td>
                  <input class="contactid" name="contactid[]" type="hidden" readonly="" required="">
                  <input class="form-control input-sm contactname" name="contactname[]" type="text" readonly="" required="">
                </td>
                <td><input class="form-control input-sm notedetail" name="notedetail[]" type="text" required=""></td>
                <td><input class="form-control input-sm amountdetail mask-number" name="amountdetail[]" type="text" required="" readonly=""></td>
                <td>
                  <button type="button" class="btn btn-danger btn-xs removerow"><i class="fa fa-remove"></i></button>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="box box-solid">
      <div class="box-body">
          <form name="form" id="form" action="<?php echo base_url();?>finance/bank_distribution_add_act" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="col-md-6">
              <?php if (isset($main)) { ?>
              <div class="form-group">
                <label class="left">ID</label>
                <span class="left2">
                  <input type="text" class="form-control input-sm" id="DistributionID" name="DistributionID" autocomplete="off" readonly="" value="<?php echo $main['DistributionID'];?>">
                </span>
              </div>
              <?php } ?>

              <div class="form-group">
                <label class="left">Company</label>
                <span class="left2">
                  <select class="form-control input-sm company" style="width: 100%;" name="company" required="">
                    <?php foreach ($fill_company as $row => $list) { ?>
                    <option value="<?php echo $list['CompanyID'];?>"><?php echo $list['CompanyName'];?></option>
                    <?php } ?>
                  </select>  
                </span>
              </div>
              <div class="form-group">
                <label class="left">Type</label>
                <span class="left2">
                  <select class="form-control input-sm DistributionTypeID" style="width: 100%;" name="type" required="">
                    <option value=""></option>
                  </select>  
                </span>
              </div>
              <div class="form-group">
                <label class="left">Note</label>
                <span class="left2">
                  <textarea class="form-control note" id="note" name="note" placeholder="Note" autocomplete="off"></textarea>
                </span>
              </div>
              <div class="form-group">
                <label class="left">Transaction</label>
                <span class="left2">
                  <select class="form-control input-sm" style="width: 100%;" name="transaction" required="">
                    <option value="0"> Transaction needed</option>
                    <option value="1"> no Transaction needed</option>
                  </select>  
                </span>
              </div> 
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Divisi</label>
                <span class="left2">
                  <select class="form-control input-sm divisi" style="width: 100%;" name="divisi" required="">
                    <?php if (isset($main)) { ?>
                    <option value="<?php echo $main['CreatedDivisi'];?>"><?php echo $main['DivisiName'];?></option>
                    <?php } ?>
                    <?php foreach ($fill_divisi as $row => $list) { ?>
                    <option value="<?php echo $list['DivisiID'];?>"><?php echo $list['DivisiName'];?></option>
                    <?php } ?>
                    <option value="0">PRIVATE ONLY</option>
                  </select>  
                </span>
              </div>
              <div class="form-group">
                <label class="left">Contact</label>
                <span class="left2">
                  <select class="form-control input-sm contacttype" style="width: 100%;" name="contacttype" required="">
                    <option value="company">Company</option>
                    <option value="isCustomer">Customer</option>
                    <option value="isEmployee">Employee</option>
                    <option value="isExpedition">Expedition</option>
                    <option value="isSupplier">Supplier</option>
                  </select>  
                </span>
              </div>
              <div class="form-group">
                <label class="left">Date</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right scheduledate" id="scheduledate" name="scheduledate" autocomplete="off" required="">
                </div>
              </div>
              <div class="form-group">
                <label class="left">Total</label>
                <span class="left2">
                  <input type="text" class="form-control input-sm mask-number amounttotal" id="amounttotal" name="amounttotal" readonly="" required="">
                </span>
              </div>
            </div>
            <div class="col-md-12" style="overflow-x:auto;">
              <table class="table table-bordered table-main">
                <thead>
                  <tr>
                    <td><input class="form-control input-sm UpperCase NoSpace ReffTypeMain" name="ReffTypeMain[]" type="text"></td>
                    <td><input class="form-control input-sm UpperCase NoSpace ReffNoMain" name="ReffNoMain[]" type="text"></td>
                    <td><select class="form-control input-sm contactmain" name="contactmain[]"></select></td>
                    <td>
                      <input class="contactidmain" name="contactidmain[]" type="hidden">
                      <input class="contactnamemain" name="contactnamemain[]" type="hidden">
                      <input class="form-control input-sm notemain" name="notemain[]" type="text">
                    </td>
                    <td><input class="form-control input-sm amountmain mask-number" name="amountmain[]" type="text" value="0"></td>
                    <td>
                      <button type="button" class="btn btn-success btn-xs addMainRow"><i class="fa fa-plus"></i></button>
                      <button type="button" class="btn btn-success btn-xs cekAmount"><i class="fa fa-check"></i></button>
                      <!-- <button type="button" class="btn btn-danger btn-xs removeMainRow"><i class="fa fa-remove"></i></button> -->
                    </td>
                  </tr>
                </thead>
                <thead>
                  <tr>
                    <th>Reff Type</th>
                    <th>Reff No</th>
                    <th>Contact</th>
                    <th>Note</th>
                    <th>Amount</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
            <div class="col-md-12">
              <div class="box-footer" style="text-align: center;">
                <button type="button" class="btn btn-success btn-count" onclick="counttotal();">Count Total</button>
                <button type="submit" class="btn btn-primary btn-submit" style="display: none;">Submit</button>
              </div>
            </div>
          </form>
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.inputmask.bundle.js"></script>
<script>
main = []
detail = []
j8  = jQuery.noConflict();
jQuery( document ).ready(function( $ ) {
   
  currentdate = new Date();
  $("#scheduledate").datepicker({ autoclose: true, format: 'yyyy-mm-dd'}).datepicker("setDate", currentdate);

  if ($("#DistributionID").length) {
    main   = $.parseJSON('<?php if ( isset($content['main2'])){ echo $content['main2']; }?>');
    detail   = $.parseJSON('<?php if ( isset($content['detail2'])){ echo $content['detail2']; }?>');
    fillmain()
    filldetail()
  } else {
    $( ".company" ).trigger( "change" );
  }

  $('.contactmain').select2({
    placeholder: 'Minimum 3 Character, ex: Company Name',
    minimumInputLength: 3,
    ajax: {
      url: '<?php echo base_url();?>general/search_contact',
      dataType: 'json',
      data: function (term) {
        return {
            q: term, // search term
            contact: $('.contacttype').val()
        };
      },
      delay: 1000,
      processResults: function (data) {
        return {
          results: data
        };
      },
      cache: true
    }
  });
  $('.contactmain').on("select2:select", function(e) { 
    contactidmain = $(this).val()
    contactnamemain = $(".contactmain option:selected").text()
    $('.contactidmain').val(contactidmain)
    $('.contactnamemain').val(contactnamemain)
  });

  $(".mask-number").inputmask({ 
      alias:"currency", 
      prefix:'', 
      autoUnmask:true, 
      removeMaskOnSubmit:true, 
      showMaskOnHover: true 
  });
});

  function fillmain() {
    j8(".company").val(main['CompanyID']).trigger( "change" )
    j8(".scheduledate").val(main['DistributionDate'])
    j8(".amounttotal").val(main['DistributionTotal'])
    j8(".note").val(main['DistributionNote'])
    j8(".contacttype").val(main['ContactType'])
  }
  function filldetail() {
    for( var i = 0; i<detail.length; i++){
      j8(".listcompany:first .ReffType").val( detail[i]['ReffType'] );
      j8(".listcompany:first .ReffNo").val( detail[i]['ReffNo'] );
      j8(".listcompany:first .contactid").val( detail[i]['ContactID'] );
      j8(".listcompany:first .contactname").val( detail[i]['ContactName'] );
      j8(".listcompany:first .notedetail").val( detail[i]['Note'] );
      j8(".listcompany:first .amountdetail").val( detail[i]['Amount'] );
      j8(".listcompany:first").clone().appendTo('.table-main tbody');
      j8(".listcompany:first input").val("");
    }
  }
  
  j8(".company").live('change', function() {
    var par = j8('.DistributionTypeID')
    $.ajax({
      url: "<?php echo base_url();?>finance/fill_bank_distribution_type",
      type : 'POST',
      data: {CompanyID: $(this).val()},
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
        
        if ($("#DistributionID").length) {
          j8(".DistributionTypeID").val(main['DistributionTypeID'])
        }
      }
    })
  });
  j8(".removerow").live('click', function() {
    j8(this).closest('tr').remove()
    j8('.btn-submit').css("display","none")
    j8('.btn-count').css("display","inline-block")
    j8("#amounttotal").val("0")
  });
  j8(".amountdetail").live('change', function() {
    j8('.btn-submit').css("display","none")
    j8('.btn-count').css("display","inline-block")
    j8("#amounttotal").val("0")
  });
  j8(".addMainRow").live('click', function() {
    amountmain = parseFloat(j8('.amountmain').val()).toFixed(2)
    ReffTypeMain = j8('.ReffTypeMain').val()
    ReffNoMain = j8('.ReffNoMain').val()
    if (amountmain === "0.00") {
      alert("Amount tidal boleh 0!")
      return 
    }

    if (ReffTypeMain != "") {
      $.ajax({
        url: "<?php echo base_url();?>finance/cekReffDistribution",
        type : 'POST',
        data: {ReffTypeMain: ReffTypeMain, ReffNoMain: ReffNoMain },
        dataType : 'json',
        success : function (response) {
          if ( !(response>0) ) {
            j8(".listcompany:first .ReffType").val( j8('.ReffTypeMain').val() );
            j8(".listcompany:first .ReffNo").val( j8('.ReffNoMain').val() );
            j8(".listcompany:first .contactid").val( j8('.contactidmain').val() );
            j8(".listcompany:first .contactname").val( j8('.contactnamemain').val() );
            j8(".listcompany:first .notedetail").val( j8('.notemain').val() );
            j8(".listcompany:first .amountdetail").val( j8('.amountmain').val() );
            j8(".listcompany:first").clone().appendTo('.table-main tbody');
          }
          clearMainRow()
        }
      })
    } else {
      j8(".listcompany:first .ReffType").val( j8('.ReffTypeMain').val() );
      j8(".listcompany:first .ReffNo").val( j8('.ReffNoMain').val() );
      j8(".listcompany:first .contactid").val( j8('.contactidmain').val() );
      j8(".listcompany:first .contactname").val( j8('.contactnamemain').val() );
      j8(".listcompany:first .notedetail").val( j8('.notemain').val() );
      j8(".listcompany:first .amountdetail").val( j8('.amountmain').val() );
      j8(".listcompany:first").clone().appendTo('.table-main tbody');
      clearMainRow()
    }

    j8('.btn-submit').css("display","none")
    j8('.btn-count').css("display","inline-block")
    j8("#amounttotal").val("0")

  });
  j8(".removeMainRow").live('click', function() {
    clearMainRow()
  });
  function clearMainRow() {
    // j8('.contactidmain').val("")
    // j8('.contactnamemain').val("")
    j8('.ReffTypeMain').val("")
    j8('.ReffNoMain').val("")
    j8('.notemain').val("")
    j8('.amountmain').val("0").attr("readonly",false)
    
    j8(".amountdetail:last").inputmask({ 
        alias:"currency", 
        prefix:'', 
        autoUnmask:true, 
        removeMaskOnSubmit:true, 
        showMaskOnHover: true 
    });
  }

  j8(".ReffNoMain").live('change', function() {
    $(".amountmain").val(0)
    cekReff()
  });
  j8(".ReffTypeMain").live('change', function() {
    $(".amountmain").val(0)
    cekReff()
  });
  function cekReff() {
    if ($(".ReffTypeMain").val() === "" && $(".ReffNoMain").val() === "") {
      $(".amountmain").attr("readonly",false)
    } else {
      $(".amountmain").attr("readonly",true)
    }
  }
  function counttotal() {
    total = 0
    j8('.table-main .amountdetail').each(function(){
      console.log( parseFloat( j8(this).val()) )
      total = total + parseFloat( j8(this).val() )
    })
    j8('.amounttotal').val(total)
    j8('.btn-count').css("display","none")
    j8('.btn-submit').css("display","inline-block")
  }
  j8("#form").submit(function(e) {
    if (j8('.table-main tbody tr').length < 1) {
      e.preventDefault();
      alert("List Kosong!")
      return false
    }
    if (j8('.amounttotal').length < 1) {
      e.preventDefault();
      alert("Total tidak boleh kosong!")
      return false
    }
  });

  j8(".cekAmount").live('click', function() {
    ReffTypeMain = $('.ReffTypeMain').val()
    ReffNoMain = $('.ReffNoMain').val()
    $.ajax({
      url: "<?php echo base_url();?>transaction/cekAmount",
      type : 'POST',
      data: {ReffTypeMain: ReffTypeMain, ReffNoMain: ReffNoMain },
      dataType : 'json',
      success : function (response) {
        $('.amountmain').val(response)
      }
    })
  });

</script>
