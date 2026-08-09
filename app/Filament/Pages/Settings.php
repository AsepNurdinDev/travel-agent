<?php

namespace App\Filament\Pages;

use UnitEnum;
use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'System';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->can('settings.view') ?? false;
    }

    public function mount(): void
    {
        $this->form->fill([
            'company_name' => Setting::getValue('company_name', config('app.name')),
            'company_email' => Setting::getValue('company_email'),
            'company_phone' => Setting::getValue('company_phone'),
            'company_address' => Setting::getValue('company_address'),
            'maintenance_mode' => Setting::getValue('maintenance_mode', false),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Company Information')
                    ->columns(2)
                    ->components([
                        TextInput::make('company_name')->required()->maxLength(255),
                        TextInput::make('company_email')->email()->maxLength(255),
                        TextInput::make('company_phone')->tel()->maxLength(50),
                        Textarea::make('company_address')->columnSpanFull(),
                    ]),
                Section::make('Public Site')
                    ->components([
                        Toggle::make('maintenance_mode')
                            ->label('Maintenance mode')
                            ->helperText('When on, the public website should show a maintenance page (public site is out of scope for this pass, so this flag is stored for later use).'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        Setting::setValue('company_name', $data['company_name'] ?? '');
        Setting::setValue('company_email', $data['company_email'] ?? '');
        Setting::setValue('company_phone', $data['company_phone'] ?? '');
        Setting::setValue('company_address', $data['company_address'] ?? '');
        Setting::setValue('maintenance_mode', $data['maintenance_mode'] ?? false, 'boolean');

        Notification::make()
            ->title('Settings saved')
            ->success()
            ->send();
    }
}
