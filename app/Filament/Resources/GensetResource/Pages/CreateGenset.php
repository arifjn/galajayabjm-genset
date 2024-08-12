<?php

namespace App\Filament\Resources\GensetResource\Pages;

use App\Filament\Resources\GensetResource;
use App\Models\Genset;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateGenset extends CreateRecord
{
    protected static string $resource = GensetResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getTitle(): string|Htmlable
    {
        return 'Tambah Data Genset';
    }

    public function getBreadcrumb(): string
    {
        return 'Tambah Data';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $increment = Genset::orderBy('created_at', 'DESC')->count();
        $increment++;

        $brand = '';
        if ($data['brand_engine'] === 'cummins') {
            $brand = 'CU';
        } elseif ($data['brand_engine'] === 'deutz') {
            $brand = 'DZ';
        } elseif ($data['brand_engine'] === 'fawde') {
            $brand = 'FW';
        } elseif ($data['brand_engine'] === 'mwm') {
            $brand = 'MW';
        } elseif ($data['brand_engine'] === 'man') {
            $brand = 'MA';
        } elseif ($data['brand_engine'] === 'isuzu') {
            $brand = 'IZ';
        } elseif ($data['brand_engine'] === 'perkins') {
            $brand = 'PK';
        } elseif ($data['brand_engine'] === 'primero') {
            $brand = 'PR';
        } elseif ($data['brand_engine'] === 'powerol') {
            $brand = 'PM';
        } elseif ($data['brand_engine'] === 'yanmar') {
            $brand = 'YM';
        } else {
            $brand = '';
        }

        $no_genset = 'GJB-' . str_pad($increment, 2, '0', STR_PAD_LEFT)  . '-' . $data['kapasitas'] . '-' . $brand;

        $data['no_genset'] = $no_genset;

        return $data;
    }
}
