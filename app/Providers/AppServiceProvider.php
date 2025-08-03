<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use App\Repositories\AttachmentTypeRepository;
use App\Repositories\AttachmentTypeRepositoryInterface;
use App\Repositories\CityDistrictRepository;
use App\Repositories\CityDistrictRepositoryInterface;
use App\Repositories\CityRepository;
use App\Repositories\CityRepositoryInterface;
use App\Repositories\ClientFileRepository;
use App\Repositories\ClientFileRepositoryInterface;
use App\Repositories\ClientPhoneNumberRepository;
use App\Repositories\ClientPhoneNumberRepositoryInterface;
use App\Repositories\ClientRepository;
use App\Repositories\ClientRepositoryInterface;
use App\Repositories\ContractMealRepository;
use App\Repositories\ContractMealRepositoryInterface;
use App\Repositories\CountyDistrictRepository;
use App\Repositories\CountyDistrictRepositoryInterface;
use App\Repositories\DeliveryCostRepository;
use App\Repositories\DeliveryCostRepositoryInterface;
use App\Repositories\EmergencyContactRepository;
use App\Repositories\EmergencyContactRepositoryInterface;
use App\Repositories\EthnicityRepository;
use App\Repositories\EthnicityRepositoryInterface;
use App\Repositories\FoodCostRepository;
use App\Repositories\FoodCostRepositoryInterface;
use App\Repositories\GenderRepository;
use App\Repositories\GenderRepositoryInterface;
use App\Repositories\HealthcareProviderPlanRepository;
use App\Repositories\HealthcareProviderPlanRepositoryInterface;
use App\Repositories\HealthcareProviderRepository;
use App\Repositories\HealthcareProviderRepositoryInterface;
use App\Repositories\HouseholdMemberRepository;
use App\Repositories\HouseholdMemberRepositoryInterface;
use App\Repositories\HouseholdRelationTypeRepository;
use App\Repositories\HouseholdRelationTypeRepositoryInterface;
use App\Repositories\HowpaContractRepository;
use App\Repositories\HowpaContractRepositoryInterface;
use App\Repositories\IdentificationTypeRepository;
use App\Repositories\IdentificationTypeRepositoryInterface;
use App\Repositories\IncomeLimitRepository;
use App\Repositories\IncomeLimitRepositoryInterface;
use App\Repositories\LegalStatusRepository;
use App\Repositories\LegalStatusRepositoryInterface;
use App\Repositories\MealContractStatisticsRepository;
use App\Repositories\MealContractStatisticsRepositoryInterface;
use App\Repositories\MonthlyAssistancePaymentRepository;
use App\Repositories\MonthlyAssistancePaymentRepositoryInterface;
use App\Repositories\ProgramBranchRepository;
use App\Repositories\ProgramBranchRepositoryInterface;
use App\Repositories\ProgramDeliveryCostRepository;
use App\Repositories\ProgramDeliveryCostRepositoryInterface;
use App\Repositories\ProgramRepository;
use App\Repositories\ProgramRepositoryInterface;
use App\Repositories\TerminationReasonRepository;
use App\Repositories\TerminationReasonRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            IdentificationTypeRepositoryInterface::class,
            IdentificationTypeRepository::class
        );
        $this->app->bind(
            ProgramBranchRepositoryInterface::class,
            ProgramBranchRepository::class
        );
        $this->app->bind(
            ProgramRepositoryInterface::class,
            ProgramRepository::class
        );
        $this->app->bind(
            LegalStatusRepositoryInterface::class,
            LegalStatusRepository::class
        );

        $this->app->bind(
            CityRepositoryInterface::class,
            CityRepository::class
        );
        $this->app->bind(
            GenderRepositoryInterface::class,
            GenderRepository::class
        );
        $this->app->bind(
            EthnicityRepositoryInterface::class,
            EthnicityRepository::class
        );
        $this->app->bind(
            HealthcareProviderRepositoryInterface::class,
            HealthcareProviderRepository::class
        );
        $this->app->bind(
            HealthcareProviderPlanRepositoryInterface::class,
            HealthcareProviderPlanRepository::class
        );
        $this->app->bind(
            MonthlyAssistancePaymentRepositoryInterface::class,
            MonthlyAssistancePaymentRepository::class
        );
        $this->app->bind(
            ClientRepositoryInterface::class,
            ClientRepository::class
        );
        $this->app->bind(
            CityDistrictRepositoryInterface::class,
            CityDistrictRepository::class
        );
        $this->app->bind(
            CountyDistrictRepositoryInterface::class,
            CountyDistrictRepository::class
        );
        $this->app->bind(
            AttachmentTypeRepositoryInterface::class,
            AttachmentTypeRepository::class
        );
        $this->app->bind(
            ClientFileRepositoryInterface::class,
            ClientFileRepository::class
        );
        $this->app->bind(
            HouseholdRelationTypeRepositoryInterface::class,
            HouseholdRelationTypeRepository::class
        );
        $this->app->bind(
            HouseholdMemberRepositoryInterface::class,
            HouseholdMemberRepository::class
        );
        $this->app->bind(
            ClientPhoneNumberRepositoryInterface::class,
            ClientPhoneNumberRepository::class
        );
        $this->app->bind(
            IncomeLimitRepositoryInterface::class,
            IncomeLimitRepository::class
        );
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            ContractMealRepositoryInterface::class,
            ContractMealRepository::class
        );

        $this->app->bind(
            DeliveryCostRepositoryInterface::class,
            DeliveryCostRepository::class
        );

        $this->app->bind(
            FoodCostRepositoryInterface::class,
            FoodCostRepository::class
        );
        $this->app->bind(
            ProgramDeliveryCostRepositoryInterface::class,
            ProgramDeliveryCostRepository::class
        );
        $this->app->bind(
            TerminationReasonRepositoryInterface::class,
            TerminationReasonRepository::class
        );
        $this->app->bind(
            MealContractStatisticsRepositoryInterface::class,
            MealContractStatisticsRepository::class
        );
        $this->app->bind(HowpaContractRepositoryInterface::class, HowpaContractRepository::class);
        $this->app->bind(EmergencyContactRepositoryInterface::class, EmergencyContactRepository::class);
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /* URL::forceHttps(
            $this->app->environment(['staging', 'production', 'demo'])
                && !$this->app->environment(['testing', 'local'])
        );*/
        /*if ($this->app->isProduction()) {
            $this->app['request']->server->set('HTTPS', true);
            $this->app['router']->middleware(function ($request, $next) {
                $response = $next($request);
                return $response->withHeaders([
                    'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
                    'X-Frame-Options' => 'SAMEORIGIN',
                    'X-Content-Type-Options' => 'nosniff'
                ]);
            });
        }*/

        VerifyEmail::toMailUsing(function (object $notifiable, string $verificationUrl) {
            return (new MailMessage)
                ->subject(__('Verify Email Address'))
                ->line(__('Please click the button below to verify your email address.'))
                ->action(__('Verify Email Address'), $verificationUrl)
                ->line(__('If you did not create an account, no further action is required.'));
        });
    }
}
