<h1>Create</h1>
<?php if(!empty($errors)) { ?>
    <div class="alert alert-danger">
        <?php foreach($errors as $e) { ?>
            <div><?php echo $e; ?></div>
        <?php } ?> 
</div>
<?php } ?>
<form action="" method="post" enctype="multipart/form-data">
    <?php if($product['image']) { ?>
        <img class="display-image" src="/<?php echo $product['image']; ?>">
    <?php } ?>
    <div class="mb-3">
        <br>
        <label>Product Image</label>
        <br>
        <input name="image" type="file">
    </div>
    <div class="mb-3">
        <label>Product Title</label>
        <input name="title" type="text" class="form-control" value="<?php echo $product['title']; ?>">
    </div>
    <div class="mb-3">
        <label>Product Description</label>
        <textarea name="description" class="form-control"><?php echo $product['description']; ?></textarea>
    </div>
    <div class="mb-3">
        <label>Product Price</label>
        <input name="price" type="number" step="0.01" class="form-control" value="<?php echo $product['price']; ?>">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>