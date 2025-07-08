<?php

namespace App\Filament\Pages\Auth;

use App\Models\InvitationCode;
use App\Rules\ValidInvitationCode;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as BaseRegister;

class Register extends BaseRegister
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('invitation_code')
                    ->label(__('app.invitation_code'))
                    ->required()
                    ->rules([
                        'required',
                        new ValidInvitationCode,
                    ]),
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    protected function handleRegistration(array $data): \Illuminate\Database\Eloquent\Model
    {
        $invitationCodeValue = $data['invitation_code'];
        unset($data['invitation_code']);

        $invitationCode = InvitationCode::findByCode($invitationCodeValue);

        if (! $invitationCode || ! $invitationCode->isAvailable()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'invitation_code' => 'Wrong or used code',
            ]);
        }

        $user = parent::handleRegistration($data);
        $invitationCode->markAsUsed($user->getKey());

        return $user;
    }
}
