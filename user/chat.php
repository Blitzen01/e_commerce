<?php
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];

        $sql = "SELECT * FROM user_account WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $userId = $row['id'];
                $isFirstLogin = $row['is_new'];
                if ($isFirstLogin == '0') { // Replace $condition with your logic
                    echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
                                backdrop: 'static', // Optional: prevent closing by clicking outside
                                keyboard: false     // Optional: prevent closing with Escape key
                            });
                            myModal.show();
                        });
                    </script>";
                }
            }
        }
?>
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Chat</title>
                
                <link rel="stylesheet" href="../assets/style/user_style.css">
                <style>
                    /* Chatbox button styling */
                    .chatbox_button {
                        position: fixed;
                        bottom: 20px; /* Position near the bottom */
                        right: 20px;  /* Position near the right side */
                        font-size: 2.5rem;
                        border-radius: 50%;
                        padding: 0.8rem;
                        background: gray;
                        color: white; 
                        border: none; 
                        cursor: pointer;
                        transition: background 0.3s ease, transform 0.2s ease;
                    }

                    .chatbox_button:hover {
                        background: darkgray; 
                        transform: scale(1.1);
                    }

                    /* Chatbox container styling */
                    .chatbox {
                        position: fixed;
                        bottom: 0;
                        right: 20px;
                        width: 300px;
                        height: 400px;
                        background: white;
                        border: 1px solid #ddd;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                        display: none; /* Hide the chatbox initially */
                        flex-direction: column;
                        border-radius: 10px;
                        z-index: 1000;
                    }

                    /* Chatbox scrollable area */
                    .chatbox_container {
                        min-width: 270px;
                        height: 80%;
                        background: white;
                        overflow-y: scroll;
                        color: black;
                        padding: 10px;
                    }

                    /* Scrollbar styling */
                    .chatbox_container::-webkit-scrollbar {
                        width: 5px;
                    }

                    .chatbox_container::-webkit-scrollbar-track {
                        background: #f1f1f1;
                    }

                    .chatbox_container::-webkit-scrollbar-thumb {
                        background: #888;
                        border-radius: 10px;
                    }

                    .chatbox_container::-webkit-scrollbar-thumb:hover {
                        background: #555;
                    }

                    /* Chat greeting message styling */
                    .chat_support_greetings {
                        font-size: 0.9rem;
                        margin: 10px 0;
                        text-align: center;
                    }

                    /* Admin message styling */
                    .admin_message {
                        background-color: #f1f1f1;
                        padding: 8px;
                        margin: 5px 0;
                        border-radius: 10px;
                        text-align: left;
                        font-size: 0.9rem;
                        color: #333;
                    }

                    /* User message styling */
                    .user_message {
                        background-color: rgb(250, 224, 224);
                        padding: 8px;
                        margin: 5px 0;
                        border-radius: 10px;
                        text-align: right;
                        font-size: 0.9rem;
                        color: #333;
                    }

                    /* Input field and button styling */
                    .input-group {
                        display: flex;
                        align-items: center;
                        padding: 10px;
                    }

                    .form-control {
                        flex-grow: 1;
                        border-radius: 2rem 0 0 2rem;
                    }

                    .input-group button {
                        border-radius: 0 2rem 2rem 0;
                        background-color: gray;
                        color: white;
                        border: none;
                        cursor: pointer;
                        padding: 0.5rem;
                    }

                    .input-group button:hover {
                        background-color: darkgray;
                    }

                    /* Close button for chatbox */
                    .close_button {
                        position: absolute;
                        top: 1px;
                        right: 20px;
                        font-size: 1.5rem;
                        background: transparent;
                        border: none;
                        color: black;
                        cursor: pointer;
                    }

                    .close_button:hover {
                        color: white;
                    }
                </style>
            </head>

            <body>
                <!-- Chatbox button that toggles the chatbox visibility -->
                <span class="chatbox_button" onclick="toggleChatbox()"><i class="fa-solid fa-comment"></i></span>

                <!-- Chatbox container -->
                <div class="chatbox" id="chatbox">
                    <button class="close_button" onclick="closeChatbox()">×</button> <!-- Close button -->
                    <div class="chatbox_container" id="chatboxContainer">
                        <div class="bg-danger text-center text-light mb-3">
                            <span>Contact Support</span>
                        </div>
                        <div class="chat_support_greetings text-center">
                            <span>👋 Hello! Welcome to HFA Computer Parts and Repair Services support chat. How can we assist you today? 😊</span>
                        </div>

                        <?php
                            // Fetch messages from the database
                            $messagesQuery = "SELECT * FROM messages WHERE sender_id = '$userId' OR receiver_id = '$userId' ORDER BY timestamp ASC";
                            $messagesResult = mysqli_query($conn, $messagesQuery);

                            if ($messagesResult && mysqli_num_rows($messagesResult) > 0) {
                                while ($messageRow = mysqli_fetch_assoc($messagesResult)) {
                                    $isAdmin = $messageRow['is_admin']; // Check if the sender is admin
                                    $messageContent = $messageRow['message'];
                                    $originalTimestamp = $messageRow['timestamp'];

                                    // Format the timestamp to "January 09, 2025"
                                    $formattedTimestamp = date('F d, Y', strtotime($originalTimestamp));

                                    if ($isAdmin) {
                                        // Admin message styling
                                        echo '<div class="admin_message" title="' . htmlspecialchars($formattedTimestamp) . '">';
                                        echo '<p><strong>Admin:</strong> ' . htmlspecialchars($messageContent) . '</p>';
                                        echo '</div>';
                                    } else {
                                        // User message styling
                                        echo '<div class="user_message" title="' . htmlspecialchars($formattedTimestamp) . '">';
                                        echo '<p>' . htmlspecialchars($messageContent) . '</p>';
                                        echo '</div>';
                                    }
                                }
                            } else {
                                echo '<p>No messages found.</p>';
                            }
                        ?>
                    </div>

                    <!-- Message input form -->
                    <form action="../assets/php_script/send_to_admin.php" method="post">
                        <div class="input-group mx-auto">
                            <input type="hidden" name="senderId" id="senderId" value="<?php echo $userId; ?>">
                            <input type="text" class="form-control" name="userMessage" id="userMessage" autocomplete="off" placeholder="Type your message here" required>
                            <button type="submit" class="btn btn-outline-secondary fs-4">
                                <i class="fa-solid fa-caret-right"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <script>
                    // Toggle chatbox visibility
                    function toggleChatbox() {
                        const chatbox = document.getElementById('chatbox');
                        chatbox.style.display = chatbox.style.display === 'block' ? 'none' : 'block';
                    }

                    // Close chatbox
                    function closeChatbox() {
                        const chatbox = document.getElementById('chatbox');
                        chatbox.style.display = 'none';
                    }

                    // Ensure the chatbox remains open if the URL contains `chatbox=open`
                    document.addEventListener("DOMContentLoaded", () => {
                        const urlParams = new URLSearchParams(window.location.search);
                        if (urlParams.get("chatbox") === "open") {
                            const chatbox = document.getElementById('chatbox');
                            chatbox.style.display = 'block';
                        }
                    });

                    // Function to scroll the chatbox to the bottom
                    function scrollToBottom() {
                        const chatboxContainer = document.getElementById('chatboxContainer');
                        chatboxContainer.scrollTop = chatboxContainer.scrollHeight;
                    }

                    // Ensure chatbox scrolls to the bottom after page load or new message
                    document.addEventListener("DOMContentLoaded", function() {
                        scrollToBottom();  // Scroll to the bottom when the page is loaded

                        // Optionally, you can listen for new messages and scroll after form submission
                        const form = document.querySelector('form');
                        form.addEventListener('submit', function() {
                            setTimeout(scrollToBottom, 300);  // Wait for the new message to appear
                        });
                    });

                    function autoLoadNewMessages(userId) {
                        setInterval(function () {
                            const xhr = new XMLHttpRequest();
                            xhr.open('GET', `../../assets/php_script/load_admin_messages.php?user_id=${userId}`, true);

                            xhr.onload = function () {
                                if (this.status === 200) {
                                    try {
                                        const response = JSON.parse(this.responseText);

                                        // If there are new messages to display
                                        if (response.messages !== document.getElementById('chatboxContainer').innerHTML) {
                                            document.getElementById('chatboxContainer').innerHTML = response.messages;
                                            scrollToBottom(); // Scroll to the bottom after loading new messages
                                        }
                                    } catch (e) {
                                        console.error('Failed to parse JSON:', this.responseText);
                                    }
                                } else {
                                    console.error('Failed to load messages:', this.status, this.statusText);
                                }
                            };

                            xhr.onerror = function () {
                                console.error('Request error');
                            };

                            xhr.send();
                        }, 500); // Poll every 5 seconds
                    }

                    function scrollToBottom() {
                        const chatboxContainer = document.getElementById('chatboxContainer');
                        chatboxContainer.scrollTop = chatboxContainer.scrollHeight;  // Scroll to the bottom
                    }

                    document.addEventListener("DOMContentLoaded", function () {
                        const userId = "<?php echo $userId; ?>";
                        autoLoadNewMessages(userId);  // Start auto-loading messages
                    });
                </script>
            </body>
        </html>
<?php
    }
?>


<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Please update your profile.</h5>
            </div>
            <div class="modal-body">
                <form action="../assets/php_script/first_update_profile_script.php" method="post">
                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input class="form-control" type="password" name="password" id="password" placeholder="Password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password">Confirm Password</label>
                        <input class="form-control" type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                    </div>
                    <div class="mb-3">
                        <label for="address">Address</label>
                        <input class="form-control" type="text" name="address" id="address" placeholder="Password" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact_number">Contact Number</label>
                        <input class="form-control" type="text" name="contact_number" id="contact_number" placeholder="Password" required>
                    </div>
                    <input type="hidden" name="is_new" id="is_new" value="1">
                    <input type="hidden" name="email" id="email" value="<?php echo $email; ?>">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>