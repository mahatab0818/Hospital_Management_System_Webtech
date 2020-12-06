
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
			<form id="frmuser" class="card">
				<div align="left">
					<h3>User Creation</h3>
				</div>
				
				<div align="left">
					<label class="form-label">Full Name</label>
					<input type="text" class="form-control" placeholder="Patient No" id="fullname" name="fullname" size="30px" required>
				</div>

				<div align="left">
					<label class="form-label">User Name</label>
					<input type="text" class="form-control" placeholder="User Name" id="uname" name="uname" size="30px" required>
				</div>
					
				<div align="left">
					<label class="form-label">Password</label>
					<input type="password" class="form-control" placeholder="Password" id="pass" name="pass" size="30px" required>
				</div> 	
				
				<div align="left">
					<label class="form-label">User Type</label>
					<select class="form-control" id="utype" name="utype" placeholder = "UserType" required>
						<option value="">Please Select</option>
						<option value="1">Pharmacist</option>
						<option value="2">Doctor</option>
						<option value="3">Receptionist</option>
					
					
					</select>
					
					
				</div> 
				</br>
				<div align="right">
					<button type="button" id="save" class="btn btn-info" onclick="addUser()">Add</button>
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
		
		var user_id = null;
		
		
		function addUser()
		{
			if($("#frmuser").valid())
			{
				var url ='';
				var data='';
				var method='';
				
				if(isNew ==true)
				{
					url='php/user/adduser.php'
					data=$('#frmuser').serialize();
					method='POST';
				}
				else
				{
					
					url='php/user/edituser.php'
					data=$('#frmuser').serialize()+"&user_id="+ user_id;
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
						alert("User Added ");
					}
					else
					{
						alert("User Updated");
					}
					
					getall();
					$('#frmuser')[0].reset();
					$('#pass').removeAttr("disabled");
					
				}
					
					
				});
				
			}
			
				
		}
		
		function getall()
		{
			$('#tbl-patient').dataTable().fnDestroy();
			$.ajax({
				
				url : "php/user/all_user.php",
				type : "GET",
				dataType : "JSON",
				
				success : function(data)
				{
					$('#tbl-patient').html(data);
					$('#tbl-patient').dataTable({
						
						"aaData" : data,
						"scrollX" : true,
						"aoColumns" : [
						
						{"sTitle" : "FullName","mData" : "fullname"},
						{"sTitle" : "Username","mData" : "uname"},
						{
							"sTitle" : "User Type",
						    "mData" : "utype",
							
						    "render" : function(mData,type,row,meta)
						{
							
							if(mData == 1)
							{
								return "<b style='color : green'>Pharmacist</b>"
							}
							else if(mData == 2)
							{
								return "<b style='color : blue'>Doctor</b>"
							}
							else if(mData == 3)
							{
								return "<b style='color : red'>Receptionist</b>"
								
							}
						}
						
						
						},
						
						{
						"sTitle" : "Edit",
						"mData" : "id",
						"render" : function(mData,type,row,meta)
						{
							return '<button class="btn btn-success" onclick="getdetails('+ mData+')">Edit</button>';
						}
						
						},
						
						{
						"sTitle" : "Delete",
						"mData" : "id",
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
		url : 'php/user/user_return.php',
		dataType : 'JSON',
		data : {user_id : id},
		
		success : function(data)
		{
			isNew =false
			user_id = data.id
			$('#pno').val(data.patientno);
			$("#pass").attr("disabled","disabled");
			
			$('#fullname').val(data.fullname);
			$('#uname').val(data.uname);
			$('#utype').val(data.utype);
			
			
			
		}
		
		
		
	});
	
	
	
}		


function removedetails(id)
{
	
	$.ajax({
		
		type : 'POST',
		url : 'php/user/user_delete.php',
		dataType : 'JSON',
		data : {user_id : id},
		
		success : function(data)
		{
			getall();
			
		}
		
		
		
	});
	
	
	
}		
		
		
	
</script>
	
	
	
	
	
	
	

</body>
</html>