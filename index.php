<?php
    

/* 
Author: Nicodemus Allan 
Date: 2022/06/29

Use to authenticate the user
Given: POST with username and password
Returns: user id table object if the login information matches the database. If it doesnet match returns false.
*/
    include 'config.php';
    
    $login_name = trim(preg_replace("/[^A-Za-z0-9\-.!@#$%^&*?_ ']/", '', $_POST['email']));//this is the u_id 
    $password = trim(preg_replace("/[^A-Za-z0-9\-.!@#$%^&*?_ ']/", '', $_POST['password']));
    $password = sha1($password);

    $sql = "SELECT * FROM `users` WHERE `u_id` = ? and `password` = ?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$login_name, $password]);
    if ($result)
    {
        if (count($stmt->fetch()) != 0)
        {
            $stmt->execute([$login_name, $password]);
            $user = $stmt->fetch();
            unset($user->password);
            echo json_encode($user->u_id);
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