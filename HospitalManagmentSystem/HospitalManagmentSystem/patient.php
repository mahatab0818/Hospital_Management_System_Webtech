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
			<form id="frmpatient" class="card">
				<div align="left">
					<h3>Patient</h3>
				</div>
				
				<div align="left">
					<label class="form-label">Patient No.</label>
					<input type="text" class="form-control" placeholder="Patient No" id="pno" name="pno" size="30px" required>
				</div>

				<div align="left">
					<label class="form-label">Patient Name</label>
					<input type="text" class="form-control" placeholder="Patient Name" id="pname" name="pname" size="30px" required>
				</div>
					
				<div align="left">
					<label class="form-label">Phone</label>
					<input type="text" class="form-control" placeholder="Phone" id="phone" name="phone" size="30px" required>
				</div> 	
				
				<div align="left">
					<label class="form-label">Address</label>
					<input type="text" class="form-control" placeholder="Address" id="address" name="address" size="30px" required>
				</div> 
				</br>
				<div align="right">
					<button type="button" id="save" class="btn btn-info" onclick="addPatient()">Add</button>
					<button type="button" id="clear" class="btn btn-warning" onclick="reset()">Reset</button>
					
					
				</div> 
			</form>
		
		</div>
		
		<div class="col-sm-8">
			<div class="panel-body">
				<table id="tbl-patient" class="table table-responsive table bordered" cellpadding="0" width="100%">
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

	
		var isNew =true;
		
		var patient_id = null;
		
		getAutoid();
		
		function getAutoid()
		{
			$('#pno').empty();
			$.ajax({
					type : "GET",
					url : 'php/autoid.php',
					dataType : "JSON",
					
					success : function (data){
						
						
						$("#pno").val(data);
					}
				
				
			});
			
			
		}
		
		
		
		
		
		
		
		
		
	
		function addPatient()
		{
			if($("#frmpatient").valid())
			{
				var url ='';
				var data='';
				var method='';
				
				if(isNew ==true)
				{
					url='php/add_patient.php'
					data=$('#frmpatient').serialize();
					method='POST';
				}
				else
				{
					
					url='php/edit_patient.php'
					data=$('#frmpatient').serialize()+"&patient_id="+ patient_id;
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
						alert("Patient Added ");
					}
					else
					{
						alert("Patient Updated");
					}
					
					getall();
					$('#frmpatient')[0].reset();
					$('#pno').removeAttr("disabled");
					
				}
					
					
				});
				
			}
			
				
		}
		
		function getall()
		{
			$('#tbl-patient').dataTable().fnDestroy();
			$.ajax({
				
				url : "php/all_patient.php",
				type : "GET",
				dataType : "JSON",
				
				success : function(data)
				{
					$('#tbl-patient').html(data);
					$('#tbl-patient').dataTable({
						
						"aaData" : data,
						"scrollX" : true,
						"aoColumns" : [
						
						{"sTitle" : "Patient No","mData" : "patientno"},
						{"sTitle" : "Patient Name","mData" : "name"},
						{"sTitle" : "Phone","mData" : "phone"},
						{"sTitle" : "Address","mData" : "address"},
						
						{
						"sTitle" : "Edit",
						"mData" : "patientno",
						"render" : function(mData,type,row,meta)
						{
							return '<button class="btn btn-success" onclick="getdetails('+ mData+')">Edit</button>';
						}
						
						},
						
						{
						"sTitle" : "Delete",
						"mData" : "patientno",
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
		url : 'php/patient_return.php',
		dataType : 'JSON',
		data : {patient_id : id},
		
		success : function(data)
		{
			isNew =false
			
			
			patient_id = data.patientno
			$('#pno').val(data.patientno);
			$("#pno").attr("disabled","disabled");
			$('#pname').val(data.name);
			$('#phone').val(data.phone);
			$('#address').val(data.address);
			
			
			
		}
		
		
		
	});
	
	
	
}		


function removedetails(id)
{
	
	$.ajax({
		
		type : 'POST',
		url : 'php/patient_delete.php',
		dataType : 'JSON',
		data : {patient_id : id},
		
		success : function(data)
		{
			getall();
			
		}
		
		
		
	});
	
	
	
}		
		
		
	
</script>
	
	
	
	
	
	
	

</body>
</html>