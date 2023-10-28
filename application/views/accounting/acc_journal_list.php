<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">

<style type="text/css">
  /*css fixed column*/
  .DTFC_LeftWrapper thead th, .DTFC_RightWrapper thead th,
  .DTFC_LeftWrapper tbody td, .DTFC_RightWrapper tbody td {
    font-size: 12px !important;
  }
  .DTFC_LeftWrapper tbody td, .DTFC_RightWrapper tbody td {
    padding: 4px !important;
    vertical-align: text-top;
    height: 28px;
  }
  /*.DTFC_LeftBodyLiner{overflow-y:unset !important}*/
  /*.DTFC_RightBodyLiner{overflow-y:unset !important}*/
  /*---------------------*/

  .divAddJournalMemo, .divEditJournal, .divfilterdate, .divreCalculate { 
    margin: 5px 0px;
    display: none; 
    border: 1px solid #0073b7; 
    padding: 5px;
    overflow: auto !important;
  }
  .rowlist, .rowtext { margin-top: 6px; }

  .table-account th { text-align: center; }
  .table-account th, .table-account td { font-size: 12px; }
  .table-account tr th:last-child,
  .table-account tr td:last-child {
    max-width: 50% !important;
  }
  .select2-container { min-width: 200px !important; }
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
    /*.btn-header { margin-top: -30px; }*/
  }
  .select-filter { display: inline-flex; }
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
                  <input type="text" class="form-control input-sm mask-number edit-amount min-w-150" autocomplete="off" name="Amount[]" required="">
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
  <div class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row rowtext">
            <div class="col-xs-4">
              <input type="hidden" class="form-control input-sm atributeid" name="atributeid[]" readonly>
              <input type="text" class="form-control input-sm atributetype" name="atributetype[]" readonly>
            </div>
            <div class="col-xs-8">
              <div class="input-group input-group-sm">                
                <input type="text" class="form-control input-sm atributevalue" name="atributevalue[]" required="">
                <span class="input-group-btn input-group-atributeConn">
                  <select name="atributeConn[]" class="form-control input-sm atributeConn">
                      <option value="or ">OR</option>
                      <option value="and">AND</option>
                  </select>
                </span>
                <span class="input-group-btn">
                  <button type="button" class="btn btn-primary  add_field" onclick="$(this).closest('.rowtext').remove();">-</button>
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
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>

  <section class="content">
    <div class="box box-solid">
      <div class="box-header">
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT"><i class="fa fa-fw fa-print"></i> Print</button>
        <a href="#" id="filterdate" class="btn btn-xs btn-primary btn-header filterdate"><i class="fa fa-search"></i> Filter</a>
        <a href="<?php echo base_url();?>accounting/journal_opposite" class="btn btn-xs btn-primary btn-header">+ Add Journal Opposite</a>
        <a href="#" id="AddJournalMemo" class="btn btn-xs btn-primary btn-header AddJournalMemo" onclick="reset_input()">+ Add Journal Memo</a>
        <a href="#" id="reCalculate" class="btn btn-xs btn-primary btn-header reCalculate" onclick="reset_input()">reCalculate</a>
        
        <span class="select-filter">
            <div class="input-group input-group-sm ">
                <select class="form-control select2 AccountList"></select>
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary cek_account">CEK</button>
                </span>
            </div>
        </span>

        <div class="divreCalculate">
          <form role="form" action="<?php echo base_url();?>accounting/acc_journal_recalculate" method="post" >
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Date Calculate</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm" autocomplete="off" name="DateCalculate" id="DateCalculate" required="">
                </div>
              </div> 
              <div class="form-group">
                <label class="left">
                  Account
                </label>
                <span class="left2">
                  <select class="form-control input-sm select2 AccountCalculate" name="AccountCalculate" required="">
                    <option value="0">ALL</option>
                    <?php 
                      foreach ($fill_account as $row => $list) { 
                    ?>
                    <option value="<?php echo $list['AccountID'];?>"><?php echo $list['AccountCode']." - ".$list['AccountName'];?></option>
                    <?php } ?>
                  </select> 
                </span>
              </div>
            </div>
            <div class="col-md-6">
              <button type="submit" class="btn btn-primary pull-center">Submit</button>
            </div>
          </form>
        </div>
        <div class="divfilterdate">
          <form role="form" action="<?php echo current_url();?>" method="post" >
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">START</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm" autocomplete="off" name="filterstart" id="filterstart" >
                </div>
              </div>
              <div class="form-group">
                <label class="left">END</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm" autocomplete="off" name="filterend" id="filterend" >
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">
                  Account
                </label>
                <span class="left2">
                  <select class="form-control input-sm select2 AccountFilter" name="AccountFilter" required="">
                    <option value="0">All</option>
                    <?php 
                      foreach ($fill_account as $row => $list) { 
                    ?>
                    <option value="<?php echo $list['AccountID'];?>"><?php echo $list['AccountCode']." - ".$list['AccountName'];?></option>
                    <?php } ?>
                  </select> 
                </span>
              </div>
              <div class="form-group">
                <label class="left">Atribute List</label>
                <span class="left2">
                  <div class="input-group input-group-sm">
                      <select class="form-control input-sm atributelist" style="width: 100%;" name="atributelist" required="">
                        <option value="JournalID_text">JournalID</option>
                        <option value="ReffNo_text">ReffNo</option>
                        <option value="SpecificDate_text">SpecificDate</option>
                        <option value="Note_text">Note</option>
                        <option value="Amount_text">Amount</option>
                        <option value="SQL_text">SQL</option>
                      </select>
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-primary add_field" onclick="createattribute();">+</button>
                      </span>
                  </div>
                </span>
              </div>
              <label id="atributelabel"></label> 
            </div>
            <div class="col-md-12">
              <center><button type="submit" class="btn btn-primary pull-center">Submit</button></center>
            </div>
          </form>
        </div>
        <div class="divEditJournal">
          <form role="form" id="formEditJournal" action="<?php echo base_url();?>accounting/acc_journal_edit_act" method="post">
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
                </span>
              </div>
              <div class="form-group">
                <label class="left">Amount</label>
                <span class="left2">
                  <input type="text" class="form-control input-sm mask-number edit-amount" autocomplete="off" name="Amount" required="">
                </span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">
                  Account Type
                </label>
                <span class="left2">
                  <select class="form-control input-sm JournalType" name="JournalType" required="">
                    <option value="debit">debit</option>
                    <option value="credit">credit</option>
                  </select> 
                </span>
              </div>
              <div class="form-group">
                <label class="left">
                  Account Name
                </label>
                <span class="left2">
                  <select class="form-control input-sm select2 AccountName" name="AccountName" required="">
                    <option value="0">EMPTY</option>
                    <?php 
                      foreach ($fill_account as $row => $list) { 
                    ?>
                    <option value="<?php echo $list['AccountID'];?>"><?php echo $list['AccountCode']." - ".$list['AccountName'];?></option>
                    <?php } ?>
                  </select> 
                </span>
              </div>
            </div>
            <div class="col-md-12">
                <center><button type="submit" class="btn btn-primary btn-sm pull-center">Submit</button></center>
            </div>
          </form>
        </div> 
        <div class="divAddJournalMemo">
          <form role="form" action="<?php echo base_url();?>accounting/acc_journal_add" method="post">
            <div class="col-md-6"> 
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
                  <input type="text" class="form-control input-sm" autocomplete="off" name="Note" required="">
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
              <th rowspan="2">Journal</th>
              <th rowspan="2">Reff</th>
              <th rowspan="2">Account</th>
              <th rowspan="2">Date</th>
              <th rowspan="2">Note</th>
              <th colspan="2">Amount</th>
              <th rowspan="2">Balance</th>
              <th rowspan="2">Employee</th>
              <th rowspan="2"></th>
            </tr>
            <tr>
              <th>Debit</th>
              <th>Credit</th>
            </tr>
          </thead>
          <tbody>
          <?php
            if (isset($content)) {
                foreach ($content as $row => $list) { 
          ?>
                <tr>
                  <td><?php echo $list['JournalID'];?></td>
                  <td class="alignRight"><?php echo $list['ReffType'].' '.$list['ReffNo'];?></td>
                  <td><?php echo $list['AccountName'];?></td>
                  <td class="alignCenter"><?php echo $list['JournalDate'];?></td>
                  <td><?php echo $list['JournalNote'];?></td>
                  <?php if ($list['JournalType'] == 'debit') { ?>
                    <td class="alignRight"><?php echo number_format($list['JournalAmount'],2);?></td>
                    <td></td>
                  <?php } else { ?>
                    <td></td>
                    <td class="alignRight"><?php echo number_format($list['JournalAmount'],2);?></td>
                  <?php } ?>
                  <td class="alignRight"><?php echo number_format($list['JournalBalance'],2);?></td>
                  <td><?php echo $list['fullname'];?></td>
                  <td>
                    <?php if ($list['isPost'] == "1") { ?>
                      <i class="fa fa-fw fa-check-square-o" style="color: green;" title="Posted"></i>
                      <span style="display:none;">Posted</span>
                    <?php } else { ?>
                      <button type="button" class="btn btn-success btn-xs EditJournal" title="EDIT" journal="<?php echo $list['JournalID'];?>" onclick="reset_input()"><i class="fa fa-fw fa-edit"></i></button>
                      <button type="button" class="btn btn-danger btn-xs deleteJournal" title="DELETE" journal="<?php echo $list['JournalID'];?>"><i class="fa fa-fw fa-trash-o"></i></button>
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
<script src="<?php echo base_url();?>tool/dataTables.rowsGroup.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.inputmask.bundle.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>

<script>
  var reset_input
$( document ).ready(function( $ ) {
  $('.select2').select2();
  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
    "order": [[3,'desc'],[0,'desc']],
    "columnDefs": [{
      targets: "_all",
      orderable: false,
    }],
    "fixedColumns": {
        leftColumns: 1,
        rightColumns: 1
    },
    "rowsGroup": [3],
    "scrollX": true,
    "scrollY": true,
    "scrollCollapse": true,
    initComplete: function () {
        this.api().columns(2).every( function () {
            var column = this;
            column.data().unique().sort().each( function ( d, j ) {
                $('.AccountList').append( '<option value="'+d+'">'+d+'</option>' )
            } );
        } );
    },
  })

  var cek_dt = function() {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

  $('.DateJournal').daterangepicker({ 
    timePicker: true, 
    singleDatePicker: true,
    startDate: new Date(),
    // minDate: moment().add(-1, 'M').toDate(),
    // minDate: "2018-07-25",
    // maxDate: moment(),
    locale: {
      format: 'YYYY-MM-DD HH:mm:ss'
    }
  })
  $("#DateCalculate").datepicker({ 
    "setDate": new Date(), 
    autoclose: true, 
    format: 'yyyy-mm-dd',
    todayBtn:  1,
  }) 
  $("#filterstart").datepicker({ 
    "setDate": new Date(), 
    autoclose: true, 
    format: 'yyyy-mm-dd',
    todayBtn:  1,
  }).on('changeDate', function (selected) {
    var minDate = new Date(selected.date.valueOf());
    var date2 = $('#filterstart').datepicker('getDate');
    $('#filterend').datepicker('setStartDate', minDate);
    $('#filterend').datepicker('setDate', date2);

  }); 
  $("#filterend").datepicker({ 
    "setDate": new Date(), 
    autoclose: true, 
    format: 'yyyy-mm-dd',
  }).on('changeDate', function (selected) {
    var maxDate = new Date(selected.date.valueOf());
    $('#filterstart').datepicker('setEndDate', maxDate);
  });
  $(".mask-number").inputmask({ 
      alias:"currency", 
      prefix:'', 
      autoUnmask:true, 
      removeMaskOnSubmit:true, 
      showMaskOnHover: true 
  });

  reset_input = function () {
    $(".divEditJournal").find('input').val('')
    $(".divEditJournal").find('.select2').val('0').select2().trigger('change').prop("disabled", false);
    // $(".divEditJournal").find(".DateJournal").daterangepicker("setDate", new Date());

    $(".divAddJournalMemo").find('input').val('')
    $(".divAddJournalMemo").find('.select2').val('0').select2().trigger('change').prop("disabled", false);
    // $(".divAddJournalMemo").find(".DateJournal").daterangepicker("setDate", new Date());
  }
  $(".cek_account").click(function(){
    $('#dt_list').dataTable().fnFilter($('.AccountList').val());
  });

  $(".reCalculate").click(function(){
    $(".divreCalculate").slideToggle();
  });
  $(".filterdate").click(function(){
    $(".divfilterdate").slideToggle();
  });
  $(".AddJournalMemo").click(function(){
    $(".divAddJournalMemo").slideToggle();
    $(".divEditJournal").slideUp()
  });
  $('.EditJournal').live('click', function(e){
    par = $(".divEditJournal")
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
        par.find(".AccountName").val(response['AccountID']).select2().trigger('change');
        par.find(".JournalType").val(response['JournalType'])
      }
    })
  });
  $('.deleteJournal').live('click', function(e){
    JournalID = $(this).attr('journal')
    var r = confirm("Apa anda yakin akan menghapus Journal "+JournalID+"?");
    if (r == true) {
      $.ajax({
        url: '<?php echo base_url();?>accounting/journal_delete',
        type: 'post',
        data: {JournalID: JournalID},
        dataType: 'json',
        success:function(response){
              if (response === 'success') {
                alert('success, hapus Journal berhasil!')
                location.reload()
                return false
              } else {
                alert('fail!')
              }
          } 
      });
    }
  });

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
  $(".add_account").live('click', function() {
    $('.tr-account:first').clone().insertAfter('.tr-account:last');
    $('.Account:last').addClass('select2')
    $('.mask-number:last').addClass('edit-amount')
    initailizeSelect2();
    initailizeMaskNumber()
  })
  $('button.print_dt').on('click', function() {               
      var fvData = table.rows({ search:'applied', page: 'all' }).data(); 
      $('.div_dt_print').empty().append(
         '<table id="dtTablePrint" class="col">' +
         '<thead>'+
         '<tr>'+
            $.map(table.columns().visible(),
                function(colvisible, colindex){
                   return (colvisible) ? "<th>" + $(table.column(colindex).header()).html() + "</th>" : null;
             }).join("") +
         '</tr>'+
         '</thead>'+
         '<tbody>' +
            $.map(fvData, function(rowdata, rowindex){
               return "<tr>" + $.map(table.columns().visible(),
                  function(colvisible, colindex){
                     return (colvisible) ? "<td class='col"+colindex+"'>" + $('<div/>').text(rowdata[colindex]).text() + "</td>" : null;
                  }).join("") + "</tr>";
            }).join("") +
         '</tbody>' +
         '<tfoot>' +
         '<tr>'+
            $.map(table.columns().visible(),
                function(colvisible, colindex){
                   return (colvisible) ? "<th>" + $(table.column(colindex).footer()).html() + "</th>" : null;
             }).join("") +
         '</tr>'+
         '</tfoot></table>'
      );

      for (var i = 0; i < $('button.print_dt').attr('removeTd'); i++) {
        $("#dtTablePrint th:last-child, #dtTablePrint td:last-child").remove();
      }

      var w = window.open();
      var html = $(".div_dt_print").html();
      $(w.document.body).append('<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">');
      $(w.document.body).append("<link href='<?php echo base_url();?>tool/dtPrint.css' rel='stylesheet' type='text/css' />");
      $(w.document.body).append(html);
  });
});

function createattribute() {
  atributelist = $(".atributelist").val().split("_")
  atributename = $(".atributelist option:selected").text()
  if (atributelist[1] === "text") {
      $(".rowtext:first .atributeid").val(atributelist[0]);
      $(".rowtext:first .atributetype").val(atributename);
      $(".rowtext:first").clone().insertBefore('#atributelabel');
  } 
}
$("#formEditJournal").submit(function(e) {
  if ($(this).find('.JournalID').val() === undefined) {
    e.preventDefault();
    alert("Journal ID is empty!")
    return false
  }
});

</script>