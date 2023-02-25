<?php
session_start();
$con=mysqli_connect("localhost","root","2002","Book_store");

if(!$con)
{
    echo "connection error";
    exit;
}
$query="SELECT * FROM book";
$result=mysqli_query($con,$query);
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
    <header style="background:gray;width:100% ; height:100px; " >
       <?php
       if(!isset($_COOKIE['logtype']))
       {?>
        <div >
            <h1 style="width:auto;text-align:center; "> welcome to our store</h1>
            <span style="right:10px; top:25px;"><a href="sign.php">sign </a></span>
            <br>
            <span style=" right:10px; top:45px;"><a href="log.php">log in</a></span>
        </div>

      <?php }
      elseif($_COOKIE['logtype']=="customer")
      {?>
        <div >
            <h1 style="width:auto;text-align:center; "> welcome to our store</h1>
            <span style="right:10px; top:25px;"><a href="logout.php">logout </a></span>
            <br>
            <span style=" right:10px; top:45px;"><a href="cart.php">my card</a></span>
        </div>
      <?php }
      else
      {?>
        <div >
            <h1 style="width:auto;text-align:center; "> welcome to our store</h1>
            <span style="right:10px; top:25px;"><a href="logout.php">logout </a></span>
            <br>
            <span style=" right:10px; top:45px;"><a href="publisher page.php">my page</a></span>
        </div>
      <?php }
       ?>
    </header>
    <div>
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
                    <?php while($row2=mysqli_fetch_assoc($result)) { 
                        if($row2['quantity']==0)
                        {
                            continue;
                        }
                     ?>
                    <tr>
                        <td style="text-align: center;"><?=(isset($row2['name']))? $row2['name']:""?></td>
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
                           <?php }if(!isset($_COOKIE['logtype'])||$_COOKIE['logtype']=='trader'){?>
                                <td>only customers can buy</td>
                           <?php } else {?>
                                <td><a href="addtocart.php?id=<?=$row2['S_number']?>">ADD to cart</a></td>
                        <?php }?>
                    </tr>
                        <?php }?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
mysqli_free_result($result);
mysqli_close($con);

?>