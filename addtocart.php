<?php
 $con=mysqli_connect("localhost","root","2002","Book_store");
 if(!$con)
{
    echo mysqli_connect_error();
}
$username=$_COOKIE['username'];
$query="SELECT card_id FROM card WHERE customer_id='".$username."'";
$result=mysqli_query($con,$query);
$card=mysqli_fetch_assoc($result);
$card=$card['card_id'];
mysqli_free_result($result);
$book_id=$_GET['id'];
$query="INSERT INTO card_items (card_id,book_id)VALUES('".$card."','".$book_id."')";
if(mysqli_query($con,$query))
{
    mysqli_close($con);
    header("location:index.php");
}
else
{
    echo  mysqli_error($con);
}