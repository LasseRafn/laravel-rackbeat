<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 16.48
 */

namespace Rackbeat\Models;


use Rackbeat\Utils\Model;

class CustomerInvoice extends Model
{

    protected $entity     = 'customer-invoices';
    protected $primaryKey = 'number';
}