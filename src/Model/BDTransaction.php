<?php

namespace JhonatanCF5\Model;

require_once '././config_bd.php';

use Illuminate\Database\Eloquent\Model;

/**
 * BDTransaction Class
 */
class BDTransaction extends Model
{
	protected $table = 'transactions';
    protected $fillable = [ 'transaction_id', 'session_id', 'return_code', 'created_at' ];
    protected $primaryKey = 'transaction_id';
}

?>