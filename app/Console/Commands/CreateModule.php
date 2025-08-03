<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
class CreateModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module with the specified name';

    /**
     * Execute the console command.
     */

        public function handle()
    {
        $moduleName = $this->argument('name');
        $basePath = base_path("src/Modules/{$moduleName}");

        // Define the folder structure
        $folders = [
            'Controllers',
            'Models',
            'Repositories',
            'Requests',
            'Resources',
            'Routes',
            'Services',
        ];

        // Create the module folder and subfolders
        if (!File::exists($basePath)) {
            File::makeDirectory($basePath, 0755, true);
            foreach ($folders as $folder) {
                File::makeDirectory("{$basePath}/{$folder}", 0755, true);
            }

            // Create placeholder files
            File::put("{$basePath}/Controllers/{$moduleName}Controller.php", $this->getControllerTemplate($moduleName));
            File::put("{$basePath}/Models/{$moduleName}.php", $this->getModelTemplate($moduleName));
            File::put("{$basePath}/Repositories/{$moduleName}Repository.php", $this->getRepositoryTemplate($moduleName));
            File::put("{$basePath}/Requests/Create{$moduleName}Request.php", $this->getRequestTemplate($moduleName));
            File::put("{$basePath}/Resources/{$moduleName}Resource.php", $this->getResourceTemplate($moduleName));
            File::put("{$basePath}/Routes/api.php", $this->getRoutesTemplate($moduleName));
            File::put("{$basePath}/Services/{$moduleName}Service.php", $this->getServiceTemplate($moduleName));

            $this->info("Module '{$moduleName}' created successfully!");
        } else {
            $this->error("Module '{$moduleName}' already exists!");
        }

        return 0;
    }

    private function getControllerTemplate($moduleName)
    {
        return <<<PHP
<?php

namespace App\Modules\\{$moduleName}\Controllers;

use App\Http\Controllers\Controller;

class {$moduleName}Controller extends Controller
{
    public function index()
    {
        //
    }
}
PHP;
    }

    private function getModelTemplate($moduleName)
    {
        return <<<PHP
<?php

namespace App\Modules\\{$moduleName}\Models;

use Illuminate\Database\Eloquent\Model;

class {$moduleName} extends Model
{
    protected \$fillable = [];
}
PHP;
    }

    private function getRepositoryTemplate($moduleName)
    {
        return <<<PHP
<?php

namespace App\Modules\\{$moduleName}\Repositories;

class {$moduleName}Repository
{
    //
}
PHP;
    }

    private function getRequestTemplate($moduleName)
    {
        return <<<PHP
<?php

namespace App\Modules\\{$moduleName}\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Create{$moduleName}Request extends FormRequest
{
    public function rules(): array
    {
        return [
            //
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
PHP;
    }

    private function getResourceTemplate($moduleName)
    {
        return <<<PHP
<?php

namespace App\Modules\\{$moduleName}\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class {$moduleName}Resource extends JsonResource
{
    public function toArray(\$request): array
    {
        return parent::toArray(\$request);
    }
}
PHP;
    }

    private function getRoutesTemplate($moduleName)
    {
        return <<<PHP
<?php

use Illuminate\Support\Facades\Route;

Route::prefix('{$moduleName}')->group(function () {
    Route::get('/', function () {
        return response()->json(['message' => '{$moduleName} module']);
    });
});
PHP;
    }

    private function getServiceTemplate($moduleName)
    {
        return <<<PHP
<?php

namespace App\Modules\\{$moduleName}\Services;

class {$moduleName}Service
{
    //
}
PHP;
    }

}
