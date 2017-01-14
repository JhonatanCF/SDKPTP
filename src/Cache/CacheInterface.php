<?php

namespace JhonatanCF5\Cache;

interface CacheInterface {

	public function put($key, $data, $expiration);

	public function get($key, $type);

	public function forget($key, $cacheData);
}

 ?>