<?php

namespace App\Filament\Resources\TestResource\Pages;

use App\Filament\Resources\TestResource;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use FilamentTiptapEditor\TiptapEditor;

class ViewTest extends Page implements HasForms
{
    use InteractsWithForms;
    use InteractsWithRecord;

    protected static string $resource = TestResource::class;

    protected static string $view = 'filament.resources.test-resource.pages.view-test';
    public ?array $data = [];

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->data = $this->setData();
    }

    public function form(Form $form): Form
    {
        return $form
            // ->extraAttributes(['max-width' => '100%'])
            ->schema([
                Split::make([
                    Section::make([
                        TiptapEditor::make('description')
                            ->columnSpan(2)
                            ->disabled()
                            ->required(),
                    ])->columns(2),
                    Section::make([
                        TextInput::make('id')
                            ->prefix("#")
                            ->inlineLabel()
                            ->label("Case Number")
                            ->disabled(),
                        TextInput::make('requester')
                            ->prefixIcon("heroicon-o-user-circle")
                            ->inlineLabel()
                            ->label("Requested by")
                            ->disabled(),
                        TextInput::make('project')
                            ->prefixIcon("heroicon-o-clipboard-document-list")
                            ->inlineLabel()
                            ->disabled(),
                        TextInput::make('status')
                            ->inlineLabel()
                            ->disabled(),
                        TextInput::make('type')
                            ->inlineLabel()
                            ->disabled(),
                        TextInput::make('nr_of_messages')
                            ->prefixIcon("heroicon-o-chat-bubble-left-right")
                            ->inlineLabel()
                            ->live()
                            ->reactive()
                            ->disabled(),
                        DateTimePicker::make('created_at')
                            ->prefixIcon('heroicon-o-calendar-days')
                            ->native(false)
                            ->dehydrated()
                            ->inlineLabel()
                            ->disabled(),
                        TextInput::make('assignee')
                            ->placeholder('TBD')
                            ->prefixIcon("heroicon-o-user-circle")
                            ->inlineLabel()
                            ->disabled(),

                    ])->grow(false),
                ])->from('sm')
            ])->statePath('data');
    }

    protected function setData(): array
    {
        $record = $this->record;
        $data = [
            'id' => $record['id'],
            'requester' => 'Adam Weston',
            'project' => 'Test',
            'created_at' => 'Never',
            'status' => 'Errors',
            'type' => 'Terrible Errors',
            'description' => $record["description"],
            'nr_of_messages' => 69
        ];

        return $data;
    }
}
