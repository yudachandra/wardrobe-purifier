<?php
//http://stackoverflow.com/a/2467974
require_once 'config.php';

//store the entire response
$response_datasensor = array();

//the array that will hold the titles and links
$posts_datasensor = array();

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
  $sql = "SELECT ROUND(AVG(suhu), 2) AS suhu,
         ROUND(AVG(kelembaban), 2) AS kelembaban,
         ROUND(AVG(debu), 2) AS debu,
         DAY(created_at) AS tanggal
  FROM data_sensor
  GROUP BY DAY(created_at)";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
  while($row=$result->fetch_assoc()){
      $tanggal=$row['tanggal'];
      $suhu=$row['suhu'];
      $kelembaban=$row['kelembaban'];
      $debu=$row['debu'];

      //each item from the rows go in their respective vars and into the posts array
      $posts_datasensor[] = array('tanggal'=> $tanggal, 'suhu'=> $suhu, 'kelembaban'=> $kelembaban, 'debu'=> $debu);
    }
  } else {
    echo "0 results";
  }


  //the posts array goes into the response
  $response_datasensor = $posts_datasensor;

  //creates the file
  $fp = fopen('./angular/api/data_sensor.json', 'w');
  fwrite($fp, json_encode($response_datasensor));
  fclose($fp);

  unset($sql);
  $sql = "SELECT suhu AS latest_suhu,
         kelembaban AS latest_kelembaban,
         debu AS latest_debu,
         created_at AS latest_tanggal
  FROM data_sensor ORDER BY created_at DESC LIMIT 1";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
  while($row=$result->fetch_assoc()){
      $tanggal=$row['latest_tanggal'];
      $suhu=$row['latest_suhu'];
      $kelembaban=$row['latest_kelembaban'];
      $debu=$row['latest_debu'];

      //each item from the rows go in their respective vars and into the posts array
      $posts_datasensor_latest[] = array('latest_tanggal'=> $tanggal, 'latest_suhu'=> $suhu, 'latest_kelembaban'=> $kelembaban, 'latest_debu'=> $debu);
    }
  } else {
    echo "0 results";
  }

    //the posts array goes into the response
    $response_datasensor_latest = $posts_datasensor_latest;

    //creates the file
    $fp = fopen('./angular/api/data_sensor_latest.json', 'w');
    fwrite($fp, json_encode($response_datasensor_latest));
    fclose($fp);

  echo json_encode($response_datasensor);
  echo json_encode($response_datasensor_latest);
  $conn->close();
}
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
