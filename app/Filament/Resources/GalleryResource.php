<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Filament\Resources\GalleryResource\RelationManagers;
use App\Models\Gallery;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Infolists\Components\Group as ComponentsGroup;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Galeri';

    protected static ?string $navigationGroup = 'Data Master';

    protected static ?string $slug = 'galeri';

    protected static ?string $breadcrumb = 'Galeri';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Section::make('Konten')
                        ->schema([
                            Group::make([
                                TextInput::make('title')
                                    ->label('Judul')
                                    ->required()
                                    ->validationMessages([
                                        'required' => 'Judul wajib diisi.',
                                    ])
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn(string $operation, $state, Set $set) => $operation !== 'create' ? null : $set('slug', str()->slug($state))),
                                TextInput::make('slug')
                                    ->required()
                                    ->validationMessages([
                                        'required' => 'Slug wajib diisi.',
                                    ])
                                    ->maxLength(255)
                                    ->disabled()
                                    ->dehydrated(),
                            ])
                                ->columns(2),
                            TextInput::make('location')
                                ->label('Lokasi')
                                ->validationMessages([
                                    'required' => 'Lokasi wajib diisi.',
                                ])
                                ->required(),
                            Textarea::make('description')
                                ->label('Deskripsi'),
                        ])
                        ->collapsible(),
                    Section::make('Foto Aktifitas')
                        ->schema([
                            FileUpload::make('images')
                                ->label('Foto')
                                ->multiple()
                                ->directory('gallery')
                                ->image()
                                ->panelLayout('grid')
                                ->validationMessages([
                                    'required' => 'Minimal upload 1 Foto.',
                                ])
                                ->required(),
                        ]),
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('images')
                    ->label('Foto Aktivitas')
                    ->circular()
                    ->stacked()
                    ->wrap()
                    ->simpleLightbox(),
                TextColumn::make('title')
                    ->formatStateUsing(fn(string $state): string => str()->title($state))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('location')
                    ->label('Lokasi')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(40)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }

                        // Only render the tooltip if the column content exceeds the length limit.
                        return $state;
                    }),
            ])
            ->emptyStateHeading('Belum ada data! 🙁')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->modalHeading('Lihat Galeri')
                        ->color(Color::Orange),
                    Tables\Actions\EditAction::make()
                        ->color(Color::Indigo),
                    Tables\Actions\DeleteAction::make()
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
                ComponentsSection::make('Galeri Aktifitas')->schema([
                    ComponentsGroup::make([
                        TextEntry::make('title'),
                        TextEntry::make('location')
                            ->icon('heroicon-o-map-pin')
                            ->label('Lokasi'),
                    ])->columns(2),
                    TextEntry::make('description')
                        ->label('Deskripsi'),
                ]),
                ImageEntry::make('images')
                    ->columnSpanFull()
                    ->label('Foto')
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
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}
