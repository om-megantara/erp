<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css"> 
  .form-addBrand, .form-editBrand {
    display: none;
  }
  input.code { text-transform: uppercase; }
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
              <div class="col-md-12 form-addBrand with-border" style="background-color: white;">
                <form role="form" action="<?php echo base_url();?>master/brand_add" method="post" >
                  <div class="box box-solid">
                    <div class="box-header">
                      <div class="col-md-9">
                        <h3 class="box-title">Add Brand</h3>
                      </div>
                      <?php if (in_array("print_without_header", $MenuList)) {?>
                        <div class="col-md-2 form-group ">
                          <label>Add Product</label>
                          <input type="checkbox" id="idp" name="idp" value="1" checked>
                        </div>
                      <?php } ?>
                      <div class="col-md-1">
                        <button type="submit" class="btn btn-primary btn-sm pull-right">Submit</button>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="box-body">
                        <div class="form-group">
                          <label>Brand Name</label>
                          <input type="text" class="form-control input-sm" placeholder="Brand Name" autocomplete="off" name="name" id="name">
                        </div>
                        <div class="form-group">
                          <label>Brand Code</label>
                          <input type="text" class="form-control input-sm code" placeholder="Brand Code" autocomplete="off" name="code" id="code" onkeyup="this.value = this.value.toUpperCase();">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="box-body">
                        <div class="form-group">
                          <label>Brand Parent</label>
                          <select class="form-control input-sm" name="parent" id="parent">
                            <option value="0" >---TOP---</option>
                            <?php foreach ($content2 as $row => $list) { ?>
                              <option value="<?php echo $list['ProductBrandID'];?>"><?php echo $list['ProductBrandName'];?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>Description</label>
                          <textarea class="form-control" rows="3" placeholder="Description" name="description" id="description"></textarea><br>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <!-- end form -->

              <!-- form edit data -->
              <div class="col-md-12 form-editBrand with-border" style="background-color: white">
                <form role="form" action="<?php echo base_url();?>master/brand_edit" method="post" >
                  <div class="box box-solid ">
                    <div class="box-header">
                      <h3 class="box-title">Edit Brand</h3>
                      <button type="submit" class="btn btn-primary btn-sm pull-right">Submit</button>
                    </div>
                    <div class="col-md-6">
                      <div class="box-body">
                        <div class="form-group">
                          <label>ID</label>
                          <input type="text" class="form-control input-sm" placeholder="Brand ID" autocomplete="off" name="id" id="id" readonly="">
                        </div>
                        <div class="form-group">
                          <label>Brand Name</label>
                          <input type="text" class="form-control input-sm" placeholder="Brand Name" autocomplete="off" name="name2" id="name2">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="box-body">
                        <div class="form-group">
                          <label>Brand Code</label>
                          <input type="text" class="form-control input-sm code" placeholder="Brand Code" autocomplete="off" name="code2" id="code2" onkeyup="this.value = this.value.toUpperCase();">
                        </div>
                        <div class="form-group">
                          <label>Description</label>
                          <textarea class="form-control" rows="3" placeholder="Description" name="description2" id="description2"></textarea><br>
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
      <div class="box-header with-border">
        <a href="#" id="addBrand" class="btn btn-primary btn-xs addBrand" data-toggle="modal" data-target="#scrollmodal" title="ADD BRAND"><b>+</b> Add Brand</a>  
        <a href="#" id="tr-filter" class="btn btn-primary btn-xs tr-filter"><i class="fa fa-search"></i> Filter by Column</a>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
            <tr>
              <th id="order" class=" alignCenter">NO</th>
              <th class=" alignCenter">ID</th>
              <th class=" alignCenter">Brand Name</th>
              <th class=" alignCenter">Brand Code</th>
              <th class=" alignCenter">Brand Parent</th>
              <th class=" alignCenter">Description</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
                // echo count($content);
                $no = 0;
                foreach ($content as $row => $list) { $no++; ?>
                  <tr>
                    <td class=" alignCenter"><?php echo $no;?></td>
                    <td class=" alignCenter"><?php echo $list['ProductBrandID'];?></td>
                    <td><?php echo $list['ProductBrandName'];?></td>
                    <td><?php echo $list['ProductBrandCode'];?></td>
                    <td><?php echo $list['ProductBrandParent'];?></td>
                    <td><?php echo $list['ProductBrandDescription'];?></td>
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

	th_filter_hidden = [0,1,5,6,7,8]
  $('#dt_list thead tr').clone(true).appendTo( '#dt_list thead' );
  $('#dt_list thead tr:eq(0)').addClass('tr-filter-column')
  $('#dt_list thead tr:eq(0) th').each( function (i) {
    if (th_filter_hidden.indexOf(i) < 0) {
      var title = $(this).text();
      $(this).html( '<input type="text" class="input-filter-column input input-sm" placeholder="Search '+title+'" />' );

      $( 'input', this ).on( 'keyup change', function () {
          if ( table.column(i).search() !== this.value ) {
              table
                  .column(i)
                  .search( this.value )
                  .draw();
          }
      });
    } else {
      $(this).text('')
    }
  });
  $(".tr-filter").click(function(){
    $(".tr-filter-column").slideToggle().focus();
  }); 

  table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "columnDefs": [ {
      "targets": 6,
      "orderable": false
    } ],
    "order": [[ 0, "asc" ]]
  });

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

  $(".addBrand").click(function(){
    $(".form-addBrand").slideDown();
    $(".form-editBrand").slideUp();
  });
  $('.edit').live('click',function(e){
    var
    par   = $(this).parent().parent();
    id    = par.find("td:nth-child(2)").html();
    name  = par.find("td:nth-child(3)").text();
    name  = name.replace(/>/g, "");
    name  = name.replace(/ /g, "");
    code  = par.find("td:nth-child(4)").html();
    description = par.find("td:nth-child(6)").html();
    // alert(id);
    $("#id").val(id);
    $("#name2").val($.trim(name));
    $("#code2").val(code);
    $("#description2").val(description);
    $( ".form-addBrand" ).slideUp();
    $( ".form-editBrand" ).slideDown();
  }); 
});
</script>