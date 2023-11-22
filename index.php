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