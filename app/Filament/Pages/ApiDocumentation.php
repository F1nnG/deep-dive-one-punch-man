<?php

namespace App\Filament\Pages;

use App\Helpers\ApiRoutesHelper;
use Filament\Pages\Page;

class ApiDocumentation extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?string $navigationGroup = 'API';

    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.api-documentation';

    protected ?string $heading = 'API Documentation';

    protected static ?string $navigationLabel = 'Documentation';

    public array $requests;

    public function __construct()
    {
        $this->requests = ApiRoutesHelper::all();
    }
}
