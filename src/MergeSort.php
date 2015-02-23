<?php

namespace League\Event;

class MergeSort
{
    /**
     * Performs a merge sort based on the provided comparing function. This sort is stable, unlike PHP's built-in
     * usort which is unstable since PHP 4.1.0. This means that if two elements in the array evaluate as equivalent, the
     * one that was originally first in the unsorted array will remain first in the sorted array.
     *
     * @param array &$array Array to sort
     * @param callable $comparitor Function to do comparison
     *
     * @return void
     */
    public static function sort(&$array, $comparitor = 'strcmp')
    {
        // Arrays of size < 2 require no action.
        if (count($array) < 2) {
            return;
        }

        // Split the array in half
        $halfway = (int) (count($array) / 2);
        $array1  = array_slice($array, 0, $halfway);
        $array2  = array_slice($array, $halfway);

        // Recurse to sort the two halves
        static::sort($array1, $comparitor);
        static::sort($array2, $comparitor);

        // If all of $array1 is <= all of $array2, just append them.
        if (call_user_func($comparitor, end($array1), $array2[0]) < 1) {
            $array = array_merge($array1, $array2);
            return;
        }

        // Merge the two sorted arrays into a single sorted array
        $array = array();
        $ptr1 = $ptr2 = 0;
        while ($ptr1 < count($array1) && $ptr2 < count($array2)) {
            if (call_user_func($comparitor, $array1[$ptr1], $array2[$ptr2]) < 1) {
                $array[] = $array1[$ptr1++];
            } else {
                $array[] = $array2[$ptr2++];
            }
        }
        // Merge the remainder
        while ($ptr1 < count($array1)) {
            $array[] = $array1[$ptr1++];
        }
        while ($ptr2 < count($array2)) {
            $array[] = $array2[$ptr2++];
        }
        return;
    }
}
