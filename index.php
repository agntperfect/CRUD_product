<?php
    include "DB/index.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        include "head.php"
    ?>
    <div class="container">
        <button class="add-product" id="add-prod"><span>+</span> Add Products</button>
        <div class="cn-center">
            <table border="1" id="myTable">
                <input type="text" id="myInput" placeholder="Search for names..">
                <thead>
                    <th class="item-id">ID</th>
                    <th class="item-name">Product Name</th>
                    <th class="item-desc">Product Description</th>
                    <th class="item-stock">Product Stock</th>
                    <th class="item-code">Product Code</th>
                    <th class="item-rating">Product Rating</th>
                    <th class="item-price">Product Price</th>
                    <th>Product Image</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    <?php 
        $sql = "SELECT * FROM product";
        $query = mysqli_query($conn, $sql);
        $i = 0;
        while($row = mysqli_fetch_assoc($query)) {
            $i++;
            $row_num = mysqli_num_rows($query);
                $id = $row['ID'];
                $name = $row['product_name'];
                $desc = $row['product_desc'];
                $stock = $row['product_stock'];
                $code = $row['product_code'];
                $rate = $row['product_rating'];
                $price = $row['product_price'];
                $img = $row['product_image'];
                $is_delete = (int) $row['is_delete'];
                if ($is_delete === 1) {
                    $i = $i - 1;
                    continue;
                }
            ?>
            <tr>
                <td class="td-id"><?=$i?></td>
                <td class="td-name"><?=$name?></td>
                <td class="td-desc" style="word-break:break;"><?=$desc?></td>
                <td class="td-stock"><?=$stock?></td>
                <td class="td-code"><?=$code?></td>
                <td class="td-rate"><?=$rate?></td>
                <td class="td-price"><?=$price?></td>
                <td class="td-img"><img src="<?=$img?>" class="product-image"></td>
                <td class="td-actions">
                    <button type="submit" class="edit-item" id="edit-item" data-itemcode="<?=$code?>">Edit</button>
                    <button type="submit" class="delete-item" id="del-item" data-itemcode="<?=$code?>">Delete</button>
                </td>
            </tr>
            <?php
            }
        ?>
            </tbody>
        </table>
    </div>
    </div>
    <script>
        var AddProduct = document.querySelector('#add-prod');
        AddProduct.onclick = () => {
            window.location.href = "add.php";
        }

        var EditItem = document.querySelectorAll('.edit-item');
        var DeleteItem = document.querySelectorAll('.delete-item');

        for (let i = 0; i < EditItem.length; i++) {
            console.log(i)
            const element = EditItem[i];
            const elementa = DeleteItem[i];
            console.log(element)
            element.onclick = () => {
                var itemCode = element.dataset.itemcode;
                window.location.href = `edit.php?code=${itemCode}`
            }
            elementa.onclick = () => {
                var itemCode = element.dataset.itemcode;
                window.location.href = `delete.php?code=${itemCode}`
            }
        }
        
        document.querySelector('#myInput').onkeyup = () => {
        // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                console.log(td);
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>
</html>