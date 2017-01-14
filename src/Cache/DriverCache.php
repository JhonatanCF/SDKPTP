<?php

namespace JhonatanCF5\Cache;

use JhonatanCF5\Cache\CacheInterface;

date_default_timezone_set('America/Bogota');

/**
* Cache Class
*
*/
class DriverCache implements CacheInterface
{
	private $fileName = 'tmp/data.cache';

	function __construct($fileName=false)
	{
		if($fileName && $fileName!='') {
			$this->fileName = $fileName;
		}
	}

	/**
	 * Store data in the cache
	 *
	 * @param string 	$key
	 * @param mixed 	$data
	 * @param integer 	[optional] $expiration
	 * @return object
	 */
	public function put($key, $data, $expiration = 0) {
		$storeData = array(
			'date'   => date('Y-m-d H:i A'),
			'time'   => time(),
			'expire' => $expiration,
			'data'   => serialize($data)
	    );

	    $dataArray = $this->loadCache();

	    if (is_array($dataArray)) {
			$dataArray[$key] = $storeData;
	    }
	    else {
	    	$dataArray = array($key => $storeData);
	    }

	    $cacheData = json_encode($dataArray);
	    file_put_contents($this->fileName, $cacheData);
	    return $this;

	}

	/**
	 * Return data cached by its key
	 * @param  string $key
	 * @param  string $type:  'data' || 'time'
	 * @return Mixed
	 */
	public function get($key, $type = 'data') {
		$cachedData = $this->loadCache();

	    if($this->isCached($key, $type, $cachedData)) {
		    if($this->checkExpired($key, $cachedData)) {
		    	$this->forget($key, $cachedData);
		    	return null;
		    }

	    	return unserialize($cachedData[$key][$type]);
	    }
	}

	/**
	 * Erase data cached by $key
	 *
	 * @return integer
	 */
	public function forget($key, $cachedData)
	{
		if (is_array($cachedData)) {
			$counter = 0;
			foreach ($cachedData as $key => $entry) {
			    if ($this->isCached($key, 'data', $cachedData)) {
			    	unset($cachedData[$key]);
			      	$counter++;
			    }
		  	}
		  	if ($counter > 0) {
		    	$cachedData = json_encode($cachedData);
		    	file_put_contents($this->fileName, $cachedData);
		  	}
		  	return $counter;
		}
	}

	/**
	 * Check whether data accociated with a key
	 *
	 * @param  string $key
	 * @return boolean
	 */
	public function isCached($key, $type='data', $cachedData)
	{
		return isset($cachedData[$key][$type]);
	}

	/**
	 * Check whether a timestamp is still in the duration
	 *
	 * @param integer $timestamp
	 * @param integer $expiration
	 * @return boolean
	 */
	public function checkExpired($key, $cachedData)
	{
		$time = $cachedData[$key]['time'];
		$expiration = $cachedData[$key]['expire'];

		if ($expiration > 0) {
			$timeDiff = time() - $time;
			return $timeDiff > $expiration; //? true : false
		}
		return false;

	}

	/**
	 * Load appointed cache
	 *
	 * @return mixed
	 */
	private function loadCache()
	{
		if (file_exists($this->fileName)) {
			$file = file_get_contents($this->fileName);
			return json_decode($file, true);
		}

		return false;
	}

	/**
	 * Validate load data in $cachedData
	 * @param  [type] $cachedData [description]
	 * @return [type]             [description]
	 */
	private function validateData($cachedData)
	{
		if(!$cachedData) {
			$cachedData = $this->loadCache();
		}

		return $cachedData;
	}
}

 ?>