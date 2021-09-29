    <?php
    if (isset($_GET['podjetje'])) {
      $podjetje = $_GET['podjetje'];
      $naslov = $_GET['podjetje'];
    } elseif (isset($_GET['poz'])) {
          $poz = $_GET['poz'];
          $naslov = $_GET['poz'];
        } elseif (isset($_GET['lokacija'])) {
              $lokacija = $_GET['lokacija'];
              $naslov = $_GET['lokacija'];
            } else {
          $naslov = "Vse pla&#269;e";
        }
     ?>

     <!DOCTYPE html>
     <html lang="en" dir="ltr">
       <head>
         <meta charset="utf-8">
         <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
         <?php echo "<title>" . $naslov . " - it-place.si</title>"; ?>
             <link rel="icon" type="image/png" href="https://it-place.si/favicon.png" />
         <link rel="stylesheet" href="css/bootstrap.min.css">
         <link rel="stylesheet" href="css/style.css">
         <link rel="stylesheet" href="fonts/css/font-awesome.min.css">
         <script src="js/jquery.min.js"></script>
         <script src="js/bootstrap.min.js"></script>


       </head>
       <body>

         <?php include("komponente/menu.html"); ?>
         <?php include("komponente/start.html"); ?>



           <div class="container mb-5">

   <div class="row">
     <div class="col-12">
       <?php
         echo "<h2>" . $naslov . "</h2>";
         ?>
     </div>
   </div>

   <div class="row">
<div class="col-12 col-md-8">

    <table class="table">
      <thead>
      <tr>
      <th class="the">Lokacija</th>
      <th class="the">Delovno mesto</th>
      <th class="the">Pla&#269;a (neto)</th>
      </tr>
      </thead>
    <tbody id="sviunosi" class="tbo">

    <?php
    include '../config.php';

    if( isset( $poz ) ) {
      $stmt = $con->prepare("SELECT a.*
      FROM treca a
      JOIN (SELECT izkusnje, COUNT(*)
      FROM treca WHERE pozicija = ?
      GROUP BY izkusnje
      HAVING count(*) > 1 ) b
      ON a.izkusnje = b.izkusnje
      WHERE pozicija = ?
      ORDER BY a.izkusnje");
       $stmt->bind_param('ss', $poz, $poz);

       $stmt->execute();

       $place = array();

       $ostalo = array();
       $dupliunosi = array();
       $dupli = $stmt->get_result();
       while ($row2 = $dupli->fetch_assoc()) {
         $dupliunosi[] = $row2;
       }

       $sredjeno = array();
       $plate = array();
       $plates = 0;
       $trenutni = "";
       $zapamceni = "";
       $i = 0;
       $cnt = 1;
       foreach ($dupliunosi as $value) {
         $trenutni = $value['izkusnje'] . " " . $value['pozicija'];
         if ($cnt == 1) {
           $sredjeno[$i] = $value;
           $place[] = $value['neto'];
           $plate[] = $value['neto'];
           $zapamceni = $value['izkusnje'] . " " . $value['pozicija'];
           $cnt = 2;
         }
        elseif ($trenutni == $zapamceni) {
          $place[] = $value['neto'];
           $plate[] = $value['neto'];
           $plates = intval(array_sum($plate) / count($plate));
           $sredjeno[$i]['neto'] = $plates;
           $zapamceni = $value['izkusnje'] . " " . $value['pozicija'];
         } else {
           $i = $i + 1;
           $sredjeno[$i] = $value;
           $plate = array();
           $plate[] = $value['neto'];
           $place[] = $value['neto'];
           $zapamceni = $value['izkusnje'] . " " . $value['pozicija'];
         }
       }

       $con->close();

       $stmt2 = $con2->prepare("SELECT a.*
       FROM treca a
       JOIN (SELECT izkusnje, COUNT(*)
       FROM treca WHERE pozicija = ?
       GROUP BY izkusnje
       HAVING count(*) < 2 ) b
       ON a.izkusnje = b.izkusnje
       WHERE pozicija = ?
       ORDER BY a.izkusnje");
        $stmt2->bind_param('ss', $poz, $poz);

        $stmt2->execute();

        $result = $stmt2->get_result();

        while ($row = $result->fetch_assoc()) {
          $ostalo[] = $row;
          $place[] = $row['neto'];
        }

        foreach ($sredjeno as $prikaz) {
        echo "<tr>";
        echo "<td class=\"lok\">" . $prikaz['lokacija'] . "</td>";
        echo "<td>" . $prikaz['izkusnje'] . " ";
        echo $prikaz['pozicija'] . "</td>";
        echo "<td>" . $prikaz['neto'] . " EUR</td>";
        echo "</tr>";
      }

      foreach ($ostalo as $prikaz2) {
      echo "<tr>";
      echo "<td class=\"lok\">" . $prikaz2['lokacija'] . "</td>";
      echo "<td>" . $prikaz2['izkusnje'] . " ";
      echo $prikaz2['pozicija'] . "</td>";
      echo "<td>" . $prikaz2['neto'] . " EUR</td>";
      echo "</tr>";
      }

      } elseif( isset( $podjetje ) ) {
      $stmt = $con->prepare("SELECT a.*
  FROM treca a
  JOIN (SELECT pozicija, izkusnje, COUNT(*)
  FROM treca WHERE podjetje = ?
  GROUP BY pozicija, izkusnje
  HAVING count(*) > 1 ) b
  ON a.pozicija = b.pozicija
  AND a.izkusnje = b.izkusnje
  WHERE podjetje = ?
  ORDER BY a.izkusnje, a.pozicija");
       $stmt->bind_param('ss', $podjetje, $podjetje);

       $stmt->execute();

       $place = array();

       $ostalo = array();
       $dupliunosi = array();
       $dupli = $stmt->get_result();
       while ($row2 = $dupli->fetch_assoc()) {
         $dupliunosi[] = $row2;
       }

       $sredjeno = array();
       $plate = array();
       $plates = 0;
       $trenutni = "";
       $zapamceni = "";
       $i = 0;
       $cnt = 1;
       foreach ($dupliunosi as $value) {
         $trenutni = $value['izkusnje'] . " " . $value['pozicija'];
         if ($cnt == 1) {
           $sredjeno[$i] = $value;
           $place[] = $value['neto'];
           $plate[] = $value['neto'];
           $zapamceni = $value['izkusnje'] . " " . $value['pozicija'];
           $cnt = 2;
         }
        elseif ($trenutni == $zapamceni) {
          $place[] = $value['neto'];
           $plate[] = $value['neto'];
           $plates = intval(array_sum($plate) / count($plate));
           $sredjeno[$i]['neto'] = $plates;
           $zapamceni = $value['izkusnje'] . " " . $value['pozicija'];
         } else {
           $i = $i + 1;
           $sredjeno[$i] = $value;
           $plate = array();
           $plate[] = $value['neto'];
           $place[] = $value['neto'];
           $zapamceni = $value['izkusnje'] . " " . $value['pozicija'];
         }
       }

       $con->close();

       $stmt2 = $con2->prepare("SELECT a.*
   FROM treca a
   JOIN (SELECT pozicija, izkusnje, COUNT(*)
   FROM treca WHERE podjetje = ?
   GROUP BY pozicija, izkusnje
   HAVING count(*) < 2 ) b
   ON a.pozicija = b.pozicija
   AND a.izkusnje = b.izkusnje
   WHERE podjetje = ?
   ORDER BY a.izkusnje, a.pozicija");
        $stmt2->bind_param('ss', $podjetje, $podjetje);

        $stmt2->execute();

        $result = $stmt2->get_result();

        while ($row = $result->fetch_assoc()) {
          $ostalo[] = $row;
          $place[] = $row['neto'];
        }

        foreach ($sredjeno as $prikaz) {
        echo "<tr>";
        echo "<td class=\"lok\">" . $prikaz['lokacija'] . "</td>";
        echo "<td>" . $prikaz['izkusnje'] . " ";
        echo $prikaz['pozicija'] . "</td>";
        echo "<td>" . $prikaz['neto'] . " EUR</td>";
        echo "</tr>";
      }

      foreach ($ostalo as $prikaz2) {
      echo "<tr>";
      echo "<td class=\"lok\">" . $prikaz2['lokacija'] . "</td>";
      echo "<td>" . $prikaz2['izkusnje'] . " ";
      echo $prikaz2['pozicija'] . "</td>";
      echo "<td>" . $prikaz2['neto'] . " EUR</td>";
      echo "</tr>";
    }
  } elseif( isset( $lokacija ) ) {
    $stmt = $con->prepare("SELECT a.*
FROM treca a
JOIN (SELECT pozicija, izkusnje, COUNT(*)
FROM treca WHERE lokacija = ?
GROUP BY pozicija, izkusnje
HAVING count(*) > 1 ) b
ON a.pozicija = b.pozicija
AND a.izkusnje = b.izkusnje
WHERE lokacija = ?
ORDER BY a.izkusnje, a.pozicija");
     $stmt->bind_param('ss', $lokacija, $lokacija);

     $stmt->execute();

     $place = array();

     $ostalo = array();
     $dupliunosi = array();
     $dupli = $stmt->get_result();
     while ($row2 = $dupli->fetch_assoc()) {
       $dupliunosi[] = $row2;
     }

     $sredjeno = array();
     $plate = array();
     $plates = 0;
     $trenutni = "";
     $zapamceni = "";
     $i = 0;
     $cnt = 1;
     foreach ($dupliunosi as $value) {
       $trenutni = $value['izkusnje'] . " " . $value['pozicija'];
       if ($cnt == 1) {
         $sredjeno[$i] = $value;
         $place[] = $value['neto'];
         $plate[] = $value['neto'];
         $zapamceni = $value['izkusnje'] . " " . $value['pozicija'];
         $cnt = 2;
       }
      elseif ($trenutni == $zapamceni) {
        $place[] = $value['neto'];
         $plate[] = $value['neto'];
         $plates = intval(array_sum($plate) / count($plate));
         $sredjeno[$i]['neto'] = $plates;
         $zapamceni = $value['izkusnje'] . " " . $value['pozicija'];
       } else {
         $i = $i + 1;
         $sredjeno[$i] = $value;
         $plate = array();
         $plate[] = $value['neto'];
         $place[] = $value['neto'];
         $zapamceni = $value['izkusnje'] . " " . $value['pozicija'];
       }
     }

     $con->close();

     $stmt2 = $con2->prepare("SELECT a.*
 FROM treca a
 JOIN (SELECT pozicija, izkusnje, COUNT(*)
 FROM treca WHERE lokacija = ?
 GROUP BY pozicija, izkusnje
 HAVING count(*) < 2 ) b
 ON a.pozicija = b.pozicija
 AND a.izkusnje = b.izkusnje
 WHERE lokacija = ?
 ORDER BY a.izkusnje, a.pozicija");
      $stmt2->bind_param('ss', $lokacija, $lokacija);

      $stmt2->execute();

      $result = $stmt2->get_result();

      while ($row = $result->fetch_assoc()) {
        $ostalo[] = $row;
        $place[] = $row['neto'];
      }

      foreach ($sredjeno as $prikaz) {
      echo "<tr>";
      echo "<td class=\"lok\">" . $prikaz['lokacija'] . "</td>";
      echo "<td>" . $prikaz['izkusnje'] . " ";
      echo $prikaz['pozicija'] . "</td>";
      echo "<td>" . $prikaz['neto'] . " EUR</td>";
      echo "</tr>";
    }

    foreach ($ostalo as $prikaz2) {
    echo "<tr>";
    echo "<td class=\"lok\">" . $prikaz2['lokacija'] . "</td>";
    echo "<td>" . $prikaz2['izkusnje'] . " ";
    echo $prikaz2['pozicija'] . "</td>";
    echo "<td>" . $prikaz2['neto'] . " EUR</td>";
    echo "</tr>";
  }
              }
              ///////////////////////
              else {
                $stmt = $con->prepare("SELECT a.*
            FROM treca a
            JOIN (SELECT pozicija, izkusnje, COUNT(*)
            FROM treca
            GROUP BY pozicija, izkusnje
            HAVING count(*) > 1 ) b
            ON a.pozicija = b.pozicija
            AND a.izkusnje = b.izkusnje
            ORDER BY a.izkusnje, a.pozicija");
                 $stmt->bind_param('ss', $lokacija, $lokacija);

                 $stmt->execute();

                 $place = array();

                 $ostalo = array();
                 $dupliunosi = array();
                 $dupli = $stmt->get_result();
                 while ($row2 = $dupli->fetch_assoc()) {
                   $dupliunosi[] = $row2;
                 }

                 $sredjeno = array();
                 $plate = array();
                 $plates = 0;
                 $trenutni = "";
                 $zapamceni = "";
                 $i = 0;
                 $cnt = 1;
                 foreach ($dupliunosi as $value) {
                   $trenutni = $value['izkusnje'] . " " . $value['pozicija'];
                   if ($cnt == 1) {
                     $sredjeno[$i] = $value;
                     $place[] = $value['neto'];
                     $plate[] = $value['neto'];
                     $zapamceni = $value['izkusnje'] . " " . $value['pozicija'];
                     $cnt = 2;
                   }
                  elseif ($trenutni == $zapamceni) {
                    $place[] = $value['neto'];
                     $plate[] = $value['neto'];
                     $plates = intval(array_sum($plate) / count($plate));
                     $sredjeno[$i]['neto'] = $plates;
                     $zapamceni = $value['izkusnje'] . " " . $value['pozicija'];
                   } else {
                     $i = $i + 1;
                     $sredjeno[$i] = $value;
                     $plate = array();
                     $plate[] = $value['neto'];
                     $place[] = $value['neto'];
                     $zapamceni = $value['izkusnje'] . " " . $value['pozicija'];
                   }
                 }

                 $con->close();

                 $stmt2 = $con2->prepare("SELECT a.*
             FROM treca a
             JOIN (SELECT pozicija, izkusnje, COUNT(*)
             FROM treca
             GROUP BY pozicija, izkusnje
             HAVING count(*) < 2 ) b
             ON a.pozicija = b.pozicija
             AND a.izkusnje = b.izkusnje
             ORDER BY a.izkusnje, a.pozicija");
                  $stmt2->bind_param('ss', $lokacija, $lokacija);

                  $stmt2->execute();

                  $result = $stmt2->get_result();

                  while ($row = $result->fetch_assoc()) {
                    $ostalo[] = $row;
                    $place[] = $row['neto'];
                  }

                  foreach ($sredjeno as $prikaz) {
                  echo "<tr>";
                  echo "<td class=\"lok\">" . $prikaz['lokacija'] . "</td>";
                  echo "<td>" . $prikaz['izkusnje'] . " ";
                  echo $prikaz['pozicija'] . "</td>";
                  echo "<td>" . $prikaz['neto'] . " EUR</td>";
                  echo "</tr>";
                }

                foreach ($ostalo as $prikaz2) {
                echo "<tr>";
                echo "<td class=\"lok\">" . $prikaz2['lokacija'] . "</td>";
                echo "<td>" . $prikaz2['izkusnje'] . " ";
                echo $prikaz2['pozicija'] . "</td>";
                echo "<td>" . $prikaz2['neto'] . " EUR</td>";
                echo "</tr>";
              }
                          }
              ?>


  </tbody>
  </table>
</div>

<div class="col-12 col-md-4">
  <?php
  $prosecna = intval(array_sum($place) / count($place));
  echo "<h5>Povpre&#269;na neto pla&#269;a:</h5>";
  echo "<h1><span class=\"badge bg-warning text-dark\">" . $prosecna . " EUR</span><h1>";

  $minimalna = intval(min($place));
  echo "<h5>Najni&#382;ja neto pla&#269;a:</h5>";
  echo "<h1><span class=\"badge bg-secondary\">" . $minimalna . " EUR</span><h1>";

  $maks = intval(max($place));
  echo "<h5>Najvi&scaron;ja neto pla&#269;a:</h5>";
  echo "<h1><span class=\"badge bg-secondary\">" . $maks . " EUR</span><h1>";
  ?>
</div>
</div>
</div>

<?php include("komponente/footer.html"); ?>

  </body>
</html>
