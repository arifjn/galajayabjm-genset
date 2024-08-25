<?php

namespace App\Filament\Resources;

use App\Enums\BrandEngine;
use App\Filament\Resources\GensetResource\Pages;
use App\Filament\Resources\GensetResource\RelationManagers;
use App\Models\Genset;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Blade;
use stdClass;

class GensetResource extends Resource
{
    protected static ?string $model = Genset::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    protected static ?string $navigationLabel = 'Genset';

    protected static ?string $navigationGroup = 'Data Master';

    protected static ?string $slug = 'genset';

    protected static ?string $breadcrumb = 'Genset';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Section::make('Engine Information')
                        ->schema([
                            Select::make('brand_engine')
                                ->autofocus()
                                ->label('Brand Engine')
                                ->native(false)
                                ->searchable()
                                ->preload()
                                ->options(BrandEngine::class)
                                ->validationMessages([
                                    'required' => 'Brand Engine wajib diisi.',
                                ])
                                ->required(),
                            Group::make([
                                TextInput::make('tipe_engine')
                                    ->label('Tipe Engine')
                                    ->dehydrateStateUsing(fn(string $state): string => str()->upper($state))
                                    ->placeholder('6CTAA83-G2')
                                    ->validationMessages([
                                        'required' => 'Tipe Engine wajib diisi.',
                                    ])
                                    ->required(),
                                TextInput::make('sn_engine')
                                    ->label('Serial Number')
                                    ->dehydrateStateUsing(fn(?string $state): string => str()->upper($state))
                                    ->placeholder('93045715')
                                    ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                            ])->columns(2),
                            Group::make([
                                TextInput::make('no_silinder')
                                    ->label('Nomor Silinder')
                                    ->numeric()
                                    ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                    ->placeholder('4 Cylinder'),
                                TextInput::make('kecepatan')
                                    ->label('Kecepatan')
                                    ->numeric()
                                    ->suffix('RPM')
                                    ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                    ->placeholder('1.500')
                            ])->columns(2),
                            Group::make([
                                TextInput::make('piston')
                                    ->label('Piston Displ.')
                                    ->numeric()
                                    ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                    ->suffix('Ltr')
                                    ->placeholder('25.200'),
                                TextInput::make('bore_stroke')
                                    ->label('Bore x Stroke')
                                    ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                    ->suffix('mm')
                                    ->placeholder('170 x 185')
                            ])->columns(2),
                            Group::make([
                                TextInput::make('pendingin')
                                    ->label('Sistem Pendingin')
                                    ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                    ->placeholder('Radiator Cooling'),
                                TextInput::make('kaps_oli')
                                    ->label('Kapasitas Oli')
                                    ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                    ->suffix('Ltr')
                                    ->placeholder('11')
                            ])->columns(2),
                            TextInput::make('bahan_bakar')
                                ->label('Konsumsi Bahan Bakar')
                                ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                ->suffix('Ltr')
                                ->placeholder('7.9 (75% Load) / 10 (100% Load)'),
                        ])
                        ->collapsible(),
                    Section::make('Generator Information')
                        ->schema([
                            TextInput::make('brand_generator')
                                ->label('Brand Generator')
                                ->dehydrateStateUsing(fn(string $state): string => str()->upper($state))
                                ->placeholder('STAMFORD')
                                ->validationMessages([
                                    'required' => 'Brand Generator wajib diisi.',
                                ])
                                ->required(),
                            Group::make([
                                TextInput::make('tipe_generator')
                                    ->label('Tipe Generator')
                                    ->dehydrateStateUsing(fn(string $state): string => str()->upper($state))
                                    ->placeholder('UC.1274H14')
                                    ->validationMessages([
                                        'required' => 'Tipe Generator wajib diisi.',
                                    ])
                                    ->required(),
                                TextInput::make('sn_generator')
                                    ->label('Serial Number')
                                    ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                    ->dehydrateStateUsing(fn(?string $state): string => str()->upper($state))
                                    ->placeholder('X22H342459')
                            ])
                                ->columns(2),
                            Group::make([
                                TextInput::make('kapasitas')
                                    ->placeholder('200')
                                    ->numeric()
                                    ->minValue(10)
                                    ->suffix('kVA')
                                    ->validationMessages([
                                        'required' => 'Kapasitas wajib diisi.',
                                    ])
                                    ->required(),
                                TextInput::make('frekuensi')
                                    ->placeholder('50')
                                    ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                    ->numeric()
                                    ->suffix('Hz'),
                            ])->columns(2),
                            Group::make([
                                TextInput::make('insul_class')
                                    ->label('Insulation Class')
                                    ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                    ->placeholder('Class H'),
                                TextInput::make('sist_eksitasi')
                                    ->label('Sistem Eksitasi')
                                    ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                    ->placeholder('Brush-less'),
                            ])->columns(2),
                            Group::make([
                                TextInput::make('regulator_tegangan')
                                    ->label('Regulator Tegangan')
                                    ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                    ->placeholder('AVR'),
                                TextInput::make('phase')
                                    ->label('Phase')
                                    ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                    ->numeric()
                                    ->suffix('Phase')
                                    ->placeholder('3'),
                            ])->columns(2),
                            TextInput::make('voltase')
                                ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                ->suffix('V')
                                ->placeholder('220 / 380'),
                        ])
                        ->collapsible(),
                ])->columnSpanFull(),

                Split::make([
                    Section::make('Genset Information')
                        ->schema([
                            TextInput::make('no_genset')
                                ->visible(fn(string $operation) => $operation == 'edit')
                                ->label('Nomor Genset')
                                ->dehydrateStateUsing(fn(string $state): string => str()->upper($state))
                                ->unique(table: 'gensets', column: 'no_genset', ignorable: fn($record) => $record)
                                ->validationMessages([
                                    'required' => 'Nomor Genset wajib diisi.',
                                    'unique' => 'Nomor Genset sudah dipakai.',
                                ])
                                ->required(),
                            Select::make('tipe_genset')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Tipe Genset wajib diisi.',
                                ])
                                ->native(false)
                                ->label('Tipe Genset')
                                ->options([
                                    'silent' => 'Silent',
                                    'open' => 'Open',
                                ]),
                            ToggleButtons::make('status_genset')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Status wajib diisi.',
                                ])
                                ->label('Status')
                                ->inline()
                                ->default('ready')
                                ->options([
                                    'ready' => 'Ready',
                                    'rent' => 'Rent',
                                    'maintenance' => 'Maintenance'
                                ])
                                ->colors([
                                    'ready' => 'success',
                                    'rent' => 'primary',
                                    'maintenance' => 'danger',
                                ])
                                ->icons([
                                    'ready' => 'heroicon-m-check-badge',
                                    'rent' => 'heroicon-m-bolt',
                                    'maintenance' => 'heroicon-m-wrench-screwdriver',
                                ]),
                            FileUpload::make('spek_genset')
                                ->label('Spesifikasi (PDF)')
                                ->directory('pdf-genset')
                                ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                ->openable()
                                ->maxSize(2048)
                                ->acceptedFileTypes(['application/pdf']),
                        ])->collapsible(),
                    Section::make('Photo Genset')
                        ->schema([
                            FileUpload::make('images_genset')
                                ->label('Foto')
                                ->directory('genset')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Upload minimal 1 foto.',
                                ])
                                ->multiple()
                                ->image()
                                ->panelLayout('grid')
                                ->openable(),
                        ])->collapsible()
                ])->columnSpanFull(),
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
                TextColumn::make('no_genset')
                    ->label('Nomor Genset')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tipe_engine')
                    ->label('Tipe Engine')
                    ->formatStateUsing(fn(string $state): string => str()->upper($state))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('brand_engine')
                    ->label('Brand Engine')
                    ->formatStateUsing(fn(string $state): string => str()->upper($state))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('kapasitas')
                    ->suffix(' kVA')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tipe_genset')
                    ->label('Tipe Genset')
                    ->formatStateUsing(fn(string $state): string => str()->title($state))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status_genset')
                    ->label('Status')
                    ->searchable()
                    ->formatStateUsing(fn(string $state): string => str()->title($state))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'ready' => 'success',
                        'rent' => 'warning',
                        'maintenance' => 'danger',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'ready' => 'heroicon-o-check-circle',
                        'rent' => 'heroicon-o-bolt',
                        'maintenance' => 'heroicon-o-wrench-screwdriver',
                    })
                    ->sortable(),
            ])
            ->defaultSort('status_genset', 'ASC')
            ->emptyStateHeading('Belum ada data! 🙁')
            ->filters([
                SelectFilter::make('status_genset')
                    ->label('Status Genset')
                    ->options([
                        'ready' => 'Ready',
                        'rent' => 'Rent',
                        'maintenance' => 'Maintenance',
                    ]),
                SelectFilter::make('brand_engine')
                    ->label('Brand Engine')
                    ->options(BrandEngine::class)
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('pdf')
                        ->label('PDF')
                        ->icon('heroicon-o-document-text')
                        ->url(fn(Genset $record): string => url('storage', $record->spek_genset))
                        ->hidden(fn(Genset $record): bool => $record->spek_genset == null)
                        ->openUrlInNewTab()
                        ->color(Color::Rose),
                    Tables\Actions\ViewAction::make()
                        ->modalHeading('Lihat Genset')
                        ->color(Color::Orange),
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ComponentsSection::make('Informasi Spesifikasi Genset')->schema([
                    TextEntry::make('no_genset')
                        ->label('Nomor Genset'),
                    TextEntry::make('tipe_genset')
                        ->label('Tipe Genset')
                        ->formatStateUsing(fn(string $state): string => str()->title($state)),
                    TextEntry::make('kapasitas')
                        ->suffix(' kVA'),
                    TextEntry::make('brand_engine')
                        ->label('Brand Engine')
                        ->formatStateUsing(fn(string $state): string => str()->title($state)),
                    TextEntry::make('tipe_engine')
                        ->label('Tipe Engine'),
                    TextEntry::make('sn_engine')
                        ->label('Serial Number (Engine)')
                        ->default('-')
                        ->formatStateUsing(fn(string $state): string => str()->upper($state)),
                    TextEntry::make('brand_generator')
                        ->label('Brand Generator'),
                    TextEntry::make('tipe_generator')
                        ->label('Tipe Generator'),
                    TextEntry::make('sn_generator')
                        ->label('Serial Number (Generator)')
                        ->default('-')
                        ->formatStateUsing(fn(string $state): string => str()->upper($state)),
                    TextEntry::make('status_genset')
                        ->formatStateUsing(fn(string $state): string => str()->title($state))
                        ->badge()
                        ->color(fn(string $state): string => match ($state) {
                            'ready' => 'success',
                            'rent' => 'warning',
                            'maintenance' => 'danger',
                        })
                        ->icon(fn(string $state): string => match ($state) {
                            'ready' => 'heroicon-o-check-circle',
                            'rent' => 'heroicon-o-bolt',
                            'maintenance' => 'heroicon-o-wrench-screwdriver',
                        })
                        ->label('Status'),
                    Actions::make([
                        Action::make('spek_genset')
                            ->visible(fn(Genset $record) => $record->spek_genset !== null)
                            ->label('Spesifikasi')
                            ->icon('heroicon-o-document-text')
                            ->url(fn(Genset $record): string => url('storage', $record->spek_genset))
                            ->openUrlInNewTab()
                            ->color(Color::Rose),
                    ])
                ])->columns(3),
                ImageEntry::make('images_genset')
                    ->columnSpanFull()
                    ->label('Foto')
                    ->hidden(fn(Genset $record): bool => $record->images_genset == null)
                    ->simpleLightbox(),
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
            'index' => Pages\ListGensets::route('/'),
            'create' => Pages\CreateGenset::route('/create'),
            'edit' => Pages\EditGenset::route('/{record}/edit'),
        ];
    }
}
