<?php

use JhonatanCF5\Authentication;
use JhonatanCF5\SDKPlaceToPay;
use JhonatanCF5\Helpers\Helper;
use JhonatanCF5\Model\PSETransactionRequest;
use JhonatanCF5\Model\Person;
use JhonatanCF5\Model\Attribute;
use JhonatanCF5\Model\CreditConcept;
use JhonatanCF5\Model\PSETransactionMultiCreditRequest;

/**
 * TestSDKPlaceToPay Class
 */
class TestSDKPlaceToPay extends PHPUnit_Framework_TestCase {


	private $sdk;

	function __construct($fileName=false)
	{
		$this->sdk = new SDKPlaceToPay();
	}

	public function test_singleton_authentication_create_only_instance()
	{
		$this->assertSame(Authentication::getInstance(), Authentication::getInstance());
	}

	public function test_get_ip_client()
	{
		$this->assertRegExp('/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/', Helper::getIpAddress());
	}

	public function test_get_bank_list()
	{
		$this->assertContainsOnlyInstancesOf('JhonatanCF5\Model\Bank', $this->sdk->getBankList());
	}

	public function test_method_create_transaction()
	{
		$PSETransactionResponse = $this->sdk->createTransaction($this->get_object_PSETransactionRequest());
		$this->assertInstanceOf('JhonatanCF5\Model\PSETransactionResponse', $PSETransactionResponse);
		/*var_dump($PSETransactionResponse);*/
	}

	public function test_method_get_transaction()
	{
		$PSETransactionResponse = $this->sdk->createTransaction($this->get_object_PSETransactionRequest());
		$this->assertInstanceOf('JhonatanCF5\Model\PSETransactionResponse', $PSETransactionResponse);

		$transactionInformation = $this->sdk->​getTransactionInformation($PSETransactionResponse->transactionID);
		$this->assertInstanceOf('JhonatanCF5\Model\TransactionInformation', $transactionInformation);
	}

	public function test_method_create_transaction_multi_credit()
	{
		$PSETransactionResponse = $this->sdk->createTransactionMultiCredit($this->get_object_PSETransactionMultiCreditRequest());
		$this->assertInstanceOf('JhonatanCF5\Model\PSETransactionResponse', $PSETransactionResponse);

		$transactionInformation = $this->sdk->​getTransactionInformation($PSETransactionResponse->transactionID);
		$this->assertInstanceOf('JhonatanCF5\Model\TransactionInformation', $transactionInformation);
	}

	/**
	 * Refresh transactions pending. Consuming ws each 12 minutes. (12*60 = 720)
	 */
	public function test_transactions_pending()
	{
		$transactions = $this->sdk->refreshTransactionsPending();

		if( $transactions ) {
			while (is_array($transactions)) {
				sleep(720);
				$transactions = $this->sdk->refreshTransactionsPending();
			}
		}

		$this->assertSame(0, count($transactions));
	}
	//--------------------------------------------------------------------------------
	//

	// PRIVATE METHODS
	private function get_object_PSETransactionRequest()
	{
		return new PSETransactionRequest([
				'bankCode' => 1013,
                'bankInterface' => 0, //0:Personas - 1: Empresas
                'returnURL' => 'http://localhost/',
                'reference' => substr(uniqid(rand(), true), 0, 31),
                'description' => 'Pago PSE PtP',
                'language' => 'es',
                'currency' => 'COP',
                'totalAmount' => 59500,
                'taxAmount' => 5000,
                'devolutionBase' => 0,
                'tipAmount' => 0,
                'payer' => $this->get_object_payer_person(),
                'buyer' => null,
                'shipping' => null,
                'ipAddress'=> Helper::getIpAddress(),
                'userAgent'=> 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', //Helper::getClientBrowser()
                'additionalData'=>array(new Attribute(['name'=>'a', 'value'=>'b']), new Attribute(['name'=>'a', 'value'=>'b']))
		]);
	}

	private function get_object_payer_person()
	{
		return new Person([
            'document' => '205476819',
			'documentType' => 'CC',
            'firstName' => 'Hernan',
            'lastName' => 'Jaramillo',
            'company' => 'EPM',
            'emailAddress' => 'hernan_jaramillo@gmail.com',
            'address' => 'Cra 40 #76-55',
            'city' => 'Envigado',
            'province' => 'Antioquia',
            'country' => 'CO',
            'phone' => '3365827',
            'mobile' => '3155278941'
		]);
	}

	private function get_object_PSETransactionMultiCreditRequest()
	{
		return new PSETransactionMultiCreditRequest([
				'credits' => $this->get_object_credit(),
				'bankCode' => 1013,
                'bankInterface' => 0, //0:Personas - 1: Empresas
                'returnURL' => 'http://localhost/',
                'reference' => substr(uniqid(rand(), true), 0, 31),
                'description' => 'Pago PSE PtP',
                'language' => 'es',
                'currency' => 'COP',
                'totalAmount' => 59500,
                'taxAmount' => 5000,
                'devolutionBase' => 0,
                'tipAmount' => 0,
                'payer' => $this->get_object_payer_person(),
                'buyer' => null,
                'shipping' => null,
                'ipAddress'=> Helper::getIpAddress(),
                'userAgent'=> 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', //Helper::getClientBrowser()
                'additionalData'=>array(new Attribute(['name'=>'a', 'value'=>'b']), new Attribute(['name'=>'a', 'value'=>'b']))
		]);
	}

	private function get_object_credit()
	{
		return array(
			new CreditConcept([
				'entityCode' => 'A123',
				'serviceCode' => 'S12',
				'amountValue' => 59500,
				'taxValue' => 5000,
				'description' => 'Credit one'
			])
		);
	}
}

?>