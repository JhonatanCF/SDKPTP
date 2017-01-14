<?php

namespace JhonatanCF5;

use \SoapClient;
use JhonatanCF5\Authentication;
use JhonatanCF5\Cache\DriverCache;
use JhonatanCF5\Model\Bank;
use JhonatanCF5\Model\PSETransactionRequest;
use JhonatanCF5\Model\PSETransactionResponse;
use JhonatanCF5\Model\PSETransactionMultiCreditRequest;
use JhonatanCF5\Model\TransactionInformation;

/**
* SDKPlaceToPay Class
*/
class SDKPlaceToPay
{
	protected $auth;
	protected $clientSOAP;
	protected $cache;

	function __construct()
	{
		$this->auth =  Authentication::getInstance();
		$this->clientSOAP = new SoapClient($this->auth->getServicio());
		$this->cache = new DriverCache();
	}

	public function getBankList()
	{
		$banks = $this->cache->get('banks');

		if($banks==null) {
			$banks = array();
			$result = $this->clientSOAP->__soapCall('getBankList', array(['auth' => $this->auth]));

			foreach($result->getBankListResult->item as $bank) {
				$banks[] = new Bank(get_object_vars($bank));
			}

			$this->cache->put('banks', $banks, 86400);//86400= (24 * 60 * 60) || 24 horas; 60 minutos; 60 segundos
		}
		return $banks;
	}

	public function createTransaction(PSETransactionRequest $transactionRequest)
	{
		$result = $this->clientSOAP->__soapCall('createTransaction', array(['auth' => $this->auth], ['transaction ' => $transactionRequest]));

		return new PSETransactionResponse(get_object_vars($result->createTransactionResult));
	}

	public function createTransactionMultiCredit(PSETransactionMultiCreditRequest $transactionRequest)
	{
		$result = $this->clientSOAP->__soapCall('createTransactionMultiCredit', array(['auth' => $this->auth], ['transaction ' => $transactionRequest]));

		return new PSETransactionResponse(get_object_vars($result->createTransactionMultiCreditResult));
	}

	public function ​getTransactionInformation($transactionID)
	{
		$result = $this->clientSOAP->__soapCall('getTransactionInformation', array(['auth' => $this->auth], ['transactionID ' => $transactionID]));

		return new TransactionInformation(get_object_vars($result->getTransactionInformationResult));
	}
}
?>