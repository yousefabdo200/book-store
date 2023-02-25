<?php
session_start();
$books=0;
$price=0;
$con=mysqli_connect("localhost","root","2002","Book_store");
if(!$con)
{
    echo "connection error";
    exit;
}
$query="Select * from book inner join card_items on book.S_number=card_items.book_id";
$result=mysqli_query($con,$query);
if(!$result)
{
    echo mysqli_error($con);
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
    <div style="text-align: center;">
        <h1>your card</h1>
    <table border="1px">
            <thead style="background-color: gray;">
                <tr>
                    <th>Book name</th>
                    <th>price</th>
                    <th>category</th>
                    <th>Book image</th>
                    <th>opreatios</th>
                </tr>
            </thead>
            <tbody>
                    <?php while($row2=mysqli_fetch_assoc($result)) { 
                        $books++;
                        if(isset($row2['quantity']))
                        {
                            $price+=$row2['price'];
                        }
                     ?>
                    <tr>
                        <td style="text-align: left;word-wrap: break-word;width:30%"><?=(isset($row2['name']))? $row2['name']:""?></td>
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
                           <td>
                            
                             <a href="confirmproduct.php?id=<?=$row2['S_number']?>">buy product</a>|<a href="Delete.php?id=<?=$row2['S_number']?>">delete</a>
                           </td>
                    </tr>
                        <?php }?>

            </tbody>
            <tfoot style="background-color:gray;">
                <tr>
                    <td colspan="1" style="text-align: center;">Books number:</td>
                    <td colspan="1" style="text-align: center;"><?= $books?></td>
                    <td colspan="1" style="text-align: center;">cart total price:</td>
                    <td colspan="1" style="text-align: center;"><?= $price?>$</td>
                    <td colspan="1" style="text-align: center;"><a href="index.php">back to shopping</a></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>