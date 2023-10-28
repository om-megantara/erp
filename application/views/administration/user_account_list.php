<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">
  .form-AddUser, .form-editdivision {
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
  .groupname, .groupname2 {margin-top: 2px;} 

  @media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 100px;
      padding: 5px 15px 5px 5px;
    }
    .form-group span.left2 {
      display: block;
      overflow: hidden;
    }
    .form-group { margin-bottom: 10px; }
  }
</style>

<div class="content-wrapper">

  <div class="modal fade" id="scrollmodal" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <div class="col-md-12 form-AddUser with-border">
                  <form role="form" action="<?php echo base_url();?>administration/user_account_add" method="post" >
                    <div class="box box-solid ">
                      <div class="box-header">
                        <h3 class="box-title">Add User</h3>
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                      </div>
                      <div class="box-body">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="left">Contact</label>
                            <span class="left2">
                              <input type="hidden" name="contactid" id="contactid">
                              <select class="form-control select2" name="contactname" id="contactname" required=""></select>
                            </span>
                          </div> 
                          <div class="form-group">
                            <label class="left">Username</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="Username" autocomplete="off" name="username" id="username" readonly="">
                            </span>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="left">Group</label>
                            <span class="left2">
                              <div class="input-group input-group-sm groupname">
                                <select class="form-control" name="groupname[]" id="groupname">
                                  <option value='0' selected disabled="">Select group</option>
                                </select>
                                <span class="input-group-btn">
                                  <button type="button" class="btn btn-primary  add_field" onclick="duplicategroupname();">+</button>
                                  <button type="button" class="btn btn-primary  add_field" onclick="if ($('.groupname').length != 1) { $(this).closest('div').remove();}">-</button>
                                </span>
                              </div>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="col-md-12 form-editdivision with-border">
                  <form role="form" action="<?php echo base_url();?>administration/user_account_edit" method="post" >
                    <div class="box box-solid ">
                      <div class="box-header">
                        <h3 class="box-title">Edit User</h3>
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                      </div>
                      <div class="box-body">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="left">Contact</label>
                            <span class="left2">
                              <input type="hidden" name="contactid" id="contactid2">
                              <input type="text" class="form-control input-sm" placeholder="Contact Name" autocomplete="off" name="contactname" id="contactname2" readonly="" >
                            </span>
                          </div> 
                          <div class="form-group">
                            <label class="left">Username</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="Username" autocomplete="off" name="username" id="username2" readonly="">
                            </span>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="left">Status</label>
                            <span class="left2">
                              <select class="form-control input-sm" name="status" id="status">
                                <option value="1">Aktif</option>   
                                <option value="0">NonAktif</option>   
                              </select>
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Group</label>
                            <span class="left2">
                              <div class="input-group input-group-sm groupname2">
                                <select class="form-control input-sm" name="groupname[]" id="groupname2" required="">
                                  <option value='' selected>Select group</option>
                                </select>
                                <span class="input-group-btn">
                                  <button type="button" class="btn btn-primary  add_field" onclick="duplicategroupname2();">+</button>
                                  <button type="button" class="btn btn-primary  add_field" onclick="if ($('.groupname2').length != 1) { $(this).closest('div').remove();}">-</button>
                                </span>
                              </div>
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
        <a href="#" id="tr-filter" class="btn btn-primary btn-xs tr-filter"><i class="fa fa-search"></i> Filter by Column</a>
        <a href="#" id="AddUser" class="btn btn-primary btn-xs AddUser" data-toggle="modal" data-target="#scrollmodal"><b>+</b> Add User</a> 
        <a href="#" id="setLogOutAll" class="btn btn-primary btn-xs setLogOutAll">Set LogOut All</a><br>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Job Code</th>
                <th>Username</th>
                <th>Group</th>
                <th>Status</th>
                <th>Email</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            <?php
              if (isset($content)) {
                foreach ($content as $row => $list) {
                  if ($list['status'] == "Active") { ?>
                      <tr class="mini">
                    <?php } else { ?>
                      <tr class="mini" style="background-color: #cc8585">
                    <?php }; ?>
                    <td><?php echo $list['UserAccountID'];?></td>
                    <td><?php echo $list['fullname'];?></td>
                    <td><?php echo $list['jobcode'];?></td>
                    <td><?php echo $list['username'];?></td>
                    <td><?php echo $list['group'];?></td>
                    <td><?php echo $list['status'];?></td>
                    <td><?php echo $list['Email'];?></td>
                    <td>
                      <button type="button" class="btn btn-success btn-xs edit" title="EDIT" data-toggle="modal" data-target="#scrollmodal"><i class="fa fa-fw fa-edit"></i></button>
                      <button type="button" class="btn btn-warning btn-xs" title="LOGIN AS" onclick="window.open('<?php echo base_url();?>login/logAs?id=<?php echo $list['UserAccountID']; ?>');"><i class="fa fa-fw fa-user-secret"></i></button>
                      <?php if ($list['ForceLogOut'] == 0){ ?>
                      <button type="button" class="btn btn-success btn-xs ForceLogOut" title="ForceLogOut" userid="<?php echo $list['UserAccountID'];?>"><i class="fa fa-fw fa-sign-out"></i></button>
                      <?php } else { ?>
                      <i class="fa fa-fw fa-sign-out"></i>
                      <?php } ?>
                    </td>
                  </tr>
            <?php } } ?>
        
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
  
  fill_groupname(); 
  th_filter_hidden = [0,3,4,5,6]
  $('#dt_list thead tr').clone(true).appendTo( '#dt_list thead' );
  $('#dt_list thead tr:eq(0)').addClass('tr-filter-column')
  $('#dt_list thead tr:eq(0) th').each( function (i) {
    if (th_filter_hidden.indexOf(i) < 0) {
      var title = $(this).text();
      $(this).html( '<input type="text" class="input-filter-column input input-sm" placeholder="Search '+title+'" />' );

      $( 'input', this ).on( 'keyup change', function () {
          if ( dtable.column(i).search() !== this.value ) {
              dtable
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

  dtable = $('#dt_list').DataTable({
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

  $(".AddUser").click(function(){
     $(".form-AddUser").slideDown();
     $(".form-editdivision").slideUp();
  });
  $('.edit').live('click',function(e){
      $(".form-AddUser").slideUp();
      $( ".form-editdivision" ).slideDown();
      var
      par   = $(this).parent().parent();
      id    = par.find("td:nth-child(1)").html();
      name  = par.find("td:nth-child(2)").html();
      username = par.find("td:nth-child(4)").html();
      group   = par.find("td:nth-child(5)").html();
      status  = par.find("td:nth-child(6)").html();
      $("#contactid2").val(id);
      $("#contactname2").val(name);
      $("#username2").val(username);
      if (status == "Active") {
        $("select#status").val("1");
      } else if (status == "NonActive") {
        $("select#status").val("0");
      }
      for (var i = $('.groupname2').length - 1; i >= 1; i--) {
        $("div.groupname2:last").remove();
      }
      if (group != "") {
        group = group.split(',');
        for (var i = 0 ; i <= group.length-1; i++) {
          $("select#groupname2:last").val(parseInt(group[i]));
          $(".groupname2:last").clone().insertAfter(".groupname2:last");
          // console.log(parseInt(group[i]));
        }
        $("div.groupname2:last").remove();
      }
  });

  $('#contactname').live('change',function(e){
      $("#contactid").val($(this).val());
      text = $('#contactname option:selected').text().split(/[\s|,|.|-]/).filter(function(e){return e})
      $("#username").val( (text[1]+'.'+ (text[2] || '')).toLowerCase() );
  })

  $('.ForceLogOut').live('click',function(e){
    par = $(this)
    userid = par.attr('userid')
    $.ajax({
        url: '<?php echo base_url();?>administration/ForceLogOut_set',
        type : 'POST',
        data: {UserAccountID:userid},
        dataType : 'json',
        success:function(response){
          if (response == "success") {
            par.replaceWith( '<i class="fa fa-fw fa-sign-out"></i>' )
          }
        }
    });
  });

  $('.setLogOutAll').on('click',function(e){
    $.ajax({
        url: '<?php echo base_url();?>administration/ForceLogOut_setAll',
        dataType : 'json',
        success:function(response){
          if (response == "success") {
            $('.ForceLogOut').replaceWith( '<i class="fa fa-fw fa-sign-out"></i>' )
          } else {
            alert('set LogOut All fail!')
          }
        }
    });
  });
});

$('#contactname').select2({
  placeholder: 'Minimum 3 Character',
  minimumInputLength: 3,
  ajax: {
    url: '<?php echo base_url();?>general/search_contact',
    dataType: 'json',
    data: function (term) {
      return {
          q: term, // search term
          contact: 'all'
      };
    },
    delay: 1000,
    processResults: function (data) {
      return {
        results: data
      };
    },
    cache: true
  }
}); 
function fill_groupname() {
  $.ajax({
      url: '<?php echo base_url();?>administration/fill_groupname',
      type: 'post',
      dataType: 'json',
      success:function(response){
          var len = response.length;
          for( var i = 0; i<len; i++){
              var UsergroupID = response[i]['UsergroupID'];
              var UsergroupNama = response[i]['UsergroupNama'];
              $("#groupname").append("<option value='"+UsergroupID+"'>"+UsergroupNama+"</option>");
              $("#groupname2").append("<option value='"+UsergroupID+"'>"+UsergroupNama+"</option>");
          }
      }
  });
}
function duplicategroupname() { $(".groupname:last").clone().insertAfter(".groupname:last"); }
function duplicategroupname2() { $(".groupname2:last").clone().insertAfter(".groupname2:last"); }

</script>