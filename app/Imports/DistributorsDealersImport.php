<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\DistributorDealer;
use Illuminate\Support\Facades\Validator;

class DistributorsDealersImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        // Remove header row
        $rows = $collection->skip(1);

        foreach ($rows as $row) {

            // Map Excel columns (index-based)
            $data = [
                'name'          => $row[0] ?? null,
                'company_name'  => $row[1] ?? null,
                'email'         => $row[2] ?? null,
                'mobile'        => $row[3] ?? null,
                'gst_number'    => $row[4] ?? null,
                'address'       => $row[5] ?? null,
                'city'          => $row[6] ?? null,
                'state'         => $row[7] ?? null,
                'pincode'       => $row[8] ?? null,
                'status'        => $row[9] ?? 1,
            ];

            // Row validation
            $validator = Validator::make($data, [
                'name'         => 'required|string|max:255',
                'company_name' => 'required|string|max:255',
                'email'        => 'required|email',
                'mobile'       => 'required|digits:10',
            ]);

            // Skip invalid rows
            if ($validator->fails()) {
                continue;
            }

            // Insert / Update distributor
            DistributorDealer::updateOrCreate(
                ['email' => $data['email']], // unique key
                $data
            );
        }
    }
}
