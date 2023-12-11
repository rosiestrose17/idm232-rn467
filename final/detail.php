<!DOCTYPE html>

<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
  <title>NomNom's Recipe</title>
  <link rel="stylesheet" href="./styles/detail.css">
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
  require_once './includes/fun.php';
  consoleMsg("PHP to JS .. is Wicked FUN");

  require_once './env.php';

  require_once './includes/database.php';

?>

<br>
<br>
<header>
<div class="top-nav">
<a href="index.php">
  <img class="small-logo" src="images/vector/small-logo.png" alt="small-logo">
</a>
</div>
<br />
</header>

<?php
    echo '<a href="javascript:history.go(-1)" class="back-button"> < Back </a>';
    ?>
    <div class="recipe-container">
        <?php
        $recID = $_GET['recID']; 
$query = "SELECT * FROM recipes WHERE id = $recID";
$results = mysqli_query($db_connection, $query);

        if ($results->num_rows > 0) {
            consoleMsg("Query successful! Number of rows: $results->num_rows");

    
            $oneRecipe = mysqli_fetch_array($results);
            ?>

            <img class="recipe-image" src="./images/thumbnail/<?php echo $oneRecipe['Main IMG']; ?>" alt="Dish Image">

            <div class="recipe-desc">
                <div class="recipe-title">
                    <h1 class="recipe-name"><?php echo $oneRecipe['Title']; ?></h1>
                    <h2 class="subheading"><?php echo $oneRecipe['Subtitle']; ?></h2>
                </div>
                <p class="description"><?php echo $oneRecipe['Description']; ?></p>
            <br>
            <br>
            <br>
            <div class="recipe-info">
                <div class="info-rows">
                    <div class="icon">
                        <img src="images/vector/time.png">
                    </div>
                    <h4>Cook Time</h4>
                    <h2><?php echo $oneRecipe['Cook Time']; ?></h2>
                </div>
                <div class="info-rows">
                    <div class="icon">
                        <img src="images/vector/serving.png">
                    </div>
                    <h4>Serving</h4>
                    <h2><?php echo $oneRecipe['Servings']; ?></h2>
                </div>
                <div class="info-rows">
                    <div class="icon">
                        <img src="images/vector/calorie.png">
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

$recID = $_GET['recID'];
$query = "SELECT * FROM recipes WHERE id = $recID";
$results = mysqli_query($db_connection, $query);

if ($results->num_rows > 0) {
    consoleMsg("Query successful! Number of rows: $results->num_rows");

    while ($oneRecipe = mysqli_fetch_array($results)) {
        $id = $oneRecipe['id'];

        echo '<div class="ingredients">';
  
        echo '<img class="ingImg" src="./images/ingredients/' . $oneRecipe['Ingredients IMG'] . '" alt="Ingredients Image">';

        echo '<div class="ingredient-list">';

        $ingredientsArray = explode('*', $oneRecipe['All Ingredients']);
        foreach ($ingredientsArray as $ingredient) {
            $ingredient = trim($ingredient);

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
$recID = $_GET['recID']; 
$query = "SELECT * FROM recipes WHERE id = $recID";
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
                echo '<p class="rest-line">' . $lines[0] . '</p>';
            }
            echo '</div>';
            if (is_numeric($firstChar)) {
                consoleMsg("First Char is: $firstChar");
                echo '<img src="./images/step-img/' . $stepImagesArray[$firstChar - 1] . '" alt="Step Image" style="margin-top: 10px;">';
            }

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
<form id="ratingForm">
    <fieldset class="rating">

        <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="Rocks!">5 stars</label>
        <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="Pretty good">4 stars</label>
        <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="Meh">3 stars</label>
        <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="Kinda bad">2 stars</label>
        <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="Sucks big time">1 star</label>
    </fieldset>
</form>
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
<script>
$(document).ready(function() {
    $("form#ratingForm").submit(function(e) 
    {
        e.preventDefault(); 
        if ($("#ratingForm :radio:checked").length == 0) {
            $('#status').html("nothing checked");
            return false;
        } else {
            $('#status').html( 'You picked ' + $('input:radio[name=rating]:checked').val() );
        }
    });
});
</script>
</body>

</html>
