# سرویس پیامکی قاصدک

سلام به روی ماهتون. این یه پکیج لاراوله برای ارسال پیامک از طریق [سامانه پیام کوتاه قاصدک](https://ghasedaksms.com/).

## نصب
برای نصب از کمپوزر استفاده میکنیم:

```bash
composer require fibdesign/sms
```

برای اینکه بتونید تنظیمات شخصی خودتون رو انجام بدین، فایل کانفیگ پکیج رو بیایم انتقال بدیم به پوشه کانفیگ پروژه
```bash
php artisan vendor:publish
```
    
بعد از وارد کردن این کامند، پروایدر زیر رو انتخاب کنید:

     - Fibdesign\Sms\Providers\SmsProvider

یادتون نره که مقادیر رو توی env هم بزارید
```dotenv
SMS_API_KEY=apikey
SMS_SENDER=تلفن ارسال کننده در سامانه
```
## متد های موجود در این نسخه از پکیج

توی نسخه فعلی پکیج میتونید یکی از کارهای زیر رو انجام بدین:

 1. ارسال تکی پیامک
 2. ارسال گروهی پیامک
 3. ارسال با قالب از پیش تعریف شده در سامانه
 4. دریافت باقی مانده اعتبار
 5. لیست پیام های دریافتی


## مقدار ها

| METHOD 	    | SYNTAX 	            | REQURIED | DESCRIPTION 	                                                                                                           | EXAMPLE 	                                          |
|-------------|---------------------|----------|-------------------------------------------------------------------------------------------------------------------------|----------------------------------------------------|
| to()        | `array` of strings  | بلی      | لیستی از تلفن های همراه که میخوای بهشون پیام بدی	                                                                       | $smsService->to(["0915348484"])                    |
| 	 testers() | `array` of strings	 | خیر      | لیستی از تلفن های اضافه. برای مثال وقتی میخوای تلفن خودت توی همه پیام ها باشه، میتونی شماره خودت رو اینجا اضافه کنی.  	 | $smsService->testers(["0915348484"])                    |
| template()	 | 	    `string`       | خیر      | مقداری که از قبل توی داشبورد توی سامانه تعریف کردی	                                                                     | 	       $smsService->template('phoneVerification') |
| 	as()       | 	  `string`         | خیر       | مقادیر قابل قبول: `single`, `group`, `credit`, `receive` و `template`. مقدار پیشفرض: `single`.	                         | 	$smsService->as('single')                         |
| message()	  | `string`	           | بلی      | 	متن پیام.                                                                                                              | 	     $smsService->message("Hi from Ghasedak")     |
| dispatch()	 | 	    void           | بلی      | 	برای اینکه عمل ارسال انجام بشه، این رو حتما در آخر فراخوانی کنید                                                       | 	        $smsService->dispatch()                                          |


## نحوه استفاده

### بریم با هم چند تا نمونه ببینیم

ارسال پیام تکی

```php
$smsService->to(["0915221484"])
    ->message("تست پیام")
    ->dispatch();
```

ارسال پیام گروهی

```php
$smsService->to(["0915221484","0915221484"])
    ->message("تست پیام")
    ->as("group")
    ->dispatch();
```
ارسال پیام با استفاده از قالب

```php
$smsService->to(["0915221484","0915221484"])
    ->message("تست پیام")
    ->template("phoneVerification")
    ->as("template")
    ->dispatch();
```
دریافت مقدار باقی مانده کیف پول

```php
$smsService
    ->as("credit")
    ->dispatch();
```

## نکته
توی پیام هاتون حتما کلمه `لغو 11` رو قرار بدید وگرنه به مشکل میخورید!
