<?php
 $con=mysqli_connect("localhost","xxx","xxx","itplaces_itplace");
 $con2=mysqli_connect("localhost","xxx","xxx","itplaces_itplace");


$hybridauthConfig = [
	'callback' => 'https://it-place.si/vpis.php',
	'providers' => [
		'LinkedIn' => [
			'enabled' => true,
			'keys' => [
				'id' => 'xxx',
				'secret' => 'xxx',
			],
		],
		'GitHub' => [
			'enabled' => true,
			'keys' => [
				'id' => 'xxx',
				'secret' => 'xxx',
			],
		]
	],
];
?>
