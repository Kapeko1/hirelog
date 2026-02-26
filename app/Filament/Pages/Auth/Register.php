<?php

namespace App\Filament\Pages\Auth;

use Filament\Schemas\Schema;

class Register extends \Filament\Auth\Pages\Register
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }
}
