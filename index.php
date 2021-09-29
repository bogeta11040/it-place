<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta property="og:image" content="https://it-place.si/placecover.jpg">
<meta property="og:image:type" content="image/jpeg">
    <title>it-place.si - Razi&scaron;&#269;ite pla&#269;e v industriji IT</title>
    <link rel="icon" type="image/png" href="https://it-place.si/favicon.png" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="css/select2.css"
rel="stylesheet" />
<link rel="stylesheet" href="fonts/css/font-awesome.min.css">
    <script src="js/jquery.min.js">
    </script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/select2.min.js">
    </script>
  </head>
  <body>

    <?php include("komponente/menu.html"); ?>
    <?php include("komponente/start.html"); ?>

    <div class="container mb-5">

      <div class="row my-5">
        <div class="col-12">
          <p class="text-center"><i>it-place.si</i> je spletno mesto za iskanje in indeksiranje IT pla&#269;. Poi&scaron;&#269;ite podatke ali pomagajte skupnosti tako, <a href="./vnos.php">da vnesete svojo pla&#269;o.</a></p>
        </div>
      </div>


    <div class="row my-5">
      <div class="col-12">
        <h4 class="display-4 text-center">Izberite podjetje:</h4>
      </div>
    </div>

    <div class="row text-center mb-5">
      <div class="col-8 mx-auto">
        <select id="naziv" name="naziv" class="form-control">
          <?php
          include '../config.php';
          $result = mysqli_query($con,"SELECT * FROM treca");
          $firme = array();

          while($row = mysqli_fetch_array($result))
          {
          $firme[] = $row['podjetje'];
          }

          $firme = array_unique($firme);
          foreach ($firme as $value) {
            echo "<option value=\"" . $value . "\">" . $value . "</option>";
          }

          mysqli_close($con);
             ?>
</select>

      </div>
    </div>

    <div class="row text-center mb-5">
      <div class="col-8 mx-auto">
<?php
    echo "<a href=\"./place.php?podjetje=" . $firme[0] . "\" id=\"poglej\" class=\"btn btn-dark btn-sm text-uppercase\">Poglejte podjetje</a>";
?>
      </div>
    </div>


  <div class="container mb-5">



   <div class="row">

</div>
</div>

</div>

<?php include("komponente/footer.html"); ?>


<script>
$("#naziv").change(function() {
  $("#poglej").attr("href", "./place.php?podjetje=" + naziv.value)
});

</script>


  </body>
</html>
