<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css">  
  .rowtext {
    margin-bottom: 3px;
  }
  @media (min-width: 768px){
      .form-group label.left {
        float: left;
        width: 120px;
        padding: 5px 15px 5px 5px;
      }
      .form-group span.left2 {
        display: block;
        overflow: hidden;
      }
      .form-group { margin-bottom: 5px; }

      .rowtext .col-xs-3 { padding-right: 3px !important; }
      .rowtext .col-xs-9 { padding-left: 3px !important; }
  }
</style>

<?php
if (isset($content['report_formula_detail'])) {
  $main = $content['report_formula_detail']['main'];
  $detail = $content['report_formula_detail']['detail'];
  $detail2 = $content['report_formula_detail']['detail2'];
}
?>

<div class="content-wrapper">

  <div class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row rowtext">
            <div class="col-xs-3">
              <div class="input-group input-group-sm">                
                <input type="text" class="form-control input-sm AccountID" name="AccountID[]" readonly>
                <span class="input-group-btn input-group-atributeConn">
                  <select name="atributeConn[]" class="form-control input-sm atributeConn">
                      <option value="debit">debit</option>
                      <option value="credit">credit</option>
                  </select>
                </span>
              </div>
            </div>
            <div class="col-xs-9">
              <div class="input-group input-group-sm">                
                <input type="text" class="form-control input-sm AccountName" name="AccountName[]" readonly="">
                <span class="input-group-btn">
                  <button type="button" class="btn btn-success moveUp" title="move Up">+</button>
                  <button type="button" class="btn btn-warning moveDown" title="move Down">-</button>
                  <button type="button" class="btn btn-danger remove" title="Remove" onclick="$(this).closest('.rowtext').remove();">x</button>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="content-header">
    <h1>
      <?php echo $PageTitle.' - '. $MainTitle; ?>
    </h1>
    <ol class="breadcrumb">
      <li><a title="HELP" class="btn btn-warning btn-xs" href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>

  <section class="content">
    <div class="box box-solid">
      <div class="box-header">
        
      </div>
      <div class="box-body">
        <form role="form" action="<?php echo base_url();?>accounting/report_formula_add_act" method="post" class="form-productnamingformula_act" >
            <div class="box box-solid ">
              <div class="box-header">
                <h3 class="box-title">Add Report Formula</h3>
                <button type="submit" class="btn btn-sm btn-primary pull-right" title="SUBMIT">Submit</button>
              </div>
              <div class="box-body">
                <div class="col-md-6 ">
                  <?php if (isset($main)) { ?>
                  <div class="form-group">
                    <label class="left">Report ID</label>
                    <span class="left2">
                      <input type="text" class="form-control input-sm" id="ReportID" name="ReportID" autocomplete="off" readonly="" value="<?php echo $main['ReportID'];?>">
                    </span>
                  </div>
                  <?php }; ?>
                  <div class="form-group">
                    <label class="left">Report Name</label>
                    <span class="left2"> 
                      <input type="text" class="form-control input-sm FormulaName" name="FormulaName" required="">
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Report Name</label>
                    <span class="left2">
                          <select class="form-control input-sm FormulaType" style="width: 100%;" name="FormulaType" required="">
                            <?php if (isset($main['ReportType'])) { ?>
                              <option value="<?php echo $main['ReportType'];?>"><?php echo $main['ReportType'];?></option>
                            <?php } ?>
                            <option value="kumulatif">kumulatif</option>
                            <option value="periodik">periodik</option> 
                          </select>
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Account</label>
                    <span class="left2">
                      <div class="input-group input-group-sm">
                          <select class="form-control input-sm AccountList" style="width: 100%;" name="AccountList" required="">
                            <option value="0" Aname=""></option>
                            <option value="0" Aname="Note">Note</option>
                            <option value="0" Aname="SUB TOTAL">SUB TOTAL</option>
                            <option value="0" Aname="TOTAL">TOTAL</option>
                            <?php foreach ($content['fill_account'] as $row => $list) { ?>
                                <option value="<?php echo $list['AccountID'];?>" Acode="<?php echo $list['AccountCode'];?>" Aname="<?php echo $list['AccountName'];?>">
                                  <?php echo $list['AccountCode']." ".$list['AccountName2'];?>
                                </option>
                            <?php } ?>
                          </select>
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-primary  add_field" onclick="createList();">+</button>
                          </span>
                      </div>
                    </span>
                  </div>
                </div>
                <div class="col-md-6 AccountFormulaList"> 

                </div> 
              </div>
            </div>
        </form>
      </div>
      <div class="box-footer">
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script>
var ReportDetail = [];
var selected = 0;
var itemlist = $('.AccountFormulaList');

jQuery( document ).ready(function( $ ) {
  // jika edit
  if ($("#ReportID").length) {
    $(".FormulaName").val('<?php if ( isset($main)){ echo $main['ReportName']; }?>');
    ReportDetail = $.parseJSON('<?php if ( isset($detail2)){ echo $detail2; }?>');
    if (ReportDetail !== null) {
      for( var i = 0; i< ReportDetail.length; i++){
          buildList( ReportDetail[i]['AccountID'], ReportDetail[i]['Note'], ReportDetail[i]['AccountType'] ) 
      }
    }
  }

    // $(".rowtext").click(function(){
    //     selected= $(this).index();
    //     alert("Selected item is " + $(this).index());
    // });

    $(".moveUp").live('click', function(){
      selected = $(this).parents(".rowtext").index();
      if(selected > 0) {
        $($(itemlist).children().eq(selected-1)).before($($(itemlist).children().eq(selected)));
      }
    });

    $(".moveDown").live('click', function(){
      selected = $(this).parents(".rowtext").index();
      len = $(itemlist).children().length; 
      if(selected < len) {
          $($(itemlist).children().eq(selected+1)).after($($(itemlist).children().eq(selected)));
      }
    });

}); 

function buildList(AccountID, AccountName, AccountType='debit') {
  $(".rowtext:first .AccountID").val(AccountID);
  $(".rowtext:first .AccountName").val(AccountName);
  $(".rowtext:first").clone().appendTo('.AccountFormulaList');
  if (AccountID === '0') {
    if (AccountName !== 'TOTAL' && AccountName !== 'SUB TOTAL' && AccountName !== '') {
      $(".rowtext:last").find('.AccountName').attr('readonly', false);
    }
  }
  $(".rowtext:last .atributeConn option[value="+AccountType+"]").attr('selected','selected');;
}

function createList() {
  AccountID = $(".AccountList").val()
  AccountName = $(".AccountList option:selected").text()
  AccountName2 = $(".AccountList option:selected").attr('Acode')+" - "+$(".AccountList option:selected").attr('Aname')
  buildList(AccountID, AccountName2)
}
</script>