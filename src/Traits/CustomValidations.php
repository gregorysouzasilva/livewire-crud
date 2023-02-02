<?php

namespace Gregorysouzasilva\LivewireCrud\Traits;

trait CustomValidations
{
    public function getFileValidationRules($rules)
    {
        $rulesArray = explode('|', $rules);
        $extensionsArray = explode(',', $rulesArray[0]);
        $rules = '';
        if (count($extensionsArray) > 1 && in_array('docx', $extensionsArray)) {
           // throw exception not allowed docx with other extensions
           throw('not allowed docx with other extensions');
        } elseif (in_array('docx', $extensionsArray)) {
            $rules = 'mimetypes:application/vnd.openxmlformats-officedocument.wordprocessingml.documentapplication/vnd.openxmlformats-officedocument.wordprocessingml.document';
        } else {
            $rules = 'mimes:' . implode(',', $extensionsArray);
        }
        if (count($rulesArray) > 1) {
            $rules .= '|' . implode('|', array_slice($rulesArray, 1));
        }
        return $rules;
    }
}