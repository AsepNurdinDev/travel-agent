<?php

namespace App\Services\Customer;

use App\Models\Customer;

class CustomerService
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function findOrCreateByEmail(array $data): Customer
    {
        // 1. Cari customer termasuk yang terhapus (Soft Deleted)
        $customer = Customer::withTrashed()
            ->where('email', $data['email'])
            ->first();

        if ($customer) {
            // Jika statusnya soft deleted, pulihkan kembali
            if ($customer->trashed()) {
                $customer->restore();
            }

            // Update user_id atau data pendukung lainnya jika ada
            $customer->update(array_filter([
                'user_id'         => $data['user_id'] ?? $customer->user_id,
                'name'            => $data['name'] ?? $customer->name,
                'phone'           => $data['phone'] ?? $customer->phone,
                'address'         => $data['address'] ?? $customer->address,
                'identity_number' => $data['identity_number'] ?? $customer->identity_number,
                'date_of_birth'   => $data['date_of_birth'] ?? $customer->date_of_birth,
            ]));

            return $customer->fresh();
        }

        // 2. Jika belum ada sama sekali, baru buat data baru
        return Customer::create([
            'email'           => $data['email'],
            'name'            => $data['name'],
            'phone'           => $data['phone'] ?? null,
            'address'         => $data['address'] ?? null,
            'identity_number' => $data['identity_number'] ?? null,
            'date_of_birth'   => $data['date_of_birth'] ?? null,
            'user_id'         => $data['user_id'] ?? null,
        ]);
    }
}