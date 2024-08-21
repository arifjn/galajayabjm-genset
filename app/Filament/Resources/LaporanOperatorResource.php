<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaporanOperatorResource\Pages;
use App\Filament\Resources\LaporanOperatorResource\RelationManagers;
use App\Models\LaporanOperator;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;

class LaporanOperatorResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Laporan Operator';

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?int $navigationSort = 2;

    protected static ?string $slug = 'laporan-operator';

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
                TextColumn::make('No.')->state(
                    static function (HasTable $livewire, stdClass $rowLoop): string {
                        return (string) ($rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * ($livewire->getTablePage() - 1
                            ))
                        );
                    }
                ),
                ImageColumn::make('profile_img')
                    ->label('Foto Profil')
                    ->defaultImageUrl(asset('assets/images/no-image.jpg'))
                    ->circular()
                    ->toggleable(),
                TextColumn::make('name')
                    ->label('Nama Lengkap')
                    ->formatStateUsing(fn(string $state): string => ucwords($state))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('no_telp')
                    ->label('No HP')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('alamat')
                    ->formatStateUsing(fn(string $state): string => ucwords($state))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable()
                    ->formatStateUsing(fn(string $state): string => str()->title($state))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'tersedia' => 'success',
                        'bertugas' => 'danger',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'tersedia' => 'heroicon-o-check-circle',
                        'bertugas' => 'heroicon-o-bolt',
                    })
                    ->sortable(),
            ])
            ->defaultSort('status', 'DESC')
            ->emptyStateHeading('Belum ada data! 🙁')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'tersedia' => 'Tersedia',
                        'bertugas' => 'Bertugas',
                    ]),
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('pdf-operator')
                    ->label('Download PDF')
                    ->color(Color::Rose)
                    ->icon('heroicon-o-arrow-down-on-square')
                    ->action(function ($records) {
                        $pdf = Pdf::loadView('pdf.operator', ['operators' => $records])->setPaper('a4', 'landscape');
                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'laporan-operator.pdf');
                    })
                    ->deselectRecordsAfterCompletion(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageLaporanOperators::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', '!=', 'admin')->where('role', '!=', 'sales');
    }
}
