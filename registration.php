<?php
/*
registration.php
- Provides the user registration interface for the extension's web component.
- Key features include:
  1. Initiating a new session and handling session data for user feedback.
  2. Displaying status messages related to registration, such as errors or confirmation messages, based on the session data.
  3. Presenting a user-friendly form for account creation, which includes fields for first name, last name, email, phone number, and password.
  4. Handling form submissions by directing them to 'userAccount.php' with a POST request, where the actual registration logic is implemented.
  5. Offering a link to the login page for users who already have an account.
- This script is essential for new users to create an account, facilitating their access to the extension's features and ensuring a smooth onboarding process.
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
    <h2>Create a New Account</h2>
    <?php echo !empty($statusMsg)?'<p class="'.$statusMsgType.'">'.$statusMsg.'</p>':''; ?>
    <div class="regisFrm">
        <form action="userAccount.php" method="post">
            <input type="text" name="first_name" placeholder="FIRST NAME" required="">
            <input type="text" name="last_name" placeholder="LAST NAME" required="">
            <input type="email" name="email" placeholder="EMAIL" required="">
            <input type="text" name="phone" placeholder="PHONE NUMBER" required="">
            <input type="password" name="password" placeholder="PASSWORD" required="">
            <input type="password" name="confirm_password" placeholder="CONFIRM PASSWORD" required="">
            <div class="send-button">
                <input type="submit" name="signupSubmit" value="CREATE ACCOUNT">
            </div>
        </form>
        <p>Have an account? <a href="index.php">LogIn</a></p>
    </div>
</div>