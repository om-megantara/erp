
<head>
	<script src="<?php echo base_url();?>tool/jquery8.js"></script>
	<link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>tool/favicon.png"/> 
	<link href="//db.onlinewebfonts.com/c/90c8de006caf7a6d22c680771a2305a2?family=Swis721+Cn+BT" rel="stylesheet" type="text/css"/>

	<title>Label Contact <?php echo $ContactID; ?></title>
	<style type="text/css">
		@font-face {font-family: "Swis721 Cn BT"; src: url("//db.onlinewebfonts.com/t/90c8de006caf7a6d22c680771a2305a2.eot"); src: url("//db.onlinewebfonts.com/t/90c8de006caf7a6d22c680771a2305a2.eot?#iefix") format("embedded-opentype"), url("//db.onlinewebfonts.com/t/90c8de006caf7a6d22c680771a2305a2.woff2") format("woff2"), url("//db.onlinewebfonts.com/t/90c8de006caf7a6d22c680771a2305a2.woff") format("woff"), url("//db.onlinewebfonts.com/t/90c8de006caf7a6d22c680771a2305a2.ttf") format("truetype"), url("//db.onlinewebfonts.com/t/90c8de006caf7a6d22c680771a2305a2.svg#Swis721 Cn BT") format("svg"); }

		@media only print {
			a.noprint, .divShipTo, .divphone{
			    display:none !important;
			}

			thead.mainThead { display: table-header-group; }
			tfoot.mainTfoot { display: table-footer-group; }
		}
		@page { size: 10cm 10cm; }
		body { margin: 0px !important; }
		.content td {
			font-family: Swis721 Cn BT;
			letter-spacing: 0px;
			font-size: 20px !important; 
		}

		thead.mainThead > tr { width: 501px; height: 501px;}
		.content table tr td { padding: 2px; } 
		.center { text-align: center; }
		.right { text-align: right; }
		.left { text-align: left; }
		
		table {
			border-collapse: collapse; 
		}

		.atas2 td{
			font-size: 12px !important; 
			font-weight: bolder;
			padding: 0px !important;
		}
		.atas{
			font-size: 12px;
			margin-top: -40px;
		}
		.atas strong { font-size: 15px; }
		.noprint {
			margin: -20px 2px;
			background-color: #f44336;
		    color: white;
		    padding: 5px 20px;
		    text-align: center;
		    text-decoration: none;
		    display: inline-block;
		    font-size: 12px;
		    margin-bottom: -20px;
		} 
		.divShipTo { margin-top: 10px; }
		.divphone { margin-top: 10px; }
	</style>
</head>

<body>
	<div class="content">
		<table width="501px" height="501px" border=0 style="background-color: white";>
			<tr>
				<td height="200px" style="vertical-align: top; text-align: left; padding-left: 70px;">
					<img src="<?php echo base_url();?>tool/logokop.png" height="210px" style="max-width: 501px; max-height: 150px;">
				</td>
				<td colspan=2 >
					<b>
						<p class="atas" align="left">
							<strong>PT ANGHAUZ INDONESIA</strong><br>
							MARGOMULYO<br>
							SURABAYA 60183<br>
							JAWA TIMUR, INDONESIA<br>
							<table class="atas2">
								<tr><td >T. </td><td>+62.31.749.8801</td></tr>
								<tr><td >F. </td><td>+62.31.749.8802</td></tr>
								<tr><td >WA. </td><td>+62.81.974.688.65</td></tr>
								<tr><td><br></td></tr>
								<tr><td >W. </td><td>www.anghauz.com</td></tr></table>
						</p>
					</b>
				</td>
			</tr>
			<tr height="50px";>
				<td></td>
				<td align="left">
					<strong>
						SHIP TO: <br>
						<span class="ShipToSpan"><?php echo $NameFirst;?></span>
					</strong>
				</td>
				<td></td>
			</tr>
			<tr height="90px";>
				<td width="200px"></td>
				<td align="left" >
					<strong><?php echo $Company;?></strong><br>
					<?php echo $address;?><br>
					<span class="PhoneSpan"><?php echo $phone;?></span>
				</td>
				<td></td>
			</tr>
			<tr>
				<td align="left" colspan="3"> 
					<img src="<?php echo base_url();?>tool/logobawah.png" height="210px" style="max-height: 100px;width: 520px;margin-top: 30px;">
				</td>
			</tr>
			<tr>
				<td align="center" colspan="3"></td>
			</tr>
		</table> 
	</div>
</body>
<br>
<a href="#" id="noprint" class="btn-header noprint" autofocus>Print</a>
<div class="divShipTo">
	<input type="text" name="ShipTo" class="ShipTo" placeholder="Ship To">
	<button class="submitShipTo">Edit</button>
</div>
<div class="divphone">
	<input type="text" name="ShipPhone" class="ShipPhone" placeholder="Phone">
	<button class="submitphone">Edit</button>
</div>

<script> 
$( "#noprint" ).click(function() {
  	window.print();
});	
$( ".submitShipTo" ).click(function() {
  	$( ".ShipToSpan" ).html( $( ".ShipTo" ).val()  )
});	
$( ".submitphone" ).click(function() {
  	$( ".PhoneSpan" ).html( $( ".ShipPhone" ).val()  )
});
</script> 
