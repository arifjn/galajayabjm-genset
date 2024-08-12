<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliveryResource\RelationManagers\GensetsRelationManager;
use App\Filament\Resources\DeliveryResource\RelationManagers\UsersRelationManager;
use App\Filament\Resources\ServicePlanResource\Pages;
use App\Filament\Resources\ServicePlanResource\RelationManagers;
use App\Models\Plan;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServicePlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationLabel = 'Service';

    protected static ?string $navigationGroup = 'Manajemen Jadwal';

    protected static ?string $slug = 'service';

    protected static ?string $breadcrumb = 'Service';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Delivery Job Information')
                    ->schema([
                        Forms\Components\Select::make('gensets')
                            ->label('Genset')
                            ->placeholder('Pilih Genset')
                            ->hidden(fn(string $operation): bool => $operation == 'edit')
                            ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                            ->native(false)
                            ->multiple()
                            ->searchable(['brand_engine', 'kapasitas'])
                            ->preload()
                            ->relationship(
                                name: 'gensets',
                                modifyQueryUsing: function (Builder $query) {
                                    $query->orderBy('status_genset', 'DESC');
                                },
                            )
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => str()->upper($record->brand_engine) . ' ' . $record->kapasitas . " KVA"),
                        Forms\Components\Select::make('users')
                            ->label('Mekanik')
                            ->placeholder('Pilih Mekanik')
                            ->hidden(fn(string $operation): bool => $operation == 'edit')
                            ->native(false)
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->relationship(
                                name: 'users',
                                titleAttribute: 'name',
                                modifyQueryUsing: function (Builder $query) {
                                    $query->where('status', 'tersedia');
                                },
                            ),
                        Forms\Components\DatePicker::make('tanggal_job')
                            ->label('Tanggal Job')
                            ->required()
                            ->native(false)
                            ->closeOnDateSelection()
                            ->displayFormat('d F Y')
                            ->default(now()),
                        Forms\Components\DatePicker::make('tanggal_job_selesai')
                            ->label('Tanggal Job Selesai')
                            ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                            ->native(false)
                            ->closeOnDateSelection()
                            ->displayFormat('d F Y')
                            ->default(now()),
                        Forms\Components\Textarea::make('keterangan')
                            ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                            ->maxLength(65535),
                        Forms\Components\Radio::make('status')
                            ->required()
                            ->inline()
                            ->inlineLabel(false)
                            ->default('pending')
                            ->options([
                                'pending' => 'Pending',
                                'selesai' => 'Selesai',
                                'cancel' => 'Cancel',
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
                Tables\Columns\TextColumn::make('jobdesk')
                    ->formatStateUsing(fn(string $state): string => $state == 'service' ? 'Service & Maintenance Check' : '')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_job')
                    ->label('Tanggal Job')
                    ->date('d F Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('gensets')
                    ->label('Genset')
                    ->searchable(['brand_engine', 'kapasitas'])
                    ->html()
                    ->formatStateUsing(function ($record) {
                        $html = '<ul class="list-inside list-disc">';
                        foreach ($record->gensets as $genset) {
                            $html .= '<li>' . str()->upper($genset->brand_engine) . ' ' . $genset->kapasitas . ' KVA' . '</li>';
                        }
                        $html .= '</ul>';
                        return $html;
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('users.name')
                    ->label('Mekanik')
                    ->searchable()
                    ->bulleted()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gensets.plans.transaction.site')
                    ->label('Alamat')
                    ->default('PT. Gala Jaya Banjarmasin')
                    ->wrap()
                    ->sortable(),
                Tables\Columns\SelectColumn::make('status')
                    ->searchable()
                    ->options([
                        'pending' => 'Pending',
                        'selesai' => 'Selesai',
                    ])
                    ->selectablePlaceholder(false),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $query->where('jobdesk', 'service');
            })
            ->emptyStateHeading('Belum ada data! 🙁')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->color(Color::Indigo),
                    Tables\Actions\DeleteAction::make()
                        ->before(function (Plan $record) {
                            if ($record->users) {
                                foreach ($record->users as $user) {
                                    $u = User::find($user->id);
                                    $u->status = 'tersedia';
                                    $u->save();
                                }
                            }
                            $record->gensets()->detach();
                            $record->users()->detach();
                        }),
                ]),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            GensetsRelationManager::class,
            UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServicePlans::route('/'),
            'create' => Pages\CreateServicePlan::route('/create'),
            'edit' => Pages\EditServicePlan::route('/{record}/edit'),
        ];
    }
}
