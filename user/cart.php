<?php
    session_start();
    
    $email = $_SESSION['email'];
    include "../assets/cdn/cdn_links.php";
    include "../render/connection.php";
    include "../render/modals.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cart</title>

        <link rel="stylesheet" href="../assets/style/user_style.css">
    </head>

    <body>
        <?php include "../navigation/user_nav.php"; ?>

        <div class="m-3">
            <div class="container">
                <div class="card p-2">
                    <?php
                        $sql = "SELECT * FROM user_account WHERE email = '$email'";
                        $result = mysqli_query($conn, $sql);

                        if($result) {
                            while($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <span><b><?php echo $row["full_name"]; ?></b> (<?php echo $row["contact_number"]; ?>)</span>
                                <span><?php echo $row["address"]; ?></span>
                                <?php
                            }
                        }
                    ?>
                </div>

                <form action="" method="post">
                    <?php
                    $sql = "SELECT * FROM product_cart WHERE email = '$email'";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <div class="form-check border p-1 my-3">
                                <div class="row">
                                    <!-- Checkbox Column -->
                                    <div class="col-lg-1 col-sm-1 d-flex align-items-center justify-content-center">
                                        <input 
                                            class="form-check-input product-checkbox" 
                                            type="checkbox" 
                                            value="<?php echo $row['id']; ?>" 
                                            data-price="<?php echo $row['total_price']; ?>" 
                                            id="flexCheckChecked_<?php echo $row['id']; ?>">
                                    </div>
                                    <!-- Image Column -->
                                    <div class="col-lg-1 col-sm-1">
                                        <?php
                                        $product_name = $row["product_name"];
                                        $sql1 = "SELECT * FROM products WHERE product_name = '$product_name'";
                                        $result1 = mysqli_query($conn, $sql1);

                                        if ($result1) {
                                            while ($row1 = mysqli_fetch_assoc($result1)) {
                                                ?>
                                                <img src="../assets/image/product_image/<?php echo $row1['product_image']; ?>" 
                                                    alt="Product Image" 
                                                    class="img-fluid w-100 h-100" 
                                                    style="object-fit: cover;">
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <!-- Product Details Column -->
                                    <div class="col">
                                        <span><b><?php echo $row["product_name"]; ?></b></span>
                                        <br>
                                        <span>&#8369; <?php echo $row["total_price"] / $row["quantity"]; ?> x<?php echo $row["quantity"]; ?></span>
                                        <br>
                                        <span><b>Total: </b> &#8369; <?php echo $row["total_price"]; ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="text-end">
                        <h3 id="cart-total" class="mb-3">Total: &#8369; 0</h3>
                        <button type="submit" class="btn btn-primary">Check Out</button>
                    </div>
                </form>
            </div>
        </div>

        <hr class="mx-5 mt-5 mb-3">

        <?php include "../navigation/user_footer.php"; ?>

        <script defer src="../assets/script/user_script.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const checkboxes = document.querySelectorAll(".product-checkbox");
                const totalDisplay = document.getElementById("cart-total");

                function updateTotal() {
                    let total = 0;
                    checkboxes.forEach((checkbox) => {
                        if (checkbox.checked) {
                            total += parseFloat(checkbox.dataset.price);
                        }
                    });
                    totalDisplay.textContent = `Total: ₱ ${total.toFixed(2)}`;
                }

                // Attach event listeners to all checkboxes
                checkboxes.forEach((checkbox) => {
                    checkbox.addEventListener("change", updateTotal);
                });
            });
        </script>
    </body>
</html>