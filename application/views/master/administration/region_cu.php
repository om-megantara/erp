<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">

<style type="text/css">
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

<?php 
// print_r($region_detail); 
if (isset($region_detail['main'])) {
  $main = $region_detail['main'];
}
?>
<div class="content-wrapper">
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
      </div>
      <div class="box-body form_add">
        <form name="form" id="form" action="<?php echo base_url();?>master/region_cu_act" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <div class="box box-solid">
              <div class="box-body">
                <?php if (isset($main)) { ?>
                  <div class="form-group">
                    <label class="left">Region ID</label>
                    <span class="left2">
                      <input type="text" class="form-control input-sm" autocomplete="off" name="regionid" id="regionid" readonly="" required="" value="<?php echo $main['RegionID']; ?>">
                    </span>
                  </div>
                <?php }; ?>
                <div class="form-group">
                  <label class="left">Region Name</label>
                  <span class="left2">
                    <input type="text" class="form-control input-sm" placeholder="Region Name" autocomplete="off" name="regionname" id="regionname" required="">
                  </span>
                </div>
                <div class="form-group">
                  <label class="left">Region Code</label>
                  <span class="left2">
                    <input type="text" class="form-control input-sm" placeholder="Region Code" autocomplete="off" name="regioncode" id="regioncode" required="">
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="box box-solid">
              <div class="box-body">
                <div class="form-group">
                  <label class="left">SEC</label>
                  <span class="left2">
                    <select class="form-control input-sm" name="sec" id="sec">
                      <?php foreach ($region_detail['sales'] as $row => $list) { ?>
                        <option value="<?php echo $list['SalesID'];?>"><?php echo $list['fullname'];?></option>
                      <?php } ?>
                    </select>
                  </span>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-primary" id="open_popup_city" title="ADD">Add</button>
                      <button type="button" class="btn btn-danger" id="clear_city" title="REMOVE ALL">Remove All</button>
                    </div>
                    <input type="text" class="form-control" readonly value="Search City">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="box-body table-responsive no-padding">
              <table id="dt_list" class="table table-bordered table-hover nowrap table-city" width="100%">
                <thead>
                  <tr>
                    <th class=" alignCenter">ID</th>
                    <th class=" alignCenter">Name</th>
                    <th class=" alignCenter">Abbreviation</th>
                    <th class=" alignCenter">Detail</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
          <div class="col-md-12">
            <div class="box-footer" style="text-align: center;">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
      </div>
      <div class="box-footer">
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
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
$( document ).ready(function( $ ) {
  $('.select2').select2();
   
  if ($("#regionid").length != 0) {
    $("#form #regionname").val('<?php if ( isset($main)){ echo $main['RegionName']; }?>');
    $("#form #regioncode").val('<?php if ( isset($main)){ echo $main['RegionCode']; }?>');
    $("#form #sec").val('<?php if ( isset($main)){ echo $main['SEC']; }?>').trigger('change');
  }
});

var popup;
function openPopupOneAtATime() {
    if (popup && !popup.closed) {
       popup.focus();
    } else {
       popup = window.open('<?php echo base_url();?>master/city_list_popup', '_blank', 'width=700,height=500,left=200,top=100');     
    }
}
$("#open_popup_city").on('click', function() {
  openPopupOneAtATime();
});

function buildcurlist() {
  curlist = []
  par = $(".cityid")
  for (var i = 0; i < par.length; i++) {
    curlist.push($(par[i]).val())
  }
}
$(".removecity").live('click', function() {
  par   = $(this).parent().parent();
  item  = par.find($(".cityid")).val();
  index = curlist.indexOf(item);
  if (index !== -1) curlist.splice(index, 1);
  
  table.row( $(this).parents('tr') ).remove().draw();
});
$("#clear_city").live('click', function() {
  table.clear().draw();
});
</script>

<script src="<?php echo base_url();?>tool/jquery11.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
j11 = $.noConflict(true);
var region_detail = [];
var table
j11( document ).ready(function( $ ) {
  table = $('#dt_list').DataTable({
    // "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    // "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
    "scrollX": true,
     "scrollY": true,
    "order": [[ 1, "asc" ]],
  })
  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  };
  $('#dt_list').resize(cek_dt);

  if ($("#regionid").length != 0) {
    region_detail = $.parseJSON('<?php if ( isset($region_detail['city2'])){ echo $region_detail['city2']; }?>');
    for( var i = 0; i<region_detail.length; i++){
        addrow(region_detail[i]['CityID'], region_detail[i]['CityName'], region_detail[i]['CityAbbreviation'], region_detail[i]['StateName']+", "+region_detail[i]['ProvinceName'])
    }
  }
  
  $('#form').on('submit', function(e){
      var form = this;
      var params = table.$('input,select,textarea').serializeArray();
      $.each(params, function(){
         if(!$.contains(document, form[this.name])){
            $(form).append(
               $('<input>')
                  .attr('type', 'hidden')
                  .attr('name', this.name)
                  .val(this.value)
            );
         }
      });
   });
});

function addrow(tdid,tdname,tdabbreviation,tddetail) {
  table.row.add([
    "<input type='hidden' name='cityid[]' class='cityid' value='"+tdid+"'>"+tdid,
    tdname,
    tdabbreviation,
    tddetail,
    "<button type='button' class='btn btn-danger btn-xs removecity'><i class='fa fa-remove'></i></button>"
  ]).draw(false);
}

var curlist = []
function ProcessChildMessage(message) {
  // console.log(message)
  buildcurlist()
  // console.log(curlist)
  if (typeof message !== 'undefined' && message.length > 0) {
    for( var i = 0; i<message.length; i++){
      if ($.inArray(message[i]['tdid'], curlist) < 0) { 
        addrow(message[i]['tdid'], message[i]['tdname'], message[i]['tdabbreviation'], message[i]['tddetail'])
      }
    }
  }
}

</script>