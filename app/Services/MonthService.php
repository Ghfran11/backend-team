<?php

namespace App\Services;

use Illuminate\Support\Carbon;

class MonthService
{
    public function getPreviousMonths($count)
    {
        $months = $this->getMonthsCollection();
        $currentMonth = Carbon::now()->month;
        $previousMonths = $months->slice($currentMonth - $count, $count)->reverse();
        return $previousMonths->toArray();
    }

    private function getMonthsCollection()
    {
        return collect(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
    }
}
