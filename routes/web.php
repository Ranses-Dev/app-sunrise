<?php

use App\Http\Controllers\ClientDownloadController;
use App\Http\Controllers\ClientFileDownloadController;
use App\Http\Controllers\Statistics\Client\ListClientsPdfController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Enums\Orientation;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Livewire\Components\Dashboard;



Route::middleware(['throttle:60,1'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    })->name('home');
    Route::middleware(['auth',/* 'verified',  'has-two-factor-activated', 'two-factor'*/])->group(function () {
        Route::prefix('settings')->as('settings.')->group(function () {
            Route::get('profile', Profile::class)->name('profile');
            Route::get('password', Password::class)->name('password');
            Route::get('two-factor', TwoFactor::class)->name('two-factor');
        });
        Route::get('dashboard', Dashboard::class)
            ->name('dashboard');
        Route::redirect('settings', 'settings/profile');
        Route::get('settings/profile', Profile::class)->name('settings.profile');
        Route::get('settings/password', Password::class)->name('settings.password');
        Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
        //Identification Types
        Route::get('identification-types', \App\Livewire\IdentificationType\Index::class)->name('identification-types.index');
        Route::get('identification-types/create', \App\Livewire\IdentificationType\Create::class)->name('identification-types.create');
        Route::get('identification-types/{id}/edit', \App\Livewire\IdentificationType\Edit::class)->name('identification-types.edit');
        Route::get('identification-types/{id}/show', \App\Livewire\IdentificationType\Show::class)->name('identification-types.show');
        //Programs
        Route::get('programs', \App\Livewire\Program\Index::class)->name('programs.index');
        Route::get('programs/create', \App\Livewire\Program\Create::class)->name('programs.create');
        Route::get('programs/{id}/edit', \App\Livewire\Program\Edit::class)->name('programs.edit');
        Route::get('programs/{id}/show', \App\Livewire\Program\Show::class)->name('programs.show');
        //Program Branches
        Route::get('program-branches', \App\Livewire\ProgramBranch\Index::class)->name('program-branches.index');
        Route::get('program-branches/create', \App\Livewire\ProgramBranch\Create::class)->name('program-branches.create');
        Route::get('program-branches/{id}/edit', \App\Livewire\ProgramBranch\Edit::class)->name('program-branches.edit');
        Route::get('program-branches/{id}/show', \App\Livewire\ProgramBranch\Show::class)->name('program-branches.show');
        //Legal Status
        Route::get('legal-statuses', \App\Livewire\LegalStatus\Index::class)->name('legal-statuses.index');
        Route::get('legal-statuses/create', \App\Livewire\LegalStatus\Create::class)->name('legal-statuses.create');
        Route::get('legal-statuses/{id}/edit', \App\Livewire\LegalStatus\Edit::class)->name('legal-statuses.edit');
        Route::get('legal-statuses/{id}/show', \App\Livewire\LegalStatus\Show::class)->name('legal-statuses.show');
        //Genders
        Route::get('genders', \App\Livewire\Gender\Index::class)->name('genders.index');
        Route::get('genders/create', \App\Livewire\Gender\Create::class)->name('genders.create');
        Route::get('genders/{id}/edit', \App\Livewire\Gender\Edit::class)->name('genders.edit');
        Route::get('genders/{id}/show', \App\Livewire\Gender\Show::class)->name('genders.show');
        //Ethnicities
        Route::get('ethnicities', \App\Livewire\Ethnicity\Index::class)->name('ethnicities.index');
        Route::get('ethnicities/create', \App\Livewire\Ethnicity\Create::class)->name('ethnicities.create');
        Route::get('ethnicities/{id}/edit', \App\Livewire\Ethnicity\Edit::class)->name('ethnicities.edit');
        Route::get('ethnicities/{id}/show', \App\Livewire\Ethnicity\Show::class)->name('ethnicities.show');
        //Health Care Providers
        Route::get('health-care-providers', \App\Livewire\HealthCareProvider\Index::class)->name('health-care-providers.index');
        Route::get('health-care-providers/create', \App\Livewire\HealthCareProvider\Create::class)->name('health-care-providers.create');
        Route::get('health-care-providers/{id}/edit', \App\Livewire\HealthCareProvider\Edit::class)->name('health-care-providers.edit');
        Route::get('health-care-providers/{id}/show', \App\Livewire\HealthCareProvider\Show::class)->name('health-care-providers.show');
        //Healthcare Provider Plans
        Route::get('healthcare-provider-plans', \App\Livewire\HealthcareProviderPlan\Index::class)->name('healthcare-provider-plans.index');
        Route::get('healthcare-provider-plans/create', \App\Livewire\HealthcareProviderPlan\Create::class)->name('healthcare-provider-plans.create');
        Route::get('healthcare-provider-plans/{id}/edit', \App\Livewire\HealthcareProviderPlan\Edit::class)->name('healthcare-provider-plans.edit');
        //Route::get('healthcare-provider-plans/{id}/show', \App\Livewire\HealthCareProviderPlan\Show::class)->name('healthcare-provider-plans.show');
        //Health Care Providers
        Route::get('monthly-assistance-payments', \App\Livewire\MonthlyAssistancePayment\Index::class)->name('monthly-assistance-payments.index');
        Route::get('monthly-assistance-payments/create', \App\Livewire\MonthlyAssistancePayment\Create::class)->name('monthly-assistance-payments.create');
        Route::get('monthly-assistance-payments/{id}/edit', \App\Livewire\MonthlyAssistancePayment\Edit::class)->name('monthly-assistance-payments.edit');
        Route::get('monthly-assistance-payments/{id}/show', \App\Livewire\MonthlyAssistancePayment\Show::class)->name('monthly-assistance-payments.show');
        //Cities
        Route::get('cities', \App\Livewire\City\Index::class)->name('cities.index');
        Route::get('cities/create', \App\Livewire\City\Create::class)->name('cities.create');
        Route::get('cities/{id}/edit', \App\Livewire\City\Edit::class)->name('cities.edit');
        Route::get('cities/{id}/show', \App\Livewire\City\Show::class)->name('cities.show');
        //City Districts
        Route::get('city-districts', \App\Livewire\CityDistrict\Index::class)->name('city-districts.index');
        Route::get('city-districts/create', \App\Livewire\CityDistrict\Create::class)->name('city-districts.create');
        Route::get('city-districts/{id}/edit', \App\Livewire\CityDistrict\Edit::class)->name('city-districts.edit');
        Route::get('city-districts/{id}/show', \App\Livewire\CityDistrict\Show::class)->name('city-districts.show');
        //City Districts
        Route::get('county-districts', \App\Livewire\CountyDistrict\Index::class)->name('county-districts.index');
        Route::get('county-districts/create', \App\Livewire\CountyDistrict\Create::class)->name('county-districts.create');
        Route::get('county-districts/{id}/edit', \App\Livewire\CountyDistrict\Edit::class)->name('county-districts.edit');
        Route::get('county-districts/{id}/show', \App\Livewire\CountyDistrict\Show::class)->name('county-districts.show');
        //Attachment Types
        Route::get('attachment-types', \App\Livewire\AttachmentType\Index::class)->name('attachment-types.index');
        Route::get('attachment-types/create', \App\Livewire\AttachmentType\Create::class)->name('attachment-types.create');
        Route::get('attachment-types/{id}/edit', \App\Livewire\AttachmentType\Edit::class)->name('attachment-types.edit');
        Route::get('attachment-types/{id}/show', \App\Livewire\AttachmentType\Show::class)->name('attachment-types.show');
        //Clients
        Route::get('clients/{id}/download-picture', ClientDownloadController::class)->name('clients.download.picture');
        Route::get('clients/certification-due', \App\Livewire\Client\CertificationsDue::class)->name('clients-certifications-due.index');
        Route::get('clients/certification-overdue', \App\Livewire\Client\CertificationsOverdue::class)->name('clients-certifications-overdue.index');
        Route::get('clients/identification-due', \App\Livewire\Client\IdentificationsDue::class)->name('clients-identifications-due.index');
        Route::get('clients/identification-overdue', \App\Livewire\Client\IdentificationsOverdue::class)->name('clients-identifications-overdue.index');
        Route::get('clients', \App\Livewire\Client\Index::class)->name('clients.index');
        Route::get('clients/create', \App\Livewire\Client\Create::class)->name('clients.create');
        Route::get('clients/{id}/edit', \App\Livewire\Client\Edit::class)->name('clients.edit');
        Route::get('clients/{id}/show', \App\Livewire\Client\Show::class)->name('clients.show');
        Route::get('client-files/{id}/download', ClientFileDownloadController::class)->name('client.files.download');
        //Statistics
        Route::get('statistics/clients/list', ListClientsPdfController::class)->name('statistics.clients.pdfs.list');
        //HouseholdRelationTypes
        Route::get('household-relation-types', \App\Livewire\HouseholdRelationType\Index::class)->name('household-relation-types.index');
        Route::get('household-relation-types/create', \App\Livewire\HouseholdRelationType\Create::class)->name('household-relation-types.create');
        Route::get('household-relation-types/{id}/edit', \App\Livewire\HouseholdRelationType\Edit::class)->name('household-relation-types.edit');
        Route::get('household-relation-types/{id}/show', \App\Livewire\HouseholdRelationType\Show::class)->name('household-relation-types.show');
        //Income Limits
        Route::get('income-limits', \App\Livewire\IncomeLimit\Index::class)->name('income-limits.index');
        Route::get('income-limits/create', \App\Livewire\IncomeLimit\Create::class)->name('income-limits.create');
        Route::get('income-limits/{id}/edit', \App\Livewire\IncomeLimit\Edit::class)->name('income-limits.edit');
        Route::get('income-limits/{id}/show', \App\Livewire\IncomeLimit\Show::class)->name('income-limits.show');
        //Contract Meals
        Route::get('contract-meals', \App\Livewire\ContractMeal\Index::class)->name('contract-meals.index');
        Route::get('contract-meals/create', \App\Livewire\ContractMeal\Create::class)->name('contract-meals.create');
        Route::get('contract-meals/{id}/edit', \App\Livewire\ContractMeal\Edit::class)->name('contract-meals.edit');
        Route::get('contract-meals/{id}/show', \App\Livewire\ContractMeal\Show::class)->name('contract-meals.show');
        //Howpa Contracts
        Route::get('howpa-contracts', \App\Livewire\HowpaContract\Index::class)->name('howpa.contracts.index');
        Route::get('howpa-contracts/create', \App\Livewire\HowpaContract\Create::class)->name('howpa.contracts.create');
        Route::get('howpa-contracts/{id}/edit', \App\Livewire\HowpaContract\Edit::class)->name('howpa.contracts.edit');
        Route::get('howpa-contracts/{id}/show', \App\Livewire\HowpaContract\Show::class)->name('howpa.contracts.show');
        //
        //Address
        Route::get('addresses', \App\Livewire\Address\Index::class)->name('addresses.index');
        Route::get('addresses/create', \App\Livewire\Address\Create::class)->name('addresses.create');
        Route::get('addresses/{id}/edit', \App\Livewire\Address\Edit::class)->name('addresses.edit');
        Route::get('addresses/{id}/show', \App\Livewire\Address\Show::class)->name('addresses.show');
        //Inspections
        Route::get('inspections', \App\Livewire\Inspection\Index::class)->name('inspections.index');
        Route::get('inspections/create', \App\Livewire\Inspection\Create::class)->name('inspections.create');
        Route::get('inspections/{id}/edit', \App\Livewire\Inspection\Edit::class)->name('inspections.edit');
        Route::get('inspections/{id}/show', \App\Livewire\Inspection\Show::class)->name('inspections.show');
    });
    Route::prefix('exports')->as('exports.')->group(function () {
        //Exports
        Route::prefix('clients')->as('clients.')->group(function () {
            Route::get('identifications-due', \App\Http\Controllers\Exports\IdentificationsDue::class)->name('identifications-due');
            Route::get('identifications-overdue', \App\Http\Controllers\Exports\IdentificationsOverdue::class)->name('identifications-overdue');
            Route::get('recertifications-due', \App\Http\Controllers\Exports\RecertificationsDue::class)->name('recertifications-due');
            Route::get('recertifications-overdue', \App\Http\Controllers\Exports\RecertificationsOverdue::class)->name('recertifications-overdue');
        });
        Route::get('inspections', \App\Http\Controllers\Exports\InspectionExport::class)->name('inspections');
        Route::get('contract-meals', \App\Http\Controllers\Exports\ContractMealExport::class)->name('contract-meals');
        Route::get('howpa-contracts', \App\Http\Controllers\Exports\HowpaContractExport::class)->name('howpa-contracts');
    });
});

require __DIR__ . '/auth.php';

Route::prefix('howpa')->group(function () {
    Route::get('form-h33', function () {
        return  Pdf::format(Format::Letter)
            ->orientation(Orientation::Landscape)
            ->margins(10, 10, 10, 10)
            ->download('clients-list.pdf')
            ->view('exports.howpa.form-h33');
    });
    Route::get('form-h19', fn() => view('exports.howpa.form-h19'));
});
