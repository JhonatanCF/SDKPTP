<?php 

use JhonatanCF5\Authentication;
use JhonatanCF5\Bank;
use \SoapClient;

/**
 * TestSDKPlaceToPay Class
 */
class TestSDKPlaceToPay extends PHPUnit_Framework_TestCase {
	
	private $servicio = "https://test.placetopay.com/soap/pse/?wsdl"; //url del servicio
	private $login = "6dd490faf9cb87a9862245da41170ff2";
	private $tranKey = "024h1IlD";
	
	/*private function __construct(array $attributes = array())
    {
        
    }*/
	
	/**
	 * Test bank list SOAP
	 */
	public function test_get_bank_list()
	{
		$parametros['auth'] =  new Authentication($this->login, $this->tranKey);
		$client = new SoapClient($this->servicio);
		
		$result = $client->__soapCall('getBankList', array($parametros));

		$banks = array();
		foreach($result->getBankListResult->item as $bank) {
			$banks[] = new Bank(get_object_vars($bank));
		}
		
		$this->assertContainsOnlyInstancesOf('JhonatanCF5\Bank', $banks);		
	}
	
}


 ?>