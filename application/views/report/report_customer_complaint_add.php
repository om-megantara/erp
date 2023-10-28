<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css"> 
@media (min-width: 768px){
  .form-group label.left {
    float: left;
    width: 130px;
    padding: 5px 15px 5px 5px;
  }
  .form-group span.left2 {
    display: block;
    overflow: hidden;
  }
  .form-group { margin-bottom: 10px; }
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
    $MenuList = $this->session->userdata('MenuList');
    if(in_array("report_customer_complaint_open", $MenuList)){$open=1;} else {$open=0;} ?>
  <section class="content">

    <div class="box box-solid">
      <div class="box-body">
        <form name="form" id="form" action="<?php echo base_url();?>report/report_customer_complaint_add_act" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <?php if($open==1){ ?>
            <div class="form-group">
              <label class="left">Code</label>
              <label class="left2" name="code"> 
                <input type="text" class="form-control" name="code" required="">
                <input type="hidden" name="no" value="0">  
                <input type="hidden" name="id" value="0"> 
              </label>
            </div>
            <?php } else { ?>
            <div class="form-group">
              <label class="left">Code</label>
              <label class="left2" name="code"> 
                <?php 
                  $id=$content['id'];
                  $idurut=$id+1;
                  $no=$content['no']; 
                  $nourut=$no+1; 
                  $bulan=date("m"); 
                  $tahun=date("y"); 
                  echo $COmplaintID="C.".str_pad($nourut, 4,"0",STR_PAD_LEFT).".".$bulan.".".$tahun;?>
              </label>
              <input type="hidden" name="code" value="<?php echo $COmplaintID?>">
              <input type="hidden" name="no" value="<?php echo $nourut?>">  
              <input type="hidden" name="id" value="<?php echo $idurut?>">  
            </div>
            <?php } ?>
            <div class="form-group">
              <label class="left">CustomerID</label>
              <input type="hidden" name="customerid" value="<?php echo $this->input->get_post('CustomerID');?>">
              <label class="left2" name="customerid">
                <?php echo $this->input->get_post('CustomerID'); ?></label>
            </div>
            <div class="form-group">
              <label class="left">Customer</label>
              <span class="left2">
                <select class="form-control customer" name="customer" required=""></select>
              </span>
            </div> 
            <div class="form-group">
              <label class="left">Open Date</label>
              <span class="left2">
                <input type="text" class="form-control input-sm date" name="date" required="">
              </span>
            </div>  
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">Sales</label>
              <input type="hidden" name="salesid" value="<?php echo $content['SalesID'];?>">
              <label class="left2" name="sales">
                <?php echo $sales = $content['sales'];?></label>
            </div>
            <div class="form-group">
              <label class="left">SOID</label>
              <input type="hidden" name="soid" value="<?php echo $this->input->get_post('SOID');?>">
              <label class="left2" name="soid">
                <?php echo $this->input->get_post('SOID');?></label>
            </div> 
            <div class="form-group">
              <label class="left">DOID</label>
              <input type="hidden" name="doid" value="<?php echo $content['DOID'];?>">
              <label class="left2" name="doid">
                <?php echo $content['DOID'];?></label>
            </div>
            <div class="form-group">
              <label class="left">Link</label>
              <span class="left2">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-link"></i>
                  </div>
                  <textarea class="form-control pull-right" rows="2" name="link" id="link" placeholder="Diawali https://" required=""></textarea>
                </div>
              </span>
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
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
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

  $(".date").datepicker({ 
    autoclose: true, 
    format: 'yyyy-mm-dd',
    todayBtn:  1,
  }).datepicker("setDate", new Date())

  <?php if (isset($content)) { ?>
    var data = {
        id: '<?php echo $content['CustomerID']; ?>',
        text: '<?php echo $content['Company2']; ?>',
    };
    var newOption = new Option(data.text, data.id, false, false);
    $('.customer').append(newOption).trigger('change');
  <?php } ?>
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
</script>