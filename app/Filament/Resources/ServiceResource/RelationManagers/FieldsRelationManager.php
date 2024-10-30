<?php

namespace App\Filament\Resources\ServiceResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FieldsRelationManager extends RelationManager
{
    protected static string $relationship = 'fields';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('field_name')
                    ->label('Field Name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('field_type')
                    ->label('Field Type')
                    ->options([
                        'text' => 'Text',
                        'textarea' => 'Textarea',
                        'select' => 'Select',
                        'checkbox' => 'Checkbox',
                    ])
                    ->reactive() // To make it dynamically show/hide options
                    ->required(),

                Forms\Components\Textarea::make('field_options')
                    ->label('Field Options (JSON)')
                    ->helperText('Enter options in JSON format if this is a select or checkbox field. E.g., ["Option 1", "Option 2"]')
                    ->hidden(fn (callable $get) => !in_array($get('field_type'), ['select', 'checkbox'])),

                Forms\Components\Toggle::make('is_required')
                    ->label('Is Required')
                    ->default(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('field_name')
            ->columns([
                Tables\Columns\TextColumn::make('field_name')->label('Field Name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('field_type')->label('Field Type')->sortable(),
                Tables\Columns\IconColumn::make('is_required')->label('Required')->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        if (in_array($data['field_type'], ['select', 'checkbox'])) {
                            $data['field_options'] = json_decode($data['field_options'], true);
                        }
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
