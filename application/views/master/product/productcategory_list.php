<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css"> 
  .form-addproduct_category, .form-editproduct_atribute {
    display: none;
    background-color: white;
  }
  .category, .category2 {margin-top: 2px;}
  #divhideshow { 
    display: none; 
    margin: 10px; 
    border: 1px solid #0073b7; 
    padding: 5px;
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
    .form-group { margin-bottom: 10px; }
  }
</style>

<div class="content-wrapper">

<!-- POP UP -->
<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              
              <!-- form add data -->
              <div class="col-md-12 form-addproduct_category with-border">
                <form role="form" action="<?php echo base_url();?>master/productcategory_add" method="post" >
                  <div class="box box-solid ">
                    <div class="box-header">
                      <h3 class="box-title">Add Product Category</h3>
                      <button type="submit" class="btn btn-primary btn-sm pull-right">Submit</button>
                    </div>
                    <div class="col-md-6">
                      <div class="box-body">
                        <div class="form-group">
                          <label>Product Category Name</label>
                          <input type="text" class="form-control input-sm" placeholder="Product Category Name" autocomplete="off" name="name" id="name">
                        </div>
                        <div class="form-group">
                          <label>Product Category Code</label>
                          <input type="text" class="form-control input-sm code" placeholder="Product Category Code" autocomplete="off" name="code" id="code" onkeyup="this.value = this.value.toUpperCase();">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="box-body">
                        <div class="form-group">
                          <label>Product Category Parent</label>
                          <select class="form-control input-sm" name="parent" id="parent">
                            <option value="0" >---TOP---</option>
                            <?php foreach ($content2 as $row => $list) { ?>
                              <option value="<?php echo $list['ProductCategoryID'];?>"><?php echo $list['ProductCategoryName'];?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>Product Atribute Set </label>
                          <select class="form-control input-sm" name="productatributeset" id="productatributeset">
                            <option value="0">--TOP--</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>Description</label>
                          <textarea class="form-control" rows="3" placeholder="Description" name="description" id="description"></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <!-- end form -->

              <!-- form edit data -->
              <div class="col-md-12 form-editproduct_atribute with-border">
                <form role="form" action="<?php echo base_url();?>master/productcategory_edit" method="post" >
                  <div class="box box-solid ">
                    <div class="box-header">
                      <h3 class="box-title">Edit Product Category</h3>
                      <button type="submit" class="btn btn-primary pull-right">Submit</button>
                    </div>
                    <div class="col-md-6">
                      <div class="box-body">
                        <div class="form-group">
                          <label>ID</label>
                          <input type="text" class="form-control input-sm" placeholder="Product Category ID" autocomplete="off" name="id" id="id" readonly="">
                        </div>
                        <div class="form-group">
                          <label>Product Category Name</label>
                          <input type="text" class="form-control input-sm" placeholder="Product Category Name" autocomplete="off" name="name2" id="name2">
                        </div>
                        <div class="form-group">
                          <label>Product Category Code</label>
                          <input type="text" class="form-control input-sm code" placeholder="Product Category Code" autocomplete="off" name="code2" id="code2" onkeyup="this.value = this.value.toUpperCase();">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="box-body">
                        <div class="form-group">
                          <label>Product Category Parent</label>
                          <select class="form-control input-sm" name="parent2" id="parent2">
                            <option value="0" >---TOP---</option>
                            <?php foreach ($content2 as $row => $list) { ?>
                              <option value="<?php echo $list['ProductCategoryID'];?>"><?php echo $list['ProductCategoryName'];?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>Product Atribute Set </label>
                          <select class="form-control input-sm" name="productatributeset2" id="productatributeset2">
                            <option value="0">--TOP--</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>Description</label>
                          <textarea class="form-control" rows="3" placeholder="Description" name="description2" id="description2"></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <!-- end form -->
              
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- END POP UP -->

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
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT"><i class="fa fa-fw fa-print"></i> Print</button>
        <a href="#" id="addproduct_category" class="btn btn-primary btn-xs addproduct_category" title="ADD PRODUCT CATEGORY" data-toggle="modal" data-target="#scrollmodal"><b>+</b> Add Product Category</a>
        <a href="#" id="tr-filter" class="btn btn-primary btn-xs tr-filter"><i class="fa fa-search"></i> Filter by Column</a>
        <a href="#" id="hideshow" class="btn btn-primary btn-xs hideshow" title="HIDE/SHOW COLUMN">Hide/Show column</a>
        <div id="divhideshow">
          Hide/Show Column :
          <a class="btn btn-primary btn-xs toggle-vis" data-column="7" title="NAME FORMULA">Name Formula</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="8" title="CODE FORMULA">Code Formula</a>
        </div>
        <br>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
            <tr>
              <th id="order" class=" alignCenter">No</th>
              <th class=" alignCenter">ID</th>
              <th class=" alignCenter">Name</th>
              <th class=" alignCenter">Code</th>
              <th class=" alignCenter">Parent</th>
              <th class=" alignCenter">Atribute Set</th>
              <th></th>
              <th class=" alignCenter">Name Formula</th>
              <th class=" alignCenter">Code Formula</th>
            </tr>
            </thead>
            <tbody>
            <?php
              // echo count($content);
              $no = 0;
              foreach ($content as $row => $list) { $no++; ?>
                <tr>
                  <td><?php echo $no;?></td>
                  <td><?php echo $list['ProductCategoryID'];?></td>
                  <td><?php echo $list['ProductCategoryName'];?></td>
                  <td><?php echo $list['ProductCategoryCode'];?></td>
                  <td><?php echo $list['ProductCategoryParent'];?></td>
                  <td><?php echo $list['ProductAtributeSetName'];?></td>
                  <td>
                    <a href="#" id="edit" class="btn btn-primary btn-xs edit" style="margin: 0px;" title="EDIT" data-toggle="modal" data-target="#scrollmodal"><i class="fa fa-edit"></i></a>
                    <a href="<?php echo base_url();?>master/productnamingformula/<?php echo $list['ProductCategoryID'];?>" id="naming" class="btn btn-primary btn-xs naming" style="margin: 0px;" title="NAMING FORMULA" target="_BLANK"><i class="fa fa-edit"></i></a>

                    <?php if ($list['ProductNameFormula'] != "") { ?>
                      <a href="#" class="btn btn-primary btn-xs formula" style="margin: 0px;" title="NAME FORMULA"><i class="fa fa-fw fa-buysellads"></i></a>
                    <?php }
                    if ($list['ProductCodeFormula'] != "") { ?>
                      <a href="#" class="btn btn-primary btn-xs formula" style="margin: 0px;" title="CODE FORMULA"><i class="fa fa-fw  fa-stumbleupon"></i></a>
                    <?php } ?>

                  </td>
                  <td><?php echo $list['ProductNameFormula'];?></td>
                  <td><?php echo $list['ProductCodeFormula'];?></td>
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

	th_filter_hidden = [0,1,3,5,6,7,8]
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

  fill_atribute_set();
  table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "columnDefs": [ {
      "targets": 6,
      "orderable": false
    } ],
    "order": [[ 0, "asc" ]],
    // "aaSorting": []
  });

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

  $('a.toggle-vis').on( 'click', function (e) {
      e.preventDefault();
      var column = table.column( $(this).attr('data-column') );
      column.visible( ! column.visible() );
      table.columns.adjust().draw();
  } );

  setTimeout( function order() {
    $('a[data-column="7"]').click();
    $('a[data-column="8"]').click();
  }, 100) //force to order and fix header width

  $(".addproduct_category").click(function(){
    $(".form-addproduct_category").slideDown();
    $(".form-editproduct_atribute").slideUp();
  });
  $('.edit').live('click',function(e){
    var
    par   = $(this).parent().parent();
    id    = par.find("td:nth-child(2)").html();
    $.ajax({
      url: '<?php echo base_url();?>master/get_category_detail',
      type: 'post',
      data: {id:id},
      dataType: 'json',
      success:function(response){
        var ProductCategoryID = response[0]['ProductCategoryID'];
        var ProductCategoryName = response[0]['ProductCategoryName'];
        var ProductCategoryCode = response[0]['ProductCategoryCode'];
        var ProductCategoryParent = response[0]['ProductCategoryParent'];
        var ProductCategoryDescription = response[0]['ProductCategoryDescription'];
        var ProductAtributeSetID = response[0]['ProductAtributeSetID'];
        $("#id").val(ProductCategoryID);
        $("#name2").val(ProductCategoryName);
        $("#code2").val(ProductCategoryCode);
        $("#description2").val(ProductCategoryDescription);
        $("select#parent2").val(ProductCategoryParent);
        $("select#productatributeset2").val(ProductAtributeSetID);
      }
    });
    $( ".form-addproduct_category" ).slideUp();
    $( ".form-editproduct_atribute" ).slideDown();
  });
});
$('button.print_dt').on('click', function() {               
      var fvData = table.rows({ search:'applied', page: 'all' }).data(); 
      $('.div_dt_print').empty().append(
         '<table id="dtTablePrint" class="col">' +
         '<thead>'+
         '<tr>'+
            $.map(table.columns().visible(),
                function(colvisible, colindex){
                   return (colvisible) ? "<th>" + $(table.column(colindex).header()).html() + "</th>" : null;
             }).join("") +
         '</tr>'+
         '</thead>'+
         '<tbody>' +
            $.map(fvData, function(rowdata, rowindex){
               return "<tr>" + $.map(table.columns().visible(),
                  function(colvisible, colindex){
                     return (colvisible) ? "<td class='col"+colindex+"'>" + $('<div/>').text(rowdata[colindex]).text() + "</td>" : null;
                  }).join("") + "</tr>";
            }).join("") +
         '</tbody>' +
         '<tfoot>' +
         '<tr>'+
            $.map(table.columns().visible(),
                function(colvisible, colindex){
                   return (colvisible) ? "<th>" + $(table.column(colindex).footer()).html() + "</th>" : null;
             }).join("") +
         '</tr>'+
         '</tfoot></table>'
      );

      for (var i = 0; i < $('button.print_dt').attr('removeTd'); i++) {
        $("#dtTablePrint th:last-child, #dtTablePrint td:last-child").remove();
      }

      var w = window.open();
      var html = $(".div_dt_print").html();
      $(w.document.body).append('<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">');
      $(w.document.body).append("<link href='<?php echo base_url();?>tool/dtPrint.css' rel='stylesheet' type='text/css' />");
      $(w.document.body).append(html);
});
$("#hideshow").click(function(){
  $("#divhideshow").slideToggle();
});

function fill_atribute_set() {
  $.ajax({
      url: '<?php echo base_url();?>master/fill_atribute_set',
      type: 'post',
      dataType: 'json',
      success:function(response){
        var len = response.length;
        for( var i = 0; i<len; i++){
            var ProductAtributeSetID = response[i]['ProductAtributeSetID'];
            var ProductAtributeSetName = response[i]['ProductAtributeSetName'];
            $("#productatributeset").append("<option value='"+ProductAtributeSetID+"'>"+ProductAtributeSetName+"</option>");
            $("#productatributeset2").append("<option value='"+ProductAtributeSetID+"'>"+ProductAtributeSetName+"</option>");
        }
      }
  });
}
</script>