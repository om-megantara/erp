<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">

<style type="text/css"> 
  @media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 100px;
      padding: 5px 15px 5px 5px;
    }
    .form-group span.left2 {
      display: block;
      overflow: hidden;
      padding-bottom: 5px;
    }
    .form-group { margin-bottom: 5px; }
  }
  .divDistributionJournalAdd {
    display: none;
    border: 1px solid #0073b7;
    overflow: auto;
    padding: 10px 0px;
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
      <div class="box-header">
        <div class="divDistributionJournalAdd">
          <form role="form" action="<?php echo base_url();?>accounting/acc_journal_distribution_add" method="post">
            <div class="col-md-6"> 
              <div class="form-group">
                <label class="left">Distribution</label>
                <span class="left2">
                  <input type="text" class="form-control input-sm DistributionID" autocomplete="off" name="DistributionID" required="" readonly="">
                </span>
              </div>
              <div class="form-group">
                <label class="left">Note</label>
                <span class="left2"> 
                  <input type="text" class="form-control input-sm Note" autocomplete="off" name="Note" required="">
                </span>
              </div>
              <div class="form-group">
                <label class="left">Amount</label>
                <span class="left2">
                  <input type="text" class="form-control input-sm mask-number Amount" autocomplete="off" name="Amount" required="">
                </span>
              </div>
            </div>
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
                <label class="left">type</label>
                <span class="left2">
                  <select class="form-control input-sm Type" name="Type" required="">
                    <option value="credit">credit</option>
                    <option value="debit">debit</option>
                  </select> 
                </span>
              </div>
              <div class="form-group">
                <label class="left">
                  Account
                </label>
                <span class="left2">
                  <select class="form-control input-sm select2 Account" name="Account" required="">
                    <option value="">EMPTY</option>
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
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered " style="width: 100%;">
          <thead>
            <tr>
              <th>ID</th>
              <!-- <th>Company</th> -->
              <th>Bank</th>
              <th>Date</th>
              <th>Note</th>
              <th>Divisi</th>
              <th>By</th>
              <th>Amount</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
                  // echo count($content);
              if (isset($content)) {
                  foreach ($content as $row => $list) { 
            ?>
                  <tr>
                    <td class="alignCenter"><?php echo $list['DistributionID'];?></td>
                    <!-- <td><?php echo $list['CompanyName'];?></td> -->
                    <td><?php echo $list['DistributionTypeName'];?></td>
                    <td class="alignCenter"><?php echo date('Y-m-d', strtotime($list['DistributionDate']));?></td>
                    <td><?php echo $list['DistributionNote'];?></td>
                    <td><?php echo $list['DivisiName'];?></td>
                    <td><?php echo $list['fullname'];?></td>
                    <td class="alignRight"><?php echo number_format($list['DistributionTotal'],2);?></td>
                    <td>
                      <button type="button" class="btn btn-success btn-xs report" title="Report" reff="bank_distribution_print?id=<?php echo $list['DistributionID'];?>"><i class="fa fa-fw fa-print"></i></button>
                      <button type="button" class="btn btn-success btn-xs create_journal" DistributionID="<?php echo $list['DistributionID'];?>" title="CREATE JOURNAL"><i class="fa fa-fw fa-edit"></i></button>
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
  $('.select2').select2();
	 
  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
    "scrollY": true,
    "order": [[ 0, "asc" ]], 
  })
  
  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

  $(".mask-number").inputmask({ 
    alias:"currency", 
    prefix:'', 
    autoUnmask:true, 
    removeMaskOnSubmit:true, 
    showMaskOnHover: true 
  });
  $('.DateJournal').daterangepicker({ 
    timePicker: true, 
    singleDatePicker: true,
    startDate: new Date(),
    locale: {
      format: 'YYYY-MM-DD HH:mm:ss'
    }
  })
}); 
 
reset_input = function () {
  $(".divDistributionJournalAdd").find('input').val('')
  $(".divDistributionJournalAdd").find('.select2').val('0').select2().trigger('change').prop("disabled", false);
}
$(".create_journal").live('click', function() {
  par = $(".divDistributionJournalAdd")
  DistributionID = $(this).attr('DistributionID')
  if (par.is(':visible') && DistributionID === par.find(".DistributionID").val()) {
    par.slideUp()
  } else {
    par.slideDown()
  }
  $.ajax({
      url: "<?php echo base_url();?>finance/get_distribution_detail",
      type : 'POST',
      data: {DistributionID: DistributionID},
      dataType : 'json',
      success : function (response) {
        console.log(response)
        if (response['DistributionTypeTransaction'] === 'debit') {var Type = 'credit'} else {var Type = 'debit'}
        par.find('.DistributionID').empty().val(response['DistributionID']);
        par.find('.Amount').empty().val(response['DistributionTotal']);
        par.find('.Note').empty().val(response['DistributionNote']);
        // par.find('.Type').empty().val(Type);
      }
    })
})
$(".report").live('click', function() {
  reff = $(this).attr("reff")
  openPopupOneAtATime2(reff);
});
var popup;
function openPopupOneAtATime2(x) {
  if (popup && !popup.closed) {
     popup.focus();
     popup.location.href = '<?php echo base_url();?>finance/'+x;
  } else {
     popup = window.open('<?php echo base_url();?>finance/'+x, '_blank', 'width=780,height=500,left=200,top=100');     
  }
}
</script>