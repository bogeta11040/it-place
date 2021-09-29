<?php
	include 'hauth/src/autoload.php';
	include '../config.php';

	use Hybridauth\Hybridauth;
	use Hybridauth\Storage\Session;

	$hybridauth = new Hybridauth($hybridauthConfig);
	$adapters = $hybridauth->getConnectedAdapters();

	$isLoggedIn = false;

	try {
		$userInfoGitHub = $adapters['GitHub']->getUserProfile();
		$userInfoLinkedIn = $adapters['LinkedIn']->getUserProfile();
		$tokens = $adapters['LinkedIn']->getAccessToken();

		$isLoggedIn = true;

	} catch(Throwable $e) {
		#print "Exception: <p> $e";
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>it-place.si - Vnesite svojo pla&#269;o</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
<div class="container-fluid">

	<?php if ($adapters) : ?>


	<?php foreach ($adapters as $name => $adapter) : ?>
							<?php
							$korisnik = $adapter->getUserProfile()->identifier;
							?>

			<?php endforeach; ?>

			<?php

		if(isset($_POST['submit']))
		{
		    $podjetje = $_POST['naziv'];
		    $lokacija = $_POST['lokacija'];
		    $pozicija = $_POST['rmesto'];
				$izkusnje = $_POST['senioritet'];
				$neto = $_POST['neto'];
				$bruto = $_POST['bruto'];
				$god = date("Y");

				$sfe = $con->prepare("SELECT `podjetje` FROM `treca` WHERE `korisnik` = '$korisnik' AND `godina` = '$god'");
				 $sfe->bind_param('ss', $korisnik, $god);

				 $sfe->execute();
				 $checkfirst = $sfe->get_result();
				if($checkfirst->num_rows == 0) {
					$insert = $con->prepare("INSERT INTO treca VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
					$insert->bind_param("ssssssss", $podjetje, $lokacija, $pozicija, $izkusnje, $neto, $bruto, $korisnik, $god);
					$insert->execute();

				 echo "<div class=\"alert alert-warning\">";
				 echo "<h2>Podatki so uspe&scaron;no shranjeni.</h2>";
				 echo "</div>";
				 $insert->close();
				} else {
					echo "<div class=\"alert alert-warning boks\">";
					echo "<h2>So va&scaron;i podatki &#382;e vne&scaron;eni v bazo.</h2>";
					echo "</div>";
				}


		}

		$con->close();
		?>

	<h4 class="display-4 text-center">Vnesite svojo pla&#269;o</h4>
	
	<p class="text-center mt-2">Anketa je anonimna in <strong>vaše ime ne bo objavljeno</strong>. Plače lahko vnesete enkrat letno.</p>

		<form method="POST" id="forma" class="form-group">

		  Podjetje: <select id="naziv" name="naziv" class="form-control">

		  </select>

			Lokacija: <select id="lokacija" name="lokacija" class="form-control select2">
			<option value="Ljubljana">Ljubljana</option>
			<option value="Maribor">Maribor</option>
			<option value="Kranj">Kranj</option>
			<option value="Celje">Celje</option>
			<option value="Koper">Koper</option>
			<option value="Velenje">Velenje</option>
			<option value="Novo Mesto">Novo Mesto</option>
			<option value="Ptuj">Ptuj</option>
			<option value="Kamnik">Kamnik</option>
			<option value="Trbovlje">Trbovlje</option>
			<option value="Jesenice">Jesenice</option>
			<option value="Dom&#382;ale">Dom&#382;ale</option>
			<option value="Nova Gorica">Nova Gorica</option>
			<option value="Izola">Izola</option>
			<option value="&Scaron;kofja Loka">&Scaron;kofja Loka</option>
			<option value="Murska Sobota">Murska Sobota</option>
			</select>

		  Delovno mesto: <select id="rmesto" name="rmesto" class="form-control"></select>
			Izku&scaron;nje: <select id="senioritet" name="senioritet" class="form-control">
			<option value="Junior">Junior</option>
			<option value="Medior">Medior</option>
			<option value="Senior">Senior</option>
			</select>
			NETO pla&#269;ilo (EUR): <input type="number" id="neto" name="neto" class="form-control" placeholder="Pla&#269;ilo:" min="1000" max="9900" Required>
			BRUTO pla&#269;ilo (EUR): <input type="number" id="bruto" name="bruto" class="form-control" placeholder="Pla&#269;ilo:" min="1000" max="9900" Required>
			<input type="submit" name="submit" class="btn btn-dark mt-3" value="PO&Scaron;LJI">
		</form>

		<script src="js/validacija.js" charset="utf-8"></script>
		<script src="js/json.js" charset="utf-8"></script>
		<script src="js/json2.js" charset="utf-8"></script>


	<?php else :?>

    <div class="text-center">
        <p class="text-center my-2">Anketa je anonimna in <strong>vaše ime ne bo objavljeno</strong>. Plače lahko vnesete enkrat letno.</p>
		<a href="<?php print $hybridauthConfig['callback'] . "?via=LinkedIn";?>" class="btn btn-dark mt-4 mb-2"><i class="fa fa-linkedin"></i> | Prijavite se s LinkedIn ra&#269;unom</a>
	</br>
		<a href="<?php print $hybridauthConfig['callback'] . "?via=GitHub";?>" class="btn btn-dark mb-5"><i class="fa fa-github"></i> | Prijavite se s GitHub ra&#269;unom</a>
  	</div>

	<?php endif; ?>

</div>

<?php include("komponente/footer.html"); ?>
</body>
</html>
