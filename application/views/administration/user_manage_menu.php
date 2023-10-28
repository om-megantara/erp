<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
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
      width: 100px;
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
                
                <div class="col-md-12 form-addjoblevel with-border">
                  <form role="form" action="<?php echo base_url();?>administration/menu_add" method="post" >
                    <div class="box box-solid ">
                      <div class="box-header">
                        <h3 class="box-title">Add Manage Menu</h3>
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                      </div>
                      <div class="box-body">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="left">ID</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="ID Menu" autocomplete="off" name="id" id="id">
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Name</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="Name Menu" autocomplete="off" name="name" id="name">
                            </span>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="left">Note</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="Note Menu" autocomplete="off" name="note" id="note">
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Parent</label>
                            <span class="left2">
                              <select class="form-control input-sm" name="parent" id="parent" required="">
                                <option value='0' selected>On TOP</option>
                                <?php foreach ($content as $row => $list) { ?>
                                <option value='<?php echo $list['MenuID'];?>'><?php echo $list['MenuID'].'-'.$list['MenuName'];?></option>
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
                  <form role="form" action="<?php echo base_url();?>administration/menu_edit" method="post" >
                    <div class="box box-solid ">
                      <div class="box-header">
                        <h3 class="box-title">Edit Menu</h3>
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                      </div>
                      <div class="box-body">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="left">ID</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="ID Menu" autocomplete="off" name="id" id="id2" readonly>
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Name</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="Name Menu" autocomplete="off" name="name" id="name2" readonly="">
                            </span>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="left">Note</label>
                            <span class="left2">
                              <input type="text" class="form-control input-sm" placeholder="Note Menu" autocomplete="off" name="note" id="note2">
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
        <a href="#" id="addjoblevel" class="btn btn-primary btn-xs addjoblevel" data-toggle="modal" data-target="#scrollmodal"><b>+</b> Add Manage Menu</a>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Note</th>
                <th>Parent</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            <?php
                foreach ($content as $row => $list) { 
                  $MenuParent = ($list['MenuParent'] != 0) ? $content[$list['MenuParent']]['MenuID'].'-'.$content[$list['MenuParent']]['MenuName'] : '';
            ?>
                  <tr>
                    <td><?php echo $list['MenuID'];?></td>
                    <td><?php echo $list['MenuName'];?></td>
                    <td><?php echo $list['MenuNote'];?></td>
                    <td><?php echo $MenuParent;?></td>
                    <td><a href="#" id="edit" class="btn btn-success btn-xs edit" style="margin: 0px;" data-toggle="modal" data-target="#scrollmodal"><i class="fa fa-fw fa-edit"></i></a></td>
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
	
  th_filter_hidden = [0,3,4]
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
    "order": []
  });

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  };
  $('#dt_list').resize(cek_dt);

  $(".addjoblevel").click(function(){
    $(".form-addjoblevel").slideDown();
    $(".form-editjoblevel").slideUp();
  });
  $('.edit').live('click',function(e){
    $( ".form-addjoblevel" ).slideUp();
    $( ".form-editjoblevel" ).slideDown();
      var
      par   = $(this).parent().parent();
      id    = par.find("td:nth-child(1)").html();
      name  = par.find("td:nth-child(2)").html();
      note  = par.find("td:nth-child(3)").html();
      // loc  = par.find("td:nth-child(4)").text();
      // alert(loc);
      $("#id2").val(id);
      $("#name2").val(name);
      $("#note2").val(note);
      // $("#location2").val(loc);
  });
});
</script>