<?php

namespace App\Filament\Operator\Resources;

use App\Filament\Operator\Resources\JobdeskOperatorResource\Pages;
use App\Filament\Operator\Resources\JobdeskOperatorResource\RelationManagers;
use App\Models\JobdeskOperator;
use App\Models\Plan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;

class JobdeskOperatorResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Jobdesk';

    protected static ?string $slug = 'jobdesk';

    protected static ?string $breadcrumb = 'Jobdesk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('No.')->state(
                    static function (HasTable $livewire, stdClass $rowLoop): string {
                        return (string) ($rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * ($livewire->getTablePage() - 1
                            ))
                        );
                    }
                ),
                Tables\Columns\TextColumn::make('jobdesk')
                    ->formatStateUsing(fn(string $state): string => $state == 'service' ? 'Service & Maintenance Check' : str()->title($state))
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_job')
                    ->label('Tanggal Job')
                    ->date('d F Y')
                    ->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gensets')
                    ->label('Genset')
                    ->searchable(['brand_engine', 'kapasitas'])
                    ->html()
                    ->formatStateUsing(function ($record) {
                        $html = '<ul class="list-inside list-disc">';
                        foreach ($record->gensets as $genset) {
                            $html .= '<li>' . str()->upper($genset->brand_engine) . ' ' . $genset->kapasitas . ' KVA' . '</li>';
                        }
                        $html .= '</ul>';
                        return $html;
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('users.name')
                    ->label('Mekanik')
                    ->bulleted(fn(Plan $record) => $record->users->count() > 1)
                    ->searchable()
                    ->default('-')
                    // ->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('operator.name')
                    ->default('-')
                    ->label('Operator')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->label('Alamat')
                    ->limit(20)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }

                        // Only render the tooltip if the column content exceeds the length limit.
                        return $state;
                    }),
                Tables\Columns\TextColumn::make('transaction.customer')
                    ->label('Customer')
                    ->sortable()
                    ->wrap()
                    ->formatStateUsing(function (Plan $record) {
                        return $record->transaction->customer->perusahaan  ? $record->transaction->customer->perusahaan : $record->transaction->customer->name;
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'delivery' => 'Delivery',
                        'rent' => 'Rent',
                        'selesai' => 'Selesai',
                        'cancel' => 'Cancel',
                    })
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'delivery' => 'info',
                        'rent' => 'primary',
                        'selesai' => 'success',
                        'cancel' => 'danger',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'pending' => 'heroicon-o-information-circle',
                        'delivery' => 'heroicon-o-truck',
                        'rent' => 'heroicon-o-bolt',
                        'selesai' => 'heroicon-o-check-badge',
                        'cancel' => 'heroicon-o-x-mark',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->emptyStateHeading('Belum ada data! 🙁')
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageJobdeskOperators::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('users', function ($q) {
            $q->where('user_id', auth()->user()->id);
        })->orWhere('operator_id', auth()->user()->id);
    }
}
