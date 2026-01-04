<?php

namespace App\Exports;

use App\Models\FormSubmission;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FormSubmissionsExport implements FromCollection, WithHeadings
{
    protected Collection $submissions;
    protected array $fieldKeys = [];

    public function __construct(Collection $submissions)
    {
        $this->submissions = $submissions;

        $this->fieldKeys = $submissions
            ->pluck('data')
            ->flatMap(fn ($data) => array_keys($data ?? []))
            ->unique()
            ->values()
            ->toArray();
    }

    public function headings(): array
    {
        return array_merge([
            'ID',
            'Submitted At',
            'Status',
            'Form',
            'Event',
        ], $this->fieldKeys);
    }

    public function collection()
    {
        return $this->submissions->map(function ($s) {
            $row = [
                $s->id,
                $s->created_at->format('Y-m-d H:i:s'),
                $s->status,
                $s->form->name ?? '',
                $s->event->title ?? '',
            ];

            foreach ($this->fieldKeys as $key) {
                $value = $s->data[$key] ?? '';
                $row[] = is_array($value) ? implode(', ', $value) : $value;
            }

            return collect($row);
        });
    }
}
