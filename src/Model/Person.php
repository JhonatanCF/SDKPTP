<?php

namespace JhonatanCF5\Model;

/**
 * Person Class
 */
class Person extends ModelPlaceToPay
{
	protected $attributes = ['documentType', 'document', 'firstName', 'lastName', 'company', 'emailAddress',
							 'address', 'city', 'province', 'country', 'phone', 'mobile'];
}


?>
