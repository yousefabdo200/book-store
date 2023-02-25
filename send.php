
<?php
$con=mysqli_connect("localhost","root","2002","Book_store");
if(!$con)
{
    echo "connection error";
    exit;
}
$customer_id=$_GET['name'];
$query="SELECT *FROM orders inner join book on orders.book_id=book.S_number WHERE customer_id='".$customer_id."'";
$result=mysqli_query($con,$query);
$q2="SELECT* from customer where username='".$customer_id."'limit 1";
$r=mysqli_query($con,$q2);
$row=mysqli_fetch_assoc($r);
if(!$result)
{
    echo mysqli_error($con);
}
$price=0;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
$mail=new PHPMailer(true);
$mail->isSMTP();
$mail->Host='smtp.gmail.com';
$mail->SMTPAuth=true;
$mail->Username='eaxmple@gmail.com';
$mail->Password='*******';
$mail->SMTPSecure='ssl';
$mail->Port='465';
$mail->setFrom('exampel@gmail.com');
$mail->addAddress($row['Email']);
$mail->isHTML(true);
$mail->Subject='order data';
$mail->Body.="
<h1>welcome {$row['fname']}  {$row['lname']}</h1>
<p>order will send to {$row['address']} </p>
<h2>order details</h2><br>
<table border='1px'>
            <thead >
                <td  style='text-align: center; ' >book name </td>
                <td  style='text-align: center; '>book serial number </td>
                <td  style='text-align: center; '>quntity </td>
                <td  style='text-align: center; '>price</td>
            </thead>";
while($row2=mysqli_fetch_assoc($result))
{
    $price+=$row2['price'];
    $mail->Body.="
    <tr>
                    <td>{$row2['name']}</td>
                    <td>{$row2['S_number']}</td>
                    <td>{$row2['quntity']}</td>
                    <td>{$row2['price']}$</td>
                </tr>";
}
$mail->Body.="
<tfoot>
                <tr style='text-align: center; '>
                    <td colspan='1'>totale price  </td>
                    <td colspan='3'>$price$</td>
                </tr>
            </tfoot>
            </table >";
$mail->Body.="<p>You will receive this order at your registered address
 with us within a period ranging from 3 days to 3 weeks, and our representative will
contact you on the number registered with us,  our eamil(easyread1515@gmail.com) .
If the order is not received, shipping costs will be charged, otherwise legal measures will be taken </p>";
$mail->send();
$query="UPDATE orders set statu='true' where customer_id='".$customer_id."' AND publisher_id ='".$_COOKIE['username']."'";

if(!mysqli_query($con,$query))
{
    echo mysqli_error($con);
}
mysqli_free_result($r);
mysqli_free_result($result);
mysqli_close($con);
header("location:publisher page.php");
?>