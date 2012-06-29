<?php

// Nicer version of var_dump();
function pre() {
    $args = func_get_args();
    if (is_array($args) && !empty($args)) {
        foreach ($args as $a) {
            echo '<pre>';
            print_r($a);
            echo '</pre>';
        }
    }
}

// This class creates cookies from your PHP arrays. The arrays can be as deep as you want them,
// and CookieOven will crete nice little pieces to turn into cookies based on the $portion variable
// inside mix(); - set to 100 for demonstrative purposes.
//
// This class isn't practical to actually use due to the fact that request headers can get very long, 
// and if you're adding on these potentially huge cookies, you'll receive a Bad Request 400 error.
// If you get this, clear your cookies for the site.
class CookieOven{

	// Bowl: associative array that contains all data
	// Batter: one seriallized string version of the bowl
	// Tray: batter chopped up into portions
	// Cookies: copy of all key/values of the cookies we have
	function __construct(){
		$this->bowl = array();
		$this->preheat();
		$this->batter = "";
		$this->tray = array();
		$this->cookies = array();
	}

	// Read from existing cookies into our object
	public function preheat(){
		$oldCookies = array();
		$oldCookies = (array) json_decode($this->cool());

		if(!empty($oldCookies)){
			foreach($oldCookies as $spice => $info){
				$this->bowl[$spice] = $info;
			}
			$this->mix();
		}
	}

	// Add stuff (array) for the cookies and mix with old stuff
	public function add($ingredients){
		$oldCookies = array();
		$oldCookies = (array) json_decode($this->cool());

		foreach($ingredients as $key => $val){
			if(array_key_exists($key, $oldCookies)){
				$oldCookies[$key] = $val;
				unset($ingredients[$key]);
			}
		}

		foreach($oldCookies as $spice => $info){
			$this->bowl[$spice] = $info;
		}

		foreach($ingredients as $spice => $info){
			$this->bowl[$spice] = $info;
		}

		$this->mix();	
	}

	// Turn what's in the bowl into batter, tray it, and cookies
	public function mix(){
		$mixed = "";
		//array_walk($this->bowl, 'CookieOven::mix', &$mixed);

		$mixed = json_encode($this->bowl);
		$this->batter = $mixed;

		$portion = 100;
		$batter = $this->batter;

		$placing = 0;
		while(strlen($batter) > 0){
			$piece = substr($batter, 0, $portion);
			$batter = preg_replace( "/" . preg_quote($piece, "/") . "/", "", $batter, 1);

			$this->tray[$placing] = $piece;
			$placing++;
		}

		$this->eat();
		foreach($this->tray as $sheet => $bake){
			setcookie("CookieOven_tray_" . $sheet, $bake, time()+60*60*24);
			$this->cookies["CookieOven_tray_" . $sheet] = $bake;
		}
	}

	// Recursively stringifies multidimensional arrays
	/*public function mix($val, $key, &$mixed){
		if(is_array($val)){
			$mixed .=  $key . ":{";
			array_walk($val, 'CookieOven::mix', &$mixed);
			$mixed .= "},";
		}
		else
			$mixed .= $key . ":" . $val . ",";
	}*/	

	// Returns all object info, or specific section
	// Example: $obj->display('bowl'); Would only display the stuff in the bowl	
	public function display($one = false){
		$answer = $this;
		if($one){
			if($this->$one)
				$answer = $this->$one;
		}

		return pre($answer);
	}

	// Read from browser cookies - not object
	public function cool(){
		$everything = "";
		$leftovers = array();
		$leftovers = $_COOKIE;

		foreach($leftovers as $good => $filling){
			if(strpos($good, "CookieOven_tray_", 0) === 0){
				$everything .= $_COOKIE[$good];
			}
		}

		$done = stripslashes($everything);
		return $done;
	}	

	// Removes all browser cookies associated with this object
	public function eat($all = false){
		$leftovers = array();
		$leftovers = $_COOKIE;

		foreach($leftovers as $bad => $filling){
			if(strpos($bad, "CookieOven_tray_", 0) === 0){
				setcookie($bad, $bake, time()-3600);
			}
		}

		// Destroy all info in our object, as well
		if($all){
			$this->batter = "";
			$this->tray = array();
			$this->cookies = array();
		}
	}

}

?>