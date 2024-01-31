<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

readonly class WordCount implements ValidationRule
{
    public function __construct(
        private int $maxWords = 300,
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (str_word_count($value) > $this->maxWords) {
            $fail("The :attribute cannot be longer than {$this->maxWords} words.");
        }
    }
}
