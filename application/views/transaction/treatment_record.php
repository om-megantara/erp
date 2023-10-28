<link rel="stylesheet" href="<?php echo base_url();?>assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/adminlte/plugins/daterangepicker/daterangepicker.css">
<style type="text/css">
  @media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 100px;
      padding: 5px;
    }
    .form-group span.left2 {
      display: block;
      overflow: hidden;
    }
    .form-group { margin-bottom: 10px; }
  }
  .btn { margin-left: 5px; }
</style>
 
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><?php echo $PageTitle; ?></h1>
      </div> 
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="">
            <a href="<?php echo base_url();?>transaction/treatment_record_add" target="_blank" class="btn btn-xs btn-info">Add Treatment Record</a>
          </li>
          <li class="">
            <a href="#" id="showFilter" class="btn btn-info btn-xs showFilter" title="FILTER"><i class="fa fa-search"></i> Filter</a>
          </li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="row">
    <div class="col-12">  
      <div class="card card-filter" style="display: none;">
        <div class="card-header">FILTER</div> 
        <div class="card-body">
          <form role="form" action="<?php echo current_url();?>" method="post" >
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label class="left">Date Filter</label>
                <span class=" left2">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control float-right" id="DateFilter" name="DateFilter" required="">
                  </div>
                </span>
              </div> 
            </div> 
            <div class="col-sm-6">
                <button type="submit" class="btn btn-info btn-sm pull-left">Submit</button>
            </div>
          </div>
          </form>
        </div>        
      </div> 

      <div class="card">
        <div class="card-body">
          <table id="dt_list" class="table table-bordered">
            <thead>
              <tr>
                <th>Treatment Record ID</th>
                <th>Sales Order ID</th>
                <th>Treatment Name</th>
                <th>Customer Name</th>
                <th>Note</th>
                <th>Date</th>
                <th>By</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
                if (isset($content)) {
                  foreach ($content as $row => $list) { ?>
                    <tr>
                      <td><?php echo $list['TreatmentRecordID'];?></td>
                      <td class="alignCenter"><?php echo $list['SalesOrderID'];?></td>
                      <td><?php echo $list['TreatmentName'];?></td>
                      <td><?php echo $list['CustomerName'];?></td>
                      <td><?php echo $list['TreatmentRecordNote'];?></td>
                      <td><?php echo $list['InputDate'];?></td>
                      <td><?php echo $list['UserFullName'];?></td>
                      <td>
                        <button type="button" class="btn btn-success btn-xs btnEditRecord" TreatmentRecordID="<?php echo $list['TreatmentRecordID'];?>" title="EDIT" onclick="location.href='<?php echo base_url();?>transaction/treatment_record_edit?TreatmentRecordID=<?php echo $list['TreatmentRecordID']; ?>';"><i class="fa fa-fw fa-edit"></i></button>
                      </td>
                    </tr>
              <?php } } ?> 
            </tbody> 
          </table>
        </div>        
      </div>      
    </div>    
  </div>  
</section>

<script src="<?php echo base_url();?>assets/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/adminlte/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="<?php echo base_url();?>assets/adminlte/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url();?>assets/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<script type="text/javascript">
jQuery( document ).ready(function( $ ) {
  $(function () {
    $('#DateFilter').daterangepicker({ 
      locale: {
        format: 'YYYY-MM-DD'
      }
    });
    $('#dt_list').DataTable();
  });
});
  
$(".showFilter").click(function(){
  $(".card-filter").slideToggle();
});
</script>