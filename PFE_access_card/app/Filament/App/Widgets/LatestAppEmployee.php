<?php

namespace App\Filament\App\Widgets;

use App\Models\Badget;
use App\Models\Employee;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LatestAppEmployee extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading =  'الأفراد التي تحمل بطاقات منتهية الصلوحية';

    public function table(Table $table): Table
    {

        $invalidBadgets = Badget::select('employees.*', 'badgets.*', 'grades.name as grade_name')
            ->join('employees', 'employees.id', '=', 'badgets.employee_id')
            ->leftJoin('grades', 'grades.id', '=', 'employees.grade_id')
            ->where('badgets.date_end_badget', '<', now())
            ->where('badgets.situational_badget', '=', 'معتمدة')
            ->where('badgets.state_badget', '=', 'سلمت');

        return $table

            ->query($invalidBadgets)

            ->columns([

                Tables\Columns\TextColumn::make('first_name')
                    ->label('الإسم')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label('اللقب')
                    ->searchable(),
                Tables\Columns\TextColumn::make('grade_name')
                    ->label('الرتبة')
                    ->searchable(),
                Tables\Columns\TextColumn::make('number_badget')
                    /*   ->getStateUsing(function (Model $record) {
                        return $record->badgets()->latest('id')->first()?->number_badget;
                    })*/
                    ->label('رقم البطاقة')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image_badget')
                    /*  ->getStateUsing(function (Model $record) {
                        return $record->badgets()->latest('id')->first()?->image_badget;
                    })*/
                    ->label('النسخة'),
                Tables\Columns\TextColumn::make('date_start_badget')
                    /*  ->getStateUsing(function (Model $record) {
                        return $record->badgets()->latest('id')->first()?->date_start_badget;
                    })*/
                    ->label('تاريخ بداية صلوحية')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('date_end_badget')
                    /*  ->getStateUsing(function (Model $record) {
                        return $record->badgets()->latest('id')->first()?->date_end_badget;
                    })*/
                    ->label('تايخ نهاية صلوحية')
                    ->searchable()
                    ->sortable(),
            ]);
    }
}
