<?php
    session_start();

    include "../assets/cdn/cdn_links.php";
    include "../render/connection.php";
    include "../render/modals.php";

    // Get search query from URL parameters if present
    $searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    $carouselStyle = !empty($searchQuery) ? 'display: none;' : '';

    if(isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
    }
    $is_new = 1;

    if (isset($email)) {
        $stmt = $conn->prepare("SELECT is_new FROM user_account WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($is_new);
        $stmt->fetch();
        $stmt->close();
    }
?>

<!-- Modal -->
<div class="modal fade" id="is_new_account" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Fill up form to proceed</h1>
            </div>
            <div class="modal-body">
                <form action="../assets/php_script/first_update_profile_script.php" method="post" id="newAccountForm">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
                        <div class="invalid-feedback">
                            Passwords do not match.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="contactNumber" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="contactNumber" name="contact_number" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HFA Computer Parts and Repair Services</title>

        <link rel="stylesheet" href="../assets/style/user_style.css">

        <style>
            .modal-dialog {
                max-height: calc(100% - 1rem);
                overflow-y: auto;
            }

            .modal-body {
                max-height: 70vh;
                overflow-y: auto;
            }

            .error-message {
                color: red;
                font-size: 14px;
                display: none;
            }
        </style>
    </head>

    <body>
        <?php include "../navigation/user_nav.php"; ?>
        <?php include "chat.php"; ?>

        <div class="container">
            <h4 class="text-center">Build your dream custom PC with our parts picker and bring your vision to life!</h4>
            <form action="custom_order_review.php" method="post" id="orderForm">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Parts Category</th>
                            <th>Parts Name</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT DISTINCT parts_category FROM computer_parts";
                            $result = mysqli_query($conn, $sql);

                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $category = $row['parts_category'];
                        ?>
                                    <tr>
                                        <td><?php echo $category; ?></td>
                                        <td>
                                            <select name="parts_name[<?php echo $category; ?>]" class="form-control" onchange="fetchPrice('<?php echo $category; ?>')">
                                                <option value="">Select Part</option>
                                                <?php
                                                    $sql_parts = "SELECT parts_name, price FROM computer_parts WHERE parts_category = '$category'";
                                                    $parts_result = mysqli_query($conn, $sql_parts);
                                                    
                                                    if ($parts_result) {
                                                        while ($part = mysqli_fetch_assoc($parts_result)) {
                                                            echo "<option value='" . $part['parts_name'] . "' data-price='" . $part['price'] . "'>" . $part['parts_name'] . "</option>";
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </td>
                                        <td><span id="price-<?php echo $category; ?>">Select a part to see price</span></td>
                                    </tr>
                        <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
                <div id="error-message" class="error-message">Please select a part from all categories before placing the order.</div>
                <button type="submit" class="btn btn-primary">Place Order</button>
            </form>
        </div>

        <hr class="mx-5 mt-5 mb-3">

        <?php include "../navigation/user_footer.php"; ?>

        <script defer src="../assets/script/user_script.js"></script>

        <script>
            const now = new Date();
            const offset = 8; // PHT is UTC+8
            const philippineTime = new Date(now.getTime() + offset * 60 * 60 * 1000);

            const today = philippineTime.toISOString().split('T')[0];

            document.getElementById('dateInput').setAttribute('min', today);

            document.addEventListener('DOMContentLoaded', function() {
                const isNew = <?php echo json_encode($is_new); ?>;
                if (isNew != 1) {
                    const modal = new bootstrap.Modal(document.getElementById('is_new_account'), {
                        backdrop: 'static',
                        keyboard: false
                    });
                    modal.show();
                }

                const form = document.getElementById('newAccountForm');
                const password = document.getElementById('password');
                const confirmPassword = document.getElementById('confirmPassword');

                form.addEventListener('submit', function(event) {
                    const passwordValue = password.value.trim();
                    const confirmPasswordValue = confirmPassword.value.trim();

                    if (passwordValue != confirmPasswordValue) {
                        event.preventDefault();
                        confirmPassword.classList.add('is-invalid');
                    } else {
                        confirmPassword.classList.remove('is-invalid');
                    }
                });

                confirmPassword.addEventListener('input', function() {
                    confirmPassword.classList.remove('is-invalid');
                });
            });

            function fetchPrice(category) {
                var selectedPart = document.querySelector('select[name="parts_name[' + category + ']"]').value;
                var selectedOption = document.querySelector('select[name="parts_name[' + category + ']"] option[value="' + selectedPart + '"]');
                var price = selectedOption ? selectedOption.getAttribute('data-price') : '';

                document.getElementById('price-' + category).textContent = price ? '₱' + price : 'Select a part to see price';
            }

            document.getElementById('orderForm').addEventListener('submit', function(event) {
                const categories = document.querySelectorAll('select');
                let allSelected = true;
                categories.forEach(function(select) {
                    if (!select.value) {
                        allSelected = false;
                    }
                });

                if (!allSelected) {
                    event.preventDefault();
                    document.getElementById('error-message').style.display = 'block';
                } else {
                    document.getElementById('error-message').style.display = 'none';
                }
            });
        </script>
    </body>
</html>
