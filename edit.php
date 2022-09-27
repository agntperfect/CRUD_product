<?php
include "DB/index.php";
if (isset($_POST['edit'])) {
    $itemcode = mysqli_real_escape_string($conn, $_POST['itemcode']);
    $id = mysqli_real_escape_string($conn, $_POST['ID']);
    $name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $price = mysqli_real_escape_string($conn, $_POST['product_price']);
    $desc = mysqli_real_escape_string($conn, $_POST['product_desc']);
    $stock = mysqli_real_escape_string($conn, $_POST['product_stock']);
    $sql = "UPDATE product SET product_name = '$name', product_desc = '$desc', product_stock = '$stock', product_price = '$price' WHERE product_code = '$itemcode' AND ID = '$id'";
    $query = mysqli_query($conn, $sql);
    if (isset($_FILES['photo'])) {
        $file = $_FILES['photo'];
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
                $img_sql = "UPDATE product set product_image = '$base64' WHERE product_code = '$itemcode' AND ID = '$id'";
                $result = mysqli_query($conn, $img_sql);    
                header('location: index.php');
            } else {
                $msg = "The was an error uploading your image";
            }
        } else {
            $msg = "Please check the file type";
        }
    }
    // header('location: index.php');
} else {
    if (!isset($_GET['code'])) {
        header('location: index.php');
        // header('location: index.php');
        print_r($_POST);
        print_r($_FILES);
    } else {
        $code = $_GET['code'];
        $sql = "SELECT * FROM product where product_code= '$code'";
        $query = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        while ($row = mysqli_fetch_assoc($query)) {
            $id = $row['ID'];
            $name = $row['product_name'];
            $desc = $row['product_desc'];
            $stock = $row['product_stock'];
            $code = $row['product_code'];
            $rate = $row['product_rating'];
            $price = $row['product_price'];
            $img = $row['product_image'];
            $date = $row['date_added'];
            $is_delete = (int) $row['is_delete'];
            $delete = ($is_delete === 1) ? "True" : "False";
            ?>
            <button class="view-product" id="viewprod">
            View List
        </button>
        <form action="<?=htmlentities($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">
            ID:
            <input type="text" name="ID" value="<?=$id?>" disabled>
            <input type="hidden" name="ID" value="<?=$id?>">
            Item Code: 
            <input type="text" id="item-code" name="itemcode" value="<?=$code?>" disabled>
            <input type="hidden" name="itemcode" value="<?=$code?>">
            Date Added:
            <input type="date" id="date_added" value="<?=$date?>" disabled>
            Name:
            <input type="text" name="product_name" id="product_name" class="product_name" placeholder="Product Name" value="<?=$name?>">
            Price:
            <input type="number" name="product_price" id="product_price" class="product_price" placeholder="Product Price" value="<?=$price?>">
            Description:
            <textarea name="product_desc" class="desc" placeholder="Product Description"><?=$desc?></textarea>
            Stock:
            <input type="number" name="product_stock" id="stock" placeholder="Stock" value="<?=$stock?>">
            Delete: <?=$delete?><br>
            Photo:
            <img src="<?=$img?>" class="displayed-img">
            <input type="file" name="photo" id="product_photo" class="product_photo">
            <button type="submit" name="edit">Edit</button>
            <button type="submit" name="cancel">Cancel</button>
        </form>
            <?php
        }
    ?>
</body>
</html>
<script>
        var viewproduct = document.querySelector('#viewprod');
        viewproduct.onclick = () => {
            window.location.href = "index.php";
        }
    </script>
<?php
    }
        }
?>