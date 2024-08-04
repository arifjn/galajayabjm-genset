<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Models\Genset;
use App\Models\Plan;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PlansRelationManager extends RelationManager
{
    protected static string $relationship = 'plans';

    protected static ?string $title = 'Jobdesk';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('order_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('order_id')
            ->columns([
                Tables\Columns\TextColumn::make('jobdesk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_job')
                    ->label('Tanggal Job')
                    ->date('d F Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_job_selesai')
                    ->label('Tanggal Selesai')
                    ->date('d F Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('transaction.customer.perusahaan')
                    ->label('Customer')
                    ->sortable()
                    ->formatStateUsing(function (Plan $record) {
                        return $record->transaction->customer->perusahaan  ? $record->transaction->customer->perusahaan : $record->transaction->customer->name;
                    }),
                Tables\Columns\TextColumn::make('gensets')
                    ->label('Genset')
                    ->searchable(['brand_engine', 'kapasitas'])
                    ->html()
                    ->formatStateUsing(function ($record) {
                        $html = '<ul class="list-inside list-disc">';
                        foreach ($record->gensets as $genset) {
                            $html .= '<li>' . $genset->brand_engine . ' ' . $genset->kapasitas . ' KVA' . '</li>';
                        }
                        $html .= '</ul>';
                        return $html;
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('users.name')
                    ->label('Operator')
                    ->searchable()
                    ->bulleted()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => str()->title($state))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'delivery' => 'info',
                        'selesai' => 'success',
                        'cancel' => 'danger',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'pending' => 'heroicon-o-exclamation-circle',
                        'delivery' => 'heroicon-o-truck',
                        'selesai' => 'heroicon-o-check-circle',
                        'cancel' => 'heroicon-o-x-circle',
                    })
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
            ->headerActions([
                // Tables\Actions\CreateAction::make()
                //     ->label('Tambah'),
            ])
            ->actions([
                // Tables\Actions\ActionGroup::make([
                //     Tables\Actions\EditAction::make()
                //         ->color(Color::Indigo),
                //     Tables\Actions\DeleteAction::make()
                //         ->before(function (Plan $record) {
                //             if ($record->gensets) {
                //                 foreach ($record->gensets as $genset) {
                //                     $gs = Genset::find($genset->id);
                //                     $gs->status_genset = 'ready';
                //                     $gs->save();
                //                 }
                //             }
                //             if ($record->users) {
                //                 foreach ($record->users as $user) {
                //                     $u = User::find($user->id);
                //                     $u->status = 'tersedia';
                //                     $u->save();
                //                 }
                //             }
                //             $record->gensets()->detach();
                //             $record->users()->detach();
                //         }),
                // ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
