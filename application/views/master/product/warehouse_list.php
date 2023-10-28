<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/datatables/media/css/jquery.dataTables.css">
<style type="text/css">
  #dtwarehouse_list tbody,
  #dtwarehouse_list thead,
  .dataTables_scrollHeadInner thead,
  #dtwarehouse_list tfoot{
    font-size: 12px !important;
  }
  #dtwarehouse_list tbody td {
    padding: 4px;
    vertical-align: text-top;
  }
  .addwarehouse, .edit {
    margin: 10px;
    background-color: #0073b7;
    color: white;
    padding: 2px 5px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    font-weight: bold;
  }
  .form-addwarehouse, .form-editwarehouse {
    display: none;
  }
</style>
<style type="text/css">
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <?php echo $PageTitle.' - '. $MainTitle; ?>
    </h1>
  </section>

  <section class="content">
    <div class="box with-border">
      <div class="box-header">
        <a href="#" id="addwarehouse" class="addwarehouse"><b>+</b> Add Warehouse</a><br>
        <div class="col-md-12 form-addwarehouse with-border">
          <form role="form" action="<?php echo base_url();?>master/warehouse_add" method="post" >
            <div class="box box-primary ">
              <div class="box-header">
                <h3 class="box-title">Add warehouse</h3>
                <button type="submit" class="btn btn-primary pull-right">Submit</button>
              </div>
              <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label>warehouse Name</label>
                      <input type="text" class="form-control" placeholder="warehouse Name" autocomplete="off" name="name" id="name">
                    </div>
                    <div class="form-group">
                      <label>Address</label>
                      <textarea class="form-control" rows="3" placeholder="Address" name="address" id="address"></textarea><br>
                    </div>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label>Phone</label>
                      <input type="text" class="form-control" placeholder="Phone Name" autocomplete="off" name="phone" id="phone">
                    </div>
                  </div>
              </div>
            </div>
          </form>
        </div>
        <div class="col-md-12 form-editwarehouse with-border">
          <form role="form" action="<?php echo base_url();?>master/warehouse_edit" method="post" >
            <div class="box box-primary ">
              <div class="box-header">
                <h3 class="box-title">Edit warehouse</h3>
                <button type="submit" class="btn btn-primary pull-right">Submit</button>
              </div>
              <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label>ID</label>
                      <input type="text" class="form-control" placeholder="warehouse ID" autocomplete="off" name="id" id="id" readonly>
                    </div>
                    <div class="form-group">
                      <label>warehouse Name</label>
                      <input type="text" class="form-control" placeholder="warehouse Name" autocomplete="off" name="name2" id="name2" readonly>
                    </div>
                    <div class="form-group">
                      <label>Address</label>
                      <textarea class="form-control" rows="3" placeholder="Address" name="address2" id="address2"></textarea><br>
                    </div>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label>Phone</label>
                      <input type="text" class="form-control" placeholder="Phone Name" autocomplete="off" name="phone2" id="phone2">
                    </div>
                  </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="box-body">
          <table id="dtwarehouse_list" class="table table-bordered table-hover" width="100%">
            <thead>
            <tr>
              <th id="order">ID</th>
              <th>warehouse Name</th>
              <th>Address</th>
              <th>Phone</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
                // echo count($content);
                foreach ($content as $row => $list) {?>
                  <tr>
                    <td><?php echo $list['WarehouseID'];?></td>
                    <td><?php echo $list['WarehouseName'];?></td>
                    <td><?php echo $list['WarehouseAddress'];?></td>
                    <td><?php echo $list['WarehousePhone'];?></td>
                    <td><a href="#" id="edit" class="edit" style="margin: 0px;"><i class="fa fa-fw fa-edit"></i></a></td>
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
<script language="javascript" src="<?php echo base_url();?>tool/datatables/media/js/jquery.dataTables.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
	$( "li.menu_master" ).addClass( "active" );
  $('#dtwarehouse_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
    "scrollX": true,
     "scrollY": true,
    "columnDefs": [ {
      "targets": 4,
      "orderable": false
    } ],
    "order": [[ 0, "desc" ]]
  });

  setTimeout( function order() {
    $('.table-bordered th#order').click();
  }, 100) //force to order and fix header width

  $(".addwarehouse").click(function(){
      $(".form-addwarehouse").slideToggle();
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
    $( ".form-editwarehouse" ).slideDown( "slow", function() { });
  });
});
</script>