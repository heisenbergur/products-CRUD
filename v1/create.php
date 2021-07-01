<?php

    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $errors = [];

    $title = '';
    $price = '';
    $description = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $date = date('Y-m-d H:i:s');

        if(!$title) {
            $errors[] = 'Title cannot be empty';
        }
        if(!$price) {
            $errors[] = 'Price cannot be empty';
        }
        if(!is_dir('images')) {
            mkdir('images');
        }
        if(empty($errors)) {
            $image = $_FILES['image'] ?? null;
            $imagePath = '';
            if($image && $image['tmp_name']) {
                $imagePath = 'images/'.randomString(8).'/'.$image['name'];
                mkdir(dirname($imagePath));
                move_uploaded_file($image['tmp_name'], $imagePath);
            }
            $statement = $pdo->prepare("INSERT INTO products (title, image, description, price, create_date)
                                        VALUES (:title, :image, :description, :price, :date)");
            $statement->bindValue(':title', $title);
            $statement->bindValue(':image', $imagePath);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':price', $price);
            $statement->bindValue(':date', $date);
            $statement->execute();
            header('Location: index.php');
        }
    }
    function randomString($n)
    {
        $characters = '1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
        $str = '';
        for($i = 0; $i < $n; $i++) {
            $index = rand(0,strlen($characters) - 1);
            $str .= $characters[$index];
        }
        return $str;
    }

?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css"> 
    <title>Hello, world!</title>
  </head>
  <body>
    <h1>Add New Product</h1>
    <?php if(!empty($errors)) { ?>
        <div class="alert alert-danger">
            <?php foreach($errors as $e) { ?>
                <div><?php echo $e; ?></div>
            <?php } ?> 
    </div>
    <?php } ?>
    <form action="create.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <br>
            <label>Product Image</label>
            <br>
            <input name="image" type="file">
        </div>
        <div class="mb-3">
            <label>Product Title</label>
            <input name="title" type="text" class="form-control" value="<?php echo $title; ?>">
        </div>
        <div class="mb-3">
            <label>Product Description</label>
            <textarea name="description" class="form-control"><?php echo $description; ?></textarea>
        </div>
        <div class="mb-3">
            <label>Product Price</label>
            <input name="price" type="number" step="0.01" class="form-control" value="<?php echo $price; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
    </form>
  </body>
</html>