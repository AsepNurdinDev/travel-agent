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
        $customer = Customer::query()->firstOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'],
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
                'identity_number' => $data['identity_number'] ?? null,
                'date_of_birth' => $data['date_of_birth'] ?? null,
                'user_id' => $data['user_id'] ?? null,
            ]
        );

        if (
            ! $customer->user_id &&
            ! empty($data['user_id'])
        ) {
            $customer->update([
                'user_id' => $data['user_id'],
            ]);
        }

        return $customer->fresh();
    }
}
