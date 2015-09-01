<?php

namespace Sid\Phalcon\Validators;

class Slug extends \Phalcon\Validation\Validator
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

        if (!preg_match('/^[a-zA-Z0-9\-]+$/i', $value)) {
            $message = $this->getOption("message");
            if (empty($message)) {
                $message = "Field :field is not in a valid slug format";
            }

            $replacePairs = [":field" => $label];

            $validation->appendMessage(new \Phalcon\Validation\Message(strtr($message, $replacePairs), $field, "Slug"));

            return false;
        }

        return true;
    }
}
