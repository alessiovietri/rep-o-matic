<?php

namespace AlexTigaer\RepOMatic\Commands;

use Illuminate\Console\Command;

class CreateRepo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repo:create
        {name               :   The name of the repository to create}
        {--e=y              :   Choose whether to create the exceptions, or not [y/n]}
        {--m=y              :   Choose whether to create the model, or not [y/n]}
        {--m-fillable=*     :   The mass-assignable attributes of the model}
        {--m-hidden=*       :   The hidden attributes of the model}
        {--r=y              :   Choose whether to create the repository, or not [y/n]}
        {--n=y              :   Choose whether to create the migration, or not [y/n]}
        {--n-types=*        :   The columns types of the attributes (check Laravel doc for acceptable values)}
        {--migrate=n        :   Choose whether to run the command migrate, or not [y/n]}
        {--s=y              :   Choose whether to create the seeder, or not [y/n]}
        {--s-instances=*    :   The values of the instances} 
        {--seed=n           :   Choose whether to run the command db:seed, or not [y/n]}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create repositories easily!';

    /**
     * The name of the repo.
     *
     * @var string
     */
    protected $name;

    /**
     * Check if the exceptions should be created.
     *
     * @var string
     */
    protected $createExceptions;

    /**
     * Check if the model should be created.
     *
     * @var string
     */
    protected $createModel;

    /**
     * The mass-assignable attributes of the model.
     *
     * @var array
     */
    protected $modelFillable;

    /**
     * The hidden attributes of the model.
     *
     * @var array
     */
    protected $modelHidden;

    /**
     * Check if the repository should be created.
     *
     * @var string
     */
    protected $createRepository;

    /**
     * Check if the migration should be created.
     *
     * @var string
     */
    protected $createMigration;

    /**
     * The types of the columns.
     *
     * @var array
     */
    protected $types;

    /**
     * Check if the command migrate should be run.
     *
     * @var array
     */
    protected $migrate;

    /**
     * Check if the seeder should be created.
     *
     * @var string
     */
    protected $createSeeder;

    /**
     * The values of the instances.
     *
     * @var array
     */
    protected $instances;

    /**
     * The separator character between instances values.
     *
     * @var char
     */
    protected $separator = ',';

    /**
     * Check if the command db:seed should be run.
     *
     * @var array
     */
    protected $seed;

    /**
     * Package's base dir.
     *
     * @var string
     */
    protected $baseDir;

    /**
     * The word to be replaced.
     *
     * @var string
     */
    protected $word = 'ENTITYNAME';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->baseDir = base_path('vendor\\alextigaer\\rep-o-matic\\src\\RepOMatic');
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Save repository name
        $this->name = $this->argument('name');

        // Save the choice for the exceptions
        $this->createExceptions = $this->option('e');

        // Save the choice for the model
        $this->createModel = $this->option('m');

        // Save model's mass-assignable attributes
        $this->modelFillable = $this->option('m-fillable');

        // Save model's hidden attributes
        $this->modelHidden = $this->option('m-hidden');

        // Save the choice for the repository
        $this->createRepository = $this->option('r');

        // Save the choice for the migration
        $this->createMigration = $this->option('n');

        // Save the types of the columns
        $this->types = $this->option('n-types');

        // Save the choice for the command migrate
        $this->migrate = $this->option('migrate');

        // Save the choice for the seeder
        $this->createSeeder = $this->option('s');

        // Save the values of the instances
        $this->instances = $this->option('s-instances');

        // Save the choice for the command db:seed
        $this->seed = $this->option('seed');

        // Check the name is not empty...
        if($this->name == "")
            // ...and show a message if it is
            $this->error('ERROR: repo name missing');
        else{
            // Print repo name
            $this->info('-------------------------------');
            $this->info('- CREATE \''.$this->name.'\' REPOSITORY -');
            $this->info('-------------------------------');
            $this->line('');

            // Create app\Exceptions\RepoName dir and the 4 repo exceptions
            if($this->createExceptions == 'y')
                $this->create_exceptions();

            // Create the app\Models dir and the repo model
            if($this->createModel == 'y')
                $this->create_model();

            // Create the app\Repositories dir, the app\Repositories\Contracts dir,
            // the app\Repositories\RepoName dir, the RepoName contract and the
            // RepoName repository files
            if($this->createRepository == 'y')
                $this->create_repository();

            // Create the create_reponames_table migration
            if($this->createMigration == 'y')
                $this->create_migration();

            // Create the RepoNamesSeeder seeder
            if($this->createSeeder == 'y')
                $this->create_seeder();

            // Show a confirmation message
            $this->info('\''.$this->name.'\' REPOSITORY CREATED SUCCESSFULLY!');
            $this->info('-------------------------------');
        }
    }

    /**
     * Create exceptions files
     *
     * @return void
     */
    private function create_exceptions(){
        $this->line('- Creating \''.$this->name.'\' exceptions...');

        // Edit and copy all files from package's exceptions dir
        $repoExceptionsDir = app_path('Exceptions\\'.$this->name);
        if(!file_exists($repoExceptionsDir))
            mkdir($repoExceptionsDir);

        $notFoundExc = $this->name.'\\'.$this->name.'NotFoundException';
        $notCreatedExc = $this->name.'\\'.$this->name.'NotCreatedException';
        $notUpdatedExc = $this->name.'\\'.$this->name.'NotUpdatedException';
        $notDeletedExc = $this->name.'\\'.$this->name.'NotDeletedException';

        if(!file_exists(app_path($notFoundExc)))
            $this->callSilent('make:exception', [
                'name' => $this->name.'\\'.$this->name.'NotFoundException'
            ]);
        if(!file_exists(app_path($notCreatedExc)))
            $this->callSilent('make:exception', [
                'name' => $this->name.'\\'.$this->name.'NotCreatedException'
            ]);
        if(!file_exists(app_path($notUpdatedExc)))
            $this->callSilent('make:exception', [
                'name' => $this->name.'\\'.$this->name.'NotUpdatedException'
            ]);
        if(!file_exists(app_path($notDeletedExc)))
            $this->callSilent('make:exception', [
                'name' => $this->name.'\\'.$this->name.'NotDeletedException'
            ]);

        // Show a confirmation message
        $this->info('> \''.$this->name.'\' exceptions created!');
        $this->line('');
    }

    /**
     * Create model file
     *
     * @return void
     */
    private function create_model(){
        $this->line('- Creating \''.$this->name.'\' model...');

        // Edit and copy the package's model
        $modelsDir = app_path('Models');
        if(!file_exists($modelsDir))
            mkdir($modelsDir);
        $repoModelFile = 'Models\\'.$this->name;
        if(!file_exists(app_path($repoModelFile)))
            $this->callSilent('make:model', [
                'name' => $repoModelFile
            ]);

        $repoModelFileContent = file(app_path($repoModelFile.'.php'), FILE_IGNORE_NEW_LINES);
        foreach ($repoModelFileContent as $index => $value) {
            if(strpos($value, 'extends Model') != false){
                $repoModelFileContent[$index + 2] = "\t/**\n\t * The table associated with the model.\n\t *\n\t * @var string\n\t*/\n\tprotected \$table = 'MODELTABLE';\n\n\t/**\n\t * The attributes that are mass assignable.\n\t *\n\t * @var array\n\t*/\n\tprotected \$fillable = [\n\t];\n\n\t/**\n\t * The attributes that should be hidden for arrays.\n\t *\n\t * @var array\n\t*/\n\tprotected \$hidden = [\n\t];";
                break;
            }
        }
        $repoModelFileContent = implode("\n", $repoModelFileContent);
        file_put_contents(app_path($repoModelFile.'.php'), $repoModelFileContent);

        // Replace model's table name
        $modelTableString = "MODELTABLE";
        $repoModelFileContent = file_get_contents(app_path($repoModelFile.'.php'));
        $repoModelFileContent = str_replace($modelTableString, strtolower($this->name).'s', $repoModelFileContent);
        file_put_contents(app_path($repoModelFile.'.php'), $repoModelFileContent);

        // Add mass-assignable attributes if prompted by the user
        if(count($this->modelFillable) > 0){
            $modelAttributesString = "\t\t'".implode("',\n\t\t'", $this->modelFillable)."'";
            $repoModelFileContent = file(app_path($repoModelFile.'.php'), FILE_IGNORE_NEW_LINES);
            foreach ($repoModelFileContent as $index => $value) {
                if(strpos($value, '$fillable') != false){
                    array_splice($repoModelFileContent, $index + 1, 0, $modelAttributesString);
                    break;
                }
            }
            $repoModelFileContent = implode("\n", $repoModelFileContent);
            file_put_contents(app_path($repoModelFile.'.php'), $repoModelFileContent);
        }

        // Add hidden attributes if prompted by the user
        if(count($this->modelHidden) > 0){
            $modelHiddenAttributesString = "\t\t'".implode("',\n\t\t'", $this->modelHidden)."'";
            $repoModelFileContent = file(app_path($repoModelFile.'.php'), FILE_IGNORE_NEW_LINES);
            foreach ($repoModelFileContent as $index => $value) {
                if(strpos($value, '$hidden') != false){
                    array_splice($repoModelFileContent, $index + 1, 0, $modelHiddenAttributesString);
                    break;
                }
            }
            $repoModelFileContent = implode("\n", $repoModelFileContent);
            file_put_contents(app_path($repoModelFile.'.php'), $repoModelFileContent);
        }

        // Show a confirmation message
        $this->info('> \''.$this->name.'\' model created!');
        $this->line('');
    }

    /**
     * Create repository files and register the repository
     *
     * @return void
     */
    private function create_repository(){
        $this->line('- Creating \''.$this->name.'\' repository...');

        // Edit and copy the package's repository files
        $repoDir = app_path('Repositories');
        $repoContractsDir = $repoDir.'\\Contracts';
        $repoRepoNameDir = $repoDir.'\\'.$this->name;
        if(!file_exists($repoDir))
            mkdir($repoDir);
        if(!file_exists($repoContractsDir))
            mkdir($repoContractsDir);
        if(!file_exists($repoRepoNameDir))
            mkdir($repoRepoNameDir);
        $packageRepositoriesDir = $this->baseDir.'\\Repositories';
        $packageContractFileName = $this->word.'Repository.php';
        $packageRepositoryFileName = $this->word.'EloquentRepository.php';
        $packageContractFile = $packageRepositoriesDir.'\\'.$packageContractFileName;
        $packageRepositoryFile = $packageRepositoriesDir.'\\'.$packageRepositoryFileName;

        // Edit and copy contract file
        $repoContractFile = $repoContractsDir.'\\'.str_replace($this->word, $this->name, $packageContractFileName);
        $this->copy_file($packageContractFile, $repoContractFile);

        // Edit and copy repository file
        $repoRepositoryFile = $repoRepoNameDir.'\\'.str_replace($this->word, $this->name, $packageRepositoryFileName);
        $this->copy_file($packageRepositoryFile, $repoRepositoryFile);

        // Register the binding in AppServiceProvider
        $bindingLine = "\t\t".'$this->app->bind(\'App\\\\Repositories\\\\Contracts\\\\'.$this->name.'Repository\', \'App\\\\Repositories\\\\'.$this->name.'\\\\'.$this->name.'EloquentRepository\');';
        $appServiceProviderFile = app_path('Providers\\AppServiceProvider.php');
        $appServiceProviderFileContent = file($appServiceProviderFile, FILE_IGNORE_NEW_LINES);
        $foundRegister = false;
        foreach ($appServiceProviderFileContent as $index => $value) {
            if($foundRegister == false){
                if(strpos($value, 'register()') != false)
                    $foundRegister = true;
            }
            else{
                if(strpos($value, '}') != false){
                    array_splice($appServiceProviderFileContent, $index, 0, $bindingLine);
                    break;
                }
            }
        }
        $appServiceProviderFileContent = implode("\n", $appServiceProviderFileContent);
        file_put_contents($appServiceProviderFile, $appServiceProviderFileContent);

        // Show a confirmation message
        $this->info('> \''.$this->name.'\' repository created!');
        $this->line('');
    }

    /**
     * Create migration file
     *
     * @return void
     */
    private function create_migration(){
        $this->line('- Creating \''.$this->name.'\' migration...');

        // Build the correct name for the migration
        $migrationFileNameWords = preg_split('/(?=[A-Z])/', $this->name);
        $migrationFileNameWords[count($migrationFileNameWords) - 1] = str_plural($migrationFileNameWords[count($migrationFileNameWords) - 1]);
        $migrationFileName = 'create_'.strtolower(implode('_', $migrationFileNameWords)).'_table';

        // Call the command to create the migration file
        $this->callSilent('make:migration', [
            'name' => $migrationFileName
        ]);

        // Set the right column types inside the migration
        $fillableCount = count($this->modelFillable);
        $hiddenCount = count($this->modelHidden);
        $typesCount = count($this->types);
        $migrationRows = '';
        if($fillableCount > 0 || $hiddenCount > 0){
            if($typesCount == $fillableCount + $hiddenCount){
                $j = 0;
                for($i = 0; $i < $fillableCount; $i++){
                    if($j == 0)
                        $migrationRows .= "\t\t\t";
                    else
                        $migrationRows .= "\n\t\t\t";
                    $migrationRows .= '$table->'.$this->types[$j++]."('".$this->modelFillable[$i]."');";
                }
                for($i = 0; $i < $hiddenCount; $i++){
                    if($j == 0)
                        $migrationRows .= "\t\t\t";
                    else
                        $migrationRows .= "\n\t\t\t";
                    $migrationRows .= '$table->'.$this->types[$j++]."('".$this->modelHidden[$i]."');";
                }
            }
            else{
                $j = 0;
                if($typesCount > 0)
                    $this->line('- WARNING: the number of columns types inserted doesn\'t match with the model attributes number. Every types will be set to \'string\'');
                if($fillableCount > 0){
                    for($i = 0; $i < $fillableCount; $i++){
                        if($i == 0)
                            $migrationRows .= "\t\t\t";
                        else
                            $migrationRows .= "\n\t\t\t";
                        $migrationRows .= '$table->string'."('".$this->modelFillable[$i]."');";
                        $j++;
                    }
                }
                else{
                    if($hiddenCount > 0)
                        $migrationRows .= "\t\t\t";
                }
                for($i = 0; $i < $hiddenCount; $i++){
                    if($j > 0)
                        $migrationRows .= "\n\t\t\t";
                    $migrationRows .= '$table->string'."('".$this->modelHidden[$i]."');";
                    $j++;
                }
            }
            $migrations = scandir(database_path('migrations'), SCANDIR_SORT_DESCENDING);
            $databaseMigrationFile = database_path('migrations\\'.$migrations[0]);
            $databaseMigrationFileContent = file($databaseMigrationFile, FILE_IGNORE_NEW_LINES);
            foreach ($databaseMigrationFileContent as $index => $value) {
                if(strpos($value, '$table->increments(') != false){
                    array_splice($databaseMigrationFileContent, $index+1, 0, $migrationRows);
                    break;
                }
            }
            $databaseMigrationFileContent = implode("\n", $databaseMigrationFileContent);
            file_put_contents($databaseMigrationFile, $databaseMigrationFileContent);
        }

        // Run the command migrate if the option is set
        if($this->migrate == 'y'){
            $this->callSilent('migrate');

            // Show a confirmation message
            $this->info('> \''.$this->name.'\' migration created and run!');
            $this->line('');
        }
        else{
            // Show a confirmation message
            $this->info('> \''.$this->name.'\' migration created!');
            $this->line('');
        }
    }

    /**
     * Create seeder file and edit the database seeder
     *
     * @return void
     */
    private function create_seeder(){
        $this->line('- Creating \''.$this->name.'\' seeder...');

        $packageSeedersDir = $this->baseDir.'\\Seeders';
        $migrationFileNameWords = preg_split('/(?=[A-Z])/', $this->name);
        $migrationFileNameWords[count($migrationFileNameWords) - 1] = str_plural($migrationFileNameWords[count($migrationFileNameWords) - 1]);
        $packageSeederFileName = implode('', $migrationFileNameWords).'Seeder.php';
        $packageSeederFile = $packageSeedersDir.'\\'.$packageSeederFileName;

        // Create seeder file
        $repoSeederFile = implode('', $migrationFileNameWords).'Seeder';
        if(!file_exists(database_path('seeds\\'.$repoSeederFile)))
            $this->callSilent('make:seeder', [
                'name' => $repoSeederFile
            ]);

        $repoSeederFileContent = file(database_path('seeds\\'.$repoSeederFile.'.php'), FILE_IGNORE_NEW_LINES);
        foreach ($repoSeederFileContent as $index => $value) {
            if(strpos($value, 'Illuminate') != false)
                $repoSeederFileContent[$index + 1] = "\nuse App\\Models\\".$this->name." as ".$this->name.";\n";
            else if(strpos($value, 'run()') != false){
                $repoSeederFileContent[$index + 2] = "\t\t// Empty the ".$this->name." table before filling it\n\t\t".$this->name."::where('id', '<>', null)->delete();";
                break;
            }
        }
        $repoSeederFileContent = implode("\n", $repoSeederFileContent);
        file_put_contents(database_path('seeds\\'.$repoSeederFile.'.php'), $repoSeederFileContent);


        // Set the right values inside the seeder
        $fillableCount = count($this->modelFillable);
        $hiddenCount = count($this->modelHidden);
        $instancesCount = count($this->instances);
        if($fillableCount > 0 || $hiddenCount > 0){
            $seederElements = '';
            if($instancesCount > 0){
                foreach($this->instances as $index => $instance){
                    $instanceValues = explode($this->separator, $instance);
                    $valuesCount = count($instanceValues);
                    if($valuesCount == $fillableCount + $hiddenCount){
                        $seederElement = '';
                        $j = 0;
                        $seederElement .= "\n\t\t".$this->name."::create([";
                        for($i = 0; $i < $fillableCount; $i++){
                            $seederElement .= "\n\t\t\t'".$this->modelFillable[$i]."' => '".$instanceValues[$j]."'";
                            if($j < $valuesCount - 1)
                                $seederElement .= ',';
                            $j++;
                        }
                        for($i = 0; $i < $hiddenCount; $i++){
                            $seederElement .= "\n\t\t\t'".$this->modelHidden[$i]."' => '".$instanceValues[$j]."'";
                            if($j < $valuesCount - 1)
                                $seederElement .= ',';
                            $j++;
                        }
                        $seederElement .= "\n\t\t]);";
                        $seederElements .= $seederElement;
                    }
                    else{
                        if($valuesCount > 0)
                            $this->line('- WARNING: the number of values for the instance #'.($index + 1).' inserted doesn\'t match with the model attributes number. Every value will be set to \'VALUE\'');
                        $seederElement = "\n\t\t".$this->name."::create([\n\t\t\t'";
                        if($fillableCount > 0){
                            $seederElement .= implode("' => 'VALUE',\n\t\t\t'", $this->modelFillable);
                            if($hiddenCount == 0)
                                $seederElement .= "' => 'VALUE'";
                        }
                        if($hiddenCount > 0){
                            $seederElement .= "' => 'VALUE',\n\t\t\t'".implode("' => 'VALUE',\n\t\t\t'", $this->modelHidden)."' => 'VALUE'";
                        }
                        $seederElement .= "\n\t\t]);";
                        $seederElements .= $seederElement;
                    }
                    if($index < $instancesCount - 1)
                        $seederElements .= "\n";
                }
            }
            else{
                $seederElement = "\n\t\t".$this->name."::create([\n\t\t\t'";
                if($fillableCount > 0){
                    $seederElement .= implode("' => 'VALUE',\n\t\t\t'", $this->modelFillable);
                    if($hiddenCount == 0)
                        $seederElement .= "' => 'VALUE'";
                }
                if($hiddenCount > 0)
                    $seederElement .= "' => 'VALUE',\n\t\t\t'".implode("' => 'VALUE',\n\t\t\t'", $this->modelHidden)."' => 'VALUE'";
                $seederElement .= "\n\t\t]);";
                $seederElements .= $seederElement;
            }
            $repoSeederFileContent = file(database_path('seeds\\'.$repoSeederFile.'.php'), FILE_IGNORE_NEW_LINES);
            foreach ($repoSeederFileContent as $index => $value) {
                if(strpos($value, '::where') != false){
                    array_splice($repoSeederFileContent, $index + 1, 0, $seederElements);
                    break;
                }
            }
            $repoSeederFileContent = implode("\n", $repoSeederFileContent);
            file_put_contents(database_path('seeds\\'.$repoSeederFile.'.php'), $repoSeederFileContent);
        }

        // Update DatabaseSeeder file
        $seederLine = "\t\t".'$this->call('.implode('', $migrationFileNameWords).'Seeder::class);';
        $databaseSeederFile = database_path('seeds\\DatabaseSeeder.php');
        $databaseSeederFileContent = file($databaseSeederFile, FILE_IGNORE_NEW_LINES);
        $foundRun = false;
        foreach ($databaseSeederFileContent as $index => $value) {
            if($foundRun == false){
                if(strpos($value, 'run()') != false)
                    $foundRun = true;
            }
            else{
                if(strpos($value, '}') != false){
                    array_splice($databaseSeederFileContent, $index, 0, $seederLine);
                    break;
                }
            }
        }
        $databaseSeederFileContent = implode("\n", $databaseSeederFileContent);
        file_put_contents($databaseSeederFile, $databaseSeederFileContent);

        // Run the command db:seed if the option is set
        if($this->seed == 'y'){
            $this->callSilent('db:seed');

            // Show a confirmation message
            $this->info('> \''.$this->name.'\' seeder created and run!');
            $this->line('');
        }
        else{
            // Show a confirmation message
            $this->info('> \''.$this->name.'\' seeder created!');
            $this->line('');
        }
    }

    /**
     * Edit and copy repo files.
     *
     * @param $sourcePath
     * @param $destPath
     * @return void
     */
    private function copy_file($sourcePath, $destPath)
    {
        // Read source file
        $sourceFileContent = file_get_contents($sourcePath);

        // Replace all occurrences of the word in the file with the repo name
        $destFileContent = str_replace($this->word, $this->name, $sourceFileContent);

        // Write destination file
        file_put_contents($destPath, $destFileContent);
    }
}
