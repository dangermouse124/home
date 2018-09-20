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
$days = $_POST["daystoget"];

$sql = "SELECT date_time, temperature FROM temp_10min WHERE sensor_id = '7' AND (date_time > DATE_SUB(NOW(), INTERVAL $days DAY))";
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
echo $jsonTable;

?>