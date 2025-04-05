<?php

namespace App\Exports;

use App\Models\Registration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RegistrationsExport implements FromCollection, WithHeadings
{
    /**
     * Fetch the data to be exported.
     */
    public function collection()
    {
        // Fetch registrations in the latest order
        return Registration::orderBy('created_at', 'desc')->get([
            'id',
            'salutation',
            'first_name',
            'last_name',
            'mobile',
            'age',
            'native_place',
            'source',
            'created_at',
        ])->map(function ($registration) {
            $registration->created_at = \Carbon\Carbon::parse($registration->created_at)->format('d-m-Y H:i:s');
            return $registration;
        });
    }

    /**
     * Define the headings for the Excel file.
     */
    public function headings(): array
    {
        return [
            'ID',
            'Salutation',
            'First Name',
            'Last Name',
            'Mobile',
            'Age',
            'Native Place',
            'Source',
            'Created At',
        ];
    }
}