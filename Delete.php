<?php
$con=mysqli_connect("localhost","root","2002","Book_store");
if(!$con)
{
    echo "connection error";
    exit;
}
if(!isset($_GET['name']))
{
    $serial= $_GET['id'];
    if($_COOKIE["logtype"]=='customer')
    {
        $query="DELETE FROM card_items WHERE book_id='".$serial."'LIMIT 1";
        if(mysqli_query($con,$query))
        {
            header("location:cart.php");
        }
        else{
            echo mysqli_error($con);
        }
    }else
    {
        $query="DELETE FROM book WHERE S_number='".$serial."'";
        if(mysqli_query($con,$query))
        {
            header("location:publisher page.php");
        }
        else{
            echo mysqli_error($con);
        }
    }
}else
{
    $id=$_GET['name'];
    $query="DELETE FROM orders WHERE customer_id='".$id."'AND publisher_id='".$_COOKIE['username']."'AND statu='true'";
        if(mysqli_query($con,$query))
        {
            header("location:publisher page.php");
        }
        else{
            echo mysqli_error($con);
        }
}
mysqli_close($con);
?>