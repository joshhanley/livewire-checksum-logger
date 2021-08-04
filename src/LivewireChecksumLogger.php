<?php

namespace LivewireChecksumLogger;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Livewire\Livewire;

class LivewireChecksumLogger
{
    public static function logInitialResponse()
    {
        Livewire::listen('mounted', function ($response) {
            self::log('RESPONSE', $response->fingerprint, $response->memo);
        });
    }

    public static function logRequest(Request $request)
    {
        $payload = $request->only([
            'fingerprint',
            'serverMemo',
            'updates',
        ]);

        if (! isset($payload['fingerprint']) || ! isset($payload['serverMemo'])) {
            return;
        }

        self::log('REQUEST', $payload['fingerprint'], $payload['serverMemo']);
    }

    public static function log($type, $fingerprint, $memo)
    {
        $channel = config('livewire-checksum-logger.channel', 'log');

        $memoSansChildren = array_diff_key($memo, array_flip(['children', 'checksum']));

        $message = "LIVEWIRE COMPONENT \"{$fingerprint['name']}\":\"{$fingerprint['id']}\" - {$type}";

        switch ($channel) {
            case 'ray':
                if(function_exists('ray')) {
                    ray($message, ['fingerprint' => $fingerprint, 'memo' => $memoSansChildren]);
                    break;
                }
            case 'log':
            default:
                Log::info($message, ['fingerprint' => $fingerprint, 'memo' => $memoSansChildren]);
        }
    }
}
