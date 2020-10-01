<?php

namespace App;

class Textlocal extends TextLocalOriginal
{
    private $sender;
    /**
     * @param string $message
     * @param string $receiver
     * @param string $sender
     * @return array|mixed
     * @throws \Exception
     */
    public function send($message, $receiver, $sender = '')
    {
        $result = $this->sendSms([$receiver], $message, $sender != '' ? $sender : $this->sender);
        return $result;
    }
}
