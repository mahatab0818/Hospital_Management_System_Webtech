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
			<form id="frmdoctor" class="card">
				<div align="left">
					<h3>Doctor</h3>
				</div>
				
				<div align="left">
					<label class="form-label">Doctor No.</label>
					<input type="text" class="form-control" placeholder="Doctor No" id="dno" name="dno" size="30px" required>
				</div>

				<div align="left">
					<label class="form-label">Doctor Name</label>
					<input type="text" class="form-control" placeholder="Doctor Name" id="dname" name="dname" size="30px" required>
				</div>

                <div align="left">
					<label class="form-label">Specialization</label>
					<input type="text" class="form-control" placeholder="Specialization" id="Special" name="Special" size="30px" required>
				</div> 
                <div align="left">
					<label class="form-label">Qualification</label>
					<input type="text" class="form-control" placeholder="Qualification" id="quali" name="quali" size="30px" required>
				</div> 

                <div align="left">
					<label class="form-label">Fee</label>
					<input type="text" class="form-control" placeholder="Fee" id="fee" name="fee" size="30px" required>
				</div> 	
					
				<div align="left">
					<label class="form-label">Phone</label>
					<input type="text" class="form-control" placeholder="Phone" id="phone" name="phone" size="30px" required>
				</div> 	
				
				<div align="left">
					<label class="form-label">Room No</label>
					<input type="text" class="form-control" placeholder="Room No" id="rno" name="rno" size="30px" required>
				</div> 

                <div align="left">
					<input type="hidden" class="form-control" value="<?php echo $_SESSION['id']?>" id="logid" name="logid" size="30px" required>
				</div>




				</br>
				<div align="right">
					<button type="button" id="save" class="btn btn-info" onclick="addDoctor()">Add Doctor</button>
					<button type="button" id="clear" class="btn btn-warning" onclick="reset()">Reset</button>
					
					
				</div> 
			</form>
		
		</div>
		
		<div class="col-sm-8">
			<div class="panel-body">
				<table id="tbl-doctor" class="table table-responsive table bordered" cellpadding="0" width="100%">
					<thead>
						<tr>
							<th></th>
							<th></th>
							<th></th>
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
		var doctor_id = null;
		
		getAutoid();
		
		function getAutoid()
		{
			$('#dno').empty();
			$.ajax({
					type : "GET",
					url : 'php/Doctor/autoid.php',
					dataType : "JSON",
					
					success : function (data){
						
						
						$("#dno").val(data);
					}
				
				
			});
			
			
		}
		
		
		
		
		
		
		
		
		
	
		function addDoctor()
		{
			if($("#frmdoctor").valid())
			{
				var url ='';
				var data='';
				var method='';
				
				if(isNew ==true)
				{
					url='php/Doctor/add_doctor.php'
					data=$('#frmdoctor').serialize();
					method='POST';
				}
				else
				{
					
					url='php/Doctor/edit_doctor.php'
					data=$('#frmdoctor').serialize()+"&doctor_id="+ doctor_id;
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
						alert("Doctor Added ");
					}
					else
					{
						alert("Doctor Updated");
					}
					
					getall();
					$('#frmdoctor')[0].reset();
					$('#dno').removeAttr("disabled");
					
				}
					
					
				});
				
			}
			
				
		}
		function getall()
		{

            var logid = $("logid").val();
            

			$('#tbl-doctor').dataTable().fnDestroy();
			$.ajax({
				
				url : "php/Doctor/all_doctor.php",
				type : "GET",
				dataType : "JSON",
                data : {logid :logid },
				
				success : function(data)
				{
					$('#tbl-doctor').html(data);
					$('#tbl-doctor').dataTable({
						
						"aaData" : data,
						"scrollX" : true,
						"aoColumns" : [
						
						{"sTitle" : "Doctor No","mData" : "doctorno"},
						{"sTitle" : "Doctor Name","mData" : "dname"},
						{"sTitle" : "Special","mData" : "special"},
						{"sTitle" : "Quali","mData" : "qual"},
                        {"sTitle" : "Fee","mData" : "fee"},
						{"sTitle" : "Phone","mData" : "phone"},
						{"sTitle" : "Room","mData" : "room"},
						
						{
						"sTitle" : "Edit",
						"mData" : "doctorno",
						"render" : function(mData,type,row,meta)
						{
							return '<button class="btn btn-success" onclick="getdetails('+ mData+')">Edit</button>';
						}
						
						},
						
						{
						"sTitle" : "Delete",
						"mData" : "doctorno",
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
		url : 'php/Doctor/doctor_return.php',
		dataType : 'JSON',
		data : {doctor_id : id},
		
		success : function(data)
		{
			isNew =false
			
			
			doctor_id = data.doctorno;
			$('#dno').val(data.doctorno);
			$("#dno").attr("disabled","disabled");
			$('#dname').val(data.dname);
			$('#Special').val(data.special);
			$('#quali').val(data.qual);
			$('#fee').val(data.fee);
			$('#phone').val(data.phone);
			$('#rno').val(data.room);

			
			
		}
		
		
		
	});
	
	
	
}		


function removedetails(id)
{
	
	$.ajax({
		
		type : 'POST',
		url : 'php/Doctor/doctor_delete.php',
		dataType : 'JSON',
		data : {doctor_id : id},
		
		success : function(data)
		{
			getall();
			
		}
		
		
		
	});
	
	
	
}		


</script>

</body>
</html>