<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use stdClass;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?string $navigationLabel = 'Customer';

    protected static ?string $navigationGroup = 'Data Master';

    protected static ?string $slug = 'customer';

    protected static ?string $breadcrumb = 'Customer';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Account Information')
                    ->schema([
                        TextInput::make('email')
                            ->required()
                            ->validationMessages([
                                'required' => 'Email wajib diisi.',
                            ])
                            ->email()
                            ->columnSpanFull(),
                        TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->validationMessages([
                                'required' => 'Password wajib diisi.',
                                'confirmed' => 'Konfirmasi Password tidak cocok.'
                            ])
                            ->confirmed(),
                        TextInput::make('password_confirmation')
                            ->label('Password Confirmation')
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->validationMessages([
                                'required' => 'Konfirmasi Password wajib diisi.',
                            ])
                            ->password()
                            ->revealable(),
                    ])
                    ->columns(2)
                    ->collapsible(),
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
                            ->displayFormat('d/m/Y')
                            ->native(false)
                            ->required()
                            ->validationMessages([
                                'required' => 'Tanggal Lahir wajib diisi.',
                            ])
                            ->closeOnDateSelection(),
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
                            ->label('Foto')
                            ->directory('customer')
                            ->image()
                            ->imageEditor(),
                        Select::make('tipe_customer')
                            ->required()
                            ->validationMessages([
                                'required' => 'Tipe Customer wajib diisi.',
                            ])
                            ->native(false)
                            ->label('Tipe Customer')
                            ->options([
                                'perorangan' => 'Perorangan',
                                'perusahaan' => 'Perusahaan',
                            ])
                            ->live(),
                        TextInput::make('perusahaan')
                            ->requiredIf('tipe_customer', 'perusahaan')
                            ->validationMessages([
                                'required_if' => 'Perusahaan wajib diisi.',
                            ])
                            ->hidden(fn (Get $get) => $get('tipe_customer') !== 'perusahaan'),
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
                    ->label('Foto')
                    ->defaultImageUrl(asset('assets/images/no-image.jpg'))
                    ->circular()
                    ->toggleable(),
                TextColumn::make('name')
                    ->label('Nama Lengkap')
                    ->formatStateUsing(fn (string $state): string => str()->title($state))
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
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tipe_customer')
                    ->label('Tipe')
                    ->formatStateUsing(fn (string $state): string => str()->title($state))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('perusahaan')
                    ->default('-')
                    ->searchable()
                    ->sortable(),
            ])
            ->emptyStateHeading('Belum ada data! 🙁')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->modalHeading('Lihat Customer')
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
                ComponentsSection::make('Informasi Customer')->schema([
                    TextEntry::make('name')
                        ->label('Nama Lengkap')
                        ->formatStateUsing(fn (string $state): string => str()->title($state)),
                    TextEntry::make('email'),
                    TextEntry::make('no_telp')
                        ->label('No. HP'),
                    TextEntry::make('tipe_customer')
                        ->formatStateUsing(fn (string $state): string => str()->title($state))
                        ->label('Tipe'),
                    TextEntry::make('perusahaan')
                        ->default('-'),
                    TextEntry::make('alamat'),
                ])->columns(3),
                ImageEntry::make('profile_img')
                    ->label('Foto')
                    ->hidden(fn (Customer $record): bool => $record->profile_img == null)
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
