<link rel="stylesheet" href="<?php echo base_url();?>assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<style type="text/css">
  @media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 100px;
      padding: 5px;
    }
    .form-group span.left2 {
      display: block;
      overflow: hidden;
    }
    .form-group { margin-bottom: 10px; }
  }
</style>

<div class="modal fade" id="modal-treatment" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form role="form" action="<?php echo base_url();?>master_data/treatment_cu" method="post">
      <div class="modal-header">
        <h4 class="modal-title">Add / Edit Treatment</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row"> 
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">Treatment ID</label>
              <span class="left2">
                <input type="text" name="TreatmentID" id="TreatmentID" class="form-control form-control-sm" readonly="">
              </span>
            </div>
            <div class="form-group">
              <label class="left">Name</label>
              <span class="left2">
                <input type="text" name="TreatmentName" id="TreatmentName" class="form-control form-control-sm">
              </span>
            </div>
            <div class="form-group">
              <label class="left">Price</label>
              <span class="left2">
                <input type="text" name="TreatmentPrice" id="TreatmentPrice" class="form-control form-control-sm mask-number">
              </span>
            </div> 
          </div>
          <div class="col-md-6"> 
            <div class="form-group">
              <label class="left">Note</label>
              <span class="left2">
              	<textarea name="TreatmentNote" id="TreatmentNote" class="form-control" rows="4" placeholder="Enter ..."></textarea>
              </span>
            </div> 
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>    

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><?php echo $PageTitle; ?></h1>
      </div> 
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <button class="btn btn-xs btn-info" data-toggle="modal" data-target="#modal-treatment" onclick="clear_form();">Add Treatment</button>
          </li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="row">
    <div class="col-12"> 
      <div class="card">
        <div class="card-body">
          <table id="dt_list" class="table table-bordered">
            <thead>
	            <tr>
	              <th>Treatment ID</th>
	              <th>Name</th>
	              <th>Price</th>
	              <th>Note</th>
	              <th></th>
	            </tr>
            </thead>
            <tbody>
              <?php
                if (isset($content)) {
                  foreach ($content as $row => $list) { ?>
                    <tr>
                      <td><?php echo $list['TreatmentID'];?></td>
                      <td><?php echo $list['TreatmentName'];?></td>
                      <td class="alignRight"><?php echo number_format($list['TreatmentPrice'],2);?></td>
                      <td><?php echo $list['TreatmentNote'];?></td>
                      <td>
                        <button type="button" class="btn btn-success btn-xs btnEditTreatment" TreatmentID="<?php echo $list['TreatmentID'];?>" title="EDIT" data-toggle="modal" data-target="#modal-treatment"><i class="fa fa-fw fa-edit"></i></button>
                      </td>
                    </tr>
              <?php } } ?> 
            </tbody> 
          </table>
        </div>        
      </div>      
    </div>    
  </div>  
</section>

<script src="<?php echo base_url();?>assets/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/adminlte/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="<?php echo base_url();?>assets/jquery.inputmask.bundle.js"></script>
<script type="text/javascript">
jQuery( document ).ready(function( $ ) {
  $(function () {
    $('#dt_list').DataTable();
  });

  $(".mask-number").inputmask({ 
      alias:"currency", 
      prefix:'', 
      autoUnmask:true, 
      removeMaskOnSubmit:true, 
      showMaskOnHover: true 
  });
});

function clear_form() {
  $('#modal-customer input').val('')
  $('#modal-customer textarea').val('')
}
$('.btnEditTreatment').on( "click", function() { 
  TreatmentID  = $(this).attr('TreatmentID');
  $.ajax({
    url: "<?php echo base_url();?>master_data/get_treatment_detail",
    type : 'POST',
    data: {TreatmentID: TreatmentID},
    dataType : 'json',
    success : function (response) {
      $('#TreatmentID').val(response['TreatmentID'])
      $('#TreatmentName').val(response['TreatmentName'])
      $('#TreatmentPrice').val(response['TreatmentPrice'])
      $('#TreatmentNote').val(response['TreatmentNote']) 
    }
  })
});
</script>