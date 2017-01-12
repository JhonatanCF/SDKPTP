<?php

namespace JhonatanCF5;

/**
 * PSETransactionResponse Class
 */
class PSETransactionResponse extends ModelPlaceToPay
{
	protected $attributes = ['returnCode', 'bankURL', 'trazabilityCode', 'transactionCycle', 'transactionID',
							 'sessionID', 'bankCurrency', 'bankFactor', 'responseCode', 'responseReasonCode', 'responseReasonText'];
}

?>