<?php

namespace pxgamer\U232ToUnit3d\Commands;

use App\Torrent;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use pxgamer\U232ToUnit3d\Functionality\Imports;

/**
 * Class FromU232.
 */
class FromU232 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unit3d:from-u232
                            {--driver=mysql : The driver type to use (mysql, sqlsrv, etc.).}
                            {--host=localhost : The hostname or IP.}
                            {--database= : The database to select from.}
                            {--username= : The database user.}
                            {--password= : The database password.}
                            {--prefix= : The database hostname or IP.}
                            {--ignore-users : Ignore the users table when importing.}
                            {--ignore-torrents : Ignore the torrents table when importing.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from an U-232 instance to UNIT3D.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     *
     * @throws \ErrorException
     */
    public function handle()
    {
        $this->checkRequired($this->options());

        config([
            'database.connections.imports' => [
                'driver'    => $this->option('driver'),
                'host'      => $this->option('host'),
                'database'  => $this->option('database'),
                'username'  => $this->option('username'),
                'password'  => $this->option('password'),
                'prefix'    => $this->option('prefix'),
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
            ],
        ]);

        $database = DB::connection('imports');

        if (!$this->option('ignore-users')) {
            Imports::importTable($database, 'User', 'users', User::class);
        } else {
            $this->output->note('Ignoring users table.');
        }

        if (!$this->option('ignore-torrents')) {
            Imports::importTable($database, 'Torrent', 'torrents', Torrent::class);
        } else {
            $this->output->note('Ignoring torrents table.');
        }
    }

    /**
     * @param array $options
     */
    public function checkRequired(array $options)
    {
        $requiredOptions = [
            'database',
            'username',
            'password',
        ];

        foreach ($requiredOptions as $option) {
            if (!key_exists($option, $options) || !$options[$option]) {
                throw new \InvalidArgumentException('Option `'.$option.'` not provided.');
            }
        }
    }
}
