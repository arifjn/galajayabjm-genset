<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServicePlanResource\Pages;
use App\Filament\Resources\ServicePlanResource\RelationManagers;
use App\Models\Plan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
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
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
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
            'index' => Pages\ListServicePlans::route('/'),
            'create' => Pages\CreateServicePlan::route('/create'),
            'edit' => Pages\EditServicePlan::route('/{record}/edit'),
        ];
    }
}
