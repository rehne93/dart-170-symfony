<?php

namespace Base;

use \SplitScore as ChildSplitScore;
use \SplitScoreQuery as ChildSplitScoreQuery;
use \Exception;
use \PDO;
use Map\SplitScoreTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'splitScore' table.
 *
 *
 *
 * @method     ChildSplitScoreQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSplitScoreQuery orderByFinalscore($order = Criteria::ASC) Order by the finalScore column
 * @method     ChildSplitScoreQuery orderByPlayerid($order = Criteria::ASC) Order by the playerId column
 * @method     ChildSplitScoreQuery orderByDate($order = Criteria::ASC) Order by the date column
 *
 * @method     ChildSplitScoreQuery groupById() Group by the id column
 * @method     ChildSplitScoreQuery groupByFinalscore() Group by the finalScore column
 * @method     ChildSplitScoreQuery groupByPlayerid() Group by the playerId column
 * @method     ChildSplitScoreQuery groupByDate() Group by the date column
 *
 * @method     ChildSplitScoreQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSplitScoreQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSplitScoreQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSplitScoreQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSplitScoreQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSplitScoreQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSplitScoreQuery leftJoinPlayer($relationAlias = null) Adds a LEFT JOIN clause to the query using the Player relation
 * @method     ChildSplitScoreQuery rightJoinPlayer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Player relation
 * @method     ChildSplitScoreQuery innerJoinPlayer($relationAlias = null) Adds a INNER JOIN clause to the query using the Player relation
 *
 * @method     ChildSplitScoreQuery joinWithPlayer($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Player relation
 *
 * @method     ChildSplitScoreQuery leftJoinWithPlayer() Adds a LEFT JOIN clause and with to the query using the Player relation
 * @method     ChildSplitScoreQuery rightJoinWithPlayer() Adds a RIGHT JOIN clause and with to the query using the Player relation
 * @method     ChildSplitScoreQuery innerJoinWithPlayer() Adds a INNER JOIN clause and with to the query using the Player relation
 *
 * @method     \PlayerQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSplitScore findOne(ConnectionInterface $con = null) Return the first ChildSplitScore matching the query
 * @method     ChildSplitScore findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSplitScore matching the query, or a new ChildSplitScore object populated from the query conditions when no match is found
 *
 * @method     ChildSplitScore findOneById(int $id) Return the first ChildSplitScore filtered by the id column
 * @method     ChildSplitScore findOneByFinalscore(int $finalScore) Return the first ChildSplitScore filtered by the finalScore column
 * @method     ChildSplitScore findOneByPlayerid(int $playerId) Return the first ChildSplitScore filtered by the playerId column
 * @method     ChildSplitScore findOneByDate(string $date) Return the first ChildSplitScore filtered by the date column *
 * @method     ChildSplitScore requirePk($key, ConnectionInterface $con = null) Return the ChildSplitScore by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSplitScore requireOne(ConnectionInterface $con = null) Return the first ChildSplitScore matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSplitScore requireOneById(int $id) Return the first ChildSplitScore filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSplitScore requireOneByFinalscore(int $finalScore) Return the first ChildSplitScore filtered by the finalScore column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSplitScore requireOneByPlayerid(int $playerId) Return the first ChildSplitScore filtered by the playerId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSplitScore requireOneByDate(string $date) Return the first ChildSplitScore filtered by the date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSplitScore[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSplitScore objects based on current ModelCriteria
 * @method     ChildSplitScore[]|ObjectCollection findById(int $id) Return ChildSplitScore objects filtered by the id column
 * @method     ChildSplitScore[]|ObjectCollection findByFinalscore(int $finalScore) Return ChildSplitScore objects filtered by the finalScore column
 * @method     ChildSplitScore[]|ObjectCollection findByPlayerid(int $playerId) Return ChildSplitScore objects filtered by the playerId column
 * @method     ChildSplitScore[]|ObjectCollection findByDate(string $date) Return ChildSplitScore objects filtered by the date column
 * @method     ChildSplitScore[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SplitScoreQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SplitScoreQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\SplitScore', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSplitScoreQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSplitScoreQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSplitScoreQuery) {
            return $criteria;
        }
        $query = new ChildSplitScoreQuery();
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
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildSplitScore|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SplitScoreTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = SplitScoreTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string)$key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSplitScore A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, finalScore, playerId, date FROM splitScore WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildSplitScore $obj */
            $obj = new ChildSplitScore();
            $obj->hydrate($row);
            SplitScoreTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string)$key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildSplitScore|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildSplitScoreQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SplitScoreTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSplitScoreQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SplitScoreTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSplitScoreQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SplitScoreTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SplitScoreTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SplitScoreTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the finalScore column
     *
     * Example usage:
     * <code>
     * $query->filterByFinalscore(1234); // WHERE finalScore = 1234
     * $query->filterByFinalscore(array(12, 34)); // WHERE finalScore IN (12, 34)
     * $query->filterByFinalscore(array('min' => 12)); // WHERE finalScore > 12
     * </code>
     *
     * @param     mixed $finalscore The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSplitScoreQuery The current query, for fluid interface
     */
    public function filterByFinalscore($finalscore = null, $comparison = null)
    {
        if (is_array($finalscore)) {
            $useMinMax = false;
            if (isset($finalscore['min'])) {
                $this->addUsingAlias(SplitScoreTableMap::COL_FINALSCORE, $finalscore['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($finalscore['max'])) {
                $this->addUsingAlias(SplitScoreTableMap::COL_FINALSCORE, $finalscore['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SplitScoreTableMap::COL_FINALSCORE, $finalscore, $comparison);
    }

    /**
     * Filter the query on the playerId column
     *
     * Example usage:
     * <code>
     * $query->filterByPlayerid(1234); // WHERE playerId = 1234
     * $query->filterByPlayerid(array(12, 34)); // WHERE playerId IN (12, 34)
     * $query->filterByPlayerid(array('min' => 12)); // WHERE playerId > 12
     * </code>
     *
     * @see       filterByPlayer()
     *
     * @param     mixed $playerid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSplitScoreQuery The current query, for fluid interface
     */
    public function filterByPlayerid($playerid = null, $comparison = null)
    {
        if (is_array($playerid)) {
            $useMinMax = false;
            if (isset($playerid['min'])) {
                $this->addUsingAlias(SplitScoreTableMap::COL_PLAYERID, $playerid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($playerid['max'])) {
                $this->addUsingAlias(SplitScoreTableMap::COL_PLAYERID, $playerid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SplitScoreTableMap::COL_PLAYERID, $playerid, $comparison);
    }

    /**
     * Filter the query on the date column
     *
     * Example usage:
     * <code>
     * $query->filterByDate('2011-03-14'); // WHERE date = '2011-03-14'
     * $query->filterByDate('now'); // WHERE date = '2011-03-14'
     * $query->filterByDate(array('max' => 'yesterday')); // WHERE date > '2011-03-13'
     * </code>
     *
     * @param     mixed $date The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSplitScoreQuery The current query, for fluid interface
     */
    public function filterByDate($date = null, $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(SplitScoreTableMap::COL_DATE, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(SplitScoreTableMap::COL_DATE, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SplitScoreTableMap::COL_DATE, $date, $comparison);
    }

    /**
     * Filter the query by a related \Player object
     *
     * @param \Player|ObjectCollection $player The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSplitScoreQuery The current query, for fluid interface
     */
    public function filterByPlayer($player, $comparison = null)
    {
        if ($player instanceof \Player) {
            return $this
                ->addUsingAlias(SplitScoreTableMap::COL_PLAYERID, $player->getId(), $comparison);
        } elseif ($player instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SplitScoreTableMap::COL_PLAYERID, $player->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPlayer() only accepts arguments of type \Player or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Player relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSplitScoreQuery The current query, for fluid interface
     */
    public function joinPlayer($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Player');

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
            $this->addJoinObject($join, 'Player');
        }

        return $this;
    }

    /**
     * Use the Player relation Player object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PlayerQuery A secondary query class using the current class as primary query
     */
    public function usePlayerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPlayer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Player', '\PlayerQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSplitScore $splitScore Object to remove from the list of results
     *
     * @return $this|ChildSplitScoreQuery The current query, for fluid interface
     */
    public function prune($splitScore = null)
    {
        if ($splitScore) {
            $this->addUsingAlias(SplitScoreTableMap::COL_ID, $splitScore->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the splitScore table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SplitScoreTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SplitScoreTableMap::clearInstancePool();
            SplitScoreTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SplitScoreTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SplitScoreTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SplitScoreTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SplitScoreTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SplitScoreQuery
