<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css">
  .DTbreakWord {
    max-width: 600px;
    word-wrap: break-word !important;
    white-space: normal !important;
  }
  .form-adddivision, .form-editdivision { display: none; }
  table.table-menu tr th, table.table-menu tr td { font size: 8px !important; padding: 2px 4px !important; }
  input[type='checkbox'] {
    -webkit-appearance:none;
    width:15px;
    height:15px;
    background:white;
    border-radius:3px;
    border:1px solid #555;
  }
  input[type='checkbox']:checked {
    background: #3c8dbc;
  }
  .table-menu { font-size: 12px !important; }
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
              <div class="form-adddivision with-border">
                <form role="form" action="<?php echo base_url();?>administration/user_menu_add" method="post" >
                  <div class="box box-solid ">
                    <div class="box-header">
                      <h3 class="box-title">Add User Menu</h3>
                      <button type="submit" class="btn btn-primary pull-right">Submit</button>
                    </div>
                    <div class="box-body">
                      <div class="row">
                        <div class="col-xs-6">
                          <input type="text" class="form-control input-sm" placeholder="User Account ID" autocomplete="off" name="id" id="id" readonly="">
                        </div>
                        <div class="col-xs-6">
                          <select class="form-control input-sm" name="name" id="name">
                            <option value='' selected disabled>pilih User Account</option>
                            <?php 
                              foreach ($content2 as $row => $list) { ?>
                                <option value='<?php echo $list['UserAccountID'];?>'><?php echo $list['Fullname'];?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div><br>
                      <div class="col-md-12 table-responsive" style="max-height: 450px; overflow: auto;">
                        <table class="table table-bordered table-menu">
                          <tr class="table-menu">
                            <th style="width: 10px">#</th>
                            <th>Menu Note</th>
                            <th>Menu Location</th>
                          </tr>
                          <?php
                            foreach ($content['menu'] as $row => $list) { ?>
                              <tr>
                                <td>
                                  <input type="checkbox" id="<?php echo $list['MenuID'];?>" name="menu[]" value="<?php echo $list['MenuID'];?>">
                                </td>
                                <td>
                                  <?php echo str_replace('.', '-- ', preg_replace("/[^.]/","",$list['MenuID']) );?>
                                  <?php echo $list['MenuNote'];?>
                                </td>
                                <td><?php echo $list['MenuLocation'];?></td>
                              </tr>
                          <?php } ?>
                        </table>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="form-editdivision with-border">
                <form role="form" action="<?php echo base_url();?>administration/user_menu_edit" method="post" >
                  <div class="box box-solid ">
                    <div class="box-header">
                      <h3 class="box-title">Edit User Manu</h3>
                      <button type="submit" class="btn btn-primary pull-right">Submit</button>
                    </div>
                    <div class="box-body">
                      <div class="row">
                        <div class="col-xs-6">
                          <input type="text" class="form-control input-sm" autocomplete="off" name="id" id="id2" readonly="">
                        </div>
                        <div class="col-xs-6">
                          <input type="text" class="form-control input-sm" autocomplete="off" name="name" id="name2">
                        </div>
                      </div><br>
                      <div class="row">
                        <div class="col-md-12 table-responsive" style="max-height: 450px; overflow: auto;">
                          <table class="table table-bordered table-menu">
                            <tr>
                              <th style="width: 10px">#</th>
                              <th>Menu Note</th>
                              <th>Menu Location</th>
                            </tr>
                            <?php
                              foreach ($content['menu'] as $row => $list) { ?>
                                <tr>
                                  <td>
                                    <input type="checkbox" id="menu<?php echo $list['MenuID'];?>" name="menu[]" value="<?php echo $list['MenuID'];?>">
                                  </td>
                                  <td>
                                    <?php echo str_replace('.', '-- ', preg_replace("/[^.]/","",$list['MenuID']) );?>
                                    <?php echo $list['MenuNote'];?>
                                  </td>
                                  <td><?php echo $list['MenuLocation'];?></td>
                                </tr>
                            <?php } ?>
                          </table>
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
        <a href="#" id="adddivision" class="btn btn-primary btn-xs adddivision" data-toggle="modal" data-target="#scrollmodal"><b>+</b> Add User Menu</a><br>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
            <tr>
              <th>ID</th>
              <th>Nama Contact</th>
              <th>Job Code</th>
              <th>Menu ID</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (isset($content['listmenu'])) {
              foreach ($content['listmenu'] as $row => $list2) { ?>
                <tr>
                  <td><?php echo $list2['UserAccountID'];?></td>
                  <td><?php echo $list2['fullname'];?></td>
                  <td><?php echo $list2['jobcode'];?></td>
                  <td class="DTbreakWord"><?php echo $list2['menu'];?></td>
                  <td><a href="#" id="edit" class="btn btn-success btn-xs edit" style="margin: 0px;" data-toggle="modal" data-target="#scrollmodal"><i class="fa fa-fw fa-edit"></i></a></td>
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
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
  
  th_filter_hidden = [0,4]
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
      "targets": 4,
      "orderable": false
    } ],
    "order": [[ 0, "asc" ]]
  });

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  };
  $('#dt_list').resize(cek_dt);

  $(".adddivision").click(function(){
    $(".form-adddivision").slideDown();
    $(".form-editdivision").slideUp();
  });
  $('.edit').live('click',function(e){
    $( ".form-adddivision" ).slideUp();
    $( ".form-editdivision" ).slideDown();
    $('input:checkbox').attr('checked',false);
    var
    par   = $(this).parent().parent();
    id    = par.find("td:nth-child(1)").html();
    name  = par.find("td:nth-child(2)").html();
    menu  = par.find("td:nth-child(4)").html();
    $("#id2").val(id);
    $("#name2").val(name);
    if (menu != "") {
      menu = menu.split(', ');
      for (var i = menu.length-1 ; i >= 0; i--) {
        menunew = menu[i].split('.').join("");
        $("input[id='menu"+menu[i]+"']").attr('checked', true);
        // console.log(menu[i]);
      } 
    }
  });
  $('#name').live('change',function(e){
      $("#id").val($(this).val());
  })
});
</script>