<?php


/**
 * Base class that represents a query for the 'author_key_value' table.
 *
 *
 *
 * @method AuthorKVQuery orderByAuthorId($order = Criteria::ASC) Order by the author_id column
 * @method AuthorKVQuery orderByKey($order = Criteria::ASC) Order by the key column
 * @method AuthorKVQuery orderByValue($order = Criteria::ASC) Order by the value column
 *
 * @method AuthorKVQuery groupByAuthorId() Group by the author_id column
 * @method AuthorKVQuery groupByKey() Group by the key column
 * @method AuthorKVQuery groupByValue() Group by the value column
 *
 * @method AuthorKVQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AuthorKVQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AuthorKVQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AuthorKVQuery leftJoinAuthor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Author relation
 * @method AuthorKVQuery rightJoinAuthor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Author relation
 * @method AuthorKVQuery innerJoinAuthor($relationAlias = null) Adds a INNER JOIN clause to the query using the Author relation
 *
 * @method AuthorKV findOne(PropelPDO $con = null) Return the first AuthorKV matching the query
 * @method AuthorKV findOneOrCreate(PropelPDO $con = null) Return the first AuthorKV matching the query, or a new AuthorKV object populated from the query conditions when no match is found
 *
 * @method AuthorKV findOneByAuthorId(int $author_id) Return the first AuthorKV filtered by the author_id column
 * @method AuthorKV findOneByKey(string $key) Return the first AuthorKV filtered by the key column
 * @method AuthorKV findOneByValue(string $value) Return the first AuthorKV filtered by the value column
 *
 * @method array findByAuthorId(int $author_id) Return AuthorKV objects filtered by the author_id column
 * @method array findByKey(string $key) Return AuthorKV objects filtered by the key column
 * @method array findByValue(string $value) Return AuthorKV objects filtered by the value column
 *
 * @package    propel.generator.bookstore.om
 */
abstract class BaseAuthorKVQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAuthorKVQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'bookstore', $modelName = 'AuthorKV', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AuthorKVQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     AuthorKVQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AuthorKVQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AuthorKVQuery) {
            return $criteria;
        }
        $query = new AuthorKVQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   AuthorKV|AuthorKV[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AuthorKVPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AuthorKVPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return   AuthorKV A model object, or null if the key is not found
     * @throws   PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `AUTHOR_ID`, `KEY`, `VALUE` FROM `author_key_value` WHERE `AUTHOR_ID` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new AuthorKV();
            $obj->hydrate($row);
            AuthorKVPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return AuthorKV|AuthorKV[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|AuthorKV[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return AuthorKVQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AuthorKVPeer::AUTHOR_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AuthorKVQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AuthorKVPeer::AUTHOR_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the author_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAuthorId(1234); // WHERE author_id = 1234
     * $query->filterByAuthorId(array(12, 34)); // WHERE author_id IN (12, 34)
     * $query->filterByAuthorId(array('min' => 12)); // WHERE author_id > 12
     * </code>
     *
     * @see       filterByAuthor()
     *
     * @param     mixed $authorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthorKVQuery The current query, for fluid interface
     */
    public function filterByAuthorId($authorId = null, $comparison = null)
    {
        if (is_array($authorId) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(AuthorKVPeer::AUTHOR_ID, $authorId, $comparison);
    }

    /**
     * Filter the query on the key column
     *
     * Example usage:
     * <code>
     * $query->filterByKey('fooValue');   // WHERE key = 'fooValue'
     * $query->filterByKey('%fooValue%'); // WHERE key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $key The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthorKVQuery The current query, for fluid interface
     */
    public function filterByKey($key = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($key)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $key)) {
                $key = str_replace('*', '%', $key);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthorKVPeer::KEY, $key, $comparison);
    }

    /**
     * Filter the query on the value column
     *
     * Example usage:
     * <code>
     * $query->filterByValue('fooValue');   // WHERE value = 'fooValue'
     * $query->filterByValue('%fooValue%'); // WHERE value LIKE '%fooValue%'
     * </code>
     *
     * @param     string $value The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AuthorKVQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($value)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $value)) {
                $value = str_replace('*', '%', $value);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AuthorKVPeer::VALUE, $value, $comparison);
    }

    /**
     * Filter the query by a related Author object
     *
     * @param   Author|PropelObjectCollection $author The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   AuthorKVQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByAuthor($author, $comparison = null)
    {
        if ($author instanceof Author) {
            return $this
                ->addUsingAlias(AuthorKVPeer::AUTHOR_ID, $author->getId(), $comparison);
        } elseif ($author instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AuthorKVPeer::AUTHOR_ID, $author->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByAuthor() only accepts arguments of type Author or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Author relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AuthorKVQuery The current query, for fluid interface
     */
    public function joinAuthor($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Author');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Author');
        }

        return $this;
    }

    /**
     * Use the Author relation Author object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   AuthorQuery A secondary query class using the current class as primary query
     */
    public function useAuthorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAuthor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Author', 'AuthorQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   AuthorKV $authorKV Object to remove from the list of results
     *
     * @return AuthorKVQuery The current query, for fluid interface
     */
    public function prune($authorKV = null)
    {
        if ($authorKV) {
            $this->addUsingAlias(AuthorKVPeer::AUTHOR_ID, $authorKV->getAuthorId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
