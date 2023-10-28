<link rel="stylesheet" href="<?php echo base_url();?>tool/jstree/dist/themes/default/style.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/jquery-ui.css">

<style type="text/css">
    .padRight10 { padding-right: 10px; }
    .jstree-search { background-color: #bababa; }
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

<div class="content-wrapper">

    <div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="AddModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <div class="form-addcompany with-border">
                  <form role="form" action="<?php echo base_url();?>accounting/acc_account_add" method="post" >
                    <div class="box box-solid ">
                      <div class="box-header">
                        <h3 class="box-title">Add Account</h3>
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                      </div>
                      <div class="box-body">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="left">Account Name</label>
                            <span class="left2">
                             <input type="text" class="form-control input-sm" placeholder="Account Name" autocomplete="off" name="Aname" required="">
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Account Code</label>
                            <span class="left2">
                             <input type="text" class="form-control input-sm" placeholder="Account Code" autocomplete="off" name="Acode" required="">
                            </span>
                          </div> 
                            <div class="form-group">
                                <label class="left">Account Type</label>
                                <span class="left2">
                                    <select class="form-control input-sm" name="Atype">
                                        <option value="credit">Credit</option>
                                        <option value="debit">Debit</option>
                                    </select>
                                </span>
                            </div>
                            <div class="form-group">
                                <label class="left">Account Position</label>
                                <span class="left2">
                                    <select class="form-control input-sm" name="Apotition">
                                        <option value="neraca">Neraca</option>
                                        <option value="rugilaba">Rugi Laba</option>
                                    </select>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="left">Company</label>
                                <span class="left2">
                                  <select class="form-control input-sm company" style="width: 100%;" name="company" required="">
                                    <option value="0">EMPTY</option>
                                    <?php foreach ($fill_company as $row => $list) { ?>
                                    <option value="<?php echo $list['CompanyID'];?>"><?php echo $list['CompanyName'];?></option>
                                    <?php } ?>
                                  </select>  
                                </span>
                            </div>
                            <div class="form-group">
                                <label class="left">Account Parent</label>
                                <span class="left2">
                                  <select class="form-control input-sm Aparent" style="width: 100%;" name="Aparent" required="">
                                    <option value="0">EMPTY</option>
                                    <?php foreach ($fill_account_no_jurnal as $row => $list) { ?>
                                    <option value="<?php echo $list['AccountID'];?>"><?php echo $list['AccountCode']." - ".$list['AccountName'];?></option>
                                    <?php } ?>
                                  </select>  
                                </span>
                            </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div> 
              </div>
          </div>
      </div>
    </div>
    <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <div class="form-addcompany with-border">
                  <form role="form" action="<?php echo base_url();?>accounting/acc_account_edit" method="post" >
                    <div class="box box-solid ">
                      <div class="box-header">
                        <h3 class="box-title">Edit Account</h3>
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                      </div>
                      <div class="box-body">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="left">Account Name</label>
                            <span class="left2">
                             <input type="hidden" class="form-control input-sm Aid" placeholder="Account Name" autocomplete="off" name="Aid">
                             <input type="text" class="form-control input-sm Aname" placeholder="Account Name" autocomplete="off" name="Aname" required="">
                            </span>
                          </div>
                          <div class="form-group">
                            <label class="left">Account Code</label>
                            <span class="left2">
                             <input type="text" class="form-control input-sm Acode" placeholder="Account Code" autocomplete="off" name="Acode" required="">
                            </span>
                          </div> 
                            <div class="form-group">
                                <label class="left">Account Type</label>
                                <span class="left2">
                                    <select class="form-control input-sm Atype" name="Atype">
                                        <option value="credit">Credit</option>
                                        <option value="debit">Debit</option>
                                    </select>
                                </span>
                            </div>
                            <div class="form-group">
                                <label class="left">Account Position</label>
                                <span class="left2">
                                    <select class="form-control input-sm Apotition" name="Apotition">
                                        <option value="neraca">Neraca</option>
                                        <option value="rugilaba">Rugi Laba</option>
                                    </select>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="left">Company</label>
                                <span class="left2">
                                  <select class="form-control input-sm company" style="width: 100%;" name="company" required="">
                                    <option value="0">EMPTY</option>
                                    <?php foreach ($fill_company as $row => $list) { ?>
                                    <option value="<?php echo $list['CompanyID'];?>"><?php echo $list['CompanyName'];?></option>
                                    <?php } ?>
                                  </select>  
                                </span>
                            </div>
                            <div class="form-group">
                                <label class="left">Account Parent</label>
                                <span class="left2">
                                  <select class="form-control input-sm Aparent" style="width: 100%;" name="Aparent" required="">
                                    <option value="0">EMPTY</option>
                                    <?php foreach ($fill_account_no_jurnal as $row => $list) { ?>
                                    <option value="<?php echo $list['AccountID'];?>"><?php echo $list['AccountCode']." - ".$list['AccountName'];?></option>
                                    <?php } ?>
                                  </select>  
                                </span>
                            </div>
                        </div>
                      </div>
                    </div>
                  </form>
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
            <div class="box-header">
                <a href="#" id="addAccount" class="btn btn-primary btn-xs addAccount" data-toggle="modal" data-target="#AddModal"><b>+</b> Add Account</a>
                <button type="button" class="btn btn-primary btn-xs expandAccount" title="EXPAND">Expand All</button>
            </div>
            <div class="box-body">
                    <input type="text" class="form-control input-sm" autocomplete="off" name="filter_tree" id="filter_tree">
                    <div id="ajaxAccount"></div>
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
    treeAccount = $('#ajaxAccount').jstree({
                        "core" : { 
                            'data' : {
                                "url" : "<?php echo site_url('accounting/ajax_account_list_jstree_table')?>",
                                "dataType" : "json", // needed only if you do not supply JSON headers
                            },
                        },
                        "plugins" : [ "grid", "dnd", "search"],
                        "grid" : { 
                            columns: [
                                {width: 400, header: "Name", headerClass: "alignCenter"},
                                {width: 80, header: "Code", value: "AccountCode", headerClass: "alignCenter" },
                                {width: 100, header: "Position", value: "AccountPosition", headerClass: "alignCenter", wideCellClass: "alignCenter" },
                                {width: 100, header: "Type", value: "AccountType", headerClass: "alignCenter", wideCellClass: "alignCenter" },
                                {width: 150, header: "Amount", value: "AccountAmount", headerClass: "alignCenter", wideCellClass: "alignRight padRight10", format: function(v){return((v).toLocaleString(undefined, {minimumFractionDigits: 2}));} },
                                {width: 80, header: "Tool", value: "tool", headerClass: "alignCenter", wideCellClass: "alignCenter" },
                            ],
                            resizable: true,
                        },
                    })

    var to = false;
    $('#filter_tree').keyup(function () {
        if(to) { clearTimeout(to); }
        to = setTimeout(function () {
          var v = $('#filter_tree').val();
          $('#ajaxAccount').jstree(true).searchColumn({0:v});
        }, 250);
    });
});
$('.expandAccount').bind('click', function(e){
    if ($('.jstree-open',treeAccount).length){
        treeAccount.jstree('close_all');
    }else{
        treeAccount.jstree('open_all');
    }
}); 
$('.EditAccount').live('click', function(e){
    Aid = $(this).attr('accountid');
    par = $("#EditModal")
    $.ajax({
      url: "<?php echo base_url();?>accounting/acc_account_detail",
      type : 'GET',
      data : 'AccountID=' + Aid,
      dataType : 'json',
      success : function (response) {
        par.find(".Aid").val(response['AccountID'])
        par.find(".Aname").val(response['AccountName'])
        par.find(".Acode").val(response['AccountCode'])
        par.find(".Atype").val(response['AccountType'])
        par.find(".company").val(response['CompanyID'])
        par.find(".Aparent").val(response['AccountParent'])
      }
    })
}); 
$('.DeleteAccount').live('click', function(e){
    Aid = $(this).attr('accountid');
    ConfirmNote = "Account akan dihapus, anda yakin?"
    var r = confirm(ConfirmNote);
    if (r == false) {
      e.preventDefault();
      return false
    } 
    $.ajax({
      url: "<?php echo base_url();?>accounting/acc_account_delete",
      type : 'GET',
      data : 'AccountID=' + Aid,
      dataType : 'json',
      success : function (response) {
        if (response == 'success') {
          location.reload();
        }
      }
    })
}); 
</script>