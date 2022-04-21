<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->delete();

        $data = [
            ['type' => 'current_session', 'description' => date("Y")],
            ['type' => 'system_title', 'description' => 'FASTDECODE'],
            ['type' => 'system_name', 'description' => 'FASTDECODE SCHOOL MANAGEMENT SYSTEM'],
            ['type' => 'term_ends', 'description' => '03/10/2021'],
            ['type' => 'term_begins', 'description' => '03/10/2021'],
            ['type' => 'phone', 'description' => '+923332511584'],
            ['type' => 'address', 'description' => 'C-57, Main Qasimabad Hyderabad'],
            ['type' => 'system_email', 'description' => 'rajas.bit@gmail.com'],
            ['type' => 'alt_email', 'description' => ''],
            ['type' => 'email_host', 'description' => ''],
            ['type' => 'email_pass', 'description' => ''],
            ['type' => 'lock_exam', 'description' => 0],
            ['type' => 'logo', 'description' => ''],
            ['type' => 'next_term_fees_j', 'description' => '20000'],
            ['type' => 'next_term_fees_pn', 'description' => '25000'],
            ['type' => 'next_term_fees_p', 'description' => '25000'],
            ['type' => 'next_term_fees_n', 'description' => '25600'],
            ['type' => 'next_term_fees_s', 'description' => '15600'],
            ['type' => 'next_term_fees_c', 'description' => '1600'],
        ];

        DB::table('settings')->insert($data);

    }
}
