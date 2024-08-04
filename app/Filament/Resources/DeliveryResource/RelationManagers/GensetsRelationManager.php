<?php

namespace App\Filament\Resources\DeliveryResource\RelationManagers;

use App\Models\Genset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;

class GensetsRelationManager extends RelationManager
{
    protected static string $relationship = 'gensets';

    protected static ?string $recordTitleAttribute = 'brand_engine';

    protected static ?string $title = 'Genset';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('brand_engine')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('brand_engine')
            ->columns([
                TextColumn::make('No.')->state(
                    static function (HasTable $livewire, stdClass $rowLoop): string {
                        return (string) ($rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * ($livewire->getTablePage() - 1
                            ))
                        );
                    }
                ),
                TextColumn::make('no_genset')
                    ->label('Nomor Genset')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tipe_engine')
                    ->label('Tipe Engine')
                    ->formatStateUsing(fn (string $state): string => str()->upper($state))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('brand_engine')
                    ->label('Genset')
                    ->formatStateUsing(fn ($record) => $record->brand_engine . ' ' . $record->kapasitas . ' KVA'),
                TextColumn::make('tipe_genset')
                    ->label('Tipe Genset')
                    ->formatStateUsing(fn (string $state): string => str()->title($state))
                    ->searchable()
                    ->sortable(),
            ])
            ->emptyStateHeading('Belum ada data! 🙁')
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()
                    ->label('Tambah')
                    ->modalHeading('Pilih Genset')
                    ->color(Color::Indigo)
                    ->preloadRecordSelect()
                    ->recordTitle(fn (Model $record) => "{$record->brand_engine} {$record->kapasitas} KVA")
                    ->successNotificationTitle('Berhasil Tambah Genset!'),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
                Tables\Actions\DetachAction::make()
                    ->label('Ganti')
                    ->before(function (Genset $genset) {
                        $genset->status_genset = 'ready';
                        $genset->save();
                    })
                    ->successNotificationTitle('Berhasil Batalkan Genset!'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
