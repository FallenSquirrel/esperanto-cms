<?php
/**
 * SearchIndexInterface.php
 *
 * @since 04/10/14
 * @author Gerhard Seidel <gseidel.message@googlemail.com>
 */

namespace esperanto\SearchBundle\Search;


interface SearchIndexInterface
{
    public function getIndexTitle();
    public function getIndexTeaser();
    public function getIndexContent();
    public function getIndexRoute();
    public function getIndexRouteParameter();
}