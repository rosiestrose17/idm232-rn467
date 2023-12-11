<!DOCTYPE html>

<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
  <title>NomNom Recipes</title>
  <link rel="stylesheet" href="./styles/general.css">
</head>

<body>
<br>
<header>
<div class="top-nav">
<img
class="small-logo"
src="images/vector/small-logo.png"
alt="small-logo"
/>
<br />
<br />
</div>
<ul class="nav_links">
<li class="nav-link"><a href="home.html" style="text-decoration: none; color: white;">Home</a></li>
<li class="nav-link"><a href="about.html" style="text-decoration: none; color: white;">About</a></li>
<li class="nav-link"><a href="index.php" style="text-decoration: none; color: #ce0000; font-size: 1.1em;">All Recipes</a></li>

</ul>
</header>
<br>
<br>
<div class="browse">
  <div class="title">
    <h1 class="browse-title">ALL RECIPES</h1>
  </div>
 

  <form action="index.php" method="POST" class="search-container">
    <div class="search">
        <input type="search" id="search" name="search" class="searchTerm" placeholder="Discover Delicious Recipes" value="<?php echo $searchTerm; ?>">
        <button type="submit" name="submit" value="submit" class="searchButton">
            <img src="images/vector/search.png" alt="Search icon" />
        </button>
    </div>
</form>

<div class="image-container">
    <figure class="image-figure" data-hover="images/vector/chicken.png">
        <a href="index.php?filter=chicken,turkey" class="filter-link">
            <img src="images/vector/15.png" alt="Image 6" />
            <figcaption>Chicken & Turkey</figcaption>
        </a>
    </figure>
    <figure class="image-figure" data-hover="images/vector/beef.png">
        <a href="index.php?filter=beef,pork"  class="filter-link">
            <img src="images/vector/10.png" alt="Image 1" />
            <figcaption>Beef & Pork</figcaption>
        </a>
    </figure>
    <figure class="image-figure" data-hover="images/vector/seafood.png">
        <a href="index.php?filter=fish"  class="filter-link">
            <img src="images/vector/11.png" alt="Image 2" style="margin-top: -20px; padding-bottom: 25px" />
            <figcaption>Fish & Seafood</figcaption>
        </a>
    </figure>
    <figure class="image-figure" data-hover="images/vector/vegetarian.png">
        <a href="index.php?filter=vegitarian" class="filter-link">
            <img src="images/vector/14.png" alt="Image 5" />
            <figcaption>Vegetarian</figcaption>
        </a>
    </figure>
    <figure class="image-figure" data-hover="images/vector/italian.png">
     <a href="index.php?filterid=3,4,5,6,12,14,15,22,29,30" class="filter-link">
    <img src="images/vector/12.png" alt="Image 3" />
    <figcaption>Italian</figcaption>
</a>
    </figure>
    <figure class="image-figure" data-hover="images/vector/mexican.png">
        <a href="index.php?filterid=7,16,13,31" class="filter-link">
            <img src="images/vector/13.png" alt="Image 4" />
            <figcaption>Mexican</figcaption>
        </a>
    </figure>
</div>
<div class="button-container">
  <button class="view-all-button" onclick="window.location.href='index.php'">Browse All Recipes</button>
</div>
 <br>
  <script>
        const imageFigures = document.querySelectorAll(".image-figure");
    
        imageFigures.forEach((figure) => {
          const img = figure.querySelector("img");
          const originalImageSrc = img.getAttribute("src");
          const hoverImageSrc = figure.getAttribute("data-hover"); 
    
          figure.addEventListener("mouseenter", () => {
            img.style.transform = "scale(1.1)"; 
            img.src = hoverImageSrc; 
          });
    
          figure.addEventListener("mouseleave", () => {
            img.style.transform = "scale(1)"; 
            img.src = originalImageSrc;
          });
        });
      </script>


<?php
echo '<div id="content">';
require_once './includes/fun.php';
consoleMsg("PHP to JS .. is Wicked FUN");

require_once './env.php';

require_once './includes/database.php';
$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';

consoleMsg("Search is: $searchTerm");
$filters = isset($_GET['filter']) ? explode(',', $_GET['filter']) : array();
$filterIds = isset($_GET['filterid']) ? explode(',', $_GET['filterid']) : array();
consoleMsg("Filters are: " . implode(', ', $filters));

if (!empty($searchTerm)) {
    consoleMsg("Doing a SEARCH");
    $query = "SELECT * FROM recipes WHERE title LIKE '%$searchTerm%' OR subtitle LIKE '%$searchTerm%'";
} elseif (!empty($filters)) {
    consoleMsg("Doing a FILTER");
    $filterConditions = implode(" OR ", array_map(function ($filter) {
        return "proteine LIKE '%$filter%'";
    }, $filters));
    $query = "SELECT * FROM recipes WHERE $filterConditions";
} elseif (!empty($filterIds)) {
    consoleMsg("Doing a FILTER BY IDS");
    $filterIdConditions = implode(" OR ", array_map(function ($filterId) {
        return "id IN ($filterId)";
    }, $filterIds));
    $query = "SELECT * FROM recipes WHERE $filterIdConditions";
} else {
    consoleMsg("Loading ALL RECIPES");
    $query = "SELECT * FROM recipes";
}

$results = mysqli_query($db_connection, $query);



if ($results->num_rows > 0) {
  echo '<div class="recipe-column">';
    consoleMsg("Query successful! Number of rows: $results->num_rows");

    while ($oneRecipe = mysqli_fetch_array($results)) {
        $id = $oneRecipe['id'];

        echo '<a href="./detail.php?recID=' . $id . '" style="text-decoration: none; color: inherit;">';
        echo '<figure class="oneRec">';
        echo '<img src="./images/thumbnail/' . $oneRecipe['Main IMG'] . '" alt="Dish Image">';
        echo '<figcaption>' . $oneRecipe['Title'] . '</figcaption>';
        echo '<figcaption1>' . $oneRecipe['Subtitle'] . '</figcaption1>';
        echo '</figure>';
        echo '</a>';
    }
    echo '</div';
} else {
    consoleMsg("No results found for the search term: $searchTerm");
    echo '<div class="no-results" style="font-size: 1.75rem; color: gray; text-align: center;">No recipes found for: <em>' . htmlspecialchars($searchTerm) . '</em>. Please try another keyword!</div>';
     echo '<div style="text-align: center;"><img src="images/vector/result.png" alt="Additional Image" style="width: 100%; max-width: 27%; opacity: 0.7;"></div>';}
echo '</div>'
?>
</div>
<br>
<br>
<hr class="white-line" />
<br />
<br />
<br />
  <div class="footer">
      <img
        src="images/vector/big-logo.png"
        alt="Image 4"
        class="image"
        width="25%"
      />
      <h3>© 2023 Rosie Nguyen - NomNom</h3>
      <h5>
        "Stay updated with mouthwatering recipes, culinary tips, and exclusive
        offers. <br />
        Subscribe to our newsletter for a daily dose of delicious inspiration!"
      </h5>
      <button class="newsletter-button">Subscribe to our Newsletter</button>

</body>

</html>
