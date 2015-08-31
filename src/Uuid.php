<?php

namespace Sid\Phalcon\Validators;

class Uuid extends \Phalcon\Validation\Validator
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

        if (!preg_match("/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[1-5][A-Z0-9]{3}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/i", $value)) {
            $message = $this->getOption("message");
            if (empty($message)) {
                $message = "Field :field must be a valid UUID";
            }

            $replacePairs = [":field" => $label];

            $validation->appendMessage(new \Phalcon\Validation\Message(strtr($message, $replacePairs), $field, "Uuid"));

            return false;
        }

        $allowedVersions = $this->getOption("allowedVersions");
        if (empty($allowedVersions)) {
            $allowedVersions = [1, 2, 3, 4, 5];
        }

        if (!in_array(substr($value, 14, 1), $allowedVersions)) {
            $message = $this->getOption("messageVersion");
            if (empty($message)) {
                $message = "Field :field must be one of the following UUID versions: :versions";
            }

            $replacePairs = [":field" => $label, ":versions" => implode(", ", $allowedVersions)];

            $validation->appendMessage(new \Phalcon\Validation\Message(strtr($message, $replacePairs), $field, "Uuid"));

            return false;
        }

        return true;
    }
}
