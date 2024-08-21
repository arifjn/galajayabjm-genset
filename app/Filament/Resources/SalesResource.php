<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalesResource\Pages;
use App\Filament\Resources\SalesResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;

class SalesResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationLabel = 'Sales';

    protected static ?string $navigationGroup = 'Data Master';

    protected static ?string $slug = 'sales';

    protected static ?string $breadcrumb = 'Sales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Personal Information')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->validationMessages([
                                'required' => 'Nama Lengkap wajib diisi.',
                            ])
                            ->required(),
                        TextInput::make('tempat_lahir')
                            ->label('Tempat Lahir')
                            ->validationMessages([
                                'required' => 'Tempat Lahir wajib diisi.',
                            ])
                            ->required(),
                        DatePicker::make('tgl_lahir')
                            ->label('Tanggal Lahir')
                            ->displayFormat('d F Y')
                            ->native(false)
                            ->validationMessages([
                                'required' => 'Tanggal Lahir wajib diisi.',
                            ])
                            ->required()
                            ->closeOnDateSelection(),
                        TextInput::make('email')
                            ->required()
                            ->validationMessages([
                                'required' => 'Email wajib diisi.',
                            ])
                            ->email(),
                        TextInput::make('no_telp')
                            ->label('No. HP')
                            ->numeric()
                            ->tel()
                            ->validationMessages([
                                'required' => 'No. HP wajib diisi.',
                            ])
                            ->required(),
                        Textarea::make('alamat')
                            ->validationMessages([
                                'required' => 'Alamat wajib diisi.',
                            ])
                            ->required(),
                        FileUpload::make('profile_img')
                            ->label('Foto Profil')
                            ->directory('foto_profil')
                            ->image()
                            ->imageEditor()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible(),
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
            ])
            ->defaultSort('status', 'DESC')
            ->emptyStateHeading('Belum ada data! 🙁')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSales::route('/create'),
            'edit' => Pages\EditSales::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', '!=', 'admin')->where('role', '!=', 'operator');
    }
}
