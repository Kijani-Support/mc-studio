<?php

namespace App\Exports;

use App\Models\Application;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ApplicationExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @var array<int, string>
     */
    protected array $columns;

    public function __construct()
    {
        // Get all column names dynamically from the applications table
        $this->columns = Schema::getColumnListing((new Application())->getTable());
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection(): Collection
    {
        return Application::query()->get($this->columns);
    }

    /**
     * @param mixed $application
     * @return array<int, mixed>
     */
    public function map($application): array
    {
        $row = [];
        foreach ($this->columns as $column) {
            $value = $application->{$column};
            // Convert booleans to 1/0 for CSV friendliness
            if (is_bool($value)) {
                $value = $value ? 1 : 0;
            }
            $row[] = $value;
        }
        return $row;
    }

    /**
     * @return array<int, string>
     */
    public function headings(): array
    {
        return $this->columns;
    }
}


