<?php

namespace Gym\Base;

use \Exception;
use \PDO;
use Gym\Exercise as ChildExercise;
use Gym\ExerciseName as ChildExerciseName;
use Gym\ExerciseNameQuery as ChildExerciseNameQuery;
use Gym\ExerciseQuery as ChildExerciseQuery;
use Gym\Map\ExerciseNameTableMap;
use Gym\Map\ExerciseTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'exercise_name' table.
 *
 *
 *
* @package    propel.generator.Gym.Base
*/
abstract class ExerciseName implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Gym\\Map\\ExerciseNameTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the muscle_group field.
     *
     * @var        int
     */
    protected $muscle_group;

    /**
     * @var        ObjectCollection|ChildExercise[] Collection to store aggregation of ChildExercise objects.
     */
    protected $collExercisesRelatedByExNameId;
    protected $collExercisesRelatedByExNameIdPartial;

    /**
     * @var        ObjectCollection|ChildExercise[] Collection to store aggregation of ChildExercise objects.
     */
    protected $collExercisesRelatedByExNameS2Id;
    protected $collExercisesRelatedByExNameS2IdPartial;

    /**
     * @var        ObjectCollection|ChildExercise[] Collection to store aggregation of ChildExercise objects.
     */
    protected $collExercisesRelatedByExNameS3Id;
    protected $collExercisesRelatedByExNameS3IdPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildExercise[]
     */
    protected $exercisesRelatedByExNameIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildExercise[]
     */
    protected $exercisesRelatedByExNameS2IdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildExercise[]
     */
    protected $exercisesRelatedByExNameS3IdScheduledForDeletion = null;

    /**
     * Initializes internal state of Gym\Base\ExerciseName object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>ExerciseName</code> instance.  If
     * <code>obj</code> is an instance of <code>ExerciseName</code>, delegates to
     * <code>equals(ExerciseName)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|ExerciseName The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [muscle_group] column value.
     *
     * @return string
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getMuscleGroup()
    {
        if (null === $this->muscle_group) {
            return null;
        }
        $valueSet = ExerciseNameTableMap::getValueSet(ExerciseNameTableMap::COL_MUSCLE_GROUP);
        if (!isset($valueSet[$this->muscle_group])) {
            throw new PropelException('Unknown stored enum key: ' . $this->muscle_group);
        }

        return $valueSet[$this->muscle_group];
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Gym\ExerciseName The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ExerciseNameTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Gym\ExerciseName The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[ExerciseNameTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [muscle_group] column.
     *
     * @param  string $v new value
     * @return $this|\Gym\ExerciseName The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setMuscleGroup($v)
    {
        if ($v !== null) {
            $valueSet = ExerciseNameTableMap::getValueSet(ExerciseNameTableMap::COL_MUSCLE_GROUP);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->muscle_group !== $v) {
            $this->muscle_group = $v;
            $this->modifiedColumns[ExerciseNameTableMap::COL_MUSCLE_GROUP] = true;
        }

        return $this;
    } // setMuscleGroup()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ExerciseNameTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ExerciseNameTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ExerciseNameTableMap::translateFieldName('MuscleGroup', TableMap::TYPE_PHPNAME, $indexType)];
            $this->muscle_group = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = ExerciseNameTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Gym\\ExerciseName'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ExerciseNameTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildExerciseNameQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collExercisesRelatedByExNameId = null;

            $this->collExercisesRelatedByExNameS2Id = null;

            $this->collExercisesRelatedByExNameS3Id = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see ExerciseName::setDeleted()
     * @see ExerciseName::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ExerciseNameTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildExerciseNameQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ExerciseNameTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                ExerciseNameTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->exercisesRelatedByExNameIdScheduledForDeletion !== null) {
                if (!$this->exercisesRelatedByExNameIdScheduledForDeletion->isEmpty()) {
                    \Gym\ExerciseQuery::create()
                        ->filterByPrimaryKeys($this->exercisesRelatedByExNameIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->exercisesRelatedByExNameIdScheduledForDeletion = null;
                }
            }

            if ($this->collExercisesRelatedByExNameId !== null) {
                foreach ($this->collExercisesRelatedByExNameId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->exercisesRelatedByExNameS2IdScheduledForDeletion !== null) {
                if (!$this->exercisesRelatedByExNameS2IdScheduledForDeletion->isEmpty()) {
                    foreach ($this->exercisesRelatedByExNameS2IdScheduledForDeletion as $exerciseRelatedByExNameS2Id) {
                        // need to save related object because we set the relation to null
                        $exerciseRelatedByExNameS2Id->save($con);
                    }
                    $this->exercisesRelatedByExNameS2IdScheduledForDeletion = null;
                }
            }

            if ($this->collExercisesRelatedByExNameS2Id !== null) {
                foreach ($this->collExercisesRelatedByExNameS2Id as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->exercisesRelatedByExNameS3IdScheduledForDeletion !== null) {
                if (!$this->exercisesRelatedByExNameS3IdScheduledForDeletion->isEmpty()) {
                    foreach ($this->exercisesRelatedByExNameS3IdScheduledForDeletion as $exerciseRelatedByExNameS3Id) {
                        // need to save related object because we set the relation to null
                        $exerciseRelatedByExNameS3Id->save($con);
                    }
                    $this->exercisesRelatedByExNameS3IdScheduledForDeletion = null;
                }
            }

            if ($this->collExercisesRelatedByExNameS3Id !== null) {
                foreach ($this->collExercisesRelatedByExNameS3Id as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[ExerciseNameTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ExerciseNameTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ExerciseNameTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(ExerciseNameTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(ExerciseNameTableMap::COL_MUSCLE_GROUP)) {
            $modifiedColumns[':p' . $index++]  = '`muscle_group`';
        }

        $sql = sprintf(
            'INSERT INTO `exercise_name` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`muscle_group`':
                        $stmt->bindValue($identifier, $this->muscle_group, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ExerciseNameTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getMuscleGroup();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['ExerciseName'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['ExerciseName'][$this->hashCode()] = true;
        $keys = ExerciseNameTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getMuscleGroup(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collExercisesRelatedByExNameId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'exercises';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'exercises';
                        break;
                    default:
                        $key = 'Exercises';
                }

                $result[$key] = $this->collExercisesRelatedByExNameId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collExercisesRelatedByExNameS2Id) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'exercises';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'exercises';
                        break;
                    default:
                        $key = 'Exercises';
                }

                $result[$key] = $this->collExercisesRelatedByExNameS2Id->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collExercisesRelatedByExNameS3Id) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'exercises';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'exercises';
                        break;
                    default:
                        $key = 'Exercises';
                }

                $result[$key] = $this->collExercisesRelatedByExNameS3Id->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Gym\ExerciseName
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ExerciseNameTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Gym\ExerciseName
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $valueSet = ExerciseNameTableMap::getValueSet(ExerciseNameTableMap::COL_MUSCLE_GROUP);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setMuscleGroup($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = ExerciseNameTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setMuscleGroup($arr[$keys[2]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Gym\ExerciseName The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ExerciseNameTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ExerciseNameTableMap::COL_ID)) {
            $criteria->add(ExerciseNameTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ExerciseNameTableMap::COL_NAME)) {
            $criteria->add(ExerciseNameTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(ExerciseNameTableMap::COL_MUSCLE_GROUP)) {
            $criteria->add(ExerciseNameTableMap::COL_MUSCLE_GROUP, $this->muscle_group);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildExerciseNameQuery::create();
        $criteria->add(ExerciseNameTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Gym\ExerciseName (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setMuscleGroup($this->getMuscleGroup());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getExercisesRelatedByExNameId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addExerciseRelatedByExNameId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getExercisesRelatedByExNameS2Id() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addExerciseRelatedByExNameS2Id($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getExercisesRelatedByExNameS3Id() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addExerciseRelatedByExNameS3Id($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Gym\ExerciseName Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('ExerciseRelatedByExNameId' == $relationName) {
            return $this->initExercisesRelatedByExNameId();
        }
        if ('ExerciseRelatedByExNameS2Id' == $relationName) {
            return $this->initExercisesRelatedByExNameS2Id();
        }
        if ('ExerciseRelatedByExNameS3Id' == $relationName) {
            return $this->initExercisesRelatedByExNameS3Id();
        }
    }

    /**
     * Clears out the collExercisesRelatedByExNameId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addExercisesRelatedByExNameId()
     */
    public function clearExercisesRelatedByExNameId()
    {
        $this->collExercisesRelatedByExNameId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collExercisesRelatedByExNameId collection loaded partially.
     */
    public function resetPartialExercisesRelatedByExNameId($v = true)
    {
        $this->collExercisesRelatedByExNameIdPartial = $v;
    }

    /**
     * Initializes the collExercisesRelatedByExNameId collection.
     *
     * By default this just sets the collExercisesRelatedByExNameId collection to an empty array (like clearcollExercisesRelatedByExNameId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initExercisesRelatedByExNameId($overrideExisting = true)
    {
        if (null !== $this->collExercisesRelatedByExNameId && !$overrideExisting) {
            return;
        }

        $collectionClassName = ExerciseTableMap::getTableMap()->getCollectionClassName();

        $this->collExercisesRelatedByExNameId = new $collectionClassName;
        $this->collExercisesRelatedByExNameId->setModel('\Gym\Exercise');
    }

    /**
     * Gets an array of ChildExercise objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildExerciseName is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildExercise[] List of ChildExercise objects
     * @throws PropelException
     */
    public function getExercisesRelatedByExNameId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collExercisesRelatedByExNameIdPartial && !$this->isNew();
        if (null === $this->collExercisesRelatedByExNameId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collExercisesRelatedByExNameId) {
                // return empty collection
                $this->initExercisesRelatedByExNameId();
            } else {
                $collExercisesRelatedByExNameId = ChildExerciseQuery::create(null, $criteria)
                    ->filterByex_name_id($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collExercisesRelatedByExNameIdPartial && count($collExercisesRelatedByExNameId)) {
                        $this->initExercisesRelatedByExNameId(false);

                        foreach ($collExercisesRelatedByExNameId as $obj) {
                            if (false == $this->collExercisesRelatedByExNameId->contains($obj)) {
                                $this->collExercisesRelatedByExNameId->append($obj);
                            }
                        }

                        $this->collExercisesRelatedByExNameIdPartial = true;
                    }

                    return $collExercisesRelatedByExNameId;
                }

                if ($partial && $this->collExercisesRelatedByExNameId) {
                    foreach ($this->collExercisesRelatedByExNameId as $obj) {
                        if ($obj->isNew()) {
                            $collExercisesRelatedByExNameId[] = $obj;
                        }
                    }
                }

                $this->collExercisesRelatedByExNameId = $collExercisesRelatedByExNameId;
                $this->collExercisesRelatedByExNameIdPartial = false;
            }
        }

        return $this->collExercisesRelatedByExNameId;
    }

    /**
     * Sets a collection of ChildExercise objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $exercisesRelatedByExNameId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildExerciseName The current object (for fluent API support)
     */
    public function setExercisesRelatedByExNameId(Collection $exercisesRelatedByExNameId, ConnectionInterface $con = null)
    {
        /** @var ChildExercise[] $exercisesRelatedByExNameIdToDelete */
        $exercisesRelatedByExNameIdToDelete = $this->getExercisesRelatedByExNameId(new Criteria(), $con)->diff($exercisesRelatedByExNameId);


        $this->exercisesRelatedByExNameIdScheduledForDeletion = $exercisesRelatedByExNameIdToDelete;

        foreach ($exercisesRelatedByExNameIdToDelete as $exerciseRelatedByExNameIdRemoved) {
            $exerciseRelatedByExNameIdRemoved->setex_name_id(null);
        }

        $this->collExercisesRelatedByExNameId = null;
        foreach ($exercisesRelatedByExNameId as $exerciseRelatedByExNameId) {
            $this->addExerciseRelatedByExNameId($exerciseRelatedByExNameId);
        }

        $this->collExercisesRelatedByExNameId = $exercisesRelatedByExNameId;
        $this->collExercisesRelatedByExNameIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Exercise objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Exercise objects.
     * @throws PropelException
     */
    public function countExercisesRelatedByExNameId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collExercisesRelatedByExNameIdPartial && !$this->isNew();
        if (null === $this->collExercisesRelatedByExNameId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collExercisesRelatedByExNameId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getExercisesRelatedByExNameId());
            }

            $query = ChildExerciseQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByex_name_id($this)
                ->count($con);
        }

        return count($this->collExercisesRelatedByExNameId);
    }

    /**
     * Method called to associate a ChildExercise object to this object
     * through the ChildExercise foreign key attribute.
     *
     * @param  ChildExercise $l ChildExercise
     * @return $this|\Gym\ExerciseName The current object (for fluent API support)
     */
    public function addExerciseRelatedByExNameId(ChildExercise $l)
    {
        if ($this->collExercisesRelatedByExNameId === null) {
            $this->initExercisesRelatedByExNameId();
            $this->collExercisesRelatedByExNameIdPartial = true;
        }

        if (!$this->collExercisesRelatedByExNameId->contains($l)) {
            $this->doAddExerciseRelatedByExNameId($l);

            if ($this->exercisesRelatedByExNameIdScheduledForDeletion and $this->exercisesRelatedByExNameIdScheduledForDeletion->contains($l)) {
                $this->exercisesRelatedByExNameIdScheduledForDeletion->remove($this->exercisesRelatedByExNameIdScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildExercise $exerciseRelatedByExNameId The ChildExercise object to add.
     */
    protected function doAddExerciseRelatedByExNameId(ChildExercise $exerciseRelatedByExNameId)
    {
        $this->collExercisesRelatedByExNameId[]= $exerciseRelatedByExNameId;
        $exerciseRelatedByExNameId->setex_name_id($this);
    }

    /**
     * @param  ChildExercise $exerciseRelatedByExNameId The ChildExercise object to remove.
     * @return $this|ChildExerciseName The current object (for fluent API support)
     */
    public function removeExerciseRelatedByExNameId(ChildExercise $exerciseRelatedByExNameId)
    {
        if ($this->getExercisesRelatedByExNameId()->contains($exerciseRelatedByExNameId)) {
            $pos = $this->collExercisesRelatedByExNameId->search($exerciseRelatedByExNameId);
            $this->collExercisesRelatedByExNameId->remove($pos);
            if (null === $this->exercisesRelatedByExNameIdScheduledForDeletion) {
                $this->exercisesRelatedByExNameIdScheduledForDeletion = clone $this->collExercisesRelatedByExNameId;
                $this->exercisesRelatedByExNameIdScheduledForDeletion->clear();
            }
            $this->exercisesRelatedByExNameIdScheduledForDeletion[]= clone $exerciseRelatedByExNameId;
            $exerciseRelatedByExNameId->setex_name_id(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this ExerciseName is new, it will return
     * an empty collection; or if this ExerciseName has previously
     * been saved, it will retrieve related ExercisesRelatedByExNameId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in ExerciseName.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildExercise[] List of ChildExercise objects
     */
    public function getExercisesRelatedByExNameIdJoinSchedule(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildExerciseQuery::create(null, $criteria);
        $query->joinWith('Schedule', $joinBehavior);

        return $this->getExercisesRelatedByExNameId($query, $con);
    }

    /**
     * Clears out the collExercisesRelatedByExNameS2Id collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addExercisesRelatedByExNameS2Id()
     */
    public function clearExercisesRelatedByExNameS2Id()
    {
        $this->collExercisesRelatedByExNameS2Id = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collExercisesRelatedByExNameS2Id collection loaded partially.
     */
    public function resetPartialExercisesRelatedByExNameS2Id($v = true)
    {
        $this->collExercisesRelatedByExNameS2IdPartial = $v;
    }

    /**
     * Initializes the collExercisesRelatedByExNameS2Id collection.
     *
     * By default this just sets the collExercisesRelatedByExNameS2Id collection to an empty array (like clearcollExercisesRelatedByExNameS2Id());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initExercisesRelatedByExNameS2Id($overrideExisting = true)
    {
        if (null !== $this->collExercisesRelatedByExNameS2Id && !$overrideExisting) {
            return;
        }

        $collectionClassName = ExerciseTableMap::getTableMap()->getCollectionClassName();

        $this->collExercisesRelatedByExNameS2Id = new $collectionClassName;
        $this->collExercisesRelatedByExNameS2Id->setModel('\Gym\Exercise');
    }

    /**
     * Gets an array of ChildExercise objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildExerciseName is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildExercise[] List of ChildExercise objects
     * @throws PropelException
     */
    public function getExercisesRelatedByExNameS2Id(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collExercisesRelatedByExNameS2IdPartial && !$this->isNew();
        if (null === $this->collExercisesRelatedByExNameS2Id || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collExercisesRelatedByExNameS2Id) {
                // return empty collection
                $this->initExercisesRelatedByExNameS2Id();
            } else {
                $collExercisesRelatedByExNameS2Id = ChildExerciseQuery::create(null, $criteria)
                    ->filterByex_name_s2_id($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collExercisesRelatedByExNameS2IdPartial && count($collExercisesRelatedByExNameS2Id)) {
                        $this->initExercisesRelatedByExNameS2Id(false);

                        foreach ($collExercisesRelatedByExNameS2Id as $obj) {
                            if (false == $this->collExercisesRelatedByExNameS2Id->contains($obj)) {
                                $this->collExercisesRelatedByExNameS2Id->append($obj);
                            }
                        }

                        $this->collExercisesRelatedByExNameS2IdPartial = true;
                    }

                    return $collExercisesRelatedByExNameS2Id;
                }

                if ($partial && $this->collExercisesRelatedByExNameS2Id) {
                    foreach ($this->collExercisesRelatedByExNameS2Id as $obj) {
                        if ($obj->isNew()) {
                            $collExercisesRelatedByExNameS2Id[] = $obj;
                        }
                    }
                }

                $this->collExercisesRelatedByExNameS2Id = $collExercisesRelatedByExNameS2Id;
                $this->collExercisesRelatedByExNameS2IdPartial = false;
            }
        }

        return $this->collExercisesRelatedByExNameS2Id;
    }

    /**
     * Sets a collection of ChildExercise objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $exercisesRelatedByExNameS2Id A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildExerciseName The current object (for fluent API support)
     */
    public function setExercisesRelatedByExNameS2Id(Collection $exercisesRelatedByExNameS2Id, ConnectionInterface $con = null)
    {
        /** @var ChildExercise[] $exercisesRelatedByExNameS2IdToDelete */
        $exercisesRelatedByExNameS2IdToDelete = $this->getExercisesRelatedByExNameS2Id(new Criteria(), $con)->diff($exercisesRelatedByExNameS2Id);


        $this->exercisesRelatedByExNameS2IdScheduledForDeletion = $exercisesRelatedByExNameS2IdToDelete;

        foreach ($exercisesRelatedByExNameS2IdToDelete as $exerciseRelatedByExNameS2IdRemoved) {
            $exerciseRelatedByExNameS2IdRemoved->setex_name_s2_id(null);
        }

        $this->collExercisesRelatedByExNameS2Id = null;
        foreach ($exercisesRelatedByExNameS2Id as $exerciseRelatedByExNameS2Id) {
            $this->addExerciseRelatedByExNameS2Id($exerciseRelatedByExNameS2Id);
        }

        $this->collExercisesRelatedByExNameS2Id = $exercisesRelatedByExNameS2Id;
        $this->collExercisesRelatedByExNameS2IdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Exercise objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Exercise objects.
     * @throws PropelException
     */
    public function countExercisesRelatedByExNameS2Id(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collExercisesRelatedByExNameS2IdPartial && !$this->isNew();
        if (null === $this->collExercisesRelatedByExNameS2Id || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collExercisesRelatedByExNameS2Id) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getExercisesRelatedByExNameS2Id());
            }

            $query = ChildExerciseQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByex_name_s2_id($this)
                ->count($con);
        }

        return count($this->collExercisesRelatedByExNameS2Id);
    }

    /**
     * Method called to associate a ChildExercise object to this object
     * through the ChildExercise foreign key attribute.
     *
     * @param  ChildExercise $l ChildExercise
     * @return $this|\Gym\ExerciseName The current object (for fluent API support)
     */
    public function addExerciseRelatedByExNameS2Id(ChildExercise $l)
    {
        if ($this->collExercisesRelatedByExNameS2Id === null) {
            $this->initExercisesRelatedByExNameS2Id();
            $this->collExercisesRelatedByExNameS2IdPartial = true;
        }

        if (!$this->collExercisesRelatedByExNameS2Id->contains($l)) {
            $this->doAddExerciseRelatedByExNameS2Id($l);

            if ($this->exercisesRelatedByExNameS2IdScheduledForDeletion and $this->exercisesRelatedByExNameS2IdScheduledForDeletion->contains($l)) {
                $this->exercisesRelatedByExNameS2IdScheduledForDeletion->remove($this->exercisesRelatedByExNameS2IdScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildExercise $exerciseRelatedByExNameS2Id The ChildExercise object to add.
     */
    protected function doAddExerciseRelatedByExNameS2Id(ChildExercise $exerciseRelatedByExNameS2Id)
    {
        $this->collExercisesRelatedByExNameS2Id[]= $exerciseRelatedByExNameS2Id;
        $exerciseRelatedByExNameS2Id->setex_name_s2_id($this);
    }

    /**
     * @param  ChildExercise $exerciseRelatedByExNameS2Id The ChildExercise object to remove.
     * @return $this|ChildExerciseName The current object (for fluent API support)
     */
    public function removeExerciseRelatedByExNameS2Id(ChildExercise $exerciseRelatedByExNameS2Id)
    {
        if ($this->getExercisesRelatedByExNameS2Id()->contains($exerciseRelatedByExNameS2Id)) {
            $pos = $this->collExercisesRelatedByExNameS2Id->search($exerciseRelatedByExNameS2Id);
            $this->collExercisesRelatedByExNameS2Id->remove($pos);
            if (null === $this->exercisesRelatedByExNameS2IdScheduledForDeletion) {
                $this->exercisesRelatedByExNameS2IdScheduledForDeletion = clone $this->collExercisesRelatedByExNameS2Id;
                $this->exercisesRelatedByExNameS2IdScheduledForDeletion->clear();
            }
            $this->exercisesRelatedByExNameS2IdScheduledForDeletion[]= $exerciseRelatedByExNameS2Id;
            $exerciseRelatedByExNameS2Id->setex_name_s2_id(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this ExerciseName is new, it will return
     * an empty collection; or if this ExerciseName has previously
     * been saved, it will retrieve related ExercisesRelatedByExNameS2Id from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in ExerciseName.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildExercise[] List of ChildExercise objects
     */
    public function getExercisesRelatedByExNameS2IdJoinSchedule(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildExerciseQuery::create(null, $criteria);
        $query->joinWith('Schedule', $joinBehavior);

        return $this->getExercisesRelatedByExNameS2Id($query, $con);
    }

    /**
     * Clears out the collExercisesRelatedByExNameS3Id collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addExercisesRelatedByExNameS3Id()
     */
    public function clearExercisesRelatedByExNameS3Id()
    {
        $this->collExercisesRelatedByExNameS3Id = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collExercisesRelatedByExNameS3Id collection loaded partially.
     */
    public function resetPartialExercisesRelatedByExNameS3Id($v = true)
    {
        $this->collExercisesRelatedByExNameS3IdPartial = $v;
    }

    /**
     * Initializes the collExercisesRelatedByExNameS3Id collection.
     *
     * By default this just sets the collExercisesRelatedByExNameS3Id collection to an empty array (like clearcollExercisesRelatedByExNameS3Id());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initExercisesRelatedByExNameS3Id($overrideExisting = true)
    {
        if (null !== $this->collExercisesRelatedByExNameS3Id && !$overrideExisting) {
            return;
        }

        $collectionClassName = ExerciseTableMap::getTableMap()->getCollectionClassName();

        $this->collExercisesRelatedByExNameS3Id = new $collectionClassName;
        $this->collExercisesRelatedByExNameS3Id->setModel('\Gym\Exercise');
    }

    /**
     * Gets an array of ChildExercise objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildExerciseName is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildExercise[] List of ChildExercise objects
     * @throws PropelException
     */
    public function getExercisesRelatedByExNameS3Id(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collExercisesRelatedByExNameS3IdPartial && !$this->isNew();
        if (null === $this->collExercisesRelatedByExNameS3Id || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collExercisesRelatedByExNameS3Id) {
                // return empty collection
                $this->initExercisesRelatedByExNameS3Id();
            } else {
                $collExercisesRelatedByExNameS3Id = ChildExerciseQuery::create(null, $criteria)
                    ->filterByex_name_s3_id($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collExercisesRelatedByExNameS3IdPartial && count($collExercisesRelatedByExNameS3Id)) {
                        $this->initExercisesRelatedByExNameS3Id(false);

                        foreach ($collExercisesRelatedByExNameS3Id as $obj) {
                            if (false == $this->collExercisesRelatedByExNameS3Id->contains($obj)) {
                                $this->collExercisesRelatedByExNameS3Id->append($obj);
                            }
                        }

                        $this->collExercisesRelatedByExNameS3IdPartial = true;
                    }

                    return $collExercisesRelatedByExNameS3Id;
                }

                if ($partial && $this->collExercisesRelatedByExNameS3Id) {
                    foreach ($this->collExercisesRelatedByExNameS3Id as $obj) {
                        if ($obj->isNew()) {
                            $collExercisesRelatedByExNameS3Id[] = $obj;
                        }
                    }
                }

                $this->collExercisesRelatedByExNameS3Id = $collExercisesRelatedByExNameS3Id;
                $this->collExercisesRelatedByExNameS3IdPartial = false;
            }
        }

        return $this->collExercisesRelatedByExNameS3Id;
    }

    /**
     * Sets a collection of ChildExercise objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $exercisesRelatedByExNameS3Id A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildExerciseName The current object (for fluent API support)
     */
    public function setExercisesRelatedByExNameS3Id(Collection $exercisesRelatedByExNameS3Id, ConnectionInterface $con = null)
    {
        /** @var ChildExercise[] $exercisesRelatedByExNameS3IdToDelete */
        $exercisesRelatedByExNameS3IdToDelete = $this->getExercisesRelatedByExNameS3Id(new Criteria(), $con)->diff($exercisesRelatedByExNameS3Id);


        $this->exercisesRelatedByExNameS3IdScheduledForDeletion = $exercisesRelatedByExNameS3IdToDelete;

        foreach ($exercisesRelatedByExNameS3IdToDelete as $exerciseRelatedByExNameS3IdRemoved) {
            $exerciseRelatedByExNameS3IdRemoved->setex_name_s3_id(null);
        }

        $this->collExercisesRelatedByExNameS3Id = null;
        foreach ($exercisesRelatedByExNameS3Id as $exerciseRelatedByExNameS3Id) {
            $this->addExerciseRelatedByExNameS3Id($exerciseRelatedByExNameS3Id);
        }

        $this->collExercisesRelatedByExNameS3Id = $exercisesRelatedByExNameS3Id;
        $this->collExercisesRelatedByExNameS3IdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Exercise objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Exercise objects.
     * @throws PropelException
     */
    public function countExercisesRelatedByExNameS3Id(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collExercisesRelatedByExNameS3IdPartial && !$this->isNew();
        if (null === $this->collExercisesRelatedByExNameS3Id || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collExercisesRelatedByExNameS3Id) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getExercisesRelatedByExNameS3Id());
            }

            $query = ChildExerciseQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByex_name_s3_id($this)
                ->count($con);
        }

        return count($this->collExercisesRelatedByExNameS3Id);
    }

    /**
     * Method called to associate a ChildExercise object to this object
     * through the ChildExercise foreign key attribute.
     *
     * @param  ChildExercise $l ChildExercise
     * @return $this|\Gym\ExerciseName The current object (for fluent API support)
     */
    public function addExerciseRelatedByExNameS3Id(ChildExercise $l)
    {
        if ($this->collExercisesRelatedByExNameS3Id === null) {
            $this->initExercisesRelatedByExNameS3Id();
            $this->collExercisesRelatedByExNameS3IdPartial = true;
        }

        if (!$this->collExercisesRelatedByExNameS3Id->contains($l)) {
            $this->doAddExerciseRelatedByExNameS3Id($l);

            if ($this->exercisesRelatedByExNameS3IdScheduledForDeletion and $this->exercisesRelatedByExNameS3IdScheduledForDeletion->contains($l)) {
                $this->exercisesRelatedByExNameS3IdScheduledForDeletion->remove($this->exercisesRelatedByExNameS3IdScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildExercise $exerciseRelatedByExNameS3Id The ChildExercise object to add.
     */
    protected function doAddExerciseRelatedByExNameS3Id(ChildExercise $exerciseRelatedByExNameS3Id)
    {
        $this->collExercisesRelatedByExNameS3Id[]= $exerciseRelatedByExNameS3Id;
        $exerciseRelatedByExNameS3Id->setex_name_s3_id($this);
    }

    /**
     * @param  ChildExercise $exerciseRelatedByExNameS3Id The ChildExercise object to remove.
     * @return $this|ChildExerciseName The current object (for fluent API support)
     */
    public function removeExerciseRelatedByExNameS3Id(ChildExercise $exerciseRelatedByExNameS3Id)
    {
        if ($this->getExercisesRelatedByExNameS3Id()->contains($exerciseRelatedByExNameS3Id)) {
            $pos = $this->collExercisesRelatedByExNameS3Id->search($exerciseRelatedByExNameS3Id);
            $this->collExercisesRelatedByExNameS3Id->remove($pos);
            if (null === $this->exercisesRelatedByExNameS3IdScheduledForDeletion) {
                $this->exercisesRelatedByExNameS3IdScheduledForDeletion = clone $this->collExercisesRelatedByExNameS3Id;
                $this->exercisesRelatedByExNameS3IdScheduledForDeletion->clear();
            }
            $this->exercisesRelatedByExNameS3IdScheduledForDeletion[]= $exerciseRelatedByExNameS3Id;
            $exerciseRelatedByExNameS3Id->setex_name_s3_id(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this ExerciseName is new, it will return
     * an empty collection; or if this ExerciseName has previously
     * been saved, it will retrieve related ExercisesRelatedByExNameS3Id from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in ExerciseName.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildExercise[] List of ChildExercise objects
     */
    public function getExercisesRelatedByExNameS3IdJoinSchedule(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildExerciseQuery::create(null, $criteria);
        $query->joinWith('Schedule', $joinBehavior);

        return $this->getExercisesRelatedByExNameS3Id($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->muscle_group = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collExercisesRelatedByExNameId) {
                foreach ($this->collExercisesRelatedByExNameId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collExercisesRelatedByExNameS2Id) {
                foreach ($this->collExercisesRelatedByExNameS2Id as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collExercisesRelatedByExNameS3Id) {
                foreach ($this->collExercisesRelatedByExNameS3Id as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collExercisesRelatedByExNameId = null;
        $this->collExercisesRelatedByExNameS2Id = null;
        $this->collExercisesRelatedByExNameS3Id = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ExerciseNameTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
