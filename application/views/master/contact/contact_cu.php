<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">
  #dtcontact_list tbody,  #dtcontact_list thead, #dtcontact_list tfoot {
    font-size: 12px !important;
  }
  #dtcontact_list tbody td { padding: 4px; }
  .form-group { display: block; margin-bottom: 5px !important; }
  .fullname .form-control, .address .form-control { margin-top: 3px; }
  .box-body h6 {display: inline; color: red; font-weight: bold;}
  .radio { display: inline-block !important; margin-left: 10px; }
  .select2 { width: 100% !important;}
  .formCP {
    border: 1px solid #dedede;
    padding: 2px;
  }
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
    .form-group { margin-bottom: 5px; }
  }
  .input-group-title {
    vertical-align: top;
    width: 150px;
    padding-left: 10px;
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

    <div class="modal fade" id="modal-contact">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">

            <div class="formCP">
              <div class="form-group">
                <label class="left">
                  Contact ID
                </label>
                <div class="input-group input-group-sm left2">
                  <input type="text" class="form-control input-sm contactpid" name="contactpid[]" readonly="">
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-primary btn-sm" onclick="if ($('.formCP').length != 1) { $(this).closest('.formCP').remove();}">-</button>
                  </span>
                </div>
                <span class="left2">
                </span>
              </div>
              <div class="form-group">
                <label class="left">Name</label>
                <span class="left2">
                  <input type="text" class="form-control input-sm contactpname" name="contactpname[]">
                </span>
              </div>
              <div class="form-group">
                <label class="left">Relation</label>
                <span class="left2">
                  <input type="text" class="form-control input-sm contactptype" name="contactptype[]">
                </span>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="box box-solid">
      <div class="box-body form_addcontact">
          <form name="form employee_add" id="form employee_add" action="<?php echo base_url();?>master/contact_cu_act" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <input type="hidden" name="contactid" value="<?php echo $content['personal']['ContactID'];?>">
            <div class="col-md-6">
              <div class="col-md-12">
                <div class="box box-solid">
                  <div class="box-header with-border">
                    <h3 class="box-title">Contact Information</h3>
                  </div>
                  <div class="box-body">
                    <div class="form-group">
                      <label>Status Contact</label>
                      <div class="radio">
                        <label>
                          <input type="radio" name="isCompany" value="1">
                          Company
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="isCompany" value="0" checked="">
                          Personal
                        </label>
                      </div>
                    </div>

                    <div class="form-group Prefix">
                      <label class="left">Prefix</label>
                      <span class="left2">
                        <select class="form-control input-sm" name="Prefix" id="Prefix">
                          <option value=""></option>
                          <option value="Mr">Mr</option>
                          <option value="Ms">Ms</option>
                          <option value="Mrs">Mrs</option>
                          <option value="PT">PT</option>
                          <option value="UD">UD</option>
                          <option value="CV">CV</option>
                          <option value="TB">TB</option>
                          <option value="Toko">Toko</option>
                        </select>
                      </span>
                    </div>
                    <!-- 
                    <div class="form-group ">
                      <label class="left">Full Name <h6>*</h6> </label>
                      <span class="left2">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control">
                            <span class="input-group-addon atributeSeparator"></span>
                            <select name="searchbygenerals[currency]" class="form-control">
                                <option value="1">HUF</option>
                                <option value="2">EUR</option>
                            </select>
                        </div>
                      </span>
                    </div>
                     -->
                    <div class="form-group fullname">
                      <label class="left">Full Name <h6>*</h6> </label>
                      <span class="left2">
                        <input type="text" class="form-control input-sm" placeholder="First Name" autocomplete="off" name="firstname" id="firstname" value="<?php echo $content['personal']['NameFirst'];?>" required>
                        <input type="text" class="form-control input-sm" placeholder="Middle Name" autocomplete="off" name="middlename" id="middlename" value="<?php echo $content['personal']['NameMid'];?>">
                        <input type="text" class="form-control input-sm" placeholder="Last Name" autocomplete="off" name="lastname" id="lastname" value="<?php echo $content['personal']['NameLast'];?>">
                      </span>
                    </div>
                    <div class="form-group companyname">
                      <label class="left">Company Name <h6>*</h6></label>
                      <span class="left2">
                        <input type="text" class="form-control input-sm" id="company" name="company" placeholder="Company Name" autocomplete="off" value="<?php echo $content['personal']['Company'];?>">
                      </span>
                    </div>
                    <div class="form-group">
                      <label class="left">Shop Name</label>
                      <span class="left2">
                        <input type="text" class="form-control input-sm" id="shop" name="shop" placeholder="Shop Name" autocomplete="off" value="<?php echo $content['personal']['ShopName'];?>">
                      </span>
                    </div>
                    <div class="form-group gender">
                      <label class="left">Gender</label>
                      <span class="left2">
                        <select class="form-control input-sm" name="gender" id="gender">
                          <option value="M">Male</option>
                          <option value="F">Female</option>   
                        </select>
                      </span>
                    </div>
                    <div class="form-group BirthDate">
                      <label class="left">Birth Date</label>
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control input-sm pull-right" id="BirthDate" name="BirthDate">
                      </div>
                    </div>
                    <div class="form-group religion">
                      <label class="left">Religion</label>
                      <span class="left2">
                        <select class="form-control input-sm" name="religion" id="religion"></select>
                      </span>
                    </div>
                    <div class="form-group ktp">
                      <label class="left">ID Card Number</label>
                      <span class="left2">
                        <input type="text" class="form-control input-sm" id="noktp" name="noktp" placeholder="ID Card Number" autocomplete="off" value="<?php echo $content['personal']['KTP'];?>">
                      </span>
                    </div>
                    <div class="form-group">
                      <label class="left">NPWP Number</label>
                      <span class="left2">
                        <input type="text" class="form-control input-sm" id="npwp" name="npwp" placeholder="NPWP Number" autocomplete="off" value="<?php echo $content['personal']['NPWP'];?>">
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12 cperson">
                <div class="box box-solid">

                  <div class="box-header with-border">
                    <h3 class="box-title">Contact Person</h3>
                  </div>
                  <div class="box-body">

                    <div class="form-group searchcp">
                      <label class="left">Search Contact</label>
                      <div class="input-group input-sm left2">
                        <select class="form-control input-sm contactp" name="contactp"></select>
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-primary btn-sm" title="ADD CONTACT PERSON" onclick="AddCP();">+</button>
                        </span>
                      </div>
                    </div>

                    <?php 
                      if (isset($content['cperson'])) {
                        foreach ($content['cperson'] as $row => $list) { 
                          // print_r($list);
                    ?>
                          <div class="formCP">
                            <div class="form-group">
                              <label class="left">
                                Contact ID
                              </label>
                              <div class="input-group input-group-sm left2">
                                <input type="text" class="form-control input-sm contactpid" name="contactpid[]" readonly="" value="<?php echo $list['ContactPersonID'];?>">
                                <span class="input-group-btn">
                                  <button type="button" class="btn btn-primary btn-sm" onclick="if ($('.formCP').length != 1) { $(this).closest('.formCP').remove();}">-</button>
                                </span>
                              </div>
                              <span class="left2">
                              </span>
                            </div>
                            <div class="form-group">
                              <label class="left">Name</label>
                              <span class="left2">
                                <input type="text" class="form-control input-sm contactpname" name="contactpname[]" value="<?php echo $list['Company2'];?>">
                              </span>
                            </div>
                            <div class="form-group">
                              <label class="left">Relation</label>
                              <span class="left2">
                                <input type="text" class="form-control input-sm contactptype" name="contactptype[]" value="<?php echo $list['ContactPersonType'];?>">
                              </span>
                            </div>
                          </div>
                    <?php } } ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Address</h3>
                </div>
                <div class="box-body">
                  <div class="form-group">
                    <label>Phone Number</label>
                    <?php
                    foreach ($content['phone'] as $row => $listphone) {?>
                      <div class="input-group input-group-sm phone">
                          <input type="text" class="form-control input-sm" name="phone[]" placeholder="Ex: 08xxxxx" value="<?php echo $listphone['DetailValue'];?>" required="">
                          <span class="input-group-btn input-group-title">
                            <input type="text" class="form-control input-sm toUpperCase" name="phoneT[]" placeholder="Head Office, FAX" value="<?php echo $listphone['DetailTitle'];?>">
                          </span>
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-primary add_field" onclick="duplicatephone();">+</button>
                            <button type="button" class="btn btn-primary add_field" onclick="if ($('.phone').length != 1) { $(this).closest('div').remove();}">-</button>
                          </span>
                      </div>
                    <?php } ?>
                  </div>
                  <div class="form-group">
                    <label>Email</label>
                    <?php
                    foreach ($content['email'] as $row => $listemail) {?>
                      <div class="input-group input-group-sm email">
                          <input type="text" class="form-control input-sm" name="email[]" placeholder="example@gmail.com" value='<?php echo $listemail['DetailValue'];?>'>
                          <span class="input-group-btn input-group-title">
                            <input type="text" class="form-control input-sm toUpperCase" name="emailT[]" placeholder="Head Office, Official" value="<?php echo $listemail['DetailTitle'];?>">
                          </span>
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-primary add_field" onclick="duplicateemail();">+</button>
                            <button type="button" class="btn btn-primary add_field" onclick="if ($('.email').length != 1) { $(this).closest('div').remove();}">-</button>
                          </span>
                      </div>
                    <?php } ?>
                  </div>
                  <div style="max-height: 1200px; overflow-y: auto;">
                    <?php foreach ($content['alamat'] as $row => $list) { ?>
                      <div class="form-group address">
                        <label style="margin-right: 20px;">Address</label> 
                        <button type="button" class="btn btn-primary btn-xs add_cperson" onclick="duplicateaddr();">+</button>
                        <button type="button" class="btn btn-primary btn-xs add_cperson" onclick="if ($('.address').length != 1) { $(this).closest('div').remove();}">-</button>
                        <div class="checkbox-inline">
                          <label><input type="checkbox" value="1" class="billing" name="billing[]" <?php echo ($list['isBilling']==1 ? 'checked' : '');?> >Billing address</label>
                        </div>
                        <input type="text" class="form-control input-sm" name="titlealamat[]" placeholder="Title Address" required="" value="<?php echo $list['DetailType'];?>">
                        <textarea class="form-control input-sm" rows="3" placeholder="Full Address" name="alamat[]"><?php echo $list['DetailValue'];?></textarea>
                        <select class="form-control input-sm state" name="state[]" required="">
                          <option value='<?php echo $list['StateID'];?>' selected><?php echo $list['StateName'];?></option>
                        </select>
                        <select class="form-control input-sm province" name="province[]" required="">
                          <option value='<?php echo $list['ProvinceID'];?>' selected><?php echo $list['ProvinceName'];?></option>
                        </select>
                        <select class="form-control input-sm city" name="city[]" required="">
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


<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/jquery-ui.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
j8  = jQuery.noConflict();
j8( document ).ready(function( $ ) {
  fill_state();
  fill_religion();

  $("input").keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
  // $('input[type=radio][name=isCompany]').trigger("change")

  $('#gender option[value=<?php echo $content['personal']['gender'];?>]').attr('selected','selected');
  $('input[type=radio][name=isCompany]').filter('[value=<?php echo $content['personal']['isCompany'];?>]').prop('checked', true).trigger("change");
  if('<?php echo $content['personal']['isCompany'];?>' === 1) { //jika contact company
    $('.cperson').show()
  }
  $('#Prefix option[value=<?php echo $content['personal']['Prefix'];?>]').attr('selected','selected');
  $("#BirthDate").val("<?php echo $content['personal']['BirthDate'];?>")
  $("#BirthDate").datepicker({ autoclose: true, format: 'yyyy-mm-dd'})


  j8('.contactp').select2({
    placeholder: 'Minimum 4 character, Full Name',
    minimumInputLength: 4,
    ajax: {
      url: '<?php echo base_url();?>general/search_contact',
      dataType: 'json',data: function (term) {
        return {
            q: term, // search term
            contact: 'isPersonal'
        };
      },
      delay: 1000,
      processResults: function (data) {
        return {
          results: data
        };
      },
      cache: true
    }
  });
});
j8('.contactp').on("select2:select", function(e) { 
  contactpval = j8(this).val()
  contactptext = j8(".contactp option:selected").text()
  result = j8(".contactp option:selected").text().split(' - ');
  j8('.contactpid:first').val(contactpval)
  j8('.contactpname:first').val(result[1])
});
function AddCP() {
  $(".formCP:first").clone().insertAfter(".searchcp"); 
}

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
        }
      }
  });
}
j8('.state').live('change',function(e){
  $(this).parent().find(".city").empty();
  $(this).parent().find(".city").append("<option value='' selected disabled>CITY</option>");
  $(this).parent().find(".districts").empty();
  $(this).parent().find(".districts").append("<option value='' selected disabled>SUB-DISTRICT</option>");
  $(this).parent().find(".pos").empty();
  $(this).parent().find(".pos").append("<option value='' selected disabled>POSTAL CODE</option>");
  var par = $(this).parent().find(".province").first()
  $.ajax({
    url: "<?php echo base_url();?>employee/fill_province",
    type : 'GET',
    data : 'StateID=' + $(this).val(),
    dataType : 'json',
    success : function (response) {
    console.log(response)
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
  $(this).parent().find(".districts").append("<option value='' selected disabled>SUB-DISTRICT</option>");
  $(this).parent().find(".pos").empty();
  $(this).parent().find(".pos").append("<option value='' selected disabled>POSTAL CODE</option>");
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
      par2.append("<option value=''></option>");
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
      // console.log(len);
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

j8('input.billing').live('change', function() {
    j8('input.billing').not(this).prop('checked', false);  
});
function duplicatephone() { $(".phone:last").clone().insertAfter(".phone:last"); }
function duplicateemail() { $(".email:last").clone().insertAfter(".email:last"); }
function duplicateaddr() { $(".address:first").clone().insertAfter(".address:last"); }
function cek_input_detail() {
  isCompany = $('input[type=radio][name=isCompany]').value
  // console.log(isCompany)
  if (isCompany ===0 && $.trim($("#firstname").val()) === "") {
    alert("input tidak boleh kosong");
    return false;
  }
  if (isCompany ===1 && $.trim($("#company").val()) === "") {
    alert("input tidak boleh kosong");
    return false;
  }

  billing = $('.billing:checkbox:checked').length
  if (billing == 0 || billing > 1) {
    alert("Billing address harus ada satu alamat!")
    return false;
  }
  $('.billing').each( function () {
      var checkbox_this = $(this);
      if( checkbox_this.is(":checked") == true ) {
          checkbox_this.attr('value','1');
      } else {
          checkbox_this.prop('checked',true);
          checkbox_this.attr('value','0');
      }
  })
}

// all about contact person : company
j8('input[type=radio][name=isCompany]').change(function() {
  if (this.value == '1') {
    $('.cperson').show()

    $('.fullname').css("display", "none")
    $('#firstname').attr("required", false)
    $('.companyname').css("display", "block")
    $('#company').attr("required", true)
    $('.gender').css("display", "none")
    $('.religion').css("display", "none")
    $('.ktp').css("display", "none")
    $('.BirthDate').css("display", "none")
  }
  else if (this.value == '0') {
    $('.cperson').hide()
    $('.cperson').find(".formCP").remove()

    $('.fullname').css("display", "block")
    $('#firstname').attr("required", true)
    $('.companyname').css("display", "none")
    $('#company').attr("required", false)
    $('.gender').css("display", "block")
    $('.religion').css("display", "block")
    $('.ktp').css("display", "block")
    $('.BirthDate').css("display", "block")
  }
});
</script>