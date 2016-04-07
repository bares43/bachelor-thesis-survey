<?php
namespace App\Utils;
use App\Model\EntityCategory;
use App\Model\RespondentWebsite;

/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 12. 12. 2015
 * Time: 22:19
 */
class Respondent {

    /**
     * @param string $age
     * @return int
     */
    public static function getAgeSortValue($age) {
        switch($age){
            case \App\Model\Respondent::AGE_15: return 1;
            case \App\Model\Respondent::AGE_15_20: return 2;
            case \App\Model\Respondent::AGE_21_30: return 3;
            case \App\Model\Respondent::AGE_31_45: return 4;
            case \App\Model\Respondent::AGE_46_60: return 5;
            case \App\Model\Respondent::AGE_60: return 6;
            default: return 0;
        }
    }

    /**
     * @param string $age
     * @return string
     */
    public static function getAgeLabel($age) {
        switch($age){
            case \App\Model\Respondent::AGE_15: return "< 15";
            case \App\Model\Respondent::AGE_15_20: return "15-21";
            case \App\Model\Respondent::AGE_21_30: return "21-30";
            case \App\Model\Respondent::AGE_31_45: return "31-45";
            case \App\Model\Respondent::AGE_46_60: return "46-60";
            case \App\Model\Respondent::AGE_60: return "> 60";
            default: return "";
        }
    }

    /**
     * @param string $gender
     * @return string
     */
    public static function getGenderLabel($gender) {
        switch($gender){
            case \App\Model\Respondent::GENDER_FEMALE: return "žena";
            case \App\Model\Respondent::GENDER_MALE: return "muž";
            default: return "";
        }
    }

    /**
     * @param int $period
     * @return string
     */
    public static function getRespondentWebsitePeriodLabel($period) {
        switch($period){
            case RespondentWebsite::PERIOD_DONT_KNOW: return "neznám";
            case RespondentWebsite::PERIOD_KNOW_AND_VISIT: return "znám a navštěvuji";
            case RespondentWebsite::PERIOD_KNOW_THAT_EXISTS: return "vím, že existuje";
            default: return "";
        }
    }

    /**
     * @param bool $computer
     * @param bool $phone
     * @param bool $tablet
     * @return string
     */
    public static function getRespondentDevices($computer, $phone, $tablet) {
        $devices = array();
        if($computer) $devices[] = \App\Model\Respondent::DEVICE_COMPUTER;
        if($phone) $devices[] = \App\Model\Respondent::DEVICE_PHONE;
        if($tablet) $devices[] = \App\Model\Respondent::DEVICE_TABLET;

        return implode(" / ", $devices);
    }

    public static function getRespondentCategoryPeriodLabel($period) {
        switch($period){
            case EntityCategory::PERIOD_NEVER: return "vůbec";
            case EntityCategory::PERIOD_DAILY: return "denně";
            case EntityCategory::PERIOD_FEW_TIMES_A_WEEK: return "několikrát týdně";
            case EntityCategory::PERIOD_FEW_TIMES_A_MONTH: return "několikrát měsíčně";
            case EntityCategory::PERIOD_FEW_TIMES_A_YEAR: return "něklikrát ročně";
            case EntityCategory::MOSTLY: return "nejvíce";
        }
    }
}