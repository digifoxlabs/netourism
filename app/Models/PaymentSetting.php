<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $fillable = [
        'enabled',
        'environment',
        'demo_url',
        'live_url',
        'alt_id_demo_url',
        'alt_id_live_url',
        'merchant_key',
        'merchant_salt',
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    public static function current(): self
    {
        return static::firstOrCreate([], [
            'enabled' => false,
            'environment' => 'demo',
            'demo_url' => 'https://sandboxsecure.payu.in/_payment',
            'live_url' => 'https://secure.payu.in/_payment',
            'alt_id_demo_url' => 'https://apitest.payu.in/card/altid',
            'alt_id_live_url' => 'https://api.payu.in/card/altid',
        ]);
    }

    public function checkoutUrl(): string
    {
        return $this->environment === 'live' ? $this->live_url : $this->demo_url;
    }

    public function altIdUrl(): string
    {
        return $this->environment === 'live' ? $this->alt_id_live_url : $this->alt_id_demo_url;
    }

    public function isReady(): bool
    {
        return $this->enabled
            && filled($this->checkoutUrl())
            && filled($this->merchant_key)
            && filled($this->merchant_salt);
    }
}
