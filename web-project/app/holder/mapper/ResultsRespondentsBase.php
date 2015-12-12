<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 12. 12. 2015
 * Time: 15:47
 */

namespace App\Holder\Mapper;


use App\Base\IHolder;
use App\Base\IMapper;

class ResultsRespondentsBase implements IMapper{

    /**
     * @param $result
     * @return IHolder
     */
    public function populate($result) {
        $holder = new \App\Holder\ResultsRespondentsBase();


        if(isset($result["total_male"])){
            $holder->setTotalMale((int)$result["total_male"]);
        }
        if(isset($result["total_female"])){
            $holder->setTotalFemale((int)$result["total_female"]);
        }
        if(isset($result["total_15"])){
            $holder->setTotal15((int)$result["total_15"]);
        }
        if(isset($result["total_15_20"])){
            $holder->setTotal1520((int)$result["total_15_20"]);
        }
        if(isset($result["total_21_30"])){
            $holder->setTotal2130((int)$result["total_21_30"]);
        }
        if(isset($result["total_31_45"])){
            $holder->setTotal3145((int)$result["total_31_45"]);
        }
        if(isset($result["total_46_60"])){
            $holder->setTotal4660((int)$result["total_46_60"]);
        }
        if(isset($result["total_60"])){
            $holder->setTotal60((int)$result["total_60"]);
        }

        if(isset($result["total_gender_unknown"])){
            $holder->setTotalGenderUnknown((int)$result["total_gender_unknown"]);
        }

        if(isset($result["total_age_unknown"])){
            $holder->setTotalAgeUnknown((int)$result["total_age_unknown"]);
        }

        if(isset($result["total_english"])){
            $holder->setTotalEnglish((int)$result["total_english"]);
        }
        if(isset($result["total_it"])){
            $holder->setTotalIt((int)$result["total_it"]);
        }
        if(isset($result["total_computer"])){
            $holder->setTotalComputer((int)$result["total_computer"]);
        }
        if(isset($result["total_tablet"])){
            $holder->setTotalTablet((int)$result["total_tablet"]);
        }
        if(isset($result["total_phone"])){
            $holder->setTotalPhone((int)$result["total_phone"]);
        }

        if(isset($result["total_most_computer"])){
            $holder->setTotalMostComputer((int)$result["total_most_computer"]);
        }
        if(isset($result["total_most_tablet"])){
            $holder->setTotalMostTablet((int)$result["total_most_tablet"]);
        }
        if(isset($result["total_most_phone"])){
            $holder->setTotalMostPhone((int)$result["total_most_phone"]);
        }
        if(isset($result["total_most_device_unknown"])){
            $holder->setTotalMostDeviceUnknown((int)$result["total_most_device_unknown"]);
        }


        return $holder;
    }
}