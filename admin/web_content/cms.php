<?php
    include "../../assets/cdn/cdn_links.php";
    include "../../render/connection.php";
    
    session_start();
    if (!isset($_SESSION['admin_email'])) {
        header("Location: ../index.php"); // Redirect to the index if not logged in
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin: Content Management System</title>
        
        <link rel="stylesheet" href="../../assets/style/admin_style.css">

        <style>
            /* Center the carousel within its parent */
            .carousel-container {
                display: flex;
                justify-content: center; /* Center horizontally */
                align-items: center; /* Center vertically */
                height: 70vh; /* Full viewport height */
            }

            #continuousCarousel {
                width: 80%; /* Adjust the width as needed */
                max-width: 800px; /* Maximum width of the carousel */
                aspect-ratio: 6 / 3; /* 6:3 aspect ratio */
                overflow: hidden;
            }

            #continuousCarousel .carousel-inner {
                height: 100%;
            }

            #continuousCarousel .carousel-item img {
                object-fit: cover;
                width: 100%;
                height: 100%;
            }
        </style>

    </head>

    <body>
        <div id="admin-body" class="">
            <div class="row">
                <div class="col-lg-2">
                    <?php include "../../navigation/admin_nav.php"; ?>
                </div>
                <div class="col">
                    <?php include "../../navigation/admin_header.php"; ?>
                    <h3 class="p-3 text-center"><i class="fa-solid fa-arrows-to-circle"></i> Content Management System</h3>
                        <section class="my-2 px-4">
                            <h4 class="text-center"><b>Carousel</b></h4>
                            <div class="carousel-container mb-3">
                                <div id="continuousCarousel" class="carousel slide shadow border" data-bs-ride="carousel" data-bs-interval="3000">
                                    <div class="carousel-inner" id="carouselItems">
                                        <?php
                                        $sql = "SELECT * FROM carousel";
                                        $result = mysqli_query($conn, $sql);
                                        if ($result) {
                                            $isActive = true; // To set the "active" class only on the first item
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                ?>
                                                <div class="carousel-item <?php if ($isActive) echo 'active'; ?>" id="carouselItem-<?php echo $row['id']; ?>">
                                                    <img src="../../assets/image/carousel/<?php echo $row['img_name']; ?>" class="d-block w-100" alt="">
                                                    <button class="btn btn-danger remove-image" data-id="<?php echo $row['id']; ?>" style="display:block; margin-top:10px;">Remove</button>
                                                </div>
                                                <?php
                                                $isActive = false; // Ensure only the first item has the "active" class
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Add Image Form -->
                                <div class="col">
                                    <form id="imageUploadForm" enctype="multipart/form-data">
                                        <input type="file" name="image" accept="image/*" required>
                                        <button type="submit" class="btn btn-primary mt-2">Add Image</button>
                                    </form>
                                </div>

                                <!-- Remove Image Section -->
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="removeImageSelect">Select Image</label>
                                                <select id="removeImageSelect" class="form-select">
                                                    <option value="">-- Select Image --</option>
                                                    <?php
                                                    // Fetch images from the database and create a list of options
                                                    $sql = "SELECT * FROM carousel";
                                                    $result = mysqli_query($conn, $sql);
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo "<option value='{$row['id']}' data-img='../../assets/image/carousel/{$row['img_name']}'>
                                                                {$row['img_name']}
                                                            </option>";
                                                    }
                                                    ?>
                                                </select>
                                                <!-- Image Preview Section -->
                                                <div id="imagePreview" class="mt-3" style="display:none;">
                                                    <img id="previewImg" src="" alt="Image Preview" width="300" height="150" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <button id="removeImageButton" class="btn btn-danger mt-2" disabled>Remove Image</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    
                    <section class="my-2 px-4">
                        <h4 class="text-center"><b>About Us</b></h4>
                        <?php
                            $sql = "SELECT * FROM contents";
                            $result = mysqli_query($conn, $sql);

                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    if($row['main_text'] == "Company Overview") {
                                        ?>
                                        <h5><b>Company Overview</b> <button class="btn text-success" data-bs-toggle="modal" data-bs-target="#cms_<?php echo $row['id']; ?>_subtext">Edit</button></h5>
                                        <p class="mb-3">
                                            <?php echo $row['sub_text']; ?>
                                        </p>
                                        <?php
                                    }
                                    if($row['main_text'] == "Mission") {
                                        ?>
                                        <h5><b>Mission</b> <button class="btn text-success" data-bs-toggle="modal" data-bs-target="#cms_<?php echo $row['id']; ?>_subtext">Edit</button></h5>
                                        <p class="mb-3">
                                            <?php echo $row['sub_text']; ?>
                                        </p>
                                        <?php
                                    }
                                    if($row['main_text'] == "Vision") {
                                        ?>
                                        <h5><b>Vision</b> <button class="btn text-success" data-bs-toggle="modal" data-bs-target="#cms_<?php echo $row['id']; ?>_subtext">Edit</button></h5>
                                        <p class="mb-3">
                                            <?php echo $row['sub_text']; ?>
                                        </p>
                                        <?php
                                    }
                                    if($row['main_text'] == "Values") {
                                        ?>
                                        <h5><b>Values</b> <button class="btn text-success" data-bs-toggle="modal" data-bs-target="#cms_<?php echo $row['id']; ?>_subtext">Edit</button></h5>
                                        <p class="mb-3">
                                            <?php echo $row['sub_text']; ?>
                                        </p>
                                        <?php
                                    }
                                    if($row['main_text'] == "Location") {
                                        ?>
                                        <h5><b>Location</b> <button class="btn text-success" data-bs-toggle="modal" data-bs-target="#cms_<?php echo $row['id']; ?>_subtext">Edit</button></h5>
                                        <p class="mb-3">
                                            <?php echo $row['sub_text']; ?>
                                        </p>
                                        <?php
                                    }
                                }
                            }
                        ?>
                        <h4 class="text-center pt-4"><b>Contact Us</b></h4>
                        <?php
                            $sql = "SELECT * FROM contents";
                            $result = mysqli_query($conn, $sql);

                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    if($row['main_text'] == "Facebook") {
                                        ?>
                                        <h5><b>Facebook</b> <button class="btn text-success" data-bs-toggle="modal" data-bs-target="#cms_<?php echo $row['id']; ?>_links">Edit</button></h5>
                                        <p class="mb-3">
                                            <?php echo $row['links']; ?>
                                        </p>
                                        <?php
                                    }
                                    if($row['main_text'] == "Instagram") {
                                        ?>
                                        <h5><b>Instagram</b> <button class="btn text-success" data-bs-toggle="modal" data-bs-target="#cms_<?php echo $row['id']; ?>_links">Edit</button></h5>
                                        <p class="mb-3">
                                            <?php echo $row['links']; ?>
                                        </p>
                                        <?php
                                    }
                                    if($row['main_text'] == "Viber") {
                                        ?>
                                        <h5><b>Viber</b> <button class="btn text-success" data-bs-toggle="modal" data-bs-target="#cms_<?php echo $row['id']; ?>_subtext">Edit</button></h5>
                                        <p class="mb-3">
                                            <?php echo $row['sub_text']; ?>
                                        </p>
                                        <?php
                                    }
                                    if($row['main_text'] == "Contact Number") {
                                        ?>
                                        <h5><b>Contact Number</b> <button class="btn text-success" data-bs-toggle="modal" data-bs-target="#cms_<?php echo $row['id']; ?>_subtext">Edit</button></h5>
                                        <p class="mb-3">
                                            <?php echo $row['sub_text']; ?>
                                        </p>
                                        <?php
                                    }
                                }
                            }
                        ?>
                    </section>
                </div>
            </div>
        </div>

        <script src="../../assets/script/admin_script.js"></script>

        <script>
            // Add image via AJAX
            document.getElementById("imageUploadForm").addEventListener("submit", function(e) {
                e.preventDefault();
                
                let formData = new FormData(this);
                
                fetch('../../assets/php_script/add_image_carousel.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let newItem = `
                            <div class="carousel-item">
                                <img src="../../assets/image/carousel/${data.img_name}" class="d-block w-100" alt="">
                                <button class="btn btn-danger remove-image" data-id="${data.id}">Remove</button>
                            </div>
                        `;
                        document.getElementById("carouselItems").innerHTML += newItem;
                    } else {
                        alert('Failed to upload image');
                    }
                });
            });

            // Remove image via AJAX
            document.addEventListener("click", function(e) {
                if (e.target && e.target.classList.contains("remove-image")) {
                    let id = e.target.getAttribute("data-id");
                    
                    fetch('../../assets/php_script/delete_image_carousel.php', {
                        method: 'POST',
                        body: JSON.stringify({ id: id }),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById("carouselItem-" + id).remove();
                        } else {
                            alert('Failed to remove image');
                        }
                    });
                }
            });

             // Enable the remove button if an image is selected
            document.getElementById("removeImageSelect").addEventListener("change", function() {
                let removeButton = document.getElementById("removeImageButton");
                removeButton.disabled = this.value === "";
            });

            // Remove image via AJAX when "Remove Image" button is clicked
            document.getElementById("removeImageButton").addEventListener("click", function() {
                let selectedImageId = document.getElementById("removeImageSelect").value;

                if (selectedImageId) {
                    fetch('../../assets/php_script/delete_image_carousel.php', {
                        method: 'POST',
                        body: JSON.stringify({ id: selectedImageId }),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove the image element from the carousel
                            document.getElementById("carouselItem-" + selectedImageId).remove();
                            alert('Image removed successfully');
                            // Remove the selected option from the dropdown
                            document.getElementById("removeImageSelect").querySelector(`option[value="${selectedImageId}"]`).remove();
                        } else {
                            alert('Failed to remove image');
                        }
                    });
                }
            });

            // JavaScript to handle selection and preview image
            const selectElement = document.getElementById("removeImageSelect");
            const removeButton = document.getElementById("removeImageButton");
            const imagePreview = document.getElementById("imagePreview");
            const previewImg = document.getElementById("previewImg");

            selectElement.addEventListener("change", function() {
                const selectedOption = selectElement.options[selectElement.selectedIndex];
                const imgSrc = selectedOption.getAttribute("data-img");

                if (imgSrc) {
                    // Show image preview
                    previewImg.src = imgSrc;
                    imagePreview.style.display = "block";
                    // Enable Remove Image button
                    removeButton.disabled = false;
                } else {
                    // Hide image preview and disable Remove Image button
                    imagePreview.style.display = "none";
                    removeButton.disabled = true;
                }
            });
        </script>
    </body>
</html>

<?php
    $sql = "SELECT * FROM contents";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <!-- Modal for subtext update -->
            <div class="modal fade" id="cms_<?php echo $row['id']; ?>_subtext" tabindex="-1" aria-labelledby="cms_<?php echo $row['id']; ?>_subtext_label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="cms_<?php echo $row['id']; ?>_subtext_label">Click button to Update</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../../assets/php_script/cms_sub_text_update.php" method="post">
                                <h5><?php echo $row['main_text']; ?></h5>
                                <!-- Hidden input field for the content ID -->
                                <input type="hidden" name="content_id" value="<?php echo $row['id']; ?>">

                                <!-- Textarea for the subtext -->
                                <textarea class="form-control" name="sub_text" required><?php echo htmlspecialchars($row['sub_text']); ?></textarea>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
?>

<?php
    $sql = "SELECT * FROM contents";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <!-- Modal for subtext update -->
            <div class="modal fade" id="cms_<?php echo $row['id']; ?>_links" tabindex="-1" aria-labelledby="cms_<?php echo $row['id']; ?>_links_label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="cms_<?php echo $row['id']; ?>_links_label">Click button to Update</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../../assets/php_script/cms_links_update.php" method="post">
                                <h5><?php echo $row['main_text']; ?></h5>
                                <!-- Hidden input field for the content ID -->
                                <input type="hidden" name="content_id" value="<?php echo $row['id']; ?>">

                                <!-- Input for the links (correct field name 'links') -->
                                <input class="form-control" name="links" required value="<?php echo htmlspecialchars($row['links']); ?>">

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
?>