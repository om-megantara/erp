<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

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
  .form-group { 
    display: block; 
    margin-bottom: 5px !important; 
  }
  .phone, .email {
    margin-top: 2px;
  }
  .add_addr {
    font-size: 18px; 
    font-weight: bold; 
    color: white; 
    background-color: #5bc0de; 
    padding: 0px 8px;
  }
  .fullname .form-control, 
  .address .form-control { 
    margin-top: 3px; 
  }
  .box-body h6 {
    display: inline; 
    color: red; 
    font-weight: bold;
  }
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

<div class="content-wrapper">
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
      <div class="box-body form_addcontact">
          <div class="col-md-12">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Employee Information</a></li>
                <li><a href="#tab_2" data-toggle="tab">Address</a></li>
                <li><a href="#tab_3" data-toggle="tab">Document File</a></li>
                <li><a href="#tab_4" data-toggle="tab">Family Information</a></li>
                <li><a href="#tab_6" data-toggle="tab">Resign Date</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                  <div class="row">
                    <form name="form employee_add" action="<?php echo base_url();?>employee/employee_edit_act/personal" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
                      <input type="hidden" name="contactid" value="<?php echo $content['personal']['ContactID'];?>">
                      <input type="hidden" name="employeeid" value="<?php echo $content['personal']['EmployeeID'];?>">
                      <div class="col-md-6">
                        <div class="box box-solid">
                          <div class="box-header with-border">
                            <h3 class="box-title">Personal Information</h3>
                          </div>
                            <div class="box-body">
                              <div class="form-group fullname">
                                <label class="left">Full Name <h6>*</h6> </label>
                                <span class="left2">
                                  <input type="text" class="form-control input-sm" placeholder="Fisrt Name" autocomplete="off" name="firstname" id="firstname" value="<?php echo $content['personal']['NameFirst'];?>">
                                  <input type="text" class="form-control input-sm" placeholder="Middle Name" autocomplete="off" name="middlename" id="middlename" value="<?php echo $content['personal']['NameMid'];?>">
                                  <input type="text" class="form-control input-sm" placeholder="Last Name" autocomplete="off" name="lastname" id="lastname" value="<?php echo $content['personal']['NameLast'];?>">
                                </span>
                              </div>
                              <div class="form-group">
                                <label class="left">Gender</label>
                                <span class="left2">
                                  <select class="form-control input-sm" name="gender" id="gender">
                                  <option value="M">Male</option>
                                  <option value="F">Female</option>   
                                </select>
                                </span>
                              </div>
                              <div class="form-group">
                                <label class="left">Birth Date</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" class="form-control input-sm pull-right" id="birthdate" name="birthdate" value="<?php echo $content['personal']['BirthDate'];?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="left">Religion</label>
                                <span class="left2">
                                  <select class="form-control input-sm" name="religion" id="religion"></select>
                                </span>
                              </div>
                              <div class="form-group">
                                <label class="left">Marital Status</label>
                                <span class="left2">
                                  <select class="form-control input-sm" name="maritalstatus" id="maritalstatus">
                                    <option value="0">Single</option>
                                    <option value="1">Married</option>   
                                </select>
                                </span>
                              </div>
                              <div class="form-group">
                                <label class="left">ID Card Number</label>
                                <span class="left2">
                                  <input type="text" class="form-control input-sm" id="noktp" name="noktp" placeholder="ID Card Number" autocomplete="off" value="<?php echo $content['personal']['KTP'];?>">
                                </span>
                              </div>
                              <div class="form-group">
                                <label class="left">NPWP Number</label>
                                <span class="left2">
                                  <input type="text" class="form-control input-sm" id="npwp" name="npwp" placeholder="No NPWP" autocomplete="off" value="<?php echo $content['personal']['NPWP'];?>">
                                </span>
                              </div>
                            </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="box box-solid">
                          <div class="box-header with-border">
                            <h3 class="box-title">Employee Information</h3>
                          </div>
                            <div class="box-body">
                              <div class="form-group">
                                <label class="left">NIP <h6>*</h6></label>
                                <span class="left2">
                                  <input type="text" class="form-control input-sm" id="nip" name="nip" placeholder="NIP" autocomplete="off" value="<?php echo $content['personal']['NIP'];?>">
                                </span>
                              </div>
                              <div class="form-group">
                                <label class="left">BIO ID <h6>*</h6></label>
                                <span class="left2">
                                  <input type="text" class="form-control input-sm" id="bioid" name="bioid" placeholder="BIO ID" autocomplete="off" value="<?php echo $content['personal']['BIOID'];?>">
                                </span>
                              </div>
                              <div class="form-group">
                                <label class="left">Attendance Group</label>
                                <span class="left2">
                                  <select class="form-control input-sm" name="AttendanceGroupTime" id="AttendanceGroupTime">
                                  <option></option>   
                                  </select>
                                </span>
                              </div>
                              <div class="form-group">
                                <label class="left">Join Date</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" class="form-control input-sm pull-right" id="joindate" name="joindate" value="<?php echo $content['personal']['JoinDate'];?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="left">Employment Status</label>
                                <span class="left2">
                                  <select class="form-control input-sm" name="employment" id="employment"></select>
                                </span>
                              </div>

                              <div class="form-group">
                                <label class="left">Date Range</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" class="form-control input-sm pull-right" id="dateemployment" name="dateemployment" value="<?php echo $content['personal']['EmploymentDate'];?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="left">Office Location</label>
                                <span class="left2">
                                  <select class="form-control input-sm" name="officelocation" id="officelocation">
                                  <option></option>   
                                  </select>
                                </span>
                              </div>
                              <div class="form-group">
                                <label class="left">Email Name</label>
                                <span class="left2">
                                  <input type="text" class="form-control input-sm" id="emailemployee" name="emailemployee" placeholder="Email Name" autocomplete="off" value="<?php echo $content['personal']['Email'];?>">
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
                <div class="tab-pane" id="tab_2">
                  <div class="row">
                    <form name="form employee_add" action="<?php echo base_url();?>employee/employee_edit_act/address" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
                      <input type="hidden" name="contactid" value="<?php echo $content['personal']['ContactID'];?>">
                      <input type="hidden" name="employeeid" value="<?php echo $content['personal']['EmployeeID'];?>">
                      <div class="col-md-6">
                        <div class="box box-solid">
                          <div class="box-header with-border">
                            <h3 class="box-title">Address</h3>
                          </div>
                          <div class="box-body">
                            <?php
                            // print_r($content['alamat']);
                              foreach ($content['alamat'] as $row => $list) {?>
                                <div class="form-group address">
                                  <label style="margin-right: 20px;">Address</label> 
                                  <a href="#" class="btn btn-primary btn-xs" onclick="duplicateaddr();" class="add_addr">+</a>
                                  <a href="#" class="btn btn-primary btn-xs" onclick="if ($('.address').length != 1) { $(this).closest('div').remove();}" class="add_addr">-</a>
                                  <input type="text" class="form-control input-sm" name="titlealamat[]" placeholder="Title Address" value="<?php echo $list['DetailType'];?>">
                                  <textarea class="form-control input-sm" rows="3" placeholder="Street Address" name="alamat[]"><?php echo $list['DetailValue'];?></textarea>
                                  <select class="form-control input-sm state" name="state[]">
                                    <option value='<?php echo $list['StateID'];?>' selected><?php echo $list['StateName'];?></option>
                                  </select>
                                  <select class="form-control input-sm province" name="province[]">
                                    <option value='<?php echo $list['ProvinceID'];?>' selected><?php echo $list['ProvinceName'];?></option>
                                  </select>
                                  <select class="form-control input-sm city" name="city[]">
                                    <option value='<?php echo $list['CityID'];?>' selected><?php echo $list['CityName'];?></option>
                                  </select>
                                  <select class="form-control input-sm districts" name="districts[]">
                                    <option value='<?php echo $list['DistrictsID'];?>' selected><?php echo $list['DistrictsName'];?></option>
                                  </select>
                                  <select class="form-control input-sm pos" name="pos[]">
                                    <option value='<?php echo $list['PosName'];?>' selected><?php echo $list['PosName'];?></option>
                                  </select>
                                </div>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="box box-solid">
                          <div class="box-header with-border">
                            <h3 class="box-title">Detail</h3>
                          </div>
                          <div class="box-body">
                            <div class="form-group">
                              <label class="left">Phone</label>
                              <span class="left2">
                                <?php
                                foreach ($content['phone'] as $row => $listphone) {?>
                                <div class="input-group input-group-sm phone">
                                  <input type="text" class="form-control input-sm" name="phone[]" placeholder="ex : +62 81xxxxxxxxx" value='<?php echo $listphone['DetailValue'];?>'>
                                  <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary  add_field" onclick="duplicatephone();">+</button>
                                    <button type="button" class="btn btn-primary  add_field" onclick="if ($('.phone').length != 1) { $(this).closest('div').remove();}">-</button>
                                  </span>
                                </div>
                                <?php } ?>
                              </span>
                            </div>
                            <div class="form-group">
                                <label class="left">Email</label>
                                <span class="left2">
                                  <?php
                                  foreach ($content['email'] as $row => $listemail) {?>
                                  <div class="input-group input-group-sm email">
                                    <input type="text" class="form-control input-sm" name="email[]" placeholder="ex : user@gmail.com" value='<?php echo $listemail['DetailValue'];?>'>
                                      <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary  add_field" onclick="duplicateemail();">+</button>
                                        <button type="button" class="btn btn-primary  add_field" onclick="if ($('.email').length != 1) { $(this).closest('div').remove();}">-</button>
                                      </span>
                                  </div>
                                  <?php } ?>
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
                <div class="tab-pane" id="tab_3">
                  <div class="row">
                    <form name="form employee_add" action="<?php echo base_url();?>employee/employee_edit_act/file" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
                      <input type="hidden" name="contactid" value="<?php echo $content['personal']['ContactID'];?>">
                      <input type="hidden" name="employeeid" value="<?php echo $content['personal']['EmployeeID'];?>">
                      <div class="col-md-6">
                        <div class="box box-solid">
                          <div class="box-header with-border">
                            <h3 class="box-title">Document File</h3>
                          </div>
                          <div class="box-body">
                            <div class="form-group">
                              <label class="left">Profile Picture</label>
                              <span class="left2">
                                <input type="file" class="input-file" id="pp" name="pp">
                                <p class="help-block">Item type must be JPG and 150kb maximum size.</p>
                              </span>
                            </div>
                            <div class="form-group">
                              <label class="left">CV</label>
                              <span class="left2">
                                <input type="file" class="input-file" id="cv" name="cv" >
                                <p class="help-block">Item type must be PDF and 500kb maximum size.</p>
                              </span>
                            </div>
                            <div class="form-group">
                              <label class="left">Appraisal</label>
                              <span class="left2">
                                <input type="file" class="input-file" id="appraisal" name="appraisal" >
                                <p class="help-block">Item type must be PDF and 500kb maximum size.</p>
                              </span>
                            </div>
                            <div class="form-group">
                              <label class="left">Certificate</label>
                              <span class="left2">
                                <input type="file" class="input-file" id="ijazah" name="ijazah" >
                                <p class="help-block">Item type must be PDF and 500kb maximum size.</p>
                              </span>
                            </div>
                            <div class="form-group">
                              <label class="left">ID Card</label>
                              <span class="left2">
                                <input type="file" class="input-file" id="ktp" name="ktp" >
                                <p class="help-block">Item type must be PDF and 500kb maximum size.</p>
                              </span>
                            </div>
                            <div class="form-group">
                              <label class="left">KSK</label>
                              <span class="left2">
                                <input type="file" class="input-file" id="ksk" name="ksk" >
                                <p class="help-block">Item type must be PDF and 500kb maximum size.</p>
                              </span>
                            </div>
                            <div class="form-group">
                              <label class="left">SKCK</label>
                              <span class="left2">
                                <input type="file" class="input-file" id="skck" name="skck" >
                                <p class="help-block">Item type must be PDF and 500kb maximum size.</p>
                              </span>
                            </div>
                            <div class="form-group">
                              <label class="left">Certificate Domicile</label>
                              <span class="left2">
                                <input type="file" class="input-file" id="domisili" name="domisili" >
                                <p class="help-block">Item type must be PDF and 500kb maximum size.</p>
                              </span>
                            </div>
                            <div class="form-group">
                              <label class="left">Reference</label>
                              <span class="left2">
                                <input type="file" class="input-file" id="referensi" name="referensi" >
                                <p class="help-block">Item type must be PDF and 500kb maximum size.</p>
                              </span>
                            </div>
                          </div>
                          <div class="box-footer" style="text-align: center;">
                            <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="tab-pane" id="tab_4">
                  <div class="row">
                    <form name="form employee_add" action="<?php echo base_url();?>employee/employee_edit_act/family" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
                      <input type="hidden" name="contactid" value="<?php echo $content['personal']['ContactID'];?>">
                      <input type="hidden" name="employeeid" value="<?php echo $content['personal']['EmployeeID'];?>">
                      <div class="col-md-6">
                        <div class="box box-solid">
                          <div class="box-header with-border">
                            <h3 class="box-title">Family Information</h3>
                          </div>
                          <div class="box-body">
                            <div class="form-group">
                              <label class="left">Full Name</label>
                              <span class="left2">
                                <input type="text" class="form-control input-sm" placeholder="Full Name" autocomplete="off" name="familyname" id="familyname" value="<?php echo $content['family']['FamilyName'];?>">
                              </span>
                            </div>
                            <div class="form-group">
                              <label class="left">Status</label>
                              <span class="left2">
                                <input type="text" class="form-control input-sm" placeholder="ex : Kakak kandung" autocomplete="off" name="familystatus" id="familystatus" value="<?php echo $content['family']['FamilyStatus'];?>">
                              </span>
                            </div>
                            <div class="form-group">
                              <label class="left">Gender</label>
                              <span class="left2">
                                <select class="form-control input-sm" name="familysex">
                                  <option value="M">Male</option>
                                  <option value="F">Female</option>   
                                </select>
                              </span>
                            </div>
                            <div class="form-group">
                              <label class="left">Job</label>
                              <span class="left2">
                                <input type="text" class="form-control input-sm" placeholder="ex : Wirausaha" autocomplete="off" name="familyjob" id="familyjob" value="<?php echo $content['family']['FamilyJob'];?>">
                              </span>
                            </div>
                            <div class="form-group">
                              <label class="left">Address</label>
                              <span class="left2">
                                <textarea class="form-control input-sm" rows="3" placeholder="Address" name="familyalamat"><?php echo $content['family']['FamilyAddress'];?></textarea>
                              </span>
                            </div>
                            <div class="form-group">
                              <label class="left">Phone</label>
                              <span class="left2">
                                <input type="text" class="form-control input-sm" placeholder="Phone" autocomplete="off" name="familyphone" id="familyphone" value="<?php echo $content['family']['FamilyPhone'];?>">
                              </span>
                            </div>
                           <div class="form-group">
                              <label class="left">Email</label>
                              <span class="left2">
                                <input type="text" class="form-control input-sm" placeholder="Email" autocomplete="off" name="familyemail" id="familyemail" value="<?php echo $content['family']['FamilyEmail'];?>">
                              </span>
                            </div>
                          </div>
                          <div class="box-footer" style="text-align: center;">
                            <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="tab-pane" id="tab_6">
                  <div class="row">
                    <form name="form employee_add" action="<?php echo base_url();?>employee/employee_edit_act/resign" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
                      <input type="hidden" name="contactid" value="<?php echo $content['personal']['ContactID'];?>">
                      <input type="hidden" name="employeeid" value="<?php echo $content['personal']['EmployeeID'];?>">
                      <div class="col-md-6">
                        <div class="box box-solid">
                          <div class="box-header with-border">
                            <h3 class="box-title">Resign Date</h3>
                          </div>
                          <div class="box-body">
                                                        
                            <div class="form-group">
                              <label class="left">Join Date</label>
                              <div class="input-group date">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control input-sm pull-right" id="joindate2" name="joindate2" value="<?php echo $content['personal']['JoinDate'];?>" readonly="">
                              </div><br>
                              <label class="left">Resign Date</label>
                              <div class="input-group date">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control input-sm pull-right" id="resigndate" name="resigndate" value="<?php echo $content['personal']['ResignDate'];?>">
                              </div>
                            </div>
                          </div>
                          <div class="box-footer" style="text-align: center;">
                            <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </section>
</div>


<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/jquery-ui.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script>
j8  = jQuery.noConflict();
j8( document ).ready(function( $ ) {
   
  $("#birthdate").datepicker({ autoclose: true, format: 'yyyy-mm-dd'});
  $("#joindate").datepicker({ autoclose: true, format: 'yyyy-mm-dd'});
  $("#datejob").datepicker({ autoclose: true, format: 'yyyy-mm-dd'});
  $("#resigndate").datepicker({ autoclose: true, format: 'yyyy-mm-dd'});
  $("#dateemployment").daterangepicker({
    autoclose: true,
    locale: { format: 'YYYY-MM-DD' }
  });
  fill_religion();
  fill_state();
  fill_employment();
  fill_officelocation();
  fill_jobtitle();
  fill_attendance_group();
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
  $('#gender option[value=<?php echo $content['personal']['gender'];?>]').attr('selected','selected');
  $('#maritalstatus option[value=<?php echo $content['personal']['maritalstatus'];?>]').attr('selected','selected');
  $('#familysex option[value=<?php echo $content['family']['FamilySex'];?>]').attr('selected','selected');

});
j8('#firstname').live('change',function(e){
  firstname = $('#firstname').val();
  lastname  = $('#lastname').val();
  $('#emailemployee').val(firstname+"."+lastname+"@angzdna.net");
})
j8('#lastname').live('change',function(e){
  firstname = $('#firstname').val();
  lastname  = $('#lastname').val();
  $('#emailemployee').val(firstname+"."+lastname+"@angzdna.net");
})
function fill_religion() {
  $.ajax({
      url: '<?php echo base_url();?>employee/fill_religion',
      type: 'post',
      dataType: 'json',
      success:function(response){
          var len = response.length;
          $("#religion").empty();
          for( var i = 0; i<len; i++){
              var ReligionName = response[i]['ReligionName'];
              var ReligionID = response[i]['ReligionID'];
              if (ReligionID == <?php echo $content['personal']['religion'];?>) {
                $("#religion").append("<option value='"+ReligionID+"' selected='selected'>"+ReligionName+"</option>");
              } else {
                $("#religion").append("<option value='"+ReligionID+"'>"+ReligionName+"</option>");
              }
          }
      }
  });
}
function fill_state() {
  // var par = $(this).parent().find(".state").first()
  $.ajax({
      url: '<?php echo base_url();?>employee/fill_state',
      type: 'post',
      dataType: 'json',
      success:function(response){
        var len = response.length;
        for( var i = 0; i<len; i++){
          var StateName = response[i]['StateName'];
          var StateID = response[i]['StateID'];

          $(".state").append("<option value='"+StateID+"'>"+StateName+"</option>");
          // par.append("<option value='"+StateID+"'>"+StateName+"</option>");
        }
      }
  });
}
function fill_attendance_group() {
  // var par = $(this).parent().find(".state").first()
  $.ajax({
      url: '<?php echo base_url();?>employee/fill_attendance_group',
      type: 'post',
      dataType: 'json',
      success:function(response){
        var len = response.length;
        for( var i = 0; i<len; i++){
          var GroupTimeID = response[i]['GroupTimeID'];
          var GroupTimeName = response[i]['GroupTimeName'];

          $("#AttendanceGroupTime").append("<option value='"+GroupTimeID+"'>"+GroupTimeName+"</option>");
          // par.append("<option value='"+StateID+"'>"+StateName+"</option>");
        }
        $('#AttendanceGroupTime option[value=<?php echo $content['personal']['GroupTimeID'];?>]').attr('selected','selected');
      }
  });
}



j8('.state').live('change',function(e){
  $(this).parent().find(".city").empty();
  $(this).parent().find(".city").append("<option value='0' selected disabled>CITY</option>");
  $(this).parent().find(".districts").empty();
  $(this).parent().find(".districts").append("<option value='0' selected disabled>SUB DISTRICT</option>");
  $(this).parent().find(".pos").empty();
  $(this).parent().find(".pos").append("<option value='0' selected disabled>POSTAL CODE</option>");
  var par = $(this).parent().find(".province").first()
  $.ajax({
    url: "<?php echo base_url();?>employee/fill_province",
    type : 'GET',
    data : 'StateID=' + $(this).val(),
    dataType : 'json',
    success : function (response) {
      var len = response.length;
      par.empty();
      par.append("<option value='0' selected disabled>PROVINCE</option>");
      for( var i = 0; i<len; i++){
          var ProvinceName = response[i]['ProvinceName'];
          var ProvinceID = response[i]['ProvinceID'];
          par.append("<option value='"+ProvinceID+"'>"+ProvinceName+"</option>");
      }
    }
  })
})
j8('.province').live('change',function(e){
  $(this).parent().find(".districts").empty();
  $(this).parent().find(".districts").append("<option value='0' selected disabled>SUB DISTRICT</option>");
  $(this).parent().find(".pos").empty();
  $(this).parent().find(".pos").append("<option value='0' selected disabled>POSTAL CODE</option>");
  var par = $(this).parent().find(".city").first()
  $.ajax({
    url: "<?php echo base_url();?>employee/fill_city",
    type : 'GET',
    data : 'ProvinceID=' + $(this).val(),
    dataType : 'json',
    success : function (response) {
      var len = response.length;
      par.empty();
      par.append("<option value='0'></option>");
      for( var i = 0; i<len; i++){
          var CityName = response[i]['CityName'];
          var CityID = response[i]['CityID'];
          par.append("<option value='"+CityID+"'>"+CityName+"</option>");
      }
    }
  })
})
j8('.city').live('change',function(e){
  var par = $(this).parent().find(".districts").first()
  var par2 = $(this).parent().find(".pos").first()
  $.ajax({
    url: "<?php echo base_url();?>employee/fill_districts",
    type : 'GET',
    data : 'CityID=' + $(this).val(),
    dataType : 'json',
    success : function (response) {
      var len = response['dis'].length;
      par.empty();
      par.append("<option value='0'></option>");
      for( var i = 0; i<len; i++){
          var DistrictsName = response['dis'][i]['DistrictsName'];
          var DistrictsID = response['dis'][i]['DistrictsID'];
          par.append("<option value='"+DistrictsID+"'>"+DistrictsName+"</option>");
      }

      var len2 = response['pos'].length;
      par2.empty();
      par2.append("<option value='0'></option>");
      for( var i = 0; i<len2; i++){
          var PosName = response['pos'][i]['PosName'];
          var PosID = response['pos'][i]['PosID'];
          par2.append("<option value='"+PosName+"'>"+PosName+"</option>");
      }
    }
  })
})
j8('.districts').live('change',function(e){
  var par = $(this).parent().find(".pos").first()
  $.ajax({
    url: "<?php echo base_url();?>employee/fill_pos",
    type : 'GET',
    data : 'DistrictsID=' + $(this).val(),
    dataType : 'json',
    success : function (response) {
      var len = response.length;
      console.log(len);
      par.empty();
      par.append("<option value='0'></option>");
      for( var i = 0; i<len; i++){
          var PosName = response[i]['PosName'];
          var PosID = response[i]['PosID'];
          par.append("<option value='"+PosName+"'>"+PosName+"</option>");
      }
    }
  })
})
function fill_employment() {
  $.ajax({
      url: '<?php echo base_url();?>employee/fill_employment',
      type: 'post',
      dataType: 'json',
      success:function(response){
          var len = response.length;
          $("#employment").empty();
          for( var i = 0; i<len; i++){
              var EmploymentName = response[i]['EmploymentName'];
              var EmploymentID = response[i]['EmploymentID'];
              if (EmploymentID == <?php echo $content['personal']['EmploymentID'];?>) {
                $("#employment").append("<option value='"+EmploymentID+"' selected='selected'>"+EmploymentName+"</option>");
              } else {
                $("#employment").append("<option value='"+EmploymentID+"'>"+EmploymentName+"</option>");
              }
          }
      }
  });
}
function fill_officelocation() {
  $.ajax({
      url: '<?php echo base_url();?>employee/fill_officelocation',
      type: 'post',
      dataType: 'json',
      success:function(response){
          var len = response.length;
          $("#officelocation").empty();
          for( var i = 0; i<len; i++){
              var LocID = response[i]['LocID'];
              var LocCode = response[i]['LocCode'];
              if (LocID == <?php echo $content['personal']['LocID'];?>) {
                $("#officelocation").append("<option value='"+LocID+"' selected='selected'>"+LocCode+"</option>");
              } else {
                $("#officelocation").append("<option value='"+LocID+"'>"+LocCode+"</option>");
              }
          }
      }
  });
}
function fill_jobtitle() {
  $.ajax({
      url: '<?php echo base_url();?>employee/fill_jobtitle',
      type: 'post',
      dataType: 'json',
      success:function(response){
          var len = response.length;
          $("#jobtitle").empty();
          for( var i = 0; i<len; i++){
              var LevelID = response[i]['LevelID'];
              var LevelCode = response[i]['LevelCode'];
              $("#jobtitle").append("<option value='"+LevelID+"'>"+LevelCode+"</option>");
          }
      }
  });
}

function duplicatephone() { $(".phone:last").clone().insertAfter(".phone:last"); }
function duplicateemail() { $(".email:last").clone().insertAfter(".email:last"); }
function duplicateaddr() { 
  $(".address:first").clone().insertAfter(".address:last"); 
  // $(".address:last").find(".province").empty();
  // $(".address:last").find(".city").empty();
  // $(".address:last").find(".districts").empty();
  // $(".address:last").find(".pos").empty();
}
function cek_input_detail() {
  if (!$("#firstname").val() || !$("#bioid").val() || !$("#nip").val() ) {
    alert("Column cannot be empty");
    return false;
  }
}
j8('.input-file').live('change', function() {
  if (this.files[0].size/1024 > 210000) {
    alert('File size is : ' + this.files[0].size/1024 + "KB, than overload!");
  }
});
</script>