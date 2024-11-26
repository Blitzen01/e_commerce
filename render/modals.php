<!-- Add Product Modal -->
<div class="modal fade" id="add_product_modal" tabindex="-1" aria-labelledby="add_product_modal_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="add_product_modal_label">Add Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../../assets/php_script/add_product_script.php" method="post" enctype="multipart/form-data">
                    <select name="product_category" id="product_category" class="form-select mb-3">
                        <option value="default" disabled>Default</option>
                        <?php
                            $sql = "SELECT * FROM product_category";
                            $result = mysqli_query($conn, $sql);

                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <option value="<?php echo $row['category']; ?>"><?php echo $row['category']; ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>

                    <!-- Image upload input -->
                    <div class="mb-3">
                        <label for="product_image">Product Image</label>
                        <input type="file" class="form-control" name="product_image" id="product_image" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label for="product_name">Product Name</label>
                        <input type="text" class="form-control" name="product_name" id="product_name" autocomplete="off">
                    </div>
                    
                    <div class="mb-3">
                        <label for="product_price">Price</label>
                        <input type="text" class="form-control" name="product_price" id="product_price" autocomplete="off">
                    </div>
                    
                    <div class="mb-2">
                        <label for="product_stocks">Stocks</label>
                        <input type="text" class="form-control" name="product_stocks" id="product_stocks" autocomplete="off">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- Add Product Modal -->

<!-- Update Product Modal -->
<div class="modal fade" id="update_product_modal" tabindex="-1" aria-labelledby="update_product_modal_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="update_product_modal_label">Update Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../../assets/php_script/update_product_script.php" method="post">
                    <input type="hidden" name="product_id" id="product_id">
                    <input type="hidden" name="product_category" id="product_category">
                    <div class="mb-3">
                        <label for="product_name">Product Name</label>
                        <input type="text" class="form-control" name="product_name" id="product_name" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="product_price">Price</label>
                        <input type="number" class="form-control" name="product_price" id="product_price" autocomplete="off">
                    </div>
                    <div class="mb-2">
                        <label for="product_stocks">Stocks</label>
                        <input type="number" class="form-control" name="product_stocks" id="product_stocks" autocomplete="off">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Update Product Modal -->

<!-- Delete Product Modal -->
<div class="modal fade" id="delete_product_modal" tabindex="-1" aria-labelledby="delete_product_modal_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete_product_modal_label">Delete Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this product?</p>
                <form action="../../assets/php_script/delete_product_script.php" method="post">
                    <!-- Hidden field to store the product ID -->
                    <input type="hidden" name="product_id" id="delete_product_id">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Delete Product Modal -->