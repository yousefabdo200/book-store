<?php
session_start();
date_default_timezone_set("Africa/Cairo");
$con=mysqli_connect("localhost","root","2002","Book_store");
$books=0;

if(!$con)
{
    echo "connection error";
    exit;
}
if(isset($_SESSION['user_name']))
{
    $cookie_name="username";
    $cookie_value=$_SESSION['user_name'];
    setcookie("username",$cookie_value,time()+3600,"/");//3 h
    $query="SELECT * FROM publisher WHERE username='".$_SESSION['user_name']."'LIMIT 1";


}
else
{
    $query="SELECT * FROM publisher WHERE username='".$_COOKIE['username']."'LIMIT 1";

}
    $dpath= getcwd();
    $result=mysqli_query($con,$query);
    $row=mysqli_fetch_assoc($result);
    $q2="SELECT * FROM book WHERE publisher_id='".$_COOKIE['username']."'";
    $r2=mysqli_query($con,$q2);
    mysqli_free_result($result);
    $q3="SELECT * FROM orders WHERE publisher_id='".$_COOKIE['username']."'";
    $r3=mysqli_query($con,$q3);
    $customers=array(); 
    $draft=array();
    while($r4=mysqli_fetch_assoc($r3))
    {
        if(!in_array($r4['customer_id'],$customers)&$r4['statu']=='false')
        {
            $customers[]=$r4['customer_id'];
        }
        else if(!in_array($r4['customer_id'],$draft)&$r4['statu']=='true')
        {
            $draft[]=$r4['customer_id'];
        }
    }
    $number=1;
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
        <header style="background:gray;width:100% ; height:100px; " >
            <div >
                <h1 style="text-align: center;"> welcome mr <?=(isset($row))?$row['fname']:""?> <?=(isset($row))?$row['lname']:""?></h1>
                <br>
                <span style=" right:10px; top:45px;"><a href="logout.php">logout</a></span>
                <span style=" left:10px; top:45px;"><a href="index.php">Home</a></span>

            </div>
        </header>
    </div>
    
    <div style="width: 50%;">
    <h1 style="text-align: center;width: 90%;">your all Books</h1>
        <table border="1px">
            <thead style="background-color: gray;">
                <tr>
                    <th>Book name</th>
                    <th>Book serial number</th>
                    <th>quantity</th>
                    <th>price</th>
                    <th>category</th>
                    <th>Book image</th>
                    <th>opreatios</th>
                </tr>
            </thead>
            <tbody>
                    <?php while($row2=mysqli_fetch_assoc($r2)) { 
                        $books++;
                     ?>
                    <tr>
                        <td style="text-align: center;"><?=(isset($row2['name'])&&$_COOKIE['username']==$_SESSION['user_name'])? $row2['name']:""?></td>
                        <td style="text-align: center;"><?=(isset($row2['S_number']))? $row2['S_number']:""?></td>
                        <td style="text-align: center;"><?=(isset($row2['quantity']))? $row2['quantity']:""?></td>
                        <td style="text-align: center;"><?=(isset($row2['price']))? $row2['price']."$":""?></td>
                        <td style="text-align: center;"><?=(isset($row2['category']))? $row2['category']:""?></td>
                        <td>
                            <?php
                            if(isset($row2['img']))
                             {?> 
                             <img src="./up/<?=$row2['img']?>" alt=""style="width:100px;hight:100px">
                            <?php }else
                            {?> <img src="./up/<?=$row2['img']?>" alt="image not found" style="width:100px;hight:200px"></td>
                           <?php }?>
                        <td><a href="edite.php?id=<?=$row2['S_number']?>">edite</a>|<a href="Delete.php?id=<?=$row2['S_number']?>">delete</a></td>
                    </tr>
                        <?php }?>

            </tbody>
            <tfoot style="background-color:gray;">
                <tr>
                    <td colspan="2" style="text-align: center;">Books number:</td>
                    <td colspan="3" style="text-align: center;"><?= $books?></td>
                    <td colspan="2" style="text-align: center;"><a  href="add.php ?>">ADD Product</a></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <?php
    ?>
    <div style="width: 50%;">
    <h1 style="text-align: left;width: 90%;">your orders</h1>
        <table border="1px">
            <thead style="background-color: gray;">
                <tr>
                    <th>order number</th>               
                    <th>customer name</th>
                    <th>confirm order</th>    
                </tr>
            </thead>
            <tbody>
                    <?php $books=0; 
                    foreach($customers as $c) { 
                        $books++;
                     ?>
                    <tr>
                        <td style="text-align: center;"><?=(!empty($customers))? $number:""?></td>
                        <td style="text-align: center;"><?=(!empty($customers))? $c:""?></td>
                        <td>
                            <?php
                            if(!empty($customers))
                            {?>
                                <a href="order.php?name=<?=$c?>">confirm order</a>
                            <?php }
                            ?>
                        </td>
                    </tr>
                        <?php 
                         $number++;
                    }?>

            </tbody>
            <tfoot style="background-color:gray;">
                <tr>
                    <td colspan="2" style="text-align: center;">total orders:</td>
                    <td colspan="3" style="text-align: center;"><?= $books?></td>
        
                </tr>
            </tfoot>
        </table>
        <h1 style="text-align: left;width: 90%;">your draft</h1>
        <table border="1px">
            <thead style="background-color: gray;">
                <tr>
                    <th>order number</th>               
                    <th>customer name</th>
                    <th>confirm order</th>    
                </tr>
            </thead>
            <tbody>
                    <?php $d=0;
                      $number=1; 
                    foreach($draft as $d) { 
                       
                     ?>
                    <tr>
                        <td style="text-align: center;"><?=(!empty($draft))? $number:""?></td>
                        <td style="text-align: center;"><?=(!empty($draft))? $d:""?></td>
                        <td>
                            <?php
                            if(!empty($draft))
                            {?>
                                <a href="order.php?name=<?= $d?>&& o='view'">view||</a>
                                <a href="Delete.php?name=<?= $d?>">Delete</a>
                            <?php }
                            ?>
                        </td>
                    </tr>
                        <?php 
                         $number++;
                    }?>

            </tbody>
            <tfoot style="background-color:gray;">
                <tr>
                    <td colspan="2" style="text-align: center;">total orders:</td>
                    <td colspan="3" style="text-align: center;"><?= $number-1?></td>
        
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
<?php
if(!isset($_COOKIE['username']))
{
    header("location:logout.php");
}
  mysqli_free_result($r2);
   mysqli_close($con);
   $row2="";
?>