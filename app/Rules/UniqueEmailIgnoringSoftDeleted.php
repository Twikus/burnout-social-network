<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueEmailIgnoringSoftDeleted implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = DB::table('users')
            ->where('email', $value)
            ->whereNull('deleted_at')
            ->exists();

        if ($exists) {
            $fail('Cette adresse email est déjà utilisée.');
        }
    }
}
