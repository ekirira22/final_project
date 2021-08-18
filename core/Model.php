<?php

/*
 * Base Model Class
 * General class for loading data and assigining the respective values
 * General class for validating data
 */
namespace app\core;
/*
 * Model class is abstract since nothing inside here changes. It remains the same throughout the project
 */
abstract class Model
{

    /*
     * We declare the rule constants that will be implemented and assigned to the respective attributes within the child
     * classes
     */
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';
    public const RULE_VALID_START_DATE = 'valid_start_date';
    public const RULE_VALID_END_DATE = 'valid_end_date';


    /* An empty array $errors that receives any error thrown within the validate() function */
    public array $errors = [];

    /*
     * Public function loadData that receives an array $data which comes from a getBody() function that is passed
     * from any of the active controllers. It takes the array and loops through it. It then checks if the property
     * corresponding to that key exists in the active model it was called from, assign the $value (from user input)
     * to that property that exists
     */
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
     * to the errors [] array, if all conditions are met, the validate function returns true,
     * i.e the errors array is empty
     */
    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules) {

            $value = $this->{$attribute};
            //We loop twice because some rules have array rules within them
            foreach ($rules as $rule) {
                /* If $rule is a string take the $rule and assign it to to $ruleName*/
                $ruleName = $rule;
                /* If $rule is  not a string i.e an array, take the first element of the array i.e.
                 *$rule[0] and assign it to to $ruleName
                 */
                if(!is_string($rule))
                {
                    $ruleName = $rule[0];
                }
                /*
                 * If any attribute has a rule required and no value exists, add an error to the
                 * errors array and pass the attribute and the rule as parameters to the addErrors function
                 */
                if($ruleName === self::RULE_REQUIRED && !$value)
                {
                    $this->addErrors($attribute, self::RULE_REQUIRED);
                }
                /*
                 * If any attribute has a rule email and the value does not pass as valid email, add to the
                 * errors array and pass the attribute and the rule as parameters to the addErrors function
                 */

                if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL))
                {
                    $this->addErrors($attribute, self::RULE_EMAIL);
                }

                /*
                 * If any attribute has a rule match and the value does not match with the value passed
                 * in the rule array where this rule is found i.e $this->{$rule['match']} which corresponds
                 * to password, so in short, $this->password, if they don't match add error to the
                 * errors array and pass the attribute and the rule as parameters to the addErrors function
                 */

                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']})
                {
                    $this->addErrors($attribute, self::RULE_MATCH);
                }

                /*
                 * This control structure if the user input is unique to the database. If it is not,
                 * it adds an error to the errors array and pass the attribute and
                 * the rule as parameters to the addErrors function
                 * The model class that returns the unique set of rules also returns the tableName and the attributes
                 * (column names in db) specific to that model class
                 * The unique rule is rendered differently to cater for various classes, an array with the unique
                 * rule passed along with the self::class that calls the active model class which extends to model
                 * and attr is also passed along withe corresponding attribute (this is optional)
                 *
                 */

                if($ruleName === self::RULE_UNIQUE)
                {
                    /*
                     * Here, the active class is gotten along with the tablename and attribute which we
                     * call uniqueAttr specific to the active model class
                     */
                    $className = $rule['class'];
                    $tableName = $className::tableName();
                    $uniqueAttr = $rule['attr'] ?? $attribute;

                    /*
                     * We prepare a statement that selects all from the tablename gotten where uniqueAttr
                     * is typed param :attr (to avoid sql injection)
                     * :attr is bound to $value which is the user input (remember data was loaded before
                     * passing it through the validate() function) and executed and object of the result is fetched
                     */

                    $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                    $statement->bindValue(":attr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();

                    /*
                     * If a record exists, add an Error, if not it returns true
                     */
                    if($record)
                    {
                        $this->addErrors($uniqueAttr, self::RULE_UNIQUE);
                    }

                }
                /*
                 * Added a rule valid start date and valid end date that check if the start date is before
                 * the current date and if the end date is before the start date of the project
                 * If the rule name has valid_start_date and the value is before (here we use < )
                 * the date of today which is passed as a corresponding value of start_date in the
                 * RULE_VALID_START_DATE array that is passed. Then add an error for the corresponding
                 * attribute and rule passing them as arguments in the addErrors function
                 */

                if ($ruleName === self::RULE_VALID_START_DATE && $value < $rule['start_date'])
                {
                    $this->addErrors('start_date', self::RULE_VALID_START_DATE);
                }

                /*
                 * If the attribute has rule valid_end_date and the value is before or equal to the
                 * day of the project start date. Then add an error for the corresponding
                 * attribute and rule passing them as arguments in the addErrors function
                 */

                if ($ruleName === self::RULE_VALID_END_DATE && $value <= $this->{$rule['end_date']})
                {
                    $this->addErrors('end_date', self::RULE_VALID_END_DATE);
                }

            }
        }
        /*
         * If all the above conditions are met it means validation passed for the data that was passed
         * to the validate function. If so it means the errors array is empty
         * Then if validate passed, return if empty errors array, as true. If errors array is not empty
         * validate function returns false
         */
        return empty($this->errors);

    }

    /*
     * Private function addErrors for this class alone. It receives two parameters, attribute and the rule
     * as we have seen above in the validate function. It then adds to the errors array of this class,
     * for that particular attribute, a specific message
     * But we will get the message from another function getMessage, that maps the exact message for each
     * rule
     */

    private function addErrors(string $attribute, string $rule)
    {
        $msg = $this->getMessage()[$rule] ?? ""; //gets the string message for the rule $rule
        $this->errors[$attribute][] = $msg;
    }

    /*
     * The getMessage function basically returns a specific message for a specific rules, and returns
     * and array where we can choose the message we want to store
     */

    public function getMessage(): array
    {
        return [
            self::RULE_REQUIRED => 'This Field is required',
            self::RULE_EMAIL => 'Please input valid email address',
            self::RULE_MATCH => 'The Passwords must match',
            self::RULE_UNIQUE => 'This record exists in the database',
            self::RULE_VALID_START_DATE => 'Project start date cannot be before today',
            self::RULE_VALID_END_DATE => 'Project end date cannot be before start date'

        ];
    }

    /*
     * This function is used to get the error message for the first error in the attributes
     * and returns it in the user views. an attribute can have multiple errors but we first return
     * the first error
     */

    public function getErrors($attr){
        return $this->errors[$attr][0] ?? false;
    }

    /*
     * Public function addErrorMessages that is accessible by any class that can directly add an error and the
     * message in the errors array if validation is directly done on the active model class calling the fn
     */

    public function addErrorMessages(string $attr, string $msg)
    {
        $this->errors[$attr][] = $msg;
    }



}