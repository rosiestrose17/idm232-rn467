<!DOCTYPE html>

<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
  <title>PHP Main Menu Dynamic</title>
  <link rel="stylesheet" href="./styles/general.css">
</head>

<body>

<?php

  // $msg = "HOWDY";
  // echo '<script type="text/javascript">console.log("'. $msg .'");</script>';

  require_once './includes/fun.php';
  consoleMsg("PHP to JS .. is Wicked FUN");

  // Include env.php that holds global vars with secret info
  require_once './env.php';

  // Include the database connection code
  require_once './includes/database.php';

?>
<header>
  <div class="top-nav">
    <img class="small-logo" src="img/small-logo.png" alt="small-logo">
    <br />
    <br />
  </div>
  <ul class="nav_links">
    <li class="nav-link">Home</li>
    <li class="nav-link">About</li>
    <li class="nav-link">Categories</li>
    <li class="nav-link">All Recipes</li>
  </ul>
</header>
<br>
<br>
<div class="browse">
  <div class="title">
    <h1 class="browse-title">ALL RECIPES</h1>
  </div>
  <div class="search-container">
    <div class="search">
      <input type="text" class="searchTerm" placeholder="Discover Delicious Recipes" />
      <button type="submit" class="searchButton">
        <img src="img/search.png" alt="Search icon" />
      </button>
    </div>
  </div>
  <div class="image-container">
      <figure class="image-figure" data-hover="img/chicken.png">
        <img src="img/15.png" alt="Image 6" />
        <figcaption>Chicken & Turkey</figcaption>
      </figure>
      <figure class="image-figure" data-hover="img/beef.png">
        <img src="img/10.png" alt="Image 1" />
        <figcaption>Beef & Pork</figcaption>
      </figure>
      <figure class="image-figure" data-hover="img/seafood.png">
        <img
          src="img/11.png"
          alt="Image 2"
          style="margin-top: -20px; padding-bottom: 25px"
        />
        <figcaption>Fish & Seafood</figcaption>
      </figure>
      <figure class="image-figure" data-hover="img/vegetarian.png">
        <img src="img/14.png" alt="Image 5" />
        <figcaption>Vegetarian</figcaption>
      </figure>
      <figure class="image-figure" data-hover="img/italian.png">
        <img src="img/12.png" alt="Image 3" />
        <figcaption>Italian</figcaption>
      </figure>
      <figure class="image-figure" data-hover="img/mexican.png">
        <img src="img/13.png" alt="Image 4" />
        <figcaption>Mexican</figcaption>
      </figure>
    </div>
  </div>
  </header>
  <div id="content">
  <div class="recipe-column">
  <script>
        const imageFigures = document.querySelectorAll(".image-figure");
    
        imageFigures.forEach((figure) => {
          const img = figure.querySelector("img");
          const originalImageSrc = img.getAttribute("src");
          const hoverImageSrc = figure.getAttribute("data-hover"); // Get the hover image source
    
          figure.addEventListener("mouseenter", () => {
            img.style.transform = "scale(1.1)"; // Scale up the image
            img.src = hoverImageSrc; // Change the image source
          });
    
          figure.addEventListener("mouseleave", () => {
            img.style.transform = "scale(1)"; // Restore the original scale
            img.src = originalImageSrc;
          });
        });
      </script>

    <?php
  // Get all the recipes from "recipes" table in the "idm232" database
  $query = "SELECT * FROM recipes";
  $results = mysqli_query($db_connection, $query);
  if ($results->num_rows > 0) {
      consoleMsg("Query successful! number of rows: $results->num_rows");
      while ($oneRecipe = mysqli_fetch_array($results)) {
          if ($oneRecipe['id'] % 2 == 0) {
              echo '<figure class="oneRec">';
          } else {
              echo '<figure class="oneRecOdd">';
          }
          echo '<img src="./images/' . $oneRecipe['Main IMG'] . '" alt="Dish Image">';
          echo '<figcaption>' . $oneRecipe['Title'] . '</figcaption>';
          echo '<figcaption1>' . $oneRecipe['Subtitle'] . '</figcaption1>';
          echo '</figure>';
      }
  } else {
      consoleMsg("QUERY ERROR");
  }
  
  ?>

  



  </div>

</body>

</html>