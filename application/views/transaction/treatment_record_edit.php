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
  .contentBefore, .contentAfter { margin-bottom: 5px; }
  .contentBefore img, .contentAfter img { margin-bottom: -22px; }
  .contentImage {
    width: 105px;
    height: 105px;
  }
</style>
 
<?php
$main = $content['main'][0];
$before = array();
$after = array();

if (isset($content['before'])) {
  $before = $content['before'];
}
if (isset($content['after'])) {
  $after = $content['after'];
}
?>

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
  <form name="form" id="formTreatment" action="<?php echo base_url();?>transaction/treatment_record_edit_act" method="post" enctype="multipart/form-data" autocomplete="off">
  <div class="row">
    <div class="col-md-12"> 
      <div class="card">
        <div class="card-body"> 
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label class="left">Treatment Record ID</label>
                <span class="left2">
                  <input type="text" name="TreatmentRecordID" id="TreatmentRecordID" class="form-control form-control-sm" readonly="" value="<?php echo $main['TreatmentRecordID'];?>">
                </span>
              </div>
              <div class="form-group">
                <label class="left">Treatment Name</label>
                <span class="left2">
                  <input type="hidden" name="TreatmentID" id="TreatmentID" class="form-control form-control-sm" readonly="" value="<?php echo $main['TreatmentID'];?>">
                  <input type="text" name="TreatmentName" id="TreatmentName" class="form-control form-control-sm" readonly="" value="<?php echo $main['TreatmentName'];?>">
                </span> 
              </div>
              <div class="form-group">
                <label class="left">Customer Name</label>
                <span class="left2">
                  <input type="hidden" name="CustomerID" id="CustomerID" class="form-control form-control-sm" readonly="" value="<?php echo $main['CustomerID'];?>">
                  <input type="text" name="CustomerName" id="CustomerName" class="form-control form-control-sm" readonly="" value="<?php echo $main['CustomerName'];?>">
                </span> 
              </div>
            </div> 
            <div class="col-sm-6"> 
              <div class="form-group">
                <label class="left">Note</label>
                <span class="left2">
                  <textarea name="TreatmentRecordNote" id="TreatmentRecordNote" class="form-control" rows="4" placeholder="Enter ..."><?php echo $main['TreatmentRecordNote'];?></textarea>
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
            <?php $no = 0; foreach ($before as $key => $value) { $no++; ?>
              <div class='contentImage contentBefore' id='contentBefore_<?php echo $no;?>'>
                <img src='<?php echo base_url();?>upload/treatment/<?php echo $main['TreatmentRecordID'].'/before/'.$value;?>' width='100' height='100'>
                <span class="btnGroup">
                  <button type='button' class='btn btn-danger btn-xs deleteBefore' id='deleteBefore_<?php echo $no;?>'>
                    <i class='fa fa-trash nav-icon'></i>
                  </button>
                  <button type='button' class='btn btn-info btn-xs compareBefore' id='compareBefore_<?php echo $no;?>'>
                    <i class='fa fa-check nav-icon'></i>
                  </button>
                  <input type='hidden' class='validFileBefore' name='validFileBefore[]' value='<?php echo base_url();?>upload/treatment/<?php echo $main['TreatmentRecordID'].'/before/'.$value;?>'>
                </span>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>   
    </div> 
    <div class="col-md-6">
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">After</h3>
        </div>
        <div class="card-body">
          <div class="input-group">
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="customFileAfter" name="file[]" multiple="multiple" accept="image/*" placeholder="Choose and Upload file" />
              <label class="custom-file-label" for="customFileAfter">Choose and Upload file</label>
            </div>
            <span class="input-group-append">
              <button type="button" class="btn btn-info btn-flat UploadcustomFileAfter">Upload</button>
            </span>
          </div>
          <div class="row containerAfter" style="margin-top: 5px">
            <?php $no = 0; foreach ($after as $key => $value) { $no++; ?>
              <div class='contentImage contentAfter' id='contentAfter_<?php echo $no;?>'>
                <img src='<?php echo base_url();?>upload/treatment/<?php echo $main['TreatmentRecordID'].'/after/'.$value;?>' width='100' height='100'>
                <span class="btnGroup">
                  <button type='button' class='btn btn-danger btn-xs deleteAfter' id='deleteAfter_<?php echo $no;?>'>
                    <i class='fa fa-trash nav-icon'></i>
                  </button>
                  <button type='button' class='btn btn-info btn-xs compareAfter' id='compareAfter_<?php echo $no;?>'>
                    <i class='fa fa-check nav-icon'></i>
                  </button>
                  <input type='hidden' class='validFileAfter' name='validFileAfter[]' value='<?php echo base_url();?>upload/treatment/<?php echo $main['TreatmentRecordID'].'/after/'.$value;?>'>
                </span>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>   
    </div>
    <div class="col-md-12">
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">Compare</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label class="left alignRight">Compare Before</label>
                <span class="left2 containerCompareBefore">
                </span>
              </div>
            </div>  
            <div class="col-sm-4">
              <div class="form-group">
                <label class="left alignRight">Compare After</label>
                <span class="left2 containerCompareAfter">
                </span>
              </div>
            </div>  
            <div class="col-sm-4">
              <div class="form-group">
                <center><button type="button" class="btn btn-success btn-compare">Compare</button></center>
              </div>
            </div> 
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


// ------------------------------------------------------------------
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
                    $('.containerBefore').append("<div class='contentImage contentBefore' id='contentBefore_"+count+"'><img src='<?php echo base_url();?>"+response[i]+"' width='100' height='100'><span class='btnGroup'><button type='button' class='btn btn-danger btn-xs deleteBefore' id='deleteBefore_"+count+"'><i class='fa fa-trash nav-icon'></i></button><button type='button' class='btn btn-info btn-xs compareBefore' id='compareBefore_"+count+"'><i class='fa fa-check nav-icon'></i></button><input type='hidden' class='validFileBefore' name='validFileBefore[]' value='"+response[i]+"'></span></div>");
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
// compare file
$('.containerBefore').on('click','.contentBefore .compareBefore',function(){
    $('.containerCompareBefore').empty()
    $(this).closest('.contentBefore').clone().appendTo('.containerCompareBefore')
    $('.containerCompareBefore').find('.btnGroup').remove()
});
// ------------------------------------------------------------------
$('#customFileAfter').on('change',function(){
  var fileName = $(this)[0].files.length;
  $(this).next('.custom-file-label').html(fileName+' file(s)');
})
// Upload
$(".UploadcustomFileAfter").click(function(){
    var fd = new FormData();
    var files = $('#customFileAfter')[0].files;
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
                    var count = $('.containerAfter .contentAfter').length;
                    count = Number(count) + 1;
                    // Show image preview with Delete button
                    $('.containerAfter').append("<div class='contentImage contentAfter' id='contentAfter_"+count+"'><img src='<?php echo base_url();?>"+response[i]+"' width='100' height='100'><span class='btnGroup'><button type='button' class='btn btn-danger btn-xs deleteAfter' id='deleteAfter_"+count+"'><i class='fa fa-trash nav-icon'></i></button><button type='button' class='btn btn-info btn-xs compareAfter' id='compareAfter_"+count+"'><i class='fa fa-check nav-icon'></i></button><input type='hidden' class='validFileAfter' name='validFileAfter[]' value='"+response[i]+"'></span></div>");
                }
            }else{
                alert('file not uploaded');
            }
        }
    });
});
// Remove file
$('.containerAfter').on('click','.contentAfter .deleteAfter',function(){
    var id = this.id;
    var split_id = id.split('_');
    var num = split_id[1];

     // Get image source
    var imgElement_src = $( '#contentAfter_'+num+' img' ).attr("src");
     
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
                  $('#contentAfter_'+num).remove();
              }

          }
        });
    }
});
// compare file
$('.containerAfter').on('click','.contentAfter .compareAfter',function(){
    $('.containerCompareAfter').empty()
    $(this).closest('.contentAfter').clone().appendTo('.containerCompareAfter')
    $('.containerCompareAfter').find('.btnGroup').remove()
});
// ------------------------------------------------------------------
// compare
var arrImage = [];
$(".btn-compare").click(function(){
    arrImage.fileBefore = $('.containerCompareBefore').find('img').attr('src')
    arrImage.fileAfter = $('.containerCompareAfter').find('img').attr('src')
    
    window.open('<?php echo base_url();?>transaction/compare_image', 'popUpWindow','height='+screen.availHeight * 0.9+', width='+screen.availWidth * 0.9+', left=0, top=0, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');

    // AJAX request
    // $.ajax({
    //     url: '<?php echo base_url();?>transaction/compare_image',
    //     type: 'post',
    //     data: fd,
    //     contentType: false,
    //     processData: false,
    //     dataType : 'json',
    //     success: function(response){ 

    //     }
    // });
});

$("#formTreatment").submit(function(e) { 
  if ($('.contentBefore').length < 1) {
      e.preventDefault();
      alert("No Picture Uploaded.")
      return false
  }
});
</script>