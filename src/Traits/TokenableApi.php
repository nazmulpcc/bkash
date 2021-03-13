<?php

namespace Shipu\Bkash\Traits;

use Illuminate\Support\Facades\Log;
use Shipu\Bkash\Enums\BkashKey;

/**
 * Trait TokenableApi
 * @package Shipu\Bkash\Traits
 */
trait TokenableApi
{
    /**
     * @return mixed
     */
    public function grantToken()
    {
        try {
            $tokenResponse = $this->json($request = [
                'app_key'    => $this->config [ BkashKey::APP_KEY ],
                'app_secret' => $this->config [ BkashKey::APP_SECRET ],
            ])->headers($headers = [
                'username' => $this->config [ BkashKey::USER_NAME ],
                'password' => $this->config [ BkashKey::PASSWORD ],
            ])->post('/token/grant');
        }catch (\Exception $e){
            Log::info('bkash token request', compact('request', 'headers'));
            throw $e;
        }

        return $tokenResponse;
    }

    /**
     * @param $refreshToken
     *
     * @return mixed
     */
    public function refreshToken( $refreshToken )
    {
        $refreshTokenResponse = $this->json([
            'app_key'       => $this->config [ BkashKey::APP_KEY ],
            'app_secret'    => $this->config [ BkashKey::APP_SECRET ],
            'refresh_token' => $refreshToken,
        ])->headers([
            'username' => $this->config [ BkashKey::USER_NAME ],
            'password' => $this->config [ BkashKey::PASSWORD ],
        ])->post('/token/grant');

        return $refreshTokenResponse;
    }
}
