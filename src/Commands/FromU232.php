<?php

namespace pxgamer\U232ToUnit3d\Commands;

use ErrorException;
use App\Models\User;
use App\Models\Torrent;
use InvalidArgumentException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use pxgamer\U232ToUnit3d\Functionality\Imports;

class FromU232 extends Command
{
    /** {@inheritdoc} */
    protected $signature = 'unit3d:from-u232
                            {--driver=mysql : The driver type to use (mysql, sqlsrv, etc.)}
                            {--host=localhost : The hostname or IP}
                            {--database= : The database to select from}
                            {--username= : The database user}
                            {--password= : The database password}
                            {--prefix= : The database hostname or IP}
                            {--ignore-users : Ignore the users table when importing}
                            {--ignore-torrents : Ignore the torrents table when importing}';

    /** {@inheritdoc} */
    protected $description = 'Import data from an U-232 instance to UNIT3D';

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws ErrorException
     */
    public function handle(): void
    {
        $this->checkRequired($this->options());

        config([
            'database.connections.imports' => [
                'driver' => $this->option('driver'),
                'host' => $this->option('host'),
                'database' => $this->option('database'),
                'username' => $this->option('username'),
                'password' => $this->option('password'),
                'prefix' => $this->option('prefix'),
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
            ],
        ]);

        $database = DB::connection('imports');

        $this->importUsers($database);
        $this->importTorrents($database);
    }

    private function checkRequired(array $options): void
    {
        $requiredOptions = [
            'database',
            'username',
            'password',
        ];

        foreach ($requiredOptions as $option) {
            if (! array_key_exists($option, $options) || ! $options[$option]) {
                throw new InvalidArgumentException('Option `'.$option.'` not provided');
            }
        }
    }

    /**
     * @param  ConnectionInterface  $database
     *
     * @throws ErrorException
     */
    private function importUsers(ConnectionInterface $database): void
    {
        if ($this->option('ignore-users')) {
            $this->output->note('Ignoring users table');

            return;
        }

        Imports::importTable($database, 'User', 'users', User::class);
    }

    /**
     * @param  ConnectionInterface  $database
     *
     * @throws ErrorException
     */
    private function importTorrents(ConnectionInterface $database): void
    {
        if ($this->option('ignore-torrents')) {
            $this->output->note('Ignoring torrents table');

            return;
        }

        Imports::importTable($database, 'Torrent', 'torrents', Torrent::class);
    }
}
