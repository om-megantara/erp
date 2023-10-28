<?php
$company 	= (array) $content['company'];
$warehouse 	= (array) $content['warehouse'];
$po 		= (array) $content['po'];
$Supplier 	= explode(";", $po['SupplierNote']);
$Product 	= $content['product'];
if (array_key_exists('raw', $content)) {
	$Raw = $content['raw'];
}

$opts=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);  
$f 		= fopen(('./tool/HeaderFaktur1.txt'), "r", false, stream_context_create($opts)); 
$npwp 	= fgets($f);
fclose($f);
$alamat = explode(";", $npwp);

if ($po['POType'] == "local") {
	$npwptitle = "NPWP";
} elseif ($po['POType'] == "import") {
	$npwptitle = "Tax Identification Number";
}

?>
<head>
	<link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>tool/favicon.png"/> 
	<title><?php echo $PageTitle.' - '. $MainTitle; ?></title>
	<style type="text/css">
		@media only print {
		    a.noprint, input#size {
			    display:none !important;
			}
			thead.main { display: table-header-group; }
			tfoot.main { display: table-footer-group; }
		}
		@page { 
			size: potrait; 
			counter-increment: page; 
		}
		
		a.noprint {
			margin: 10px;
			background-color: #f44336;
		    color: white;
		    padding: 10px 120px;
		    text-align: center;
		    text-decoration: none;
		    display: inline-block;
		    font-size: 12px;
		    margin-bottom: -20px;
		}
		a.Attachment {
			margin: 3px 2px;
			background-color: #4cae4c;
		    color: white;
		    padding: 2px 5px;
		    text-align: center;
		    text-decoration: none;
		    display: inline-block;
		    font-size: 12px;
		}

		.content {
			font-family: Arial, Helvetica, sans-serif;
			width: 750px;
		}
		.content table tr td { padding: 5px; }
		.header-company { text-align: center; }
		.header-company td { border: 0px !important; }
		.header-company h2, .header-company h6 { margin: 0px; }
		.header-po1>td { border: 1px solid #000; }
		.header-po1>td:first-child { width: 170px; }
		.header-po1>td:nth-child(2) { width: 370px; }
		.header-po1 .poid td{ font-weight: bolder; font-size: 20px !important; }
		.header-po1, .header-po1 tr { vertical-align: top;}
		.header-po1 table tr td { border: 1px !important; font-size: 12px; padding: 0px;}
		td.detail {	font-weight: bold; }
		.shipto h4, .shipto h5, .shipto h6 { margin: 0px; }

		.productlist th { border-bottom: 2px solid #000; }
		.productlist tbody { font-size: 12px; }
		.productlist tr td { border-bottom: 1px dashed #000 !important; }
		.productqty, .productdisc { text-align: center; }
		.productprice, .producttotal { text-align: right; }

		.total .cell1{ 
			width: 350px; 
			font-size: 12px;
			font-weight: bold;
			border: 1px solid #000;
			vertical-align: top;
		}
		.cell2 table { font-size: 12px; font-weight: bold;}
		.cell2 table tr td { padding: 0px !important; }
		.cell2 table tr td:first-child { width: 250px; }

		.sign tr td{
			border: 1px solid #000;
			width: 20%;
			vertical-align: bottom;
			text-align: center;
			font-size: 12px;
			font-weight: bold;
		}
		.sign tr:first-child td{ height: 50px; }
		table { border-collapse: collapse; }
		.footer { 
			font-size: 10px;
			border-top: 1px solid #000;
		}
		#pageNumber { float: right; }

		.raw { 
			font-size: 12px;
			margin-left: 30px;
			background-color: #c4c4c4;
		}
		.raw tbody tr td:first-child { width: 400px; }
		.pocancel {
			background: url("<?php echo base_url();?>tool/cancel.png") no-repeat;
			background-position-x: center;
		}
		.ProductID { display: inline; }
	</style>

</head>

<?php if ($po['POStatus'] == "2" ) { ?>
<body class="pocancel">
<?php } else { ?>
<body>
<?php } ?>

<div class="content">
	<table>
	</table>
</div>


</body>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script>
$( "#noprint" ).click(function() {
  	window.print();
});	

$('#size').live( "keyup", function() {
    size  = $(this).val();
    $(".productname").css('font-size',size);
    $(".productqty").css('font-size',size);
    $(".productdisc").css('font-size',size);
    $(".productprice").css('font-size',size);
    $(".producttotal").css('font-size',size);
    $(".rawname").css('font-size',size);
    $(".rawqty").css('font-size',size);
});
</script>