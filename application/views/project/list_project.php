<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">
  @media (min-width: 768px){
      .form-group label.left {
        float: left;
        width: 130px;
      }
      .form-group span.left2 {
        display: block;
        overflow: hidden;
      }
      .form-group { margin-bottom: 5px; }
  }
</style>
<div class="content-wrapper">
  <div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">SO PROJECT DETAIL</h4>
          </div>
          <div class="modal-body">
            <div class="detailcontentAjax" id="detailcontent" style="background-color: white;">
            </div>
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
        <button type="button" class="btn btn-primary btn-xs" onclick="window.open('<?php echo base_url();?>development/project_add', '_blank');" title='ADD PROJECT'><b>+</b> Add Project</button>
        <a href="#" id="tr-filter" class="btn btn-primary btn-xs tr-filter"><i class="fa fa-search"></i> Filter by Column</a>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
              <tr>
                <th>Project Code</th>
                <th>Customer</th>
                <th>Project Name</th>
                <th>City</th>
                <th>Project Input</th>
                <th>Technical Draw</th>
                <th>Letter of Offer</th>
                <th>Floor Plan</th>
                <th>Sample</th>
                <th>Our Technical Draw</th>
                <th>Project CLosed</th>
                <th>Note</th>
                <th>Edit</th>
                <th>Action</th>
            </thead>
            <tbody>
            <?php
              if (isset($content)) {
                foreach ($content as $row => $list) { 
            ?>
                <tr>
                  <td><?php echo $list['ProjectID'];?></td>
                  <td><?php echo $list['customer'];?></td>
                  <td><?php echo $list['ProjectName'];?></td>
                  <td><?php echo $list['City'];?></td>
                  <td><?php echo $list['ProjectInput']; ?></td>
                  <td><?php echo $list['CustomerDrawingDate']."  "; ?><?php if($list['CustomerDrawing']==1){ echo '<i class="fa  fa-check-square" style="color:#00a65a"></i>'; }?></td>
                  <td><?php echo $list['LetterDate']."  "; ?><?php if($list['Letter']==1){ echo '<i class="fa  fa-check-square" style="color:#00a65a"></i>'; }?></td>
                  <td><?php echo $list['FloorDate']."  "; ?><?php if($list['Floor']==1){ echo '<i class="fa  fa-check-square" style="color:#00a65a"></i>'; }?></td>
                  <td><?php echo $list['SampleDate']."  "; ?><?php if($list['Sample']==1){ echo '<i class="fa  fa-check-square" style="color:#00a65a"></i>'; }?></td>
                  <td><?php echo $list['OurTechnicalDate']."  "; ?><?php if($list['OurTechnical']==1){ echo '<i class="fa  fa-check-square" style="color:#00a65a"></i>'; }?></td>
                  <td><?php echo $list['ProjectClosed'];?></td>
                  <td><?php echo $list['Note'];?></td>
                  <td>
                    <!-- <button type="button" class="btn btn-primary btn-xs detail" Title="SO Detail" id="<?php echo $list['CustomerID']; ?>" data-toggle="modal" data-target="#modal-detail" ><i class="fa fa-ship"></i></button> -->
                    <?php if($list['Status']=="0" || $list['Status']==""){ ?><a href="<?php echo base_url();?>development/project_edit?ProjectID=<?php echo $list['ProjectID'];?>" target='_blank' class="btn btn btn-xs" Title="Edit"><i class="fa fa-edit"></i>Edit</a>
                    <?php } ?>
                  </td>                  
                  <td>
                    <?php if($list['CustomerDrawingLink']!==""){ ?><a href="<?php echo $list['CustomerDrawingLink'];?>" target='_blank' class="btn btn-primary btn-xs" Title="Customer Technical Drawing"><i class="fa fa-fw fa-link"></i></a> <?php }?> 
                    <?php if($list['LetterLink']!==""){ ?><a href="<?php echo $list['LetterLink'];?>" target='_blank' class="btn btn-success btn-xs" Title="Letter Of Offer"><i class="fa fa-fw fa-link"></i></a> <?php }?>
                    <?php if($list['FloorLink']!==""){ ?><a href="<?php echo $list['FloorLink'];?>" target='_blank' class="btn btn-warning btn-xs" Title="Custommer Floor Plan"><i class="fa fa-fw fa-link"></i></a> <?php }?>
                    <?php if($list['SampleLink']!==""){ ?><a href="<?php echo $list['SampleLink'];?>" target='_blank' class="btn btn-info btn-xs" Title="Sample"><i class="fa fa-fw fa-link"></i></a> <?php }?>
                    <?php if(!empty($list['OurTechnical'])){?><a href="<?php echo $list['OurTechnicalLink'];?>" target='_blank' class="btn btn-danger btn-xs" Title="Our Technical Drawing"><i class="fa fa-fw fa-link"></i></a> <?php }?>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
	th_filter_hidden = [0,3,4,5,6,7,8,9,10,11,12,13]
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
    "searchDelay": 2000,
    "processing": true, 
    "language": { processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '}, 
  });
  $('.detail').live('click', function(e){
        document.getElementById("detailcontent").innerHTML='<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
        id  = $(this).attr("id")
        datestart  = $(this).attr("datestart")
        dateend  = $(this).attr("dateend")
        get(id, datestart, dateend);
  }); 
  function get(id) {
    xmlHttp=GetXmlHttpObject()
      var url="<?php echo base_url();?>development/project_so_detail"
      url=url+"?id="+id
      alert(url);
      xmlHttp.onreadystatechange=stateChanged
      xmlHttp.open("GET",url,true)
      xmlHttp.send(null)
  }
  function stateChanged(){
      if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
          document.getElementById("detailcontent").innerHTML=xmlHttp.responseText
      }
  }
  f
  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

  $('.customer').select2({
    placeholder: 'Minimum 3 char, Company',
    minimumInputLength: 3,
    ajax: {
      url: '<?php echo base_url();?>general/search_customer_having_sales',
      dataType: 'json',
      delay: 1000,
      processResults: function (data) {
        return {
          results: data
        };
      },
      cache: true
    }
  });
});

$(document).ready(function(){
  $(".closeProject").click(function(){
    ProjectID = $(this).attr('ProjectID')
    errornote  = "This Project will be closed!\nare you sure?"
    var r = confirm(errornote);
    if (r == false) {
      e.preventDefault();
      return false
    } else {
      location.href = '<?php echo base_url();?>development/project_close?ProjectID='+ProjectID;
    }
  });
});

</script>