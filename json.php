<?php
//http://stackoverflow.com/a/2467974
require_once 'config.php';

//store the entire response
$response = array();

//the array that will hold the titles and links
$posts = array();

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT ROUND(AVG(suhu), 2) AS suhu,
       ROUND(AVG(kelembaban), 2) AS kelembaban,
       ROUND(AVG(debu), 2) AS debu,
       CAST(created_at AS DATE) AS tanggal
FROM data_sensor
GROUP BY CAST(created_at AS DATE)";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
while($row=$result->fetch_assoc()){
    $suhu=$row['suhu'];
    $kelembaban=$row['kelembaban'];
    $debu=$row['debu'];
    $tanggal=$row['tanggal'];

    //each item from the rows go in their respective vars and into the posts array
    //$posts[] = array('suhu'=> $suhu, 'kelembaban'=> $kelembaban, 'debu'=> $debu, 'tanggal'=> $tanggal);
    $posts[] = array($suhu, $tanggal);
  }
} else {
  echo "0 results";
}


//the posts array goes into the response
$response = $posts;
//$response['posts'] = $posts;

//creates the file
$fp = fopen('./angular/api/data_sensor.json', 'w');
fwrite($fp, json_encode($response));
fclose($fp);

echo json_encode($response);
$conn->close();
//
// $query="SELECT * FROM datasensor";
//
// $result=$mysqli->query($query)
// 	or die ($mysqli->error);
//
//
//
// /* Final Output
// {"posts": [
//   {
//     "title":"output_from_table",
//     "url":"output_from_table"
//   },
//   ...
// ]}
// */
?>
