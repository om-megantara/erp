<link rel="stylesheet" href="<?php echo base_url();?>assets/adminlte/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<style type="text/css">
  @media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 150px;
      padding: 5px;
    }
    .form-group span.left2 {
      display: block;
      overflow: hidden;
    }
    .form-group { margin-bottom: 12px; }
  }
  .deleteBefore { margin-top: -20px; }
</style>
 
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><?php echo $PageTitle; ?></h1>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <form name="form" id="formTreatment" action="<?php echo base_url();?>transaction/treatment_record_add_act" method="post" enctype="multipart/form-data" autocomplete="off">
  <div class="row">
    <div class="col-md-12"> 
      <div class="card">
        <div class="card-body"> 
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label class="left">Treatment Record ID</label>
                <span class="left2">
                  <input type="text" name="TreatmentRecordID" id="TreatmentRecordID" class="form-control form-control-sm" readonly="">
                </span>
              </div>
              <div class="form-group">
                <label class="left">Treatment Name</label>
                <span class="left2">
                  <select class="form-control select2 TreatmentMain" name="TreatmentMain" style="width: 100%;" required=""></select>
                </span> 
              </div>
              <div class="form-group">
                <label class="left">Customer Name</label>
                <span class="left2">
                  <select class="form-control select2 CustomerMain" name="CustomerMain" style="width: 100%;" required=""></select>
                </span> 
              </div>
            </div> 
            <div class="col-sm-6"> 
              <div class="form-group">
                <label class="left">Note</label>
                <span class="left2">
                  <textarea name="TreatmentRecordNote" id="TreatmentRecordNote" class="form-control" rows="4" placeholder="Enter ..."></textarea>
                </span>
              </div> 
            </div>
            <div class="col-sm-12">
               <center><button type="submit" class="btn btn-success btn-submit">Submit</button></center>
            </div>
          </div>
        </div>        
      </div>   
    </div> 
    <div class="col-md-6">
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">Before</h3>
        </div>
        <div class="card-body">
          <div class="input-group">
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="customFileBefore" name="file[]" multiple="multiple" accept="image/*" placeholder="Choose and Upload file" />
              <label class="custom-file-label" for="customFileBefore">Choose and Upload file</label>
            </div>
            <span class="input-group-append">
              <button type="button" class="btn btn-info btn-flat UploadcustomFileBefore">Upload</button>
            </span>
          </div>
          <div class="row containerBefore" style="margin-top: 5px">
          </div>
        </div>
      </div>   
    </div>
  </div>  
  </form>
</section>

<script src="<?php echo base_url();?>assets/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/adminlte/plugins/select2/js/select2.full.min.js"></script>
<script type="text/javascript">
jQuery( document ).ready(function( $ ) {
  $(function () {

  });
});
  
$('.TreatmentMain').select2({
  width: 'resolve',
  placeholder: 'Input minimum 2 Characters',
  dropdownAutoWidth: true,
  allowClear: true,
  minimumInputLength: 2,
  ajax: {
    url: '<?php echo base_url();?>master_data/search_treatment',
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
$('.CustomerMain').select2({
  width: 'resolve',
  placeholder: 'Input minimum 2 Characters',
  dropdownAutoWidth: true,
  allowClear: true,
  minimumInputLength: 2,
  ajax: {
    url: '<?php echo base_url();?>master_data/search_customer',
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


$('#customFileBefore').on('change',function(){
  var fileName = $(this)[0].files.length;
  $(this).next('.custom-file-label').html(fileName+' file(s)');
})
// Upload
$(".UploadcustomFileBefore").click(function(){
    var fd = new FormData();
    var files = $('#customFileBefore')[0].files;
    for (var i = files.length - 1; i >= 0; i--) {
        fd.append('file[]',files[i]);
    }
    fd.append('request',1);

    // AJAX request
    $.ajax({
        url: '<?php echo base_url();?>transaction/UploadDeleteFile',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        dataType : 'json',
        success: function(response){
            if(response.length>0){
                for (var i = 0; i < response.length; i++) {
                    var count = $('.containerBefore .contentBefore').length;
                    count = Number(count) + 1;
                    // Show image preview with Delete button
                    $('.containerBefore').append("<div class='col-sm-2 contentBefore' id='contentBefore_"+count+"'><img src='<?php echo base_url();?>"+response[i]+"' width='100' height='100'><button type='button' class='btn btn-danger btn-xs deleteBefore' id='deleteBefore_"+count+"'><i class='fa fa-trash nav-icon'></i></button><input type='hidden' class='validFileBefore' name='validFileBefore[]' value='"+response[i]+"'></div>");
                }
            }else{
                alert('file not uploaded');
            }
        }
    });
});
// Remove file
$('.containerBefore').on('click','.contentBefore .deleteBefore',function(){
    var id = this.id;
    var split_id = id.split('_');
    var num = split_id[1];

     // Get image source
    var imgElement_src = $( '#contentBefore_'+num+' img' ).attr("src");
     
    var deleteFile = confirm("Do you really want to Delete?");
    if (deleteFile == true) {
        // AJAX request
        $.ajax({
          url: '<?php echo base_url();?>transaction/UploadDeleteFile',
          type: 'post',
          data: {path: imgElement_src,request: 2},
          success: function(response){
              // Remove <div >
              if(response == 1){
                  $('#contentBefore_'+num).remove();
              }

          }
        });
    }
});

$("#formTreatment").submit(function(e) { 
  if ($('.contentBefore').length < 1) {
      e.preventDefault();
      alert("No Picture Uploaded.")
      return false
  }
});
</script>