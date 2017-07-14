<?php

namespace Gym\Base;

use \Exception;
use \PDO;
use Gym\Schedule as ChildSchedule;
use Gym\ScheduleQuery as ChildScheduleQuery;
use Gym\Map\ScheduleTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'schedule' table.
 *
 *
 *
 * @method     ChildScheduleQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildScheduleQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildScheduleQuery orderByFrom($order = Criteria::ASC) Order by the from column
 * @method     ChildScheduleQuery orderByTo($order = Criteria::ASC) Order by the to column
 *
 * @method     ChildScheduleQuery groupById() Group by the id column
 * @method     ChildScheduleQuery groupByName() Group by the name column
 * @method     ChildScheduleQuery groupByFrom() Group by the from column
 * @method     ChildScheduleQuery groupByTo() Group by the to column
 *
 * @method     ChildScheduleQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildScheduleQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildScheduleQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildScheduleQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildScheduleQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildScheduleQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildScheduleQuery leftJoinExercise($relationAlias = null) Adds a LEFT JOIN clause to the query using the Exercise relation
 * @method     ChildScheduleQuery rightJoinExercise($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Exercise relation
 * @method     ChildScheduleQuery innerJoinExercise($relationAlias = null) Adds a INNER JOIN clause to the query using the Exercise relation
 *
 * @method     ChildScheduleQuery joinWithExercise($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Exercise relation
 *
 * @method     ChildScheduleQuery leftJoinWithExercise() Adds a LEFT JOIN clause and with to the query using the Exercise relation
 * @method     ChildScheduleQuery rightJoinWithExercise() Adds a RIGHT JOIN clause and with to the query using the Exercise relation
 * @method     ChildScheduleQuery innerJoinWithExercise() Adds a INNER JOIN clause and with to the query using the Exercise relation
 *
 * @method     \Gym\ExerciseQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSchedule findOne(ConnectionInterface $con = null) Return the first ChildSchedule matching the query
 * @method     ChildSchedule findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSchedule matching the query, or a new ChildSchedule object populated from the query conditions when no match is found
 *
 * @method     ChildSchedule findOneById(int $id) Return the first ChildSchedule filtered by the id column
 * @method     ChildSchedule findOneByName(string $name) Return the first ChildSchedule filtered by the name column
 * @method     ChildSchedule findOneByFrom(string $from) Return the first ChildSchedule filtered by the from column
 * @method     ChildSchedule findOneByTo(string $to) Return the first ChildSchedule filtered by the to column *

 * @method     ChildSchedule requirePk($key, ConnectionInterface $con = null) Return the ChildSchedule by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSchedule requireOne(ConnectionInterface $con = null) Return the first ChildSchedule matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSchedule requireOneById(int $id) Return the first ChildSchedule filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSchedule requireOneByName(string $name) Return the first ChildSchedule filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSchedule requireOneByFrom(string $from) Return the first ChildSchedule filtered by the from column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSchedule requireOneByTo(string $to) Return the first ChildSchedule filtered by the to column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSchedule[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSchedule objects based on current ModelCriteria
 * @method     ChildSchedule[]|ObjectCollection findById(int $id) Return ChildSchedule objects filtered by the id column
 * @method     ChildSchedule[]|ObjectCollection findByName(string $name) Return ChildSchedule objects filtered by the name column
 * @method     ChildSchedule[]|ObjectCollection findByFrom(string $from) Return ChildSchedule objects filtered by the from column
 * @method     ChildSchedule[]|ObjectCollection findByTo(string $to) Return ChildSchedule objects filtered by the to column
 * @method     ChildSchedule[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ScheduleQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Gym\Base\ScheduleQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'gym', $modelName = '\\Gym\\Schedule', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildScheduleQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildScheduleQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildScheduleQuery) {
            return $criteria;
        }
        $query = new ChildScheduleQuery();
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
     * @return ChildSchedule|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ScheduleTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ScheduleTableMap::DATABASE_NAME);
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
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSchedule A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `name`, `from`, `to` FROM `schedule` WHERE `id` = :p0';
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
            /** @var ChildSchedule $obj */
            $obj = new ChildSchedule();
            $obj->hydrate($row);
            ScheduleTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildSchedule|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ScheduleTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ScheduleTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ScheduleTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ScheduleTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScheduleTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ScheduleTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the from column
     *
     * Example usage:
     * <code>
     * $query->filterByFrom('2011-03-14'); // WHERE from = '2011-03-14'
     * $query->filterByFrom('now'); // WHERE from = '2011-03-14'
     * $query->filterByFrom(array('max' => 'yesterday')); // WHERE from > '2011-03-13'
     * </code>
     *
     * @param     mixed $from The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function filterByFrom($from = null, $comparison = null)
    {
        if (is_array($from)) {
            $useMinMax = false;
            if (isset($from['min'])) {
                $this->addUsingAlias(ScheduleTableMap::COL_FROM, $from['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($from['max'])) {
                $this->addUsingAlias(ScheduleTableMap::COL_FROM, $from['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScheduleTableMap::COL_FROM, $from, $comparison);
    }

    /**
     * Filter the query on the to column
     *
     * Example usage:
     * <code>
     * $query->filterByTo('2011-03-14'); // WHERE to = '2011-03-14'
     * $query->filterByTo('now'); // WHERE to = '2011-03-14'
     * $query->filterByTo(array('max' => 'yesterday')); // WHERE to > '2011-03-13'
     * </code>
     *
     * @param     mixed $to The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function filterByTo($to = null, $comparison = null)
    {
        if (is_array($to)) {
            $useMinMax = false;
            if (isset($to['min'])) {
                $this->addUsingAlias(ScheduleTableMap::COL_TO, $to['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($to['max'])) {
                $this->addUsingAlias(ScheduleTableMap::COL_TO, $to['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScheduleTableMap::COL_TO, $to, $comparison);
    }

    /**
     * Filter the query by a related \Gym\Exercise object
     *
     * @param \Gym\Exercise|ObjectCollection $exercise the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildScheduleQuery The current query, for fluid interface
     */
    public function filterByExercise($exercise, $comparison = null)
    {
        if ($exercise instanceof \Gym\Exercise) {
            return $this
                ->addUsingAlias(ScheduleTableMap::COL_ID, $exercise->getScheduleId(), $comparison);
        } elseif ($exercise instanceof ObjectCollection) {
            return $this
                ->useExerciseQuery()
                ->filterByPrimaryKeys($exercise->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByExercise() only accepts arguments of type \Gym\Exercise or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Exercise relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function joinExercise($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Exercise');

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
            $this->addJoinObject($join, 'Exercise');
        }

        return $this;
    }

    /**
     * Use the Exercise relation Exercise object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Gym\ExerciseQuery A secondary query class using the current class as primary query
     */
    public function useExerciseQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinExercise($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Exercise', '\Gym\ExerciseQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSchedule $schedule Object to remove from the list of results
     *
     * @return $this|ChildScheduleQuery The current query, for fluid interface
     */
    public function prune($schedule = null)
    {
        if ($schedule) {
            $this->addUsingAlias(ScheduleTableMap::COL_ID, $schedule->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the schedule table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ScheduleTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ScheduleTableMap::clearInstancePool();
            ScheduleTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ScheduleTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ScheduleTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ScheduleTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ScheduleTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ScheduleQuery
