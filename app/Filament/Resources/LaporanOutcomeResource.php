<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaporanOutcomeResource\Pages;
use App\Filament\Resources\LaporanOutcomeResource\RelationManagers;
use App\Models\Outcome;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Number;

class LaporanOutcomeResource extends Resource
{
    protected static ?string $model = Outcome::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-minus';

    protected static ?string $navigationLabel = 'Laporan Pengeluaran';

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?int $navigationSort = 8;

    protected static ?string $slug = 'laporan-pengeluaran';

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
                Tables\Columns\TextColumn::make('plan.tanggal_job')
                    ->label('Tanggal')
                    ->date('d F Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('plan.jobdesk')
                    ->sortable()
                    ->label('Pekerjaan')
                    ->formatStateUsing(fn(Model $record) => ucwords($record->plan->jobdesk)),
                Tables\Columns\TextColumn::make('plan.gensets')
                    ->label('Genset')
                    ->searchable(['brand_engine', 'kapasitas'])
                    ->html()
                    ->formatStateUsing(function ($record) {
                        $html = '<ul class="list-inside list-disc">';
                        foreach ($record->plan->gensets as $genset) {
                            $html .= '<li>' . str()->upper($genset->brand_engine) . ' ' . $genset->kapasitas . ' KVA' . '</li>';
                        }
                        $html .= '</ul>';
                        return $html;
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('plan.transaction')
                    ->label('Customer')
                    ->wrap()
                    ->sortable()
                    ->formatStateUsing(fn(Model $record) => $record->plan->transaction->customer->perusahaan ? $record->plan->transaction->customer->perusahaan : $record->plan->transaction->customer->name),
                Tables\Columns\TextColumn::make('upd')
                    ->label('UPD')
                    ->formatStateUsing(fn(Model $record) => Number::currency($record->upd, 'IDR', 'id'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('biaya_service')
                    ->label('Biaya Service')
                    ->formatStateUsing(fn(Model $record) => Number::currency($record->biaya_service, 'IDR', 'id'))
                    ->default(0)
                    ->sortable(),
                Tables\Columns\TextColumn::make('biaya_lainnya')
                    ->label('Biaya Lainnya')
                    ->formatStateUsing(fn(Model $record) => Number::currency($record->biaya_lainnya, 'IDR', 'id'))
                    ->default(0)
                    ->sortable(),
                Tables\Columns\TextColumn::make('lainnya')
                    ->label('Keterangan')
                    ->default('-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('outcome')
                    ->label('Total Pengeluaran')
                    ->formatStateUsing(fn(Model $record) => Number::currency($record->outcome, 'IDR', 'id'))
                    ->default(0)
                    ->sortable(),
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
                Tables\Actions\BulkAction::make('pdf-outcome')
                    ->label('Download PDF')
                    ->color(Color::Rose)
                    ->icon('heroicon-o-arrow-down-on-square')
                    ->action(function ($records) {
                        $pdf = Pdf::loadView('pdf.outcome', ['outcomes' => $records])->setPaper('a4', 'landscape');
                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'laporan-outcome.pdf');
                    })
                    ->deselectRecordsAfterCompletion(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageLaporanOutcomes::route('/'),
        ];
    }
}
