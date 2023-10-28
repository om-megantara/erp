<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css"> 
  .toggle-vis {
    background-color: #0073b7;
    color: white;
    padding: 1px 3px;
    text-align: center;
    text-decoration: none;
    font-size: 12px;
    font-weight: bold;
    cursor: pointer;
  }
  #divhideshow { display: none; margin-left: 10px; border: 1px solid #0073b7; padding: 5px;}
</style>

<?php
// print_r($content['fullbrand']);
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <?php echo $PageTitle.' - '. $MainTitle; ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank" title="HELP"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>

  <section class="content">
    <div class="box box-solid">
      <div class="box-header">

        <a href="<?php echo base_url();?>master/product_add" id="addProduct" class="addProduct" target="_blank"><b>+</b> Add Product</a>
        <a href="#" id="hideshow" class="btn btn-primary btn-xs hideshow">Hide/Show column</a>
        <a href="#" id="batch_formula" class="btn btn-primary btn-xs check">Batch Edit Formula</a>
        <a href="#" id="batch_detail" class="btn btn-primary btn-xs check">Batch Edit Detail</a>

        <div id="divhideshow">
          Hide/Show column :
          <a class="btn btn-primary btn-xs toggle-vis" data-column="1">ID</a> 
          <a class="btn btn-primary btn-xs toggle-vis" data-column="2">Name</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="3">Code</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="4">Price</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="5">Quality</a>
          <!-- <a class="btn btn-primary btn-xs toggle-vis" data-column="6">Category</a> -->
          <a class="btn btn-primary btn-xs toggle-vis" data-column="7">Brand</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="8">Documentation</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="9">Min Stock</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="10">Max Stock</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="13">Full Brand</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="14">Full Category</a>
        </div>

      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
          <thead>
            <tr>
              <th><input name="select_all" id="select_all" value="1" type="checkbox"></th>
              <th id="order">ID</th>
              <th>Name</th>
              <th>Code</th>
              <th>Price</th>
              <th>Quality</th>
              <th>Category</th>
              <th>Brand</th>
              <th>Documentation</th>
              <th>Min Stock</th>
              <th>Max Stock</th>
              <th>Status</th>
              <th>Action</th>
              <th>Full Brand</th>
              <th>Full Category</th>
            </tr>
          </thead>
          <tbody>
            <?php
              if (isset($content['main'])) {
                foreach ($content['main'] as $row => $list) { ; 
            ?>
                <tr>
                  <td></td>
                  <td><?php echo $list['ProductID'];?></td>
                  <td><?php echo $list['ProductName'];?></td>
                  <td><?php echo $list['ProductCode'];?></td>
                  <td><?php echo number_format($list['ProductPriceDefault']);?></td>
                  <td><?php echo $list['ProductStatusName'];?></td>
                  <td><?php echo $list['ProductCategoryName'];?></td>
                  <td><?php echo $list['ProductBrandName'];?></td>
                  <td>
                    <?php if ( $list['ProductImage'] != "") { ?>
                    <a target="_blank" href="<?php echo base_url();?>" class="view" onclick="return new_window('<?php echo $list['ProductImage'];?>')" title="Image"><i class="fa fa-fw fa-file-image-o"></i></a>
                    <?php } ?>
                    <?php if ( $list['ProductDoc'] != "") { ?>
                      <a target="_blank" href="<?php echo base_url();?>" class="view" onclick="return new_window('<?php echo $list['ProductDoc'];?>')" title="PDF"><i class="fa fa-fw fa-file-pdf-o"></i></a>
                    <?php } ?>
                  </td>
                  <td><?php echo $list['MinStock'];?></td>
                  <td><?php echo $list['MaxStock'];?></td>
                  <td>
                    <?php if ($list['forSale'] == "1") { ?>
                      <a href="#" class="sale" style="margin: 0px;" title="For Sale"><i class="fa fa-fw fa-cart-plus"></i></a>
                    <?php } else { ?>
                      <a href="#" class="sale" style="margin: 0px; background-color: red;" title="Not For Sale"><i class="fa fa-fw fa-cart-plus"></i></a>
                    <?php } ?>

                    <?php if ($list['isActive'] == "1") { ?>
                      <a href="#" class="sale" style="margin: 0px;" title="Active"><i class="fa fa-fw fa-thumbs-o-up"></i></a>
                    <?php } else { ?>
                      <a href="#" class="sale" style="margin: 0px; background-color: red;" title="Not Active"><i class="fa fa-fw fa-thumbs-o-up"></i></a>
                    <?php } ?>

                    <?php if ($list['Stockable'] == "1") { ?>
                      <a href="#" class="sale" style="margin: 0px;" title="Stockable"><i class="fa fa-fw fa-hourglass"></i></a>
                    <?php } else { ?>
                      <a href="#" class="sale" style="margin: 0px; background-color: red;" title="Not Stockable"><i class="fa fa-fw  fa-hourglass-o"></i></a>
                    <?php } ?>
                  </td>
                  <td>
                    <a href="<?php echo base_url();?>master/product_add?id=<?php echo $list['ProductID'];?>" id="edit" class="edit view" style="margin: 0px;" target="_blank" title="EDIT"><i class="fa fa-fw fa-edit"></i></a>
                    <a href="#" class="dtbutton view" id="view_product" data-toggle="modal" data-target="#modal-product" title="VIEW"><i class="fa fa-fw fa-eye"></i></a>
                  </td>
                  <td><?php echo $content['fullbrand'][$list['ProductBrandID']]['ProductBrandName'];?></td>
                  <td><?php echo $content['fullcategory'][$list['ProductCategoryID']]['ProductCategoryName'];?></td>
                </tr>
            <?php } } ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="modal fade" id="modal-product">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Detail Product</h4>
          </div>
          <div class="modal-body" id="detailcontentAjax" style="background-color: white;">
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery11.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
var j11 = $.noConflict(true);
j11( document ).ready(function( $ ) {
   

  var rows_selected = []; // for adding checkbox
  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "order": [],
    "scrollX": true,
     "scrollY": true,
    "columnDefs": [ 
    {"targets": 11, "orderable": false, "width": "1%"},
    {"targets": 12, "orderable": false, "width": "1%"},
    {"targets": 1, "width": "1%"},
    
    // for adding checkbox
    {'targets': 0,
     'searchable': false,
     'orderable': false,
     'width': '1%',
     'className': 'dt-body-center',
     'render': function (data, type, full, meta){ return '<input type="checkbox">'; }
    }
    // ======================

    ],
    "aaSorting": [],

    // for adding checkbox
    "rowCallback": function(row, data, dataIndex){ 
      // Get row ID
      var rowId = data[1];
      // If row ID is in the list of selected row IDs
      if($.inArray(rowId, rows_selected) >= 0){
        $(row).find('input[type="checkbox"]').prop('checked', true);
        $(row).addClass('selected');
      }
    }
    // ======================
  })

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);
  
  // all about checkbox dataTables
    // Handle click on "Select all" control
    $('thead input[name="select_all"]', table.table().container()).on('click', function(e){
      if(this.checked){
         $('#dt_list tbody input[type="checkbox"]:not(:checked)').trigger('click');
      } else {
         $('#dt_list tbody input[type="checkbox"]:checked').trigger('click');
      }
      // Prevent click event from propagating to parent
      e.stopPropagation();
    });

    // Handle click on checkbox
    $('#dt_list tbody').on('click', 'input[type="checkbox"]', function(e){
      var $row = $(this).closest('tr');
      // Get row data
      var data = table.row($row).data();
      // Get row ID
      var rowId = data[1];
      // Determine whether row ID is in the list of selected row IDs
      var index = $.inArray(rowId, rows_selected);

      // If checkbox is checked and row ID is not in list of selected row IDs
      if(this.checked && index === -1){
        rows_selected.push(rowId);
      // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
      } else if (!this.checked && index !== -1){
        rows_selected.splice(index, 1);
      }

      if(this.checked){
         $row.addClass('selected');
      } else {
         $row.removeClass('selected');
      }

      // Update state of "Select all" control
      updateDataTableSelectAllCtrl(table);
      // Prevent click event from propagating to parent
      e.stopPropagation();
    });

    // Handle table draw event
    table.on('draw', function(){
      // Update state of "Select all" control
      updateDataTableSelectAllCtrl(table);
    });

    // Handle form submission event

    $('#batch_formula').on('click', function(e){
      var data_selected = []; // for collecting data
      var rows_selected2 = rows_selected.sort()
      var valueBefore = ""
      table.column( 1 ).data().each( function ( value, index ) {
        var valueCurrent = {} 
        valueCurrent.id = table.cell( index, 1 ).data();
        valueCurrent.category = table.cell( index, 13 ).data();
        if($.inArray(valueCurrent.id, rows_selected2) >= 0){
          if (valueBefore === "" || valueBefore === valueCurrent.category ) {
            data_selected.push(valueCurrent);
            valueBefore = valueCurrent.category
            // console.log(data_selected)
          } else {
            // alert("product yg dipilih harus satu category !!!")
            data_selected.length = 0
            return false
          }
        }
      });

      if (data_selected.length === rows_selected2.length) {
        var win = window.open('<?php echo base_url();?>master/product_cu_batch_formula?data='+rows_selected2, '_blank');
        win.focus();
      } else {
        // alert("product yg dipilih harus satu category !!!")
        alert("The selected product must be one category !!!")
        
      }
    }); 

    $('#batch_detail').on('click', function(e){
      var data_selected = []; // for collecting data
      var rows_selected2 = rows_selected.sort()
      var valueBefore = ""
      table.column( 1 ).data().each( function ( value, index ) {
        valueCurrent = {}
        valueCurrent.id = table.cell( index, 1 ).data();
        if($.inArray(valueCurrent.id, rows_selected2) >= 0){
          data_selected.push(valueCurrent);
          // console.log(data_selected)
        }
      });
      if (data_selected.length === rows_selected2.length) {
        var win = window.open('<?php echo base_url();?>master/product_cu_batch_edit?data='+rows_selected2, '_blank');
        win.focus();
      }
    }); 
  // ====================================================================

  $('a.toggle-vis').on( 'click', function (e) {
      e.preventDefault();
      var column = table.column( $(this).attr('data-column') );
      column.visible( ! column.visible() );
      table.columns.adjust().draw();
  } );

  setTimeout( function order() {
    // $('a[data-column="3"]').click();
    $('a[data-column="4"]').click();
    $('a[data-column="5"]').click();
    $('a[data-column="9"]').click();
    $('a[data-column="10"]').click();
    $('a[data-column="13"]').click();
    $('a[data-column="14"]').click();
  }, 100) //force to order and fix header width

  $(".addProduct").click(function(){
      $(".form-addProduct").slideToggle();
  });

});

function updateDataTableSelectAllCtrl(table){ // for adding checkbox
  var $table             = table.table().node();
  var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
  var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
  var chkbox_select_all  = $('thead #select_all');
  // If none of the checkboxes are checked
  if($chkbox_checked.length === 0){
    chkbox_select_all.prop("checked", false)
    chkbox_select_all.prop("indeterminate", false)
  // If all of the checkboxes are checked
  } else if ($chkbox_checked.length === $chkbox_all.length){
    chkbox_select_all.prop("checked", true)
    chkbox_select_all.prop("indeterminate", false)
  // If some of the checkboxes are checked
  } else {
    chkbox_select_all.prop("checked", false)
    chkbox_select_all.prop("indeterminate", true)
  }
}
</script>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script>
$('#view_product').live('click',function(e){
  var
    par = $(this).parent().parent();
    id  = par.find("td:nth-child(2)").html();
    get(id);
});
$("#hideshow").click(function(){
  $("#divhideshow").slideToggle();
});
function get(id) {
  xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>master/get_product_detail"
    url=url+"?a="+id
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

function new_window($val) {
  if ($val !== "") {
    var myview = window.open('<?php echo base_url();?>tool/product/'+$val, 'view_file', 'width=800,height=600');
  }
  return false;
}
</script>