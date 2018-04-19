<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Show errors for debugging
ini_set("display_errors", 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_STRICT); // Needed to report mysqli errors

$prefix = "ajax_";
if( !empty($_POST) ){
    // Post Ajax function
    $function = $prefix . "post_" . $_POST["action"];
    $function();
}
elseif ( !empty($_GET) ) {
    $function = $prefix . "get_" . $_GET["action"];
    $function();
}
else{
    echo "What do you think you are doing? Trying to cheat huh!!!";
}


//function ajax_get_test1(){
//    echo json_encode($_GET);
//}

function ajax_get_test(){
    extract( $_GET );
    include_once 'db_credentials.php';
    include_once 'models/class-birthday-model.php';
    try{
        $bdayModel = new Birthday_Model( $db );
        $birthday = $year ."-". $month ."-". $day;
        $insert = $bdayModel->insert_birthday(array(
            "birthday" => $birthday
        ));
        if( $insert === TRUE ):
            $result = $bdayModel->get_all_birthdays();
            $response["success"] = true;
            $response["data"] = $result;
        endif;
        
    } catch (InvalidArgumentException $ex) {
        echo $ex->getMessage();
    } catch (mysqli_sql_exception $ex){
        echo $ex->getMessage();
    } catch (Exception $ex){
        echo "Some other type of error";
    }

    
    
}

function ajax_post_add_birthday(){
    include_once 'db_credentials.php'; //Includes a $db array, change the array with your own db credentials. 
    include_once 'models/class-birthday-model.php';
    extract( $_POST );
    //Server side vALIDATION HERE
    $response = array(
        "success" => false,
    );
    try{
        
        $bdayModel = new Birthday_Model( $db );
        $birthday = $year ."-". $month ."-". $day;
        $insert = $bdayModel->insert_birthday(array(
            "birthday" => $birthday
        ));
        if( $insert === TRUE ):
            $result = $bdayModel->get_all_birthdays();
            $response["success"] = true;
            $response["data"] = $result;
        endif;
        
    } catch (InvalidArgumentException $ex) {
        $response["error"] = array('code' => $ex->getCode(), 'message' => $ex->getMessage());
    } catch (mysqli_sql_exception $ex){
        $response["error"] = array('code' => $ex->getCode(), 'message' => $ex->getMessage());
    } catch (Exception $ex){
        $response["error"] = array('code' => $ex->getCode(), 'message' => $ex->getMessage());
    } finally {
        echo json_encode($response);
        exit;
    }
    
}

// 500 error means no function is defined to handle the request, possible missing action request