<?php 
/*
Author Nathan Rowbottom June 8 2022
A variety of functions which are used to suppliment fetchAPI calls in some way.
*/

/*
used to get all the keys of specified table.  
These are then used to generate the select drop down lists.
The getFieldValues function below is used to generate the select options for each trait.
*/

function getKeys($pdo, $table ){
    try{
        $sql = "DESCRIBE $table";//SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLSCHEMA = _NAME =";
        $stmt= $pdo->prepare($sql);
        $stmt->execute();
        $post = $stmt->fetchAll(PDO::FETCH_COLUMN);
        if (!empty($post)){
            return $post;
        }

        return null;
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

/*
used to get values for drop down lists for forms to in turn create 
the post array for the next function
*/
function getFieldValues($pdo, $table, $column){
    //form the query string
    $sql = "SELECT '$column' FROM `$table`";

    try{

        $stmt= $pdo->prepare($sql);
        $stmt->execute();
        $dbResponse = $stmt->fetchAll();

        while($dbResponse[array_key_last($dbResponse)] == NULL){
            array_pop($dbResponse);
        }
           
        if (!empty($dbResponse)){
            return $dbResponse;
        }
        return null;
    }
    catch(PDOException $e) {
        echo "getFieldValues Error: " . $e->getMessage();
    }

}

/* 
This is used to generate the Query to get the key value pairs from a table based on 
based on the input into a post array. 
NOTE: this is made to work with the fetchAll function below
*/
function formQuery($POST, $table){
    $sql = "SELECT * FROM `$table` WHERE ";
    unset($_POST['sub_que']);
    foreach ($_POST as $key => $val){
        if (!empty($val)){
            $sql .= "`$key` = '$val'";

            if ($key != array_key_last($_POST)){
                $sql .= " AND ";
            }
    
        }
    }
    $andLength = strlen(substr($sql, strrpos($sql, ' AND ')));
    $sql = substr($sql, -strrpos($sql, '/'), -$andLength);
    return $sql;

}

/* Given a properly constructed PDO and the query string formed by the function above.
    Returns the array of objects*/

function fetchAll($pdo, $sql){
    try{

        $stmt= $pdo->prepare($sql);
        $stmt->execute();
        $dbResponse = $stmt->fetchAll();
    
        if (!empty($dbResponse)){
            return $dbResponse;
        }
        return null;
    }
    catch(PDOException $e) {
        echo "fetchAll Error: " . $e->getMessage();
    }
}

?>