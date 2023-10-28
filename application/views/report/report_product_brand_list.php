<link rel="stylesheet" href="<?php echo base_url();?>tool/jstree/dist/themes/default/style.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/jquery-ui.css">
<style type="text/css">
    .GoToListC, .GoToListB, .cekValue {
        margin: 3px 0px;
        /*display: none;*/
    }
    .padRight10 { padding-right: 10px; }
    .spanD { float: right; }
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
                        Brand List
                        <button type="button" class="btn btn-primary btn-xs expandBrand" title="EXPAND">Expand All</button>
                    </h3>
                    <input type="text" class="form-control input-sm" autocomplete="off" name="filter_tree" id="filter_tree">
                    <div id="ajaxBrand"></div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/jstree/dist/jstree.min.js"></script>
<script src="<?php echo base_url();?>tool/jstree/src/jstreegrid.js"></script>
<script src="<?php echo base_url();?>tool/jquery-ui.js"></script>
<script>
jQuery(function($) { 
    treeBrand = $('#ajaxBrand').jstree({
        // 'plugins': ["wholerow", "checkbox"],
        'core' : {
            'data' : {
                // "url" : "<?php echo site_url('general/ajax_product_brand_list_jstree')?>",
                "url" : "<?php echo site_url('general/ajax_product_brand_list_jstree_table')?>",
                "dataType" : "json", // needed only if you do not supply JSON headers
                // "plugins" : [ "wholerow", "checkbox" ],
            }
        },
        "plugins" : [ "grid", "dnd", "search"],
        "grid" : { 
            columns: [
                {width: 400, header: "Name", headerClass: "alignCenter"},
                {width: 80, header: "Type", value: "qtyProduct", headerClass: "alignCenter", wideCellClass: "alignRight padRight10", format: function(v){return((v).toLocaleString(undefined, {minimumFractionDigits: 2}));} },
                {width: 80, header: "Stock", value: "qtyStock", headerClass: "alignCenter", wideCellClass: "alignRight padRight10", format: function(v){return((v).toLocaleString(undefined, {minimumFractionDigits: 2}));} },
                {width: 80, header: "Go To List", value: "GoToList", headerClass: "alignCenter", wideCellClass: "alignRight padRight10"},
            ],
            resizable: true,
            // contextmenu: true,
            // width: 1000,
        }, 
    }); 
    var to = false;
    $('#filter_tree').keyup(function () {
        if(to) { clearTimeout(to); }
        to = setTimeout(function () {
          var v = $('#filter_tree').val();
          $('#ajaxBrand').jstree(true).searchColumn({0:v});
        }, 250);
    });
    $('.expandBrand').live('click', function(e){
        if ($('.jstree-open',treeBrand).length){
            treeBrand.jstree('close_all');
        }else{
            treeBrand.jstree('open_all');
        }
    }); 
    $('.cekParentB').live('click', function(e){
        current = $(this)
        current.parent().parent().find('.spanD').remove()
        $('<span class="spanD"></span>').insertAfter( current.parent() )
        brand = current.attr('brand')
        $.ajax({
            url: "<?php echo base_url();?>master/get_brand_name",
            type : 'GET',
            data : 'id=' + brand,
            dataType : 'json',
            success : function (response) {
                current.parent().parent().find('.spanD').html("( "+response+" )")
            }
        })
    }); 
    $('.GoToListB').live('click', function(e){
        current = $(this)
        brand = current.attr('brand')
        var obj = {type: 'brand', id: brand};
        localStorage.removeItem('parse_report_product_list');
        localStorage.setItem('parse_report_product_list', JSON.stringify(obj));
        var win = window.open('report_product_general', '_blank');
            win.focus();
    }); 
});
</script>