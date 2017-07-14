<?php

namespace Gym\Base;

use \Exception;
use \PDO;
use Gym\Exercise as ChildExercise;
use Gym\ExerciseQuery as ChildExerciseQuery;
use Gym\Map\ExerciseTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'exercise' table.
 *
 *
 *
 * @method     ChildExerciseQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildExerciseQuery orderByExNameId($order = Criteria::ASC) Order by the ex_name_id column
 * @method     ChildExerciseQuery orderByExNameS2Id($order = Criteria::ASC) Order by the ex_name_s2_id column
 * @method     ChildExerciseQuery orderByExNameS3Id($order = Criteria::ASC) Order by the ex_name_s3_id column
 * @method     ChildExerciseQuery orderByDay($order = Criteria::ASC) Order by the day column
 * @method     ChildExerciseQuery orderByKind($order = Criteria::ASC) Order by the kind column
 * @method     ChildExerciseQuery orderBySerie($order = Criteria::ASC) Order by the serie column
 * @method     ChildExerciseQuery orderByRepetition($order = Criteria::ASC) Order by the repetition column
 * @method     ChildExerciseQuery orderByDifficulty($order = Criteria::ASC) Order by the difficulty column
 * @method     ChildExerciseQuery orderByExecWeights($order = Criteria::ASC) Order by the exec_weights column
 * @method     ChildExerciseQuery orderByExecTimes($order = Criteria::ASC) Order by the exec_times column
 * @method     ChildExerciseQuery orderByPauseTimes($order = Criteria::ASC) Order by the pause_times column
 * @method     ChildExerciseQuery orderByScheduleId($order = Criteria::ASC) Order by the schedule_id column
 *
 * @method     ChildExerciseQuery groupById() Group by the id column
 * @method     ChildExerciseQuery groupByExNameId() Group by the ex_name_id column
 * @method     ChildExerciseQuery groupByExNameS2Id() Group by the ex_name_s2_id column
 * @method     ChildExerciseQuery groupByExNameS3Id() Group by the ex_name_s3_id column
 * @method     ChildExerciseQuery groupByDay() Group by the day column
 * @method     ChildExerciseQuery groupByKind() Group by the kind column
 * @method     ChildExerciseQuery groupBySerie() Group by the serie column
 * @method     ChildExerciseQuery groupByRepetition() Group by the repetition column
 * @method     ChildExerciseQuery groupByDifficulty() Group by the difficulty column
 * @method     ChildExerciseQuery groupByExecWeights() Group by the exec_weights column
 * @method     ChildExerciseQuery groupByExecTimes() Group by the exec_times column
 * @method     ChildExerciseQuery groupByPauseTimes() Group by the pause_times column
 * @method     ChildExerciseQuery groupByScheduleId() Group by the schedule_id column
 *
 * @method     ChildExerciseQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildExerciseQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildExerciseQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildExerciseQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildExerciseQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildExerciseQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildExerciseQuery leftJoinex_name_id($relationAlias = null) Adds a LEFT JOIN clause to the query using the ex_name_id relation
 * @method     ChildExerciseQuery rightJoinex_name_id($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ex_name_id relation
 * @method     ChildExerciseQuery innerJoinex_name_id($relationAlias = null) Adds a INNER JOIN clause to the query using the ex_name_id relation
 *
 * @method     ChildExerciseQuery joinWithex_name_id($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ex_name_id relation
 *
 * @method     ChildExerciseQuery leftJoinWithex_name_id() Adds a LEFT JOIN clause and with to the query using the ex_name_id relation
 * @method     ChildExerciseQuery rightJoinWithex_name_id() Adds a RIGHT JOIN clause and with to the query using the ex_name_id relation
 * @method     ChildExerciseQuery innerJoinWithex_name_id() Adds a INNER JOIN clause and with to the query using the ex_name_id relation
 *
 * @method     ChildExerciseQuery leftJoinex_name_s2_id($relationAlias = null) Adds a LEFT JOIN clause to the query using the ex_name_s2_id relation
 * @method     ChildExerciseQuery rightJoinex_name_s2_id($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ex_name_s2_id relation
 * @method     ChildExerciseQuery innerJoinex_name_s2_id($relationAlias = null) Adds a INNER JOIN clause to the query using the ex_name_s2_id relation
 *
 * @method     ChildExerciseQuery joinWithex_name_s2_id($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ex_name_s2_id relation
 *
 * @method     ChildExerciseQuery leftJoinWithex_name_s2_id() Adds a LEFT JOIN clause and with to the query using the ex_name_s2_id relation
 * @method     ChildExerciseQuery rightJoinWithex_name_s2_id() Adds a RIGHT JOIN clause and with to the query using the ex_name_s2_id relation
 * @method     ChildExerciseQuery innerJoinWithex_name_s2_id() Adds a INNER JOIN clause and with to the query using the ex_name_s2_id relation
 *
 * @method     ChildExerciseQuery leftJoinex_name_s3_id($relationAlias = null) Adds a LEFT JOIN clause to the query using the ex_name_s3_id relation
 * @method     ChildExerciseQuery rightJoinex_name_s3_id($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ex_name_s3_id relation
 * @method     ChildExerciseQuery innerJoinex_name_s3_id($relationAlias = null) Adds a INNER JOIN clause to the query using the ex_name_s3_id relation
 *
 * @method     ChildExerciseQuery joinWithex_name_s3_id($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ex_name_s3_id relation
 *
 * @method     ChildExerciseQuery leftJoinWithex_name_s3_id() Adds a LEFT JOIN clause and with to the query using the ex_name_s3_id relation
 * @method     ChildExerciseQuery rightJoinWithex_name_s3_id() Adds a RIGHT JOIN clause and with to the query using the ex_name_s3_id relation
 * @method     ChildExerciseQuery innerJoinWithex_name_s3_id() Adds a INNER JOIN clause and with to the query using the ex_name_s3_id relation
 *
 * @method     ChildExerciseQuery leftJoinSchedule($relationAlias = null) Adds a LEFT JOIN clause to the query using the Schedule relation
 * @method     ChildExerciseQuery rightJoinSchedule($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Schedule relation
 * @method     ChildExerciseQuery innerJoinSchedule($relationAlias = null) Adds a INNER JOIN clause to the query using the Schedule relation
 *
 * @method     ChildExerciseQuery joinWithSchedule($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Schedule relation
 *
 * @method     ChildExerciseQuery leftJoinWithSchedule() Adds a LEFT JOIN clause and with to the query using the Schedule relation
 * @method     ChildExerciseQuery rightJoinWithSchedule() Adds a RIGHT JOIN clause and with to the query using the Schedule relation
 * @method     ChildExerciseQuery innerJoinWithSchedule() Adds a INNER JOIN clause and with to the query using the Schedule relation
 *
 * @method     \Gym\ExerciseNameQuery|\Gym\ScheduleQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildExercise findOne(ConnectionInterface $con = null) Return the first ChildExercise matching the query
 * @method     ChildExercise findOneOrCreate(ConnectionInterface $con = null) Return the first ChildExercise matching the query, or a new ChildExercise object populated from the query conditions when no match is found
 *
 * @method     ChildExercise findOneById(int $id) Return the first ChildExercise filtered by the id column
 * @method     ChildExercise findOneByExNameId(int $ex_name_id) Return the first ChildExercise filtered by the ex_name_id column
 * @method     ChildExercise findOneByExNameS2Id(int $ex_name_s2_id) Return the first ChildExercise filtered by the ex_name_s2_id column
 * @method     ChildExercise findOneByExNameS3Id(int $ex_name_s3_id) Return the first ChildExercise filtered by the ex_name_s3_id column
 * @method     ChildExercise findOneByDay(int $day) Return the first ChildExercise filtered by the day column
 * @method     ChildExercise findOneByKind(int $kind) Return the first ChildExercise filtered by the kind column
 * @method     ChildExercise findOneBySerie(int $serie) Return the first ChildExercise filtered by the serie column
 * @method     ChildExercise findOneByRepetition(string $repetition) Return the first ChildExercise filtered by the repetition column
 * @method     ChildExercise findOneByDifficulty(int $difficulty) Return the first ChildExercise filtered by the difficulty column
 * @method     ChildExercise findOneByExecWeights(string $exec_weights) Return the first ChildExercise filtered by the exec_weights column
 * @method     ChildExercise findOneByExecTimes(string $exec_times) Return the first ChildExercise filtered by the exec_times column
 * @method     ChildExercise findOneByPauseTimes(string $pause_times) Return the first ChildExercise filtered by the pause_times column
 * @method     ChildExercise findOneByScheduleId(int $schedule_id) Return the first ChildExercise filtered by the schedule_id column *

 * @method     ChildExercise requirePk($key, ConnectionInterface $con = null) Return the ChildExercise by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExercise requireOne(ConnectionInterface $con = null) Return the first ChildExercise matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildExercise requireOneById(int $id) Return the first ChildExercise filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExercise requireOneByExNameId(int $ex_name_id) Return the first ChildExercise filtered by the ex_name_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExercise requireOneByExNameS2Id(int $ex_name_s2_id) Return the first ChildExercise filtered by the ex_name_s2_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExercise requireOneByExNameS3Id(int $ex_name_s3_id) Return the first ChildExercise filtered by the ex_name_s3_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExercise requireOneByDay(int $day) Return the first ChildExercise filtered by the day column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExercise requireOneByKind(int $kind) Return the first ChildExercise filtered by the kind column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExercise requireOneBySerie(int $serie) Return the first ChildExercise filtered by the serie column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExercise requireOneByRepetition(string $repetition) Return the first ChildExercise filtered by the repetition column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExercise requireOneByDifficulty(int $difficulty) Return the first ChildExercise filtered by the difficulty column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExercise requireOneByExecWeights(string $exec_weights) Return the first ChildExercise filtered by the exec_weights column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExercise requireOneByExecTimes(string $exec_times) Return the first ChildExercise filtered by the exec_times column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExercise requireOneByPauseTimes(string $pause_times) Return the first ChildExercise filtered by the pause_times column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExercise requireOneByScheduleId(int $schedule_id) Return the first ChildExercise filtered by the schedule_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildExercise[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildExercise objects based on current ModelCriteria
 * @method     ChildExercise[]|ObjectCollection findById(int $id) Return ChildExercise objects filtered by the id column
 * @method     ChildExercise[]|ObjectCollection findByExNameId(int $ex_name_id) Return ChildExercise objects filtered by the ex_name_id column
 * @method     ChildExercise[]|ObjectCollection findByExNameS2Id(int $ex_name_s2_id) Return ChildExercise objects filtered by the ex_name_s2_id column
 * @method     ChildExercise[]|ObjectCollection findByExNameS3Id(int $ex_name_s3_id) Return ChildExercise objects filtered by the ex_name_s3_id column
 * @method     ChildExercise[]|ObjectCollection findByDay(int $day) Return ChildExercise objects filtered by the day column
 * @method     ChildExercise[]|ObjectCollection findByKind(int $kind) Return ChildExercise objects filtered by the kind column
 * @method     ChildExercise[]|ObjectCollection findBySerie(int $serie) Return ChildExercise objects filtered by the serie column
 * @method     ChildExercise[]|ObjectCollection findByRepetition(string $repetition) Return ChildExercise objects filtered by the repetition column
 * @method     ChildExercise[]|ObjectCollection findByDifficulty(int $difficulty) Return ChildExercise objects filtered by the difficulty column
 * @method     ChildExercise[]|ObjectCollection findByExecWeights(string $exec_weights) Return ChildExercise objects filtered by the exec_weights column
 * @method     ChildExercise[]|ObjectCollection findByExecTimes(string $exec_times) Return ChildExercise objects filtered by the exec_times column
 * @method     ChildExercise[]|ObjectCollection findByPauseTimes(string $pause_times) Return ChildExercise objects filtered by the pause_times column
 * @method     ChildExercise[]|ObjectCollection findByScheduleId(int $schedule_id) Return ChildExercise objects filtered by the schedule_id column
 * @method     ChildExercise[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ExerciseQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Gym\Base\ExerciseQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'gym', $modelName = '\\Gym\\Exercise', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildExerciseQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildExerciseQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildExerciseQuery) {
            return $criteria;
        }
        $query = new ChildExerciseQuery();
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
     * @return ChildExercise|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ExerciseTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ExerciseTableMap::DATABASE_NAME);
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
     * @return ChildExercise A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `ex_name_id`, `ex_name_s2_id`, `ex_name_s3_id`, `day`, `kind`, `serie`, `repetition`, `difficulty`, `exec_weights`, `exec_times`, `pause_times`, `schedule_id` FROM `exercise` WHERE `id` = :p0';
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
            /** @var ChildExercise $obj */
            $obj = new ChildExercise();
            $obj->hydrate($row);
            ExerciseTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildExercise|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildExerciseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ExerciseTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildExerciseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ExerciseTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildExerciseQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ExerciseTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ExerciseTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExerciseTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the ex_name_id column
     *
     * Example usage:
     * <code>
     * $query->filterByExNameId(1234); // WHERE ex_name_id = 1234
     * $query->filterByExNameId(array(12, 34)); // WHERE ex_name_id IN (12, 34)
     * $query->filterByExNameId(array('min' => 12)); // WHERE ex_name_id > 12
     * </code>
     *
     * @see       filterByex_name_id()
     *
     * @param     mixed $exNameId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExerciseQuery The current query, for fluid interface
     */
    public function filterByExNameId($exNameId = null, $comparison = null)
    {
        if (is_array($exNameId)) {
            $useMinMax = false;
            if (isset($exNameId['min'])) {
                $this->addUsingAlias(ExerciseTableMap::COL_EX_NAME_ID, $exNameId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($exNameId['max'])) {
                $this->addUsingAlias(ExerciseTableMap::COL_EX_NAME_ID, $exNameId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExerciseTableMap::COL_EX_NAME_ID, $exNameId, $comparison);
    }

    /**
     * Filter the query on the ex_name_s2_id column
     *
     * Example usage:
     * <code>
     * $query->filterByExNameS2Id(1234); // WHERE ex_name_s2_id = 1234
     * $query->filterByExNameS2Id(array(12, 34)); // WHERE ex_name_s2_id IN (12, 34)
     * $query->filterByExNameS2Id(array('min' => 12)); // WHERE ex_name_s2_id > 12
     * </code>
     *
     * @see       filterByex_name_s2_id()
     *
     * @param     mixed $exNameS2Id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExerciseQuery The current query, for fluid interface
     */
    public function filterByExNameS2Id($exNameS2Id = null, $comparison = null)
    {
        if (is_array($exNameS2Id)) {
            $useMinMax = false;
            if (isset($exNameS2Id['min'])) {
                $this->addUsingAlias(ExerciseTableMap::COL_EX_NAME_S2_ID, $exNameS2Id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($exNameS2Id['max'])) {
                $this->addUsingAlias(ExerciseTableMap::COL_EX_NAME_S2_ID, $exNameS2Id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExerciseTableMap::COL_EX_NAME_S2_ID, $exNameS2Id, $comparison);
    }

    /**
     * Filter the query on the ex_name_s3_id column
     *
     * Example usage:
     * <code>
     * $query->filterByExNameS3Id(1234); // WHERE ex_name_s3_id = 1234
     * $query->filterByExNameS3Id(array(12, 34)); // WHERE ex_name_s3_id IN (12, 34)
     * $query->filterByExNameS3Id(array('min' => 12)); // WHERE ex_name_s3_id > 12
     * </code>
     *
     * @see       filterByex_name_s3_id()
     *
     * @param     mixed $exNameS3Id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExerciseQuery The current query, for fluid interface
     */
    public function filterByExNameS3Id($exNameS3Id = null, $comparison = null)
    {
        if (is_array($exNameS3Id)) {
            $useMinMax = false;
            if (isset($exNameS3Id['min'])) {
                $this->addUsingAlias(ExerciseTableMap::COL_EX_NAME_S3_ID, $exNameS3Id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($exNameS3Id['max'])) {
                $this->addUsingAlias(ExerciseTableMap::COL_EX_NAME_S3_ID, $exNameS3Id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExerciseTableMap::COL_EX_NAME_S3_ID, $exNameS3Id, $comparison);
    }

    /**
     * Filter the query on the day column
     *
     * @param     mixed $day The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExerciseQuery The current query, for fluid interface
     */
    public function filterByDay($day = null, $comparison = null)
    {
        $valueSet = ExerciseTableMap::getValueSet(ExerciseTableMap::COL_DAY);
        if (is_scalar($day)) {
            if (!in_array($day, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $day));
            }
            $day = array_search($day, $valueSet);
        } elseif (is_array($day)) {
            $convertedValues = array();
            foreach ($day as $value) {
                if (!in_array($value, $valueSet)) {
                    throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $value));
                }
                $convertedValues []= array_search($value, $valueSet);
            }
            $day = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExerciseTableMap::COL_DAY, $day, $comparison);
    }

    /**
     * Filter the query on the kind column
     *
     * @param     mixed $kind The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExerciseQuery The current query, for fluid interface
     */
    public function filterByKind($kind = null, $comparison = null)
    {
        $valueSet = ExerciseTableMap::getValueSet(ExerciseTableMap::COL_KIND);
        if (is_scalar($kind)) {
            if (!in_array($kind, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $kind));
            }
            $kind = array_search($kind, $valueSet);
        } elseif (is_array($kind)) {
            $convertedValues = array();
            foreach ($kind as $value) {
                if (!in_array($value, $valueSet)) {
                    throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $value));
                }
                $convertedValues []= array_search($value, $valueSet);
            }
            $kind = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExerciseTableMap::COL_KIND, $kind, $comparison);
    }

    /**
     * Filter the query on the serie column
     *
     * @param     mixed $serie The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExerciseQuery The current query, for fluid interface
     */
    public function filterBySerie($serie = null, $comparison = null)
    {
        $valueSet = ExerciseTableMap::getValueSet(ExerciseTableMap::COL_SERIE);
        if (is_scalar($serie)) {
            if (!in_array($serie, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $serie));
            }
            $serie = array_search($serie, $valueSet);
        } elseif (is_array($serie)) {
            $convertedValues = array();
            foreach ($serie as $value) {
                if (!in_array($value, $valueSet)) {
                    throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $value));
                }
                $convertedValues []= array_search($value, $valueSet);
            }
            $serie = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExerciseTableMap::COL_SERIE, $serie, $comparison);
    }

    /**
     * Filter the query on the repetition column
     *
     * Example usage:
     * <code>
     * $query->filterByRepetition('fooValue');   // WHERE repetition = 'fooValue'
     * $query->filterByRepetition('%fooValue%'); // WHERE repetition LIKE '%fooValue%'
     * </code>
     *
     * @param     string $repetition The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExerciseQuery The current query, for fluid interface
     */
    public function filterByRepetition($repetition = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($repetition)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $repetition)) {
                $repetition = str_replace('*', '%', $repetition);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ExerciseTableMap::COL_REPETITION, $repetition, $comparison);
    }

    /**
     * Filter the query on the difficulty column
     *
     * Example usage:
     * <code>
     * $query->filterByDifficulty(1234); // WHERE difficulty = 1234
     * $query->filterByDifficulty(array(12, 34)); // WHERE difficulty IN (12, 34)
     * $query->filterByDifficulty(array('min' => 12)); // WHERE difficulty > 12
     * </code>
     *
     * @param     mixed $difficulty The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExerciseQuery The current query, for fluid interface
     */
    public function filterByDifficulty($difficulty = null, $comparison = null)
    {
        if (is_array($difficulty)) {
            $useMinMax = false;
            if (isset($difficulty['min'])) {
                $this->addUsingAlias(ExerciseTableMap::COL_DIFFICULTY, $difficulty['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($difficulty['max'])) {
                $this->addUsingAlias(ExerciseTableMap::COL_DIFFICULTY, $difficulty['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExerciseTableMap::COL_DIFFICULTY, $difficulty, $comparison);
    }

    /**
     * Filter the query on the exec_weights column
     *
     * Example usage:
     * <code>
     * $query->filterByExecWeights('fooValue');   // WHERE exec_weights = 'fooValue'
     * $query->filterByExecWeights('%fooValue%'); // WHERE exec_weights LIKE '%fooValue%'
     * </code>
     *
     * @param     string $execWeights The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExerciseQuery The current query, for fluid interface
     */
    public function filterByExecWeights($execWeights = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($execWeights)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $execWeights)) {
                $execWeights = str_replace('*', '%', $execWeights);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ExerciseTableMap::COL_EXEC_WEIGHTS, $execWeights, $comparison);
    }

    /**
     * Filter the query on the exec_times column
     *
     * Example usage:
     * <code>
     * $query->filterByExecTimes('fooValue');   // WHERE exec_times = 'fooValue'
     * $query->filterByExecTimes('%fooValue%'); // WHERE exec_times LIKE '%fooValue%'
     * </code>
     *
     * @param     string $execTimes The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExerciseQuery The current query, for fluid interface
     */
    public function filterByExecTimes($execTimes = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($execTimes)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $execTimes)) {
                $execTimes = str_replace('*', '%', $execTimes);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ExerciseTableMap::COL_EXEC_TIMES, $execTimes, $comparison);
    }

    /**
     * Filter the query on the pause_times column
     *
     * Example usage:
     * <code>
     * $query->filterByPauseTimes('fooValue');   // WHERE pause_times = 'fooValue'
     * $query->filterByPauseTimes('%fooValue%'); // WHERE pause_times LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pauseTimes The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExerciseQuery The current query, for fluid interface
     */
    public function filterByPauseTimes($pauseTimes = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pauseTimes)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pauseTimes)) {
                $pauseTimes = str_replace('*', '%', $pauseTimes);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ExerciseTableMap::COL_PAUSE_TIMES, $pauseTimes, $comparison);
    }

    /**
     * Filter the query on the schedule_id column
     *
     * Example usage:
     * <code>
     * $query->filterByScheduleId(1234); // WHERE schedule_id = 1234
     * $query->filterByScheduleId(array(12, 34)); // WHERE schedule_id IN (12, 34)
     * $query->filterByScheduleId(array('min' => 12)); // WHERE schedule_id > 12
     * </code>
     *
     * @see       filterBySchedule()
     *
     * @param     mixed $scheduleId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExerciseQuery The current query, for fluid interface
     */
    public function filterByScheduleId($scheduleId = null, $comparison = null)
    {
        if (is_array($scheduleId)) {
            $useMinMax = false;
            if (isset($scheduleId['min'])) {
                $this->addUsingAlias(ExerciseTableMap::COL_SCHEDULE_ID, $scheduleId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($scheduleId['max'])) {
                $this->addUsingAlias(ExerciseTableMap::COL_SCHEDULE_ID, $scheduleId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExerciseTableMap::COL_SCHEDULE_ID, $scheduleId, $comparison);
    }

    /**
     * Filter the query by a related \Gym\ExerciseName object
     *
     * @param \Gym\ExerciseName|ObjectCollection $exerciseName The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildExerciseQuery The current query, for fluid interface
     */
    public function filterByex_name_id($exerciseName, $comparison = null)
    {
        if ($exerciseName instanceof \Gym\ExerciseName) {
            return $this
                ->addUsingAlias(ExerciseTableMap::COL_EX_NAME_ID, $exerciseName->getId(), $comparison);
        } elseif ($exerciseName instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ExerciseTableMap::COL_EX_NAME_ID, $exerciseName->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByex_name_id() only accepts arguments of type \Gym\ExerciseName or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ex_name_id relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildExerciseQuery The current query, for fluid interface
     */
    public function joinex_name_id($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ex_name_id');

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
            $this->addJoinObject($join, 'ex_name_id');
        }

        return $this;
    }

    /**
     * Use the ex_name_id relation ExerciseName object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Gym\ExerciseNameQuery A secondary query class using the current class as primary query
     */
    public function useex_name_idQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinex_name_id($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ex_name_id', '\Gym\ExerciseNameQuery');
    }

    /**
     * Filter the query by a related \Gym\ExerciseName object
     *
     * @param \Gym\ExerciseName|ObjectCollection $exerciseName The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildExerciseQuery The current query, for fluid interface
     */
    public function filterByex_name_s2_id($exerciseName, $comparison = null)
    {
        if ($exerciseName instanceof \Gym\ExerciseName) {
            return $this
                ->addUsingAlias(ExerciseTableMap::COL_EX_NAME_S2_ID, $exerciseName->getId(), $comparison);
        } elseif ($exerciseName instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ExerciseTableMap::COL_EX_NAME_S2_ID, $exerciseName->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByex_name_s2_id() only accepts arguments of type \Gym\ExerciseName or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ex_name_s2_id relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildExerciseQuery The current query, for fluid interface
     */
    public function joinex_name_s2_id($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ex_name_s2_id');

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
            $this->addJoinObject($join, 'ex_name_s2_id');
        }

        return $this;
    }

    /**
     * Use the ex_name_s2_id relation ExerciseName object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Gym\ExerciseNameQuery A secondary query class using the current class as primary query
     */
    public function useex_name_s2_idQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinex_name_s2_id($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ex_name_s2_id', '\Gym\ExerciseNameQuery');
    }

    /**
     * Filter the query by a related \Gym\ExerciseName object
     *
     * @param \Gym\ExerciseName|ObjectCollection $exerciseName The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildExerciseQuery The current query, for fluid interface
     */
    public function filterByex_name_s3_id($exerciseName, $comparison = null)
    {
        if ($exerciseName instanceof \Gym\ExerciseName) {
            return $this
                ->addUsingAlias(ExerciseTableMap::COL_EX_NAME_S3_ID, $exerciseName->getId(), $comparison);
        } elseif ($exerciseName instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ExerciseTableMap::COL_EX_NAME_S3_ID, $exerciseName->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByex_name_s3_id() only accepts arguments of type \Gym\ExerciseName or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ex_name_s3_id relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildExerciseQuery The current query, for fluid interface
     */
    public function joinex_name_s3_id($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ex_name_s3_id');

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
            $this->addJoinObject($join, 'ex_name_s3_id');
        }

        return $this;
    }

    /**
     * Use the ex_name_s3_id relation ExerciseName object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Gym\ExerciseNameQuery A secondary query class using the current class as primary query
     */
    public function useex_name_s3_idQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinex_name_s3_id($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ex_name_s3_id', '\Gym\ExerciseNameQuery');
    }

    /**
     * Filter the query by a related \Gym\Schedule object
     *
     * @param \Gym\Schedule|ObjectCollection $schedule The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildExerciseQuery The current query, for fluid interface
     */
    public function filterBySchedule($schedule, $comparison = null)
    {
        if ($schedule instanceof \Gym\Schedule) {
            return $this
                ->addUsingAlias(ExerciseTableMap::COL_SCHEDULE_ID, $schedule->getId(), $comparison);
        } elseif ($schedule instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ExerciseTableMap::COL_SCHEDULE_ID, $schedule->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySchedule() only accepts arguments of type \Gym\Schedule or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Schedule relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildExerciseQuery The current query, for fluid interface
     */
    public function joinSchedule($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Schedule');

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
            $this->addJoinObject($join, 'Schedule');
        }

        return $this;
    }

    /**
     * Use the Schedule relation Schedule object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Gym\ScheduleQuery A secondary query class using the current class as primary query
     */
    public function useScheduleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSchedule($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Schedule', '\Gym\ScheduleQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildExercise $exercise Object to remove from the list of results
     *
     * @return $this|ChildExerciseQuery The current query, for fluid interface
     */
    public function prune($exercise = null)
    {
        if ($exercise) {
            $this->addUsingAlias(ExerciseTableMap::COL_ID, $exercise->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the exercise table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ExerciseTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ExerciseTableMap::clearInstancePool();
            ExerciseTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ExerciseTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ExerciseTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ExerciseTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ExerciseTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ExerciseQuery
