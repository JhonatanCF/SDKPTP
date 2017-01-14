<?php

namespace JhonatanCF5;

use \SoapClient;
use JhonatanCF5\Authentication;
use JhonatanCF5\Cache\DriverCache;
use JhonatanCF5\Model\Bank;

/**
* SDKPlaceToPay Class
*/
class SDKPlaceToPay
{
	protected $parametros = array();
	protected $clientSOAP;
	protected $cache;

	function __construct()
	{
		$this->parametros['auth'] =  Authentication::getInstance();
		$this->clientSOAP = new SoapClient($this->parametros['auth']->getServicio());
		$this->cache = new DriverCache();
	}

	public function getBankList()
	{
		$banks = $this->cache->get('banks');

		if($banks==null) {
			$banks = array();
			$result = $this->clientSOAP->__soapCall('getBankList', array($this->parametros));

			foreach($result->getBankListResult->item as $bank) {
				$banks[] = new Bank(get_object_vars($bank));
			}

			$this->cache->put('banks', $banks, 86400);//86400= (24 * 60 * 60) || 24 horas; 60 minutos; 60 segundos
		}
		return $banks;
	}
}
?>