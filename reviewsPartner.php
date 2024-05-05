<?php
// Database connection
include 'connect.php';
$connection = new Connect();
if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id='';
   header('location:login.php');
}

// Get partner ID from URL parameter
if(isset($_GET['partnerID'])) {
   $partnerID = $_GET['partnerID'];
} else {
   // Handle case where partner ID is not provided
   die("Partner ID not provided.");
}
 // Assuming the partner ID is 1 for example
$sql = "SELECT ReviewsRatings.ReviewID, ReviewsRatings.Rating, ReviewsRatings.ReviewText, LanguageLearners.FirstName, LanguageLearners.LastName
        FROM ReviewsRatings
        INNER JOIN LearningSessions ON ReviewsRatings.SessionID = LearningSessions.SessionID
        INNER JOIN LanguageLearners ON LearningSessions.LearnerID = LanguageLearners.LearnerID
        WHERE LearningSessions.PartnerID = $partnerID";
$result = $connection->conn->query($sql);
if (!$result) {
   die("Query failed: " . $conn->error); // Output error message if query fails
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Reviews</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">
</head>
<body>

   <header class="header">
      <div class="flex">
         <a href="profileLearner.html" class="logo"> <img src = "images/logo.jpg" width="210" height="60" alt="logo"></a> 
         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="toggle-btn" class="fas fa-sun"></div>
         </div>
      </div>
   </header>   
   <div class="side-bar">

<div id="close-btn">
   <i class="fas fa-times"></i>
</div>

<div class="profile">
   <img src="images/<?= $fetch_user['Photo']; ?>" class="image" alt="">
   <h3 class="name"><?= $fetch_user['FirstName'] . ' ' . $fetch_user['LastName']; ?></h3>
   <p class="role">Partner</p>
</div>

<nav class="navbar">
   <a href="profilePartner.php"><i class="fas fa-home"></i><span>home</span></a>
   <a href="SessionsPartner.php"><i><img src="images/session.png" alt="sessions"></i><span>sessions</span></a>
   <a href="about_partner.php"><i class="fas fa-question"></i><span>about</span></a>
</nav>
<nav>
   <div style="text-align: center; margin-top: 20px; margin-bottom: 150px;">
   <a href="home.html"  class="inline-btn" >Sign out</a>
</div>
</nav>

</div>
   

   <section class="reviews">
      <h1 class="heading">Reviews</h1>
      <div class="box-container">
         <?php
         if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
               echo '<div class="box">';
               echo '<p>' . $row['ReviewText'] . '</p>';
               echo '<div class="student">';
               echo '<img src="images/pic-2.jpg" alt="">'; // Assuming all reviews have the same image
               echo '<div>';
               echo '<h3>' . $row['FirstName'] . ' ' . $row['LastName'] . '</h3>';
               // Display stars based on rating
               echo '<div class="stars">';
               $rating = $row['Rating'];
               for ($i = 0; $i < $rating; $i++) {
                  echo '<i class="fas fa-star"></i>';
               }
               echo '</div>';
               echo '</div>';
               echo '</div>';
               echo '</div>';
            }
         } else {
            echo "<p>No reviews available.</p>";
         }
         ?>
      </div>
   </section>

   <footer class="footer">
      &copy; copyright @ 2024 by <span>CHAT FLUENCY</span> | all rights reserved!
      <a href="contact_learner.html"><i class="fas fa-headset"></i><span> contact us</span></a>
   </footer>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>
</body>
</html>
