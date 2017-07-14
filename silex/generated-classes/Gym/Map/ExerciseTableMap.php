<?php

namespace Gym\Map;

use Gym\Exercise;
use Gym\ExerciseQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'exercise' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ExerciseTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Gym.Map.ExerciseTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'gym';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'exercise';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Gym\\Exercise';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Gym.Exercise';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 13;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 13;

    /**
     * the column name for the id field
     */
    const COL_ID = 'exercise.id';

    /**
     * the column name for the ex_name_id field
     */
    const COL_EX_NAME_ID = 'exercise.ex_name_id';

    /**
     * the column name for the ex_name_s2_id field
     */
    const COL_EX_NAME_S2_ID = 'exercise.ex_name_s2_id';

    /**
     * the column name for the ex_name_s3_id field
     */
    const COL_EX_NAME_S3_ID = 'exercise.ex_name_s3_id';

    /**
     * the column name for the day field
     */
    const COL_DAY = 'exercise.day';

    /**
     * the column name for the kind field
     */
    const COL_KIND = 'exercise.kind';

    /**
     * the column name for the serie field
     */
    const COL_SERIE = 'exercise.serie';

    /**
     * the column name for the repetition field
     */
    const COL_REPETITION = 'exercise.repetition';

    /**
     * the column name for the difficulty field
     */
    const COL_DIFFICULTY = 'exercise.difficulty';

    /**
     * the column name for the exec_weights field
     */
    const COL_EXEC_WEIGHTS = 'exercise.exec_weights';

    /**
     * the column name for the exec_times field
     */
    const COL_EXEC_TIMES = 'exercise.exec_times';

    /**
     * the column name for the pause_times field
     */
    const COL_PAUSE_TIMES = 'exercise.pause_times';

    /**
     * the column name for the schedule_id field
     */
    const COL_SCHEDULE_ID = 'exercise.schedule_id';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /** The enumerated values for the day field */
    const COL_DAY_1 = '1';
    const COL_DAY_2 = '2';
    const COL_DAY_3 = '3';
    const COL_DAY_4 = '4';
    const COL_DAY_5 = '5';
    const COL_DAY_TUTTI = 'Tutti';

    /** The enumerated values for the kind field */
    const COL_KIND_NORMALE = 'Normale';
    const COL_KIND_SUPERSERIE = 'Superserie';
    const COL_KIND_PIRAMIDALE = 'Piramidale';

    /** The enumerated values for the serie field */
    const COL_SERIE_1 = '1';
    const COL_SERIE_2 = '2';
    const COL_SERIE_3 = '3';
    const COL_SERIE_4 = '4';
    const COL_SERIE_5 = '5';
    const COL_SERIE_6 = '6';
    const COL_SERIE_7 = '7';
    const COL_SERIE_8 = '8';
    const COL_SERIE_9 = '9';
    const COL_SERIE_10 = '10';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'ExNameId', 'ExNameS2Id', 'ExNameS3Id', 'Day', 'Kind', 'Serie', 'Repetition', 'Difficulty', 'ExecWeights', 'ExecTimes', 'PauseTimes', 'ScheduleId', ),
        self::TYPE_CAMELNAME     => array('id', 'exNameId', 'exNameS2Id', 'exNameS3Id', 'day', 'kind', 'serie', 'repetition', 'difficulty', 'execWeights', 'execTimes', 'pauseTimes', 'scheduleId', ),
        self::TYPE_COLNAME       => array(ExerciseTableMap::COL_ID, ExerciseTableMap::COL_EX_NAME_ID, ExerciseTableMap::COL_EX_NAME_S2_ID, ExerciseTableMap::COL_EX_NAME_S3_ID, ExerciseTableMap::COL_DAY, ExerciseTableMap::COL_KIND, ExerciseTableMap::COL_SERIE, ExerciseTableMap::COL_REPETITION, ExerciseTableMap::COL_DIFFICULTY, ExerciseTableMap::COL_EXEC_WEIGHTS, ExerciseTableMap::COL_EXEC_TIMES, ExerciseTableMap::COL_PAUSE_TIMES, ExerciseTableMap::COL_SCHEDULE_ID, ),
        self::TYPE_FIELDNAME     => array('id', 'ex_name_id', 'ex_name_s2_id', 'ex_name_s3_id', 'day', 'kind', 'serie', 'repetition', 'difficulty', 'exec_weights', 'exec_times', 'pause_times', 'schedule_id', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ExNameId' => 1, 'ExNameS2Id' => 2, 'ExNameS3Id' => 3, 'Day' => 4, 'Kind' => 5, 'Serie' => 6, 'Repetition' => 7, 'Difficulty' => 8, 'ExecWeights' => 9, 'ExecTimes' => 10, 'PauseTimes' => 11, 'ScheduleId' => 12, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'exNameId' => 1, 'exNameS2Id' => 2, 'exNameS3Id' => 3, 'day' => 4, 'kind' => 5, 'serie' => 6, 'repetition' => 7, 'difficulty' => 8, 'execWeights' => 9, 'execTimes' => 10, 'pauseTimes' => 11, 'scheduleId' => 12, ),
        self::TYPE_COLNAME       => array(ExerciseTableMap::COL_ID => 0, ExerciseTableMap::COL_EX_NAME_ID => 1, ExerciseTableMap::COL_EX_NAME_S2_ID => 2, ExerciseTableMap::COL_EX_NAME_S3_ID => 3, ExerciseTableMap::COL_DAY => 4, ExerciseTableMap::COL_KIND => 5, ExerciseTableMap::COL_SERIE => 6, ExerciseTableMap::COL_REPETITION => 7, ExerciseTableMap::COL_DIFFICULTY => 8, ExerciseTableMap::COL_EXEC_WEIGHTS => 9, ExerciseTableMap::COL_EXEC_TIMES => 10, ExerciseTableMap::COL_PAUSE_TIMES => 11, ExerciseTableMap::COL_SCHEDULE_ID => 12, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'ex_name_id' => 1, 'ex_name_s2_id' => 2, 'ex_name_s3_id' => 3, 'day' => 4, 'kind' => 5, 'serie' => 6, 'repetition' => 7, 'difficulty' => 8, 'exec_weights' => 9, 'exec_times' => 10, 'pause_times' => 11, 'schedule_id' => 12, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
                ExerciseTableMap::COL_DAY => array(
                            self::COL_DAY_1,
            self::COL_DAY_2,
            self::COL_DAY_3,
            self::COL_DAY_4,
            self::COL_DAY_5,
            self::COL_DAY_TUTTI,
        ),
                ExerciseTableMap::COL_KIND => array(
                            self::COL_KIND_NORMALE,
            self::COL_KIND_SUPERSERIE,
            self::COL_KIND_PIRAMIDALE,
        ),
                ExerciseTableMap::COL_SERIE => array(
                            self::COL_SERIE_1,
            self::COL_SERIE_2,
            self::COL_SERIE_3,
            self::COL_SERIE_4,
            self::COL_SERIE_5,
            self::COL_SERIE_6,
            self::COL_SERIE_7,
            self::COL_SERIE_8,
            self::COL_SERIE_9,
            self::COL_SERIE_10,
        ),
    );

    /**
     * Gets the list of values for all ENUM and SET columns
     * @return array
     */
    public static function getValueSets()
    {
      return static::$enumValueSets;
    }

    /**
     * Gets the list of values for an ENUM or SET column
     * @param string $colname
     * @return array list of possible values for the column
     */
    public static function getValueSet($colname)
    {
        $valueSets = self::getValueSets();

        return $valueSets[$colname];
    }

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('exercise');
        $this->setPhpName('Exercise');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\Gym\\Exercise');
        $this->setPackage('Gym');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('ex_name_id', 'ExNameId', 'INTEGER', 'exercise_name', 'id', true, null, null);
        $this->addForeignKey('ex_name_s2_id', 'ExNameS2Id', 'INTEGER', 'exercise_name', 'id', false, null, null);
        $this->addForeignKey('ex_name_s3_id', 'ExNameS3Id', 'INTEGER', 'exercise_name', 'id', false, null, null);
        $this->addColumn('day', 'Day', 'ENUM', true, null, null);
        $this->getColumn('day')->setValueSet(array (
  0 => '1',
  1 => '2',
  2 => '3',
  3 => '4',
  4 => '5',
  5 => 'Tutti',
));
        $this->addColumn('kind', 'Kind', 'ENUM', true, null, null);
        $this->getColumn('kind')->setValueSet(array (
  0 => 'Normale',
  1 => 'Superserie',
  2 => 'Piramidale',
));
        $this->addColumn('serie', 'Serie', 'ENUM', true, null, null);
        $this->getColumn('serie')->setValueSet(array (
  0 => '1',
  1 => '2',
  2 => '3',
  3 => '4',
  4 => '5',
  5 => '6',
  6 => '7',
  7 => '8',
  8 => '9',
  9 => '10',
));
        $this->addColumn('repetition', 'Repetition', 'VARCHAR', true, 30, null);
        $this->addColumn('difficulty', 'Difficulty', 'INTEGER', true, 1, 3);
        $this->addColumn('exec_weights', 'ExecWeights', 'VARCHAR', false, 90, null);
        $this->addColumn('exec_times', 'ExecTimes', 'VARCHAR', false, 90, null);
        $this->addColumn('pause_times', 'PauseTimes', 'VARCHAR', false, 90, null);
        $this->addForeignKey('schedule_id', 'ScheduleId', 'INTEGER', 'schedule', 'id', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('ex_name_id', '\\Gym\\ExerciseName', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':ex_name_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('ex_name_s2_id', '\\Gym\\ExerciseName', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':ex_name_s2_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('ex_name_s3_id', '\\Gym\\ExerciseName', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':ex_name_s3_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Schedule', '\\Gym\\Schedule', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':schedule_id',
    1 => ':id',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? ExerciseTableMap::CLASS_DEFAULT : ExerciseTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Exercise object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ExerciseTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ExerciseTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ExerciseTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ExerciseTableMap::OM_CLASS;
            /** @var Exercise $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ExerciseTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = ExerciseTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ExerciseTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Exercise $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ExerciseTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(ExerciseTableMap::COL_ID);
            $criteria->addSelectColumn(ExerciseTableMap::COL_EX_NAME_ID);
            $criteria->addSelectColumn(ExerciseTableMap::COL_EX_NAME_S2_ID);
            $criteria->addSelectColumn(ExerciseTableMap::COL_EX_NAME_S3_ID);
            $criteria->addSelectColumn(ExerciseTableMap::COL_DAY);
            $criteria->addSelectColumn(ExerciseTableMap::COL_KIND);
            $criteria->addSelectColumn(ExerciseTableMap::COL_SERIE);
            $criteria->addSelectColumn(ExerciseTableMap::COL_REPETITION);
            $criteria->addSelectColumn(ExerciseTableMap::COL_DIFFICULTY);
            $criteria->addSelectColumn(ExerciseTableMap::COL_EXEC_WEIGHTS);
            $criteria->addSelectColumn(ExerciseTableMap::COL_EXEC_TIMES);
            $criteria->addSelectColumn(ExerciseTableMap::COL_PAUSE_TIMES);
            $criteria->addSelectColumn(ExerciseTableMap::COL_SCHEDULE_ID);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.ex_name_id');
            $criteria->addSelectColumn($alias . '.ex_name_s2_id');
            $criteria->addSelectColumn($alias . '.ex_name_s3_id');
            $criteria->addSelectColumn($alias . '.day');
            $criteria->addSelectColumn($alias . '.kind');
            $criteria->addSelectColumn($alias . '.serie');
            $criteria->addSelectColumn($alias . '.repetition');
            $criteria->addSelectColumn($alias . '.difficulty');
            $criteria->addSelectColumn($alias . '.exec_weights');
            $criteria->addSelectColumn($alias . '.exec_times');
            $criteria->addSelectColumn($alias . '.pause_times');
            $criteria->addSelectColumn($alias . '.schedule_id');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(ExerciseTableMap::DATABASE_NAME)->getTable(ExerciseTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ExerciseTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ExerciseTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ExerciseTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Exercise or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Exercise object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ExerciseTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Gym\Exercise) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ExerciseTableMap::DATABASE_NAME);
            $criteria->add(ExerciseTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = ExerciseQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ExerciseTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ExerciseTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the exercise table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ExerciseQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Exercise or Criteria object.
     *
     * @param mixed               $criteria Criteria or Exercise object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ExerciseTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Exercise object
        }

        if ($criteria->containsKey(ExerciseTableMap::COL_ID) && $criteria->keyContainsValue(ExerciseTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ExerciseTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = ExerciseQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ExerciseTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ExerciseTableMap::buildTableMap();
