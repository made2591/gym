<?php

namespace Gym;

use Gym\Base\Exercise as BaseExercise;

/**
 * Skeleton subclass for representing a row from the 'exercise' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Exercise extends BaseExercise
{

    public function setAll($name_id_1,
                           $name_id_2,
                           $name_id_3,
                           $day,
                           $kind,
                           $serie,
                           $repetition,
                           $difficulty,
                           $exec_weights,
                           $exec_times,
                           $pause_times) {

        $this->setExNameId($name_id_1);
        $this->setExNameS2Id($name_id_2);
        $this->setExNameS3Id($name_id_3);
        $this->setDay($day);
        $this->setKind($kind);
        $this->setSerie($serie);
        $this->setRepetition($repetition);
        $this->setDifficulty($difficulty);
        $this->setExecWeights($exec_weights);
        $this->setExecTimes($exec_times);
        $this->setPauseTimes($pause_times);

        return $this;

    }

}
