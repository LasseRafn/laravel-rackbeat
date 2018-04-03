<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 1.4.18.
 * Time: 00.02
 */

namespace Rackbeat\Models\Variation;


use Rackbeat\Builders\Variation\TypeOptionBuilder;
use Rackbeat\Utils\Model;
use Rackbeat\Utils\Request;

class Type extends Model
{
    public    $number;
    protected $entity          = 'variations/:variation_number/types';
    protected $primaryKey      = 'number';
    protected $typeOptionModel = TypeOption::class;

    public function __construct( Request $request, array $data = [] )
    {
        parent::__construct( $request, $data );

        str_replace( ':variation_number', $this->variation_id, $this->entity );
    }

    public function options()
    {
        $options    = new TypeOptionBuilder( $this->request );
        $old_entity = $options->getEntity();
        $new_entity = $options->setEntity( str_replace( ':variation_number', $this->variation_id, $old_entity ) );
        $options->setEntity( str_replace( 'type_number', $this->primaryKey, $new_entity ) );

        return $options;
    }
}