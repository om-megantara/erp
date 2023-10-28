<link rel="stylesheet" href="<?php echo base_url();?>tool/jstree/dist/themes/default/style.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/jquery-ui.css">
<style type="text/css">
    .padRight10 { padding-right: 10px; }
    .jstree-search { background-color: #bababa; }
</style>
<div class="content-wrapper">

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
            <div class="box-body">
                <div class="col-md-12">
                    <h3>
                        Category List
                        <button type="button" class="btn btn-primary btn-xs expandCategory" title="EXPAND">Expand All</button>
                    </h3>
                    <input type="text" class="form-control input-sm" autocomplete="off" name="filter_tree" id="filter_tree">
                    <div id="ajaxCategory"></div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/jstree/dist/jstree.js"></script>
<script src="<?php echo base_url();?>tool/jstree/src/jstreegrid.js"></script>
<script src="<?php echo base_url();?>tool/jquery-ui.js"></script>
<script>
jQuery(function($) {
    treeCategory = $('#ajaxCategory').jstree({
                        "core" : { 
                            'data' : {
                                "url" : "<?php echo site_url('general/ajax_product_category_list_jstree_table')?>",
                                "dataType" : "json", // needed only if you do not supply JSON headers
                            },
                            // "check_callback" : true 
                        },
                        "plugins" : [ "checkbox", "grid", "dnd", "search"],
                        "grid" : { 
                            columns: [
                                {width: 400, header: "Name", headerClass: "alignCenter"},
                                {width: 150, header: "Product Type", value: "qtyProduct", headerClass: "alignCenter", wideCellClass: "alignRight padRight10", format: function(v){return((v).toLocaleString(undefined, {minimumFractionDigits: 2}));} },
                                {width: 150, header: "Qty Stock", value: "qtyStock", headerClass: "alignCenter", wideCellClass: "alignRight padRight10", format: function(v){return((v).toLocaleString(undefined, {minimumFractionDigits: 2}));} },
                                {width: 150, header: "Value", value: "value", headerClass: "alignCenter", wideCellClass: "alignRight padRight10", format: function(v){return("Rp. "+( v.toLocaleString(undefined, {minimumFractionDigits: 2}) ))} }
                            ],
                            resizable: true,
                            // contextmenu: true,
                            // width: 1000,
                        },
                        "footerrow": true,
                        loadComplete: function () {
                            $(this).jqGrid('footerData','set',
                                {name:'TOTAL', num:"500", debit:"<i>Bla</i> Bla",
                                credit:'20', balance:'<span style="color:red">-1000</span>'});
                        }
                    })

    var to = false;
    $('#filter_tree').keyup(function () {
        if(to) { clearTimeout(to); }
        to = setTimeout(function () {
          var v = $('#filter_tree').val();
          $('#ajaxCategory').jstree(true).searchColumn({0:v});
        }, 250);
    });
});
$('.expandCategory').bind('click', function(e){
    if ($('.jstree-open',treeCategory).length){
        treeCategory.jstree('close_all');
    }else{
        treeCategory.jstree('open_all');
    }
}); 
</script>