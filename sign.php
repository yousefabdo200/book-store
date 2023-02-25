<?php
$error_feilds=array();
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_SERVER['REQUEST_METHOD']))
{
    $con=mysqli_connect("localhost","root","2002","Book_store");
    if(!mysqli_connect("localhost","root","2002","Book_store"))
    {
        echo mysqli_connect_error();
    }
    else 
    {
        //validation
       if(!isset($_POST['fname'])||$_POST['fname']==' '||$_POST['fname']=='')
       {
        $error_feilds[]="fname";
       }
       if(!isset($_POST['lname'])||$_POST['lname']==' '||$_POST['lname']=='')
       {
        $error_feilds[]="lname";
       }
       if(!isset($_POST['user_name'])||$_POST['user_name']==' '||$_POST['user_name']=='')
       {
        $error_feilds[]="user_name";
       }
       else
       {
            $query="SELECT username FROM publisher WHERE username ='".$_POST['user_name']."' LIMIT 1";
            $result=mysqli_query($con,$query);
            $r=mysqli_fetch_row($result);
            if(isset($r[0]))
            {
                $error_feilds[]="exist";
            }
       }
       if(!isset($_POST['address'])||$_POST['address']==' '||$_POST['address']=='')
       {
        $error_feilds[]="address";
       }
       if(!isset($_POST['em'])||$_POST['em']==' '||filter_input(INPUT_POST,$_POST['em'],FILTER_VALIDATE_EMAIL))
       {
        $error_feilds[]="email";
       }
       
       if(!isset($_POST['password'])||strlen($_POST['password'])<5)
       {
        $error_feilds[]="password";
       }
       if(!isset($_POST['password'])||$_POST['password']!=$_POST['cpassword']||$_POST['cpassword']=='')
       {
        $error_feilds[]="cpassword";
       }
       if(!isset($_POST['phone'])||$_POST['phone']==' '||$_POST['phone']=='')
       {
        $error_feilds[]='phone';
       }
       //escaping
       $fname=mysqli_escape_string($con,$_POST['fname']);
       $lname=mysqli_escape_string($con,$_POST['lname']);
       $username=mysqli_escape_string($con,$_POST['user_name']);
       $email=mysqli_escape_string($con,$_POST['em']);
       $address=mysqli_escape_string($con,$_POST['address']);
       $password=password_hash($_POST['password'], PASSWORD_DEFAULT);
       $phone=mysqli_escape_string($con,$_POST['phone']);
       //add to database
       if($_POST['type']=='trader'& empty($error_feilds))
       {
        $query="INSERT into publisher (fname,lname,username,Email,password,address) values('".$fname."','".$lname."','".$username."','".$email."','".$password."','".$address."')";
        $q3="INSERT INTO pub_phone(publisher_id,phone)values('".$username."','".$phone."')";
       }
       else if($_POST['type']=='customer'& empty($error_feilds))
       {
        $query="INSERT into customer (fname,lname,username,Email,password,address) values('".$fname."','".$lname."','".$username."','".$email."','".$password."','".$address."')";
        $q2="INSERT INTO card(customer_id) value('".$username."')";
        $q3="INSERT INTO cus_phone(customer_id,phone)values('".$username."','".$phone."')";
       }
       mysqli_query($con,$query);
       if(isset($q2))
       {
            if(!mysqli_query($con,$q2))
            {
                echo mysqli_error($con);
            }
       }
       if(isset($r))
        {
            mysqli_free_result($result);
        }
        if(isset($q3))
        {
            if(! mysqli_query($con,$q3))
            {
                echo mysqli_error($con);
            }
        }
        mysqli_close($con);
        header("location:log.php");
    }   
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
    <div style="background-color: gray; text-align:center;">
        <h1 >Welcome To Our store  </h1>
        <span ><a href="index.php">home</a></span>

    </div>
    <br>
    <br>
    <div>
        <form method="POST">
            <label for="f-name">first name </label>
            <input id="f-name" name="fname" placeholder="enter your first name" value="<?=(isset($fname))?"$fname":""?>">
            <?=(in_array("fname",$error_feilds))? "enter your first name please":""?>
            <label for="l-name"> &nbsp;&nbsp;&nbsp;&nbsp; last name </label>
            <input id="l-name" name="lname" placeholder="enter your last name"value="<?=(isset($lname))?"$lname":""?>">
            <?=(in_array("lname",$error_feilds))? "enter your last name please":""?>      
            <br>
            <br>
            <label for="user_name">  user name </label>
            <input id="user_name" name="user_name" placeholder="create your user name"value="<?=(isset($username))?"$username":""?>"> 
            <?=(in_array("user_name",$error_feilds))? "you must create  user name":""?> 
            <?=(in_array("exist",$error_feilds))? "username already exists":""?> 
            <label for="password">  &nbsp;&nbsp;&nbsp;&nbsp;Password </label>
            <input id="password" name="password" placeholder="create a strong password " type="password">
            <?=(in_array("password",$error_feilds))? "you must create a strong password at lest 6 digits":""?>       
            <br>
            <br>
            <label for="cpassword"> confirm Password </label>
            <input id="cpassword"  type="password" name="cpassword" placeholder="create a strong password " style="width:150px;"> 
            <?=(in_array("cpassword",$error_feilds))? "the confirm password must equle the main password":""?>
            <label for="email"> &nbsp;&nbsp;&nbsp;email </label>
            <input type="email" name='em' placeholder="enter your email" value="<?=(isset($email))?"$email":""?>">
            <?=(in_array("email",$error_feilds))? "you must enter your email":""?>  
            <br>
            <br>
            <label for="address">Address</label>
            <input type="text" name="address" id="address" placeholder="enter your full address "value="<?=(isset($address))?"$address":""?>">
            <?=(in_array("address",$error_feilds))? "you must enter your address":""?> 
            &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
            <label for="phone">Phone</label>
            <input type="text" name='phone' id="phone" placeholder="enter your phone number "value=<?=(isset($phone))?"$phone":""?>>
            <?=(in_array('phone',$error_feilds))? "you must enter your phone":""?> 
            <br>
            <br>
            <label >user type </label>
            <input type="radio" name ="type" value="trader" id="trader">
            <label for="trader">trader</label>
            <input type="radio" name ="type" value="customer" id="customer" checked>
            <label for="customer">customer</label>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="submit" value="create account " >
        </form>
    </div>   
</body>
</html>