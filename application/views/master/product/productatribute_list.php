<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css"> 
  .addproduct_atribute, .cek_duplicate_code { margin-bottom: 22px; }
  .atributevalue, .atributevalue2 { margin-top: 2px; }
  .form-addproduct_atribute, .form-editproduct_atribute {
    display: none;
  }
  /*input.code { text-transform: uppercase; }*/
</style>

<div class="content-wrapper">

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
              <div class="col-md-12 form-addproduct_atribute with-border" style="background-color: white;">
                <form role="form" action="<?php echo base_url();?>master/productatribute_add" method="post" >
                  <div class="box box-solid ">
                    <div class="box-header">
                      <h3 class="box-title">Add Product Atribute</h3>
                      <button type="submit" class="btn btn-primary btn-sm pull-right">Submit</button>
                    </div>
                    <div class="col-md-6">
                        <div class="box-body">
                          <div class="form-group">
                            <label>Product Atribute Name</label>
                            <input type="text" class="form-control input-sm" placeholder="Product Atribute Name" autocomplete="off" name="name" id="name">
                          </div>
                          <div class="form-group">
                            <label>Product Atribute Type</label>
                            <select class="form-control input-sm" name="type" id="type" onchange="formdetail(this);">
                              <option value="list" >List</option>
                              <option value="text" >Text</option>
                            </select>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                      <div class="box-body">
                        <div class="form-group atributelist">
                          <div>
                            <div class="col-xs-6">
                              Product Atribute Value
                            </div>
                            <div class="col-xs-6">
                              Product Atribute Code
                            </div>
                          </div>
                          <div class="input-group input-group-sm atributevalue">
                            <div class="col-xs-6">
                              <input type="text" class="form-control input-sm nonComma" name="namevalue[]" placeholder="Name Value" required="">
                            </div>
                            <div class="col-xs-6">
                              <input type="text" class="form-control input-sm nonComma code" name="codevalue[]" placeholder="Code Value" onkeyup="this.value = this.value.toUpperCase();" required="">
                            </div>
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-primary  add_field" onclick="duplicateaributevalue();">+</button>
                              <button type="button" class="btn btn-primary  add_field" onclick="if ($('.codevalue').length != 1) { $(this).closest('div').remove();}">-</button>
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
              <div class="col-md-12 form-editproduct_atribute with-border" style="background-color: white;">
                <form role="form" action="<?php echo base_url();?>master/productatribute_edit" method="post" >
                  <div class="box box-solid ">
                    <div class="box-header">
                      <h3 class="box-title">Edit Product Atribute</h3>
                      <button type="submit" class="btn btn-primary btn-sm pull-right">Submit</button>
                    </div>
                    <div class="col-md-6">
                        <div class="box-body">
                          <div class="form-group">
                            <label>ID</label>
                            <input type="text" class="form-control input-sm" placeholder="product atribute ID" autocomplete="off" name="id" id="id" readonly>
                          </div>
                          <div class="form-group">
                            <label>Product Atribute Name</label>
                            <input type="text" class="form-control input-sm" placeholder="Product Atribute Name" autocomplete="off" name="name2" id="name2" readonly>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box-body">
                          <div class="form-group">
                            <label>Product Atribute Type</label>
                            <select class="form-control" name="type2" id="type2" readonly disabled>
                              <option value="list" >List</option>
                              <option value="text" >Text</option>
                            </select>
                          </div>
                          <div class="form-group atributelist2">
                            <div>
                              <div class="col-xs-6">
                                Product Atribute Value
                              </div>
                              <div class="col-xs-6">
                                Product Atribute Code
                              </div>
                            </div>
                            <div class="input-group input-group-sm atributevalue2">
                              <div class="col-xs-6">
                                <input type="text" class="form-control input-sm namevalue2 nonComma" name="namevalue[]" placeholder="Name Value" required="">
                                <input type="hidden" class="namevalue2Old" name="namevalueOld[]">
                              </div>
                              <div class="col-xs-6">
                                <input type="text" class="form-control input-sm codevalue2 nonComma code" name="codevalue[]" placeholder="Code Value" onkeyup="this.value = this.value.toUpperCase();" required="">
                                <input type="hidden" class="codevalue2Old" name="codevalueOld[]">
                              </div>
                              <span class="input-group-btn">
                                <button type="button" class="btn btn-primary  add_field" onclick="duplicateaributevalue2();">+</button>
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
      <li><a title="HELP" class="btn btn-warning btn-xs" href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>

  <section class="content">
    <div class="box box-solid">
      <div class="box-header">
        <button type="button" class="btn btn-primary btn-xs addproduct_atribute" id="addproduct_atribute" title="ADD PRODUCT ATRIBUTE" data-toggle="modal" data-target="#scrollmodal"><b>+</b> Add Product Atribute</button>
        <button type="button" class="btn btn-primary btn-xs cek_duplicate_code" id="cek_duplicate_code" title="CHECK DUPLICATE CODE">Check Duplicate Code</button>
        <div class="form_cek_used_code" style="display: inline-grid;">
          <div class="input-group input-group-sm">
            <div class="input-group-btn">
              <button type="button" class="btn btn-primary btn-xs " id="cek_used_code" title="CHECK">Check</button>
            </div>
            <input type="text" class="form-control input-sm" id="code" name="code" placeholder="INSERT CODE" autocomplete="off">
          </div>
        </div>
        <br>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" style="width: 100%;">
            <thead>
            <tr>
              <th id="order" class=" alignCenter">ID</th>
              <th class=" alignCenter">Product Atribute Name</th>
              <th class=" alignCenter">Product Atribute Type</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
                // echo count($content);
                foreach ($content as $row => $list) {?>
                  <tr>
                    <td class=" alignCenter"><?php echo $list['ProductAtributeID'];?></td>
                    <td><?php echo $list['ProductAtributeName'];?></td>
                    <td><?php echo $list['ProductAtributeType'];?></td>
                    <td><a href="#" id="edit" class="btn btn-primary btn-xs edit" style="margin: 0px;" data-toggle="modal" data-target="#scrollmodal" title="EDIT"><i class="fa fa-fw fa-edit"></i></a></td>
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
    "order": [[ 0, "asc" ]]
  });

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

  $(".addproduct_atribute").click(function(){
    $(".form-addproduct_atribute").slideDown();
    $(".form-editproduct_atribute").slideUp();
  });
  $('.edit').live('click',function(e){
    par   = $(this).parent().parent();
    id    = par.find("td:nth-child(1)").html();
    name  = par.find("td:nth-child(2)").html();
    type  = par.find("td:nth-child(3)").html();
    $("#id").val(id);
    $("#name2").val(name);
    $("select#type2").val(type);

    len = $('.atributevalue2').length;
    for( var i = 1; i<len; i++){
      if ($('.atributevalue2').length != 1) { $('.atributevalue2:last').remove();}
    }
    if (type == "list") {
      $('.atributelist2').show();
      $.ajax({
        url: '<?php echo base_url();?>master/get_atribute_value',
        type: 'post',
        data: {id:id},
        dataType: 'json',
        success:function(response){
          len = response.length;
          for( var i = 0; i<len; i++){
            console.log(i);
            $(".codevalue2:last").val(response[i]['ProductAtributeValueCode']);
            $(".codevalue2Old:last").val(response[i]['ProductAtributeValueCode']);
            $(".codevalue2:last").prop("readonly", false);
            $(".codevalue2Old:last").prop("readonly", true);
            $(".namevalue2:last").val(response[i]['ProductAtributeValueName']);
            $(".namevalue2Old:last").val(response[i]['ProductAtributeValueName']);
            $(".namevalue2:last").prop("readonly", false);
            $(".namevalue2Old:last").prop("readonly", true);
            $(".atributevalue2:last").clone().insertAfter(".atributevalue2:last");
          }
          $('.atributevalue2:last').remove();
        }
      });
    } else { $('.atributelist2').hide(); }
    $( ".form-addproduct_atribute" ).slideUp();
    $( ".form-editproduct_atribute" ).slideDown();
  });
});
function duplicateaributevalue() { $(".atributevalue:last").clone().insertAfter(".atributevalue:last"); }
function duplicateaributevalue2() { 
  $(".atributevalue2:last").clone().insertAfter(".atributevalue2:last"); 
  $(".namevalue2:last").prop("readonly", false).val("");
  $(".namevalue2Old:last").val("new_item");
  $(".codevalue2:last").prop("readonly", false).val("");
  $(".codevalue2Old:last").val("new_item");
}
function formdetail(sel) {
  len = $('.atributevalue').length;
  for( var i = 1; i<len; i++){
    if ($('.atributevalue').length != 1) { $('.atributevalue:last').remove();}
  }
  if (sel.value == "list") {
    $('.atributelist').show();
  } else {
    $('.atributelist').hide();
  }
}

$('#cek_duplicate_code').click( function() {
  $.ajax({
    url: "<?php echo base_url();?>master/cek_duplicate_atribute_code",
    type : 'POST',
    dataType : 'json',
    success : function (response) {
      len = response.length;
      note = ""
      if (len>1) {
        note += "The following code is the same attribute :\n"
        for( var i = 0; i<len; i++){
          note += "-> "+response[i]['ProductAtributeName']+", "+response[i]['ProductAtributeValueName']+", "+response[i]['ProductAtributeValueCode']+"\n"
        }
        alert(note)
      } else {
        alert("There is no same attribute code.")
      }
    }
  })
});
$('#cek_used_code').click( function() {
  code = $('#code').val()
  $.ajax({
    url: "<?php echo base_url();?>master/cek_used_atribute_code",
    type : 'POST',
    data: {code: code},
    dataType : 'json',
    success : function (response) {
      len = response.length;
      note = ""
      if (len>0) {
        note += "Attribute code is already used :\n"
        for( var i = 0; i<len; i++){
          note += "-> "+response[i]['ProductAtributeName']+", "+response[i]['ProductAtributeValueName']+", "+response[i]['ProductAtributeValueCode']+"\n"
        }
        alert(note)
      } else {
        alert("There is no same attribute code.")
      }
    }
  })
});
</script>