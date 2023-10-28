<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">
    @media (min-width: 768px){
      .form-group label.left {
        float: left;
        width: 200px;
        padding: 0px 5px;
        text-align: right;
      }
      .form-group span.left2 {
        display: block;
        overflow: hidden;
        text-align: right;
      }
      .form-group { margin-bottom: 10px; }
    }
    .danger { color: red; }
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
          <div class="col-md-6">
            <div class="form-group">
              <label>Month</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control input-sm" autocomplete="off" name="filterdate" id="filterdate">
              </div>
            </div>
          </div>
          <div class="col-md-6"> 
          </div>
        </div>
        <div class="box-body">
          <form role="form" action="<?php echo base_url();?>accounting/acc_account_assignment_add" method="post">
            <div class="col-md-6">
              <h4>Warehouse</h4>
              <?php foreach ($content['warehouse'] as $key => $list) { ?>
                <div class="form-group">
                    <label class="left">
                      <input type="text" class="form-control input-sm" name="" value="<?php echo $list['ReffName'];?>" readonly>
                      <span><?php echo number_format($list['RealAmount'],2);?></span>
                    </label>
                    <span class="left2">
                      <input type="hidden" name="ReffType[]" value="<?php echo $list['ReffType'];?>">
                      <input type="hidden" name="ReffNo[]" value="<?php echo $list['ReffNo'];?>">
                      <select class="form-control input-sm select2" name="AccountID[]">
                        <?php if (!is_null($list['AccountID'])) { ?>
                          <option value="<?php echo $list['AccountID'];?>"><?php echo $list['AccountName'];?></option>
                        <?php } ?>
                        <option value="0">Empty</option>
                        <?php 
                          foreach ($fill_account_no_child as $row => $list2) { 
                        ?>
                          <option value="<?php echo $list2['AccountID'];?>"><?php echo $list2['AccountCode'].' - '.$list2['AccountName'];?></option>
                        <?php } ?>
                      </select>

                      <?php if ($list['RealAmount'] != $list['AccountAmount']) { ?>
                        <span class="danger">
                      <?php } else { ?>
                        <span>
                      <?php } ?>
                        <?php echo number_format($list['AccountAmount'],2);?>
                      </span>
                    </span>
                </div>
              <?php } ?>
              <h4>Other</h4>
              <?php foreach ($content['other'] as $key => $list) { ?>
                <div class="form-group">
                    <label class="left">
                      <input type="text" class="form-control input-sm" name="" value="<?php echo $list['ReffName'];?>" readonly>
                      <button type="button" class="btn btn-xs btn-primary pull-left cekRealAmount" reff="<?php echo $list['ReffName'];?>"><i class="fa fa-check"></i>cek</button>
                      <span class="span-<?php echo $list['ReffName'];?>"><?php echo number_format($list['RealAmount'],2);?></span>
                    </label>
                    <span class="left2">
                      <input type="hidden" name="ReffType[]" value="<?php echo $list['ReffType'];?>">
                      <input type="hidden" name="ReffNo[]" value="<?php echo $list['ReffNo'];?>">
                      <select class="form-control input-sm select2" name="AccountID[]">
                        <?php if (!is_null($list['AccountID'])) { ?>
                          <option value="<?php echo $list['AccountID'];?>"><?php echo $list['AccountName'];?></option>
                        <?php } ?>
                        <option value="0">Empty</option>
                        <?php 
                          foreach ($fill_account_no_child as $row => $list2) { 
                        ?>
                          <option value="<?php echo $list2['AccountID'];?>"><?php echo $list2['AccountCode'].' - '.$list2['AccountName'];?></option>
                        <?php } ?>
                      </select>
                      
                      <span class="AccountAmount-<?php echo $list['ReffName'];?> danger">
                        <?php echo number_format($list['AccountAmount'],2);?>
                      </span>
                    </span>
                </div>
              <?php } ?>
            </div>
            <div class="col-md-6">
              <h4>Bank</h4>
              <?php foreach ($content['bank'] as $key => $list) { ?>
                <div class="form-group">
                    <label class="left">
                      <input type="text" class="form-control input-sm" name="" value="<?php echo $list['ReffName'];?>" readonly>
                      <span><?php echo number_format($list['RealAmount'],2);?></span>
                    </label>
                    <span class="left2">
                      <input type="hidden" name="ReffType[]" value="<?php echo $list['ReffType'];?>">
                      <input type="hidden" name="ReffNo[]" value="<?php echo $list['ReffNo'];?>">
                      <select class="form-control input-sm select2" name="AccountID[]">
                        <?php if (!is_null($list['AccountID'])) { ?>
                          <option value="<?php echo $list['AccountID'];?>"><?php echo $list['AccountName'];?></option>
                        <?php } ?>
                        <option value="0">Empty</option>
                        <?php 
                          foreach ($fill_account_no_child as $row => $list2) { 
                        ?>
                          <option value="<?php echo $list2['AccountID'];?>"><?php echo $list2['AccountCode'].' - '.$list2['AccountName'];?></option>
                        <?php } ?>
                      </select>
                      
                      <?php if ($list['RealAmount'] != $list['AccountAmount']) { ?>
                        <span class="danger">
                      <?php } else { ?>
                        <span>
                      <?php } ?>
                        <?php echo number_format($list['AccountAmount'],2);?>
                      </span>
                    </span>
                </div>
              <?php } ?>
            </div>
            <div class="col-md-12">
              <center><button type="submit" class="btn btn-primary btn-sm pull-center">Submit</button></center>
            </div>
          </form>
        </div>
      </div>
    </section>

</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
jQuery(function($) {
  $('.select2').select2();

  $("#filterdate").datepicker({ 
    format: "yyyy-mm-dd",
    viewMode: "months", 
    minViewMode: "months"
  })
  $('.cekRealAmount').live('click', function(e){
    reff = $(this).attr('reff')
    filterdate = $('#filterdate').val()
    console.log(filterdate)
    $('.span-'+reff).text('(wait ...)')
    $.ajax({
      url: "<?php echo base_url();?>accounting/cek_real_amount",
      type : 'GET',
      data : 'reff=' + reff+'&filterdate=' + filterdate,
      dataType : 'json',
      success : function (response) { 
        $('.span-'+reff).text(response)
        RealAmount = (response.replace(/[^0-9.]/g,''));
        AccountAmount = ($('.AccountAmount-'+reff).html().replace(/[^0-9.]/g,''));
        // console.log(RealAmount)
        // console.log(AccountAmount)
        // if (RealAmount === AccountAmount) {
        //   $('.AccountAmount-'+reff).removeClass('danger')
        // } else {
        //   $('.AccountAmount-'+reff).addClass('danger')
        // }
      }
    })
  });
})
</script>