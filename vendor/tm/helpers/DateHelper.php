<?php

namespace tm\helpers;

class DateHelper {

    public function validateDate($date, $format = 'Y-m-d H:i:s') {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public static function startOfPeriod($date, $period, $format = 'Y-m-d H:i:s') {

        switch (strtolower($period)) {
            case "day": return self::startOfDay($date, $format);
            case "week": return self::startOfWeek($date, $format);
            case "month": return self::startOfMonth($date, $format);
            case "year": return self::startOfYear($date, $format);
            default: return self::startOfDay($date, $format);
        }
    }

    public static function endOfPeriod($date, $period, $format = 'Y-m-d H:i:s') {

        switch (strtolower($period)) {
            case "day": return self::endOfDay($date, $format);
            case "week": return self::endOfWeek($date, $format);
            case "month": return self::endOfMonth($date, $format);
            case "year": return self::endOfYear($date, $format);
            default: return self::endOfDay($date, $format);
        }
    }

    public static function startOfDay($date, $format = 'Y-m-d H:i:s') {
        $d = \DateTime::createFromFormat($format, $date);
        $d->setTime(0, 0, 0);

        return $d->format($format);
    }

    public static function endOfDay($date, $format = 'Y-m-d H:i:s') {
        $d = \DateTime::createFromFormat($format, $date);
        $d->setTime(23, 59, 59);

        return $d->format($format);
    }

    public static function startOfWeek($date, $format = 'Y-m-d H:i:s') {
        $d = \DateTime::createFromFormat($format, $date);
        $d->setTime(0, 0, 0);
        $d->modify("monday this week");
        return $d->format($format);
    }

    public static function endOfWeek($date, $format = 'Y-m-d H:i:s') {
        $d = \DateTime::createFromFormat($format, $date);
        $d->setTime(0, 0, 0);
        $d->modify("sunday this week");
        return $d->format($format);
    }

    public static function startOfMonth($date, $format = 'Y-m-d H:i:s') {
        $d = \DateTime::createFromFormat($format, $date);
        $d->setTime(0, 0, 0);
        $d->modify("first day of");

        return $d->format($format);
    }

    public static function endOfMonth($date, $format = 'Y-m-d H:i:s') {
        $d = \DateTime::createFromFormat($format, $date);
        $d->setTime(23, 59, 59);
        $d->modify("last day of");

        return $d->format($format);
    }

    public static function startOfYear($date, $format = 'Y-m-d H:i:s') {
        $d = \DateTime::createFromFormat($format, $date);
        $d->setDate($d->format("Y"), 1, 1);
        $d->setTime(0, 0, 0);


        return $d->format($format);
    }

    public static function endOfYear($date, $format = 'Y-m-d H:i:s') {
        $d = \DateTime::createFromFormat($format, $date);
        $d->setDate($d->format("Y"), 12, 31);
        $d->setTime(23, 59, 59);


        return $d->format($format);
    }

    public static function getPeriodFromRequest($request, $paramFrom = 'dateFrom', $paramTo = 'dateTo') {
        $get = $request->get();

        $arrPeriod = [
            'dateFrom' => null,
            'dateTo' => null
        ];

        if (isset($get['dtype'])) {

            if (self::allowedPeriodType($get['dtype'])) {
                if ($get['dtype'] == 'period') {
                    $dateFrom = $get[$paramFrom] ?? null;
                    $dateTo = $get[$paramTo] ?? null;
                    if (!is_null($dateFrom)) {
                        $arrPeriod['dateFrom'] = self::startOfPeriod($dateFrom, "day", 'Y-m-d');
                    }
                    if (!is_null($dateTo)) {
                        $arrPeriod['dateTo'] = self::endOfPeriod($dateTo, "day", 'Y-m-d');
                    }
                } else {

                    $dateFrom = $get[$paramFrom] ?? null;
                    if (!is_null($dateFrom)) {
                        $arrPeriod['dateFrom'] = self::startOfPeriod($dateFrom, $get['dtype'], 'Y-m-d');
                        $arrPeriod['dateTo'] = self::endOfPeriod($dateFrom, $get['dtype'], 'Y-m-d');
                    }
                }
            }
        }

        return $arrPeriod;
    }
    
    public static function getPeriodFromRequestAsInt($request, $paramFrom = 'dateFrom', $paramTo = 'dateTo') {
        $arrayPeriod = self::getPeriodFromRequest($request, $paramFrom, $paramTo);
        if (!is_null($arrayPeriod['dateFrom'])) {
            $arrayPeriod['dateFrom'] = strtotime($arrayPeriod['dateFrom']);    
        }
        
        if (!is_null($arrayPeriod['dateTo'])) {
            $arrayPeriod['dateTo'] = strtotime($arrayPeriod['dateTo']);    
        }
        
        
        return $arrayPeriod;
    }


    public static function allowedPeriodType($type) {
        $allowed = ['period', 'day', 'week', 'month', 'year'];

        return array_search(strtolower($type), $allowed) === false ? false : true;
    }

}
