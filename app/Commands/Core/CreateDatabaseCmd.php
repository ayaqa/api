<?php

namespace AyaQA\Commands\Core;

use Illuminate\Console\Command;

class CreateDatabaseCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create all needed dbs.';

    public function handle()
    {
        $config = config('database');
        $defaultConnection = data_get($config, 'default');
        $defaultConnectionConfig = data_get($config, sprintf('connections.%s', $defaultConnection), []);

        if ($defaultConnectionConfig['driver'] !== 'sqlite') {
            throw new \RuntimeException(
                'Only SQLite is supported. Current driver for default connection is: %s'
            );
        }

        if (false === file_exists($defaultConnectionConfig['database'])) {
            file_put_contents($defaultConnectionConfig['database'], '');

            $this->info(sprintf('Database %s was created.', $defaultConnectionConfig['database']));
            return;
        }

        $this->info(sprintf('`%s` db already exists.', $defaultConnectionConfig['database']));
    }
}
