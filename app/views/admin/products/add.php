<!-- <div class="content-wrapper mt-2">
    <div class="container">
        <form method="POST" action="<?php echo (_WEB_ROOT_) ?>/admin/products/add" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" class="form-control" id="price" name="price" required>
            </div>

            <div class="form-group">
                <label for="categories_id">Category:</label>
                <select class="form-control" id="categories_id" name="categories_id" required>
                    <?php echo $categories['list'] ?>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>

            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                <img id="thumbnail" src="#" alt="Thumbnail" style="display: none; max-width: 100px; margin-top: 10px;">
            </div>

            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>
</div> -->


<div class="content-wrapper mt-2">
    <div class="container">
        <form method="POST" action="<?php echo (_WEB_ROOT_) ?>/admin/products/add" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control <?php echo !empty($errors['name']) ? 'is-invalid' : '' ?>" id="name" name="name" value="<?php echo htmlspecialchars($inputValues['name']) ?>" re>
                <?php if (!empty($errors['name'])) : ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['name']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" class="form-control <?php echo !empty($errors['price']) ? 'is-invalid' : '' ?>" id="price" name="price" value="<?php echo htmlspecialchars($inputValues['price']) ?>" re>
                <?php if (!empty($errors['price'])) : ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['price']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="categories_id">Category:</label>
                <select class="form-control <?php echo !empty($errors['categories_id']) ? 'is-invalid' : '' ?>" id="categories_id" name="categories_id" re>
                    <?php echo $categories['list'] ?>
                </select>
                <?php if (!empty($errors['categories_id'])) : ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['categories_id']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control <?php echo !empty($errors['description']) ? 'is-invalid' : '' ?>" id="description" name="description"><?php echo htmlspecialchars($inputValues['description']) ?></textarea>
                <?php if (!empty($errors['description'])) : ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['description']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" class="form-control <?php echo !empty($errors['quantity']) ? 'is-invalid' : '' ?>" id="quantity" name="quantity" value="<?php echo htmlspecialchars($inputValues['quantity']) ?>" re>
                <?php if (!empty($errors['quantity'])) : ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['quantity']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control-file <?php echo !empty($errors['image']) ? 'is-invalid' : '' ?>" id="image" name="image" accept="image/*">
                <img id="thumbnail" src="#" alt="Thumbnail" style="display: none; max-width: 100px; margin-top: 10px;">
                <?php if (!empty($errors['image'])) : ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['image']; ?>
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>
</div>