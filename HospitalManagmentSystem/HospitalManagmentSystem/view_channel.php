<?php
session_start();
if($_SESSION["isLogin"] != true)
{
	header("location: login.php");
}
?>

<html>
<head>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

	

</head>


<body>

	<?php 
		if($_SESSION["utype"] == 1)
		{
			include("header.php");
		}
		else if($_SESSION["utype"] == 2)
		{
			include("header1.php");
		}

		else if($_SESSION["utype"] == 3)
		{
			include("header2.php");
		}
	?>
	
	<br>
	<div class="container-fluid"> 
	<div class="row">
		<div align="left">
					<input text="hidden" class="form-control" value="<?php echo $_SESSION['id'];?>" id="logid" name="logid" size="30px" required>
		</div>

		<div class="col-sm-12">
			<div class="panel-body">
				<table id="tbl-channel" class="table table-responsive table bordered" cellpadding="0" width="100%">
					<thead>
						<tr>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>				
						</tr>
					
					</thead>
				</table>	
		
			</div>
		</div>
	</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	
	<script src="compn/jquery.validate.min.js"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	
	<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	
	
	<script>
		getall(); 
		
		function getall()
		{
			$('#tbl-channel').dataTable().fnDestroy();
			
			var logid = $('#logid').val();
			
			$.ajax({
				
				
				
				
				
				url : "php/channel/all_channel.php",
				type : "POST",
				dataType : "JSON",
				data : {logid : logid},
				
				success : function(data)
				{
					$('#tbl-channel').html(data);
					$('#tbl-channel').dataTable({
						
						"aaData" : data,
						"scrollX" : true,
						"aoColumns" : [
						
						{"sTitle" : "Channel No","mData" : "chno"},
						{"sTitle" : "Doctor Name","mData" : "dname"},
						{"sTitle" : "Patient Name","mData" : "pname"},
						{"sTitle" : "Room No","mData" : "rno"},
						{"sTitle" : "Date","mData" : "date"},
						
						
						]
						
					});
					
				}
				
			});
			
			
		}
		
	function getPres(id)
	{
		window.location.href="add_pres.php?id=" +id;
	}		
	
</script>
	
	
	
	
	
	
	

</body>
</html>