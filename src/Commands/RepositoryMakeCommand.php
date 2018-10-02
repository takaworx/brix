<?php

namespace Takaworx\Brix\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class RepositoryMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * The model of the repository
     *
     * @var string
     */
    protected $model;

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        if (! $this->option('model') || ! strlen($this->option('model'))) {
            throw new \Exception("No model specified! Use the --model option to specify a model.");
        }

        $this->model = $this->option('model');

        parent::handle();
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../stubs/repository.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Repositories';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_REQUIRED, 'Generate a resource controller for the given model.'],
        ];
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());
        $stub = $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
        $stub = $this->replaceModel($stub, $this->getModel());
        $stub = $this->replaceTableName($stub, $this->getModel());

        return $stub;
    }

    /**
     * Replace the model of the given stub.
     *
     * @param string $stub
     * @param string $model
     * @return string
     */
    protected function replaceModel($stub, $model)
    {
        $modelClass = $this->getModelClass();

        $stub = str_replace('DummyModel', $model, $stub);
        $stub = str_replace('DummyMC', $modelClass, $stub);

        return $stub;
    }

    /**
     * Replace the table name of the given stub
     *
     * @param string $stub
     * @param string $model
     * @return string
     */
    protected function replaceTableName($stub, $model)
    {
        $tableName = (new $model)->getTable();

        $stub = str_replace('TableName', $tableName, $stub);

        return $stub;
    }

    /**
     * Get the model property
     *
     * @return string
     */
    protected function getModel()
    {
        return str_replace('/', '\\', ($this->rootNamespace() . $this->model));
    }

    /**
     * Get the model property without the namespace
     *
     * @return string
     */
    protected function getModelClass()
    {
        $model = explode('\\', $this->getModel());

        return end($model);
    }

    /**
     * Get the destination class path.
     *
     * @param  string $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = $this->getNameInput();
        return base_path() . '/app/Repositories/' . str_replace('\\', '/', $name) . '.php';
    }
}
