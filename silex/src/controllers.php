<?php

// setup the autoloading
require_once '../vendor/autoload.php';

// setup Propel
require_once '../generated-conf/config.php';

use Gym\Schedule;
use Gym\Exercise;
use Gym\ExerciseName;
use Symfony\Component\HttpFoundation\Request;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$defaultLogger = new Logger('defaultLogger');
$defaultLogger->pushHandler(new StreamHandler('/var/log/propel.log', Logger::WARNING));

$serviceContainer->setLogger('defaultLogger', $defaultLogger);

$app['asset_path'] = 'http://localhost:8001/';

/**
 * Questo restituisce una lista di elementi
 */
$app->get('/list/{type}/', function($type) use ($app) {

    return $app->redirect('/list/'.$type."/1");

});

$app->get('/list/{type}/{pagenumber}', function($type, $pagenumber) use ($app) {

    $datas = array();

    if($type == 'exercise') {

        $datas['type'] = 'exercise';
        $datas['exercises'] = \Gym\ExerciseNameQuery::create()->orderByName(\Propel\Runtime\ActiveQuery\Criteria::ASC)->paginate($page = $pagenumber, $maxPerPage = 15);
        $datas['actualpage'] = $pagenumber;
        $datas['lastpage'] = $datas['exercises']->getLastPage();

    } else if($type == 'musclegroup') {

        $datas['type'] = 'musclegroup';
        $muscle_group = [0 => 'Gambe',
            1 => 'Polpacci',
            2 => 'Addome',
            3 => 'Bicipiti',
            4 => 'Tricipiti',
            5 => 'Dorsali',
            6 => 'Pettorali',
            7 => 'Cardio',
            8 => 'Spalle'];
        $datas['musclegroup'] = $muscle_group;

    } else if($type == 'schedule') {

        $datas['type'] = 'schedule';
        $datas['schedules'] = \Gym\ScheduleQuery::create()->orderById(\Propel\Runtime\ActiveQuery\Criteria::ASC)->paginate($page = $pagenumber, $maxPerPage = 5);
        $datas['actualpage'] = $pagenumber;
        $datas['lastpage'] = $datas['schedules']->getLastPage();

    } else if($type == 'scheduletrainings') {

        $datas['type'] = 'scheduletrainings';
        $schedule = \Gym\ScheduleQuery::create()->findOneById($pagenumber);
        $datas['exercises'] = $schedule->getExercises();
        $datas['trainings'] = $schedule->getTrainings();

    } else {
        return $app['twig']->render(
            'error.html.twig'
        );
    }
    return $app['twig']->render(
        'list.html.twig',
        $datas
    );

});

$app->post('/listexnames', function(Request $request) use ($app) {

    $all_ex = array();
    $muscle_group = [0 => 'Gambe',
                     1 => 'Polpacci',
                     2 => 'Addome',
                     3 => 'Bicipiti',
                     4 => 'Tricipiti',
                     5 => 'Dorsali',
                     6 => 'Pettorali',
                     7 => 'Cardio',
                     8 => 'Spalle'];

    $exs = \Gym\ExerciseNameQuery::create()->orderByName()->find();
    foreach($muscle_group as $key => $val) {
        $all_ex[$val] = array();
        foreach ($exs as $exkey => $ex) {
            if($ex->getMuscleGroup() == $val) {
                $all_ex[$val][count($all_ex[$val])] = $ex->toArray();
            }
        }
    }

    return json_encode($all_ex);

});

$app->post('/insertion', function(Request $request) use ($app) {

    $datas = array();

    $type = $request->request->get('type');

    if ($type == 'exercise_name') {

        $ex_name = new ExerciseName();
        $ex_name->setName($request->request->get('name'));
        $ex_name->setMuscleGroup($request->request->get('group'));
        $ex_name->save();

        return \Gym\ExerciseNameQuery::create()->find()->toJSON();

    } else if ($type == 'schedule') {

        $datas['type'] = 'schedule';

        $sc = new \Gym\Schedule();
        $sc->setFrom(\Propel\Runtime\Util\PropelDateTime::createFromFormat('j / m / Y', $request->request->get('from')));
        $sc->setTo(\Propel\Runtime\Util\PropelDateTime::createFromFormat('j / m / Y', $request->request->get('to')));
        $sc->setName('Scheda');
        $sc->save();

        foreach ($request->request->get('exercises') as $ex_number => $ex_dict) {

            $ex = new Exercise();
            foreach ($ex_dict as $key => $val) {
                echo $key . " => " . $val;
                if ($key == 'name') $ex->setExNameId($val);
                if ($key == 'name_2' && $val != -1) $ex->setExNameS2Id($val);
                if ($key == 'name_3' && $val != -1) $ex->setExNameS3Id($val);
                if ($key == 'day') $ex->setDay($val);
                if ($key == 'kind' && $val != "") $ex->setKind($val);
                if ($key == 'difficulty' && $val != "") $ex->setDifficulty($val);
                if ($key == 'serie' && $val != "") $ex->setSerie($val);
                if ($key == 'repetition' && $val != "") $ex->setRepetition($val);
                if ($key == 'pauses' && $val != "") $ex->setPauseTimes($val);
                if ($key == 'execs' && $val != "") $ex->setExecTimes($val);
                if ($key == 'weights' && $val != "") $ex->setExecWeights($val);
                $sc->addExercise($ex);
            }
            $ex->save();
        }
        return $sc->getId();

    } else {
        return $app['twig']->render(
            'error.html.twig'
        );
    }
});


$app->get('/insert/{type}/', function($type) use ($app) {

    $datas = array();

    $datas['type'] = 'schedule';
    $muscle_group = [0 => 'Gambe',
        1 => 'Polpacci',
        2 => 'Addome',
        3 => 'Bicipiti',
        4 => 'Tricipiti',
        5 => 'Dorsali',
        6 => 'Pettorali',
        7 => 'Cardio',
        8 => 'Spalle'];

    $datas['muscle_groups'] = $muscle_group;
    $datas['exercises'] = \Gym\ExerciseQuery::create()->find();
    $datas['exercise_names'] = \Gym\ExerciseNameQuery::create()->find();

//    $sc = new \Gym\Schedule();
//    $sc->setName('Scheda '.$sc->getId());
//    $sc->save();
//    $datas['schedule_id'] = $sc->getId();

    return $app['twig']->render(
        'insert.html.twig',
        $datas
    );

});


$app->get('/fixture/', function() use ($app) {
    $infos = array( 'Chest press impugnatura bassa' => 'Pettorali',
                    'Cross over cavi' => 'Pettorali',
                    'Croci panca 30°' => 'Pettorali',
                    'Croci panca 45°' => 'Pettorali',
                    'Panca piana multipower' => 'Pettorali',
                    'Panca piana bilanciere' => 'Pettorali',
                    'Panca inclinata' => 'Pettorali',
                    'Panca inclinata 45° 2 manubri' => 'Pettorali',
                    'Panca inclinata bilanciere' => 'Pettorali',
                    'Spinte 2 manubri panca 30°' => 'Pettorali',
                    'Spinte 2 manubri panca 45°' => 'Pettorali',
                    'Pectoral' => 'Pettorali',
                    'Parallele pettorali' => 'Pettorali',
                    'Rematore 1 manubrio' => 'Dorsali',
                    'Lat machine avanti' => 'Dorsali',
                    'Lat machine dietro' => 'Dorsali',
                    'Lat machine presa inversa' => 'Dorsali',
                    'Hyper extension' => 'Dorsali',
                    'Pulldown' => 'Dorsali',
                    'Pulley' => 'Dorsali',
                    'Low row' => 'Dorsali',
                    'Easy power avanti' => 'Dorsali',
                    'Arm curl' => 'Bicipiti',
                    'Curl a martello' => 'Bicipiti',
                    'Curl al cavo basso' => 'Bicipiti',
                    'Curl panca scott' => 'Bicipiti',
                    'Curl panca 45°' => 'Bicipiti',
                    'Curl bilanciere' => 'Bicipiti',
                    'Curl bilanciere dritto' => 'Bicipiti',
                    'Curl bilanciere in piedi' => 'Bicipiti',
                    'Curl di concentrazione' => 'Bicipiti',
                    'Curl 2 manubri seduto' => 'Bicipiti',
                    'Curl 2 manubri alternato' => 'Bicipiti',
                    'Curl alla macchina' => 'Bicipiti',
                    'Panca piana gomiti stretti' => 'Tricipiti',
                    'Push down con sbarra dritta' => 'Tricipiti',
                    'Push down con corda' => 'Tricipiti',
                    'Push down' => 'Tricipiti',
                    'French press panca piana' => 'Tricipiti',
                    'French press sopra la testa' => 'Tricipiti',
                    'French press panca 30°' => 'Tricipiti',
                    'French press panca 60°' => 'Tricipiti',
                    'Kick back 1 manubrio' => 'Tricipiti',
                    '1 manubrio sopra la testa' => 'Tricipiti',
                    'Parallele tricipiti' => 'Tricipiti',
                    'Panchette' => 'Tricipiti',
                    'Alzate frontali' => 'Spalle',
                    'Alzate laterali' => 'Spalle',
                    'Lento 2 manubri' => 'Spalle',
                    'Lento avanti multypower' => 'Spalle',
                    'Lento dietro multypower' => 'Spalle',
                    'Fly' => 'Spalle',
                    'Upper back' => 'Spalle',
                    'Upper back seggiolino basso' => 'Spalle',
                    'Shoulder press' => 'Spalle',
                    'Shoulder press impugnatura frontale' => 'Spalle',
                    'Tirate al mento' => 'Spalle',
                    'Cyclette (forte)' => 'Gambe',
                    'Cyclette frontale (forte)' => 'Gambe',
                    'Pressa' => 'Gambe',
                    'Leg curl' => 'Gambe',
                    'Leg extension' => 'Gambe',
                    'Adduttori' => 'Gambe',
                    'Affondi' => 'Gambe',
                    'Affondi bilanciere' => 'Gambe',
                    'Squat' => 'Gambe',
                    'Squat multy' => 'Gambe',
                    'Calf pressa' => 'Polpacci',
                    'Calf in piedi' => 'Polpacci',
                    'Chiusure a libro' => 'Addome',
                    'Crunch' => 'Addome',
                    'Crunch alla macchina' => 'Addome',
                    'Crunch per obliqui' => 'Addome',
                    'Sit up inverso' => 'Addome',
                    'Torsioni con bastone' => 'Addome',
                    'Reverse crunches' => 'Addome',
                    'Twist su fitball' => 'Addome',
                    'Corsa' => 'Cardio',
                    'Camminata veloce' => 'Cardio',
                    'Camminata in salita' => 'Cardio',
                    'Vario' => 'Cardio',
                    'Cyclette (piano)' => 'Cardio',
                    'Cyclette frontale (piano)' => 'Cardio',
                    'Cyclette a mano' => 'Cardio'
    );

    foreach($infos as $exname => $exgroup) {
        $exn = new ExerciseName();
        $exn->setName($exname);
        $exn->setMuscleGroup($exgroup);
        $exn->save();
    }

    $scs_date = [1 => '22 / 10 / 2011',
                 2 => '26 / 02 / 2012',
                 3 => '15 / 10 / 2012',
                 4 => '04 / 03 / 2013',
                 5 => '07 / 10 / 2013',
                 6 => '03 / 03 / 2014',
                 7 => '21 / 10 / 2014'];

    foreach($scs_date as $sc_number => $sc_date) {

        $sc = new Schedule();
        $sc->setFrom(\Propel\Runtime\Util\PropelDateTime::createFromFormat('j / m / Y', $sc_date));
        if ($sc_number < count($scs_date)) {
            $sc->setTo(\Propel\Runtime\Util\PropelDateTime::createFromFormat('j / m / Y', $scs_date[$sc_number + 1]));
        }
        else {
            $sc->setTo(\Propel\Runtime\Util\PropelDateTime::createFromFormat('j / m / Y', '21 / 10 / 2015'));
        }
        $sc->setName('Scheda '.$sc_number);

        switch($sc_number) {
            case 1:
                // giorno 1
                // pettorali
                $ex = new Exercise();
                $ex = $ex->setAll(9, null, null, 1, 'Normale', 4, 12, 3, '', '', '');
                $sc->addExercise($ex);

                $ex = new Exercise();
                $ex->setAll(6, null, null, 1, 'Normale', 3, 8, 3, '', '', '');
                $sc->addExercise($ex);

                $ex = new Exercise();
                $ex->setAll(12, null, null, 1, 'Normale', 4, 15, 3, '', '', '');
                $sc->addExercise($ex);

                // bicipiti
                $ex = new Exercise();
                $ex->setAll(32, null, null, 1, 'Normale', 3, 12, 3, '', '', '');
                $sc->addExercise($ex);

                $ex = new Exercise();
                $ex->setAll(30, null, null, 1, 'Normale', 4, 8, 3, '', '', '');
                $sc->addExercise($ex);

                $ex = new Exercise();
                $ex->setAll(26, null, null, 1, 'Piramidale', 3, '10-12-15', 3, '', '', '');
                $sc->addExercise($ex);

                // gambe
                $ex = new Exercise();
                $ex->setAll(62, null, null, 1, 'Normale', 5, 10, 3, '', '', '');
                $sc->addExercise($ex);

                $ex = new Exercise();
                $ex->setAll(63, null, null, 1, 'Normale', 4, 15, 3, '', '', '');
                $sc->addExercise($ex);

                // giorno 2
                // dorsali
                $ex = new Exercise();
                $ex->setAll(15, null, null, 2, 'Normale', 4, 10, 3, '', '', '');
                $sc->addExercise($ex);

                $ex = new Exercise();
                $ex->setAll(20, null, null, 2, 'Normale', 4, 15, 3, '', '', '');
                $sc->addExercise($ex);

                $ex = new Exercise();
                $ex->setAll(21, null, null, 2, 'Normale', 4, 12, 3, '', '', '');
                $sc->addExercise($ex);

                // tricipiti
                $ex = new Exercise();
                $ex->setAll(35, null, null, 2, 'Piramidale', 4, '12-10-8-8', 3, '', '', '');
                $sc->addExercise($ex);

                $ex = new Exercise();
                $ex->setAll(39, null, null, 2, 'Normale', 3, 10, 3, '', '', '');
                $sc->addExercise($ex);

                $ex = new Exercise();
                $ex->setAll(37, null, null, 2, 'Piramidale', 3, '10-12-15', 3, '', '', '');
                $sc->addExercise($ex);

                // giorno 3
                // gambe
                $ex = new Exercise();
                $ex->setAll(60, null, null, 3, 'Normale', 4, 15, 3, '', '', '');
                $sc->addExercise($ex);

                $ex = new Exercise();
                $ex->setAll(62, null, null, 3, 'Normale', 3, 10, 3, '', '', '');
                $sc->addExercise($ex);

                $ex = new Exercise();
                $ex->setAll(61, null, null, 3, 'Normale', 3, 15, 3, '', '', '');
                $sc->addExercise($ex);

                // polpacci
                $ex = new Exercise();
                $ex->setAll(69, null, null, 3, 'Normale', 4, 20, 3, '', '', '');
                $sc->addExercise($ex);

                // spalle
                $ex = new Exercise();
                $ex->setAll(56, null, null, 3, 'Normale', 4, 8, 3, '', '', '');
                $sc->addExercise($ex);

                $ex = new Exercise();
                $ex->setAll(49, null, null, 3, 'Normale', 3, 12, 3, '', '', '');
                $sc->addExercise($ex);

                $ex = new Exercise();
                $ex->setAll(48, null, null, 3, 'Normale', 4, 15, 3, '', '', '');
                $sc->addExercise($ex);

                // addome
                $ex = new Exercise();
                $ex->setAll(74, null, null, 3, 'Piramidale', 4, '15-15-20-20', 3, '', '', '');
                $sc->addExercise($ex);

                $ex = new Exercise();
                $ex->setAll(72, null, null, 3, 'Normale', 3, 25, 3, '', '', '');
                $sc->addExercise($ex);

                $sc->save();

                break;

            case 2:

                break;
            case 3:

                break;
            case 4:

                break;
            case 5:

                break;
            case 6:

                break;
            case 7:

                break;
        }

    }

    return $app->redirect('/');

});

$app->get('/base/', function() use ($app) {
    return $app['twig']->render(
        'base.html.twig'
    );
});

$app->get('/', function() use ($app) {
    return $app['twig']->render(
        'home.html.twig'
    );
});