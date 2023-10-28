<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">
  .form-addjoblevel, .form-editjoblevel {
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
  
  <div class="modal fade" id="scrollmodal"  style="overflow:hidden;" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="col-md-12 form-addjoblevel with-border">
                  <form role="form" action="<?php echo base_url();?>hrd/job_add" method="post" >
                    <div class="box box-solid ">
                      <div class="box-header">
                        <h3 class="box-title">Add Job Level</h3>
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                      </div>
                      <div class="box-body">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="left">Name</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="Job Level Name" autocomplete="off" name="name" id="name" readonly>
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Code</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="Code Name" autocomplete="off" name="code" id="code" readonly>
                            </span>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="left">Company Parent</label>
                            <span class="left2">
                              <select class="form-control input-sm" name="company" id="company">
                              <?php foreach ($fill_company as $row => $list) { ?>
                                <option value="<?php echo $list['CompanyID'];?>"><?php echo $list['CompanyName'];?></option>
                              <?php } ?>
                              </select>
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Level Devisi</label>
                            <span class="left2">
                              <select class="form-control input-sm" name="divisi" id="divisi"></select>
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Level Parent</label>
                            <span class="left2">
                              <select class="form-control input-sm select2" name="parent" id="parent">
                                <option value="0"></option>
                              <?php foreach ($content as $row => $list) { ?>
                                <option value="<?php echo $list['LevelID'];?>"><?php echo $list['LevelCode'].' - '.$list['LevelName'];?></option> 
                              <?php } ?>
                            </select>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="col-md-12 form-editjoblevel with-border">
                  <form role="form" action="<?php echo base_url();?>hrd/job_edit" method="post" >
                    <div class="box box-solid ">
                      <div class="box-header">
                        <h3 class="box-title">Edit Job Level</h3>
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                      </div>
                      <div class="box-body">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="left">ID</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" autocomplete="off" name="id" id="id" readonly>
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Job Level Name</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="Job Level Name" autocomplete="off" name="name2" id="name2" readonly>
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Status</label>
                            <span class="left2">
                              <select class="form-control input-sm" name="status" id="status">
                              <option value="1">Aktif</option>   
                              <option value="0">NonAktif</option>   
                            </select>
                            </span>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="left">Company Parent</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="Company parent Name" autocomplete="off" name="company2" id="company2" readonly>
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Level Devisi</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="Company parent Name" autocomplete="off" name="divisi2" id="divisi2" readonly>
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Level Parent</label>
                            <span class="left2">
                              <select class="form-control input-sm" name="parent2" id="parent2">
                              <option value="0"></option>
                              <?php foreach ($content as $row => $list) { ?>
                                <option value="<?php echo $list['LevelID'];?>"><?php echo $list['LevelCode'].' - '.$list['LevelName'];?></option> 
                              <?php } ?>
                              </select>
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Employee</label>
                            <span class="left2">
                              <select class="form-control select2 employee2" style="width: 100%;" name="employee2">
                              <option value="">Empty</option>
                              <?php foreach ($fill_employee as $row => $list) { ?>
                              <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['EmployeeName'];?></option>
                              <?php } ?>
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

  <div class="modal fade" id="infomodal" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div id="detailcontentAjax"></div>
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
        <a href="#" id="addjoblevel" class="btn btn-primary btn-xs addjoblevel" title="Add Job Level" data-toggle="modal" data-target="#scrollmodal"><b>+</b> Add Job Level</a><br>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
            <tr>
              <th id="order">ID</th>
              <th>Company Name</th>
              <th>Division</th>
              <th>Code</th>
              <th>Name</th>
              <th>Employee Name</th>
              <th>Status</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
                // echo print_r($content);
                foreach ($content as $row => $list) {
                  if ($list['LevelStatus'] == "Aktif") { ?>
                      <tr class="mini">
                    <?php } else { ?>
                      <tr class="mini" style="background-color: #cc8585">
                    <?php }; ?>
                    <td><?php echo $list['LevelID'];?></td>
                    <td><?php echo $list['CompanyName'];?></td>
                    <td><?php echo $list['DivisiName'];?></td>
                    <td><?php echo $list['LevelCode'];?></td>
                    <td><?php echo $list['LevelName'];?></td>
                    <td><?php echo $list['Employee'];?></td>
                    <td><?php echo $list['LevelStatus'];?></td>
                    <td>
                      <button type="button" class="btn btn-success btn-xs edit" title="EDIT" style="margin: 0px;" data-toggle="modal" data-target="#scrollmodal" employee="<?php echo $list['EmployeeID'];?>" parent="<?php echo $list['LevelParent'];?>"><i class="fa fa-fw fa-edit"></i></button>
                      <button type="button" class="btn btn-success btn-xs history" title="HISTORY" style="margin: 0px;" data-toggle="modal" data-target="#infomodal" id="<?php echo $list['LevelID'];?>"><i class="fa fa-fw fa-file-text-o"></i></button>
                    </td>
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
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
	 
  $('.select2').select2()
  $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',

    "ordering": false,
    "paging":   false,
    "scrollX": true,
    "scrollY": true,
  });
  
  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  };
  $('#dt_list').resize(cek_dt);

  $(".addjoblevel").click(function(){
      $(".form-addjoblevel").slideDown();
      $(".form-editjoblevel").slideUp();
      $("#name").prop("readonly", true);
      $("#code").prop("readonly", true);
  });
  $('.edit').live('click',function(e){
    $(".form-addjoblevel").slideUp();
    $( ".form-editjoblevel" ).slideDown();
      var
      par   = $(this).parent().parent();
      id    = par.find("td:nth-child(1)").html();
      name  = par.find("td:nth-child(5)").html();
      DivisiName  = par.find("td:nth-child(3)").html();
      CompanyName = par.find("td:nth-child(2)").html();
      code      = par.find("td:nth-child(4)").html();
      employee  = $(this).attr("employee")
      parent    = $(this).attr("parent")
      status    = par.find("td:nth-child(7)").html();
      $("#id").val(id);
      $("#name2").val(name);
      $("#divisi2").val(DivisiName);
      $("#company2").val(CompanyName);
      $("#code2").val(code);
      $('select.employee2').val(employee).trigger('change');
      $("#parent2").val(parent);
      if (status == "Aktif") {
        $("select#status").val("1");
      } else if (status == "NonAktif") {
        $("select#status").val("0");
      }
  });
  $('.history').live('click',function(e){
      LevelID    = $(this).attr("id")
      get(LevelID);
  });
  $("#company").click(function() {
    $.ajax({
      url: '<?php echo base_url();?>hrd/fill_divisi',
      data : 'data=' + $("#company").val(),
      type: 'get',
      dataType: 'json',
      success:function(response){
          var len = response.length;
          $("#divisi").empty();
          for( var i = 0; i<len; i++){
              var DivisiName = response[i]['DivisiName'];
              var DivisiID = response[i]['DivisiID'];
              $("#divisi").append("<option value='"+DivisiID+"'>"+DivisiName+"</option>");
          }
      }
    });
  });
  $("#divisi").click(function() {
    if ($("#divisi").val() !== null) {
      $.ajax({
        url: "<?php echo base_url();?>hrd/get_divisi_code",
        type : 'GET',
        data : 'data=' + $("#divisi").val(),
        dataType : 'json',
        success : function (result) {
          // $("#companyid").val(result['CompanyID']);
          $("#name").prop("readonly", false);
          $("#code").prop("readonly", false);
          $("#code").val(result['DivisiCode'] + "/");
        },
        error : function () {
           alert("error");
        }
      })
    }
  });
});

function get(id) {
  xmlHttp=GetXmlHttpObject()
    url="<?php echo base_url();?>hrd/job_history"
    url=url+"?id="+id
    xmlHttp.onreadystatechange=stateChanged
    xmlHttp.open("GET",url,true)
    xmlHttp.send(null)
}
function stateChanged(){
    if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
        document.getElementById("detailcontentAjax").innerHTML=xmlHttp.responseText
    }
}
function GetXmlHttpObject(){
    var xmlHttp=null;
    try{
        xmlHttp=new XMLHttpRequest();
    }catch(e){
        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    return xmlHttp;
}
</script>