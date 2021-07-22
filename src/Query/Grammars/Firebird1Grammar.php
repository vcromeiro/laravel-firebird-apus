<?php

namespace Firebird\Query\Grammars;

use Illuminate\Database\Query\Builder;

class Firebird1Grammar extends Firebird2Grammar
{
    /**
     * The components that make up a select clause.
     *
     * @var array
     */
    protected $selectComponents = [
        'limit', 'offset', 'aggregate', 'columns', 'from', 'joins',
        'wheres', 'groups', 'havings', 'orders', 'lock',
    ];

    /**
     * @param Builder $query
     * @param array $columns
     * @return string|null
     */
    protected function compileColumns(Builder $query, $columns)
    {
        // See superclass.
        if (! is_null($query->aggregate)) {
            return;
        }

        // In Firebird 1.5, the correct syntax of pagination is...
        // "select first [num_rows] skip [start_row] * from table" instead of...
        // "select * from table rows X to Y".
        // Reference: http://mc-computing.com/Databases/Firebird/SQL.html

        $select = 'select ';

        if ($query->limit) {
            $select .= 'first '.$query->limit.' ';
        }

        if ($query->offset) {
            $select .= 'skip '.$query->offset.' ';
        }

        if ($query->distinct) {
            $select .= 'distinct ';
        }

        return $select.$this->columnize($columns);
    }

    /**
     * Compile the "limit" portions of the query.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  int  $limit
     * @return string
     */
    protected function compileLimit(Builder $query, $limit)
    {
        // The compileColumns() function handles query limits for v1.5 due to
        // different query ordering.
        return '';
    }

    /**
     * Compile the "offset" portions of the query.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  int  $offset
     * @return string
     */
    protected function compileOffset(Builder $query, $offset)
    {
        // The compileColumns() function handles query offsets for v1.5 due to
        // different query ordering.
        return '';
    }
}
