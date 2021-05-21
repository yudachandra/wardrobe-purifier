<?php

require_once 'angular/config.php';
//include('angular/config.php');
    try {
          $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
            // execute the stored procedure
            $sql = 'CALL GetCustomers()';
            // call the stored procedure
            $q = $pdo->query($sql);
            $q->setFetchMode(PDO::FETCH_ASSOC);
        }
    catch (PDOException $e) {
            die("Error occurred:" . $e->getMessage());
        }

if(isset($_POST['register'])){

    // filter data yang diinputkan
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    // enkripsi password
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);


    // menyiapkan query
    // INSERT INTO `Customer`(`customer_id`, `customer_name`, `phone`, `password`, `email`, `address`, `status`)
    // VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7])
    $sql = "INSERT INTO Customer (customer_name, phone, password, email, address, status)
            VALUES (:customer_name, :phone, , :password, :email, :address, 1)";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":name" => $name,
        ":username" => $username,
        ":password" => $password,
        ":email" => $email
    );

    // eksekusi query untuk menyimpan ke database
    $saved = $stmt->execute($params);

    // jika query simpan berhasil, maka user sudah terdaftar
    // maka alihkan ke halaman login
    if($saved) header("Location: login.php");
}

?>
