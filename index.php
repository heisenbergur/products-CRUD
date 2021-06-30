<?php

    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');
    $statement->execute();
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
    // echo '<pre>';
    // var_dump($products);
    // echo '<pre>';

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
    <h1>Products CRUD</h1>
    <p>
        <a href="create.php" class="btn btn-success">Add Product</a>
    </p> 
    <table class="table">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Image</th>
        <th scope="col">Title</th>
        <th scope="col">Price</th>
        <th scope="col">Create Date</th>
        <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($products as $i => $p) { ?>
            <tr>
            <th scope="row"><?php echo $i+1 ?></th>
            <td>
                <img src="<?php echo $p['image']; ?>" class="thumb-image">
            </td>
            <td><?php echo $p['title'] ?></td>
            <td><?php echo $p['price'] ?></td>
            <td><?php echo $p['create_date'] ?></td>
            <td>
                <a href="update.php?id=<?php echo $p['id']; ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                <form style="display: inline;" method="post" action="delete.php">
                    <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
  </body>
</html>