<?php

namespace JhonatanCF5\Model;

/**
 * TransactionInformation Class
 */
class TransactionInformation extends ModelPlaceToPay
{
	protected $attributes = ['transactionID', 'sessionID', 'reference', 'requestDate', 'bankProcessDate', 'onTest',
							 'returnCode', 'trazabilityCode', 'transactionCycle', 'transactionState', 'responseCode',
							 'responseReasonCode', 'responseReasonText'];

}

?>