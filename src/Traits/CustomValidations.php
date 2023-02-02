<?php

namespace Gregorysouzasilva\LivewireCrud\Traits;

trait CustomValidations
{
    public function getFileValidationRules($rules)
    {
        $rulesArray = explode('|', $rules);
        $extensionsArray = explode(',', $rulesArray[0]);
        $rules = '';
        $rules = 'mimeTypes:' . implode(',', $this->getMimeTypes($extensionsArray));

        if (count($rulesArray) > 1) {
            $rules .= '|' . implode('|', array_slice($rulesArray, 1));
        }
        return $rules;
    }

    public function getMimeTypes($extensionsArray)
    {
        $mimeTypes = [];
        $mimeTypesConfig = config('mimeTypes');
        foreach ($extensionsArray as $extension) {
            $mimeTypes[] = $mimeTypesConfig[$extension];
        }
        return $mimeTypes;
    }
}