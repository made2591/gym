<?php

namespace Gym\Base;

use \Exception;
use \PDO;
use Gym\ExerciseName as ChildExerciseName;
use Gym\ExerciseNameQuery as ChildExerciseNameQuery;
use Gym\ExerciseQuery as ChildExerciseQuery;
use Gym\Schedule as ChildSchedule;
use Gym\ScheduleQuery as ChildScheduleQuery;
use Gym\Map\ExerciseTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'exercise' table.
 *
 *
 *
* @package    propel.generator.Gym.Base
*/
abstract class Exercise implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Gym\\Map\\ExerciseTableMap';


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
     * The value for the ex_name_id field.
     *
     * @var        int
     */
    protected $ex_name_id;

    /**
     * The value for the ex_name_s2_id field.
     *
     * @var        int
     */
    protected $ex_name_s2_id;

    /**
     * The value for the ex_name_s3_id field.
     *
     * @var        int
     */
    protected $ex_name_s3_id;

    /**
     * The value for the day field.
     *
     * @var        int
     */
    protected $day;

    /**
     * The value for the kind field.
     *
     * @var        int
     */
    protected $kind;

    /**
     * The value for the serie field.
     *
     * @var        int
     */
    protected $serie;

    /**
     * The value for the repetition field.
     *
     * @var        string
     */
    protected $repetition;

    /**
     * The value for the difficulty field.
     *
     * Note: this column has a database default value of: 3
     * @var        int
     */
    protected $difficulty;

    /**
     * The value for the exec_weights field.
     *
     * @var        string
     */
    protected $exec_weights;

    /**
     * The value for the exec_times field.
     *
     * @var        string
     */
    protected $exec_times;

    /**
     * The value for the pause_times field.
     *
     * @var        string
     */
    protected $pause_times;

    /**
     * The value for the schedule_id field.
     *
     * @var        int
     */
    protected $schedule_id;

    /**
     * @var        ChildExerciseName
     */
    protected $aex_name_id;

    /**
     * @var        ChildExerciseName
     */
    protected $aex_name_s2_id;

    /**
     * @var        ChildExerciseName
     */
    protected $aex_name_s3_id;

    /**
     * @var        ChildSchedule
     */
    protected $aSchedule;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->difficulty = 3;
    }

    /**
     * Initializes internal state of Gym\Base\Exercise object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
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
     * Compares this with another <code>Exercise</code> instance.  If
     * <code>obj</code> is an instance of <code>Exercise</code>, delegates to
     * <code>equals(Exercise)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Exercise The current object, for fluid interface
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
     * Get the [ex_name_id] column value.
     *
     * @return int
     */
    public function getExNameId()
    {
        return $this->ex_name_id;
    }

    /**
     * Get the [ex_name_s2_id] column value.
     *
     * @return int
     */
    public function getExNameS2Id()
    {
        return $this->ex_name_s2_id;
    }

    /**
     * Get the [ex_name_s3_id] column value.
     *
     * @return int
     */
    public function getExNameS3Id()
    {
        return $this->ex_name_s3_id;
    }

    /**
     * Get the [day] column value.
     *
     * @return string
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getDay()
    {
        if (null === $this->day) {
            return null;
        }
        $valueSet = ExerciseTableMap::getValueSet(ExerciseTableMap::COL_DAY);
        if (!isset($valueSet[$this->day])) {
            throw new PropelException('Unknown stored enum key: ' . $this->day);
        }

        return $valueSet[$this->day];
    }

    /**
     * Get the [kind] column value.
     *
     * @return string
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getKind()
    {
        if (null === $this->kind) {
            return null;
        }
        $valueSet = ExerciseTableMap::getValueSet(ExerciseTableMap::COL_KIND);
        if (!isset($valueSet[$this->kind])) {
            throw new PropelException('Unknown stored enum key: ' . $this->kind);
        }

        return $valueSet[$this->kind];
    }

    /**
     * Get the [serie] column value.
     *
     * @return string
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getSerie()
    {
        if (null === $this->serie) {
            return null;
        }
        $valueSet = ExerciseTableMap::getValueSet(ExerciseTableMap::COL_SERIE);
        if (!isset($valueSet[$this->serie])) {
            throw new PropelException('Unknown stored enum key: ' . $this->serie);
        }

        return $valueSet[$this->serie];
    }

    /**
     * Get the [repetition] column value.
     *
     * @return string
     */
    public function getRepetition()
    {
        return $this->repetition;
    }

    /**
     * Get the [difficulty] column value.
     *
     * @return int
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * Get the [exec_weights] column value.
     *
     * @return string
     */
    public function getExecWeights()
    {
        return $this->exec_weights;
    }

    /**
     * Get the [exec_times] column value.
     *
     * @return string
     */
    public function getExecTimes()
    {
        return $this->exec_times;
    }

    /**
     * Get the [pause_times] column value.
     *
     * @return string
     */
    public function getPauseTimes()
    {
        return $this->pause_times;
    }

    /**
     * Get the [schedule_id] column value.
     *
     * @return int
     */
    public function getScheduleId()
    {
        return $this->schedule_id;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Gym\Exercise The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ExerciseTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [ex_name_id] column.
     *
     * @param int $v new value
     * @return $this|\Gym\Exercise The current object (for fluent API support)
     */
    public function setExNameId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->ex_name_id !== $v) {
            $this->ex_name_id = $v;
            $this->modifiedColumns[ExerciseTableMap::COL_EX_NAME_ID] = true;
        }

        if ($this->aex_name_id !== null && $this->aex_name_id->getId() !== $v) {
            $this->aex_name_id = null;
        }

        return $this;
    } // setExNameId()

    /**
     * Set the value of [ex_name_s2_id] column.
     *
     * @param int $v new value
     * @return $this|\Gym\Exercise The current object (for fluent API support)
     */
    public function setExNameS2Id($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->ex_name_s2_id !== $v) {
            $this->ex_name_s2_id = $v;
            $this->modifiedColumns[ExerciseTableMap::COL_EX_NAME_S2_ID] = true;
        }

        if ($this->aex_name_s2_id !== null && $this->aex_name_s2_id->getId() !== $v) {
            $this->aex_name_s2_id = null;
        }

        return $this;
    } // setExNameS2Id()

    /**
     * Set the value of [ex_name_s3_id] column.
     *
     * @param int $v new value
     * @return $this|\Gym\Exercise The current object (for fluent API support)
     */
    public function setExNameS3Id($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->ex_name_s3_id !== $v) {
            $this->ex_name_s3_id = $v;
            $this->modifiedColumns[ExerciseTableMap::COL_EX_NAME_S3_ID] = true;
        }

        if ($this->aex_name_s3_id !== null && $this->aex_name_s3_id->getId() !== $v) {
            $this->aex_name_s3_id = null;
        }

        return $this;
    } // setExNameS3Id()

    /**
     * Set the value of [day] column.
     *
     * @param  string $v new value
     * @return $this|\Gym\Exercise The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setDay($v)
    {
        if ($v !== null) {
            $valueSet = ExerciseTableMap::getValueSet(ExerciseTableMap::COL_DAY);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->day !== $v) {
            $this->day = $v;
            $this->modifiedColumns[ExerciseTableMap::COL_DAY] = true;
        }

        return $this;
    } // setDay()

    /**
     * Set the value of [kind] column.
     *
     * @param  string $v new value
     * @return $this|\Gym\Exercise The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setKind($v)
    {
        if ($v !== null) {
            $valueSet = ExerciseTableMap::getValueSet(ExerciseTableMap::COL_KIND);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->kind !== $v) {
            $this->kind = $v;
            $this->modifiedColumns[ExerciseTableMap::COL_KIND] = true;
        }

        return $this;
    } // setKind()

    /**
     * Set the value of [serie] column.
     *
     * @param  string $v new value
     * @return $this|\Gym\Exercise The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setSerie($v)
    {
        if ($v !== null) {
            $valueSet = ExerciseTableMap::getValueSet(ExerciseTableMap::COL_SERIE);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->serie !== $v) {
            $this->serie = $v;
            $this->modifiedColumns[ExerciseTableMap::COL_SERIE] = true;
        }

        return $this;
    } // setSerie()

    /**
     * Set the value of [repetition] column.
     *
     * @param string $v new value
     * @return $this|\Gym\Exercise The current object (for fluent API support)
     */
    public function setRepetition($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->repetition !== $v) {
            $this->repetition = $v;
            $this->modifiedColumns[ExerciseTableMap::COL_REPETITION] = true;
        }

        return $this;
    } // setRepetition()

    /**
     * Set the value of [difficulty] column.
     *
     * @param int $v new value
     * @return $this|\Gym\Exercise The current object (for fluent API support)
     */
    public function setDifficulty($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->difficulty !== $v) {
            $this->difficulty = $v;
            $this->modifiedColumns[ExerciseTableMap::COL_DIFFICULTY] = true;
        }

        return $this;
    } // setDifficulty()

    /**
     * Set the value of [exec_weights] column.
     *
     * @param string $v new value
     * @return $this|\Gym\Exercise The current object (for fluent API support)
     */
    public function setExecWeights($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->exec_weights !== $v) {
            $this->exec_weights = $v;
            $this->modifiedColumns[ExerciseTableMap::COL_EXEC_WEIGHTS] = true;
        }

        return $this;
    } // setExecWeights()

    /**
     * Set the value of [exec_times] column.
     *
     * @param string $v new value
     * @return $this|\Gym\Exercise The current object (for fluent API support)
     */
    public function setExecTimes($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->exec_times !== $v) {
            $this->exec_times = $v;
            $this->modifiedColumns[ExerciseTableMap::COL_EXEC_TIMES] = true;
        }

        return $this;
    } // setExecTimes()

    /**
     * Set the value of [pause_times] column.
     *
     * @param string $v new value
     * @return $this|\Gym\Exercise The current object (for fluent API support)
     */
    public function setPauseTimes($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->pause_times !== $v) {
            $this->pause_times = $v;
            $this->modifiedColumns[ExerciseTableMap::COL_PAUSE_TIMES] = true;
        }

        return $this;
    } // setPauseTimes()

    /**
     * Set the value of [schedule_id] column.
     *
     * @param int $v new value
     * @return $this|\Gym\Exercise The current object (for fluent API support)
     */
    public function setScheduleId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->schedule_id !== $v) {
            $this->schedule_id = $v;
            $this->modifiedColumns[ExerciseTableMap::COL_SCHEDULE_ID] = true;
        }

        if ($this->aSchedule !== null && $this->aSchedule->getId() !== $v) {
            $this->aSchedule = null;
        }

        return $this;
    } // setScheduleId()

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
            if ($this->difficulty !== 3) {
                return false;
            }

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ExerciseTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ExerciseTableMap::translateFieldName('ExNameId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ex_name_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ExerciseTableMap::translateFieldName('ExNameS2Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ex_name_s2_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ExerciseTableMap::translateFieldName('ExNameS3Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ex_name_s3_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ExerciseTableMap::translateFieldName('Day', TableMap::TYPE_PHPNAME, $indexType)];
            $this->day = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ExerciseTableMap::translateFieldName('Kind', TableMap::TYPE_PHPNAME, $indexType)];
            $this->kind = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ExerciseTableMap::translateFieldName('Serie', TableMap::TYPE_PHPNAME, $indexType)];
            $this->serie = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ExerciseTableMap::translateFieldName('Repetition', TableMap::TYPE_PHPNAME, $indexType)];
            $this->repetition = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ExerciseTableMap::translateFieldName('Difficulty', TableMap::TYPE_PHPNAME, $indexType)];
            $this->difficulty = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : ExerciseTableMap::translateFieldName('ExecWeights', TableMap::TYPE_PHPNAME, $indexType)];
            $this->exec_weights = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : ExerciseTableMap::translateFieldName('ExecTimes', TableMap::TYPE_PHPNAME, $indexType)];
            $this->exec_times = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : ExerciseTableMap::translateFieldName('PauseTimes', TableMap::TYPE_PHPNAME, $indexType)];
            $this->pause_times = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : ExerciseTableMap::translateFieldName('ScheduleId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->schedule_id = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 13; // 13 = ExerciseTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Gym\\Exercise'), 0, $e);
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
        if ($this->aex_name_id !== null && $this->ex_name_id !== $this->aex_name_id->getId()) {
            $this->aex_name_id = null;
        }
        if ($this->aex_name_s2_id !== null && $this->ex_name_s2_id !== $this->aex_name_s2_id->getId()) {
            $this->aex_name_s2_id = null;
        }
        if ($this->aex_name_s3_id !== null && $this->ex_name_s3_id !== $this->aex_name_s3_id->getId()) {
            $this->aex_name_s3_id = null;
        }
        if ($this->aSchedule !== null && $this->schedule_id !== $this->aSchedule->getId()) {
            $this->aSchedule = null;
        }
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
            $con = Propel::getServiceContainer()->getReadConnection(ExerciseTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildExerciseQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aex_name_id = null;
            $this->aex_name_s2_id = null;
            $this->aex_name_s3_id = null;
            $this->aSchedule = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Exercise::setDeleted()
     * @see Exercise::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ExerciseTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildExerciseQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ExerciseTableMap::DATABASE_NAME);
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
                ExerciseTableMap::addInstanceToPool($this);
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

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aex_name_id !== null) {
                if ($this->aex_name_id->isModified() || $this->aex_name_id->isNew()) {
                    $affectedRows += $this->aex_name_id->save($con);
                }
                $this->setex_name_id($this->aex_name_id);
            }

            if ($this->aex_name_s2_id !== null) {
                if ($this->aex_name_s2_id->isModified() || $this->aex_name_s2_id->isNew()) {
                    $affectedRows += $this->aex_name_s2_id->save($con);
                }
                $this->setex_name_s2_id($this->aex_name_s2_id);
            }

            if ($this->aex_name_s3_id !== null) {
                if ($this->aex_name_s3_id->isModified() || $this->aex_name_s3_id->isNew()) {
                    $affectedRows += $this->aex_name_s3_id->save($con);
                }
                $this->setex_name_s3_id($this->aex_name_s3_id);
            }

            if ($this->aSchedule !== null) {
                if ($this->aSchedule->isModified() || $this->aSchedule->isNew()) {
                    $affectedRows += $this->aSchedule->save($con);
                }
                $this->setSchedule($this->aSchedule);
            }

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

        $this->modifiedColumns[ExerciseTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ExerciseTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ExerciseTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(ExerciseTableMap::COL_EX_NAME_ID)) {
            $modifiedColumns[':p' . $index++]  = '`ex_name_id`';
        }
        if ($this->isColumnModified(ExerciseTableMap::COL_EX_NAME_S2_ID)) {
            $modifiedColumns[':p' . $index++]  = '`ex_name_s2_id`';
        }
        if ($this->isColumnModified(ExerciseTableMap::COL_EX_NAME_S3_ID)) {
            $modifiedColumns[':p' . $index++]  = '`ex_name_s3_id`';
        }
        if ($this->isColumnModified(ExerciseTableMap::COL_DAY)) {
            $modifiedColumns[':p' . $index++]  = '`day`';
        }
        if ($this->isColumnModified(ExerciseTableMap::COL_KIND)) {
            $modifiedColumns[':p' . $index++]  = '`kind`';
        }
        if ($this->isColumnModified(ExerciseTableMap::COL_SERIE)) {
            $modifiedColumns[':p' . $index++]  = '`serie`';
        }
        if ($this->isColumnModified(ExerciseTableMap::COL_REPETITION)) {
            $modifiedColumns[':p' . $index++]  = '`repetition`';
        }
        if ($this->isColumnModified(ExerciseTableMap::COL_DIFFICULTY)) {
            $modifiedColumns[':p' . $index++]  = '`difficulty`';
        }
        if ($this->isColumnModified(ExerciseTableMap::COL_EXEC_WEIGHTS)) {
            $modifiedColumns[':p' . $index++]  = '`exec_weights`';
        }
        if ($this->isColumnModified(ExerciseTableMap::COL_EXEC_TIMES)) {
            $modifiedColumns[':p' . $index++]  = '`exec_times`';
        }
        if ($this->isColumnModified(ExerciseTableMap::COL_PAUSE_TIMES)) {
            $modifiedColumns[':p' . $index++]  = '`pause_times`';
        }
        if ($this->isColumnModified(ExerciseTableMap::COL_SCHEDULE_ID)) {
            $modifiedColumns[':p' . $index++]  = '`schedule_id`';
        }

        $sql = sprintf(
            'INSERT INTO `exercise` (%s) VALUES (%s)',
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
                    case '`ex_name_id`':
                        $stmt->bindValue($identifier, $this->ex_name_id, PDO::PARAM_INT);
                        break;
                    case '`ex_name_s2_id`':
                        $stmt->bindValue($identifier, $this->ex_name_s2_id, PDO::PARAM_INT);
                        break;
                    case '`ex_name_s3_id`':
                        $stmt->bindValue($identifier, $this->ex_name_s3_id, PDO::PARAM_INT);
                        break;
                    case '`day`':
                        $stmt->bindValue($identifier, $this->day, PDO::PARAM_INT);
                        break;
                    case '`kind`':
                        $stmt->bindValue($identifier, $this->kind, PDO::PARAM_INT);
                        break;
                    case '`serie`':
                        $stmt->bindValue($identifier, $this->serie, PDO::PARAM_INT);
                        break;
                    case '`repetition`':
                        $stmt->bindValue($identifier, $this->repetition, PDO::PARAM_STR);
                        break;
                    case '`difficulty`':
                        $stmt->bindValue($identifier, $this->difficulty, PDO::PARAM_INT);
                        break;
                    case '`exec_weights`':
                        $stmt->bindValue($identifier, $this->exec_weights, PDO::PARAM_STR);
                        break;
                    case '`exec_times`':
                        $stmt->bindValue($identifier, $this->exec_times, PDO::PARAM_STR);
                        break;
                    case '`pause_times`':
                        $stmt->bindValue($identifier, $this->pause_times, PDO::PARAM_STR);
                        break;
                    case '`schedule_id`':
                        $stmt->bindValue($identifier, $this->schedule_id, PDO::PARAM_INT);
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
        $pos = ExerciseTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getExNameId();
                break;
            case 2:
                return $this->getExNameS2Id();
                break;
            case 3:
                return $this->getExNameS3Id();
                break;
            case 4:
                return $this->getDay();
                break;
            case 5:
                return $this->getKind();
                break;
            case 6:
                return $this->getSerie();
                break;
            case 7:
                return $this->getRepetition();
                break;
            case 8:
                return $this->getDifficulty();
                break;
            case 9:
                return $this->getExecWeights();
                break;
            case 10:
                return $this->getExecTimes();
                break;
            case 11:
                return $this->getPauseTimes();
                break;
            case 12:
                return $this->getScheduleId();
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

        if (isset($alreadyDumpedObjects['Exercise'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Exercise'][$this->hashCode()] = true;
        $keys = ExerciseTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getExNameId(),
            $keys[2] => $this->getExNameS2Id(),
            $keys[3] => $this->getExNameS3Id(),
            $keys[4] => $this->getDay(),
            $keys[5] => $this->getKind(),
            $keys[6] => $this->getSerie(),
            $keys[7] => $this->getRepetition(),
            $keys[8] => $this->getDifficulty(),
            $keys[9] => $this->getExecWeights(),
            $keys[10] => $this->getExecTimes(),
            $keys[11] => $this->getPauseTimes(),
            $keys[12] => $this->getScheduleId(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aex_name_id) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'exerciseName';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'exercise_name';
                        break;
                    default:
                        $key = 'ex_name_id';
                }

                $result[$key] = $this->aex_name_id->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aex_name_s2_id) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'exerciseName';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'exercise_name';
                        break;
                    default:
                        $key = 'ex_name_s2_id';
                }

                $result[$key] = $this->aex_name_s2_id->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aex_name_s3_id) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'exerciseName';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'exercise_name';
                        break;
                    default:
                        $key = 'ex_name_s3_id';
                }

                $result[$key] = $this->aex_name_s3_id->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aSchedule) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'schedule';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'schedule';
                        break;
                    default:
                        $key = 'Schedule';
                }

                $result[$key] = $this->aSchedule->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\Gym\Exercise
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ExerciseTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Gym\Exercise
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setExNameId($value);
                break;
            case 2:
                $this->setExNameS2Id($value);
                break;
            case 3:
                $this->setExNameS3Id($value);
                break;
            case 4:
                $valueSet = ExerciseTableMap::getValueSet(ExerciseTableMap::COL_DAY);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setDay($value);
                break;
            case 5:
                $valueSet = ExerciseTableMap::getValueSet(ExerciseTableMap::COL_KIND);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setKind($value);
                break;
            case 6:
                $valueSet = ExerciseTableMap::getValueSet(ExerciseTableMap::COL_SERIE);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setSerie($value);
                break;
            case 7:
                $this->setRepetition($value);
                break;
            case 8:
                $this->setDifficulty($value);
                break;
            case 9:
                $this->setExecWeights($value);
                break;
            case 10:
                $this->setExecTimes($value);
                break;
            case 11:
                $this->setPauseTimes($value);
                break;
            case 12:
                $this->setScheduleId($value);
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
        $keys = ExerciseTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setExNameId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setExNameS2Id($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setExNameS3Id($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setDay($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setKind($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setSerie($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setRepetition($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setDifficulty($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setExecWeights($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setExecTimes($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setPauseTimes($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setScheduleId($arr[$keys[12]]);
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
     * @return $this|\Gym\Exercise The current object, for fluid interface
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
        $criteria = new Criteria(ExerciseTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ExerciseTableMap::COL_ID)) {
            $criteria->add(ExerciseTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ExerciseTableMap::COL_EX_NAME_ID)) {
            $criteria->add(ExerciseTableMap::COL_EX_NAME_ID, $this->ex_name_id);
        }
        if ($this->isColumnModified(ExerciseTableMap::COL_EX_NAME_S2_ID)) {
            $criteria->add(ExerciseTableMap::COL_EX_NAME_S2_ID, $this->ex_name_s2_id);
        }
        if ($this->isColumnModified(ExerciseTableMap::COL_EX_NAME_S3_ID)) {
            $criteria->add(ExerciseTableMap::COL_EX_NAME_S3_ID, $this->ex_name_s3_id);
        }
        if ($this->isColumnModified(ExerciseTableMap::COL_DAY)) {
            $criteria->add(ExerciseTableMap::COL_DAY, $this->day);
        }
        if ($this->isColumnModified(ExerciseTableMap::COL_KIND)) {
            $criteria->add(ExerciseTableMap::COL_KIND, $this->kind);
        }
        if ($this->isColumnModified(ExerciseTableMap::COL_SERIE)) {
            $criteria->add(ExerciseTableMap::COL_SERIE, $this->serie);
        }
        if ($this->isColumnModified(ExerciseTableMap::COL_REPETITION)) {
            $criteria->add(ExerciseTableMap::COL_REPETITION, $this->repetition);
        }
        if ($this->isColumnModified(ExerciseTableMap::COL_DIFFICULTY)) {
            $criteria->add(ExerciseTableMap::COL_DIFFICULTY, $this->difficulty);
        }
        if ($this->isColumnModified(ExerciseTableMap::COL_EXEC_WEIGHTS)) {
            $criteria->add(ExerciseTableMap::COL_EXEC_WEIGHTS, $this->exec_weights);
        }
        if ($this->isColumnModified(ExerciseTableMap::COL_EXEC_TIMES)) {
            $criteria->add(ExerciseTableMap::COL_EXEC_TIMES, $this->exec_times);
        }
        if ($this->isColumnModified(ExerciseTableMap::COL_PAUSE_TIMES)) {
            $criteria->add(ExerciseTableMap::COL_PAUSE_TIMES, $this->pause_times);
        }
        if ($this->isColumnModified(ExerciseTableMap::COL_SCHEDULE_ID)) {
            $criteria->add(ExerciseTableMap::COL_SCHEDULE_ID, $this->schedule_id);
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
        $criteria = ChildExerciseQuery::create();
        $criteria->add(ExerciseTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Gym\Exercise (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setExNameId($this->getExNameId());
        $copyObj->setExNameS2Id($this->getExNameS2Id());
        $copyObj->setExNameS3Id($this->getExNameS3Id());
        $copyObj->setDay($this->getDay());
        $copyObj->setKind($this->getKind());
        $copyObj->setSerie($this->getSerie());
        $copyObj->setRepetition($this->getRepetition());
        $copyObj->setDifficulty($this->getDifficulty());
        $copyObj->setExecWeights($this->getExecWeights());
        $copyObj->setExecTimes($this->getExecTimes());
        $copyObj->setPauseTimes($this->getPauseTimes());
        $copyObj->setScheduleId($this->getScheduleId());
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
     * @return \Gym\Exercise Clone of current object.
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
     * Declares an association between this object and a ChildExerciseName object.
     *
     * @param  ChildExerciseName $v
     * @return $this|\Gym\Exercise The current object (for fluent API support)
     * @throws PropelException
     */
    public function setex_name_id(ChildExerciseName $v = null)
    {
        if ($v === null) {
            $this->setExNameId(NULL);
        } else {
            $this->setExNameId($v->getId());
        }

        $this->aex_name_id = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildExerciseName object, it will not be re-added.
        if ($v !== null) {
            $v->addExerciseRelatedByExNameId($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildExerciseName object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildExerciseName The associated ChildExerciseName object.
     * @throws PropelException
     */
    public function getex_name_id(ConnectionInterface $con = null)
    {
        if ($this->aex_name_id === null && ($this->ex_name_id !== null)) {
            $this->aex_name_id = ChildExerciseNameQuery::create()->findPk($this->ex_name_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aex_name_id->addExercisesRelatedByExNameId($this);
             */
        }

        return $this->aex_name_id;
    }

    /**
     * Declares an association between this object and a ChildExerciseName object.
     *
     * @param  ChildExerciseName $v
     * @return $this|\Gym\Exercise The current object (for fluent API support)
     * @throws PropelException
     */
    public function setex_name_s2_id(ChildExerciseName $v = null)
    {
        if ($v === null) {
            $this->setExNameS2Id(NULL);
        } else {
            $this->setExNameS2Id($v->getId());
        }

        $this->aex_name_s2_id = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildExerciseName object, it will not be re-added.
        if ($v !== null) {
            $v->addExerciseRelatedByExNameS2Id($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildExerciseName object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildExerciseName The associated ChildExerciseName object.
     * @throws PropelException
     */
    public function getex_name_s2_id(ConnectionInterface $con = null)
    {
        if ($this->aex_name_s2_id === null && ($this->ex_name_s2_id !== null)) {
            $this->aex_name_s2_id = ChildExerciseNameQuery::create()->findPk($this->ex_name_s2_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aex_name_s2_id->addExercisesRelatedByExNameS2Id($this);
             */
        }

        return $this->aex_name_s2_id;
    }

    /**
     * Declares an association between this object and a ChildExerciseName object.
     *
     * @param  ChildExerciseName $v
     * @return $this|\Gym\Exercise The current object (for fluent API support)
     * @throws PropelException
     */
    public function setex_name_s3_id(ChildExerciseName $v = null)
    {
        if ($v === null) {
            $this->setExNameS3Id(NULL);
        } else {
            $this->setExNameS3Id($v->getId());
        }

        $this->aex_name_s3_id = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildExerciseName object, it will not be re-added.
        if ($v !== null) {
            $v->addExerciseRelatedByExNameS3Id($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildExerciseName object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildExerciseName The associated ChildExerciseName object.
     * @throws PropelException
     */
    public function getex_name_s3_id(ConnectionInterface $con = null)
    {
        if ($this->aex_name_s3_id === null && ($this->ex_name_s3_id !== null)) {
            $this->aex_name_s3_id = ChildExerciseNameQuery::create()->findPk($this->ex_name_s3_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aex_name_s3_id->addExercisesRelatedByExNameS3Id($this);
             */
        }

        return $this->aex_name_s3_id;
    }

    /**
     * Declares an association between this object and a ChildSchedule object.
     *
     * @param  ChildSchedule $v
     * @return $this|\Gym\Exercise The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSchedule(ChildSchedule $v = null)
    {
        if ($v === null) {
            $this->setScheduleId(NULL);
        } else {
            $this->setScheduleId($v->getId());
        }

        $this->aSchedule = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSchedule object, it will not be re-added.
        if ($v !== null) {
            $v->addExercise($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSchedule object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSchedule The associated ChildSchedule object.
     * @throws PropelException
     */
    public function getSchedule(ConnectionInterface $con = null)
    {
        if ($this->aSchedule === null && ($this->schedule_id !== null)) {
            $this->aSchedule = ChildScheduleQuery::create()->findPk($this->schedule_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSchedule->addExercises($this);
             */
        }

        return $this->aSchedule;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aex_name_id) {
            $this->aex_name_id->removeExerciseRelatedByExNameId($this);
        }
        if (null !== $this->aex_name_s2_id) {
            $this->aex_name_s2_id->removeExerciseRelatedByExNameS2Id($this);
        }
        if (null !== $this->aex_name_s3_id) {
            $this->aex_name_s3_id->removeExerciseRelatedByExNameS3Id($this);
        }
        if (null !== $this->aSchedule) {
            $this->aSchedule->removeExercise($this);
        }
        $this->id = null;
        $this->ex_name_id = null;
        $this->ex_name_s2_id = null;
        $this->ex_name_s3_id = null;
        $this->day = null;
        $this->kind = null;
        $this->serie = null;
        $this->repetition = null;
        $this->difficulty = null;
        $this->exec_weights = null;
        $this->exec_times = null;
        $this->pause_times = null;
        $this->schedule_id = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
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
        } // if ($deep)

        $this->aex_name_id = null;
        $this->aex_name_s2_id = null;
        $this->aex_name_s3_id = null;
        $this->aSchedule = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ExerciseTableMap::DEFAULT_STRING_FORMAT);
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
