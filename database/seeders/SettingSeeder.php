<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'privacy',
                'value' => [
                    'en' => 'Privacy Policy Content',
                    'ar' => 'محتوى سياسة الخصوصية',
                ],
            ],
            [
                'key' => 'terms',
                'value' => [
                    'en' => 'Terms of Service Content',
                    'ar' => 'محتوى شروط الخدمة',
                ],
            ],
            [
                'key' => 'tagline',
                'value' => [
                    'en' => 'Enterprise Data Intelligence',
                    'ar' => 'ذكاء بيانات المؤسسات',
                ],
            ],
            [
                'key' => 'email',
                'value' => 'hello@botjourney.ai',
            ],
            [
                'key' => 'phone',
                'value' => '+966 50 123 4567',
            ],
            [
                'key' => 'address',
                'value' => [
                    'en' => 'Riyadh, Saudi Arabia',
                    'ar' => 'الرياض، المملكة العربية السعودية',
                ],
            ],
            [
                'key' => 'linkedin',
                'value' => 'https://linkedin.com/company/botjourney',
            ],
            [
                'key' => 'twitter',
                'value' => 'https://twitter.com/botjourney',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}
