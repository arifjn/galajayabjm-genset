<?php

namespace App\Filament\Resources\PlanResource\RelationManagers;

use App\Models\Plan;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Mekanik';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
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
                    ->formatStateUsing(fn(string $state): string => str()->title($state))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('no_telp')
                    ->label('No HP')
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
                    ->modalHeading('Pilih Mekanik (Delivery)')
                    ->color(Color::Indigo)
                    ->preloadRecordSelect()
                    ->recordSelectOptionsQuery(fn(Builder $query) => $query->where('role', '!=', 'admin')->where('status', 'tersedia'))
                    ->successNotificationTitle('Berhasil Tambah Mekanik!'),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
                Tables\Actions\DetachAction::make()
                    ->label('Ganti')
                    ->before(function (User $user) {
                        $user->status = 'tersedia';
                        $user->save();
                    })
                    ->successNotificationTitle('Berhasil Batalkan Mekanik!'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
