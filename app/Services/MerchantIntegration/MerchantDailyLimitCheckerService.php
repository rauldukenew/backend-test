<?php

namespace App\Services\MerchantIntegration;

use Carbon\CarbonImmutable;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class MerchantDailyLimitCheckerService
{
    public function checkMerchantHasLimit(int $merchantId, int $limit): bool
    {
        $now = CarbonImmutable::now();
        $startOfDay = $now->startOfDay();
        $endOfDay = $now->endOfDay();
        $paidStatusName = "paid";
        $dailyPaidPaymentsSum = DB::query()->from('payments as p')
            ->join('payment_statuses as s', function (JoinClause $join) use (
                $paidStatusName,
                $startOfDay,
                $endOfDay
            ) {
                $join->on('p.payment_status_id', '=', 's.id')
                    ->where('s.title', $paidStatusName)
                    ->whereBetween('p.updated_at', [$startOfDay, $endOfDay]);
            })
            ->join('merchants as m', function (JoinClause $join) use ($merchantId) {
                $join->on('p.merchant_id', '=', 'm.id')
                    ->where('m.merchant_id', $merchantId);
            })
            ->selectRaw('COALESCE(SUM(p.amount_paid),0) as sum')
            ->get()
            ->first()
            ->sum;
        return $dailyPaidPaymentsSum <= $limit; // return 200 ok or abort(403)
    }
}
