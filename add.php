<?php
    include "DB/index.php";
    
    if (isset($_POST['add'])) {
        $name = mysqli_real_escape_string($conn, $_POST['product_name']);
        $price = mysqli_real_escape_string($conn, $_POST['product_price']);
        $desc = mysqli_real_escape_string($conn, $_POST['product_desc']);
        $stock = mysqli_real_escape_string($conn, $_POST['product_stock']);
        $itemcode = mysqli_real_escape_string($conn, $_POST['item_code']);
        $file = $_FILES['photo'];
        if (strlen((string) $itemcode) !== 9) {
                $msg = "Something went wrong, Please try again";
                
            } else {
                $fileName = $file['name'];
                $fileType = $file['type'];
                $fileTmpName = $file['tmp_name'];
                $fileError = $file['error'];
                $fileSize = $file['size'];
                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));
                $allowed = array('jpeg', 'jpg', 'png', 'gif');
                if (in_array($fileActualExt, $allowed)) {
                    if ($fileError === 0) {
                        $fileNameNew = uniqid('', true) . '.' . $fileActualExt;
                        $type = pathinfo($fileTmpName, PATHINFO_EXTENSION);
                        $data = file_get_contents($fileTmpName);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        $stock = intval($stock);
                        $itemcode = intval($itemcode);
                        $price = intval($price);
                        $insert_sql = "INSERT INTO product(product_name, product_desc, product_stock, product_code, product_price, product_image, add_by) VALUES ('$name', '$desc', '$stock', '$itemcode', '$price', '$base64', 'Admin')";
                        $query = mysqli_query($conn, $insert_sql);
                        $err = mysqli_error($conn);
                        header('location: index.php');
                    } else {
                        $msg = "The was an error uploading your image";
                    }
                } else {
                    $msg = "Please check the file type";
                }
                // converting the string into numbers

                
            }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        include "head.php"
    ?>
    <div class="container">
        <button class="view-product" id="viewprod">
            View List
        </button>
        <form action="<?=htmlentities($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="item_code" value="<?php
                echo rand();
            ?>">
            Name:
            <input type="text" name="product_name" id="product_name" class="product_name" placeholder="Product Name">
            Price:
            <input type="number" name="product_price" id="product_price" class="product_price" placeholder="Product Price">
            Description:
            <textarea name="product_desc" class="desc" placeholder="Product Description"></textarea>
            Stock:
            <input type="number" name="product_stock" id="stock" placeholder="Stock">
            Photo:
            <input type="file" name="photo" id="product_photo" class="product_photo">
            <button type="submit" name="add">Add</button>
        </form>
    </div>
    <script>
        var viewproduct = document.querySelector('#viewprod');
        viewproduct.onclick = () => {
            window.location.href = "index.php";
        }
    </script>
</body>
</html>