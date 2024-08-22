<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OutcomeResource\Pages;
use App\Filament\Resources\OutcomeResource\RelationManagers;
use App\Models\Outcome;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Number;

class OutcomeResource extends Resource
{
    protected static ?string $model = Outcome::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-left-circle';

    protected static ?string $navigationLabel = 'Pengeluaran';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Manajemen Keuangan';

    protected static ?string $slug = 'pengeluaran';

    protected static ?string $breadcrumb = 'Pengeluaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Outcome  Information')
                    ->schema([
                        Forms\Components\Select::make('plan_id')
                            ->label('Pekerjaan')
                            ->placeholder('Pilih Pekerjaan')
                            ->native(false)
                            ->searchable(['order_id'])
                            ->preload()
                            ->live()
                            ->relationship(
                                name: 'plan',
                                modifyQueryUsing: function (Builder $query) {
                                    $query->where('status', 'selesai');
                                },
                            )
                            ->columnSpanFull()
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => ucwords($record->jobdesk) . ' Genset - ' . ($record->transaction->customer->perusahaan ? $record->transaction->customer->perusahaan : $record->transaction->customer->name) . ' (' . $record->order_id . ')'),
                        Forms\Components\TextInput::make('upd')
                            ->label('Uang Perjalanan Dinas (UPD)')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->dehydrateStateUsing(fn($state) => floatval(str_replace(',', '', $state)))
                            ->numeric()
                            ->reactive()
                            ->live(onBlur: true)
                            ->default(0)
                            ->dehydrated()
                            ->prefix('Rp'),
                        Forms\Components\TextInput::make('biaya_service')
                            ->label('Biaya Service')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->dehydrateStateUsing(fn($state) => floatval(str_replace(',', '', $state)))
                            ->numeric()
                            ->reactive()
                            ->live(onBlur: true)
                            ->default(0)
                            ->dehydrated()
                            ->prefix('Rp'),
                        Forms\Components\TextInput::make('lainnya')
                            ->live()
                            ->label('Pengeluaran Lainnya'),
                        Forms\Components\TextInput::make('biaya_lainnya')
                            ->label('Biaya Lainnya')
                            ->visible(fn(Get $get) => $get('lainnya'))
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->dehydrateStateUsing(fn($state) => floatval(str_replace(',', '', $state)))
                            ->numeric()
                            ->reactive()
                            ->live(onBlur: true)
                            ->default(0)
                            ->dehydrated()
                            ->prefix('Rp'),
                        Forms\Components\Placeholder::make('outcome_placheholder')
                            ->label('Total Pengeluaran')
                            ->content(function (Get $get, Set $set) {
                                $total = 0;

                                if ($get('upd') == null) {
                                    $set('upd', 0);
                                } elseif ($get('biaya_service') == null) {
                                    $set('biaya_service', 0);
                                } elseif ($get('biaya_lainnya') == null) {
                                    $set('biaya_lainnya', 0);
                                }

                                if (floatval(str_replace(',', '', $get('upd'))) > 0) {
                                    $total = floatval(str_replace(',', '', $get('upd'))) + floatval(str_replace(',', '', $get('biaya_service'))) + floatval(str_replace(',', '', $get('biaya_lainnya')));
                                }

                                $set('outcome', $total);
                                return Number::currency($total, 'IDR', 'ID');
                            }),

                        Forms\Components\Hidden::make('outcome')
                            ->dehydrated()
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('plan.jobdesk')
                    ->label('Pekerjaan')
                    ->sortable()
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
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->color(Color::Indigo),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOutcomes::route('/'),
            'create' => Pages\CreateOutcome::route('/create'),
            'edit' => Pages\EditOutcome::route('/{record}/edit'),
        ];
    }
}
