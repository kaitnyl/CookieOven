<?

ob_start();

include("CookieOven.php");

$oven = new CookieOven();
$oven->preheat();

$inserti = array("color" => "red",
			     "night" => "time",
			     "nice" => "day",
			     "mouse" => "pad",
			     "break" => "fast",
			     "multi" => array("di" => "men",
			    				  "sion" => "al",
			    				  "arr" => array("ay" => "ay", 
			    				 				 "kait" => "lyn")),
			     "back" => "to",
			     "square" => "one"
		   );

$insertii = array("good" => "day",
				  "happy" => "birthday",
				  "drink" => "coffee",
				  "many" => array("new" => "old"),
				  "cats" => array("kitten" => "cute")
			);

// Can only use the add method once - so make sure to combine your arrays if you have multiple.
// This is due to adding cookies, and the current window not being able to read the ones 
// you just previously added (until you refresh the page). Therefore, one add call per page.
$oven->add(array_merge($inserti, $insertii));

?>


<html>
	<head>
		<title>COOKIEOVEN ~</title>
		<style>
			body {
				word-wrap: break-word;
			}
		</style>
	</head>
	<body>
		<hr />
		<h3> PHP Object: </h3>
		<?php pre($oven->display()); ?>
		<hr />
		<h3> Browser Cookies: </h3>
		<?php pre($_COOKIE); ?>
		<hr />
		<h3> Reading in PHP from browser cookies: </h3>
		<?php 
			// Going to completely destroy the current CookieOven to demonstrate that
			// it's actually working from cookies
			$oven->eat(true);

			// New CookieOven, so preheat to get contens from browser cookies!
			$oven = new CookieOven();
			$oven->preheat();

			// Simple example
			echo "\$oven->bowl['color'] is: " . $oven->bowl['color'];

			// Multidimensional array example
			foreach($oven->bowl['multi'] as $multi){
				if(is_object($multi)){
					foreach($multi as $key => $arr){
						if($key == 'kait')
							echo "<br /> \$oven->bowl['multi']['arr']['kait'] is: " . $arr;
					}
				}
			}
		?>
		<hr />
	</body>
</html>

<?php ob_flush(); ?>