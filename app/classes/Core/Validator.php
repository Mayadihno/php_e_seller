<?php

namespace Core;

use Core\Database;

class Validator extends Database
{
    protected $rules = [];
    protected $data = [];
    public $errors = [];

    public $primaryKey = 'id';

    public function __construct(array $data)
    {
        parent::__construct();
        $this->data = $data;
    }

    public function setRules(array $rules)
    {
        $this->rules = $rules;
        $this->validate();
    }

    protected function validate()
    {
        $this->errors = [];
        foreach ($this->rules as $field => $rules) {

            $input_name = ucfirst($field);
            if (isset($rules['name']) || (count($rules) == 2 && is_string($rules[0]) && is_array($rules[1]))) {
                $input_name = $rules['name'] ?? ($rules[0] ?? '');
                $rules = $rules['rules'] ?? ($rules[1] ?? []);
            }

            foreach ($rules as $rule) {

                $error_message = '';
                if (is_array($rule)) {
                    $error_message = isset($rule['error_message']) ? $rule['error_message'] : ($rule[1] ?? '');
                    $rule = $rule['rule'] ?? ($rule[0] ?? '');
                }

                $value = $this->data[$field] ?? null;

                if (is_string($value)) {
                    $value = trim($value);
                }

                // if (empty($value) && $rule !== 'required') {
                //     continue; // Skip validation if the field is not required and is empty
                // }
                $ruleParts = explode(':', $rule);
                $rule = $ruleParts[0];
                $param = isset($ruleParts[1]) ? $ruleParts[1] : null;
                if (method_exists($this, 'validate_' . $rule)) {
                    $method = 'validate_' . $rule;
                    $this->$method($field, $value, $param, [
                        'input_name' => $input_name,
                        'error_message' => $error_message
                    ]);
                }
            }
        }
    }

    public function has_error()
    {
        return !empty($this->errors);
    }

    protected function validate_required(string $field, mixed $value, ?string $param, $meta)
    {
        if (empty($value)) {
            $this->errors[$field][] = !empty($meta['error_message']) ? $meta['error_message'] : $meta['input_name'] . " is required";
        }
    }
    protected function validate_image(string $field, mixed $value, ?string $param, $meta)
    {
        // Handle multiple files
        if (is_array($value['name'])) {
            $hasValidFile = false;

            foreach ($value['error'] as $index => $error) {
                if ($error === UPLOAD_ERR_OK) {
                    $hasValidFile = true;
                    break;
                }
            }

            if (!$hasValidFile) {
                $this->errors[$field][] = $meta['input_name'] . " is required";
            }
        }
        // Handle single file
        elseif (is_array($value) && isset($value['error'])) {
            if ($value['error'] !== UPLOAD_ERR_OK) {
                $this->errors[$field][] = $meta['input_name'] . " is required";
            }
        }
        // If completely empty
        elseif (empty($value)) {
            $this->errors[$field][] = $meta['input_name'] . " is required";
        }
    }


    protected function validate_email(string $field, string $value, ?string $param, $meta)
    {

        if (!filter_var($value, FILTER_VALIDATE_EMAIL))
            $this->errors[$field][] = !empty($meta['error_message']) ? $meta['error_message'] : $meta['input_name'] . " is not a valid email address";
    }

    protected function validate_regex(string $field, string $value, ?string $param, $meta)
    {
        if (!preg_match("/$param/", $value))
            $this->errors[$field][] = !empty($meta['error_message']) ? $meta['error_message'] : $meta['input_name'] . " is not valid";
    }

    protected function validate_min(string $field, string $value, ?string $param, $meta)
    {
        if (strlen($value) < $param)
            $this->errors[$field][] = !empty($meta['error_message']) ? $meta['error_message'] : $meta['input_name'] . " must be at least " . $param . " characters";
    }

    protected function validate_max(string $field, string $value, ?string $param, $meta)
    {
        if (strlen($value) > $param)
            $this->errors[$field][] = !empty($meta['error_message']) ? $meta['error_message'] : $meta['input_name'] . " must not exceed " . $param . " characters";
    }

    protected function validate_date(string $field, string $value, ?string $param, $meta)
    {
        if (!strtotime($value))
            $this->errors[$field][] = !empty($meta['error_message']) ? $meta['error_message'] : $meta['input_name'] . " is not a valid date";
    }

    protected function validate_match(string $field, string $value, ?string $param, $meta)
    {
        if ($value !== ($this->data[$param] ?? ''))
            $this->errors[$field][] = !empty($meta['error_message']) ? $meta['error_message'] : $meta['input_name'] . " does not match " . $meta['input_name'];
    }

    protected function validate_alpha(string $field, string $value, ?string $param, $meta)
    {
        if (!preg_match("/^[a-zA-Z ]+$/", $value))
            $this->errors[$field][] = !empty($meta['error_message']) ? $meta['error_message'] : $meta['input_name'] . " should only contain letters";
    }
    protected function validate_numeric(string $field, string $value, ?string $param, $meta)
    {
        if (!preg_match("/^[0-9 ]+$/", $value))
            $this->errors[$field][] = !empty($meta['error_message']) ? $meta['error_message'] : $meta['input_name'] . " should only contain numbers";
    }
    protected function validate_is_numeric(string $field, string $value, ?string $param, $meta)
    {
        if (!is_numeric($value)) {
            $this->errors[$field][] = !empty($meta['error_message'])
                ? $meta['error_message']
                : $meta['input_name'] . " should be a valid number";
        }
    }


    protected function validate_alpha_numeric(string $field, string $value, ?string $param, $meta)
    {
        if (!preg_match("/^[a-zA-Z0-9 ]+$/", $value))
            $this->errors[$field][] = !empty($meta['error_message']) ? $meta['error_message'] : $meta['input_name'] . " should only contain letters and numbers";
    }

    protected function validate_no_space(string $field, string $value, ?string $param, $meta)
    {
        if (preg_match("/[\s]+/", $value))
            $this->errors[$field][] = !empty($meta['error_message']) ? $meta['error_message'] : $meta['input_name'] . " should not contain spaces";
    }
    protected function validate_unique(string $field, string $value, ?string $param, $meta)
    {

        if (!empty($this->data[$this->primaryKey])) {
            // If the primary key is set, we need to exclude the current record from the uniqueness check
            $sql = "SELECT COUNT(*) as count FROM " . $param . " WHERE " . $field . " = :value AND " . $this->primaryKey . " != :id limit 1";
            $query = $this->query($sql, [
                'value' => $value,
                'id' => $this->data[$this->primaryKey]
            ]);
        } else {
            // Otherwise, we check for uniqueness without excluding any record
            $sql = "SELECT COUNT(*) as count FROM " . $param . " WHERE " . $field . " = :value limit 1";
            $query = $this->query($sql, [
                'value' => $value
            ]);
        }
        if (!empty($query) && $query->fetchColumn() > 0) {
            $this->errors[$field][] = !empty($meta['error_message']) ? $meta['error_message'] : $meta['input_name'] . " already exists";
        }
    }
}
