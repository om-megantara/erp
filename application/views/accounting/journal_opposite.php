<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">

<style type="text/css"> 
  @media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 120px;
      padding: 5px 15px 5px 5px;
    }
    .form-group span.left2 {
      display: block;
      overflow: hidden;
      padding-bottom: 5px;
    }
    .form-group { margin-bottom: 5px; }
  }
  .divJournalOpposite {
    margin: 5px 0px;
    display: none; 
    border: 1px solid #0073b7; 
    padding: 5px;
    overflow: auto !important;
  }
  .table-account th { text-align: center; }
  .table-account th, .table-account td { font-size: 12px; }
  .table-account tr th:last-child,
  .table-account tr td:last-child {
    max-width: 50% !important;
  }
  .select2-container { min-width: 200px !important; }
</style>

<div class="content-wrapper">
 
  <div class="modal fade" id="modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <table>
              <tr class="tr-account">
                <td>
                    <select class="form-control input-sm JournalType min-w-100" name="Type[]">
                      <option value="debit">debit</option> 
                      <option value="credit">credit</option> 
                    </select> 
                </td>
                <td>
                  <input type="text" class="form-control input-sm mask-number edit-amount min-w-150" autocomplete="off" name="Amount[]" required="" value="0">
                </td>
                <td>
                  <div class="input-group input-group-sm">
                    <select class="form-control input-sm Account" name="Account[]" required="">
                      <option value="">EMPTY</option>
                      <?php 
                        foreach ($fill_account as $row => $list) { 
                      ?>
                      <option value="<?php echo $list['AccountID'];?>"><?php echo $list['AccountCode']." - ".$list['AccountName'];?></option>
                      <?php } ?>
                    </select>  
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-primary add_account">+</button>
                      <button type="button" class="btn btn-danger remove_account" onclick="if ($('.tr-account').length != 2) { $(this).closest('.tr-account').remove();}">-</button>
                    </span>
                  </div>
                </td>
              </tr> 
            </table>
          </div>
        </div>
      </div>
  </div>

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
      <div class="box-header">
        <div class="divJournalOpposite">
          <form role="form" id="formAddJournal" action="<?php echo base_url();?>accounting/journal_opposite_add" method="post">
            <div class="col-md-6"> 
              <div class="form-group">
                <label class="left">Journal ID</label>
                <span class="left2">
                  <input type="text" class="form-control input-sm JournalID" autocomplete="off" name="JournalID" readonly="" required="">
                </span>
              </div>
              <div class="form-group">
                <label class="left">Date</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm DateJournal" autocomplete="off" name="DateJournal" required="">
                </div>
              </div>
              <div class="form-group">
                <label class="left">Note</label>
                <span class="left2">
                  <input type="text" class="form-control input-sm edit-note" autocomplete="off" name="Note" required="">
                  <input type="hidden" class="mask-number AmountReal">
                </span>
              </div> 
              <div class="form-group">
                <label class="left">Type</label>
                <span class="left2">
                  <input type="text" class="form-control input-sm edit-type" autocomplete="off" required="" readonly="">
                </span>
              </div> 
            </div>
            <div class="col-md-6">
              <table class="table table-condensed table-account">
                <thead>
                  <tr>
                    <th class="alignCenter">Type</th>
                    <th class="alignCenter">Amount</th>
                    <th class="alignCenter">Account</th>
                  </tr>
                  <tr class="tr-account">
                    <td>
                        <select class="form-control input-sm JournalType min-w-100" name="Type[]">
                          <option value="debit">debit</option> 
                          <option value="credit">credit</option> 
                        </select> 
                    </td>
                    <td>
                      <input type="text" class="form-control input-sm mask-number edit-amount min-w-150" autocomplete="off" name="Amount[]" required="">
                    </td>
                    <td>
                      <div class="input-group input-group-sm">
                        <select class="form-control input-sm select2 Account" name="Account[]" required="">
                          <option value="">EMPTY</option>
                          <?php 
                            foreach ($fill_account as $row => $list) { 
                          ?>
                          <option value="<?php echo $list['AccountID'];?>"><?php echo $list['AccountCode']." - ".$list['AccountName'];?></option>
                          <?php } ?>
                        </select>  
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-primary add_account">+</button>
                          <button type="button" class="btn btn-danger remove_account" onclick="if ($('.tr-account').length != 2) { $(this).closest('.tr-account').remove();}">-</button>
                        </span>
                      </div>
                    </td>
                  </tr>
                </thead>
              </table> 
            </div>  
            <div class="col-md-12">
                <center><button type="submit" class="btn btn-primary btn-sm pull-center">Submit</button></center>
            </div>
          </form>
        </div>
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered " style="width: 100% !important;">
          <thead>
            <tr>
              <th>Journal</th>
              <th>Account</th>
              <th>Date</th>
              <th>Note</th>
              <th>Type</th>
              <th>Amount</th>
              <th>Reff</th>
              <th>Employee</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          <?php
            if (isset($content)) {
                foreach ($content as $row => $list) { ?>
                <tr>
                  <td><?php echo $list['JournalID'];?></td>
                  <td><?php echo $list['AccountName'];?></td>
                  <td class="alignCenter"><?php echo $list['JournalDate'];?></td>
                  <td><?php echo $list['JournalNote'];?></td>
                  <td><?php echo $list['JournalType'];?></td>
                  <td class="alignRight"><?php echo number_format($list['JournalAmount'],2);?></td>
                  <td class="alignRight"><?php echo $list['ReffType'].' '.$list['ReffNo'];?></td>
                  <td><?php echo $list['fullname'];?></td>
                  <td>
                    <?php if ($list['isPost'] == "1") { ?>
                      <i class="fa fa-fw fa-check-square-o" style="color: green;" title="Posted"></i>
                      <span style="display:none;">Posted</span>
                    <?php } else { ?>
                      <button type="button" class="btn btn-success btn-xs AddJournalOpposite" title="ADD" journal="<?php echo $list['JournalID'];?>" onclick="reset_input()"><i class="fa fa-fw fa-edit"></i></button>
                    <?php } ?>
                  </td>
                </tr>
          <?php } } ?>
          </tbody>
        </table>
      </div>
    </div>

  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/jquery.inputmask.bundle.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
  totalJournalAmount = 0

  initailizeSelect2();
  initailizeMaskNumber()
  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
    "scrollY": true,
    "order": [], 
  })
  
  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

  $('.DateJournal').daterangepicker({ 
    timePicker: true, 
    singleDatePicker: true,
    startDate: new Date(),
    locale: {
      format: 'YYYY-MM-DD HH:mm:ss'
    }
  })
  $(".AddJournalOpposite").live('click', function() {
      par = $(".divJournalOpposite")
      JournalID = $(this).attr('journal')
      if (par.is(':visible') && JournalID === par.find(".JournalID").val()) {
        par.slideUp()
      } else {
        par.slideDown()
      }
      $.ajax({
        url: "<?php echo base_url();?>accounting/acc_journal_edit",
        type : 'GET',
        data : 'JournalID=' + JournalID,
        dataType : 'json',
        success : function (response) {
          par.find(".JournalID").val(response['JournalID'])
          par.find(".DateJournal").val(response['JournalDate'])
          par.find(".edit-note").val(response['JournalNote'])
          par.find(".edit-amount").val(response['JournalAmount'])
          par.find(".AmountReal").val(response['JournalAmount'])
          if (response['JournalType'] === 'debit') {
            par.find(".edit-type").val('credit')
          //   par.find(".AccountCredit").prop("disabled", true);
          //   par.find(".AccountDebit").val(response['AccountID']).select2().trigger('change');
          } else {
            par.find(".edit-type").val('debit')
          //   par.find(".AccountDebit").prop("disabled", true);
          //   par.find(".AccountCredit").val(response['AccountID']).select2().trigger('change');
          }
        }
      })
  }) 
  reset_input = function () {
    $(".divJournalOpposite").find('input').val('')
    $(".divJournalOpposite").find('.select2').val('0').select2().trigger('change').prop("disabled", false);
    // $(".remove_account").each(function() {
    //   $(this).trigger('click')
    // })
  } 
  $(".add_account").live('click', function() {
    $('.tr-account:first').clone().insertAfter('.tr-account:last');
    $('.Account:last').addClass('select2')
    $('.mask-number:last').addClass('edit-amount')
    initailizeSelect2();
    initailizeMaskNumber()
    countamount()
    $('.edit-amount:last').val( $(".AmountReal").val()-totalJournalAmount )
  })

  function initailizeSelect2(){
      $(".select2:last").select2();
  }
  function initailizeMaskNumber(){
    $(".mask-number").inputmask({ 
      alias:"currency", 
      prefix:'', 
      autoUnmask:true, 
      removeMaskOnSubmit:true, 
      showMaskOnHover: true 
    });
  }
}); 
 
function countamount() {
  totalJournalAmount = 0
  $(".edit-amount").each(function() {
    totalJournalAmount = totalJournalAmount + parseFloat($(this).val())
    console.log(parseFloat($(this).val()))
  })
}
$("#formAddJournal").submit(function(e){
  countamount() 
  if (totalJournalAmount.toFixed(2) !== parseFloat($(".AmountReal").val()).toFixed(2) ) {
    e.preventDefault();
    alert("Jumlah Journal Opposite dengan Journal asli tidak sesuai!\n "+totalJournalAmount.toFixed(2)+" - "+parseFloat($(".AmountReal").val()) )
    return false
  }
});
</script>