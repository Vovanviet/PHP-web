<?php
session_start();
if(isset($_SESSION["loggedin"])&& $_SESSION(["loggedin"])===true){
    header("location:index.php");
    exit;
}
require_once "config.php";
$username=$password="";
$username_err=$password_err=$loggin_err="";
if($_SERVER["REQUES_METHOD"]=="POST"){
    if(empty(trim($_POST["username"]))){
        $username_err="Please enter username";
    }else{
        $username=trim($_POST["username"]);
    }
    if(empty(trim($_POST["password"]))){
        $password_err="Please enter your password";
    }else{
        $password=trim($_POST["password"]);
    }
    if(empty($username_err)&& empty($password_err)){
        $sql="Select id,username,password FROM users WHERE username=?";
        if($stmt=mysqli_prepare($mysqli,$sql)){
            mysqli_stmt_bind_param($stmt,"s",$param_username);
            $param_username=$username;
            
        if(mysqli_stmt_execute ($stmt) ){

            mysqli_stmt_store_result ($stmt);

                if(mysqli_stmt_num_rows ($stmt) == 1) {
            
                    mysqli_stmt_bind_result ($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch ($stmt) ){
                        if(password_verify($password, $hashed_password) ){
                        
                        session_start ();
                        
                        $_SESSION["loggedin"] = true;
                        $_SESSION[" id"] = $id;
                        $_SESSION["username"]= $username;
                        header("location:index.php");
                        }else{
                            $loggin_err="Invalid username or password";
                        }
                    }
                }else{
                    $loggin_err="Invalid username or password";
                }
            }else{
                    echo "Oops! Something went wrong.Please try again later";
                }
                mysqli_stmt_close($stmt);
            }
        }
        mysqli_close($mysqli);
    }


