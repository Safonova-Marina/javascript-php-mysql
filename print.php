<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<title>Form</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" class="href">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css" class="href">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

</head>
<body>
	<div class="form-group">
		<label for="date_from" class="col-sm-1 control-label">Date From: </label>
		<div  class="col-sm-2">
			<input class="form-control" id="date_from"/>
		</div>
		<label for="date_to" class="col-sm-1 control-label">Date To: </label>
		<div  class="col-sm-2">
			<input class="form-control" id="date_to"/>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-4">
			<button type="button" class="btn btn-primary" id="date_filter_show" disabled>Show choosen date</button>
		</div>
	</div>

	<div class="form-group" id="div_sort">
		<label for="sel_sort" class="col-sm-1 control-label">Sort by date:</label>
		<div class="col-sm-2">
			<select class="form-control" id="sel_sort">
				<option>Choose sort method</option>
				<option value="1">From old to new</option>
				<option value="-1">From new to old</option>
			</select>
		</div>
	</div>

	<div class="page-container">
		<div class="form-group text-info col-sm-12" id="total">
			<p id="tot"></p>
			<p id="choos"></p>
		</div>
		<table cellpadding="7" cellspacing="7" class="table table-hover table-responsive" id="res_tab">
			<thead>
				<th>User Id</th>
				<th>User Name</th>
				<th>Name</th>
				<th>Email</th>
				<th>Text Comment</th>
				<th>IP</th>
				<th>Date</th>
				<th>Path to file</th>
			</thead>
			<tbody>
				<?php
				include("./connect.inc.php");
				$strSQL1 = "SELECT * FROM users";
				$result = mysql_query($strSQL1) or die("He могу выполнить запрос t_user!");

				if($result) {
					while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
						?>
						<tr>
							<td><?=$row['user_id']?></td>
							<td><?=$row['user_name']?></td>
							<td><?=$row['name']?></td>
							<td><?=$row['email']?></td>
							<td><?=rawurldecode($row['text_com'])?></td>
							<td><?=$row['ip']?></td>
							<td><?=$row['date_create']?></td>
							<td><?=$row['path_file']?></td>
						</tr>
						<?php
					}
				}
				else if(!$row = mysql_fetch_array($result))
					echo '<tr>
				<td colspan="5">No Data</td>
			</tr> ';
			?>  
		</tbody> 
	</table>
</div>

<script type="text/javascript">
	var grid1 = document.getElementById('res_tab');
	var tbodyStart = $('tbody')[0];
	var date_start = '';
	var date_to = '';
	var rowsArrayStart = [].slice.call(tbodyStart.rows);
	$('#total #tot').html("Total users: " + rowsArrayStart.length);
	$('#date_from, #date_to').datepicker({
		dateFormat: 'yy-mm-dd',
		onSelect: function (date) {
			var id = this.id;
			if(id == 'date_from') date_start = date;
			if(id == 'date_to') date_to = date;
			$('#date_filter_show').removeAttr('disabled');

		}
	});
	$('#date_filter_show').click(function(){
		if (date_start == '') date_start = '2017-04-09';
		if (date_to == '') {
			var new_date = new Date();
			date_to = new_date.getFullYear() + '-' + (new_date.getMonth()<10? '0':'') + (new_date.getMonth()+1) + '-' + (new_date.getDate()<10? '0':'') + new_date.getDate();
		}	
		if(date_start > date_to) {
			var dat1 = date_start;
			date_start = date_to;
			date_to = dat1;
		}
		filterGrid(rowsArrayStart, date_start, date_to);
	});

	$('#div_sort').change(function(){
		sortGrid($('#sel_sort').val());
	});
	var grid = document.getElementById('res_tab');	
	function sortGrid(style) {
		var tbody = $('tbody')[0];
		var rowsArray = [].slice.call(tbody.rows);
		var compare = function(rowA, rowB) {
			return rowA.cells[6].innerHTML > rowB.cells[6].innerHTML ? style : (-1)*style;
		};;
		rowsArray.sort(compare);
		grid.removeChild(tbody);
		for (var i = 0; i < rowsArray.length; i++) {
			tbody.appendChild(rowsArray[i]);
		}
		grid.appendChild(tbody);
	}

	function filterGrid(rowsArrayStart, strStart, strEnd) {
		var tbody = $('tbody')[0];
		tbody.innerHTML = '';
		var rowsArrayNew = rowsArrayStart.filter(function(rowA){
			return (rowA.cells[6].innerHTML > strStart) && (rowA.cells[6].innerHTML.substr(0,10) <= strEnd);
		})
		$('#total #choos').html("Selected users: " + rowsArrayNew.length);
		for (var i = 0; i < rowsArrayNew.length; i++) {
			tbody.appendChild(rowsArrayNew[i]);
		}
		grid.appendChild(tbody);
	}
</script>
</body>
</html>