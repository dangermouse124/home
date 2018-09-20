<?php
$servername = "localhost";
$username = "admin";
$password = "slugthepug";
$dbname = "smart_home";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT date_time, temperature FROM temp_10min where sensor_id = '7'";
$result = mysqli_query($conn, $sql);
mysqli_close($conn);


$rows = array();
$table = array();

$table['cols'] = array(
 array(
  'label' => 'Date Time', 
  'type' => 'string' //'datetime'
 ),
 array(
  'label' => 'Temperature', 
  'type' => 'number'
 )
);

while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
// $datetime = explode(".", $row["date_time"]);
 $sub_array[] =  array(
      "v" => $row["date_time"]  //'new Date(' . $datetime[0] . '000)'
     );
 $sub_array[] =  array(
      "v" => $row["temperature"]
     );
 $rows[] =  array(
     "c" => $sub_array
    );
}
$table['rows'] = $rows;
$jsonTable = json_encode($table);
//echo $jsonTable;

?>

<html>
<head>
	<title>Carport Temperature</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart()
	{
	var data = new google.visualization.DataTable(<?php echo $jsonTable; ?>);

	var options = {
	 title:'Carport',
	 color:'black',
	 //vAxis: {title: 'Temperature'},
	 hAxis: {title: 'Ten minute data'},
	 hAxis: {showTextEvery: 50, textStyle: {color: 'white'}},
	 vAxis: {textStyle: {color: 'white'}},
	 backgroundColor:'black',
	 colors:['orange'],
	 legend:{position:'top', textStyle: {color: 'white'}},
	 //legend: {textStyle: {color: 'white'}},
	 chartArea:{width:'95%', height:'80%'}
	};

	var chart = new google.visualization.AreaChart(document.getElementById('line_chart'));

	chart.draw(data, options);
	}
	</script>

</head>  
<body>
<div class="w3-container w3-dark-grey w3-center">
	<div class="w3-card-4">
		<h2>The Carport</h2>
		<br>
		<div id="line_chart" style="width: 100%; height: 500px"></div>
		<br>
	</div>
	<br>
</div>


</body>
</html>