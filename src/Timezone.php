<?php

namespace Sid\Phalcon\Validators;

class Timezone extends \Phalcon\Validation\Validator
{
    public function validate(\Phalcon\Validation $validation, $field)
    {
        if (!is_string($field)) {
            throw new \Phalcon\Validation\Exception("Field name must be a string");
        }

        $label = $this->getOption("label");
        if (empty($label)) {
            $label = $validation->getLabel($field);
        }

        $value = $validation->getValue($field);
        if ($this->isSetOption("allowEmpty") && empty($value)) {
            return true;
        }

        if (!in_array($value, \DateTimeZone::listIdentifiers())) {
            $message = $this->getOption("message");
            if (empty($message)) {
                $message = "Field :field is not a valid timezone";
            }

            $replacePairs = [":field" => $label];

            $validation->appendMessage(new \Phalcon\Validation\Message(strtr($message, $replacePairs), $field, "Timezone"));

            return false;
        }

        return true;
    }
}
