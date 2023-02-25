<?php
session_start();
$error_fileds=array();
if($_SERVER["REQUEST_METHOD"]=='POST')
{
    $con=mysqli_connect("localhost","root","2002","Book_store");
    if(!$con)
    {
       echo mysqli_connect_error();
       exit;
    }
    if(!isset($_POST['name'])||$_POST['name']==''||$_POST['name']==' ')
    {
        $error_fileds[]="name";
    }
    if(!isset($_POST['category'])||$_POST['category']==''||$_POST['category']==' ')
    {
        $error_fileds[]="category";
    }
    if(!isset($_POST['serial'])||strlen($_POST['serial'])!=strlen((int)$_POST['serial'])||$_POST['serial']==" "||$_POST['serial']=='')
    {
        $error_fileds[]="serial";
    }
    if(!isset($_POST['price'])||strlen($_POST['price'])!=strlen((int)$_POST['price'])||$_POST['price']==" "||$_POST['price']=='')
    {
        $error_fileds[]="price";
    }
    if(!isset($_POST['quntity'])||$_POST['quntity']==" "||$_POST['quntity']=='')
    {
        $error_fileds[]="quntity";
    }
    if($_FILES['pic']['name']=="")
    {
        $error_fileds[]="pic";
    }
    if(empty($error_fileds))
    {
            //imge upload
        $dpath= getcwd();
        $temp_name=$_FILES['pic']['tmp_name'];
        $type=$_FILES['pic']['name'];
        $type=explode('.',$type);
        $type=end($type);
        $imgpath="$dpath\\up\\{$_POST['serial']}.$type";
        $imgname="{$_POST['serial']}.$type";
        move_uploaded_file($temp_name,$imgpath);
        //escaping
        $name=mysqli_escape_string($con,$_POST['name']);
        $category=mysqli_escape_string($con,$_POST['category']);
        $serial=mysqli_escape_string($con,$_POST['serial']);
        $quntity=(int)$_POST['quntity'];
        $price=(float)$_POST['price'];
        //data base store
        $query="INSERT INTO book(name,publisher_id,price,S_number,quantity,category,img)
        values('".$name."','".$_COOKIE['username']."',{$price},'".$serial."',{$quntity},'".$category."','".$imgname."')";
        if(mysqli_query($con,$query))
        {
            header("location:add.php");
        }
        else{
            echo mysqli_error($con);
        }
        mysqli_close($con);
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
    <a href="publisher page.php">home</a>
    <div>
        <form method="POST" enctype="multipart/form-data">
            <label for="name">Book Name</label>
            <input type="text" name="name" id="name" placeholder="enter book name">
            <?=(in_array("name",$error_fileds))?"*you must enter book name":""?>
            <label for="category">Book Category</label>
            <input type="text" id="category" name="category"placeholder="enter book category name">
            <?=(in_array("category",$error_fileds))?"*you must enter book category":""?>
            <br>
            <br>
            <label for="serial">Book serial number</label>
            <input type="text" id="serial" name="serial" placeholder="enter book serial number">
            <?=(in_array("serial",$error_fileds))?"*you must enter book serial number":""?>
            <label for="list">quntity</label>
            <input type="number" id="quntity" name="quntity"  placeholder="enter book quntity" min ="1">
            <?=(in_array("quntity",$error_fileds))?"*you must enter book quntity":""?>
            <br>
            <br>
            <label for="price">Book Price</label>
            <input type="text" name="price" id="price" placeholder="enter book price">
            <?=(in_array("price",$error_fileds))?"*enter book price":""?>
            &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label for="pic" >book image</label>
            <input type="file" name="pic">
            <?=(in_array("pic",$error_fileds))?"*you must upload pic for the book":""?>
            <br>
            <br>
            <input type="submit">
        </form>
    </div>
</body>
</html>