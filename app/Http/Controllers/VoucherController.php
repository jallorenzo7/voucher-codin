<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VoucherService;
use App\Models\Voucher;

class VoucherController extends Controller
{
    public function __construct(VoucherService $voucherService)
    {
        $this->voucherService = $voucherService;
    }

    public function index()
    {
        $user = auth()->user();

        return response()->json([
            'vouchers' => $user->vouchers
        ]);
    }

    public function generate()
    {
        $user = auth()->user();

        if ($user->vouchers()->count() >= 10) {
            return response()->json([
                'error' => 'You cannot generate more than 10 voucher codes.'
            ], 403);
        }

        $voucher = $this->voucherService->generate($user);

        return response()->json([
            'voucher' => $voucher
        ]);
    }

    public function destroy($id)
    {
        $voucher = Voucher::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$voucher) {
            return response()->json(['error' => 'Voucher not found.'], 404);
        }

        $voucher->delete();

        return response()->json(['message' => 'Voucher deleted successfully.']);
    }
}
