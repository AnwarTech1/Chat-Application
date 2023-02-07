<?php

  session_start();
  if (isset($_SESSION['unique_id'])) {
    header("location: users.php");
  }

?>

<?php
  include_once "header.php";
?>

  <body>
    <div class="wrapper">
      <section class="form login">
        <header>Chat Application</header>
        <form action="#">
          <div class="error-txt"></div>
          <div class="field input">
            <label>Email Address</label>
            <input type="text" name="email" placeholder="Enter Your Email" />
          </div>
          <div class="field input">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter Your Password" />
            <i class="fas fa-eye"></i>
          </div>
          <div class="field button">
            <input type="submit" value="Continue To Chat" />
          </div>
        </form>
        <div class="link">Not Signed Up ? <a href="index.php">Signup Now</a></div>
      </section>
    </div>
    <!-- JavaScript File Link -->
    <script src="js/show-hide.js"></script>
    <script src="js/login.js"></script>
  </body>
</html>
