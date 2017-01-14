<?php

use JhonatanCF5\Authentication;
use JhonatanCF5\SDKPlaceToPay;

/**
 * TestSDKPlaceToPay Class
 */
class TestSDKPlaceToPay extends PHPUnit_Framework_TestCase {

	public function test_get_bank_list()
	{
		$sdk = new SDKPlaceToPay();

		$this->assertContainsOnlyInstancesOf('JhonatanCF5\Model\Bank', $sdk->getBankList());
	}

	public function test_singleton_authentication_create_only_instance()
	{
		$this->assertSame(Authentication::getInstance(), Authentication::getInstance());
	}

	/*public function test_cache_banks()
	{
		$parametros['auth'] =  Authentication::getInstance();
		$client = new SoapClient($parametros['auth']->getServicio());

		$result = $client->__soapCall('getBankList', array($parametros));

		$banks = array();
		foreach($result->getBankListResult->item as $bank) {
			$banks[] = new Bank(get_object_vars($bank));
		}

		DriverCache::put('banks', $data, 86400);//86400= (24 * 60 * 60) || 24 horas; 60 minutos; 60 segundos
	}*/

}


 ?>