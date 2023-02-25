<?php
$con=mysqli_connect("localhost","root","2002","Book_store");
if(!$con)
{
    echo "connection error";
    exit;
}
$customer_id=$_GET['name'];
$query="SELECT *from customer inner join cus_phone on customer.username=cus_phone.customer_id WHERE customer.username='".$customer_id."'limit 1";
$result=mysqli_query($con,$query);
if(!$result)
{
    echo mysqli_error($con);
}
$row=mysqli_fetch_assoc($result);
$query="SELECT *FROM orders inner join book on orders.book_id=book.S_number WHERE customer_id='".$customer_id."'AND orders.publisher_id='".$_COOKIE['username']."'";
$result=mysqli_query($con,$query);
if(!$result)
{
    echo mysqli_error($con);
}
$price=0;
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
    <div>
        <h1>customer date</h1>
        <table border="1px">
            <thead >
                <td colspan="2" style="text-align: center; ">customer data </td>
            </thead>
            <tr>
                <td> customer name :</td>
                <td><?="{$row['fname']} {$row['lname']}" ?></td>
            </tr>
            <tr>
                <td> customer email :</td>
                <td><?=$row['Email']?></td>
            </tr>
            <tr>
                <td> customer phone :</td>
                <td><?=$row['phone']?></td>
            </tr>
            <tr>
                <td> customer address :</td>
                <td><?=$row['address']?></td>
            </tr>
        </table>
        
    </div>
    <div>
        <h1> all orders details from this custmer</h1>
        <table border='1px'>
            
            <thead >
                <td  style='text-align: center; ' >book name </td>
                <td  style='text-align: center; '>book serial number </td>
                <td  style='text-align: center; '>quntity </td>
                <td  style='text-align: center; '>price</td>
            </thead>
            <?php while($row2=mysqli_fetch_assoc($result)){
                $price+=$row2['price']; ?>
                <tr>
                    <td><?=$row2['name']?></td>
                    <td><?=$row2['S_number']?></td>
                    <td><?=$row2['quntity']?></td>
                    <td><?=$row2['price']?>$</td>
                </tr>
            <?php }?>
            <tfoot>
                <tr style="text-align: center;">
                    <td colspan="1">totale price  </td>
                    <td colspan="1"><?= $price?>$</td>
                    <td colspan="2"><?=(isset($_GET['o']))?"<a href='publisher page.php'>home</a>":"<a href='send.php?name=$customer_id'>confirm</a>"?></td>
                </tr>
            </tfoot>
        </table>
        
    </div>
</body>
</html>