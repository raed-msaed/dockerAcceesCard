<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Imports\EmployeesImport;
use App\Models\Employee;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('importEmployees')
                ->label('إستيراد ملف')
                ->color('danger')
                ->icon('heroicon-o-arrow-down-tray')
                ->form([
                    FileUpload::make('attachment'),
                ])
                ->action(function (array $data) {

                    //dd($data);
                    $file = public_path('storage/' . $data['attachment']);
                    // dd($file);
                    Excel::Import(new EmployeesImport, $file);
                    Notification::make()
                        ->title('عملية الإستراد قائمة المنتفعين تمت بنجاح')
                        ->success()
                        ->send();
                })
        ];
    }

    public function getTabs(): array
    {
        return [
            'الكل' => Tab::make(),
            'هذا الأسبوع' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    $query->whereHas('badgets', function (Builder $query) {
                        $query->whereBetween('date_end_badget', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                            ->whereIn('id', function ($subQuery) {
                                $subQuery->select(DB::raw('MAX(badgets.id)'))
                                    ->from('badgets')
                                    ->groupBy('employee_id');
                            });
                    });
                })
                ->badge(
                    Employee::query()
                        ->whereHas('badgets', function (Builder $query) {
                            $query->whereBetween('date_end_badget', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                ->whereIn('id', function ($subQuery) {
                                    $subQuery->select(DB::raw('MAX(badgets.id)'))
                                        ->from('badgets')
                                        ->groupBy('employee_id');
                                });
                        })->count()
                ),
            'هذا الشهر' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    $query->whereHas('badgets', function (Builder $query) {
                        $query->whereBetween('date_end_badget', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                            ->whereIn('id', function ($subQuery) {
                                $subQuery->select(DB::raw('MAX(badgets.id)'))
                                    ->from('badgets')
                                    ->groupBy('employee_id');
                            });
                    });
                })
                ->badge(
                    Employee::query()
                        ->whereHas('badgets', function (Builder $query) {
                            $query->whereBetween('date_end_badget', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                                ->whereIn('id', function ($subQuery) {
                                    $subQuery->select(DB::raw('MAX(badgets.id)'))
                                        ->from('badgets')
                                        ->groupBy('employee_id');
                                });
                        })->count()
                ),
            'هذه السنة' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    $query->whereHas('badgets', function (Builder $query) {
                        $query->whereBetween('date_end_badget', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
                            ->whereIn('id', function ($subQuery) {
                                $subQuery->select(DB::raw('MAX(badgets.id)'))
                                    ->from('badgets')
                                    ->groupBy('employee_id');
                            });
                    });
                })
                ->badge(
                    Employee::query()
                        ->whereHas('badgets', function (Builder $query) {
                            $query->whereBetween('date_end_badget', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
                                ->whereIn('id', function ($subQuery) {
                                    $subQuery->select(DB::raw('MAX(badgets.id)'))
                                        ->from('badgets')
                                        ->groupBy('employee_id');
                                });
                        })->count()
                ),
        ];
    }
}
