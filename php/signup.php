<?php

  session_start();
  include_once "config.php";
  $fname = mysqli_real_escape_string($conn, $_POST['fname']);
  $lname = mysqli_real_escape_string($conn, $_POST['lname']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
    // Checking If User Email Is Valid Or Not
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      // Checking If Email Already Exits in The DB Or Not
      $sql = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}'");
      // If Email Already Exit
      if(mysqli_num_rows($sql) > 0) {
        echo "$email - This Email Already Exist...!";
      } else {
        // Check If User Upload File Or Not
        if (isset($_FILES['image'])) { // If File Is Uploaded
          $img_name = $_FILES['image']['name']; // Getting User Uploaded Image Name
          $image_type = $_FILES['image']['type']; // Getting User Uploaded Image Type
          $tmp_name = $_FILES['image']['tmp_name']; // This Tem Name Is Used To Save File In The Folder

          // Explode Image And Get The Last Extension Like -> jpg - png .. Elc
          $img_explode = explode('.', $img_name);
          $img_ext = end($img_explode); // We Get The Extensions Of An User Uploaded Img File

          $extensions = ['png', 'jpeg', 'jpg']; // There Are Some Valid Img File Extentions and We Have Store them In Array
          if (in_array($img_ext, $extensions) === true ) { // If User Uploaded Img Extension Matched With any Array Extensions
            // Time Function To Return Us Current Time..
            // We Need This Time Because When you Uploading User Img to In Our Folder, We Rename File WIth Current Time .
            // So All Time File Will Have A Unique Name
            $time = time();
            // Move The user uploaded img to our particular folder
            $new_img_name = $time.$img_name;
            if (move_uploaded_file($tmp_name, "images/".$new_img_name)) { // if user upload img, move to our folder successfully
              $status = "Active Now"; // Once User Signed Up, Then His Status Will Be Active Now
              $random_id= rand(time(), 10000000); // Creating Random id for the user

              // Insert all user data inside the table
              $sql2 = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status) VALUES ({$random_id}, '{$fname}', '{$lname}', '{$email}', '{$password}', '{$new_img_name}', '{$status}')");
              if ($sql2) { // if these data inserted
                $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                if (mysqli_num_rows($sql3) > 0) {
                  $row = mysqli_fetch_assoc($sql3);
                  $_SESSION['unique_id'] = $row['unique_id']; // using this sessions we used user unigue_id in other php file
                  echo "success";
                }
              } else {
                echo "Something Went Wrong...!";
              }
            }
          } else {
            echo "Please Select An Image File - jpeg, jpg, png !";
          }

        } else {
          echo "Please Select An Image File...!";
        }
      }
    } else {
      echo "$email - This Is Not Valid Email...!";
    }
  } else {
    echo "All Input Field Are Required!";
  }

?>