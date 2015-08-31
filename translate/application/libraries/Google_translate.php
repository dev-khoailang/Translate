<?php
class Google_translate {
	public $api_key = '';
	public $source="en";
	public $target="fr";

	function set_config($source_lang, $target_lang, $api_key) {
		$this->api_key = $api_key;
		$this->source = strtolower($source_lang);
		$this->target = strtolower($target_lang);
	}

	function get_translated($text) {
		$obj = $this->translate($text);
		if($obj != null)
		{
		    if(isset($obj['error']))
		    {
		        log_message("error", "Error is : ".$obj['error']['message']);
		    }
		    else
		    {
		        return $obj['data']['translations'][0]['translatedText']."n";
		    }
		} else {
			log_message("error", "error when translate");
		    return false;
		}
	}
	 
	function translate($text)
	{
	    $url = 'https://www.googleapis.com/language/translate/v2?key=' . $this->api_key . '&q=' . rawurlencode($text);
	    $url .= '&target='.$this->target;
	    if($this->source)
	    	$url .= '&source='.$this->source;
	 
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $response = curl_exec($ch);                 
	    var_dump($response);die;
	    curl_close($ch);
	 
	    $obj =json_decode($response,true); //true converts stdClass to associative array.
	    return $obj;
	}   
}
?>
