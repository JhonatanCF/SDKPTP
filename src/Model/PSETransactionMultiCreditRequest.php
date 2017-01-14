<?php

namespace JhonatanCF5\Model;

/**
 * PSETransactionMultiCreditRequest Class
 */
class PSETransactionMultiCreditRequest extends ModelPlaceToPay
{
	protected $attributes = ['credits', 'bankCode', 'bankInterface', 'returnURL', 'reference', 'description',
							 'language', 'currency', 'totalAmount', 'taxAmount', 'devolutionBase', 'tipAmount',
							 'payer', 'buyer', 'shipping', 'ipAddress', 'userAgent', 'additionalData'];

}

?>
