<?php
$con=mysqli_connect("localhost","root","2002","book_store");
if(!$con)
{
    echo "error while connect";
    exit;
}
$book_id=$_GET['id'];
$query="SELECT * FROM book where S_number='".$book_id."' limit 1";
$result=mysqli_query($con,$query);
$row=mysqli_fetch_assoc($result);
$msg;
$t=false;
if($row['quantity']!=0)
{
    $q=$row['quantity']-1;
    $publisher_id=$row['publisher_id'];
    $query="UPDATE book set quantity={$q} where  S_number='".$book_id."' limit 1";
    if(mysqli_query($con,$query))
    {
        $query="SELECT * from orders where book_id='".$book_id."'";
        $result=mysqli_query($con,$query);
        while( $row=mysqli_fetch_assoc($result))
        {
            if($row['book_id']==$book_id)
            {
                $t=true;
                break;
            }
        }
        $msg="done";
        if($t==false)
        {
            $q=1;
            $query="INSERT INTO orders(customer_id,publisher_id,book_id,quntity,statu) values('".$_COOKIE['username']."','".$publisher_id."','".$book_id."',{$q},'false')";
        }
        else
        {
            if($row['statu']!='false')
            {
                $q=1;     
            }
            else
            {
                $q=$row['quntity']+1;
            }
            $query="UPDATE orders set quntity={$q},statu='false' where book_id='".$book_id."'";
            $t=false;
        }
        //mysqli_query($con,$query);
        if(!mysqli_query($con,$query))
        {
            echo mysqli_error($con);
        }
    }
}
else
    {
        $msg = "no";
    }
    $query="DELETE FROM card_items WHERE book_id='".$book_id."'limit 1";
        
    if(!mysqli_query($con,$query))
    {
        echo mysqli_error($con);
    }
mysqli_free_result($result);    
mysqli_close($con);
header("Location: cart.php?msg=$msg & id=$book_id");
?>