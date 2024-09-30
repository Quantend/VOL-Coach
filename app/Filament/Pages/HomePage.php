<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use App\Models\Home;
use Filament\Forms\Form;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;


class HomePage extends Page implements HasForms
{
    use InteractsWithForms;
    public ?array $data = [];
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.pages.home-page';

    public Home $home;

    public function mount(): void
    {
        $this->home = Home::firstOrCreate([]);

        $this->data = [
            'content' => $this->home->content,
            'media' => $this->home->media,
        ];

        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('media')
                    ->label('Youtube link')
                    ->default($this->data['media']),
                TinyEditor::make('content')
                    ->profile('custom')
                    ->required()
                    ->default($this->data['content']),
            ])
            ->statePath('data');
    }

    public function getFormActions(): array
    {
        return [
            Action::make('save')
              ->label('Save')
              ->submit('save')
        ];
    }

    public function save(): void
    {
        $this->home->fill($this->data);
        $this->home->save();

        Notification::make()
            ->success()
            ->title('Saved')
            ->send();
    }
}
