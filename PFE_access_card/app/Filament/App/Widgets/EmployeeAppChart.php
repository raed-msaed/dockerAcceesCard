<?php

namespace App\Filament\App\Widgets;

use App\Models\Badget;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\DB;

class EmployeeAppChart extends ChartWidget
{
    protected static ?string $heading = 'عدد البطاقات المنتهية الصلوحية حسب الشهر';

    protected static ?int $sort = 3;

    protected static string $color = 'info';

    protected function getData(): array
    {
        $latestBadgetsSubquery = Badget::select(DB::raw('MAX(id) as max_id'))
            ->groupBy('employee_id');

        $invalidBadgetsCount = Badget::where(function ($query) use ($latestBadgetsSubquery) {
            $query->where('situational_badget', 'معتمدة')
                ->where('state_badget', 'سلمت')
                ->whereIn('id', function ($subQuery) use ($latestBadgetsSubquery) {
                    $subQuery->select('max_id')
                        ->fromSub($latestBadgetsSubquery, 'latest_badgets');
                });
        });

        $data = Trend::query($invalidBadgetsCount)
            ->dateColumn('date_end_badget')
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'عدد البطاقات المنتهية الصلوحية',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
