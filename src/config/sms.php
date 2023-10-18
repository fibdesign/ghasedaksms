<?php

return [
    "url" => [
        // to use template, you need to first add your template in website. then use: ->template($yourTemplateName)
        "template" => env('SMS_URL_SINGLE', 'http://api.ghasedaksms.com/v2/send/verify'),
        "single" => env('SMS_URL_GROUP', 'http://api.ghasedaksms.com/v2/sms/send/simple'),
        "group" => env('SMS_URL_GROUP', 'http://api.ghasedaksms.com/v2/sms/send/bulk2'),
        "credit" => env('SMS_URL_CREDIT', 'http://api.ghasedaksms.com/v2/credit'),
        "receive" => env('SMS_URL_CREDIT', 'http://api.ghasedaksms.com/v2/sms/recive'),
    ],
    "apiKey" => env('SMS_API_KEY', 'xxx'),
    "sender" => env('SMS_SENDER', 'xxx'),
    "messageType" => env('SMS_MESSAGE_TYPE', "text"), // text, voice
];
