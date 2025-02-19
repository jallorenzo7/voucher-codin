<?php

namespace App\Services;

use App\Models\Voucher;

class VoucherService
{
    public function uniqueCode($user)
    {
        do {
            $code = strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));
        } while (Voucher::where('code', $code)->where('user_id', $user->id)->exists());

        return $code;
    }

    public function generate($user)
    {
        return Voucher::create([
            'user_id' => $user->id,
            'code' => $this->uniqueCode($user)
        ]);
    }
}
