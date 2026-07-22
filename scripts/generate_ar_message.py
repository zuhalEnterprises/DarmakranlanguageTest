#!/usr/bin/env python3
"""Generates resources/lang/ar/message.php from en/message.php keys."""

import re
from pathlib import Path

BASE = Path(__file__).resolve().parent.parent
EN_PATH = BASE / "resources/lang/en/message.php"
AR_PATH = BASE / "resources/lang/ar/message.php"
MESSAGES_PATH = BASE / "resources/lang/ar/messages.php"


def parse_php_array(content: str) -> dict:
    """Parse simple PHP return array."""
    result = {}
    for match in re.finditer(r"'((?:\\'|[^'])*)'\s*=>\s*'((?:\\'|[^'])*)'", content):
        key = match.group(1).replace("\\'", "'")
        val = match.group(2).replace("\\'", "'")
        result[key] = val
    return result


def escape_php(s: str) -> str:
    return s.replace("\\", "\\\\").replace("'", "\\'")


ARABIC_MAP = {
    "Agent": "وكيل", "Add Property": "إضافة عقار", "Properties List": "قائمة العقارات",
    "My Leads": "عملائي المحتملين", "Register Lead": "تسجيل عميل", "Message": "رسالة",
    "Favorites": "المفضلة", "Exit": "خروج", "Home": "الرئيسية", "Buy": "شراء",
    "Rent": "إيجار", "Login": "تسجيل الدخول", "Register": "إنشاء حساب",
    "Dashboard": "لوحة التحكم", "Delete": "حذف", "Edit": "تعديل", "Search": "بحث",
    "Filter": "تصفية", "City": "المدينة", "Tel": "الهاتف", "Continue": "متابعة",
    "Select": "اختيار", "Optional": "اختياري", "Note": "ملاحظة", "Name": "الاسم",
    "Email": "البريد الإلكتروني", "Mobile": "الجوال", "Yes": "نعم", "No": "لا",
    "Owner": "مالك", "Low": "منخفض", "Average": "متوسط", "From": "من",
    "Until": "حتى", "In": "في", "Request": "طلب", "Areas": "المناطق",
    "Apartment": "شقة", "Villa": "فيلا", "Shop": "محل تجاري", "Land": "أرض",
    "Detail": "التفاصيل", "Add my property": "إضافة عقاري",
    "Login & Register": "تسجيل الدخول وإنشاء حساب", "Find Agents": "البحث عن الوكلاء",
    "Properties Search": "بحث العقارات", "Add Agent": "تسجيل وكيل",
    "Contact An Agent": "الاتصال بالوكيل", "Main Admin": "المدير الرئيسي",
    "Referrer": "مسوق", "My Clients": "عملائي", "Brand List": "قائمة العلامات",
    "Brand": "علامة تجارية", "Create Brand": "إنشاء علامة", "Edit Brand": "تعديل العلامة",
    "Demand Marketing": "تسويق الطلب", "My Marketing Entries": "تسويقاتي",
    "Search Marketing": "بحث التسويق", "Creation Date": "تاريخ الإنشاء",
    "Secondary": "ثانوي", "Private Gym": "صالة رياضية خاصة",
    "Infinity Pool": "مسبح لا متناهي", "Private Pool": "مسبح خاص",
    "Children Pool": "مسبح أطفال", "Maid Service": "خدمة تنظيف",
    "Smart Home System": "نظام منزل ذكي", "Concierge Service": "خدمة الاستقبال",
    "Built-in Wardrobes": "خزائن مدمجة", "Walk-in Closet": "غرفة ملابس",
    "View of Water": "إطلالة على الماء", "View of Landmark": "إطلالة على معلم",
    "Garden": "حديقة", "Vacant": "شاغر", "Rented": "مؤجر",
    "Under Mortgage": "تحت رهن", "Motivated Seller": "بائع جاد",
    "Property Comments": "تعليقات العقارات", "Comment List": "قائمة التعليقات",
    "Comment Type": "نوع التعليق", "Under Review": "قيد المراجعة",
    "Approve Comment": "الموافقة على التعليق", "Reject Comment": "رفض التعليق",
    "Tag": "وسم", "Select tag": "اختر الوسم", "Booking List": "قائمة المواعيد",
    "Submit Booking": "تسجيل موعد", "Booking Request": "طلب زيارة",
    "Request a Visit": "طلب زيارة", "Visit Time": "وقت الزيارة",
    "Your Name": "اسمك", "Send Request": "إرسال الطلب",
    "Successfully Submitted": "تم التسجيل بنجاح",
    "Thank You for Contacting Us": "شكراً لتواصلك معنا",
    "Please Fill Out All Fields": "يرجى ملء جميع الحقول",
    "Link Not Found": "الرابط غير موجود",
    "Images and Documents": "الصور والمستندات",
    "Related Documents": "المستندات ذات الصلة",
    "Social Networks": "الشبكات الاجتماعية",
    "Submit Consultation Request": "إرسال طلب استشارة",
    "You're Just One Step Away from Your Ideal Property": "أنت على بعد خطوة واحدة من عقارك المثالي",
    "Enter your information and we'll contact you shortly": "أدخل معلوماتك وسنتواصل معك قريباً",
    "e.g. Ali Rezaei": "مثال: علي رضائي", "e.g.": "مثال", "Description": "الوصف",
    "Marketer Name": "اسم المسوق",
    "We send you daily updates.": "نرسل لك تحديثات يومية.",
    "Create base property": "إنشاء عقار أساسي",
    "Schedule a Physical Booking": "جدولة زيارة حضورية",
    "Booking Date & Time": "تاريخ ووقت الزيارة",
    "Select Booking Date & Time": "اختر تاريخ ووقت الزيارة",
    "Booked By": "حجز بواسطة", "Search Booking Requests": "بحث طلبات الزيارة",
    "Booking From Date": "تاريخ الزيارة من", "Booking To Date": "تاريخ الزيارة إلى",
    "Please select an advisor": "يرجى اختيار مستشار",
    "The advisor has been successfully changed.": "تم تغيير المستشار بنجاح.",
    "Error changing advisor. Please try again.": "خطأ في تغيير المستشار. يرجى المحاولة مرة أخرى.",
    "Your request has been submitted. Our experts will contact you.": "تم تسجيل طلبك. سيتواصل معك خبراؤنا.",
    "The selected comment was successfully deleted.": "تم حذف التعليق المحدد بنجاح.",
    "The selected comment was successfully approved.": "تمت الموافقة على التعليق المحدد بنجاح.",
    "The selected comment was successfully deactivated.": "تم إلغاء تفعيل التعليق المحدد بنجاح.",
    "Marketing Link Copied to Clipboard": "تم نسخ رابط التسويق",
    "Error Copying Link": "خطأ في نسخ الرابط",
    "There Was a Problem Submitting the Information": "حدثت مشكلة في إرسال المعلومات",
    "Price to": "السعر حتى", "Price since": "السعر من",
    "Current Files": "الملفات الحالية", "My Leads List": "قائمة عملائي",
    "Search Marketing Entries": "بحث التسويقات",
    "On Notice Period": "في فترة الإشعار",
    "VOT (Vacant on Transfer)": "شاغر عند النقل",
    "Lead Information": "معلومات العميل", "Lead Name": "اسم العميل",
    "Mobile Phone": "الهاتف المحمول", "Request Type": "نوع الطلب",
    "Payment Status": "حالة الدفع", "Cash Payment": "دفع نقدي",
    "Payment Plan": "خطة دفع", "Mortgage": "رهن عقاري",
    "Property Type": "نوع العقار", "Select The City": "اختر المدينة",
    "Select requested Neighborhood": "اختر الحي المطلوب",
    "Min Size (sqft)": "الحد الأدنى للمساحة (قدم²)",
    "Max Size (sqft)": "الحد الأقصى للمساحة (قدم²)",
    "Min Amount Of rent": "الحد الأدنى للإيجار",
    "Max Amount Of rent": "الحد الأقصى للإيجار",
    "Min Amount Of Deposit": "الحد الأدنى للوديعة",
    "Max Deposit Amount": "الحد الأقصى للوديعة",
    "Min Price (AED)": "الحد الأدنى للسعر (درهم)",
    "Max Price (AED)": "الحد الأقصى للسعر (درهم)",
    "Enter The Minimum Amount": "أدخل الحد الأدنى",
    "Enter The Maximum Amount": "أدخل الحد الأقصى",
    "Select Agent": "اختر الوكيل", "Enter Your Password": "أدخل كلمة المرور",
    "Lead Id": "رقم العميل", "Lead Details": "تفاصيل العميل",
    "Lead Detail": "تفاصيل العميل", " sqft Up": " قدم² فأكثر",
    "AED": "درهم", "Priority": "الأولوية", "Reason To Buy": "سبب الشراء",
    "For Living": "للسكن", "Housing": "السكن",
    "Non-local resident": "مقيم غير محلي", "For Investment": "للاستثمار",
    "Edit Lead": "تعديل العميل", "For Convert": "للتحويل",
    "Add Lead": "إضافة عميل", "My Leads": "عملائي",
}

FA_AR_DIRECT = {
    "ورود": "تسجيل الدخول", "ثبت-نام": "إنشاء حساب", "خروج": "تسجيل الخروج",
    "خانه": "الرئيسية", "داشبورد": "لوحة التحكم", "ثبت-ملک": "إضافة عقار",
    "ثبت-ملک-من": "إضافة عقاري", "جستجو": "بحث", "جستجوی-ملک": "بحث العقارات",
    "ﺟﺴﺘﺠﻮی-ملک": "بحث العقارات", "ویرایش": "تعديل", "حذف": "حذف",
    "مشاهده": "عرض", "شهر": "المدينة", "محله": "الحي", "تلفن": "الهاتف",
    "کارشناس": "وكيل", "مشاور": "مستشار", "مشتری": "عميل", "خریدار": "مشتري",
    "فروش": "بيع", "اجاره": "إيجار", "خرید": "شراء", "املاک": "العقارات",
    "موردعلاقه-ها": "المفضلة", "موردعلاقه": "المفضلة", "پیام": "رسالة",
    "ورود-به-حساب-کاربری": "تسجيل الدخول",
    "ورود-و-ثبت-نام": "تسجيل الدخول وإنشاء حساب",
    "ثبت-رایگان-ملک": "إضافة عقار مجاناً", "ثبت-رایگان-آگهی": "نشر إعلان مجاني",
    "مجله-املاک": "مجلة العقارات", "کارشناسان": "الوكلاء", "درباره-ما": "من نحن",
    "تماس-با-ما": "اتصل بنا", "لینک-های-مرتبط": "روابط ذات صلة",
    "مقالات-مرتبط": "مقالات ذات صلة",
    "فایل-های-فروش-ملک-جدید": "ملفات عقارات جديدة للبيع",
    "مشاهده-همه": "عرض الكل", "مقالات-بیشتر": "المزيد من المقالات",
    "املاک-فروشی": "عقارات للبيع", "املاک-فروش-فوری": "عقارات للبيع العاجل",
    "املاک-اکازیون": "عقارات فرصة", "ثبت-تقاضا": "تسجيل طلب",
    "سرمایه‌گذاری-امروز،-آرامش-فردا": "استثمر اليوم، راحة غداً",
    "دارمکران": "دارمكران",
    "مشاوره-رایگان-خرید-و-اجاره-ملک": "استشارة مجانية لشراء وإيجار العقارات",
    "همین-حالا-تماس-بگیرید": "اتصل الآن",
    "چرا-دارمکران-برای-شما-انتخاب-خوبی-است؟": "لماذا دارمكران خيار جيد لك؟",
    "مالک-هستید؟": "هل أنت مالك؟",
    "مجله-املاک-امارات": "مجلة عقارات الإمارات",
    "کارشناسان-دارمکران": "وكلاء دارمكران",
    "سلام!-به-سایت-دارمکران-خوش-آمدید.": "مرحباً! أهلاً بك في موقع دارمكران.",
    "هنوز-ثبت-نام-نکرده-اید؟": "لم تسجل بعد؟",
    "پست-الکترونیکی": "البريد الإلكتروني", "رمز-عبور": "كلمة المرور",
    "رمز-عبور-را-فراموش-کرده-اید؟": "نسيت كلمة المرور؟",
    "رمز-عبور-را-وارد-نمایید": "أدخل كلمة المرور",
    "تمام-حقوق-این-سایت-متعلق-به": "جميع حقوق هذا الموقع محفوظة لـ",
    "تولید-توسط": "إنتاج بواسطة", "مدیر-اصلی": "المدير الرئيسي",
    "بازاریاب": "مسوق", "کاربر-عادی": "مستخدم عادي",
    "داشبورد-من": "لوحتي", "لیست-املاک": "قائمة العقارات",
    "لیست-مشتریان": "قائمة العملاء", "بازاریابی-تقاضا": "تسويق الطلب",
    "ویرایش-مشخصات": "تعديل البيانات", "ثبت-خریدار": "تسجيل عميل",
    "مدیریت-املاک": "إدارة العقارات", "عملکرد-املاک": "أداء العقارات",
    "لیست-سازندگان": "قائمة المطورين", "لیست-پروژه-ها": "قائمة المشاريع",
    "مدیریت-مشتریان": "إدارة العملاء", "ثبت-مشتری": "تسجيل عميل",
    "مشاور-فروش": "مستشار مبيعات", "مشاور-اجاره": "مستشار إيجار",
    "مشاور-فروش-و-اجاره": "مستشار مبيعات وإيجار",
    "ثبت-نام-کارشناس": "تسجيل وكيل", "تماس-با-کارشناس": "الاتصال بالوكيل",
    "پروانه-ساخت": "رخصة البناء", "مقایسه": "المقارنة",
    "اشتراک-گذاری": "مشاركة", "بستن": "إغلاق", "باشه": "حسناً",
    "ثبت-ملک": "إضافة عقار", "ثبت-خریدار-جدید": "إضافة عميل جديد",
    "اطلاعات-خریدار": "معلومات العميل", "نام-خریدار": "اسم العميل",
    "تلفن-همراه": "الهاتف المحمول", "نوع-درخواست": "نوع الطلب",
    "وضعیت-نقدینگی": "حالة الدفع", "کاملا-نقد": "دفع نقدي كامل",
    "بخشی-نقد": "دفع جزئي", "غیر-نقد": "غير نقدي",
    "نوع-ملک": "نوع العقار", "انتخاب-نوع-ملک": "اختر نوع العقار",
    "آپارتمان": "شقة", "منزل-ویلایی": "فيلا", "ویلایی": "فيلا",
    "مغازه": "محل تجاري", "زمین": "أرض", "صنعتی-تجاری": "صناعي تجاري",
    "انتخاب-شهر": "اختر المدينة",
    "انتخاب-محله-درخواستی": "اختر الحي المطلوب",
    "حداقل-متراژ-درخواستی": "الحد الأدنى للمساحة المطلوبة",
    "حداکثر-متراژ-درخواستی": "الحد الأقصى للمساحة المطلوبة",
    "حداقل-مبلغ-اجاره": "الحد الأدنى لمبلغ الإيجار",
    "حداکثر-مبلغ-اجاره": "الحد الأقصى لمبلغ الإيجار",
    "حداقل-مبلغ-ودیعه": "الحد الأدنى للوديعة",
    "حداکثر-مبلغ-ودیعه": "الحد الأقصى للوديعة",
    "حداقل-مبلغ-خرید": "الحد الأدنى لسعر الشراء",
    "حداکثر-مبلغ-خرید": "الحد الأقصى لسعر الشراء",
    "یادداشت": "ملاحظة", "انتخاب-کارشناس": "اختر الوكيل",
    "ادامه": "متابعة", "خریدار-من": "عميلي",
    "جستجوی-خریداران": "بحث العملاء", "کد-مشتری": "رمز العميل",
    "نام-و-نام-خانوادگی": "الاسم الكامل",
    "حداقل-مساحت": "الحد الأدنى للمساحة",
    "حداکثر-مساحت": "الحد الأقصى للمساحة",
    "محله-های-درخواست": "الأحياء المطلوبة",
    "درخواست": "طلب", "در": "في", "تا": "حتى", "تومان": "درهم",
    "جزییات-خریدار": "تفاصيل العميل", "جزئیات-خریدار": "تفاصيل العميل",
    "مشخصات-خریدار": "بيانات العميل", "سپردن-ملک": "إيداع عقار",
    "محله-های-درخواستی": "الأحياء المطلوبة",
    "حداقل-متراژ": "الحد الأدنى للمساحة", "متر": "متر",
    "حداکثر-متراژ": "الحد الأقصى للمساحة",
    "حداقل-مبلغ": "الحد الأدنى للمبلغ", "حداکثر-مبلغ": "الحد الأقصى للمبلغ",
    "تعجیل-در-خرید": "الاستعجال في الشراء", "متوسط": "متوسط",
    "دلیل-خرید": "سبب الشراء", "نیاز-به-خانه": "حاجة لمنزل",
    "وضعیت-سکونت": "حالة السكن", "مقیم-غیر-محلی": "مقيم غير محلي",
    "مالک": "مالك", "سرمایه-گذاری": "استثمار",
    "ویرایش-خریدار": "تعديل العميل", "از": "من",
    "انتخاب-نمایید": "يرجى الاختيار",
    "سلام": "مرحباً",
    "ثبت-نام": "إنشاء حساب",
    "ایمیل": "البريد الإلكتروني",
    "آدرس": "العنوان",
    "انتخاب-زبان": "اختيار اللغة",
    "به-سایت-دارمکران-خوش-آمدید.": "أهلاً بك في موقع دارمكران.",
    "هنوز-ثبت-نام-نکرده-اید؟": "لم تسجل بعد؟",
    "گروه-مشاورین-املاک-دارمکران-با-سال‌ها-تجربه-ارزشمند-در-حوزه-خرید،-فروش-و-سرمایه‌گذاری-ملکی-در-دبی،-مفتخر-است-همراه-و-مشاور-مطمئن-شما-در-این-مسیر-باشد.-تیمی-از-کارشناسان-باتجربه-و-آگاه-به-بازار-املاک-امارات،-آماده‌اند-تا-با-ارائه-راهکارهای-تخصصی،-شما-را-در-حفظ-و-افزایش-سرمایه‌تان-یاری-رسانند.":
        "مجموعة مستشاري عقارات دارمكران، بخبرتها الثمينة في مجال شراء وبيع واستثمار العقارات في دبي، فخورة بأن تكون رفيقك ومستشارك الموثوق. فريق من الخبراء المتمرسين في سوق العقارات الإماراتي جاهز لمساعدتك في حفظ وزيادة استثمارك.",
    "هر-کجای-کشور-امارات-که-ملکی-برای-فروش-دارید-می-تونید-با-چند-کلیک-ساده-ملکتان-را-به-صورت-رایگان-در-دارمکران-آگهی-و-در-سریع-ترین-زمان-ممکن-معامله-کنید":
        "أينما كان لديك عقار للبيع في الإمارات، يمكنك بنقرات بسيطة نشر إعلانك مجاناً على دارمكران وإتمام الصفقة في أسرع وقت.",
    "املاک-دارمکران-یک-بنگاه-معاملات-ملکی-در-دبی-است-که-به‌طور-تخصصی-خدمات-خرید،-فروش-و-اجاره-ملک-را-به-سرمایه‌گذاران-ایرانی-ارائه-می‌دهد.-با-آشنایی-کامل-با-بازار-املاک-امارات،-املاک-دارمکران-مسیر-مطمئنی-برای-سرمایه‌گذاری،-خرید-خانه-و-دریافت-اقامت-در-دبی-فراهم-می‌کند.":
        "دارمكران للعقارات هي وكالة عقارية في دبي تقدم خدمات شراء وبيع وإيجار العقارات للمستثمرين. بفضل معرفتها الكاملة بسوق العقارات الإماراتي، توفر دارمكران مساراً آمناً للاستثمار وشراء المنازل والإقامة في دبي.",
}

WORD_REPLACEMENTS = [
    ("Properties Search", "بحث العقارات"), ("Add Property", "إضافة عقار"),
    ("Add Lead", "إضافة عميل"), ("Edit Lead", "تعديل العميل"),
    ("Lead Information", "معلومات العميل"), ("Lead Name", "اسم العميل"),
    ("Lead Details", "تفاصيل العميل"), ("Lead Detail", "تفاصيل العميل"),
    ("Lead Id", "رقم العميل"), ("My Leads", "عملائي"),
    ("My Leads List", "قائمة عملائي"), ("Register Lead", "تسجيل عميل"),
    ("Select Agent", "اختر الوكيل"), ("Contact An Agent", "الاتصال بالوكيل"),
    ("Find Agents", "البحث عن الوكلاء"), ("Add Agent", "تسجيل وكيل"),
    ("Main Admin", "المدير الرئيسي"), ("Demand Marketing", "تسويق الطلب"),
    ("Search Marketing", "بحث التسويق"), ("Brand List", "قائمة العلامات"),
    ("Create Brand", "إنشاء علامة"), ("Edit Brand", "تعديل العلامة"),
    ("Please Enter Your Mobile Number", "يرجى إدخال رقم جوالك"),
    ("Enter Your Password", "أدخل كلمة المرور"),
    ("Please Enter The Password Number", "يرجى إدخال كلمة المرور"),
    ("Login & Register", "تسجيل الدخول وإنشاء حساب"),
    ("Cash Payment", "دفع نقدي"), ("Payment Plan", "خطة دفع"),
    ("Payment Status", "حالة الدفع"), ("Property Type", "نوع العقار"),
    ("Request Type", "نوع الطلب"), ("Mobile Phone", "الهاتف المحمول"),
    ("Select The City", "اختر المدينة"),
    ("Select requested Neighborhood", "اختر الحي المطلوب"),
    ("Min Size (sqft)", "الحد الأدنى للمساحة"),
    ("Max Size (sqft)", "الحد الأقصى للمساحة"),
    ("Min Price (AED)", "الحد الأدنى للسعر"),
    ("Max Price (AED)", "الحد الأقصى للسعر"),
    ("Enter The Minimum Amount", "أدخل الحد الأدنى"),
    ("Enter The Maximum Amount", "أدخل الحد الأقصى"),
    ("Reason To Buy", "سبب الشراء"), ("For Living", "للسكن"),
    ("For Investment", "للاستثمار"), ("Non-local resident", "مقيم غير محلي"),
    ("Industrial-Commercial", "صناعي تجاري"),
    ("Add", "إضافة"), ("Property", "عقار"), ("Properties", "العقارات"),
    ("Lead", "عميل"), ("Leads", "العملاء"), ("Register", "تسجيل"),
    ("My", "لي"), ("List", "قائمة"), ("Search", "بحث"),
    ("Edit", "تعديل"), ("Delete", "حذف"), ("Create", "إنشاء"),
    ("Select", "اختيار"), ("Enter", "أدخل"), ("Please", "يرجى"),
    ("Minimum", "الحد الأدنى"), ("Maximum", "الحد الأقصى"),
    ("Amount", "المبلغ"), ("Price", "السعر"), ("Size", "المساحة"),
    ("Agent", "وكيل"), ("Agents", "الوكلاء"), ("Customer", "عميل"),
    ("Client", "عميل"), ("Dashboard", "لوحة التحكم"),
    ("Information", "معلومات"), ("Details", "التفاصيل"),
    ("Phone", "الهاتف"), ("Mobile", "الجوال"), ("Password", "كلمة المرور"),
    ("Login", "تسجيل الدخول"), ("Home", "الرئيسية"), ("City", "المدينة"),
    ("Type", "النوع"), ("Status", "الحالة"), ("Date", "التاريخ"),
    ("Time", "الوقت"), ("Name", "الاسم"), ("Email", "البريد الإلكتروني"),
    ("Note", "ملاحظة"), ("Image", "صورة"), ("Images", "الصور"),
    ("File", "ملف"), ("Files", "الملفات"), ("Submit", "إرسال"),
    ("Send", "إرسال"), ("Save", "حفظ"), ("Cancel", "إلغاء"),
    ("Close", "إغلاق"), ("Continue", "متابعة"), ("Success", "نجاح"),
    ("Error", "خطأ"), ("Yes", "نعم"), ("No", "لا"), ("All", "الكل"),
    ("New", "جديد"), ("Free", "مجاني"), ("Optional", "اختياري"),
    ("Buy", "شراء"), ("Rent", "إيجار"), ("Sale", "بيع"),
    ("Owner", "مالك"), ("Contract", "عقد"), ("Project", "مشروع"),
    ("Brand", "علامة"), ("Comment", "تعليق"), ("Booking", "حجز"),
    ("Visit", "زيارة"), ("Request", "طلب"), ("Marketing", "تسويق"),
    ("Floor", "طابق"), ("Room", "غرفة"), ("Building", "مبنى"),
    ("Apartment", "شقة"), ("Villa", "فيلا"), ("Land", "أرض"),
    ("Shop", "محل"), ("Parking", "موقف"), ("Pool", "مسبح"),
    ("Garden", "حديقة"), ("View", "إطلالة"), ("Deposit", "وديعة"),
    ("Mortgage", "رهن"), ("Cash", "نقد"), ("Payment", "دفع"),
    ("Filter", "تصفية"), ("Show", "عرض"), ("More", "المزيد"),
    ("Total", "الإجمالي"), ("Number", "الرقم"), ("Code", "الرمز"),
    ("Tag", "وسم"), ("Share", "مشاركة"), ("Compare", "مقارنة"),
    ("Favorite", "مفضلة"), ("Favorites", "المفضلة"),
    ("Admin", "مدير"), ("User", "مستخدم"), ("Expert", "خبير"),
    ("Advisor", "مستشار"), ("Manager", "مدير"), ("Referrer", "مسوق"),
    ("Profile", "الملف الشخصي"), ("Settings", "الإعدادات"),
    ("Document", "مستند"), ("Documents", "المستندات"),
    ("Description", "الوصف"), ("Title", "العنوان"), ("Content", "المحتوى"),
    ("Active", "نشط"), ("Inactive", "غير نشط"), ("Pending", "قيد الانتظار"),
    ("Approved", "موافق عليه"), ("Rejected", "مرفوض"),
    ("Contact", "اتصال"), ("Message", "رسالة"), ("Report", "تقرير"),
    ("Upload", "رفع"), ("Download", "تحميل"), ("Map", "خريطة"),
    ("Location", "الموقع"), ("Address", "العنوان"), ("District", "الحي"),
    ("sqft", "قدم²"), ("AED", "درهم"), ("Up", "فأكثر"),
    ("From", "من"), ("Until", "حتى"), ("In", "في"), ("To", "إلى"),
    ("For", "لـ"), ("And", "و"), ("Or", "أو"), ("With", "مع"),
    ("By", "بواسطة"), ("Your", "خاصتك"), ("You", "أنت"), ("We", "نحن"),
    ("Our", "نحن"), ("The", ""), ("This", "هذا"), ("That", "ذلك"),
    ("Not", "لا"), ("Low", "منخفض"), ("Average", "متوسط"),
    ("High", "مرتفع"), ("Area", "المنطقة"), ("Areas", "المناطق"),
    ("Neighborhood", "الحي"), ("Reason", "السبب"), ("Priority", "الأولوية"),
    ("Housing", "السكن"), ("Convert", "تحويل"), ("Detail", "التفاصيل"),
    ("Exit", "خروج"), ("Tel", "الهاتف"), ("Note", "ملاحظة"),
]


def translate_en_to_ar(english: str) -> str:
    if english in ARABIC_MAP:
        return ARABIC_MAP[english]
    result = english
    for en, ar in WORD_REPLACEMENTS:
        if en and ar:
            result = re.sub(r"\b" + re.escape(en) + r"\b", ar, result)
    result = re.sub(r"\s+", " ", result).strip()
    return result if result else english


def persian_fallback(key: str) -> str:
    if key in FA_AR_DIRECT:
        return FA_AR_DIRECT[key]
    persian = key.replace("-", " ")
    sorted_items = sorted(FA_AR_DIRECT.items(), key=lambda x: len(x[0]), reverse=True)
    result = persian
    for fa_key, ar_val in sorted_items:
        fa_text = fa_key.replace("-", " ")
        if fa_text and fa_text in result:
            result = result.replace(fa_text, ar_val)
    return result.strip() if result.strip() else persian


def is_english_like(value: str) -> bool:
    return bool(re.search(r"[A-Za-z]{3,}", value)) and not bool(re.search(r"[\u0600-\u06FF]", value))


def main():
    en_content = EN_PATH.read_text(encoding="utf-8")
    en = parse_php_array(en_content)

    output = {}
    if MESSAGES_PATH.exists():
        output.update(parse_php_array(MESSAGES_PATH.read_text(encoding="utf-8")))
    if AR_PATH.exists():
        output.update(parse_php_array(AR_PATH.read_text(encoding="utf-8")))

    for key, english in en.items():
        existing = output.get(key, "")
        if existing and not is_english_like(existing) and existing != key.replace("-", " "):
            continue

        arabic = FA_AR_DIRECT.get(key)
        if not arabic:
            arabic = persian_fallback(key)
        if (not arabic or arabic == key.replace("-", " ") or is_english_like(arabic)) and english:
            arabic = translate_en_to_ar(english)
        if is_english_like(arabic):
            arabic = persian_fallback(key)

        output[key] = arabic

    lines = ["<?php", "", "return ["]
    for k in sorted(output.keys()):
        lines.append(f"    '{escape_php(k)}' => '{escape_php(output[k])}',")
    lines.append("];")
    lines.append("")

    AR_PATH.write_text("\n".join(lines), encoding="utf-8")
    print(f"Generated {len(output)} Arabic translations to {AR_PATH}")


if __name__ == "__main__":
    main()
