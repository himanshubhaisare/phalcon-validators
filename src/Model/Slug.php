<?php

namespace Sid\Phalcon\Validators\Model;

class Slug extends \Phalcon\Mvc\Model\Validator implements \Phalcon\Mvc\Model\ValidatorInterface
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

        if (!preg_match('/^[a-zA-Z0-9\-]+$/i', $value)) {
            $message = $this->getOption("message");
            if (empty($message)) {
                $message = ":field does not have a valid slug format";
            }

            $replacePairs = [":field" => $field];

            $this->appendMessage(strtr($message, $replacePairs), $field, "Slug");

            return false;
        }

        return true;
    }
}
