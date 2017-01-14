<?php

namespace JhonatanCF5\Model;

/**
 * PSETransactionResponse Class
 */
class PSETransactionResponse extends ModelPlaceToPay
{
	protected $attributes = ['returnCode', 'bankURL', 'trazabilityCode', 'transactionCycle', 'transactionID',
							 'sessionID', 'bankCurrency', 'bankFactor', 'responseCode', 'responseReasonCode', 'responseReasonText'];
}

?>