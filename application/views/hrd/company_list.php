<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css">
  .form-addcompany, .form-editcompany {
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

  <div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <div class="form-addcompany with-border">
                  <form role="form" action="<?php echo base_url();?>hrd/company_add" method="post" >
                    <div class="box box-solid ">
                      <div class="box-header">
                        <h3 class="box-title">Add Company</h3>
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                      </div>
                      <div class="box-body">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="left">Company Name</label>
                            <span class="left2">
                             <input type="text" class="form-control input-sm" placeholder="Company Name" autocomplete="off" name="name" id="name">
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Address</label>
                            <span class="left2">
                             <textarea class="form-control input-sm" rows="3" placeholder="Street Address" name="address" id="address"></textarea><br>
                            </span>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="left">Phone Number</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="ex : +62 81xxxxxxxxx" autocomplete="off" name="phone" id="phone">
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Fax Number</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="ex : +62 32 xxxxxx" autocomplete="off" name="fax" id="fax">
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Code</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="Code Name" autocomplete="off" name="code" id="code">
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="form-editcompany with-border">
                  <form role="form" action="<?php echo base_url();?>hrd/company_edit" method="post" >
                    <div class="box box-solid ">
                      <div class="box-header">
                        <h3 class="box-title">Edit Company</h3>
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                      </div>
                      <div class="box-body">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="left">ID</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="Company ID" autocomplete="off" name="id" id="id" readonly="">
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Company Name</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="Company Name" autocomplete="off" name="name2" id="name2" readonly="">
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Address</label>
                            <span class="left2">
                              <textarea class="form-control input-sm" rows="3" placeholder="Address" name="address2" id="address2"></textarea><br>
                            </span>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="left">Phone Number</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="ex : +62 81xxxxxxxxx" autocomplete="off" name="phone2" id="phone2">
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Fax Number</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="ex : +62 32 xxxxxx" autocomplete="off" name="fax2" id="fax2">
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Code</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="Code Name" autocomplete="off" name="code2" id="code2" readonly="">
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="modal-footer">
              </div>
          </div>
      </div>
  </div>
  
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
        <a href="#" id="addCompany" class="btn btn-primary btn-xs addCompany" title="Add Company" data-toggle="modal" data-target="#scrollmodal"><b>+</b> Add Company</a><br>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
              <tr>
                <th id="order">ID</th>
                <th>Company Name</th>
                <th>Address</th>
                <th>Phone Number</th>
                <th>Fax Number</th>
                <th>Code</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            <?php
                // echo count($content);
                foreach ($content as $row => $list) {?>
                  <tr>
                    <td><?php echo $list['CompanyID'];?></td>
                    <td><?php echo $list['CompanyName'];?></td>
                    <td><?php echo $list['CompanyAddress'];?></td>
                    <td><?php echo $list['CompanyPhone'];?></td>
                    <td><?php echo $list['CompanyFax'];?></td>
                    <td><?php echo $list['CompanyCode'];?></td>
                    <td><a href="#" id="edit" class="btn btn-success btn-xs edit" title="Edit" style="margin: 0px;" data-toggle="modal" data-target="#scrollmodal"><i class="fa fa-fw fa-edit"></i></a></td>
                  </tr>
            <?php } ?>
        
            </tbody>
          </table>
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
      "targets": 6,
      "orderable": false
    } ],
    "order": [[ 0, "asc" ]]
  });

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  };
  $('#dt_list').resize(cek_dt);

  $(".addCompany").click(function(){
      $(".form-addcompany").slideDown();
      $(".form-editcompany").slideUp();
  });
  $('.edit').live('click',function(e){
    $(".form-addcompany").slideUp();
    $( ".form-editcompany" ).slideDown();
    var
    par   = $(this).parent().parent();
    id    = par.find("td:nth-child(1)").html();
    name  = par.find("td:nth-child(2)").html();
    address = par.find("td:nth-child(3)").html();
    phone = par.find("td:nth-child(4)").html();
    fax   = par.find("td:nth-child(5)").html();
    code  = par.find("td:nth-child(6)").html();
    // alert(id);
    $("#id").val(id);
    $("#name2").val(name);
    $("#address2").val(address);
    $("#phone2").val(phone);
    $("#fax2").val(fax);
    $("#code2").val(code);
    $( ".form-editcompany" ).slideDown( "slow", function() { });
  });
});
</script>