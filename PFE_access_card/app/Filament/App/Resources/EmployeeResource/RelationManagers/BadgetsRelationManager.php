<?php

namespace App\Filament\App\Resources\EmployeeResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BadgetsRelationManager extends RelationManager
{
    protected static string $relationship = 'badgets';

    protected static ?string $title = 'البطاقات';

    //protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationLabel = 'البطاقة';

    protected static ?string $pluralModelLabel = 'قائمة البطاقة';

    protected static ?string $modelLabel = 'بطاقة';
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('number_badget')
                    ->label('رقم البطاقة')
                    ->maxLength(20)
                    ->default(null),

                Forms\Components\Select::make('situational_badget')
                    ->label('وضعية البطاقة')
                    ->options([
                        'معتمدة' => 'معتمدة',
                        'غير معتمدة' => 'غير معتمدة',
                    ]),
                Forms\Components\Select::make('state_badget')
                    ->label('حالة البطاقة')
                    ->options([
                        'سلمت' => 'سلمت',
                        'لم تسلم' => 'لم تسلم',
                        'أرجعت' => 'أرجعت',
                    ]),
                Forms\Components\DatePicker::make('date_start_badget')
                    ->label('تاريخ بداية الصلوحية')
                    ->native(false)
                    ->displayFormat('Y/m/d'),
                Forms\Components\DatePicker::make('date_end_badget')
                    ->label('تاريخ نهاية الصلوحية')
                    ->native(false)
                    ->displayFormat('Y/m/d'),

                Forms\Components\TextInput::make('description')
                    ->label('الملاحظات')
                    ->maxLength(20)
                    ->default(null),

                Forms\Components\Section::make('نسخة من البطاقة')
                    ->description('')
                    ->schema([
                        FileUpload::make('image_badget')->disk('public')->openable()->downloadable()->deletable(true)->label(''),
                    ]),
            ])->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('number_badget')

            ->columns([
                Tables\Columns\TextColumn::make('number_badget')
                    ->label('رقم البطاقة')
                    ->searchable(),
                Tables\Columns\TextColumn::make('situational_badget')
                    ->label('الوضعية')
                    ->searchable(),
                Tables\Columns\TextColumn::make('state_badget')
                    ->label('الحالة')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image_badget')
                    ->label('النسخة'),
                Tables\Columns\TextColumn::make('date_start_badget')
                    ->label('تاريخ بداية صلوحية')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('date_end_badget')
                    ->label('تايخ نهاية صلوحية')
                    ->searchable()
                    ->sortable(),
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
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}