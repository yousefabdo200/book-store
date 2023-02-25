<?php
if(isset($_COOKIE['username']))
{
    header("location:index.php");
}
$error_fieleds=array();
$errors="";
session_start();
if($_SERVER['REQUEST_METHOD']=='POST')
{
    $con=mysqli_connect("localhost","root","2002","book_store");
    if(!$con)
    {
        echo "error while connect";
        exit;
    }
    if(isset($_POST['user_name']))
        {
            if($_POST['type']=='trader')
            {
                $query="SELECT * FROM publisher WHERE username='".$_POST['user_name']."' LIMIT 1 ";
            }
            else{
                $query="SELECT * FROM customer WHERE username='".$_POST['user_name']."' LIMIT 1 ";
            }
            $result=mysqli_query($con,$query);
            $row=mysqli_fetch_assoc($result);
            if (!isset($row['username']))
            {
                $r= "No user name found";
            }
            else if(!password_verify($_POST['password'],$row['password']))
            {
                $r= "in vailed  password";
            }
            else{
                $_SESSION['user_name']=$_POST['user_name'];
                $_SESSION['type']=$_POST['type'];
                setcookie("username",$_POST['user_name'],time()+3600*2,"/");
                setcookie("logtype",$_POST['type'],time()+3600*2,"/");
                header("location:index.php");
                //
            }
        }
    
    mysqli_close($con);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">
        <div style=" width:50%">
            <label for="user_name">user name</label>
            <input type="text" id="user_name" name="user_name" placeholder="enter your user name " >
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label for="password"> password</label>
            <input type="password" name="password" id="password" placeholder="enter your password please">
            <?= (isset($r))? $r:"" ?>
            <br>
            <br>
            <label>select account type</label>
            <input type="radio" name="type" value="trader" id="trader">
            <label for="trader">trader</label>
            <input type="radio" name="type" value="customer" id="customer" checked>
            <label for="customer">customer</label>
            <br>
            <a href="sign.php">create new account</a>
            <br>
            <input type="submit" value=" login"  >
        </div>
    </form>
</body>
</html>