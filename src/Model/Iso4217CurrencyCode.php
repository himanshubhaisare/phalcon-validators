<?php

namespace Sid\Phalcon\Validators\Model;

class Iso4217CurrencyCode extends \Phalcon\Mvc\Model\Validator implements \Phalcon\Mvc\Model\ValidatorInterface
{
    public function validate(\Phalcon\Mvc\EntityInterface $record)
    {
        $field = $this->getOption("field");
        if (!is_string($field)) {
            throw new Exception("Field name must be a string");
        }

        $value = $record->readAttribute($field);
        if ($this->isSetOption("allowEmpty") && empty($value)) {
            return true;
        }

        if (!preg_match('/^[A-Z]{2}$/i', $value)) {
            $message = $this->getOption("message");
            if (empty($message)) {
                $message = "Field :field must be a valid ISO 4217 currency code";
            }

            $replacePairs = [":field" => $field];

            $this->appendMessage(strtr($message, $replacePairs), $field, "Iso4217CurrencyCode");

            return false;
        }

        return true;
    }
}
