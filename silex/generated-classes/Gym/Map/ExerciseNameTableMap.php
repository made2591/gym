<?php

namespace Gym\Map;

use Gym\ExerciseName;
use Gym\ExerciseNameQuery;
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
 * This class defines the structure of the 'exercise_name' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ExerciseNameTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Gym.Map.ExerciseNameTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'gym';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'exercise_name';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Gym\\ExerciseName';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Gym.ExerciseName';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 3;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 3;

    /**
     * the column name for the id field
     */
    const COL_ID = 'exercise_name.id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'exercise_name.name';

    /**
     * the column name for the muscle_group field
     */
    const COL_MUSCLE_GROUP = 'exercise_name.muscle_group';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /** The enumerated values for the muscle_group field */
    const COL_MUSCLE_GROUP_GAMBE = 'Gambe';
    const COL_MUSCLE_GROUP_POLPACCI = 'Polpacci';
    const COL_MUSCLE_GROUP_ADDOME = 'Addome';
    const COL_MUSCLE_GROUP_BICIPITI = 'Bicipiti';
    const COL_MUSCLE_GROUP_TRICIPITI = 'Tricipiti';
    const COL_MUSCLE_GROUP_DORSALI = 'Dorsali';
    const COL_MUSCLE_GROUP_PETTORALI = 'Pettorali';
    const COL_MUSCLE_GROUP_CARDIO = 'Cardio';
    const COL_MUSCLE_GROUP_SPALLE = 'Spalle';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Name', 'MuscleGroup', ),
        self::TYPE_CAMELNAME     => array('id', 'name', 'muscleGroup', ),
        self::TYPE_COLNAME       => array(ExerciseNameTableMap::COL_ID, ExerciseNameTableMap::COL_NAME, ExerciseNameTableMap::COL_MUSCLE_GROUP, ),
        self::TYPE_FIELDNAME     => array('id', 'name', 'muscle_group', ),
        self::TYPE_NUM           => array(0, 1, 2, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'MuscleGroup' => 2, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'name' => 1, 'muscleGroup' => 2, ),
        self::TYPE_COLNAME       => array(ExerciseNameTableMap::COL_ID => 0, ExerciseNameTableMap::COL_NAME => 1, ExerciseNameTableMap::COL_MUSCLE_GROUP => 2, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'name' => 1, 'muscle_group' => 2, ),
        self::TYPE_NUM           => array(0, 1, 2, )
    );

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
                ExerciseNameTableMap::COL_MUSCLE_GROUP => array(
                            self::COL_MUSCLE_GROUP_GAMBE,
            self::COL_MUSCLE_GROUP_POLPACCI,
            self::COL_MUSCLE_GROUP_ADDOME,
            self::COL_MUSCLE_GROUP_BICIPITI,
            self::COL_MUSCLE_GROUP_TRICIPITI,
            self::COL_MUSCLE_GROUP_DORSALI,
            self::COL_MUSCLE_GROUP_PETTORALI,
            self::COL_MUSCLE_GROUP_CARDIO,
            self::COL_MUSCLE_GROUP_SPALLE,
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
        $this->setName('exercise_name');
        $this->setPhpName('ExerciseName');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\Gym\\ExerciseName');
        $this->setPackage('Gym');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('muscle_group', 'MuscleGroup', 'ENUM', true, null, null);
        $this->getColumn('muscle_group')->setValueSet(array (
  0 => 'Gambe',
  1 => 'Polpacci',
  2 => 'Addome',
  3 => 'Bicipiti',
  4 => 'Tricipiti',
  5 => 'Dorsali',
  6 => 'Pettorali',
  7 => 'Cardio',
  8 => 'Spalle',
));
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('ExerciseRelatedByExNameId', '\\Gym\\Exercise', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':ex_name_id',
    1 => ':id',
  ),
), null, null, 'ExercisesRelatedByExNameId', false);
        $this->addRelation('ExerciseRelatedByExNameS2Id', '\\Gym\\Exercise', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':ex_name_s2_id',
    1 => ':id',
  ),
), null, null, 'ExercisesRelatedByExNameS2Id', false);
        $this->addRelation('ExerciseRelatedByExNameS3Id', '\\Gym\\Exercise', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':ex_name_s3_id',
    1 => ':id',
  ),
), null, null, 'ExercisesRelatedByExNameS3Id', false);
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
        return $withPrefix ? ExerciseNameTableMap::CLASS_DEFAULT : ExerciseNameTableMap::OM_CLASS;
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
     * @return array           (ExerciseName object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ExerciseNameTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ExerciseNameTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ExerciseNameTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ExerciseNameTableMap::OM_CLASS;
            /** @var ExerciseName $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ExerciseNameTableMap::addInstanceToPool($obj, $key);
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
            $key = ExerciseNameTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ExerciseNameTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var ExerciseName $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ExerciseNameTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ExerciseNameTableMap::COL_ID);
            $criteria->addSelectColumn(ExerciseNameTableMap::COL_NAME);
            $criteria->addSelectColumn(ExerciseNameTableMap::COL_MUSCLE_GROUP);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.muscle_group');
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
        return Propel::getServiceContainer()->getDatabaseMap(ExerciseNameTableMap::DATABASE_NAME)->getTable(ExerciseNameTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ExerciseNameTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ExerciseNameTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ExerciseNameTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a ExerciseName or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ExerciseName object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ExerciseNameTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Gym\ExerciseName) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ExerciseNameTableMap::DATABASE_NAME);
            $criteria->add(ExerciseNameTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = ExerciseNameQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ExerciseNameTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ExerciseNameTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the exercise_name table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ExerciseNameQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ExerciseName or Criteria object.
     *
     * @param mixed               $criteria Criteria or ExerciseName object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ExerciseNameTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ExerciseName object
        }

        if ($criteria->containsKey(ExerciseNameTableMap::COL_ID) && $criteria->keyContainsValue(ExerciseNameTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ExerciseNameTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = ExerciseNameQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ExerciseNameTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ExerciseNameTableMap::buildTableMap();
