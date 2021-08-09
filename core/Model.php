<?php

/*
 * Base Model Class
 * General class for loading data and assigining the respective values
 * General class for validating data
 */
namespace app\core;

abstract class Model
{

    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';

    public array $errors = [];

    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if(property_exists($this, $key))
            {
                $this->{$key} = $value;
            }
        }
    }

    /*
     * Created an abstract function rules that must be implemented in the child classes
     */
    abstract public function rules() : array;

    /*
     * Validate function that is used to loop through the various rules in the model being used,
     * It the checks the rule against the value to see if the condition is met, if not an error is added
     * to the array, if all conditions are met, the validate function returns true, i.e the errors array is empty
     */
    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules) {

            $value = $this->{$attribute};

            foreach ($rules as $rule) {
                $ruleName = $rule;
                if(!is_string($rule))
                {
                    $ruleName = $rule[0];
                }

                if($ruleName === self::RULE_REQUIRED && !$value)
                {
                    $this->addErrors($attribute, self::RULE_REQUIRED);
                }

                if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL))
                {
                    $this->addErrors($attribute, self::RULE_EMAIL);
                }

                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']})
                {
                    $this->addErrors($attribute, self::RULE_MATCH);
                }

                if($ruleName === self::RULE_UNIQUE)
                {
                    $className = $rule['class'];
                    $tableName = $className::tableName();
                    $uniqueAttr = $rule['attr'] ?? $attribute;

                    $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                    $statement->bindValue(":attr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();

                    if($record)
                    {
                        $this->addErrors($uniqueAttr, self::RULE_UNIQUE);
                    }

                }

            }
        }

        return empty($this->errors);

    }

    public function addErrors(string $attribute, string $rule)
    {
        $msg = $this->getMessage()[$rule] ?? "";
        $this->errors[$attribute][] = $msg;
    }

    public function getMessage(): array
    {
        return [
            self::RULE_REQUIRED => 'This Field is required',
            self::RULE_EMAIL => 'Please input valid email address',
            self::RULE_MATCH => 'The Passwords must match',
            self::RULE_UNIQUE => 'This record exists in the database',

        ];
    }

    public function getErrors($attr){
        $errors = $this->errors[$attr] ?? [];

        foreach ($errors as $error) {
            return $error;
        }
    }



}