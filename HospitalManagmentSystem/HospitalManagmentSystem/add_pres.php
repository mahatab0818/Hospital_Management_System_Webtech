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
		<div class="col-sm-4">
			<form id="frmpres" class="card">
				<div align="left">
					<h3>Prescription</h3>
				</div>
				
				<div align="left">
					<label class="form-label">Prescription No.</label>
					<input type="text" class="form-control" placeholder="Prescription No" id="presno" name="presno" size="30px" required>
				</div>
				<div align="left">
					<label class="form-label">Patient Name</label>
					<select class="form-control"  id="pname" name="pname">
						<option value="">Please select</option>
					</select>
				</div> 	
				
				<div align="left">
					<label class="form-label">Disease</label>
					<input type="text" class="form-control" placeholder="Disease" id="dtype" name="dtype" size="30px" required>
				</div> 
				<div align="left">
					<label class="form-label">Description</label>
					<input type="text" class="form-control" placeholder="Description" id="des" name="des" size="30px" required>
				</div> 

				</br>
				<div align="right">
					<button type="button" id="save" class="btn btn-info" onclick="addPres()">Add</button>
					<button type="button" id="clear" class="btn btn-warning" onclick="reset()">Reset</button>
					
					
				</div> 
			</form>
		
		</div>
		
		<div class="col-sm-8">
			<div class="panel-body">
				<table id="tbl-pres" class="table table-responsive table bordered" cellpadding="0" width="100%">
					<thead>
						<tr>
							<th></th>
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
		getPatient();

	
		var isNew =true;
		
		var pres_id = null;
		
		getAutoid();


		function getPatient() {
			$.ajax({

				type : "GET",
				url : "get_patient.php",
				dataType : "JSON",

				success :function(data){
					for(var i=0 ; i< data.length ; i++)
					{
						$('#pname').append($("<option/>",
						{
							value : data[i].patientno,
							text : data[i].name,
						}));
						
					}

				}
				
			})
			
		}
		
		function getAutoid()
		
		{
			$('#presno').empty();
			$.ajax({
					type : "GET",
					url : 'php/prescription/autoid.php',
					dataType : "JSON",
					
					success : function (data){
						
						
						$("#presno").val(data);
					}
				
				
			});
			
			
		}
		
		
		
		
		
		
		
		
		
	
		function addPres()
		{
			if($("#frmpres").valid())
			{
				var url ='';
				var data='';
				var method='';
				
				if(isNew ==true)
				{
					url='php/prescription/add_pres.php'
					data=$('#frmpres').serialize();
					method='POST';
				}
				else
				{
					
					url='php/prescription/edit_pres.php'
					data=$('#frmpres').serialize()+"&pres_id="+ pres_id;
					method='POST';
					
				}
				
				$.ajax({
					
					type : method,
					url : url,
					dataType : 'JSON',
					data : data,
					
				success:function(data)
				{
					if(isNEW ==true)
					{
						alert("Pres Booked");
					}
					else
					{
						alert("Channel Updated");
					}
					
					getall();
					$('#frmpres')[0].reset();
					$('#presno').removeAttr("disabled");
					
				}
					
					
				});
				
			}
			
				
		}
		function getall()
		{
			$('#tbl-pres').dataTable().fnDestroy();
			$.ajax({
				
				url : "php/prescription/all_pres.php",
				type : "GET",
				dataType : "JSON",
				
				success : function(data)
				{
					$('#tbl-pres').html(data);
					$('#tbl-pres').dataTable({
						
						"aaData" : data,
						"scrollX" : true,
						"aoColumns" : [
						
						{"sTitle" : "Prescription No","mData" : "pid"},
						{"sTitle" : "Patient Name","mData" : "pname"},
						{"sTitle" : "Disease","mData" : "dtype"},
						{"sTitle" : "Description","mData" : "des"},
						{
						"sTitle" : "Edit",
						"mData" : "pid",
						"render" : function(mData,type,row,meta)
						{
							return '<button class="btn btn-success" onclick="getdetails('+ mData+')">Edit</button>';
						}
						
						},
						
						{
						"sTitle" : "Delete",
						"mData" : "pid",
						"render" : function(mData,type,row,meta)
						{
							return '<button class="btn btn-danger" onclick="removedetails('+ mData+')">Delete</button>';
						}
						
						},
						
						
						]
						
					});
					
				}
				
			});
			
			
		}
		
function getdetails(id)
{
	$.ajax({
		
		type : 'POST',
		url : 'php/prescription/pres_return.php',
		dataType : 'JSON',
		data : {pres_id : id},
		
		success : function(data)
		{
			isNew =false
			
			
			pres_id = data.pid;
			$('#presno').val(data.pid);
			$("#presno").attr("disabled","disabled");
			$('#pname').val(data.pname);
			$('#dtype').val(data.dtype);
			$('#des').val(data.des);

			
		}
		
		
		
	});
	
	
	
}		


function removedetails(id)
{
	
	$.ajax({
		
		type : 'POST',
		url : 'php/prescription/pres_delete.php',
		dataType : 'JSON',
		data : {pres_id : id},
		
		success : function(data)
		{
			getall();
			
		}
		
		
		
	});
	
	
	
}		
		
		
		
	
</script>
	
	
	
	
	
	
	

</body>
</html>