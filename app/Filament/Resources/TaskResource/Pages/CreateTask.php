<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use App\Models\Briefing;
use App\Models\Task;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTask extends CreateRecord
{
    protected static string $resource = TaskResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {

        $task = Task::create($data);
        foreach ($data['serviceFields'] as $fieldId => $value) {
            Briefing::create([
                'task_id' => $task->id,
                'service_id' => $data['service_id'],
                'service_field_id' => $fieldId,
                'value' => $value,
            ]);
        }
        return $data;
    }

}
