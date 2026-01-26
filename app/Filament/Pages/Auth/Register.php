<?php

namespace App\Filament\Pages\Auth;

use App\Models\InvitationCode;
use App\Rules\ValidInvitationCode;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class Register extends \Filament\Auth\Pages\Register
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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

    /**
     * @throws ValidationException
     */
    protected function handleRegistration(array $data): Model
    {
        $invitationCodeValue = $data['invitation_code'];
        unset($data['invitation_code']);

        $invitationCode = InvitationCode::findByCode($invitationCodeValue);

        if (! $invitationCode || ! $invitationCode->isAvailable()) {
            throw ValidationException::withMessages([
                'invitation_code' => 'Wrong or used code',
            ]);
        }

        $user = parent::handleRegistration($data);
        $invitationCode->markAsUsed($user->getKey());

        return $user;
    }
}
