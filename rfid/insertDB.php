<?php
     
    require 'database.php';
 
    if ( !empty($_POST)) {
        // keep track post values
        $name = $_POST['name'];
		$id = $_POST['id'];
		$category = $_POST['category'];
        $sleeve = $_POST['sleeve'];
        $color = $_POST['color'];
        
		// insert data
        $pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO table_rfid (name,id,category,sleeve,color) values(?, ?, ?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($name,$id,$category,$sleeve,$color));
		Database::disconnect();
		header("Location: user data.php");
    }
?>