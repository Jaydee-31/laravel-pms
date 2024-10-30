<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Models\Service;
use App\Models\ServiceField;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('service_id')
                    ->label('Service')
                    ->options(Service::all()->pluck('name', 'id'))
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('serviceFields', [])),

                Forms\Components\Fieldset::make('Service Details')
                    ->statePath('serviceFields')
                    ->schema(fn (callable $get) =>
                    static::getServiceFieldsSchema($get('service_id'))
                    ),

                Forms\Components\TextInput::make('parent_task_id')
                    ->numeric(),
                Forms\Components\TextInput::make('workflow_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('status_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('priority')
                    ->options([
                        'low' => 'Low',
                        'medium' => 'Medium',
                        'high' => 'High',
                    ])
                    ->required(),
                Forms\Components\DatePicker::make('due_date')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('parent_task_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('workflow_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('priority'),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }

    protected static function getServiceFieldsSchema(?int $serviceId): array
    {
        if (!$serviceId) {
            return [];
        }

        $fields = ServiceField::where('service_id', $serviceId)->get();

        return $fields->map(function ($field) {
            switch ($field->field_type) {
                case 'text':
                    return Forms\Components\TextInput::make($field->id)
                        ->label($field->field_name)
                        ->required($field->is_required);
                case 'textarea':
                    return Forms\Components\Textarea::make($field->id)
                        ->label($field->field_name)
                        ->required($field->is_required);
                case 'select':
                    return Forms\Components\Select::make($field->id)
                        ->label($field->field_name)
                        ->options(collect($field->field_options)->toArray())
                        ->required($field->is_required);
                case 'checkbox':
                    return Forms\Components\Checkbox::make($field->id)
                        ->label($field->field_name)
                        ->required($field->is_required);
                default:
                    return Forms\Components\TextInput::make($field->id)
                        ->label($field->field_name)
                        ->required($field->is_required);
            }
        })->toArray();
    }
}
