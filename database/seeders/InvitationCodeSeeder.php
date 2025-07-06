<?php

namespace Database\Seeders;

use App\Models\InvitationCode;
use Illuminate\Database\Seeder;

class InvitationCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InvitationCode::create(['code' => 'WORK2025']);
        InvitationCode::create(['code' => 'INVITE01']);
        InvitationCode::create(['code' => 'TRACK123']);
        InvitationCode::create(['code' => 'APPLY456']);
        InvitationCode::create(['code' => 'JOBHUNT7']);
        InvitationCode::create(['code' => 'CAREER89']);
        InvitationCode::create(['code' => 'WORKAPP1']);
        InvitationCode::create(['code' => 'JOINTEAM']);
        InvitationCode::create(['code' => 'STARTER3']);
        InvitationCode::create(['code' => 'WELCOME5']);
    }
}
