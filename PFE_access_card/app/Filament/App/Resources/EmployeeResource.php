<?php

namespace App\Filament\App\Resources;

use App\Exports\CardEmployeeExport;
use App\Filament\App\Resources\EmployeeResource\Pages;
use App\Filament\App\Resources\EmployeeResource\RelationManagers;
use App\Filament\App\Resources\EmployeeResource\RelationManagers\BadgetsRelationManager;
use App\Models\Employee;
use App\Models\Grade;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationLabel = 'المنتفعين';

    protected static ?string $pluralModelLabel = 'قائمة المنتفعين';

    protected static ?string $modelLabel = 'منتفع';

    protected static ?string $navigationGroup = 'التصرف في بطاقات الدخول';

    protected static ?int $navigationSort = 1;


    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->first_name;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['first_name', 'last_name', 'grade.name'];
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'success';
        //return static::getModel()::count() >  5 ? 'warning' : 'success';
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'الإسم' => $record->first_name,
            'اللقب' => $record->last_name,
            'الرتبة' => $record->Grade->name,
            'تاريخ نهاية الصلوحية' => $record->badgets()->latest('id')->first()?->date_end_badget,
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->label('الإسم')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('last_name')
                    ->label('اللقب')
                    ->required()
                    ->maxLength(20),
                Forms\Components\Select::make('sort')
                    ->label('الصفة')
                    ->options([
                        'عسكري' => 'عسكري',
                        'مدني' => 'مدني',
                    ]),
                Forms\Components\TextInput::make('matricule')
                    ->label('رقم التجنيد')
                    ->numeric()
                    ->maxLength(20)
                    ->default(null),
                Forms\Components\Select::make('armee')
                    ->label('جيش الإنتماء')
                    ->options([
                        'البر' => 'البر',
                        'الطيران' => 'الطيران',
                        'البحر' => 'البحر',
                    ])
                    ->default(null),
                Forms\Components\Select::make('category_id')
                    ->label('الصنف')
                    ->relationship(name: 'category', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->afterStateUpdated(fn (Set $set) => $set('grade_id', null))
                    ->live()
                    ->default(null),
                Forms\Components\Select::make('grade_id')
                    ->label('الرتبة')
                    ->options(fn (Get $get): Collection => Grade::query()
                        ->where('category_id', $get('category_id'))
                        ->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->live()
                    ->default(null),
                Forms\Components\Select::make('organisation_id')
                    ->label('جهة الإنتماء')
                    ->relationship(name: 'organisation', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->default(null),

            ])->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->label('الإسم')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label('اللقب')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sort')
                    ->label('الصفة')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('organisation.name')
                    ->label('جهة الإنتماء')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('الصنف')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('grade.name')
                    ->label('الرتبة')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('badgets.number_badget')
                    ->getStateUsing(function (Model $record) {
                        return $record->badgets()->latest('id')->first()?->number_badget;
                    })
                    ->label('رقم البطاقة')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('badgets.date_end_badget')
                    ->getStateUsing(function (Model $record) {
                        return $record->badgets()->latest('id')->first()?->date_end_badget;
                    })
                    ->label('تاريخ نهاية صلوحية')
                    ->dateTime('Y/m/d')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('badgets.situational_badget')
                    ->getStateUsing(function (Model $record) {
                        return $record->badgets()->latest('id')->first()?->situational_badget;
                    })
                    ->label('وضعية البطاقة')
                    ->searchable(),
                Tables\Columns\TextColumn::make('badgets.state_badget')
                    ->getStateUsing(function (Model $record) {
                        return $record->badgets()->latest('id')->first()?->state_badget;
                    })
                    ->label('حالة البطاقة')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('تاريخ التعديل')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('organisation')
                    ->label('التصفية حسب جهة الإنتماء')
                    ->relationship('organisation', 'name')
                    ->searchable()
                    ->preload()
                    ->indicator('جهة الإنتماء'),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')->label('تاريخ الإنشاء من'),
                        DatePicker::make('created_until')->label('تاريخ الإنشاء إلى'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['created_from'] ?? null) {
                            $indicators[] = Indicator::make('تاريخ الإنشاء من' . Carbon::parse($data['created_from'])->toFormattedDateString())
                                ->removeField('created_from');
                        }

                        if ($data['created_until'] ?? null) {
                            $indicators[] = Indicator::make('تاريخ الإنشاء إلى' . Carbon::parse($data['created_until'])->toFormattedDateString())
                                ->removeField('created_until');
                        }

                        return $indicators;
                    })->columnSpan(2)->columns(2),
            ], layout: FiltersLayout::AboveContent)->filtersFormColumns(3)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('تم حذف البطاقة')
                            ->body('تم حذف البطاقة بنجاح')
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('export')
                        ->label('تصدير بيانات')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->action(function (Collection $records) {
                            return Excel::download(new CardEmployeeExport($records), 'CradEmployee.xlsx');
                        })
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            BadgetsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            // 'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
