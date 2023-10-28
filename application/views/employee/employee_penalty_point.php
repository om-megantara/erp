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
  .kiri { margin-left: -10px; }
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
        <form name="form" id="form" action="<?php echo base_url();?>employee/employee_penalty_point_act" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">Point Order ID </label>
              <label class="left2" name="code"> 
                <?php $no=$content['no']; $nourut=$no+1; $bulan=date("m"); $tahun=date("y"); echo $PointID="SSI.".$content['EmployeeID'].".".str_pad($nourut, 4,"0",STR_PAD_LEFT).".".$bulan.".".$tahun;?></label>
              <input type="hidden" name="code" value="<?php echo $PointID?>">
              <input type="hidden" name="no" value="<?php echo $nourut?>">    
            </div>
            <div class="form-group">
              <label class="left">Date Penalty</label>
              <span class="left2">
                <input type="text" class="form-control input-sm date" name="date" required="">
              </span>
            </div>
            <?php
            if($content['id']==0){?>
            <div class="form-group">
              <label class="left">Employee Name</label>
              <span class="left2">
                <select class="form-control select2 input-sm Employee" id="Employee" name="Employee" required=""> 
                  <?php
                    foreach ($content['employee'] as $row => $list) {
                  ?>
                  <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['fullname'];?></option>
                  <?php } ?>
                </select>
              </span>
            </div>
            <?php } else {?>
            <div class="form-group">
              <label class="left">Employee Name</label>
              <span class="left2">
                <input type="hidden" name="Employee" value="<?php echo $content[0]['EmployeeID'];?>">
                <input type="text" class="form-control input-sm name" name="name" required="" value="<?php echo $content[0]['fullname'];?>" readonly>
              </span>
            </div> 
            <?php } ?>
            <div class="form-group">
              <label class="left">Quantity</label>
              <span class="left2">
                <input type="text" class="form-control input-sm quantity" onkeyup="calculate()" name="quantity" id="quantity" required="">
              </span>
            </div> 
            <div class="form-group">
              <label class="left">Nominal</label>
              <span class="left2">
                <input type="text" class="form-control input-sm nominal" name="nominal" required="" readonly >
              </span>
            </div>
            <div class="form-group">
              <label class="left">Link Basecamp</label>
              <span class="left2">
                <input type="text" class="form-control input-sm basecamp" name="basecamp" id="basecamp" required="">
              </span>
            </div>         
            <div class="form-group">
              <label class="left">Note</label>
              <span class="left2">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-sticky-note-o"></i>
                  </div>
                  <textarea class="form-control pull-right" rows="2" name="note" id="note"></textarea>
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
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
j8 = jQuery.noConflict();
j8( document ).ready(function( $ ) {
  $('.select2').select2();
  $(".date").datepicker({ 
    autoclose: true, 
    format: 'yyyy-mm-dd',
    todayBtn:  1,
  }) 
  
});

function calculate(){
  var quantity = $("#quantity").val();
  $.ajax({
    url: "<?php echo base_url();?>employee/get_quantity",
    type : 'GET',
    data : 'quantity=' +quantity,
    dataType : 'json',
    success : function (response) {
      console.log(response)
      // alert(response['Quantity']);
      $(".nominal").val(response['Quantity']);
    }
  })
}

</script>