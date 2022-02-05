<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'CNPJ' => ['required', 'numeric', 'max:255'],
            'Telefone' => ['required', 'numeric', 'max:255'],
            'CEP' => ['required', 'numeric', 'max:8'],
            'Endereço' => ['required', 'string', 'max:255'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'CNPJ' => $input['CNPJ'],
            'Telefone' => $input['Telefone'],
            'CEP' => $input['CEP'],
            'Endereço' => $input['Endereço'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
