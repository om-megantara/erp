<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<style type="text/css">
  .form-group { display: block; margin-bottom: 5px !important; }
  #reject { background-color: #dd4b39; }
  #approve { background-color: #0073b7; }
</style>

<?php 
// print_r($content['personal']); 
$actor = $content['actor']['Actor1'] != $EmployeeID ? : "Actor1";
$actor = $content['actor']['Actor2'] != $EmployeeID ? $actor : "Actor2";
$actor = $content['actor']['Actor3'] != $EmployeeID ? $actor : "Actor3";

?>

<div class="content-wrapper">
  <div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Customer List </h4>
          </div>
          <div class="modal-body">
            <div class="detailcontentAjax" id="detailcontent" style="background-color: white;">
            </div>
          </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-detail2">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Detail Customer</h4>
          </div>
          <div class="modal-body">
            <div class="detailcontentAjax2" id="detailcontent2" style="background-color: white;">
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
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-fw fa-info-circle" title="HELP"></i>Help</a></li>
    </ol>
  </section>

  <section class="content">
    <div class="box box-solid">
      <div class="box-body form_addcontact">
          <table id="dt_list" class="table table-bordered table-hover nowrap dtapproval" width="100%">
            <thead>
            <tr>
              <th class="alignCenter">City</th>
              <th class="alignCenter">Omzet</th>
              <th class="alignCenter">Tanggal</th>
              <th class="alignCenter">Customer</th>
              <th class="alignCenter">Category</th>
              <th class="alignCenter">Last CFU/CV</th>
              <th class="alignCenter">Last<br>Order</th>
              <th class="alignCenter">Previous<br>Omzet</th>
              <th class="alignCenter">Latest<br>Omzet</th>
              <th class="alignCenter">Sales</th>
              <th class="alignCenter">Type</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
              <?php
              // echo $actor;
                if ($actor != "1" && !empty($content['list'])) {
                  $no = 0;
                  foreach ($content['list'] as $row => $list) {
                    $no++;
                    $Cuzet1 =$list['Cuzet1']/1000000;
                    $Cuzet2 =$list['Cuzet2']/1000000;
                    $Cuzet3 =$list['Cuzet3']/1000000;
                    $Cuzet4 =$list['Cuzet4']/1000000;
                    $Omzet1 =$list['Omzet1']/1000000;
                    $Omzet2 =$list['Omzet2']/1000000;
                    $Omzet3 =$list['Omzet3']/1000000;
                    $Omzet4 =$list['Omzet4']/1000000;
                    ?>
                      <tr>
                        <td>
                          <a href="#" class="detail" id="<?php echo $list['CityID']; ?>"  cityname="<?php echo $list['CityName']; ?>" data-toggle="modal" data-target="#modal-detail"><?php echo $list['CityName'];?></a>
                        </td>
                        <td>
                          <b>C = </b>
                          <?php
                            echo number_format($Cuzet1, 1)." / ".number_format($Cuzet2, 1)." / ".number_format($Cuzet3, 1)." / ".number_format($Cuzet4, 1);
                            ?>
                          <br>
                          <b>R = </b>
                          <?php
                            echo number_format($Omzet1, 1)." / ".number_format($Omzet2, 1)." / ".number_format($Omzet3, 1)." / ".number_format($Omzet4, 1);
                          ?>
                        </td>
                        <td><?php echo $list['ActivityDate'];?></td>
                        <td><a href="#" class="detail2" target="_blank" customerid="<?php echo $list['ContactID']; ?>"  customer="<?php echo $list['customer']; ?>" data-toggle="modal" data-target="#modal-detail2"><?php echo wordwrap($list['customer']." (".$list['customerid'].") / ".$list['ShopName'] , 20,"<br>\n");?></a></td>
                        <td><?php echo $list['CustomercategoryName'];?></td>
                        <td><?php echo "CFU= ".$list['ActivityDateCFU']." (".$list['CFU'].")"."<br> CV = ".$list['ActivityDateCV']." (".$list['CV'].")";?></td>
                        <td><?php echo $list['INVDate'];?></td>
                        <td><?php echo number_format($list['total2']);?></td>
                        <td><?php echo number_format($list['total']);?></td>
                        <td><?php echo wordwrap($list['sales'], 20,"<br>\n");?></td>
                        <td><?php if($list['ActivityType']=="Customer Follow Up (CFU)"){echo "CFU";} else {echo "CV";} ?></td>
                        <td>
                      		<a href="<?php echo $list['ActivityLink'];?>" target='_blank' class="btn btn-primary btn-xs"><i class="fa fa-fw fa-link"></i></a>
                          <?php 
                            if ($list[$actor] == "") {
                              echo ($content['actor'][$actor] != "") ? "<a href='#' class='btn btn-primary btn-xs dtbutton' id='approve' data='".$actor."' ActivityID='".$list['ActivityID']."'><i class='fa fa-fw fa-check-square'></i></a>" : "";
                              echo ($content['actor'][$actor] != "") ? " <a href='#' class='btn btn-danger btn-xs dtbutton' id='reject' data='".$actor."' ActivityID='".$list['ActivityID']."'><i class='fa fa-fw fa-minus-square'></i></a>" : "";
                            }
                          ?>
                        </td>
                      </tr>
              <?php } } else {
                $actor= "Actor".$actor;
                  $no = 0;
                  foreach ($content['list'] as $row => $list) { $no++;
                    // echo $list['Actor1ID'];
                    $Cuzet1 =$list['Cuzet1']/1000000;
                    $Cuzet2 =$list['Cuzet2']/1000000;
                    $Cuzet3 =$list['Cuzet3']/1000000;
                    $Cuzet4 =$list['Cuzet4']/1000000;
                    $Omzet1 =$list['Omzet1']/1000000;
                    $Omzet2 =$list['Omzet2']/1000000;
                    $Omzet3 =$list['Omzet3']/1000000;
                    $Omzet4 =$list['Omzet4']/1000000;
                    ?>
                      <tr>
                        <td>
                          <a href="#" class="detail" id="<?php echo $list['CityID']; ?>"  cityname="<?php echo $list['CityName']; ?>" data-toggle="modal" data-target="#modal-detail"><?php echo $list['CityName'];?></a>
                        </td>
                        <td>
                          <b>C = </b>
                          <?php
                            echo number_format($Cuzet1, 1)." / ".number_format($Cuzet2, 1)." / ".number_format($Cuzet3, 1)." / ".number_format($Cuzet4, 1);
                            ?>
                          <br>
                          <b>R = </b>
                          <?php
                            echo number_format($Omzet1, 1)." / ".number_format($Omzet2, 1)." / ".number_format($Omzet3, 1)." / ".number_format($Omzet4, 1);
                          ?>
                        </td>
                        <td><?php echo $list['ActivityDate'];?></td>
                        <td><a href="#" class="detail2" customerid="<?php echo $list['ContactID']; ?>" customer="<?php echo $list['customer']; ?>" target="_blank" data-toggle="modal" data-target="#modal-detail2"><?php echo wordwrap($list['customer']." (".$list['customerid'].") / ".$list['ShopName'], 20,"<br>\n");?></a></td>
                        <td><?php echo $list['CustomercategoryName'];?></td>
                        <td><?php echo "CFU= ".$list['ActivityDateCFU']." (".$list['CFU'].")"."<br> CV = ".$list['ActivityDateCV']." (".$list['CV'].")";?></td>
                        <td><?php echo $list['INVDate'];?></td>
                        <td></td>
                        <td></td>
                        <td><?php echo wordwrap($list['sales'], 20,"<br>\n");?></td>
                        <td><?php if($list['ActivityType']=="Customer Follow Up (CFU)"){echo "CFU";} else {echo "CV";} ?></td>
                        <td>
                          <a href="<?php echo $list['ActivityLink'];?>" target='_blank' class="btn btn-primary btn-xs"><i class="fa fa-fw fa-link"></i></a>
                        <?php 
                            if ($content['actor']['Actor1'] == "SEC") {
                              if(empty($list['Actor1ID'])){
                                echo ($content['actor']['Actor1'] != "") ? "<a href='#' class='btn btn-primary btn-xs dtbutton' id='approve' data='".$actor."' ActivityID='".$list['ActivityID']."'><i class='fa fa-fw fa-check-square'></i></a>" : "";
                                echo ($content['actor']['Actor1'] != "") ? " <a href='#' class='btn btn-danger btn-xs dtbutton' id='reject' data='".$actor."' ActivityID='".$list['ActivityID']."'><i class='fa fa-fw fa-minus-square'></i></a>" : "";
                              }
                            }
                          ?>  
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
<script src="<?php echo base_url();?>tool/jquery-ui.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
j8  = jQuery.noConflict();
j8( document ).ready(function( $ ) {
   
  $('#dt_list').DataTable({
    "pageLength": <?php echo '200';?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,

    "order": [[ 0, "asc" ]]
  });

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  };
  $('#dt_list').resize(cek_dt);

  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});

jQuery( document ).ready(function( $ ) {
  $('.detail').live('click', function(e){
        document.getElementById("detailcontent").innerHTML='<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
        CityName  = $(this).attr("CityName")
        id  = $(this).attr("id")
        datestart  = $(this).attr("datestart")
        dateend  = $(this).attr("dateend")
        $('.modal-title').text("Customer List "+CityName)
        get(id, datestart, dateend);
  });
  function get(id) {
    xmlHttp=GetXmlHttpObject()
      var url="<?php echo base_url();?>report/report_customer_city_detail"
      url=url+"?id="+id
      // alert(url);
      xmlHttp.onreadystatechange=stateChanged
      xmlHttp.open("GET",url,true)
      xmlHttp.send(null)
  }
  function stateChanged(){
      if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
          document.getElementById("detailcontent").innerHTML=xmlHttp.responseText
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
  $('.detail2').live('click', function(e){
      document.getElementById("detailcontent2").innerHTML='<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
      customer  = $(this).attr("customer")
      customerid  = $(this).attr("customerid")
      $('.modal-title').text("Detail Customer "+customer)
      get2(customerid);
      //   
      //   var
      // id  = $(this).attr("customerid")
      // 
      // //$('<tr id="detail"><td colspan="7"><div id="detailcontentAjax"></div></td></tr>').insertAfter($(this).closest('tr'));
      // get2(id);
  });
  function get2(customerid) {
  xmlHttp=GetXmlHttpObject()
    xmlHttp=GetXmlHttpObject()
    var url="<?php echo base_url();?>master/customer_list_detail"
    url=url+"?a="+customerid
    // alert(url);
    xmlHttp.onreadystatechange=stateChanged2
    xmlHttp.open("GET",url,true)
    xmlHttp.send(null)
  }
  function stateChanged2(){
      if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
          document.getElementById("detailcontent2").innerHTML=xmlHttp.responseText
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

  // window.setTimeout(function(){location.reload()},60000);
  $('#approve').live('click',function(e){
    var
      user = $(this).attr('data');
      ActivityID = $(this).attr('ActivityID');
      par  = $(this).parent().parent();
      Approval1  = par.find("td:nth-child(4)").html();
      Approval2  = par.find("td:nth-child(5)").html();
      Approval3  = par.find("td:nth-child(6)").html();
      data = {user:user, ActivityID:ActivityID, Approval1:Approval1, Approval2:Approval2, Approval3:Approval3 };
      $.ajax({
        url: "<?php echo base_url();?>approval/approve_marketing_activity_act/approve",
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
      ActivityID = $(this).attr('ActivityID');
      par  = $(this).parent().parent();
      Approval1  = par.find("td:nth-child(4)").html();
      Approval2  = par.find("td:nth-child(5)").html();
      Approval3  = par.find("td:nth-child(6)").html();
      data = {user:user, ActivityID:ActivityID, Approval1:Approval1, Approval2:Approval2, Approval3:Approval3 };
      $.ajax({
        url: "<?php echo base_url();?>approval/approve_marketing_activity_act/reject",
        type : 'POST',
        data : data,
        success : function (response) {
          window.location.href = "<?php echo current_url(); ?>";
        }
      })
  });  
});   
</script>