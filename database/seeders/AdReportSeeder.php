<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\AdReport;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AdReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ad = Ad::query()->first();
        $user = User::query()->first();

        if (! $ad || ! $user) {
            $this->command->warn('AdReportSeeder: Nema oglasa ili korisnika u bazi – preskačem seeding ad_reports.');

            return;
        }

        $reports = [
            [
                'reason' => 'Lažan oglas',
                'message' => 'Ovaj oglas deluje kao prevara, opis ne odgovara slici.',
                'status' => 'pending',
            ],
            [
                'reason' => 'Neprimeren sadržaj',
                'message' => 'Sadrži uvredljiv tekst koji krši pravila sajta.',
                'status' => 'reviewed',
            ],
            [
                'reason' => 'Pogrešna kategorija',
                'message' => 'Oglas je postavljen u pogrešnoj kategoriji.',
                'status' => 'dismissed',
            ],
            [
                'reason' => 'Spam / dupli oglas',
                'message' => 'Isti oglas je postavljen više puta.',
                'status' => 'pending',
            ],
            [
                'reason' => 'Nepotpune informacije',
                'message' => 'Nedostaju ključne informacije o proizvodu.',
                'status' => 'reviewed',
            ],
        ];

        foreach ($reports as $data) {
            AdReport::create([
                'ad_id' => $ad->id,
                'user_id' => $user->id,
                'reason' => $data['reason'],
                'message' => $data['message'],
                'status' => $data['status'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
