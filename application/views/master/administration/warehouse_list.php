<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css"> 
  .form-addwarehouse, .form-editwarehouse {
    display: none;
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
                <div class="col-md-12 form-addwarehouse with-border" style="background-color: white;">
                  <form role="form" action="<?php echo base_url();?>master/warehouse_add" method="post" >
                    <div class="box box-solid ">
                      <div class="box-header">
                        <h3 class="box-title">Add Warehouse</h3>
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                      </div>
                      <div class="col-md-6">
                          <div class="box-body">
                            <div class="form-group">
                              <label class="left">Warehouse Name</label>
                              <span class="left2">
                                <input type="text" class="form-control input-sm" placeholder="Warehouse Name" autocomplete="off" name="name" id="name">
                              </span>
                            </div>
                            <div class="form-group">
                              <label class="left">Address</label>
                              <span class="left2">
                                <textarea class="form-control" rows="3" placeholder="Address" name="address" id="address"></textarea><br>
                              </span>
                            </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="box-body">
                            <div class="form-group">
                              <label class="left">Phone Number</label>
                              <span class="left2">
                                <input type="text" class="form-control input-sm" placeholder="Ex: 081xxx" autocomplete="off" name="phone" id="phone">
                              </span>
                            </div>
                          </div>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- end form add -->

                <!-- form edit data -->
                <div class="col-md-12 form-editwarehouse with-border" style="background-color: white;">
                  <form role="form" action="<?php echo base_url();?>master/warehouse_edit" method="post" >
                    <div class="box box-solid ">
                      <div class="box-header">
                        <h3 class="box-title">Edit Warehouse</h3>
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                      </div>
                      <div class="col-md-6">
                          <div class="box-body">
                            <div class="form-group">
                              <label class="left">ID</label>
                              <span class="left2">
                                <input type="text" class="form-control input-sm" placeholder="Warehouse ID" autocomplete="off" name="id" id="id" readonly>
                              </span>
                            </div>
                            <div class="form-group">
                              <label class="left">Warehouse Name</label>
                              <span class="left2">
                                <input type="text" class="form-control input-sm" placeholder="Warehouse Name" autocomplete="off" name="name2" id="name2" readonly>
                              </span>
                            </div>
                            <div class="form-group">
                              <label class="left">Address</label>
                              <span class="left2">
                                <textarea class="form-control input-sm" rows="3" placeholder="Address" name="address2" id="address2"></textarea>
                              </span>
                            </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="box-body">
                            <div class="form-group">
                              <label class="left">Phone Number</label>
                              <span class="left2">
                                <input type="text" class="form-control input-sm" placeholder="Ex: 081xxx" autocomplete="off" name="phone2" id="phone2">
                              </span>
                            </div>
                          </div>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- end form edit-->
                
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
        <a title="ADD WAREHOUSE" href="#" id="addwarehouse" class="btn btn-primary btn-xs addwarehouse" data-toggle="modal" data-target="#scrollmodal"><b>+</b> Add Warehouse</a><br>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
            <tr>
              <th id="order" class=" alignCenter">ID</th>
              <th class=" alignCenter">Warehouse Name</th>
              <th class=" alignCenter">Address</th>
              <th class=" alignCenter">Phone</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
                // echo count($content);
                foreach ($content as $row => $list) {?>
                  <tr>
                    <td class=" alignCenter"><?php echo $list['WarehouseID'];?></td>
                    <td><?php echo $list['WarehouseName'];?></td>
                    <td><?php echo $list['WarehouseAddress'];?></td>
                    <td><?php echo $list['WarehousePhone'];?></td>
                    <td><a title="EDIT" href="#" id="edit" class="btn btn-success btn-xs edit" style="margin: 0px;" data-toggle="modal" data-target="#scrollmodal"><i class="fa fa-fw fa-edit"></i></a></td>
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
      "targets": 4,
      "orderable": false
    } ],
    "order": [[ 0, "asc" ]]
  });

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  };
  $('#dt_list').resize(cek_dt);

  $(".addwarehouse").click(function(){
    $(".form-addwarehouse").slideDown();
    $(".form-editwarehouse").slideUp();
  });
  $('.edit').live('click',function(e){
    var
    par   = $(this).parent().parent();
    id    = par.find("td:nth-child(1)").html();
    name  = par.find("td:nth-child(2)").html();
    address = par.find("td:nth-child(3)").html();
    phone = par.find("td:nth-child(4)").html();
    // alert(id);
    $("#id").val(id);
    $("#name2").val(name);
    $("#address2").val(address);
    $("#phone2").val(phone);

    $( ".form-addwarehouse" ).slideUp();
    $( ".form-editwarehouse" ).slideDown();
  });
});
</script>