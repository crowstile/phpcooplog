<?php 
/* 
Author: Nathan Rowbottom 
Date: 2024/04/25

Use to authenticate the user
Given: POST with username and password
Returns: user id table object if the login information matches the database. If it doesn't match returns false.
*/
    include 'config.php';
    
    $login_name = trim(preg_replace("/[^A-Za-z0-9\-.!@#$%^&*?_ ']/", '', $_POST['email']));//this is the u_id 
    $password = trim(preg_replace("/[^A-Za-z0-9\-.!@#$%^&*?_ ']/", '', $_POST['password']));
    $password = sha1($password);

    $sql = "SELECT * FROM `users` WHERE `username` = ? and `password` = ?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$login_name, $password]);
    if ($result)
    {
        if (count($stmt->fetch()) != 0)
        {
            //$stmt->execute([$login_name, $password]);
            $user = $stmt->fetch();
            unset($user->password);
            echo json_encode($user->username);
        }
        else 
        {
            echo json_encode(false);
        }
    }
    else 
    {
        echo json_encode("Error");
    }
?>