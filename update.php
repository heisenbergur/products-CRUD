<?php

    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $id = $_GET['id'] ?? null;
    if(!$id) {
        header('Location: index.php');
        exit;
    }
    $errors = [];
    $statement = $pdo->prepare('SELECT * FROM products WHERE id = :id');
    $statement->bindValue(':id', $id);
    $statement->execute();
    $product = $statement->fetch(PDO::FETCH_ASSOC);
    $title = $product['title'];
    $price = $product['price'];

    $description = $product['description'];

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];

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
            $imagePath = $product['image'];
            if($image && $image['tmp_name']) {
                if($product['image']) {
                    unlink($product['image']);
                }
                $imagePath = 'images/'.randomString(8).'/'.$image['name'];
                mkdir(dirname($imagePath));
                move_uploaded_file($image['tmp_name'], $imagePath);
            }
            $statement = $pdo->prepare("UPDATE products SET title = :title,
                                        image = :image, description = :description, 
                                        price = :price WHERE id = :id");
            $statement->bindValue(':title', $title);
            $statement->bindValue(':image', $imagePath);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':price', $price);
            $statement->bindValue(':id', $id);
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
      <p>
          <a href="index.php" class="btn btn-secondary">Back to Products</a>
      </p>
    <h1>Edit Product</h1>
    <?php if(!empty($errors)) { ?>
        <div class="alert alert-danger">
            <?php foreach($errors as $e) { ?>
                <div><?php echo $e; ?></div>
            <?php } ?> 
    </div>
    <?php } ?>
    <form action="" method="post" enctype="multipart/form-data">
        <?php if($product['image']) { ?>
            <img class="display-image" src="<?php echo $product['image']; ?>">
        <?php } ?>
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
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </body>
</html>