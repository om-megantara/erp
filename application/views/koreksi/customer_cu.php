<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<style type="text/css">
  #dtcontact_list tbody,
  #dtcontact_list thead,
  #dtcontact_list tfoot{
    font-size: 12px !important;
  }
  #dtcontact_list tbody td { padding: 4px; }
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
  .phone, .email, .sales, .price, .cperson input, .cperson textarea  {margin-top: 2px;}
  .add_addr, .add_cperson {font-size: 18px; font-weight: bold; color: white; background-color: #5bc0de; padding: 0px 8px;}
  .fullname .form-control, .address .form-control { margin-top: 3px; }
  .box-body h6 {display: inline; color: red; font-weight: bold;}
  .radio { display: inline-block !important; margin-left: 10px; }
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
            <div class="form-group cpperson-detail">
              <label style="margin-right: 20px;">Contact Person</label>
              <a href="#" onclick="duplicatecperson();" class="add_cperson">+</a>
              <a href="#" onclick="if ($('.cpperson-detail').length != 2) { $(this).closest('div').remove();}" class="add_cperson">-</a>
              <div class="form-group">
                <input type="text" class="form-control input-sm cpname" name="cpname[]" placeholder="Nama Contact Person" value="">
                <input type="text" class="form-control input-sm cpjob" name="cpjob[]" placeholder="Posisi Contact Person" value="">
                <input type="text" class="form-control input-sm cpphone" name="cpphone[]" placeholder="Phone Contact Person" value="">
                <input type="text" class="form-control input-sm cpemail" name="cpemail[]" placeholder="Email Contact Person" value="">
                <textarea class="form-control input-sm cpaddress" rows="3" placeholder="Address Contact Person" name="cpaddress[]"></textarea>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="box box-solid">
      <div class="box-header with-border">
      </div>
      <div class="box-body form_addcontact">
          <form name="form employee_add" id="form employee_add" action="<?php echo base_url();?>koreksi/customer_cu_act" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <input type="hidden" name="contactid" value="<?php echo $content['personal']['ContactID'];?>">
            <input type="hidden" name="customerid" value="<?php echo $content['personal']['CustomerID'];?>">
            <div class="col-md-6">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Customer Information</h3>
                </div>
                <div class="box-body">
                  <div class="form-group fullname">
                    <label>Full Name <h6>*</h6> </label>
                    <input type="text" class="form-control input-sm" placeholder="First Name" autocomplete="off" name="firstname" id="firstname" value="<?php echo $content['personal']['NameFirst'];?>" required>
                    <input type="text" class="form-control input-sm" placeholder="Middle Name" autocomplete="off" name="middlename" id="middlename" value="<?php echo $content['personal']['NameMid'];?>">
                    <input type="text" class="form-control input-sm" placeholder="Last Name" autocomplete="off" name="lastname" id="lastname" value="<?php echo $content['personal']['NameLast'];?>">
                  </div>
                  <div class="form-group">
                    <label class="left">Company Name</label>
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
                    <label class="left">Religion</label>
                    <span class="left2">
                      <select class="form-control input-sm" name="religion" id="religion"></select>
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">No KTP</label>
                    <span class="left2">
                      <input type="text" class="form-control input-sm" id="noktp" name="noktp" placeholder="No ID KTP" autocomplete="off" value="<?php echo $content['personal']['KTP'];?>">
                    </span>
                  </div>
                  <div class="form-group">
                    <label class="left">No NPWP</label>
                    <span class="left2">
                      <input type="text" class="form-control input-sm" id="npwp" name="npwp" placeholder="No NPWP" autocomplete="off" value="<?php echo $content['personal']['NPWP'];?>">
                    </span>
                  </div>
                  <div class="form-group">
                    <label>Credit Limit <h6>*)any changes require approval</h6></label>
                    <input type="hidden" id="creditlimitold" name="creditlimitold" placeholder="Nominal Credit Limit default:5000000" autocomplete="off" value="<?php echo $content['personal']['creditlimit'];?>">
                    <input type="number" class="form-control input-sm" id="creditlimit" name="creditlimit" placeholder="Nominal Credit Limit default:5000000" autocomplete="off" value="<?php echo $content['personal']['creditlimit'];?>">
                  </div>
                  <div class="form-group">
                    <label>Payment Term Allowed <h6>*)any changes require approval</h6></label>
                    <input type="hidden" class="form-control input-sm" id="paymenttermold" name="paymenttermold" placeholder="Payment Term Allowed in days" autocomplete="off" value="<?php echo $content['personal']['paymentterm'];?>">
                    <input type="number" class="form-control input-sm" id="paymentterm" name="paymentterm" placeholder="Payment Term Allowed in days" autocomplete="off" value="<?php echo $content['personal']['paymentterm'];?>">
                  </div>
                  <div class="form-group">
                    <label>Customer Category <h6>*)any changes require approval</h6></label>
                    <select class="form-control input-sm" name="customercategory" id="customercategory"></select>
                  </div>
                  <div class="form-group">
                    <label>Sales Executive</label>
                    <?php
                    foreach ($content['sales'] as $row => $listsales) {?>
                      <div class="input-group input-group-sm sales">
                        <select class="form-control input-sm saleschild" name="sales[]" required="">
                          <option value='<?php echo $listsales['salesID'];?>' selected><?php echo $listsales['salesName'];?></option>
                        </select>
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-primary  add_field" onclick="duplicatesales();">+</button>
                          <button type="button" class="btn btn-primary  add_field" onclick="if ($('.sales').length != 1) { $(this).closest('div').remove();}">-</button>
                        </span>
                      </div>
                    <?php } ?>
                  </div>
                  <div class="form-group">
                    <label>Price List Category</label>
                    <?php
                    foreach ($content['price'] as $row => $listprice) {?>
                      <div class="input-group input-group-sm price">
                        <select class="form-control input-sm pricechild" name="price[]" onchange="fill_price_text(this);">
                          <option value='<?php echo $listprice['PricecategoryID'];?>' selected><?php echo $listprice['PricecategoryName'];?></option>
                        </select>
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-primary  add_field" onclick="duplicateprice();">+</button>
                          <button type="button" class="btn btn-primary  add_field" onclick="if ($('.price').length != 1) { $(this).closest('div').remove();}">-</button>
                        </span>
                        <input type="hidden" class="form-control input-sm pricechild_text" name="price_text[]" value='<?php echo $listprice['PricecategoryName'];?>'>
                      </div>
                    <?php } ?>
                  </div>
                  <div class="form-group">
                    <label class="left">Status</label>
                    <span class="left2">
                      <select class="form-control input-sm" name="status" id="status">
                        <option value="1">Aktif</option>   
                        <option value="0">NonAktif</option>   
                      </select>
                    </span>
                  </div>
                  <div class="form-group">
                    <label>Status Personal</label>
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

                  <div class="col-md-12 cperson">
                    <div class="box box-solid">
                      <div class="box-body">
                        <?php if (isset($content['cperson'])) { 
                        foreach ($content['cperson'] as $row => $listcperson) { ?>
                          <div class="form-group cpperson-detail">
                            <label style="margin-right: 20px;">Contact Person</label>
                            <button type="button" class="btn btn-primary btn-xs add_cperson" onclick="duplicatecperson();">+</button>
                            <button type="button" class="btn btn-primary btn-xs add_cperson" onclick="if ($('.cpperson-detail').length != 2) { $(this).closest('div').remove();}">-</button>
                            <div class="form-group">
                              <input type="text" class="form-control input-sm cpname" name="cpname[]" placeholder="Nama Contact Person" value="<?php echo $listcperson['ContactPersonName'];?>">
                              <input type="text" class="form-control input-sm cpjob" name="cpjob[]" placeholder="Posisi Contact Person" value="<?php echo $listcperson['ContactPersonJob'];?>">
                              <input type="text" class="form-control input-sm cpphone" name="cpphone[]" placeholder="Phone Contact Person" value="<?php echo $listcperson['ContactPersonPhone'];?>">
                              <input type="text" class="form-control input-sm cpemail" name="cpemail[]" placeholder="Email Contact Person" value="<?php echo $listcperson['ContactPersonEmail'];?>">
                              <textarea class="form-control input-sm cpaddress" rows="3" placeholder="Address Contact Person" name="cpaddress[]"><?php echo $listcperson['ContactPersonAddress'];?></textarea>
                            </div>
                          </div>
                        <?php } } ?>
                      </div>
                    </div>
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
                    <label>Phone</label>
                    <?php
                    foreach ($content['phone'] as $row => $listphone) {?>
                      <div class="input-group input-group-sm phone">
                        <input type="text" class="form-control input-sm" name="phone[]" value='<?php echo $listphone['DetailValue'];?>'>
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-primary  add_field" onclick="duplicatephone();">+</button>
                            <button type="button" class="btn btn-primary  add_field" onclick="if ($('.phone').length != 1) { $(this).closest('div').remove();}">-</button>
                          </span>
                      </div>
                    <?php } ?>
                  </div>
                  <div class="form-group">
                    <label>Email</label>
                    <?php
                    foreach ($content['email'] as $row => $listemail) {?>
                      <div class="input-group input-group-sm email">
                        <input type="text" class="form-control input-sm" name="email[]" value='<?php echo $listemail['DetailValue'];?>'>
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-primary  add_field" onclick="duplicateemail();">+</button>
                            <button type="button" class="btn btn-primary  add_field" onclick="if ($('.email').length != 1) { $(this).closest('div').remove();}">-</button>
                          </span>
                      </div>
                    <?php } ?>
                  </div>
                  <div style="max-height: 1200px; overflow-y: auto;">
                    <?php foreach ($content['alamat'] as $row => $list) { ?>
                      <div class="form-group address">
                        <label style="margin-right: 20px;">Alamat</label> 
                        <button type="button" class="btn btn-primary btn-xs add_cperson" onclick="duplicateaddr();">+</button>
                        <button type="button" class="btn btn-primary btn-xs add_cperson" onclick="if ($('.address').length != 1) { $(this).closest('div').remove();}">-</button>
                        <div class="checkbox-inline">
                          <label><input type="checkbox" value="1" class="billing" name="billing[]" <?php echo ($list['isBilling']==1 ? 'checked' : '');?> >Billing address</label>
                        </div>
                        <input type="text" class="form-control input-sm" name="titlealamat[]" placeholder="Title Alamat" value="<?php echo $list['DetailType'];?>">
                        <textarea class="form-control input-sm" rows="3" placeholder="Alamat" name="alamat[]"><?php echo $list['DetailValue'];?></textarea>
                        <select class="form-control input-sm state" name="state[]">
                          <option value='<?php echo $list['StateID'];?>' selected><?php echo $list['StateName'];?></option>
                        </select>
                        <select class="form-control input-sm province" name="province[]">
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
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script>
j8  = jQuery.noConflict();
j8( document ).ready(function( $ ) {
   
  console.log(<?php echo $content['personal']['religion'];?>);
  fill_religion();
  fill_customercategory();
  fill_sales();
  fill_price();
  fill_state();
  $("input").keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
  $('#gender option[value=<?php echo $content['personal']['gender'];?>]').attr('selected','selected');
  $('#status option[value=<?php echo $content['personal']['status'];?>]').attr('selected','selected');

  $('input[type=radio][name=isCompany]').filter('[value=<?php echo $content['personal']['isCompany'];?>]').prop('checked', true);
  if ('<?php echo $content['personal']['isCompany'];?>' === 1) { //jika contact company
    $('.cperson').show()
  }

  $('input.billing').live('change', function() {
      $('input.billing').not(this).prop('checked', false);  
  });
});
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
function fill_customercategory() {
  $.ajax({
      url: '<?php echo base_url();?>master/fill_customercategory',
      type: 'post',
      dataType: 'json',
      success:function(response){
          var len = response.length;
          $("#customercategory").empty();
          for( var i = 0; i<len; i++){
              var CustomercategoryName = response[i]['CustomercategoryName'];
              var CustomercategoryID = response[i]['CustomercategoryID'];
              if (CustomercategoryID == <?php echo $content['personal']['CustomercategoryID'];?>) {
                $("#customercategory").append("<option value='"+CustomercategoryID+"' selected='selected'>"+CustomercategoryName+"</option>");
              } else {
                $("#customercategory").append("<option value='"+CustomercategoryID+"'>"+CustomercategoryName+"</option>");
              }
          }
      }
  });
}
function fill_sales() {
  $.ajax({
      url: '<?php echo base_url();?>master/fill_sales',
      type: 'post',
      dataType: 'json',
      success:function(response){
        var len = response.length;
        for( var i = 0; i<len; i++){
            var SalesName = response[i]['SalesName'];
            var SalesID = response[i]['SalesID'];
            $(".saleschild").append("<option value='"+SalesID+"'>"+SalesName+"</option>");
        }
      }
  });
}
function fill_price() {
  $.ajax({
      url: '<?php echo base_url();?>master/fill_price',
      type: 'post',
      dataType: 'json',
      success:function(response){
        var len = response.length;
        $(".pricechild").append("<option value=''></option>");
        for( var i = 0; i<len; i++){
            var PricecategoryName = response[i]['PricecategoryName'];
            var PricecategoryID = response[i]['PricecategoryID'];
            $(".pricechild").append("<option value='"+PricecategoryID+"'>"+PricecategoryName+"</option>");
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
  $(this).parent().find(".city").append("<option value='0' selected>KOTA</option>");
  $(this).parent().find(".districts").empty();
  $(this).parent().find(".districts").append("<option value='0' selected>KECAMATAN</option>");
  $(this).parent().find(".pos").empty();
  $(this).parent().find(".pos").append("<option value='0' selected>KODE POS</option>");
  var par = $(this).parent().find(".province").first()
  $.ajax({
    url: "<?php echo base_url();?>employee/fill_province",
    type : 'GET',
    data : 'StateID=' + $(this).val(),
    dataType : 'json',
    success : function (response) {
      var len = response.length;
      par.empty();
      par.append("<option value='0' selected>PROVINSI</option>");
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
  $(this).parent().find(".districts").append("<option value='0' selected>KECAMATAN</option>");
  $(this).parent().find(".pos").empty();
  $(this).parent().find(".pos").append("<option value='0' selected>KODE POS</option>");
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
function duplicatephone() { $(".phone:last").clone().insertAfter(".phone:last"); }
function duplicateemail() { $(".email:last").clone().insertAfter(".email:last"); }
function duplicatesales() { $(".sales:last").clone().insertAfter(".sales:last"); }
function duplicateprice() { $(".price:last").clone().insertAfter(".price:last"); }
function fill_price_text() {
  // var par = ddl.options[ddl.selectedIndex].text;
}
j8(document).on('change', '.pricechild', function(e) {
  $(this).parent().find(".pricechild_text").val(this.options[e.target.selectedIndex].text);
});
function duplicateaddr() { 
  $(".address:first").clone().insertAfter(".address:last");
}
function cek_input_detail() {
  if ($.trim($("#firstname").val()) === "") {
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
    $(".cpperson-detail:first").clone().appendTo(".cperson .box-body");
  }
  else if (this.value == '0') {
    $('.cperson').hide()
    $(".cperson .box-body").empty()
  }
});
function duplicatecperson() { 
  $(".cpperson-detail:first").clone().insertAfter(".cperson .cpperson-detail:last"); 
}
</script>