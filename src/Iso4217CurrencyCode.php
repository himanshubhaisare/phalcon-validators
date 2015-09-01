<?php

namespace Sid\Phalcon\Validators;

class Iso4217CurrencyCode extends \Phalcon\Validation\Validator
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

        if (!preg_match("/^[A-Z]{3}$/i", $value)) {
            $message = $this->getOption("message");
            if (empty($message)) {
                $message = "Field :field must be a valid ISO 4217 currency code";
            }

            $replacePairs = [":field" => $label];

            $validation->appendMessage(new \Phalcon\Validation\Message(strtr($message, $replacePairs), $field, "Iso4217CurrencyCode"));

            return false;
        }

        return true;
    }
}
