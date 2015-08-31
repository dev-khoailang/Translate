<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model('translate_model', 'translate');
	}

	public function index($source_lang = 'US', $target_lang = 'FR', $page = 0) 
	{
		$countries = $this->translate->get_all_country();

		$source_lang = strtolower($source_lang);
		if(!in_array($source_lang, $countries))
			$source_lang = 'us';

		$rematch_countries = array(
			'us' => 'en',
			'jp' => 'ja',
			'uk' => 'en'
		);

		$google_source = $source_lang;
		$google_target = $target_lang;

		foreach($rematch_countries as $key => $val) {
			if($key == $source_lang)
				$google_source = $val;
		}

		if($google_source == $google_target) {
			exit('the source and target languages are the same');
		}

		// get your configuration variables
		$api_key = $this->config->item('api_key');

		// load library
		$this->load->library('Google_translate');
		// set library config
		$this->google_translate->set_config($google_source, $google_target, $api_key);

		// defined variables
		$total = $this->translate->total_source_rows($source_lang);

		if(!is_numeric($page)) $page = 0;

		$limit = 20;
		$start = $page * $limit;

		$run = true;
		$count = 1;

		// run
		do {
			$sources = $this->translate->get_source_rows($limit, $start, $source_lang);

			// the latest rows
			if(!$sources) {
				$run = false;
				exit('done all');
			}

			foreach($sources as $source) {
				echo "$count of $total - start $start - limit $limit".PHP_EOL; $count++;

				$nodepath_translated = html_entity_decode($this->google_translate->get_translated($source->nodepath), ENT_QUOTES, 'UTF-8');
				$nodepath_translated = str_replace(' / ', '/', $nodepath_translated);
				$nodeenpoint_translated = html_entity_decode($this->google_translate->get_translated($source->nodeenpoint), ENT_QUOTES, 'UTF-8');
				$nodeenpoint_translated = str_replace(' / ', '/', $nodeenpoint_translated);

				$nodepath_hash = substr(md5($nodepath_translated),0,16);

				// check for existed in target table
				$where = array(
					'node_path_hash' => $nodepath_hash,
					'target-lang' => $target_lang
				);

				// check existed first
				$check = $this->translate->check_exist_target($where);
				if($check) {
					echo "existed - $nodepath_translated - ".$check->node_path_hash . PHP_EOL;
					continue;
				}

				// insert into target table
				$data = array(
					'country' => $source->country
					,'node-id' => $source->nodeid
					,'node-path' => $nodepath_translated
					,'node-enpoint' => $nodeenpoint_translated
					,'target-lang' => $target_lang
					,'node_path_hash' => $nodepath_hash
				);
				$this->translate->save_translated($data); unset($data);

				echo "source: ".$source->nodepath.PHP_EOL;
				echo "translated: ".$nodepath_translated.PHP_EOL	;
				echo "----------------------------------".PHP_EOL;

				if($count%100 == 0) {
					echo "---------- sleep 2 seconds";
					sleep(2);
				}

			}

			// next rows
			$start += $limit;
		} while ($run);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */