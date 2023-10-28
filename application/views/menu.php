<?php 
  if ($MenuList == "") {
    $MenuList = array();
  }
?>
<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
      </div>
      <div class="pull-left info">
      </div>
    </div>
    <ul class="sidebar-menu" data-widget="tree">
      <li class="treeview menu_dashboard">
        <a href="<?php echo base_url();?>main" onclick="window.location.replace('<?php echo base_url();?>main');">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>

      <?php if (in_array("menu_app_administration", $MenuList)) { ?>
        <li class="treeview menu_app_administration">
          <a href="#">
            <i class="fa fa-suitcase"></i> <span>App Administration</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="user_account_list">
              <a href="<?php echo base_url();?>administration/user_account_list"><i class="fa fa-key"></i> Manage User Account
              </a>
            </li>
            <li class="manage_group">
              <a href="<?php echo base_url();?>administration/group_list"><i class="fa fa-key"></i> Manage Group Account
              </a>
            </li>
            <li class="manage_personal">
              <a href="<?php echo base_url();?>administration/user_menu"><i class="fa fa-key"></i> Manage Personal Menu
              </a>
            </li>
            <li class="manage_menu">
              <a href="<?php echo base_url();?>administration/user_manage_menu"><i class="fa fa-key"></i> Manage Menu
              </a>
            </li>
            <li class="site_configuration">
              <a href="<?php echo base_url();?>administration/site_config"><i class="fa fa-gears"></i> Site Configuration
              </a>
            </li>
          </ul>
        </li>
      <?php }; ?>

      <?php if (in_array("menu_hrd", $MenuList)) { ?>
        <li class="treeview menu_hrd">
          <a href="#">
            <i class="fa fa-suitcase"></i> <span>HRD</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if (in_array("menu_manage_employee", $MenuList)) { ?>
              <li class="treeview menu_manage_employee">
                <a href="#"><i class="fa fa-users"></i> Manage Employee
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <?php if (in_array("employee_list", $MenuList)) { ?>
                  <li class="employee_list"><a href="<?php echo base_url();?>employee/employee_list"><i class="fa fa-users"></i> Employee List</a></li>
                  <li class="employee_attendance"><a href="<?php echo base_url();?>employee/employee_attendance"><i class="fa fa-users"></i> Attendance</a></li>
                  <?php }; ?>
                  <?php if (in_array("employee_list_active", $MenuList)) { ?>
                  <li class="employee_list_active"><a href="<?php echo base_url();?>employee/employee_list_active"><i class="fa fa-users"></i> Employee List Active</a></li>
                  <?php }; ?>
                  <?php if (in_array("employee_penalty", $MenuList)) { ?>
                  <li class="employee_penalty"><a href="<?php echo base_url();?>employee/employee_penalty_list"><i class="fa fa-users"></i> Penalty</a></li>
                  <?php }; ?>
                </ul>
              </li>
            <?php }; ?>
            <?php if (in_array("menu_manage_structure", $MenuList)) { ?>
              <li class="treeview menu_manage_structure">
                <a href="#"><i class="fa fa-users"></i> Manage Structure
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <?php if (in_array("company_list", $MenuList)) { ?>
                  <li class="company_list"><a href="<?php echo base_url();?>hrd/company_list"><i class="fa fa-users"></i> Company</a></li>
                  <?php }; ?>
                  <?php if (in_array("division_list", $MenuList)) { ?>
                  <li class="division_list"><a href="<?php echo base_url();?>hrd/division_list"><i class="fa fa-users"></i> Division</a></li>
                  <?php }; ?>
                  <?php if (in_array("job_list", $MenuList)) { ?>
                  <li class="job_list"><a href="<?php echo base_url();?>hrd/job_list"><i class="fa fa-users"></i> Job Title</a></li>
                  <?php }; ?>
                  <?php if (in_array("office_list", $MenuList)) { ?>
                  <li class="office_list"><a href="<?php echo base_url();?>hrd/office_list"><i class="fa fa-users"></i> Office Location</a></li>
                  <?php }; ?>
                </ul>
              </li>
            <?php }; ?>
            <?php if (in_array("menu_manage_asset", $MenuList)) { ?>
              <li class="treeview manage_asset">
                <a href="#"><i class="fa fa-users"></i> Manage Asset
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <?php if (in_array("asset_list", $MenuList)) { ?>
                  <li class="asset_list"><a href="<?php echo base_url();?>hrd/asset_list"><i class="fa fa-users"></i> Asset List</a></li>
                  <?php }; ?>
                  <?php if (in_array("asset_assignment_history", $MenuList)) { ?>
                  <li class="asset_assignment_history"><a href="<?php echo base_url();?>hrd/asset_assignment_history"><i class="fa fa-users"></i> Asset Assignment History</a></li>
                  <?php }; ?>
                </ul>
              </li>
            <?php }; ?>
          </ul>
        </li>
      <?php }; ?>

      <?php if (in_array("menu_employee", $MenuList)) { ?>
        <li class="treeview menu_employee">
          <a href="#">
            <i class="fa fa-suitcase"></i> <span>Employee</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if (in_array("employee_overtime", $MenuList)) { ?>
              <li class="employee_overtime"><a href="<?php echo base_url();?>employee/employee_overtime"><i class="fa fa-clock-o"></i> Employee Over Time</a></li>
            <?php }; ?>
          </ul>
        </li>
      <?php }; ?>

      <?php if (in_array("menu_master", $MenuList)) { ?>
        <li class="treeview menu_master">
          <a href="#">
            <i class="fa fa-suitcase"></i> <span>Master Data</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if (in_array("menu_manage_contact", $MenuList)) { ?>
              <li class="treeview menu_manage_contact">
                <a href="#"><i class="fa fa-book"></i> Manage Contact
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <?php if (in_array("contact_list", $MenuList)) { ?>
                    <li class="contact_list">
                      <a href="<?php echo base_url();?>master/contact_list"><i class="fa fa-book"></i> Contact List
                      </a>
                    </li>
                  <?php }; ?>
                  <?php if (in_array("customer_list", $MenuList)) { ?>
                    <li class="customer_list">
                      <a href="<?php echo base_url();?>master/customer_list"><i class="fa fa-book"></i> Customer List
                      </a>
                    </li>
                  <?php }; ?>
                  <?php if (in_array("supplier_list", $MenuList)) { ?>
                    <li class="supplier_list">
                      <a href="<?php echo base_url();?>master/supplier_list"><i class="fa fa-book"></i> Supplier List
                      </a>
                    </li>
                  <?php }; ?>
                  <?php if (in_array("expedition_list", $MenuList)) { ?>
                    <li class="expedition_list">
                      <a href="<?php echo base_url();?>master/expedition_list"><i class="fa fa-book"></i> Expedition List
                      </a>
                    </li>
                  <?php }; ?>
                  <?php if (in_array("sales_list", $MenuList)) { ?>
                    <li class="sales_list">
                      <a href="<?php echo base_url();?>master/sales_list"><i class="fa fa-book"></i> Sales List
                      </a>
                    </li>
                  <?php }; ?>
                </ul>
              </li>
            <?php }; ?>

            <?php if (in_array("menu_manage_product", $MenuList)) { ?>
              <li class="treeview menu_manage_product">
              <a href="#"><i class="fa fa-book"></i> Manage Product
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if (in_array("manage_product", $MenuList)) { ?>
                  <li class="product_list"><a href="<?php echo base_url();?>master/product_list"><i class="fa fa-book"></i> Product List</a></li>
                <?php }; ?>
                <?php if (in_array("manage_product_hpp", $MenuList)) { ?>
                  <li class="product_hpp_list"><a href="<?php echo base_url();?>master/product_hpp_list"><i class="fa fa-book"></i> Product HPP List</a></li>
                <?php }; ?>
                <?php if (in_array("manage_product_detail", $MenuList)) { ?>
                  <li class="category_list"><a href="<?php echo base_url();?>master/productcategory_list"><i class="fa fa-book"></i> Category List</a></li>
                  <li class="brand_list"><a href="<?php echo base_url();?>master/brand_list"><i class="fa fa-book"></i> Brand List</a></li>
                  <li class="atributeset_list"><a href="<?php echo base_url();?>master/productatributeset_list"><i class="fa fa-book"></i> Atribute Set</a></li>
                  <li class="atribute_list"><a href="<?php echo base_url();?>master/productatribute_list"><i class="fa fa-book"></i> Atribute List</a></li>
                <?php }; ?>
              </ul>
              </li>
            <?php }; ?>

            <?php if (in_array("menu_manage_administration", $MenuList)) { ?>
              <li class="treeview menu_manage_administration">
              <a href="#"><i class="fa fa-book"></i> Manage Administration
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if (in_array("manage_city", $MenuList)) { ?>
                  <li class="city_list"><a href="<?php echo base_url();?>master/city_list"><i class="fa fa-book"></i> City List</a></li>
                <?php }; ?>
                <?php if (in_array("manage_region", $MenuList)) { ?>
                <li class="region_list"><a href="<?php echo base_url();?>master/region_list"><i class="fa fa-book"></i> Region List</a></li>
                <?php }; ?>
                <?php if (in_array("manage_warehouse", $MenuList)) { ?>
                <li class="warehouse_list"><a href="<?php echo base_url();?>master/warehouse_list"><i class="fa fa-book"></i> Warehouse List</a></li>
                <?php }; ?>
                <?php if (in_array("manage_price", $MenuList)) { ?>
                <li class="price_category"><a href="<?php echo base_url();?>master/productpricecategory_list"><i class="fa fa-book"></i> Price Category</a></li>
                <li class="price_list"><a href="<?php echo base_url();?>master/price_list"><i class="fa fa-book"></i> Promo Piece</a></li>
                <li class="promo_volume"><a href="<?php echo base_url();?>master/promo_volume"><i class="fa fa-book"></i> Promo Volume</a></li>
                <?php }; ?>
                <?php if (in_array("price_recommendation", $MenuList)) { ?>
                  <li class="price_recommendation"><a href="<?php echo base_url();?>master/price_recommendation"><i class="fa fa-book"></i> Price Recommendation</a></li>
                <?php }; ?>
              </ul>
              </li>
            <?php }; ?>

            <?php if (in_array("menu_manage_penalty", $MenuList)) { ?>
              <li class="treeview menu_manage_penalty">
              <a href="#"><i class="fa fa-book"></i> Manage HRD
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if (in_array("penalty_list", $MenuList)) { ?>
                  <li class="penalty_list"><a href="<?php echo base_url();?>master/penalty_list"><i class="fa fa-book"></i> Penalty</a></li>
                <?php }; ?>
                <?php if (in_array("sop_list", $MenuList)) { ?>
                  <li class="sop_list"><a href="<?php echo base_url();?>master/sop_list"><i class="fa fa-book"></i> SOP</a></li>
                <?php }; ?>
              </ul>
              </li>
            <?php }; ?>

            <?php if (in_array("menu_manage_shop", $MenuList)) { ?>
              <li class="treeview menu_manage_shop">
              <a href="#"><i class="fa fa-book"></i> Manage Shop
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if (in_array("shop_list", $MenuList)) { ?>
                  <li class="shop_list"><a href="<?php echo base_url();?>master/shop_list"><i class="fa fa-book"></i> Shop List </a></li>
                <?php }; ?>
                <?php if (in_array("product_link_list", $MenuList)) { ?>
                  <li class="product_link_list"><a href="<?php echo base_url();?>master/product_link_list"><i class="fa fa-book"></i> List Link </a></li>
                <?php }; ?>
              </ul>
              </li>
            <?php }; ?>
          </ul>
        </li>
      <?php }; ?>

      <?php if (in_array("menu_finance", $MenuList)) { ?>
        <li class="treeview menu_finance">
          <a href="#">
            <i class="fa fa-suitcase"></i> <span>Finance</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if (in_array("bank_transaction", $MenuList)) { ?>
              <li class="bank_transaction">
              <a href="<?php echo base_url();?>finance/bank_transaction"><i class="fa fa-money"></i> Bank Transaction
              </a>
              </li>
            <?php }; ?>
            <?php if (in_array("customer_deposit", $MenuList)) { ?>
              <li class="confirmation_deposit">
                <a href="<?php echo base_url();?>finance/confirmation_deposit"><i class="fa fa-money"></i> Confirmation Deposit
                </a>
              </li>
              <li class="customer_deposit">
                <a href="<?php echo base_url();?>finance/customer_deposit"><i class="fa fa-money"></i> Customer Deposit
                </a>
              </li>
            <?php }; ?>
            <?php if (in_array("customer_retur", $MenuList)) { ?>
              <li class="customer_retur">
                <a href="<?php echo base_url();?>finance/customer_retur"><i class="fa fa-money"></i> Customer Retur
                </a>
              </li>
            <?php }; ?>
            <?php if (in_array("bank_distribution", $MenuList)) { ?>
              <li class="bank_distribution">
                <a href="<?php echo base_url();?>finance/bank_distribution"><i class="fa fa-money"></i> Bank Distribution
                </a>
              </li>
            <?php }; ?>
          </ul>
        </li>
      <?php }; ?>

      <?php if (in_array("menu_accounting", $MenuList)) { ?>
        <li class="treeview menu_accounting">
          <a href="#">
            <i class="fa fa-suitcase"></i> <span>Accounting</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if (in_array("acc_account", $MenuList)) { ?>
              <li class="acc_account_list">
                <a href="<?php echo base_url();?>accounting/acc_account_list"><i class="fa fa-money"></i> Account List</a>
              </li>
              <li class="acc_account_assignment">
                <a href="<?php echo base_url();?>accounting/acc_account_assignment"><i class="fa fa-money"></i> Account Assignment</a>
              </li>
            <?php }; ?>
            <?php if (in_array("acc_journal", $MenuList)) { ?>
              <li class="acc_journal_list">
                <a href="<?php echo base_url();?>accounting/acc_journal_list"><i class="fa fa-money"></i> Journal List</a>
              </li>
            <?php }; ?>
            <?php if (in_array("acc_report", $MenuList)) { ?>
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-money"></i> <span>Management Report</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="report_balance">
                    <a href="<?php echo base_url();?>accounting/report_balance"><i class="fa fa-money"></i> Report Balance</a>
                  </li>
                  <li class="report_formula">
                    <a href="<?php echo base_url();?>accounting/report_formula"><i class="fa fa-money"></i> Report Formula</a>
                  </li>
                  <li class="report_result">
                    <a href="<?php echo base_url();?>accounting/report_result"><i class="fa fa-money"></i> Report Result</a>
                  </li>
                  <li class="report_posted">
                    <a href="<?php echo base_url();?>accounting/report_posted"><i class="fa fa-money"></i> Report Posted</a>
                  </li>
                </ul>
              </li>
            <?php }; ?>
            <?php if (in_array("acc_faktur_inv", $MenuList)) { ?>
              <li class="acc_faktur_inv">
                <a href="<?php echo base_url();?>accounting/acc_faktur_inv"><i class="fa fa-money"></i> Faktur Invoice Sales</a>
              </li>
            <?php }; ?>
            <?php if (in_array("acc_faktur_inv", $MenuList)) { ?>
              <li class="acc_faktur_inv_retur">
                <a href="<?php echo base_url();?>accounting/acc_faktur_inv_retur"><i class="fa fa-money"></i> Faktur Invoice Retur</a>
              </li>
            <?php }; ?>
            <?php if (in_array("acc_stock_value", $MenuList)) { ?>
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-money"></i> <span>Value of Inventory</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="acc_stock_value">
                    <a href="<?php echo base_url();?>accounting/acc_stock_value"><i class="fa fa-money"></i> Product List</a>
                  </li>
                  <li class="acc_stock_value2">
                    <a href="<?php echo base_url();?>accounting/acc_stock_value2"><i class="fa fa-money"></i> Category List</a>
                  </li>
                </ul>
              </li>
            <?php }; ?>
            <?php if (in_array("acc_dp_payment", $MenuList)) { ?>
              <li class="acc_dp_payment">
                <a href="<?php echo base_url();?>accounting/acc_dp_payment"><i class="fa fa-money"></i> Payment History</a>
              </li>
            <?php }; ?>
          </ul>
        </li>
      <?php }; ?>

      <?php if (in_array("menu_transaction", $MenuList)) { ?>
        <li class="treeview menu_transaction">
          <a href="#">
            <i class="fa fa-suitcase"></i> <span>Transaction</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if (in_array("invoice_list", $MenuList)) { ?>
              <li class="invoice_list">
                <a href="<?php echo base_url();?>transaction/invoice_list"><i class="fa fa-cart-plus"></i> Invoice Sales</a>
              </li>
              <li class="invoice_retur_list">
                <a href="<?php echo base_url();?>transaction/invoice_retur_list"><i class="fa fa-cart-plus"></i> Invoice Retur</a>
              </li>
            <?php }; ?>
            <?php if (in_array("menu_sales_order", $MenuList)) { ?>

              <li class="treeview menu_sales_order">
                <a href="#"><i class="fa fa-cart-plus"></i> Sales Order
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <?php if (in_array("sales_order_list", $MenuList)) { ?>
                  <li class="sales_order_list">
                    <a href="<?php echo base_url();?>transaction/sales_order_list"><i class="fa fa-cart-plus"></i> SO List</a>
                  </li>
                  <?php }; ?>
                  <?php if (in_array("sales_order_due_date", $MenuList)) { ?>
                  <li class="sales_order_due_date">
                    <a href="<?php echo base_url();?>transaction/sales_order_due_date"><i class="fa fa-cart-plus"></i> SO DueDate
                    </a>
                  </li>
                  <?php }; ?>
                  <?php if (in_array("sales_order_upload", $MenuList)) { ?>
                  <li class="sales_order_upload">
                    <a href="<?php echo base_url();?>transaction/sales_order_upload"><i class="fa fa-cart-plus"></i> SO Upload</a>
                  </li>
                  <?php }; ?>
                </ul>
              </li>
            <?php }; ?>
            <?php if (in_array("request_order_list", $MenuList)) { ?>
              <li class="request_order">
                <a href="<?php echo base_url();?>transaction/request_order_list"><i class="fa fa-cart-plus"></i> Request Order</a>
              </li>
            <?php }; ?>
            <?php if (in_array("purchase_order_list", $MenuList)) { ?>
              <li class="purchase_order">
                <a href="<?php echo base_url();?>transaction/purchase_order_list"><i class="fa fa-cart-plus"></i> Purchase Order</a>
              </li>
            <?php }; ?>
            <?php if (in_array("delivery_order_list", $MenuList)) { ?>
              <li class="delivery_order">
                <a href="<?php echo base_url();?>transaction/delivery_order_list"><i class="fa fa-cart-plus"></i> Delivery Order</a>
              </li>
            <?php }; ?>
            <?php if (in_array("delivery_order_received_list", $MenuList)) { ?>
              <li class="delivery_order_received">
                <a href="<?php echo base_url();?>transaction/delivery_order_received_list"><i class="fa fa-cart-plus"></i> Delivery Order Received</a>
              </li>
            <?php }; ?>
            <?php if (in_array("product_stock_list", $MenuList)) { ?>
              <li class="product_stock">
                <a href="<?php echo base_url();?>transaction/product_stock_list"><i class="fa fa-cart-plus"></i> Product Stock</a>
              </li>
            <?php }; ?>
            <?php if (in_array("product_mutation_list", $MenuList)) { ?>
              <li class="product_mutation">
                <a href="<?php echo base_url();?>transaction/product_mutation_list"><i class="fa fa-cart-plus"></i> Product Mutation</a>
              </li>
            <?php }; ?>
            <?php if (in_array("product_stock_opname_list", $MenuList)) { ?>
              <li class="product_stock_opname">
                <a href="<?php echo base_url();?>transaction/product_stock_opname_list"><i class="fa fa-cart-plus"></i> Stock Opname</a>
              </li>
            <?php }; ?>
            <?php if (in_array("stock_adjustment_list", $MenuList)) { ?>
              <li class="stock_adjustment">
                <a href="<?php echo base_url();?>transaction/stock_adjustment_list"><i class="fa fa-cart-plus"></i> Stock Adjustment</a>
              </li>
            <?php }; ?>
            <?php if (in_array("adjust_stock_history", $MenuList)) { ?>
              <li class="adjust_stock_history">
                <a href="<?php echo base_url();?>transaction/adjust_stock_history"><i class="fa fa-cart-plus"></i> Adjust Stock History</a>
              </li>
            <?php }; ?>
            <?php if (in_array("stock_check", $MenuList)) { ?>
              <li class="stock_check">
                <a href="<?php echo base_url();?>development/stock_check"><i class="fa fa-cart-plus"></i> Stock Check</a>
              </li>
            <?php }; ?>
          </ul>
        </li>
      <?php }; ?>

      <?php if (in_array("menu_approval", $MenuList)) { ?>
        <li class="treeview menu_approval">
          <a href="#">
            <i class="fa fa-suitcase"></i> <span>Approval</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if (in_array("upgrade_customer", $MenuList)) { ?>
              <li class="upgrade_customer">
                <a href="<?php echo base_url();?>approval/upgrade_customer">
                  <i class="fa fa-thumbs-o-up"></i> Upgrade Data Customer
                </a>
              </li>
            <?php }; ?>
            <?php if (in_array("approve_so", $MenuList)) { ?>
              <li class="approve_so">
                <a href="<?php echo base_url();?>approval/approve_so">
                  <i class="fa fa-thumbs-o-up"></i> Sales Order
                </a>
              </li>
            <?php }; ?>
            <?php if (in_array("approve_stock_adjustment", $MenuList)) { ?>
              <li class="approve_stock_adjustment">
                <a href="<?php echo base_url();?>approval/approve_stock_adjustment">
                  <i class="fa fa-thumbs-o-up"></i> Stock Adjustment
                </a>
              </li>
            <?php }; ?>
            <?php if (in_array("approve_mutation_product", $MenuList)) { ?>
              <li class="approve_mutation_product">
                <a href="<?php echo base_url();?>approval/approve_mutation_product">
                  <i class="fa fa-thumbs-o-up"></i> Mutation Product
                </a>
              </li>
            <?php }; ?>
            <?php if (in_array("approve_dor_invr", $MenuList)) { ?>
              <li class="approve_dor_invr">
                <a href="<?php echo base_url();?>approval/approve_dor_invr">
                  <i class="fa fa-thumbs-o-up"></i> DOR INV Retur
                </a>
              </li>
            <?php }; ?>
            <?php if (in_array("approve_price_list", $MenuList)) { ?>
              <li class="approve_price_list">
                <a href="<?php echo base_url();?>approval/approve_price_list">
                  <i class="fa fa-thumbs-o-up"></i> Price List
                </a>
              </li>
            <?php }; ?>
            <?php if (in_array("approve_price_recommendation", $MenuList)) { ?>
              <li class="approve_price_recommendation">
                <a href="<?php echo base_url();?>approval/approve_price_recommendation">
                  <i class="fa fa-thumbs-o-up"></i> Recommendation Price 
                </a>
              </li>
            <?php }; ?>
            <?php if (in_array("approve_promo_volume", $MenuList)) { ?>
              <li class="approve_promo_volume">
                <a href="<?php echo base_url();?>approval/approve_promo_volume">
                  <i class="fa fa-thumbs-o-up"></i> Promo Volume
                </a>
              </li>
            <?php }; ?>
            <?php if (in_array("approve_po", $MenuList)) { ?>
              <li class="approve_po">
                <a href="<?php echo base_url();?>approval/approve_po"><i class="fa fa-thumbs-o-up"></i> Purchase Order</a>
              </li>
            <?php }; ?>
            <?php if (in_array("approve_po_expired", $MenuList)) { ?>
              <li class="approve_po_expired">
                <a href="<?php echo base_url();?>approval/approve_po_expired">
                  <i class="fa fa-thumbs-o-up"></i> Purchase Order Expired
                </a>
              </li>
            <?php }; ?>
            <?php if (in_array("approve_marketing_activity", $MenuList)) { ?>
              <li class="approve_marketing_activity">
                <a href="<?php echo base_url();?>approval/approve_marketing_activity">
                  <i class="fa fa-thumbs-o-up"></i> Marketing Activity
                </a>
              </li>
            <?php }; ?>
            <?php if (in_array("cancel_marketing_activity", $MenuList)) { ?>
              <li class="cancel_marketing_activity">
                <a href="<?php echo base_url();?>approval/cancel_marketing_activity">
                  <i class="fa fa-thumbs-o-up"></i>Cancel Marketing Activity
                </a>
              </li>
            <?php }; ?>
            <?php if (in_array("approve_so_complaint", $MenuList)) { ?>
              <li class="approve_so_complaint">
                <a href="<?php echo base_url();?>approval/approve_so_complaint">
                  <i class="fa fa-thumbs-o-up"></i> SO Complaint
                </a>
              </li>
            <?php }; ?>
            <?php if (in_array("approve_employee_overtime", $MenuList)) { ?>
              <li class="approve_employee_overtime">
                <a href="<?php echo base_url();?>approval/approve_employee_overtime">
                  <i class="fa fa-thumbs-o-up"></i> Employee Overtime
                </a>
              </li>
            <?php }; ?>
          </ul>
        </li>
      <?php }; ?>

      <?php if (in_array("menu_notification", $MenuList)) { ?>
        <li class="treeview menu_notification">
          <a href="#">
            <i class="fa fa-suitcase"></i> <span>Notification</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if (in_array("update_price_list", $MenuList)) { ?>
              <li class="update_price_list"><a href="<?php echo base_url();?>notification2/update_price_list"><i class="fa fa-thumbs-o-up"></i> Update Price List</a>
              </li>
            <?php }; ?>
            <?php if (in_array("notif_price", $MenuList)) { ?>
              <li class="notif_price"><a href="<?php echo base_url();?>notification2/notif_price"><i class="fa fa-thumbs-o-up"></i> Price</a></li>
            <?php }; ?>
            <?php if (in_array("update_stock", $MenuList)) { ?>
              <li class="update_stock"><a href="<?php echo base_url();?>notification2/update_stock"><i class="fa fa-thumbs-o-up"></i> Update Stock</a>
              </li>
            <?php }; ?>
            <?php if (in_array("update_mp", $MenuList)) { ?>
              <li class="update_mp"><a href="<?php echo base_url();?>notification2/update_mp"><i class="fa fa-thumbs-o-up"></i> Update MP</a>
              </li>
            <?php }; ?>
            <?php if (in_array("update_ready_for_sale", $MenuList)) { ?>
              <li class="update_ready_for_sale"><a href="<?php echo base_url();?>notification2/update_ready_for_sale"><i class="fa fa-thumbs-o-up"></i> Ready For Sale</a>
              </li>
            <?php }; ?>
            <?php if (in_array("notif_minmax", $MenuList)) { ?>
              <li class="notif_minmax"><a href="<?php echo base_url();?>notification2/notif_minmax"><i class="fa fa-thumbs-o-up"></i> ROS Min Max</a>
              </li>
            <?php }; ?>
            <?php if (in_array("notif_sop", $MenuList)) { ?>
              <li class="notif_sop"><a href="<?php echo base_url();?>notification2/notif_sop"><i class="fa fa-thumbs-o-up"></i> SOP</a>
              </li>
            <?php }; ?>
          </ul>
        </li>
      <?php }; ?>
      
      <?php if (in_array("menu_report", $MenuList)) { ?>
        <li class="treeview menu_report">
          <a href="#">
            <i class="fa fa-suitcase"></i> <span>Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <?php if (in_array("menu_report_pv", $MenuList)) { ?>
              <li class="treeview menu_report_pv">
              <a href="#"><i class="fa fa-print"></i> Report PV
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if (in_array("report_pv_inv", $MenuList)) { ?>
                <li class="report_pv_inv">
                  <a href="<?php echo base_url();?>report/report_bonus_invoice"><i class="fa fa-print"></i> PV by Invoice
                  </a>
                </li>
                <li class="report_pv_inv_percentage">
                  <a href="<?php echo base_url();?>report/report_bonus_invoice_percentage"><i class="fa fa-print"></i> PV by Invoice Percentage
                  </a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_pv_sales", $MenuList)) { ?>
                <li class="report_pv_sales">
                  <a href="<?php echo base_url();?>report/report_bonus_sales"><i class="fa fa-print"></i> PV by Sales
                  </a>
                </li>
                <li class="report_pv_sales_percentage">
                  <a href="<?php echo base_url();?>report/report_bonus_sales_percentage"><i class="fa fa-print"></i> PV by Sales Percentage</a>
                </li>
                <?php }; ?>
              </ul>
            </li>
            <?php }; ?>
            <?php if (in_array("menu_report_ro", $MenuList)) { ?>
              <li class="treeview menu_report_ro">
              <a href="#"><i class="fa fa-print"></i> Report Request Order
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if (in_array("report_ro_outstanding_po", $MenuList)) { ?>
                <li class="report_ro_outstanding_po">
                  <a href="<?php echo base_url();?>report/report_ro_outstanding_po"><i class="fa fa-print"></i> Outstanding PO</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_ro_outstanding_dor", $MenuList)) { ?>
                <li class="report_ro_outstanding_dor">
                  <a href="<?php echo base_url();?>report/report_ro_outstanding_dor"><i class="fa fa-print"></i> Outstanding DOR</a>
                </li>
                <?php }; ?>
              </ul>
            </li>
            <?php }; ?>
            <?php if (in_array("menu_report_po", $MenuList)) { ?>
              <li class="treeview menu_report_po">
              <a href="#"><i class="fa fa-print"></i> Report Purchase Order
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if (in_array("report_po_general", $MenuList)) { ?>
                <li class="report_po_general">
                  <a href="<?php echo base_url();?>report/report_po_general"><i class="fa fa-print"></i> PO General</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_po_outstanding_do", $MenuList)) { ?>
                <li class="report_po_outstanding_do">
                  <a href="<?php echo base_url();?>report/report_po_outstanding_do"><i class="fa fa-print"></i> Outstanding DO</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_po_outstanding_dor", $MenuList)) { ?>
                <li class="report_po_outstanding_dor">
                  <a href="<?php echo base_url();?>report/report_po_outstanding_dor"><i class="fa fa-print"></i> Outstanding DOR</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_po_dor_general", $MenuList)) { ?>
                <li class="report_po_dor_general">
                  <a href="<?php echo base_url();?>report/report_po_dor_general"><i class="fa fa-print"></i> DOR General</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_po_dor_product", $MenuList)) { ?>
                <li class="report_po_dor_product">
                  <a href="<?php echo base_url();?>report/report_po_dor_product"><i class="fa fa-print"></i> DOR Product</a>
                </li>
                <?php }; ?>
              </ul>
              </li>
            <?php }; ?>
            <?php if (in_array("menu_report_do", $MenuList)) { ?>
              <li class="treeview menu_report_do">
              <a href="#"><i class="fa fa-print"></i> Report Delivery Order
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if (in_array("report_do_global", $MenuList)) { ?>
                <li class="report_do_global">
                  <a href="<?php echo base_url();?>report/report_do_global"><i class="fa fa-print"></i> Global</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_do_not_inv", $MenuList)) { ?>
                <li class="report_do_not_inv">
                  <a href="<?php echo base_url();?>report/report_do_not_inv"><i class="fa fa-print"></i> Not Invoice</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_do_consignment", $MenuList)) { ?>
                <li class="report_do_consignment">
                  <a href="<?php echo base_url();?>report/report_do_consignment"><i class="fa fa-print"></i> Consignment</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_do_fc", $MenuList)) { ?>
                <li class="report_do_fc">
                  <a href="<?php echo base_url();?>report/report_do_fc"><i class="fa fa-print"></i> Freightcharge</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_do_product", $MenuList)) { ?>
                <li class="report_do_product">
                  <a href="<?php echo base_url();?>report/report_do_product"><i class="fa fa-print"></i> By Product</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_do_late_so", $MenuList)) { ?>
                <li class="report_do_late_so">
                  <a href="<?php echo base_url();?>report/report_do_late_so"><i class="fa fa-print"></i> Late (SO)</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_do_schedule", $MenuList)) { ?>
                <li class="report_do_schedule">
                  <a href="<?php echo base_url();?>report/report_do_schedule"><i class="fa fa-print"></i> Schedule (SO)</a>
                </li>
                <?php }; ?>
              </ul>
              </li>
            <?php }; ?>
            <?php if (in_array("menu_report_so", $MenuList)) { ?>
              <li class="treeview menu_report_so">
              <a href="#"><i class="fa fa-print"></i> Report Sales Order
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if (in_array("report_so_global", $MenuList)) { ?>
                <li class="report_so_global">
                  <a href="<?php echo base_url();?>report/report_so_global"><i class="fa fa-print"></i> Global</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_so_resi_mp", $MenuList)) { ?>
                <li class="report_so_resi_mp">
                  <a href="<?php echo base_url();?>report/report_so_resi_mp"><i class="fa fa-print"></i> Resi MP</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_so_outstanding_do", $MenuList)) { ?>
                <li class="report_so_outstanding_do">
                  <a href="<?php echo base_url();?>report/report_so_outstanding_do"><i class="fa fa-print"></i> Outstanding DO</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_so_outstanding_payment", $MenuList)) { ?>
                <li class="report_so_outstanding_payment">
                  <a href="<?php echo base_url();?>report/report_so_outstanding_payment"><i class="fa fa-print"></i> Outstanding Payment</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_so_sales", $MenuList)) { ?>
                <li class="report_so_sales">
                  <a href="<?php echo base_url();?>report/report_so_sales"><i class="fa fa-print"></i>By SE</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_so_shop", $MenuList)) { ?>
                <li class="report_so_shop">
                  <a href="<?php echo base_url();?>report/report_so_shop"><i class="fa fa-print"></i> By Shop</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_so_custom", $MenuList)) { ?>
                  <li class="treeview">
                    <a href="#">
                      <i class="fa fa-print"></i> <span>Custom</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <?php if (in_array("report_so_project", $MenuList)) { ?>
                      <li class="report_so_project">
                        <a href="<?php echo base_url();?>report/report_so_project"><i class="fa fa-print"></i> Project</a>
                      </li>
                      <?php }; ?>
                      <?php if (in_array("report_so_product", $MenuList)) { ?>
                      <li class="report_so_product">
                        <a href="<?php echo base_url();?>report/report_so_product"><i class="fa fa-print"></i> By Product (Qty)</a>
                      </li>
                      <?php }; ?>
                      <?php if (in_array("report_so_outstanding_do_product", $MenuList)) { ?>
                      <li class="report_so_outstanding_do_product">
                        <a href="<?php echo base_url();?>report/report_so_outstanding_do_product"><i class="fa fa-print"></i> Picking List</a>
                      </li>
                      <?php }; ?>
                      <li class="report_so_city_having_display">
                        <a href="<?php echo base_url();?>report/report_so_city_having_display"><i class="fa fa-print"></i> City Having Display</a>
                      </li>
                      <li class="report_so_not_inv">
                        <a href="<?php echo base_url();?>report/report_so_not_inv"><i class="fa fa-print"></i> Not INV</a>
                      </li>
                      <li class="report_so_late_payment">
                        <a href="<?php echo base_url();?>report/report_so_late_payment"><i class="fa fa-print"></i> Late Payment</a>
                      </li>
                    </ul>
                  </li>
                <?php }; ?>
              </ul>
              </li>
            <?php }; ?>
            <?php if (in_array("menu_report_inv", $MenuList)) { ?>
              <li class="treeview menu_report_inv">
              <a href="#"><i class="fa fa-print"></i> Report Invoice
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if (in_array("report_inv_global", $MenuList)) { ?>
                <li class="report_inv_global">
                  <a href="<?php echo base_url();?>report/report_inv_global"><i class="fa fa-print"></i> Global</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_inv_customer", $MenuList)) { ?>
                <li class="report_inv_customer">
                  <a href="<?php echo base_url();?>report/report_inv_customer"><i class="fa fa-print"></i> By Customer</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_inv_sales", $MenuList)) { ?>
                <li class="report_inv_sales">
                  <a href="<?php echo base_url();?>report/report_inv_sales"><i class="fa fa-print"></i> By SE</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_inv_product", $MenuList)) { ?>
                <li class="report_inv_product">
                  <a href="<?php echo base_url();?>report/report_inv_product"><i class="fa fa-print"></i> By Product</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_inv_city", $MenuList)) { ?>
                <li class="report_inv_city">
                  <a href="<?php echo base_url();?>report/report_inv_city"><i class="fa fa-print"></i> By City</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_inv_shop", $MenuList)) { ?>
                <li class="report_inv_shop">
                  <a href="<?php echo base_url();?>report/report_inv_shop"><i class="fa fa-print"></i> By Shop</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_inv_unpaid", $MenuList)) { ?>
                <li class="report_inv_unpaid">
                  <a href="<?php echo base_url();?>report/report_inv_unpaid"><i class="fa fa-print"></i> Unpaid</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_inv_global", $MenuList)) { ?>
                <li class="report_inv_retur">
                  <a href="<?php echo base_url();?>report/report_inv_retur"><i class="fa fa-print"></i> Retur</a>
                </li>
                <?php }; ?>  
                <?php if (in_array("report_inv_profit", $MenuList)) { ?>
                  <li class="treeview">
                    <a href="#">
                      <i class="fa fa-print"></i> <span>Profit (CEO only)</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu"> 
                      <li class="report_inv_profit">
                        <a href="<?php echo base_url();?>report/report_inv_profit"><i class="fa fa-print"></i> By INV</a>
                      </li>
                      <li class="report_inv_profit_product">
                        <a href="<?php echo base_url();?>report/report_inv_profit_product"><i class="fa fa-print"></i> By Product</a>
                      </li>
                    </ul>
                  </li>
                <?php }; ?>      
                <?php if (in_array("menu_report_inv_custom", $MenuList)) { ?>
                  <li class="treeview">
                    <a href="#">
                      <i class="fa fa-print"></i> <span>Custom</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <li class="treeview">
                        <a href="#">
                          <i class="fa fa-print"></i> <span>100 Cities East</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                          <li class="report_inv_100_cities_east_customer">
                            <a href="<?php echo base_url();?>report/report_inv_100_cities_east_customer"><i class="fa fa-print"></i> By Customer</a>
                          </li>
                          <li class="report_inv_100_cities_east_sales">
                            <a href="<?php echo base_url();?>report/report_inv_100_cities_east_sales"><i class="fa fa-print"></i> By SE</a>
                          </li>
                          <li class="report_inv_100_cities_east_product">
                            <a href="<?php echo base_url();?>report/report_inv_100_cities_east_product"><i class="fa fa-print"></i> By Product</a>
                          </li>
                          <li class="report_inv_100_cities_east_city">
                            <a href="<?php echo base_url();?>report/report_inv_100_cities_east_city"><i class="fa fa-print"></i> By City</a>
                          </li>
                        </ul>
                      </li>
                      <li class="treeview">
                        <a href="#">
                          <i class="fa fa-print"></i> <span>100 Cities West</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                          <li class="report_inv_100_cities_west_customer">
                            <a href="<?php echo base_url();?>report/report_inv_100_cities_west_customer"><i class="fa fa-print"></i> By Customer</a>
                          </li>
                          <li class="report_inv_100_cities_west_sales">
                            <a href="<?php echo base_url();?>report/report_inv_100_cities_west_sales"><i class="fa fa-print"></i> By SE</a>
                          </li>
                          <li class="report_inv_100_cities_west_product">
                            <a href="<?php echo base_url();?>report/report_inv_100_cities_west_product"><i class="fa fa-print"></i> By Product</a>
                          </li>
                          <li class="report_inv_100_cities_west_city">
                            <a href="<?php echo base_url();?>report/report_inv_100_cities_west_city"><i class="fa fa-print"></i> By City</a>
                          </li>
                        </ul>
                      </li>
                      <li class="report_inv_having_display">
                        <a href="<?php echo base_url();?>report/report_inv_having_display"><i class="fa fa-print"></i> By Having Display</a>
                      </li>
                      <li class="report_inv_product_category">
                        <a href="<?php echo base_url();?>report/report_inv_product_category"><i class="fa fa-print"></i> By Product Category</a>
                      </li>
                      <li class="report_inv_product_brand">
                        <a href="<?php echo base_url();?>report/report_inv_product_brand"><i class="fa fa-print"></i> By Product Brand</a>
                      </li>
                      <li class="report_inv_product_id">
                        <a href="<?php echo base_url();?>report/report_inv_product_id"><i class="fa fa-print"></i> By Product ID</a>
                      </li>
                      <li class="report_inv_paid_customer_product">
                        <a href="<?php echo base_url();?>report/report_inv_paid_customer_product"><i class="fa fa-print"></i> Paid/Customer/Product</a>
                      </li>
                    </ul>
                  </li>
                <?php }; ?>
              </ul>
              </li>
            <?php }; ?>
            <?php if (in_array("menu_report_customer", $MenuList)) { ?>
              <li class="treeview menu_report_customer">
              <a href="#"><i class="fa fa-print"></i> Report Customer
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if (in_array("report_customer_deposit", $MenuList)) { ?>
                <li class="report_customer_deposit">
                  <a href="<?php echo base_url();?>report/report_customer_deposit"><i class="fa fa-print"></i> Deposit</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_customer_sales", $MenuList)) { ?>
                <li class="report_customer_sales">
                  <a href="<?php echo base_url();?>report/report_customer_sales"><i class="fa fa-print"></i> Customer By SE
                  </a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_customer_city", $MenuList)) { ?>
                <li class="report_customer_city">
                  <a href="<?php echo base_url();?>report/report_customer_city"><i class="fa fa-print"></i> Customer By City
                  </a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_customer_complaint", $MenuList)) { ?>
                <li class="report_customer_complaint">
                  <a href="<?php echo base_url();?>report/report_customer_complaint"><i class="fa fa-print"></i> Customer Complaint
                  </a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_customer_display", $MenuList)) { ?>
                <li class="report_customer_display">
                  <a href="<?php echo base_url();?>report/report_customer_display"><i class="fa fa-print"></i> Customer (Display) By City
                  </a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_customer_consignment", $MenuList)) { ?>
                <li class="report_customer_consignment">
                  <a href="<?php echo base_url();?>report/report_customer_consignment"><i class="fa fa-print"></i> Customer (CT) By City
                  </a>
                </li>
                <?php }; ?>
              </ul>
              </li>
            <?php }; ?>
            <?php if (in_array("menu_report_employee", $MenuList)) { ?>
              <li class="treeview menu_report_employee">
              <a href="#"><i class="fa fa-print"></i> Report Employee
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if (in_array("report_employee_login_hours", $MenuList)) { ?>
                <li class="report_employee_login_hours">
                  <a href="<?php echo base_url();?>report/report_employee_login_hours"><i class="fa fa-print"></i> Login Hours</a>
                </li>
                <?php }; ?> 
                <?php if (in_array("report_employee_penalty", $MenuList)) { ?>
                <li class="report_employee_penalty">
                  <a href="<?php echo base_url();?>report/report_employee_penalty"><i class="fa fa-print"></i> Penalty</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_employee_overtime", $MenuList)) { ?>
                <li class="report_employee_overtime">
                  <a href="<?php echo base_url();?>report/report_employee_overtime"><i class="fa fa-print"></i> Overtime</a>
                </li>
                <?php }; ?> 
              </ul>
              </li>
            <?php }; ?>
            <?php if (in_array("menu_report_approval", $MenuList)) { ?>
              <li class="treeview menu_report_approval">
              <a href="#"><i class="fa fa-print"></i> Report Approval
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if (in_array("report_approval_customer", $MenuList)) { ?>
                <li class="report_approval_customer">
                  <a href="<?php echo base_url();?>report/report_approval_customer"><i class="fa fa-print"></i> Customer</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_approval_so", $MenuList)) { ?>
                <li class="report_approval_so">
                  <a href="<?php echo base_url();?>report/report_approval_so"><i class="fa fa-print"></i> Sales Order</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_approval_adjustment", $MenuList)) { ?>
                <li class="report_approval_adjustment">
                  <a href="<?php echo base_url();?>report/report_approval_adjustment"><i class="fa fa-print"></i> Adjustment Stock</a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_approval_price_list", $MenuList)) { ?>
                <li class="report_approval_price_list">
                  <a href="<?php echo base_url();?>report/report_approval_price_list"><i class="fa fa-print"></i> Promo Piece
                  </a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_approval_price_recommendation", $MenuList)) { ?>
                <li class="report_approval_price_recommendation">
                  <a href="<?php echo base_url();?>report/report_approval_price_recommendation"><i class="fa fa-print"></i> Price Recommendation
                  </a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_approval_promo_volume", $MenuList)) { ?>
                <li class="report_approval_promo_volume">
                  <a href="<?php echo base_url();?>report/report_approval_promo_volume"><i class="fa fa-print"></i> Promo Volume
                  </a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_approval_mutation_product", $MenuList)) { ?>
                <li class="report_approval_mutation_product">
                  <a href="<?php echo base_url();?>report/report_approval_mutation_product"><i class="fa fa-print"></i> Mutation
                  </a>
                </li>
                <?php }; ?>
                <?php if (in_array("report_approval_purchase_order", $MenuList)) { ?>
                <li class="report_approval_purchase_order">
                  <a href="<?php echo base_url();?>report/report_approval_purchase_order"><i class="fa fa-print"></i> Purchase Order
                  </a>
                </li>
                <?php }; ?>
              </ul>
              </li>
            <?php }; ?> 
            <?php if (in_array("menu_report_product", $MenuList)) { ?>
              <li class="treeview menu_report_product">
                <a href="#"><i class="fa fa-print"></i> Report Product
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
              <ul class="treeview-menu">
                <?php if (in_array("report_product_general", $MenuList)) { ?>
                  <li class="report_product_general">
                    <a href="<?php echo base_url();?>report/report_product_general"><i class="fa fa-print"></i> General</a>
                  </li>
                <?php }; ?>
                <?php if (in_array("report_product_stock_ro", $MenuList)) { ?>
                  <li class="report_product_stock_ro">
                    <a href="<?php echo base_url();?>report/report_product_stock_ro"><i class="fa fa-print"></i> Stock ROS > 0</a>
                  </li>
                <?php }; ?>
                <?php if (in_array("report_product_stock_ready_std", $MenuList)) { ?>
                  <li class="report_product_stock_ready_std">
                    <a href="<?php echo base_url();?>report/report_product_stock_ready_std"><i class="fa fa-print"></i> Stock Ready (STD)</a>
                  </li>
                <?php }; ?>
                <?php if (in_array("report_product_stock_ro_std", $MenuList)) { ?>
                  <li class="report_product_stock_ro_std">
                    <a href="<?php echo base_url();?>report/report_product_stock_ro_std"><i class="fa fa-print"></i> Stock ROS > 0 (STD)</a>
                  </li>
                <?php }; ?>
                <?php if (in_array("report_product_stock_min_ro", $MenuList)) { ?>
                  <li class="report_product_stock_min_ro">
                    <a href="<?php echo base_url();?>report/report_product_stock_min_ro"><i class="fa fa-print"></i> Stock Ready < MIN (STD)</a>
                  </li>
                <?php }; ?>
                <?php if (in_array("report_product_stock_all", $MenuList)) { ?>
                  <li class="report_product_stock_ready">
                    <a href="<?php echo base_url();?>report/report_product_stock_ready"><i class="fa fa-print"></i> Stock Ready</a>
                  </li>
                  <li class="report_product_stock_all">
                    <a href="<?php echo base_url();?>report/report_product_stock_all"><i class="fa fa-print"></i> Stock All</a>
                  </li>
                <?php }; ?>
                <?php if (in_array("report_product_kpi", $MenuList)) { ?>
                  <li class="report_product_kpi">
                    <a href="<?php echo base_url();?>report/report_product_kpi"><i class="fa fa-print"></i> Product KPI
                    </a>
                  </li>
                <?php }; ?>
                <?php if (in_array("report_product_by_manager", $MenuList)) { ?>
                  <li class="report_product_by_manager">
                    <a href="<?php echo base_url();?>report/report_product_by_manager"><i class="fa fa-print"></i> by Product Manager
                    </a>
                  </li>
                <?php }; ?>
                <?php if (in_array("report_product_manager", $MenuList)) { ?>
                  <li class="report_product_manager">
                    <a href="<?php echo base_url();?>report/report_product_manager"><i class="fa fa-print"></i> Product Manager
                    </a>
                  </li>
                <?php }; ?>
                <?php if (in_array("report_product_not_sale", $MenuList)) { ?>
                  <li class="report_product_not_sale">
                    <a href="<?php echo base_url();?>report/report_product_not_sale"><i class="fa fa-print"></i> Not Sale > 0
                    </a>
                  </li>
                <?php }; ?>
                <?php if (in_array("report_product_slowmoving", $MenuList)) { ?>
                  <li class="report_product_slowmoving">
                    <a href="<?php echo base_url();?>report/report_product_slowmoving"><i class="fa fa-print"></i> SlowMoving</a>
                  </li>
                <?php }; ?>
                <?php if (in_array("report_product_brand_category", $MenuList)) { ?>
                  <li class="report_product_category_list">
                    <a href="<?php echo base_url();?>report/report_product_category_list"><i class="fa fa-print"></i> Category List</a>
                  </li>
                  <li class="report_product_brand_list">
                    <a href="<?php echo base_url();?>report/report_product_brand_list"><i class="fa fa-print"></i> Brand List</a>
                  </li>
                <?php }; ?>
                <?php if (in_array("shop_list", $MenuList)) { ?>
                  <li class="report_product_shop">
                    <a href="<?php echo base_url();?>report/report_product_shop"><i class="fa fa-print"></i> IShop</a>
                  </li>
                <?php }; ?>
                <?php if (in_array("shop_list", $MenuList)) { ?>
                  <li class="report_product_shop_dor">
                    <a href="<?php echo base_url();?>report/report_product_shop_dor"><i class="fa fa-print"></i>ISHOP BY DOR (PSHOP)</a>
                  </li>
                <?php }; ?>
                <?php if (in_array("report_stock_adjustment_balance", $MenuList)) { ?>
                  <li class="report_stock_adjustment_balance">
                    <a href="<?php echo base_url();?>report/report_stock_adjustment_balance"><i class="fa fa-print"></i> Stock Check</a>
                  </li>
                <?php }; ?>
              </ul>
              </li>
            <?php }; ?>
            <?php if (in_array("menu_report_price", $MenuList)) { ?>
              <li class="treeview menu_report_price">
                <a href="#"><i class="fa fa-print"></i> Report Price
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <?php if (in_array("report_product_price_active", $MenuList)) { ?>
                    <li class="report_product_price_active">
                      <a href="<?php echo base_url();?>report/report_product_price_active"><i class="fa fa-print"></i> Pricelist Offline
                      </a>
                    </li>
                  <?php }; ?>
                  <?php if (in_array("report_product_price_offline_reseller", $MenuList)) { ?>
                    <li class="report_product_price_offline_reseller">
                      <a href="<?php echo base_url();?>report/report_product_price_offline_reseller"><i class="fa fa-print"></i> Pricelist Offline Reseller 
                      </a>
                    </li>
                  <?php }; ?>
                  <?php if (in_array("report_product_price", $MenuList)) { ?>
                    <li class="report_product_price">
                      <a href="<?php echo base_url();?>report/report_product_price"><i class="fa fa-print"></i> HPP Price</a>
                    </li>
                    <li class="report_product_hpp_zero">
                      <a href="<?php echo base_url();?>report/report_product_hpp_zero"><i class="fa fa-print"></i> HPP Zero</a>
                    </li>
                  <?php }; ?>
                  <?php if (in_array("report_price_check_list", $MenuList)) { ?>
                    <li class="report_price_check_list">
                      <a href="<?php echo base_url();?>report/report_price_check_list"><i class="fa fa-print"></i> Price Check List
                      </a>
                    </li>
                  <?php }; ?>
                </ul>
              </li>
            <?php }; ?>
            <?php if (in_array("menu_report_marketing", $MenuList)) { ?>
              <li class="treeview menu_report_marketing">
              <a href="#"><i class="fa fa-print"></i> Report Marketing
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if (in_array("report_marketing_activity", $MenuList)) { ?>
                <li class="report_marketing_activity">
                  <a href="<?php echo base_url();?>report/report_marketing_activity"><i class="fa fa-print"></i> Activity Monthly</a>
                </li>
                <?php }; ?>
              </ul>
              </li>
            <?php }; ?>
          </ul>
        </li>
      <?php }; ?>

      <?php if (in_array("menu_development", $MenuList)) { ?>
        <li class="treeview menu_development">
          <a href="#">
            <i class="fa fa-suitcase"></i> <span>Development</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="development">
              <a href="<?php echo base_url();?>development"><i class="fa fa-wrench"></i> Development
              </a>
            </li>
          </ul>
        </li>
      <?php }; ?>

      <?php if (in_array("menu_excel", $MenuList)) { ?>
        <li class="treeview menu_excel">
          <a href="#">
            <i class="fa fa-suitcase"></i> <span>Excel</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="excel">
              <a href="<?php echo base_url();?>excel"><i class="fa fa-wrench"></i> Upload Excel
              </a>
            </li>
          </ul>
        </li>
      <?php }; ?>
      
      <?php if (in_array("menu_marketing", $MenuList)) { ?>
        <li class="treeview menu_marketing">
          <a href="#">
            <i class="fa fa-suitcase"></i> <span>Marketing</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if (in_array("manage_city", $MenuList)) { ?>
              <li class="manage_city">
                <a href="<?php echo base_url();?>marketing/manage_city"><i class="fa fa-book"></i> Manage City</a>
              </li>
            <?php }; ?>
            <?php if (in_array("marketing_activity", $MenuList)) { ?>
              <li class="marketing_activity">
                <a href="<?php echo base_url();?>marketing/marketing_activity"><i class="fa fa-book"></i> Marketing Activity</a>
              </li>
            <?php }; ?>
            <?php if (in_array("marketing_activity_category", $MenuList)) { ?>
              <li class="marketing_activity_category">
                <a href="<?php echo base_url();?>marketing/marketing_activity_category"><i class="fa fa-book"></i> Marketing Activity Category</a>
              </li>
            <?php }; ?>
            <?php if (in_array("marketing_activity_bonus", $MenuList)) { ?>
              <li class="marketing_activity_bonus">
                <a href="<?php echo base_url();?>marketing/marketing_activity_bonus"><i class="fa fa-book"></i> Marketing Activity Bonus</a>
              </li>
            <?php }; ?>
            <?php if (in_array("marketing_activity_category_fee", $MenuList)) { ?>
              <li class="marketing_activity_category_fee">
                <a href="<?php echo base_url();?>marketing/marketing_activity_category_fee"><i class="fa fa-book"></i> Marketing Activity Employee</a>
              </li>
            <?php }; ?>
            <?php if (in_array("project_list", $MenuList)) { ?>
              <li class="project_list">
                <a href="<?php echo base_url();?>development/project_list"><i class="fa fa-print"></i> Project List</a>
              </li>
            <?php }; ?> 
            <?php if (in_array("online_order", $MenuList)) { ?>
              <li class="online_order">
                <a href="<?php echo base_url();?>marketing/online_order"><i class="fa fa-book"></i> Online Order </a>
              </li>
            <?php }; ?>
          </ul>
        </li>
      <?php }; ?>

      <?php if (in_array("koreksi", $MenuList)) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-suitcase"></i> <span>Data koreksi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if (in_array("koreksi_data_lama", $MenuList)) { ?>
              <li class="koreksi_data_lama">
                <a href="<?php echo base_url();?>koreksi/customer_list"><i class="fa fa-book"></i> Customer List
                </a>
              </li>
              <li class="koreksi_kota">
                <a href="<?php echo base_url();?>koreksi/customer_list_city_miss"><i class="fa fa-book"></i> Customer - City miss
                </a>
              </li>
              <li class="koreksi_se_barat">
                <a href="<?php echo base_url();?>koreksi/customer_list_se_miss_barat"><i class="fa fa-book"></i> Customer - miss SE Barat
                </a>
              </li>
              <li class="koreksi_se_timur">
                <a href="<?php echo base_url();?>koreksi/customer_list_se_miss_timur"><i class="fa fa-book"></i> Customer - miss SE Timur
                </a>
              </li>
              <li class="customer_list_miss_cp">
                <a href="<?php echo base_url();?>koreksi/customer_list_miss_cp"><i class="fa fa-book"></i> Customer - miss ContactPerson
                </a>
              </li>
              <li class="customer_list_miss_cp_se">
                <a href="<?php echo base_url();?>koreksi/customer_list_miss_cp_se"><i class="fa fa-book"></i> Customer - miss CP by SE 
                </a>
              </li>
            <?php }; ?>
            <?php if (in_array("koreksi_produk", $MenuList)) { ?>
              <li class="koreksi_produk">
              <a href="<?php echo base_url();?>koreksi/product_list"><i class="fa fa-book"></i> Product List
              </a>
              </li>
            <?php }; ?>
            <?php if (in_array("koreksi_produk_manager", $MenuList)) { ?>
              <li class="koreksi_produk_manager">
              <a href="<?php echo base_url();?>koreksi/product_manager"><i class="fa fa-book"></i> Product Manager
              </a>
              </li>
            <?php }; ?>
            <?php if (in_array("koreksi_produk_acz", $MenuList)) { ?>
              <li class="koreksi_produk_acz">
              <a href="<?php echo base_url();?>koreksi/product_list_acz"><i class="fa fa-book"></i> Product PSHOP ACZ
              </a>
              </li>
            <?php }; ?>
            <?php if (in_array("koreksi_produk_cvn", $MenuList)) { ?>
              <li class="koreksi_produk_cvn">
              <a href="<?php echo base_url();?>koreksi/product_list_cvn"><i class="fa fa-book"></i> Product PSHOP CVN
              </a>
              </li>
            <?php }; ?>
            <?php if (in_array("koreksi_produk_angz", $MenuList)) { ?>
              <li class="koreksi_produk_angz">
              <a href="<?php echo base_url();?>koreksi/product_list_angz"><i class="fa fa-book"></i> Product PSHOP ANGZ
              </a>
              </li>
            <?php }; ?>
            <?php if (in_array("koreksi_produk_ati", $MenuList)) { ?>
              <li class="koreksi_produk_ati">
              <a href="<?php echo base_url();?>koreksi/product_list_ati"><i class="fa fa-book"></i> Product PSHOP ATI
              </a>
              </li>
            <?php }; ?>
            <?php if (in_array("koreksi_produk_ago", $MenuList)) { ?>
              <li class="koreksi_produk_ago">
              <a href="<?php echo base_url();?>koreksi/product_list_ago"><i class="fa fa-book"></i> Product PSHOP AGO
              </a>
              </li>
            <?php }; ?>
          </ul>
        </li>
      <?php }; ?>
      
      <?php if (in_array("menu_perbaikan", $MenuList)) { ?>
        <li class="treeview menu_perbaikan">
          <a href="#">
            <i class="fa fa-suitcase"></i> <span>Experiment</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if (in_array("perbaikan_report_customer", $MenuList)) { ?>
              <li class="perbaikan_report_customer">
              <a href="<?php echo base_url();?>development/perbaikan_report_customer"><i class="fa fa-check"></i>Halaman Customer List
              </a>
              </li>
            <?php }; ?>
            <?php if (in_array("perbaikan_report_product_shop", $MenuList)) { ?>
              <li class="perbaikan_report_product_shop">
              <a href="<?php echo base_url();?>development/perbaikan_report_product_shop"><i class="fa fa-book"></i>Report Product Shop
              </a>
              </li>
            <?php }; ?>
            <?php if (in_array("perbaikan_report_inv_100_cities_east_customer", $MenuList)) { ?>
              <li class="perbaikan_report_inv_100_cities_east_customer">
              <a href="<?php echo base_url();?>development/perbaikan_report_inv_100_cities_east_customer"><i class="fa fa-check"></i> Halaman 100 Cities East
              </a>
              </li>
            <?php }; ?>
            <?php if (in_array("perbaikan_report_inv_100_cities_west_customer", $MenuList)) { ?>
              <li class="perbaikan_report_inv_100_cities_west_customer">
              <a href="<?php echo base_url();?>development/perbaikan_report_inv_100_cities_west_customer"><i class="fa fa-check"></i> Halaman 100 Cities West
              </a>
              </li>
            <?php }; ?>
            <?php if (in_array("perbaikan_report_customer_sales", $MenuList)) { ?>
              <li class="perbaikan_report_customer_sales">
              <a href="<?php echo base_url();?>development/perbaikan_report_customer_sales"><i class="fa fa-check"></i> Halaman Customer By SE
              </a>
              </li>
            <?php }; ?>
            <?php if (in_array("perbaikan_report_customer_city_z", $MenuList)) { ?>
              <li class="perbaikan_report_customer_city_z">
              <a href="<?php echo base_url();?>development/perbaikan_report_customer_city_z"><i class="fa fa-check"></i> Report Customer By City Z
              </a>
              </li>
            <?php }; ?>
            <?php if (in_array("perbaikan_report_customer_city", $MenuList)) { ?>
              <li class="perbaikan_report_customer_city">
              <a href="<?php echo base_url();?>development/perbaikan_report_customer_city"><i class="fa fa-check"></i> Report Customer By City
              </a>
              </li>
            <?php }; ?>
            <?php if (in_array("perbaikan_report_product_kpi", $MenuList)) { ?>
              <li class="perbaikan_report_product_kpi">
              <a href="<?php echo base_url();?>development/perbaikan_report_product_kpi"><i class="fa fa-check"></i> Halaman Product KPI
              </a>
              </li>
            <?php }; ?>
            <?php if (in_array("perbaikan_report_customer_display", $MenuList)) { ?>
              <li class="perbaikan_report_customer_display">
              <a href="<?php echo base_url();?>development/perbaikan_report_customer_display"><i class="fa fa-check"></i> Customer (Display) By City
              </a>
              </li>
            <?php }; ?>
            <?php if (in_array("perbaikan_report_contact_list", $MenuList)) { ?>
              <li class="perbaikan_report_contact_list">
              <a href="<?php echo base_url();?>development/perbaikan_report_contact_list"><i class="fa fa-book"></i> Contact List
              </a>
              </li>
            <?php }; ?>
            <?php if (in_array("perbaikan_report_product_stock_ready", $MenuList)) { ?>
              <li class="perbaikan_report_product_stock_ready">
              <a href="<?php echo base_url();?>development/perbaikan_report_product_stock_ready"><i class="fa fa-check"></i> Stock Ready (Standard & Prime)</a>
              </li>
            <?php }; ?>
            <?php if (in_array("perbaikan_report_cfu", $MenuList)) { ?>
              <li class="perbaikan_report_cfu">
              <a href="<?php echo base_url();?>development/perbaikan_report_cfu"><i class="fa fa-check"></i> CFU</a>
              </li>
            <?php }; ?>
            <?php if (in_array("perbaikan_report_so_complaint", $MenuList)) { ?>
              <li class="perbaikan_report_so_complaint">
              <a href="<?php echo base_url();?>development/perbaikan_report_so_complaint"><i class="fa fa-check"></i> SO Global</a>
              </li>
            <?php }; ?>
            <?php if (in_array("perbaikan_list_complaint", $MenuList)) { ?>
              <li class="perbaikan_list_complaint">
              <a href="<?php echo base_url();?>development/perbaikan_list_complaint"><i class="fa fa-check"></i> Report Complain</a>
              </li>
            <?php }; ?>
            <?php if (in_array("perbaikan_marketing_activity_report", $MenuList)) { ?>
              <li class="perbaikan_marketing_activity_report">
              <a href="<?php echo base_url();?>development/perbaikan_marketing_activity_report"><i class="fa fa-check"></i> Report Marketing Activity</a>
              </li>
            <?php }; ?>
            <?php if (in_array("perbaikan_sales_order_list", $MenuList)) { ?>
              <li class="perbaikan_sales_order_list">
              <a href="<?php echo base_url();?>development/perbaikan_sales_order_list"><i class="fa fa-cart-plus"></i> SO List</a>
              </li>
            <?php }; ?>
            <?php if (in_array("perbaikan_report_product_price_active", $MenuList)) { ?>
              <li class="perbaikan_report_product_price_active">
              <a href="<?php echo base_url();?>development/perbaikan_report_product_price_active"><i class="fa fa-cart-plus"></i> Report Product Price Active</a>
              </li>
            <?php }; ?>
            <?php if (in_array("perbaikan_online_order", $MenuList)) { ?>
              <li class="perbaikan_online_order">
              <a href="<?php echo base_url();?>marketing/online_order"><i class="fa fa-cart-plus"></i> Online Order</a>
              </li>
            <?php }; ?>
          </ul>
        </li>
      <?php }; ?>
    </ul>
  </section>
</aside>