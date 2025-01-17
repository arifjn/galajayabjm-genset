<?php

namespace App\Filament\Resources\PlanResource\Pages;

use App\Filament\Resources\PlanResource;
use App\Models\Genset;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class CreatePlan extends CreateRecord
{
    protected static string $resource = PlanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getTitle(): string|Htmlable
    {
        return 'Tambah Jobdesk';
    }

    public function getBreadcrumb(): string
    {
        return 'Tambah Data';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if ($data['choose_jobdesk'] == 'delivery') {
            $data['jobdesk'] = 'delivery';
        } else if ($data['choose_jobdesk'] == 'service') {
            $data['jobdesk'] = 'service';
        } else if ($data['choose_jobdesk'] == 'penarikan') {
            $data['jobdesk'] = 'penarikan';
        } else {
            return $data;
        }

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        if ($data['order_id']) {
            $order = Transaction::where('order_id',  $data['order_id'])->first();
            $data['alamat'] = $order->site;
            // $plan['alamat'] = $plan->transaction->site;
            // $plan->save();
        }

        $record =  static::getModel()::create($data);

        if ($record->order_id && $record->subject == 'sewa') {
            $message = 'Halo Kak ' . $record->transaction->customer->name . ', Pengiriman Genset sudah dijadwalkan! 😁. Silakan Cek Jadwal Pengiriman dengan Order ID #' . $record->order_id;
            $no_telp = $record->transaction->customer->no_telp;
            $token = 'jVT18@D7koZiQkm3wE4z';

            $curl = curl_init();

            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => 'https://api.fonnte.com/send',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array('target' => $no_telp, 'message' => $message),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: ' . $token
                    ),
                )
            );

            $response = curl_exec($curl);

            curl_close($curl);
        }

        if ($record->operator_id) {
            $user = User::find($record->operator_id);
            $user->status = 'bertugas';
            $user->save();
        }

        return $record;
    }
}
