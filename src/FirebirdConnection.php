<?php

namespace Firebird;

use Exception;
use Firebird\Query\Builder as FirebirdQueryBuilder;
use Firebird\Query\Grammars\Firebird1Grammar as Firebird1QueryGrammar;
use Firebird\Query\Grammars\Firebird2Grammar as Firebird2QueryGrammar;
use Firebird\Schema\Builder as FirebirdSchemaBuilder;
use Firebird\Schema\Grammars\FirebirdGrammar as FirebirdSchemaGrammar;
use Firebird\Support\Version;
use Illuminate\Database\Connection as DatabaseConnection;

class FirebirdConnection extends DatabaseConnection
{
    /**
     * Get the default query grammar instance.
     *
     * @return \Firebird\Query\Grammars\Firebird1Grammar|\Firebird\Query\Grammars\Firebird2Grammar
     */
    protected function getDefaultQueryGrammar()
    {
        switch ($this->getDatabaseVersion()) {
            case Version::FIREBIRD_15:
                return new Firebird1QueryGrammar;
            case Version::FIREBIRD_25:
                return new Firebird2QueryGrammar;
        }
    }

    /**
     * Get a schema builder instance for this connection.
     *
     * @return \Firebird\Schema\Builder
     */
    public function getSchemaBuilder()
    {
        if (is_null($this->schemaGrammar)) {
            $this->useDefaultSchemaGrammar();
        }

        return new FirebirdSchemaBuilder($this);
    }

    /**
     * Get the default schema grammar instance.
     *
     * @return \Firebird\Schema\Grammars\FirebirdGrammar
     */
    protected function getDefaultSchemaGrammar()
    {
        return $this->withTablePrefix(new FirebirdSchemaGrammar);
    }

    /**
     * Get a new query builder instance.
     *
     * @return \Firebird\Query\Builder
     */
    public function query()
    {
        return new FirebirdQueryBuilder(
            $this, $this->getQueryGrammar(), $this->getPostProcessor()
        );
    }

    /**
     * Execute a stored procedure.
     *
     * @param string $procedure
     * @param array $values
     *
     * @return \Illuminate\Support\Collection
     */
    public function executeProcedure($procedure, array $values = [])
    {
        return $this->query()->fromProcedure($procedure, $values)->get();
    }

    /**
     * The Firebird database version that should be used when compiling queries.
     *
     * @return string
     */
    protected function getDatabaseVersion()
    {
        if (! array_key_exists('version', $this->config)) {
            return Version::FIREBIRD_25;
        }

        // Check the user has provided a supported version.
        if (! in_array($this->config['version'], Version::SUPPORTED_VERSIONS)) {
            throw new Exception('The Firebird database version provided is not supported.');
        }

        return $this->config['version'];
    }
}
