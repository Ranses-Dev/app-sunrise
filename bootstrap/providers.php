<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    PragmaRX\Google2FALaravel\ServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
    Maatwebsite\Excel\ExcelServiceProvider::class,
];
