<?php

namespace JhonatanCF5;

/**
 * PSETransactionRequest Class
 */
class PSETransactionRequest extends ModelPlaceToPay
{
	protected $attributes = ['bankCode', 'bankInterface', 'returnURL', 'reference', 'description', 'language', 'currency',
							 'totalAmount', 'taxAmount', 'devolutionBase', 'tipAmount', 'payer', 'buyer', 'shipping',
							 'ipAddress', 'userAgent', 'additionalData'];
}

?>