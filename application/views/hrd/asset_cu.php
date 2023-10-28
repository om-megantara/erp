<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">

<style type="text/css"> 
  #addcontact {
    margin: 10px;
    background-color: #00a65a;
    color: white;
    padding: 2px 5px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    font-weight: bold;
  }
  .form-group { display: block; margin-bottom: 5px !important; }
  .customaddr {font-size: 12px; padding: 0px 3px; font-weight: bold; margin-bottom: 3px;}
  .phone, .email, .employeename {margin-top: 2px;}
  .add_addr {font-size: 18px; font-weight: bold; color: white; background-color: #5bc0de; padding: 0px 8px;}
  .fullname .form-control, .address .form-control { margin-top: 3px; }
  .box-body h6 {display: inline; color: red; font-weight: bold;}
  @media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 150px;
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
// print_r($content); 
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
    <div class="box box-solid">
      <div class="box-header with-border">
      </div>
      <div class="box-body form_addcontact">
          <form name="form employee_add" id="form employee_add" action="<?php echo base_url();?>hrd/asset_cu_act" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <input type="hidden" name="assetid" id="showhidediv" value="<?php echo $content['personal']['AssetID'];?>">
            <input type="hidden" name="contactid" value="<?php echo $content['personal']['ContactID'];?>">
            <input type="hidden" name="assetdetailid" value="<?php echo $content['personal']['AssetDetailID'];?>">
            <div class="col-md-6">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Asset Information</h3>
                </div>
                <div class="box-body">
                  <div class="form-group fullname">
                    <label class="left">Asset Name <h6>*</h6> </label>
                    <span class="left2">
                      <input type="text" class="form-control input-sm" placeholder="Asset Name" autocomplete="off" name="assetname" id="assetname" value="<?php echo $content['personal']['AssetName'];?>">
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Model Number</label>
                    <span class="left2">
                      <input type="text" class="form-control input-sm" id="modelnumber" name="modelnumber" placeholder="Model Number" autocomplete="off" value="<?php echo $content['personal']['ModelNumber'];?>">
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Serial Number</label>
                    <span class="left2">
                      <input type="text" class="form-control input-sm" id="serialnumber" name="serialnumber" placeholder="Serial Number" autocomplete="off" value="<?php echo $content['personal']['SerialNumber'];?>">
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Asset Colour</label>
                    <span class="left2">
                      <select class="form-control input-sm" name="assetcolour" id="assetcolour">
                      <option value="Blue">Blue</option>
                      <option value="Black">Black</option>
                      <option value="Green">Green</option>
                      <option value="Yellow">Yellow</option>
                      <option value="Silver">Silver</option>
                      <option value="Grey">Grey</option>
                      <option value="White">White</option>
                      <option value="Chrome">Chrome</option>
                      <option value="Red">Red</option>
                      <option value="Gold">Gold</option>
                      <option value="Cream">Cream</option>
                      <option value="Orange">Orange</option>
                      <option value="Clear">Clear</option>
                    </select>
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Asset Type</label>
                    <span class="left2">
                      <input type="text" class="form-control input-sm" id="assettype" name="assettype" placeholder="Asset Type" autocomplete="off" value="<?php echo $content['personal']['AssetType'];?>">
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Asset Category</label>
                    <span class="left2">
                      <select class="form-control input-sm" name="assetcategory" id="assetcategory">
                      <option value="Tanah">Tanah</option>
                      <option value="Bangunan">Bangunan</option>
                      <option value="Mesin">Mesin</option>
                       <option value="Kendaraan">Kendaraan</option>
                      <option value="Inventaris">Inventaris</option>  
                    </select>
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Date In</label>
                    <span class="left2">
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                      <input type="text" class="form-control input-sm pull-right" id="datein" name="datein" value="<?php echo $content['personal']['DateIn'];?>" required="">
                      </div>
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Asset Price</label>
                    <span class="left2">
                      <input type="text" class="form-control input-sm" id="price" name="price" placeholder="Price" autocomplete="off" value="<?php echo $content['personal']['Price'];?>">
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Asset Condition</label>
                    <span class="left2">
                      <select class="form-control input-sm" name="assetcondition" id="assetcondition">
                        <option value="Baru">Asset Baru</option>
                        <option value="Baik">Asset Baik</option>
                        <option value="Normal">Asset Normal</option>
                        <option value="Perbaikan">Asset Butuh Perbaikan</option>   
                        <option value="Rusak">Asset Rusak</option>
                      </select>
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Asset Specification</label>
                    <span class="left2">
                      <textarea class="form-control input-sm" id="assetspecification" name="assetspecification" placeholder="Asset Specification" autocomplete="off"><?php echo $content['personal']['AssetSpecification']; ?></textarea>
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Asset Note</label>
                    <span class="left2">
                      <textarea class="form-control input-sm" id="assetnote" name="assetnote" placeholder="Asset Note" autocomplete="off"><?php echo $content['personal']['AssetNote']; ?></textarea>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6" id="addedit">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Asset Information Detail</h3>
                </div>
                <div class="box-body">
                  <div class="form-group">
                    <label class="left">Employee Name <h6>*</h6></label>
                    <span class="left2">
                      <div class="form-group-sm employeename">
                        <select class="form-control input-sm employeenamechild select2" required="" name="employeename[]">
                          <?php
                          foreach ($content['employeename'] as $row => $listemployeename) { ?>
                              <option value='<?php echo $listemployeename['EmployeeID'];?>' selected><?php echo $listemployeename['Fullname'];?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Date In</label>
                    <span class="left2">
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control input-sm pull-right" id="dateind" name="dateind" value="<?php echo $listemployeename['DateInD'];?>" required="">
                     </div>
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Status In</label>
                    <span class="left2">
                      <select class="form-control input-sm" name="statusin" id="statusin">
                        <option value="Good">Good</option>
                        <option value="Not Good">Not Good</option>
                        <option value="Lost">Lost</option>
                        <option value="New">New</option>
                        <option value="Broke">Broke</option>   
                      </select>
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Note</label>
                    <span class="left2">
                      <textarea class="form-control input-sm" id="notedetail" name="notedetail" placeholder="note detail" autocomplete="off"><?php echo $listemployeename['Note']; ?></textarea>
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
      <div class="box-footer">
      </div>
    </div>
  </section>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/jquery-ui.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
$(document).ready(function(){
	
	if ($("input#showhidediv").val() == '') {
			$("#addedit").show();
	}else{
			$("#addedit").hide();
	}
});
	
j8  = jQuery.noConflict();
j8( document ).ready(function( $ ) {
  $('.select2').select2()
   
  $("#datein").datepicker({ autoclose: true, format: 'yyyy-mm-dd'});
  $("#dateind").datepicker({ autoclose: true, format: 'yyyy-mm-dd'});
  $("#dateout").datepicker({ autoclose: true, format: 'yyyy-mm-dd'});
  fill_employeename();
  $("input").keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
  $('#statusin option[value=<?php echo $content['personal']['statusin'];?>]').attr('selected','selected');
  $('#statusout option[value=<?php echo $content['personal']['statusout'];?>]').attr('selected','selected');
  $('#assetcolour option[value=<?php echo $content['personal']['assetcolour'];?>]').attr('selected','selected');
  $('#assetcategory option[value=<?php echo $content['personal']['assetcategory'];?>]').attr('selected','selected');
	
});

function fill_employeename() {
  $.ajax({
      url: '<?php echo base_url();?>hrd/fill_employee_active',
      type: 'post',
      dataType: 'json',
      success:function(response){
          var len = response.length;
          //$("#employeename").empty();
          for( var i = 0; i<len; i++){
              var EmployeeID = response[i]['EmployeeID'];
              var Fullname = response[i]['Fullname'];
              $(".employeenamechild").append("<option value='"+EmployeeID+"'>"+Fullname+"</option>");
          }
      }
  });
}
function duplicateemployeename() { $(".employeename:last").clone().insertAfter(".employeename:last"); }
</script>