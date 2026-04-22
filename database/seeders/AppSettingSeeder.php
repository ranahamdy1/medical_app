<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AppSetting;

class AppSettingSeeder extends Seeder
{
    public function run()
    {
        AppSetting::firstOrCreate(
            ['id' => 1],
            [
                'app_name' => 'LAVENDER LAND CLINICS',
                'subtitle' => 'DENTAL - LASER - DERMA',

                'about' => 'تطبيق "طبي" هو منصتك المتكاملة للحصول على الخدمات الطبية بسهولة وسرعة. يمكنك من خلاله حجز المواعيد مع الأطباء في مختلف التخصصات، وإجراء الفحوصات الطبية مثل الأشعة والتحاليل في أفضل المراكز المعتمدة.',

                'year' => 2025,
                'rights' => 'كل الحقوق محفوظة لتطبيق طبي 2025',

                'note' => 'يبرز التطبيق أحدث التقنيات في مجال الطب والعناية الصحية، ويتيح لك متابعة مواعيدك، حجوزاتك، ونتائجك بسهولة.',

                // Social links
                'facebook'  => 'https://facebook.com/',
                'instagram' => 'https://instagram.com/',
                'youtube'   => 'https://youtube.com/',
                'twitter'   => 'https://twitter.com/',

                // Links
                'privacy_policy' => 'https://yourapp.com/privacy-policy',
                'terms'          => 'https://yourapp.com/terms',
            ]
        );
    }
}
