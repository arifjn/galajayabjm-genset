<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\PlansRelationManager;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use stdClass;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Operator';

    protected static ?string $navigationGroup = 'Data Master';

    protected static ?string $slug = 'operator';

    protected static ?string $breadcrumb = 'Operator';

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
                            ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                            ->dehydrated(fn(?string $state): bool => filled($state))
                            ->validationMessages([
                                'required' => 'Password wajib diisi.',
                                'confirmed' => 'Konfirmasi Password tidak cocok.'
                            ])
                            ->required(fn(string $operation): bool => $operation === 'create')
                            ->confirmed(),
                        TextInput::make('password_confirmation')
                            ->label('Password Confirmation')
                            ->required(fn(string $operation): bool => $operation === 'create')
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
                            ->displayFormat('d F Y')
                            ->native(false)
                            ->validationMessages([
                                'required' => 'Tanggal Lahir wajib diisi.',
                            ])
                            ->required()
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
                            ->label('Foto Profil')
                            ->directory('foto_profil')
                            ->image()
                            ->imageEditor(),
                        Radio::make('status')
                            ->validationMessages([
                                'required' => 'Status wajib diisi.',
                            ])
                            ->required()
                            ->label('Status')
                            ->inline()
                            ->default('tersedia')
                            ->options([
                                'tersedia' => 'Tersedia',
                                'bertugas' => 'Bertugas',
                            ]),
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
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->modalHeading('Lihat Operator')
                        ->color(Color::Orange),
                    Tables\Actions\EditAction::make()
                        ->color(Color::Indigo),
                    Tables\Actions\DeleteAction::make()
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('pdf-operator')
                    ->label('Download PDF')
                    ->color(Color::Rose)
                    ->icon('heroicon-o-arrow-down-on-square')
                    ->action(function ($records) {
                        $pdf = Pdf::loadView('pdf.operator', ['operators' => $records])->setPaper('a4', 'portrait');
                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'laporan-operator.pdf');
                    })
                    ->deselectRecordsAfterCompletion(),
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ComponentsSection::make('Informasi Operator')->schema([
                    TextEntry::make('name')
                        ->label('Nama Lengkap')
                        ->formatStateUsing(fn(string $state): string => str()->title($state)),
                    TextEntry::make('email'),
                    TextEntry::make('no_telp')
                        ->label('No. HP'),
                    TextEntry::make('status')
                        ->formatStateUsing(fn(string $state): string => str()->title($state))
                        ->badge()
                        ->color(fn(string $state): string => match ($state) {
                            'tersedia' => 'success',
                            'bertugas' => 'danger',
                        }),
                    TextEntry::make('tempat_lahir')
                        ->label('Tempat Lahir'),
                    TextEntry::make('tgl_lahir')
                        ->date()
                        ->label('Tanggal Lahir'),
                    TextEntry::make('alamat')
                        ->columnSpan(2),
                ])->columns(3),
                ImageEntry::make('profile_img')
                    ->label('Foto Profil')
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', '!=', 'admin')->where('role', '!=', 'sales');
    }
}
