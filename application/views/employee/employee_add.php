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
  .customaddr {
    font-size: 12px; 
    padding: 0px 3px; 
    font-weight: bold; 
    margin-bottom: 3px;
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
  .fullname .form-control, .address .form-control { 
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
      width: 120px;
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
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>

  <section class="content">
    <div class="box box-solid">
      <div class="box-body form_addcontact">
        <form name="form employee_add" id="form employee_add" action="<?php echo base_url();?>employee/employee_add_act" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
          <div class="col-md-6">
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">Personal Information</h3>
              </div>
                <div class="box-body">
                  <div class="form-group fullname">
                    <label class="left">Full Name <h6>*</h6> </label>
                    <span class="left2">
                      <input type="text" class="form-control input-sm" placeholder="Fisrt Name" autocomplete="off" name="firstname" id="firstname" required="">
                      <input type="text" class="form-control input-sm" placeholder="Middle Name" autocomplete="off" name="middlename" id="middlename">
                      <input type="text" class="form-control input-sm" placeholder="Last Name" autocomplete="off" name="lastname" id="lastname">
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
                      <input type="text" class="form-control input-sm pull-right" id="birthdate" name="birthdate" required="">
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
                      <input type="text" class="form-control input-sm" id="noktp" name="noktp" placeholder="ID Card Number" autocomplete="off">
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">NPWP Number</label>
                    <span class="left2">
                      <input type="text" class="form-control input-sm" id="npwp" name="npwp" placeholder="NPWP Number" autocomplete="off">
                    </span>
                  </div>
                </div>
            </div>
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">Address</h3>
              </div>
                <div class="box-body">
                  <div class="form-group address">
                    <label style="margin-right: 20px;">Address</label> 
                    <a href="#" class="btn btn-primary btn-xs" onclick="duplicateaddr();" class="add_addr">+</a>
                    <a href="#" class="btn btn-primary btn-xs" onclick="if ($('.address').length != 1) { $(this).closest('div').remove();}" class="add_addr">-</a>
                    <input type="text" class="form-control input-sm" name="titlealamat[]" id="titlealamat" placeholder="Title Address" required="">
                    <textarea class="form-control input-sm" rows="3" placeholder="Street Address" name="alamat[]" id="alamat" required=""></textarea>
                    <select class="form-control input-sm state" id="state" name="state[]"></select>
                    <select class="form-control input-sm province" id="province" name="province[]">
                      <option value='0' selected disabled>SELECT PROVINCE</option>
                    </select>
                    <select class="form-control input-sm city" id="city" name="city[]">
                      <option value='0' selected disabled>SELECT CITY</option>
                    </select>
                    <select class="form-control input-sm districts" id="districts" name="districts[]">
                      <option value='0' selected disabled>SELECT DISTRICT</option>
                    </select>
                    <select class="form-control input-sm pos" id="pos" name="pos[]">
                      <option value='0' selected disabled>SELECT POSTAL CODE</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="left">Phone Number</label>
                    <span class="left2">
                      <div class="input-group input-group-sm phone">
                      <input type="text" class="form-control input-sm" name="phone[]" id="phone" placeholder="ex : +62 81xxxxxxxxx">
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-primary  add_field" onclick="duplicatephone();">+</button>
                          <button type="button" class="btn btn-primary  add_field" onclick="if ($('.phone').length != 1) { $(this).closest('div').remove();}">-</button>
                        </span>
                      </div>
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Email Address</label>
                    <span class="left2">
                      <div class="input-group input-group-sm email">
                      <input type="text" class="form-control input-sm" name="email[]" id="email" placeholder="ex : user@gmail.com">
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-primary  add_field" onclick="duplicateemail();">+</button>
                          <button type="button" class="btn btn-primary  add_field" onclick="if ($('.email').length != 1) { $(this).closest('div').remove();}">-</button>
                        </span>
                      </div>
                    </span>
                  </div>
                </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">Family Information</h3>
              </div>
                <div class="box-body">
                  <div class="form-group">
                    <label class="left">Full Name</label>
                    <span class="left2">
                      <input type="text" class="form-control input-sm" placeholder="Full Name" autocomplete="off" name="familyname" id="familyname">
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Status</label>
                    <span class="left2">
                      <input type="text" class="form-control input-sm" placeholder="ex : Kakak kandung" autocomplete="off" name="familystatus" id="familystatus">
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
                      <input type="text" class="form-control input-sm" placeholder="ex : Wirausaha" autocomplete="off" name="familyjob" id="familyjob">
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Address</label> 
                    <span class="left2">
                      <textarea class="form-control input-sm" rows="3" placeholder="Street Address" name="familyalamat"></textarea>
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Phone</label>
                    <span class="left2">
                      <input type="text" class="form-control input-sm" placeholder="ex : + 62 81xxxxxxxxx" autocomplete="off" name="familyphone" id="familyphone">
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Email</label>
                    <span class="left2">
                      <input type="text" class="form-control input-sm" placeholder="ex : user@gmail.com" autocomplete="off" name="familyemail" id="familyemail">
                    </span>
                  </div>
                </div>
            </div>
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">Employee Information</h3>
              </div>
                <div class="box-body">
                  <div class="form-group">
                    <label class="left">NIP <h6>*</h6></label>
                    <span class="left2">
                      <input type="text" class="form-control input-sm" id="nip" name="nip" placeholder="NIP" autocomplete="off" required="">
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">BIO ID <h6>*</h6></label>
                    <span class="left2">
                      <input type="text" class="form-control input-sm" id="bioid" name="bioid" placeholder="BIO ID" autocomplete="off" required="">
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Join Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control input-sm pull-right" id="joindate" name="joindate">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="left" for="exampleInputFile">Profile Picture</label>
                    <span class="left2">
                      <input type="file" id="pp" name="pp" >
                      <p class="help-block">Item Type Must Be in JPG.</p>
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">Employment </label>
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
                      <input type="text" class="form-control input-sm pull-right" id="dateemployment" name="dateemployment">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="left">Job Title</label>
                    <span class="left2">
                      <select class="form-control input-sm" name="jobtitle" id="jobtitle" required=""></select>
                    </span>
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
                      <input type="text" class="form-control input-sm" id="emailemployee" name="emailemployee" placeholder="Email Name" autocomplete="off" required="">
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
  $("#dateemployment").daterangepicker({
    autoclose: true,
    locale: { format: 'YYYY-MM-DD' }
  });
  fill_religion();
  fill_state();
  fill_employment();
  fill_officelocation();
  fill_jobtitle();
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
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
              $("#religion").append("<option value='"+ReligionID+"'>"+ReligionName+"</option>");
          }
      }
  });
}
function fill_state() {
  $.ajax({
      url: '<?php echo base_url();?>employee/fill_state',
      type: 'post',
      dataType: 'json',
      success:function(response){
        var len = response.length;
        $("#state").empty();
        for( var i = 0; i<len; i++){
            var StateName = response[i]['StateName'];
            var StateID = response[i]['StateID'];
            $("#state").append("<option value='"+StateID+"'>"+StateName+"</option>");
        }
      }
  });
}
j8('.state').live('change',function(e){
  $(this).parent().find(".city").empty();
  $(this).parent().find(".city").append("<option value='0' selected>CITY</option>");
  $(this).parent().find(".districts").empty();
  $(this).parent().find(".districts").append("<option value='0' selected>SUB DISTRICT</option>");
  $(this).parent().find(".pos").empty();
  $(this).parent().find(".pos").append("<option value='0' selected>POSTAL CODE</option>");
  var par = $(this).parent().find(".province").first()
  $.ajax({
    url: "<?php echo base_url();?>employee/fill_province",
    type : 'GET',
    data : 'StateID=' + $(this).val(),
    dataType : 'json',
    success : function (response) {
      var len = response.length;
      par.empty();
      par.append("<option value='0' selected>PROVINCE</option>");
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
  $(this).parent().find(".districts").append("<option value='0' selected>SUB DISTRICT</option>");
  $(this).parent().find(".pos").empty();
  $(this).parent().find(".pos").append("<option value='0' selected>POSTAL CODE</option>");
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
              $("#employment").append("<option value='"+EmploymentID+"'>"+EmploymentName+"</option>");
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
              $("#officelocation").append("<option value='"+LocID+"'>"+LocCode+"</option>");
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
          $("#jobtitle").append("<option value=''></option>");
          for( var i = 0; i<len; i++){
              var LevelID = response[i]['LevelID'];
              var LevelCode = response[i]['LevelName'];
              $("#jobtitle").append("<option value='"+LevelID+"'>"+LevelCode+"</option>");
          }
      }
  });
}

function duplicatephone() { $(".phone:last").clone().insertAfter(".phone:last"); }
function duplicateemail() { $(".email:last").clone().insertAfter(".email:last"); }
function duplicateaddr() { 
  $(".address:last").clone().insertAfter(".address:last"); 
  // $(".address:last").find(".province").empty();
  // $(".address:last").find(".city").empty();
  // $(".address:last").find(".districts").empty();
  // $(".address:last").find(".pos").empty();
}
function cek_input_detail() {
  if (!$("#firstname").val() || !$("#bioid").val() || !$("#nip").val() ) {
    alert("input must be not blank");
    return false;
  }
}

function get(id) {
  xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>kesantrian/get_detail_santri"
    url=url+"?a="+id
    // alert(url);
    xmlHttp.onreadystatechange=stateChanged
    xmlHttp.open("GET",url,true)
    xmlHttp.send(null)
}
function stateChanged(){
    if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
        document.getElementById("detaildata").innerHTML=xmlHttp.responseText
    }
}
function GetXmlHttpObject(){
    var xmlHttp=null;
    try{
        xmlHttp=new XMLHttpRequest();
    }catch(e){
        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    return xmlHttp;
}
</script>