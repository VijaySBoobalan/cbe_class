<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Twilio\Rest\Client;
class Token extends Model
{
    const EXPIRATION_TIME = 5; // minutes

    protected $fillable = [
        'code',
        'user_id',
        'used'
    ];

    public function __construct(array $attributes = [])
    {
        if (! isset($attributes['code'])) {
            $attributes['code'] = $this->generateCode();
        }

        parent::__construct($attributes);
    }

    /**
     * Generate a six digits code
     *
     * @param int $codeLength
     * @return string
     */
    public function generateCode($codeLength = 3)
    {
        $min = pow(10, $codeLength);
        $max = $min * 10 - 1;
        $code = mt_rand($min, $max);

        return $code;
    }

    /**
     * User tokens relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * True if the token is not used nor expired
     *
     * @return bool
     */
    public function isValid()
    {
        return ! $this->isUsed() && ! $this->isExpired();
    }

    /**
     * Is the current token used
     *
     * @return bool
     */
    public function isUsed()
    {
        return $this->used;
    }

    /**
     * Is the current token expired
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->created_at->diffInMinutes(Carbon::now()) > static::EXPIRATION_TIME;
    }

    public function sendCode($user){
        if (! $this->user) {
            throw new \Exception("No user attached to this token.");
        }

        if (! $this->code) {
            $this->code = $this->generateCode();
        }

        try {
            // Authorisation details.
            // $username = "ttsvle@gmail.com";
            // $hash = "3fd6b7be8ca215742dd68b81b32f7e2121cd8ddc18f20b8a41e70e8b8cb60851";

            $username = "j.aravindhgopi@gmail.com";
            $hash = "e77c1cbdc7b6838cc5a8612ff67c676589d4eba5d37b957d486bfa8a081b0733";

            // Config variables. Consult http://api.textlocal.in/docs for more info.
            $test = "0";

            // Data for text message. This is the text message data.
            $sender = "TXTLCL"; // This is who the message appears to be from.
            $numbers = $user->mobile_number; // A single number or a comma-seperated list of numbers
            $message = "Your verification code is {$this->code}";
            // 612 chars or less
            // A single number or a comma-seperated list of numbers
            $message = urlencode($message);
            $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
            $ch = curl_init('http://api.textlocal.in/send/?');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch); // This is the result from the API
            curl_close($ch);
            return true;
            // $client->messages->create("+918667804277",
            //     ['from' => "+12058989006", 'body' => "Your verification code is {$this->code}"]);
        } catch (\Exception $ex) {
            return false; //enable to send SMS
        }

        return true;
    }
}
