<?php
/*
index.php
- Acts as the main entry point for the web interface of the extension.
- Key functionalities:
  1. Initiates a session and manages session data for user interactions.
  2. Checks for user login status and displays relevant messages.
  3. If the user is logged in, retrieves and displays user details like name, email, and phone. It includes 'user.php' for user-related operations.
  4. Triggers a custom JavaScript event ('userLoggedIn') upon loading, which is used to communicate the login status to other scripts.
  5. Saves the user's name in localStorage for client-side scripts to access.
  6. Provides an interface for the user to log out and view their account details.
  7. For non-logged-in users, displays a login form and the option to navigate to the registration page.
- This script is crucial for user authentication, providing a gateway to access user-specific features of the extension and managing user sessions.
*/
?>


<?php
session_start();



$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}
?>
<div class="container">

    <?php

        if(!empty($sessData['userLoggedIn']) && !empty($sessData['userID'])){
            include 'user.php';
            $user = new User();
            $conditions['where'] = array(
                'id' => $sessData['userID'],
            );
            $conditions['return_type'] = 'single';

//            echo "User is logged in.<br>";

            $userData = $user->getRows($conditions);
    ?>
            <script>
                console.log("Before triggering the event");

                //This JavaScript code triggers a custom event
                window.onload = function() {
                    let userLoggedInEvent = new Event('userLoggedIn');
                    document.dispatchEvent(userLoggedInEvent);

                    // Use localStorage instead of chrome.storage
                    localStorage.setItem('username', '<?php echo $userData['first_name']; ?>');
                    console.log('User name is saved in localStorage.');
                }


                console.log("After triggering the event");
            </script>

<!--      Here is the user page will show-->
    <h2>Welcome <?php echo $userData['first_name']; ?>!</h2>
    <a href="userAccount.php?logoutSubmit=1" class="logout">Logout</a>
    <div class="regisFrm">
        <p>Name: <?php echo $userData['first_name'].' '.$userData['last_name']; ?></p>
        <p>Email: <?php echo $userData['email']; ?></p>
        <p>Phone: <?php echo $userData['phone']; ?></p>
    </div>
    <?php }else{ ?>

    <h2>Login to Your Account</h2>
    <?php echo !empty($statusMsg)?'<p class="'.$statusMsgType.'">'.$statusMsg.'</p>':''; ?>
    <div class="regisFrm">
        <form action="userAccount.php" method="post">
            <input type="email" name="email" placeholder="EMAIL" required autocomplete="username">
            <input type="password" name="password" placeholder="PASSWORD" required autocomplete="current-password">
            <div class="send-button">
                <input type="submit" name="loginSubmit" value="LOGIN">
            </div>
        </form>
        <p>Don't have an account? <a href="registration.php">Register</a></p>
    </div>
    <?php } ?>
</div>