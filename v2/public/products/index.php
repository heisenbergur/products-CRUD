<?php

    require_once "../../database.php";
    $statement = $pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');
    $statement->execute();
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include_once "../../views/partials/header.php" ?> 
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
            <img src="/<?php echo $p['image']; ?>" class="thumb-image">
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