<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css"> 
  .form-addBrand, .form-editBrand {
    display: none;
  }
  input.code { text-transform: uppercase; }
</style>

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
        <a href="#" id="tr-filter" class="btn btn-primary btn-xs tr-filter"><i class="fa fa-search"></i> Filter by Column</a>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
            <tr>
              <th id="order" class=" alignCenter">NO</th>
              <th class=" alignCenter">ID</th>
              <th class=" alignCenter">Product Name</th>
              <th class=" alignCenter">Market Place</th>
              <th class=" alignCenter">Last Check</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
                // echo count($content);
                $no = 0;
                foreach ($content as $row => $list) { $no++; ?>
                  <tr>
                    <td class=" alignCenter"><?php echo $no;?></td>
                    <td class=" alignCenter"><?php echo $list['ProductID'];?></td>
                    <td><?php echo $list['ProductName'];?></td>
                    <td><?php echo $list['ShopName'];?></td>
                    <td><?php echo $list['CheckDate'];?></td>
                    <td>
                      <?php if($list['LinkText']==""){ }else{?>
                        <a href="<?php echo $list['LinkText'];?>" class="btn btn-primary btn-xs" style="margin: 0px;" target="_blank" title="OPEN LINK"><i class="fa fa-fw fa-link"></i></a>
                        <?php if($list['CheckDate']==""){?>
                        <a title="APPROVE LINK" href="#" id="approve" class="btn btn-success btn-xs approve" style="margin: 0px;" OrderID="<?php echo $list['OrderID'];?>"><i class="fa fa-fw fa-check-square"></i></a>
                        <?php } ?>
                        <a title="REJECT LINK" href="#" id="reject" class="btn btn-danger btn-xs reject" style="margin: 0px;" OrderID="<?php echo $list['OrderID'];?>"><i class="fa fa-fw fa-minus-square"></i></a>
                      <?php } ?>
                    </td>
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
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
jQuery( document ).ready(function( $ ) {

	th_filter_hidden = [0]
  $('#dt_list thead tr').clone(true).appendTo( '#dt_list thead' );
  $('#dt_list thead tr:eq(0)').addClass('tr-filter-column')
  $('#dt_list thead tr:eq(0) th').each( function (i) {
    if (th_filter_hidden.indexOf(i) < 0) {
      var title = $(this).text();
      $(this).html( '<input type="text" class="input-filter-column input input-sm" placeholder="Search '+title+'" />' );

      $( 'input', this ).on( 'keyup change', function () {
          if ( table.column(i).search() !== this.value ) {
              table
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

  table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "columnDefs": [ {
      "targets": 5,
      "orderable": false
    } ],
    "order": [[ 0, "asc" ]]
  });

  var cek_dt = function() {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };

  $('#dt_list').resize(cek_dt);

  $('#approve').live('click',function(e){
    var
      user = $(this).attr('data');
      OrderID = $(this).attr('OrderID');
      par  = $(this).parent().parent();
      data = {user:user, OrderID:OrderID};
      $.ajax({
        url: "<?php echo base_url();?>master/product_link_list_act/approve",
        type : 'POST',
        data : data,
        success : function (response) {
          window.location.href = "<?php echo current_url(); ?>";
        }
      })
  });
  $('#reject').live('click',function(e){
    var
      user = $(this).attr('data');
      OrderID = $(this).attr('OrderID');
      par  = $(this).parent().parent();
      data = {user:user, OrderID:OrderID, };
      errornote  = "This Link will be Reject!\nare you sure?"
      var r = confirm(errornote);
      if (r == false) {
        e.preventDefault();
        return false
      } else {
        $.ajax({
          url: "<?php echo base_url();?>master/product_link_list_act/reject",
          type : 'POST',
          data : data,
          success : function (response) {
            window.location.href = "<?php echo current_url(); ?>";
          }
        })
      }
  });
});
</script>