<?php

namespace App\Services;

class PersianToArabicService
{
    protected static ?array $cache = null;

    protected static array $wordMap = [
        'ورود' => 'تسجيل الدخول',
        'ثبت' => 'تسجيل',
        'نام' => 'الاسم',
        'خروج' => 'تسجيل الخروج',
        'خانه' => 'الرئيسية',
        'داشبورد' => 'لوحة التحكم',
        'ملک' => 'عقار',
        'املاک' => 'العقارات',
        'خریدار' => 'مشتري',
        'مشتری' => 'عميل',
        'کارشناس' => 'وكيل',
        'مشاور' => 'مستشار',
        'جستجو' => 'بحث',
        'جستجوی' => 'بحث',
        'ویرایش' => 'تعديل',
        'حذف' => 'حذف',
        'مشاهده' => 'عرض',
        'ثبت' => 'إضافة',
        'خرید' => 'شراء',
        'فروش' => 'بيع',
        'اجاره' => 'إيجار',
        'شهر' => 'المدينة',
        'محله' => 'الحي',
        'تلفن' => 'الهاتف',
        'ایمیل' => 'البريد الإلكتروني',
        'رمز' => 'كلمة',
        'عبور' => 'المرور',
        'ادامه' => 'متابعة',
        'بستن' => 'إغلاق',
        'باشه' => 'حسناً',
        'بله' => 'نعم',
        'خیر' => 'لا',
        'انتخاب' => 'اختيار',
        'نمایش' => 'عرض',
        'لیست' => 'قائمة',
        'اطلاعات' => 'معلومات',
        'مشخصات' => 'البيانات',
        'تاریخ' => 'التاريخ',
        'قیمت' => 'السعر',
        'متراژ' => 'المساحة',
        'متر' => 'متر',
        'حداقل' => 'الحد الأدنى',
        'حداکثر' => 'الحد الأقصى',
        'نوع' => 'النوع',
        'وضعیت' => 'الحالة',
        'یادداشت' => 'ملاحظة',
        'توضیحات' => 'الوصف',
        'تصاویر' => 'الصور',
        'فایل' => 'ملف',
        'ارسال' => 'إرسال',
        'درخواست' => 'طلب',
        'تماس' => 'اتصال',
        'پیام' => 'رسالة',
        'موردعلاقه' => 'المفضلة',
        'مقایسه' => 'المقارنة',
        'اشتراک' => 'مشاركة',
        'گذاری' => '',
        'رایگان' => 'مجاني',
        'جدید' => 'جديد',
        'همه' => 'الكل',
        'بیشتر' => 'المزيد',
        'درباره' => 'حول',
        'ما' => 'نحن',
        'تماس با ما' => 'اتصل بنا',
        'لینک' => 'رابط',
        'مقالات' => 'مقالات',
        'مجله' => 'مجلة',
        'بازاریاب' => 'مسوق',
        'مدیر' => 'مدير',
        'اصلی' => 'رئيسي',
        'کاربر' => 'مستخدم',
        'عادی' => 'عادي',
        'مالک' => 'مالك',
        'آپارتمان' => 'شقة',
        'ویلا' => 'فيلا',
        'ویلایی' => 'فيلا',
        'زمین' => 'أرض',
        'مغازه' => 'محل تجاري',
        'پروژه' => 'مشروع',
        'سازنده' => 'مطور',
        'برند' => 'علامة تجارية',
        'قرارداد' => 'عقد',
        'بازدید' => 'زيارة',
        'نظر' => 'تعليق',
        'تایید' => 'تأكيد',
        'رد' => 'رفض',
        'موفقیت' => 'نجاح',
        'خطا' => 'خطأ',
        'لطفا' => 'يرجى',
        'وارد' => 'إدخال',
        'کنید' => '',
        'نمایید' => '',
        'شماره' => 'رقم',
        'موبایل' => 'الجوال',
        'ایجاد' => 'إنشاء',
        'تغییر' => 'تغيير',
        'ذخیره' => 'حفظ',
        'انصراف' => 'إلغاء',
        'بازگشت' => 'عودة',
        'جزئیات' => 'التفاصیل',
        'جزییات' => 'التفاصیل',
        'عملکرد' => 'الأداء',
        'مدیریت' => 'إدارة',
        'تقاضا' => 'طلب',
        'مشاوره' => 'استشارة',
        'سرمایه' => 'استثمار',
        'گذاری' => '',
        'امروز' => 'اليوم',
        'فردا' => 'غداً',
        'آرامش' => 'راحة',
        'ثبت' => 'تسجيل',
        'آگهی' => 'إعلان',
        'فوری' => 'عاجل',
        'اکازیون' => 'فرصة',
        'فروشی' => 'للبيع',
        'کارشناسان' => 'الوكلاء',
        'امارات' => 'الإمارات',
        'دبی' => 'دبي',
        'حقوق' => 'الحقوق',
        'متعلق' => 'تعود',
        'سایت' => 'الموقع',
        'تولید' => 'إنتاج',
        'توسط' => 'بواسطة',
        'هنوز' => 'لم',
        'نشده' => 'بعد',
        'خوش' => 'مرحباً',
        'آمدید' => 'بكم',
        'سلام' => 'مرحباً',
        'فراموش' => 'نسيت',
        'کرده' => '',
        'اید' => '',
        'پست' => 'البريد',
        'الکترونیکی' => 'الإلكتروني',
        'حساب' => 'الحساب',
        'کاربری' => '',
        'چرا' => 'لماذا',
        'انتخاب' => 'اختيار',
        'خوبی' => 'جيد',
        'است' => '',
        'همین' => 'الآن',
        'حالا' => '',
        'بگیرید' => 'اتصل',
        'می' => '',
        'تونید' => 'يمكنك',
        'هر' => 'كل',
        'کجای' => 'أين',
        'کشور' => 'بلد',
        'دارید' => 'لديك',
        'چند' => 'بضع',
        'کلیک' => 'نقرات',
        'ساده' => 'بسيطة',
        'ملکتان' => 'عقارك',
        'صورت' => 'بشكل',
        'سریع' => 'سريع',
        'ترین' => 'الأسرع',
        'زمان' => 'وقت',
        'ممکن' => 'ممكن',
        'معامله' => 'صفقة',
        'هستید' => 'هل أنت',
        'آدرس' => 'العنوان',
        'لینک' => 'روابط',
        'مرتبط' => 'ذات صلة',
        'فایل' => 'ملف',
        'های' => '',
        'فروش' => 'بيع',
        'جدید' => 'جديد',
    ];

    public function translate(string $persian): string
    {
        $persian = trim($persian);
        if ($persian === '') {
            return '';
        }

        $keyword = str_replace(' ', '-', $persian);
        $cached = $this->getCachedTranslations();

        if (isset($cached[$keyword]) && $cached[$keyword] !== '') {
            return $cached[$keyword];
        }

        if (isset($cached[$persian]) && $cached[$persian] !== '') {
            return $cached[$persian];
        }

        $apiKey = env('GOOGLE_TRANSLATE_API_KEY');
        if (!empty($apiKey)) {
            try {
                $translator = new GoogleTranslateService();
                $translated = $translator->translate('fa', 'ar', $persian);
                if (!empty($translated)) {
                    $this->cacheTranslation($keyword, $translated);
                    return $translated;
                }
            } catch (\Throwable $e) {
                // fall through to dictionary
            }
        }

        $translated = $this->translateByDictionary($persian);
        if ($translated !== $persian) {
            $this->cacheTranslation($keyword, $translated);
        }

        return $translated;
    }

    protected function translateByDictionary(string $persian): string
    {
        $result = $persian;
        $sorted = self::$wordMap;
        uksort($sorted, fn ($a, $b) => mb_strlen($b) <=> mb_strlen($a));

        foreach ($sorted as $fa => $ar) {
            if ($ar !== '' && mb_strpos($result, $fa) !== false) {
                $result = str_replace($fa, $ar, $result);
            }
        }

        $result = preg_replace('/\s+/', ' ', trim($result));

        return $result !== '' ? $result : $persian;
    }

    protected function getCachedTranslations(): array
    {
        if (self::$cache !== null) {
            return self::$cache;
        }

        self::$cache = [];
        $path = resource_path('lang/ar/message.php');
        if (file_exists($path)) {
            $data = include $path;
            if (is_array($data)) {
                self::$cache = $data;
            }
        }

        $messagesPath = resource_path('lang/ar/messages.php');
        if (file_exists($messagesPath)) {
            $messages = include $messagesPath;
            if (is_array($messages)) {
                self::$cache = array_merge(self::$cache, $messages);
            }
        }

        return self::$cache;
    }

    protected function cacheTranslation(string $keyword, string $translation): void
    {
        self::$cache = null;
        $path = resource_path('lang/ar/message.php');
        $existing = file_exists($path) ? include $path : [];
        if (!is_array($existing)) {
            $existing = [];
        }

        if (isset($existing[$keyword]) && $existing[$keyword] === $translation) {
            return;
        }

        $existing[$keyword] = $translation;
        ksort($existing);

        $content = "<?php\n\nreturn [\n";
        foreach ($existing as $k => $v) {
            $content .= "    '" . str_replace("'", "\\'", $k) . "' => '" . str_replace("'", "\\'", $v) . "',\n";
        }
        $content .= "];\n";

        file_put_contents($path, $content);
    }
}
