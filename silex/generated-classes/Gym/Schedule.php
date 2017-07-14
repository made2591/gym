<?php

namespace Gym;

use Gym\Base\Schedule as BaseSchedule;

/**
 * Skeleton subclass for representing a row from the 'schedule' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Schedule extends BaseSchedule {

    public function getTrainings() {

        $trainings = array();
        $exs = $this->getExercises();
        foreach ($exs as $k => $ex) {
            $trainings[$ex->getDay()] = array();
        }
        foreach ($trainings as $day => $training) {
            foreach ($exs as $k => $ex) {
                if ($ex->getDay() == $day)
                    $trainings[$day][] = $ex;
            }
        }
        return $trainings;
    }

}