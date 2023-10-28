<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css">
  .form-addproduct_atributeset, .form-editproduct_atributeset {
    display: none;
  }
  .atribute, .atribute2 {margin-top: 2px;}
</style>

<div class="content-wrapper">

<!-- POP UP -->
<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              
              <!-- form add data -->
              <div class="col-md-12 form-addproduct_atributeset with-border" style="background-color: white;">
                <form role="form" action="<?php echo base_url();?>master/productatributeset_add" method="post" >
                  <div class="box box-solid ">
                    <div class="box-header">
                      <h3 class="box-title">Add Atribute Set</h3>
                      <button type="submit" class="btn btn-primary bt-sm pull-right">Submit</button>
                    </div>
                    <div class="col-md-6">
                      <div class="box-body">
                        <div class="form-group">
                          <label>Atribute Set Name</label>
                          <input type="text" class="form-control input-sm" placeholder="Atribute Set Name" autocomplete="off" name="name" id="name">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="box-body">
                        <div class="form-group">
                          <label>Atribute Set Detail</label>
                            <div class="input-group input-group-sm atribute">
                              <select class="form-control atributechild" name="atribute[]" required="">
                                <option value="" >---TOP---</option>
                              </select>
                              <span class="input-group-btn">
                                <button type="button" class="btn btn-primary  add_field" onclick="duplicateatribute();">+</button>
                                <button type="button" class="btn btn-primary  add_field" onclick="if ($('.atribute').length != 1) { $(this).closest('div').remove();}">-</button>
                              </span>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <!-- end form -->

              <!-- form edit data -->
              <div class="col-md-12 form-editproduct_atributeset with-border" style="background-color: white;">
                <form role="form" action="<?php echo base_url();?>master/productatributeset_edit" method="post" >
                  <div class="box box-solid ">
                    <div class="box-header">
                      <h3 class="box-title">Edit Atribute Set</h3>
                      <button type="submit" class="btn btn-primary btn-sm pull-right">Submit</button>
                    </div>
                    <div class="col-md-6">
                      <div class="box-body">
                        <div class="form-group">
                          <label>ID</label>
                          <input type="text" class="form-control input-sm" placeholder="Atribute Set ID" autocomplete="off" name="id" id="id" readonly="">
                        </div>
                        <div class="form-group">
                          <label>Atribute Set Name</label>
                          <input type="text" class="form-control input-sm" placeholder="Atribute Set Name" autocomplete="off" name="name2" id="name2" readonly="">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="box-body">
                        <div class="form-group">
                          <label>Atribute Set Detail</label>
                            <div class="input-group input-group-sm atribute2">
                              <select class="form-control atributechild2" name="atribute2[]" disabled="" required="">
                                <option value="" >---TOP---</option>
                              </select>
                              <span class="input-group-btn">
                                <button type="button" class="btn btn-primary  add_field" onclick="duplicateatribute2();">+</button>
                              </span>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <!-- end form -->
              
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- END POP UP -->

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
      <div class="box-header">
        <a title="ADD ATRIBUTE SET" href="#" id="addproduct_atributeset" class="btn btn-primary btn-xs addproduct_atributeset" data-toggle="modal" data-target="#scrollmodal"><b>+</b> Add Atribute Set</a><br>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
            <tr>
              <th id="order" class=" alignCenter">Atribute Set ID</th>
              <th class=" alignCenter"> Atribute Set Name</th>
              <th class=" alignCenter"> Atribute Set Detail</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
                // echo count($content);
                foreach ($content as $row => $list) {?>
                  <tr>
                    <td class=" alignCenter"><?php echo $list['ProductAtributeSetID'];?></td>
                    <td><?php echo $list['ProductAtributeSetName'];?></td>
                    <td><?php echo $list['detailname'];?></td>
                    <td><a title="EDIT" href="#" id="edit" class="btn btn-primary btn-xs edit" style="margin: 0px;" data-toggle="modal" data-target="#scrollmodal"><i class="fa fa-fw fa-edit"></i></a></td>
                  </tr>
            <?php } ?>
        
            </tbody>
          </table>
      </div>
      <div class="box-footer">
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
	 
  fill_atribute();
  $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "columnDefs": [ {
      "targets": 3,
      "orderable": false
    } ],
    "order": [[ 0, "asc" ]],
    "aaSorting": []
  });

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

  $(".addproduct_atributeset").click(function(){
    $(".form-addproduct_atributeset").slideDown();
    $(".form-editproduct_atributeset").slideUp();
  });
  $('.edit').live('click',function(e){
    par   = $(this).parent().parent();
    id    = par.find("td:nth-child(1)").html();
    name  = par.find("td:nth-child(2)").html();
    $("#id").val(id);
    $("#name2").val(name);

    len = $('.atribute2').length;
    for( var i = 1; i<len; i++){
      if ($('.atribute2').length != 1) { $('.atribute2:last').remove();}
    }
    $.ajax({
      url: '<?php echo base_url();?>master/get_atribute_set_value',
      type: 'post',
      data: {id:id},
      dataType: 'json',
      success:function(response){
        len = response.length;
        for( var i = 0; i<len; i++){
          console.log(i);
          $("select.atributechild2:last").val(response[i]);
          $(".atributechild2:last").prop("disabled", true);
          $(".atribute2:last").clone().insertAfter(".atribute2:last");
        }
        $('.atribute2:last').remove();
      }
    });
    $( ".form-addproduct_atributeset" ).slideUp();
    $( ".form-editproduct_atributeset" ).slideDown();
  });
  $('.form-editproduct_atributeset form').live('submit', function() {
      $(this).find(':disabled').removeAttr('disabled');
  });
});

function duplicateatribute() { $(".atribute:last").clone().insertAfter(".atribute:last"); }
function duplicateatribute2() { 
  $(".atribute2:last").clone().insertAfter(".atribute2:last"); 
  $(".atributechild2:last").prop("disabled", false);
}
function fill_atribute() {
  $.ajax({
    url: '<?php echo base_url();?>master/fill_atribute',
    type: 'post',
    dataType: 'json',
    success:function(response){
      var len = response.length;
      // $(".categorychild2").empty();
      for( var i = 0; i<len; i++){
        var ProductAtributeName = response[i]['ProductAtributeName'];
        var ProductAtributeID = response[i]['ProductAtributeID'];
        $(".atributechild").append("<option value='"+ProductAtributeID+"'>"+ProductAtributeName+"</option>");
        $(".atributechild2").append("<option value='"+ProductAtributeID+"'>"+ProductAtributeName+"</option>");
      }
    }
  });
}
</script>