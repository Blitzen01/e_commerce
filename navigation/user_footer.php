<div class="container-fluid text-center bg-dark">
    <div class="row text-light justify-content-center">
        <div class="col-lg-4 col-sm-10 mt-3 mx-auto text-center mb-2">
            <h3 class="mb-2">Feedback Form</h3>
            <div class="rating-box border border-secondary">
                <header>How was your experiend?</header>
                <form action="../assets/php_script/submit_rating_script.php" method="post">
                    <div class="stars">
                        <input type="radio" id="star1" name="rating" value="1" required style="visibility: hidden;">
                        <label for="star1"><i class="fa-solid fa-star"></i></label>
                        
                        <input type="radio" id="star2" name="rating" value="2" required style="visibility: hidden;">
                        <label for="star2"><i class="fa-solid fa-star"></i></label>
                        
                        <input type="radio" id="star3" name="rating" value="3" required style="visibility: hidden;">
                        <label for="star3"><i class="fa-solid fa-star"></i></label>

                        <input type="radio" id="star4" name="rating" value="4" required style="visibility: hidden;">
                        <label for="star4"><i class="fa-solid fa-star"></i></label>
                        
                        <input type="radio" id="star5" name="rating" value="5" required style="visibility: hidden;">
                        <label for="star5"><i class="fa-solid fa-star"></i></label>
                        
                    </div>

                    <label for="subject" class="mt-4 mb-2">Select Feedback Type:</label>
                    <div class="form-group d-flex justify-content-center">
                        <div class="form-check d-flex align-items-center">
                            <input class="form-check-input" type="radio" name="subject" id="complaint" value="Complaint" required>
                            <label class="form-check-label mx-2" for="complaint">
                            Complaint
                            </label>
                        </div>
                        <div class="form-check d-flex align-items-center">
                            <input class="form-check-input" type="radio" name="subject" id="problem" value="Problem" required>
                            <label class="form-check-label mx-2" for="problem">
                            Problem
                            </label>
                        </div>
                        <div class="form-check d-flex align-items-center">
                            <input class="form-check-input" type="radio" name="subject" id="suggestion" value="Suggestion" required>
                            <label class="form-check-label mx-2" for="suggestion">
                            Suggestion
                            </label>
                        </div>
                        <div class="form-check d-flex align-items-center">
                            <input class="form-check-input" type="radio" name="subject" id="praise" value="Praise" required>
                            <label class="form-check-label mx-2" for="praise">
                            Praise
                            </label>
                        </div>
                    </div>

                    <div class="form-group d-flex flex-column justify-content-center align-items-center mx-3 mt-4 mb-2">
                        <label for="category" class="mb-2">What about the library do you want to comment on?</label>
                        <input type="text" class="form-control mb-3" id="category" name="category" placeholder="Enter your comment about our service/website." required>
                        
                        <label for="comments" class="mb-2">Enter your comments in the space provided below:</label>
                        <textarea class="form-control mb-3" id="comments" name="comments" rows="4" placeholder="Enter your detailed comments here" style="resize: none;" required></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary mb-2">Submit</button>
                </form>
            </div>
        </div>
        <div class="col-lg-4 col-sm-10 m-3 mx-auto text-center">
            <h2>About Us</h2>
            <h5 style="text-align: justify;">Founded in January 2019 by Rhaian Fornosdoro, 
                our business has grown with a commitment to providing quality services and customer satisfaction. 
                Located on the Tanza-Trece Martires Road, our office is conveniently situated on the 2nd floor of 
                the DKP Commercial Building in Daang Amaya 1, Tanza, Cavite.
                <br><br>
                With a focus on excellence, we aim to serve our community and beyond with dedication and professionalism. 
                Whether you're visiting us for the first time or returning as a valued client, we look forward to helping 
                you meet your needs and exceed your expectations.
            </h5>
            <a href="about.php" class="btn btn-info p-2 mt-3">See More</a>
        </div>
        <div class="col-lg-4 col-sm-10 mt-3 mx-auto text-center">
            <h2>Contact Us</h2>
            <div class="row mb-3">
                <a class="nav-link text-primary" href="https://www.facebook.com/HFAComputers"><i class="fa-brands fa-facebook"></i> HFA Computers and Repair Service</a>
            </div>
            <div class="row mb-3">
                <a class="nav-link text-warning" href="https://www.instagram.com/hfacomputerparts/"><i class="fa-brands fa-instagram"></i> HFA Computers and Repair Service</a>
            </div>
            <div class="row mb-3">
                <a class="nav-link" href="viber://chat?number=+09179784098" style="color: #7360f2;"><i class="fa-brands fa-viber"></i> 09179784098</a>
            </div>
            <div class="row mb-3">
                <a class="nav-link" href="javascript:void(0);" onclick="copyToClipboard('09179784098')"><i class="fa-solid fa-phone text-light"></i> 09179784098</a>
            </div>
        </div>
    </div>
    <div class="row border-top border-secondary text-secondary text-center mt-3">
        <span>&copy; 2024 HFA Computer Parts and Repair Services. All rights reserved.</span>
    </div>
</div>