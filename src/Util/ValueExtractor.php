<?php

namespace Devster\CmsBundle\Util;

class ValueExtractor
{
    static public function extractValue(mixed $data, string|\Closure $getter)
    {
        if ($getter instanceof \Closure) {
            return $getter($data);
        }

        if (is_array($data)) {
            if (!isset($data[$getter])) {
                throw new \RuntimeException('Brak pola: ' . $getter);
            }

            return $data[$getter];
        }

        $getterName = ucfirst($getter);
        $getters = [
            "get{$getterName}",
            "is{$getterName}"
        ];

        foreach ($getters as $possibleGetter) {
            if (method_exists($data, $possibleGetter)) {
                return $data->$possibleGetter();
            }
        }

        throw new \RuntimeException('Brak gettera dla pola: ' . $getter);
    }
}