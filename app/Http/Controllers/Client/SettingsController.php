<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\UpdateSettingsRequest;
use App\Services\Client\SettingsService;

class SettingsController extends Controller
{
    protected $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    public function update(UpdateSettingsRequest $request)
    {
        $user = auth('client')->user();

        $result = $this->settingsService->update($user, $request->validated());

        return api_response(
            $result['status'] ? 'success' : 'fail',
            $result['message'],
            $result['data'] ?? null,
            $result['code'] ?? 200
        );
    }

    public function terms()
    {
        $terms = <<<EOT
مرحبًا بك في تطبيق "طبي".

باستخدامك لهذا التطبيق، فإنك توافق على الالتزام بالشروط والأحكام التالية:

1. الاستخدام:
يُستخدم التطبيق لحجز المواعيد الطبية، والاطلاع على الخدمات الصحية، ولا يُعد بديلاً عن الاستشارة الطبية المباشرة.

2. دقة المعلومات:
نحن نسعى لتوفير معلومات دقيقة، ولكن لا نتحمل مسؤولية أي أخطاء أو نقص في البيانات.

3. الحساب الشخصي:
أنت مسؤول عن الحفاظ على سرية بيانات حسابك، وأي نشاط يتم من خلاله.

4. المواعيد:
حجز المواعيد يعتمد على توفر الأطباء والمراكز الطبية، وقد يتم تعديل أو إلغاء المواعيد في بعض الحالات.

5. المسؤولية:
التطبيق غير مسؤول عن أي أضرار ناتجة عن استخدام الخدمات أو الاعتماد على المعلومات المقدمة.

6. الخصوصية:
يتم التعامل مع بياناتك وفقًا لسياسة الخصوصية الخاصة بالتطبيق.

7. التعديلات:
نحتفظ بالحق في تعديل هذه الشروط في أي وقت دون إشعار مسبق.

باستخدامك للتطبيق، فإنك تقر بموافقتك على هذه الشروط.
EOT;

        return api_response(
            'success',
            'Terms fetched successfully',
            [
                'terms' => $terms
            ]
        );
    }

}
