<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css">
  .form-addoffice, .form-editoffice {
    display: none;
  }
  .ui-autocomplete {
    z-index: 5;
    float: left;
    display: none;
    min-width: 160px;   
    padding: 4px 0;
    margin: 2px 0 10px 10px;
    list-style: none;
    background-color: #ffffff;
    border-color: #ccc;
    border-style: solid;
    border-width: 1px;
    max-height: 200px; 
    overflow-y: scroll; 
    overflow-x: hidden;
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
                <div class="col-md-12 form-addoffice with-border">
                  <form role="form" action="<?php echo base_url();?>hrd/office_add" method="post" >
                    <div class="box box-solid ">
                      <div class="box-header">
                        <h3 class="box-title">Add Office</h3>
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                      </div>
                      <div class="box-body">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="left">Office Name</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="Office Name" autocomplete="off" name="name" id="name">
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Location Address</label>
                            <span class="left2">
                              <textarea class="form-control input-sm" rows="3" placeholder="Location Address" name="note" id="note"></textarea><br>
                            </span>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="left">Company Parent</label>
                            <span class="left2">
                              <select class="form-control input-sm" name="company" id="company">
                                <?php foreach ($fill_company as $row => $list) { ?>
                                <option value="<?php echo $list['CompanyName'];?>"><?php echo $list['CompanyName'];?></option>
                                <?php } ?>
                              </select>
                              <input type="hidden" name="companyid" id="companyid">
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
                <div class="col-md-12 form-editoffice with-border">
                  <form role="form" action="<?php echo base_url();?>hrd/office_edit" method="post" >
                    <div class="box box-solid ">
                      <div class="box-header">
                        <h3 class="box-title">Edit Office</h3>
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                      </div>
                      <div class="box-body">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="left">ID</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" autocomplete="off" name="id" id="id" readonly="">
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Office Name</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="Office Name" autocomplete="off" name="name2" id="name2">
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Location Address</label>
                            <span class="left2">
                              <textarea class="form-control input-sm" rows="3" placeholder="Location Address" name="note2" id="note2"></textarea><br>
                            </span>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="left">Company Parent</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="Company parent Name" autocomplete="off" name="company2" id="company2" readonly="">
                              <input type="hidden" name="companyid2" id="companyid2">
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Code</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="Code Name" autocomplete="off" name="code2" id="code2" readonly="">
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Status</label>
                            <span class="left2">
                              <select class="form-control" name="status" id="status">
                                <option value="1">Aktif</option>   
                                <option value="0">NonAktif</option>   
                              </select>
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
      <div class="box-header with-border">
        <a href="#" id="addoffice" class="btn btn-primary btn-xs addoffice" data-toggle="modal" title="Add Office" data-target="#scrollmodal"><b>+</b> Add Office</a><br>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
            <tr>
              <th id="order">ID</th>
              <th>Name</th>
              <th>Company Name</th>
              <th>Code</th>
              <th>Location Address</th>
              <th>Status</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
                // echo print_r($content);
                foreach ($content as $row => $list) {
                  if ($list['LocStatus'] == "Aktif") { ?>
                      <tr class="mini">
                    <?php } else { ?>
                      <tr class="mini" style="background-color: #cc8585">
                    <?php }; ?>
                    <td><?php echo $list['LocID'];?></td>
                    <td><?php echo $list['LocName'];?></td>
                    <td><?php echo $list['CompanyName'];?></td>
                    <td><?php echo $list['LocCode'];?></td>
                    <td><?php echo $list['LocNote'];?></td>
                    <td><?php echo $list['LocStatus'];?></td>
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
<script src="<?php echo base_url();?>tool/jquery-ui.js"></script>
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

  $(".addoffice").click(function(){
      $(".form-addoffice").slideDown();
      $(".form-editoffice").slideUp();
  });
  $('.edit').live('click',function(e){
    $(".form-addoffice").slideUp();
    $( ".form-editoffice" ).slideDown();
      var
      par   = $(this).parent().parent();
      id    = par.find("td:nth-child(1)").html();
      name  = par.find("td:nth-child(2)").html();
      CompanyName = par.find("td:nth-child(3)").html();
      note  = par.find("td:nth-child(5)").html();
      code  = par.find("td:nth-child(4)").html();
      status  = par.find("td:nth-child(6)").html();
      $("#id").val(id);
      $("#name2").val(name);
      $("#company2").val(CompanyName);
      $("#note2").val(note);
      $("#code2").val(code);
      if (status == "Aktif") {
        $("select#status").val("1");
      } else if (status == "NonAktif") {
        $("select#status").val("0");
      }
  });
  $("#company").click(function() {
    $.ajax({
      url: "<?php echo base_url();?>hrd/get_company_code",
      type : 'GET',
      data : 'data=' + $("#company").val(),
      dataType : 'json',
      success : function (result) {
        $("#companyid").val(result['CompanyID']);
        $("#code").val(result['CompanyCode'] + "-");
      },
      error : function () {
         alert("error");
      }
    })
  });
});
</script>