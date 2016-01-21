<?php

namespace Sid\Phalcon\Validators\Model;

class Hostname extends \Phalcon\Mvc\Model\Validator implements \Phalcon\Mvc\Model\ValidatorInterface
{
    /**
     * @param \Phalcon\Mvc\EntityInterface $record
     *
     * @return boolean
     *
     * @throws \Phalcon\Validation\Exception
     */
    public function validate(\Phalcon\Mvc\EntityInterface $record)
    {
        $field = $this->getOption("field");
        if (!is_string($field)) {
            throw new \Phalcon\Validation\Exception("Field name must be a string");
        }

        $value = $record->readAttribute($field);
        if ($this->isSetOption("allowEmpty") && empty($value)) {
            return true;
        }

        // http://stackoverflow.com/questions/1418423/the-hostname-regex
        if (!preg_match('/^(?=.{1,255}$)[0-9A-Za-z](?:(?:[0-9A-Za-z]|-){0,61}[0-9A-Za-z])?(?:\.[0-9A-Za-z](?:(?:[0-9A-Za-z]|-){0,61}[0-9A-Za-z])?)*\.?$/', $value)) {
            $message = $this->getOption("message");
            if (empty($message)) {
                $message = "Field :field is not have a valid hostname";
            }

            $replacePairs = [":field" => $field];

            $this->appendMessage(strtr($message, $replacePairs), $field, "Hostname");

            return false;
        }

        return true;
    }
}
