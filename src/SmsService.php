<?php
namespace Fibdesign\Sms;

use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class SmsService
{
    private string $url;
    private string $apiKey;
    private string $sender;
    private array $receptor;
    private string $message;
    private int $messageType;
    private string $template;
    private string $smsType;


    public function __construct()
    {
        $this->url = config('sms.url.single');
        $this->apiKey = config('sms.apiKey');
        $this->sender = config('sms.sender');
        $this->messageType = config('sms.messageType') === "text" ? 1 : 2;
        $this->template = "";
        $this->receptor = [""];
        $this->smsType = 'single';
    }

    public function to(array $receptor): self
    {
        $this->receptor = $receptor;
        return $this;
    }

    public function testers(array $phones): self
    {
        foreach ($phones as $phone){
            $this->receptor[] = $phone;
        }
        return $this;
    }

    public function template(string $template): self
    {
        $this->template = $template;
        return $this;
    }

    public function as(string $smsType):self
    {
        $this->url = match ($smsType) {
            'group' => config('sms.url.group'),
            'template' => config('sms.url.template'),
            'credit' => config('sms.url.credit'),
            'receive' => config('sms.url.receive'),
            default => config('sms.url.single')
        };
        $this->smsType = $smsType;
        return $this;
    }

    public function message(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    private function getFields():string{
        $receptor = implode(",", $this->receptor);
        $fieldsArray = match ($this->smsType){
            'template' => [
                "type" => $this->messageType,
                "receptor" => $receptor,
                "template" => $this->template,
                "param1" => $this->message
            ],
            'credit' => [],
            'receive' => [
                'linenumber' => config('sms.sender'),
                'isread' => '0',
            ],
            default => [
                "message" => $this->message,
                "sender" => $this->sender,
                "Receptor" => $receptor,
            ]
        };
        return http_build_query($fieldsArray);
    }

    public function dispatch($returnItem = ''):string
    {
        $curl = curl_init();
        curl_setopt_array($curl,
            array(
                CURLOPT_URL => $this->url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $this->getFields(),
                CURLOPT_HTTPHEADER => array(
                    "apikey: $this->apiKey",
                    "cache-control: no-cache",
                    "content-type: application/x-www-form-urlencoded",
                )));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return $err;
        }
        return match ($returnItem) {
            'list' => json_decode($response)->list,
            'credit' => json_decode($response)->credit,
            default => $response
        };
    }
}
