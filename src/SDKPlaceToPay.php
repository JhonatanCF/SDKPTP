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
use JhonatanCF5\Model\BDTransaction;

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
		$result = $this->clientSOAP->__soapCall('createTransaction', array(['auth' => $this->auth, 'transaction' => $transactionRequest]));

		return $this->getAndSavePSETransactionResponse(get_object_vars($result->createTransactionResult));
	}

	public function createTransactionMultiCredit(PSETransactionMultiCreditRequest $transactionRequest)
	{
		$result = $this->clientSOAP->__soapCall('createTransactionMultiCredit', array(['auth' => $this->auth, 'transaction' => $transactionRequest]));

		return $this->getAndSavePSETransactionResponse(get_object_vars($result->createTransactionMultiCreditResult));
	}

	public function ​getTransactionInformation($transactionID)
	{
		$result = $this->clientSOAP->__soapCall('getTransactionInformation', array(['auth' => $this->auth, 'transactionID' => $transactionID]));

		return new TransactionInformation(get_object_vars($result->getTransactionInformationResult));
	}

	public function refreshTransactionsPending()
	{
		$fecha = date('Y-m-d H:i:s');
        $lastTime = strtotime('-7 minutes');
        $transactions = BDTransaction::where([
		    	['return_code', '=', 'PENDING'],
		    	['created_at', '<', date('Y-m-d H:i:s', strtotime ( '-7 minute' , strtotime ( $fecha ) ))],
			])->get();

		foreach ($transactions as $transaction) {
			$this->getTransactionInformation($transaction->transaction_id);
		}

		return BDTransaction::where([
		    	['return_code', '=', 'PENDING'],
		    	['created_at', '<', date('Y-m-d H:i:s', strtotime ( '-7 minute' , strtotime ( $fecha ) ))],
			])->get();
	}

	/**
	 * Save data response en model Eloquent BDTransaction
	 * @param  array() $transactionResponse
	 * @return PSETransactionResponse
	 */
	private function getAndSavePSETransactionResponse($transactionResponse)
	{
		$responsePSE = new PSETransactionResponse($transactionResponse);

		if(is_object($responsePSE)) {
			$transaction = BDTransaction::find($responsePSE->transactionID);
			$transaction = is_object($transaction) ? $transaction : new BDTransaction;

			$transaction->transaction_id = $responsePSE->transactionID;
			$transaction->session_id = $responsePSE->sessionID;
			$transaction->return_code = $responsePSE->returnCode;
			$transaction->save();
		}

		return $responsePSE;
	}
}
?>