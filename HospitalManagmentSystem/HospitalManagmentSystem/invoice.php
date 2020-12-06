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
	<div class="col-sm-11">
		<form id="frm-invoice">
			<table class="table table-bordered">
			<tr>
				<th>Item Code</th>
				<th>Item Name</th>
				<th>Price</th>
				<th>Qty</th>
				<th>Amount</th>
				<th>Option</th>
			</tr>
			<tr>
				<td>
					<input type="text" class="form control" placeholder="Item Code" id="icode" name="icode"size="30px" required>
				</td>
				<td>
					<input type="text" class="form control" placeholder="Item Name" id="iname" name="iname"size="30px" required>
				</td>
				<td>
					<input type="text" class="form control" placeholder="Price" id="price" name="price"size="30px" required>
				</td>
				<td>
					<input type="number" class="form control" placeholder="Qty" id="qty" name="qty"size="30px" required>
				</td>
				<td>
					<input type="text" class="form control" placeholder="Amount" id="amount" name="amount"size="30px" required>
				</td>
				<td>
					<button type="button" class="btn btn-info" onclick="additem()">Add</button>
				</td>
			</tr>
			</table>
		</form>
		
		<table id="tbl-item" class="table table-bordered">
		
			<thread>
			<tr>
				<th>Delete</th>
				<th>Item No</th>
				<th>Price</th>
				<th>Qty</th>
				<th>Total</th>
			</tr>
			<tr>
				<tbody>

				</tbody>
				
			</tr>
			</thred>
		
		
		</table>
	</div>
	<div class="col-sm-12">
	
		<div class="form-group" align="left">
			<label>Total</label>
			<input type="text" class="form-control" placeholder="total" id="total" name="total" size="30px">
		</div>
		<div class="form-group" align="left">
			<label>Pay</label>
			<input type="text" class="form-control" placeholder="Pay" id="pay" name="pay" size="30px">
		</div>
		<div class="form-group" align="left">
			<label>Balance</label>
			<input type="text" class="form-control" placeholder="Balance" id="bal" name="bal" size="30px">
		</div>
			<div class="form-group" align="right">
			<button type="button" class="btn btn-success">Print</button>
			<button type="button" class="btn btn-warning" onclick="reset()">Reset</button>
		</div>
	</div>
</div>	
		
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	
	<script src="compn/jquery.validate.min.js"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	
	<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	

<script>

getItemCode();
	function getItemCode()
	{
		$('#icode').empty();
		$('#icode').keyup(function(e)
		{
			$.ajax({
				type : "POST",
				url : "php/item/get_item.php",
				dataType : "JSON",
			data : { itemcode: $('#icode').val() },
			
			succes : function(data)
			{
				$("#iname").val(data[0].itemname);
				$("#price").val(data[0].sellprice);
				$("#qty").focus();
			}	
		});
		});
	}
$(function(){
	$("#price,#qty").on("keydown,keyup click",tot);
	function tot()
	{
		var sum = (Number($("#price").val()) *  Number($("#qty").val()));
		$('#amount').val(sum); 
	}
});

$(function(){
	$("#total,#pay").on("keydown,keyup click",tot);
	function tot()
	{
		var sum = (Number($("#pay").val()) - Number($("#total").val()));
		$('#bal').val(sum); 
	}
});

var tot=0;
var total=0;
function additem()
{
	var itemcode = $('#icode').val();
	var iname = $('#iname').val();
	var price = $('#price').val();
	var qty = $('#qty').val();
	tot = price * qty;
	
	var table=
	"<tr>" + 
		"<td><button type='button' name='record' class='btn btn-danger' onclick='deleterow(this)'>Delete</td>"+
		"<td>" + itemcode + "</td>" + 
		"<td>" + iname + "</td>" +
		"<td>" + price + "</td>"+
		"<td>" + qty + "</td>"+
		"<td>" + tot + "</td>"+
	"</tr>";
	total +=Number(tot);
	$("#total").val(total);
	$("#tbl-item tbody").append(table);
	
	$('#icode').val('');
	$('#iname').val('');
	$('#price').val('');
	$('#qty').val(1);
	$('#amount').val('');
}
function deleterow(e)
{
	totalcost = parseInt($(e).parent().parent().find('td:last').text(),10);
	total-=totalcost;
	$("#total").val(total);
	$(e).parent().parent().remove();
}

function reset(id)
{
	window.loaction.href = "view_press.php?id=" +id;
}	
	
	
</script>
	
	
	
	
	
	
	

</body>
</html>