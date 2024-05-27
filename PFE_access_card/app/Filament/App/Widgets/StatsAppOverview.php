<?php

namespace App\Filament\App\Widgets;

use App\Models\Badget;
use App\Models\Employee;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsAppOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $latestBadgetsSubquery = Badget::select(DB::raw('MAX(id) as max_id'))
            ->groupBy('employee_id');

        $invalidBadgetsCount = Badget::where(function ($query) use ($latestBadgetsSubquery) {
            $query->where('date_end_badget', '<', Carbon::now())
                ->where('situational_badget', 'معتمدة')
                ->where('state_badget', 'سلمت')
                ->whereIn('id', function ($subQuery) use ($latestBadgetsSubquery) {
                    $subQuery->select('max_id')
                        ->fromSub($latestBadgetsSubquery, 'latest_badgets');
                });
        })
            ->count();


        return [
            Stat::make('المنتفعين', Employee::query()->count())
                ->description('جميع المنتفعين')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('عدد البطاقات الغير صالحة', $invalidBadgetsCount)
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
            Stat::make('عدد البطاقات الصالحة', Employee::whereHas('badgets', function ($query) {
                $query->where('situational_badget', 'معتمدة')->where('state_badget', 'سلمت')->where('date_end_badget', '>', Carbon::now());
            })->count())
                ->chart([17, 12, 1, 13, 5, 14, 7])
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}