<div class="container-fluid text-center bg-dark rounded-top pt-2 px-3">
    <div class="row text-light justify-content-center g-4">
        <div class="col-lg-4 col-sm-10 mx-auto">
            <h3 class="mb-4 fw-bold">Feedback Form</h3>
            <div class="rating-box border border-secondary rounded-4 p-4 shadow-sm bg-secondary bg-opacity-10">
                <header class="mb-3 fs-5">How was your experience?</header>
                <form action="../assets/php_script/submit_rating_script.php" method="post">
                    <div class="stars d-flex justify-content-center gap-2 mb-4">
                        <!-- (inputs stay as you had them) -->
                        <input type="radio" id="star1" name="rating" value="1" required style="visibility: hidden;">
                        <label for="star1" class="fs-2 text-warning"><i class="fa-solid fa-star"></i></label>

                        <input type="radio" id="star2" name="rating" value="2" required style="visibility: hidden;">
                        <label for="star2" class="fs-2 text-warning"><i class="fa-solid fa-star"></i></label>

                        <input type="radio" id="star3" name="rating" value="3" required style="visibility: hidden;">
                        <label for="star3" class="fs-2 text-warning"><i class="fa-solid fa-star"></i></label>

                        <input type="radio" id="star4" name="rating" value="4" required style="visibility: hidden;">
                        <label for="star4" class="fs-2 text-warning"><i class="fa-solid fa-star"></i></label>

                        <input type="radio" id="star5" name="rating" value="5" required style="visibility: hidden;">
                        <label for="star5" class="fs-2 text-warning"><i class="fa-solid fa-star"></i></label>
                    </div>

                    <label for="subject" class="form-label mt-4 mb-2">Select Feedback Type:</label>
                    <div class="form-group d-flex flex-wrap justify-content-center gap-3 mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="subject" id="complaint" value="Complaint" required>
                            <label class="form-check-label" for="complaint">Complaint</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="subject" id="problem" value="Problem" required>
                            <label class="form-check-label" for="problem">Problem</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="subject" id="suggestion" value="Suggestion" required>
                            <label class="form-check-label" for="suggestion">Suggestion</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="subject" id="praise" value="Praise" required>
                            <label class="form-check-label" for="praise">Praise</label>
                        </div>
                    </div>

                    <div class="form-group d-flex flex-column align-items-center mb-4">
                        <label for="category" class="form-label mb-2">What about the service/website do you want to comment on?</label>
                        <input type="text" class="form-control mb-3 rounded-3" id="category" name="category" placeholder="Enter your comment about our service/website." required>

                        <label for="comments" class="form-label mb-2">Enter your comments below:</label>
                        <textarea class="form-control rounded-3" id="comments" name="comments" rows="4" placeholder="Enter your detailed comments here" style="resize: none;" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2">Submit</button>
                </form>
            </div>
        </div>

        <div class="col-lg-4 col-sm-10 mx-auto">
            <h2 class="mb-4 fw-bold">About Us</h2>
            <p class="text-light text-justify small">
                Founded in January 2019 by Rhaian Fornosdoro, our business has grown with a commitment to providing quality services and customer satisfaction. Located on the Tanza-Trece Martires Road, our office is situated on the 2nd floor of the DKP Commercial Building in Daang Amaya 1, Tanza, Cavite.
                <br><br>
                With a focus on excellence, we aim to serve our community and beyond with dedication and professionalism. Whether you're visiting us for the first time or returning as a valued client, we look forward to exceeding your expectations.
            </p>
            <a href="about.php" class="btn btn-outline-info rounded-pill px-4 py-2 mt-3">See More</a>
        </div>

        <div class="col-lg-4 col-sm-10 mx-auto">
            <h2 class="mb-4 fw-bold">Contact Us</h2>
            <div class="d-flex flex-column align-items-center gap-3">
                <a class="text-decoration-none text-primary" href="https://www.facebook.com/HFAComputers">
                    <i class="fa-brands fa-facebook fa-lg"></i> HFA Computers and Repair Service
                </a>
                <a class="text-decoration-none text-warning" href="https://www.instagram.com/hfacomputerparts/">
                    <i class="fa-brands fa-instagram fa-lg"></i> HFA Computers and Repair Service
                </a>
                <a class="text-decoration-none" href="viber://chat?number=+09179784098" style="color: #7360f2;">
                    <i class="fa-brands fa-viber fa-lg"></i> 0917-978-4098
                </a>
                <a class="text-decoration-none text-light" href="javascript:void(0);" onclick="copyToClipboard('09179784098')">
                    <i class="fa-solid fa-phone fa-lg"></i> 0917-978-4098
                </a>
            </div>
        </div>
    </div>

    <div class="text-center text-secondary small py-2 mt-4 border-top border-secondary">
        2024 &copy; HFA Computer Parts and Repair Services. All rights reserved.
    </div>
</div>
