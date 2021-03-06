<?php
/**
 * Created by PhpStorm.
 * User: nts
 * Date: 31.3.18.
 * Time: 17.00
 */

namespace Rackbeat\Builders;

use Rackbeat\Utils\Model;
use Rackbeat\Utils\Request;


class Builder
{
    protected $entity;
    /** @var Model */
    protected $model;
    private   $request;

    public function __construct( Request $request )
    {
        $this->request = $request;
    }


    /**
     * @param array $filters
     *
     * @return \Illuminate\Support\Collection|Model[]
     */
    public function get( $filters = [] )
    {
        $filters[] = [ 'limit', '=', 1500 ];

        $urlFilters = $this->parseFilters( $filters );

        return $this->request->handleWithExceptions( function () use ( $urlFilters ) {

            $response     = $this->request->client->get( "{$this->entity}{$urlFilters}" );
            $responseData = json_decode( (string) $response->getBody() );
            $fetchedItems = collect( $responseData );
            $items        = collect( [] );
            $pages        = $responseData->pages;

            foreach ( $fetchedItems->first() as $index => $item ) {


                /** @var Model $model */
                $model = new $this->model( $this->request, $item );

                $items->push( $model );


            }

            return $items;
        } );
    }

    protected function parseFilters( $filters = [] )
    {

        $urlFilters = '';

        if ( count( $filters ) > 0 ) {

            $i = 1;

            $urlFilters .= '?';

            foreach ( $filters as $filter ) {

                $urlFilters .= $filter[ 0 ] . $filter[ 1 ] . $filter[ 2 ] ?? '=';

                if ( count( $filters ) > $i ) {

                    $urlFilters .= '&';
                }

                $i++;
            }
        }

        return $urlFilters;
    }

    public function all( $filters = [] )
    {
        $page = 1;

        $items = collect();

        $response = function ( $filters, $page ) {

            $filters[] = [ 'limit', '=', 1500 ];
            $filters[] = [ 'page', '=', $page ];

            $urlFilters = $this->parseFilters( $filters );

            return $this->request->handleWithExceptions( function () use ( $urlFilters ) {

                $response     = $this->request->client->get( "{$this->entity}{$urlFilters}" );
                $responseData = json_decode( (string) $response->getBody() );
                $fetchedItems = collect( $responseData );
                $items        = collect( [] );
                $pages        = $responseData->pages;

                foreach ( $fetchedItems->first() as $index => $item ) {


                    /** @var Model $model */
                    $model = new $this->model( $this->request, $item );

                    $items->push( $model );


                }

                return (object) [

                    'items' => $items,
                    'pages' => $pages,
                ];
            } );
        };

        do {

            $resp = $response( $filters, $page );

            $items = $items->merge( $resp->items );
            $page++;
            sleep( 2 );

        } while ( $page <= $resp->pages );


        return $items;

    }

    public function find( $id )
    {
        return $this->request->handleWithExceptions( function () use ( $id ) {

            $response     = $this->request->client->get( "{$this->entity}/{$id}" );
            $responseData = collect( json_decode( (string) $response->getBody() ) );

            return new $this->model( $this->request, $responseData->first() );
        } );
    }

    public function create( $data )
    {
        return $this->request->handleWithExceptions( function () use ( $data ) {

            $response = $this->request->client->post( "{$this->entity}", [
                'json' => $data,
            ] );

            $responseData = collect( json_decode( (string) $response->getBody() ) );

            return new $this->model( $this->request, $responseData->first() );
        } );
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function setEntity( $new_entity )
    {
        $this->entity = $new_entity;

        return $this->entity;
    }
}