<?php

namespace tm\helpers;

class CollectionsHelper
{

    public static function collapseArray(array $arr, array $groupElements , array $agregateElements)
    {
        $newArray = [];

        $filterKeys = function($value, $key) use ($groupElements) {

            $okGr = array_search ($key, $groupElements);

            if ($okGr === false) {
                return false;
            }

            return true;
        };



        foreach ($arr as $arrElement) {
            $filtered = array_filter($arrElement, $filterKeys, ARRAY_FILTER_USE_BOTH );

            if (empty($newArray)) {
                self::addElementToFinalArray($arrElement, $newArray, $groupElements,$agregateElements );
                continue;
            }

            $foundedStr = false;
            foreach ($newArray as &$newArrElem) {
                $equalStr = true;
                foreach ($filtered as $key =>$value) {
                    if ($newArrElem[$key] <> $filtered[$key]) {
                        $equalStr = false;
                        break;
                    }
                }

                if ($equalStr === true) {
                    $foundedStr = true;
                    foreach ($agregateElements as $agrKey) {
                        $newArrElem[$agrKey] += $arrElement[$agrKey] ;
                    }
                    break;
                }

            }

            if ($foundedStr === false) { //add new element to final array
                self::addElementToFinalArray($arrElement, $newArray, $groupElements,$agregateElements );
            }
        }

        return $newArray;

    }

    private static function addElementToFinalArray(&$currentElem, &$finalArray, &$groupElements, &$agregateElements)
    {
        $newArrElem = [];

        foreach ($groupElements as $key) {
            $newArrElem[$key] = $currentElem[$key];
        }

        foreach ($agregateElements as $key) {
            $newArrElem[$key] = $currentElem[$key];
        }


        $finalArray[] = $newArrElem;
    }

}