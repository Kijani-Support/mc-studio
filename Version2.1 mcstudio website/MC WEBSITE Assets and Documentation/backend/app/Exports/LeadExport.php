<?php

namespace App\Exports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LeadExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Lead::all();
    }

    public function map($lead): array
    {
        return [
            $lead->first_name,
            $lead->last_name,
            $lead->email,
            $lead->phone,
            $lead->education,
            $lead->experience,
            $lead->ai_experience,
            $lead->specialization,
            $lead->created_at,
        ];
    }

    public function headings(): array
    {
        return [
            'First Name',
            'Last Name',
            'Email',
            'Phone',
            'Education',
            'Experience',
            'AI Experience',
            'Specialization',
            'Created At',
        ];
    }
}
