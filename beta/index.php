<!DOCTYPE html>

<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
  <title>BETA - rn467</title>
  <link rel="stylesheet" href="./styles1/general1.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha384-DfXLxu3RFhqYHzP0ib5unRvRjaJKRqvz1ykgB37BRSrm2w8i6+90HCw5eqt3e4k2" crossorigin="anonymous">
<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
/>
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

<br>
<br>
<header>
<div class="top-nav">
<br />
<br />
</div>

</ul>
</header>
<br>
<br>

<?php
    echo '<a href="javascript:history.go(-1)" class="back-button"> < All Recipes </a>';
    ?>
    <div class="recipe-container">
        <?php
        // Get a single recipe from the "recipes" table in the "idm232" database
        $query = "SELECT * FROM recipes WHERE id = 1"; // Limit the result to one row
        $results = mysqli_query($db_connection, $query);

        if ($results->num_rows > 0) {
            consoleMsg("Query successful! Number of rows: $results->num_rows");

            // Fetch the single recipe
            $oneRecipe = mysqli_fetch_array($results);
            ?>

            <img class="recipe-image" src="./images/<?php echo $oneRecipe['Main IMG']; ?>" alt="Dish Image">

            <div class="recipe-desc">
                <div class="recipe-title">
                    <h1 class="recipe-name"><?php echo $oneRecipe['Title']; ?></h1>
                    <h2 class="subheading"><?php echo $oneRecipe['Subtitle']; ?></h2>
                </div>
                <p class="description"><?php echo $oneRecipe['Description']; ?></p>

                <br>

                <button class="save-button">
                    <span>SAVE RECIPE</span>
                </button>

            <br>
            <br>

            <div class="recipe-info">
                <div class="info-rows">
                    <div class="icon">
                        <img src="img/time.png">
                    </div>
                    <h4>Cook Time</h4>
                    <h2><?php echo $oneRecipe['Cook Time']; ?></h2>
                </div>
                <div class="info-rows">
                    <div class="icon">
                        <img src="img/serving.png">
                    </div>
                    <h4>Serving</h4>
                    <h2><?php echo $oneRecipe['Servings']; ?></h2>
                </div>
                <div class="info-rows">
                    <div class="icon">
                        <img src="img/calorie.png">
                    </div>
                    <h4>Calories</h4>
                    <h2><?php echo $oneRecipe['Cal/Serving']; ?></h2>
                </div>
            </div>

            <?php
        } else {
            consoleMsg("QUERY ERROR");
        }
        ?>
    </div>
    </div>

<!-- Ingredients -->
<br>
<br>
<h1 class="ingredient-title">INGREDIENTS</h1>
<div class="ingredient-container">

<?php
// Get all the recipes from "recipes" table in the "idm232" database
$query = "SELECT * FROM `recipes` WHERE `id` = 1 ";
$results = mysqli_query($db_connection, $query);

if ($results->num_rows > 0) {
    consoleMsg("Query successful! Number of rows: $results->num_rows");

    while ($oneRecipe = mysqli_fetch_array($results)) {
        $id = $oneRecipe['id'];

        echo '<div class="ingredients">';
  
        echo '<img class="ingImg" src="./images/' . $oneRecipe['Ingredients IMG'] . '" alt="Ingredients Image">';

        echo '<div class="ingredient-list">';

        // Outputting ingredients with checkboxes
        $ingredientsArray = explode('*', $oneRecipe['All Ingredients']);
        foreach ($ingredientsArray as $ingredient) {
            // Trim to remove any leading/trailing spaces
            $ingredient = trim($ingredient);

            // Output checkbox with label
            echo '<label class="checkbox-label">';
            echo '<input type="checkbox" name="ingredient[]" value="' . $ingredient . '">';
            echo $ingredient;
            echo '</label><br>';
        }

        echo '</div>';
    }
} else {
    consoleMsg("QUERY ERROR");
}
?>
</div>
  </div>
<!-- Instruction -->
<div class="instruction-title">
<h3 class="step-by-step">step-by-step</h3>
<h2 class="big-title">INSTRUCTION</h2>

<div class="steps">
<?php
$query = "SELECT * FROM `recipes` WHERE `id` = 1 ";
$results = mysqli_query($db_connection, $query);

if ($results->num_rows > 0) {
    consoleMsg("Query successful! Number of rows: $results->num_rows");

    // Fetch the single recipe
    $oneRecipe = mysqli_fetch_array($results);

    if ($oneRecipe) {
        $stepImagesArray = explode("*", $oneRecipe['Step IMGs']);
        $stepTextArray = explode("*", $oneRecipe['All Steps']);

        echo '<div class="steps-container" style="text-align: center;">';

        for ($lp = 0; $lp < count($stepTextArray); $lp++) {
            // If step starts with a number, get number minus one for image name
            $firstChar = substr($stepTextArray[$lp], 0, 1);

            echo '<div class="step" style="text-align: center; margin-bottom: 30px;">';
            echo '<div class="above-image">';
            // Display the first line above the image
            $lines = explode("\n", $stepTextArray[$lp]);
            
            // Find the position of the first colon in the line
            $colonPos = strpos($lines[0], ':');

            // Check if colon exists in the line
            if ($colonPos !== false) {
                // Display only the text before the first colon
                $firstLine = substr($lines[0], 0, $colonPos + 1);
                echo '<p class="first-line">' . $firstLine . '</p>';
            } else {
                // If no colon, display the entire line
                echo '<p class="rest-line">' . $lines[0] . '</p>';
            }
            echo '</div>';
            if (is_numeric($firstChar)) {
                consoleMsg("First Char is: $firstChar");
                echo '<img src="./images/' . $stepImagesArray[$firstChar - 1] . '" alt="Step Image" style="margin-top: 10px;">';
            }

            // Display the rest of the content below the image
            for ($i = 1; $i < count($lines); $i++) {
                echo '<p class="rest-line">' . $lines[$i] . '</p>';
            }

            echo '</div>';
        }

        echo '</div>';
    } else {
        consoleMsg("QUERY ERROR");
    }
}
?>


</div>
<br>
<br>
<div class="rating">
<h1 class="enjoy"> ENJOY!</h1>
<h4>Rate this Recipe</h4>
<span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star"></span>
<span class="fa fa-star"></span>
</div>
</div>
<br>
<br>
<hr class="white-line" />
<br />
<br />
<br />
    <div class="footer">
      <img
        src="img/big-logo.png"
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
