<?php

namespace Sid\Phalcon\Validators;

class Hostname extends \Phalcon\Validation\Validator
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

        // http://stackoverflow.com/questions/1418423/the-hostname-regex
        if (!preg_match('/^(?=.{1,255}$)[0-9A-Za-z](?:(?:[0-9A-Za-z]|-){0,61}[0-9A-Za-z])?(?:\.[0-9A-Za-z](?:(?:[0-9A-Za-z]|-){0,61}[0-9A-Za-z])?)*\.?$/', $value)) {
            $message = $this->getOption("message");
            if (empty($message)) {
                $message = "Field :field is not a valid hostname";
            }

            $replacePairs = [":field" => $label];

            $validation->appendMessage(new \Phalcon\Validation\Message(strtr($message, $replacePairs), $field, "Hostname"));

            return false;
        }

        return true;
    }
}
