<?php

namespace Config;

use CodeIgniter\Database\Config;

/**
 * Database Configuration
 */
class Database extends Config
{
    /**
     * The directory that holds the Migrations
     * and Seeds directories.
     *
     * @var string
     */
    public $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    /**
     * Lets you choose which connection group to
     * use if no other is specified.
     *
     * @var string
     */
    public $defaultGroup = 'default';

    /**
     * The default database connection.
     *
     * @var array
     */
    public $default = [
        'DSN'      => '',
        'hostname' => 'localhost',
        'username' => 'postgres',
        'password' => 'Imalia123',
        'database' => 'pkl63_wilayah',
        'DBDriver' => 'Postgre',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => (ENVIRONMENT !== 'production'),
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 5432,
    ];

    public $pkl63 = [
        'DSN'      => '',
        'hostname' => 'localhost',
        'username' => 'postgres',
        'password' => '12345',
        'database' => 'pkl63',
        'DBDriver' => 'Postgre',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => (ENVIRONMENT !== 'production'),
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 5432,
    ];

    // public $sikoko = [
    //     'DSN'      => '',
    //     'hostname' => 'localhost',
    //     'username' => 'root',
    //     'password' => '',
    //     'database' => 'pkl62_sikoko',
    //     'DBDriver' => 'MySQLi',
    //     'DBPrefix' => '',
    //     'pConnect' => false,
    //     'DBDebug'  => (ENVIRONMENT !== 'production'),
    //     'charset'  => 'utf8',
    //     'DBCollat' => 'utf8_general_ci',
    //     'swapPre'  => '',
    //     'encrypt'  => false,
    //     'compress' => false,
    //     'strictOn' => false,
    //     'failover' => [],
    //     'port'     => 3306,
    // ];

    // public $lokasi = [
    //     'DSN'      => '',
    //     'hostname' => 'localhost',
    //     'username' => 'root',
    //     'password' => '',
    //     'database' => 'pkl62_monitoring',
    //     'DBDriver' => 'MySQLi',
    //     'DBPrefix' => '',
    //     'pConnect' => false,
    //     'DBDebug'  => (ENVIRONMENT !== 'production'),
    //     'charset'  => 'utf8',
    //     'DBCollat' => 'utf8_general_ci',
    //     'swapPre'  => '',
    //     'encrypt'  => false,
    //     'compress' => false,
    //     'strictOn' => false,
    //     'failover' => [],
    //     'port'     => 3306,
    // ];

    // public $ws = [
    //     'DSN'      => '',
    //     'hostname' => 'localhost',
    //     'username' => 'root',
    //     'password' => '',
    //     'database' => 'pkl62_ws',
    //     'DBDriver' => 'MySQLi',
    //     'DBPrefix' => '',
    //     'pConnect' => false,
    //     'DBDebug'  => (ENVIRONMENT !== 'production'),
    //     'charset'  => 'utf8',
    //     'DBCollat' => 'utf8_general_ci',
    //     'swapPre'  => '',
    //     'encrypt'  => false,
    //     'compress' => false,
    //     'strictOn' => false,
    //     'failover' => [],
    //     'port'     => 3306,
    // ];

    public $wilayah = [
        'DSN'      => '',
        'hostname' => 'localhost',
        'username' => 'postgres',
        'password' => 'Imalia123',
        'database' => 'pkl63_wilayah',
        'DBDriver' => 'Postgre',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => (ENVIRONMENT !== 'production'),
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 5432,
    ];

    // public $wilayahR1 = [
    //     'DSN'      => '',
    //     'hostname' => 'localhost',
    //     'username' => 'root',
    //     'password' => '',
    //     'database' => 'pkl62_wilayah_riset1',
    //     'DBDriver' => 'MySQLi',
    //     'DBPrefix' => '',
    //     'pConnect' => false,
    //     'DBDebug'  => (ENVIRONMENT !== 'production'),
    //     'charset'  => 'utf8',
    //     'DBCollat' => 'utf8_general_ci',
    //     'swapPre'  => '',
    //     'encrypt'  => false,
    //     'compress' => false,
    //     'strictOn' => false,
    //     'failover' => [],
    //     'port'     => 3306,
    // ];

    // public $wilayahR2 = [
    //     'DSN'      => '',
    //     'hostname' => 'localhost',
    //     'username' => 'root',
    //     'password' => '',
    //     'database' => 'pkl62_wilayah_riset2',
    //     'DBDriver' => 'MySQLi',
    //     'DBPrefix' => '',
    //     'pConnect' => false,
    //     'DBDebug'  => (ENVIRONMENT !== 'production'),
    //     'charset'  => 'utf8',
    //     'DBCollat' => 'utf8_general_ci',
    //     'swapPre'  => '',
    //     'encrypt'  => false,
    //     'compress' => false,
    //     'strictOn' => false,
    //     'failover' => [],
    //     'port'     => 3306,
    // ];

    // public $wilayahR3 = [
    //     'DSN'      => '',
    //     'hostname' => 'localhost',
    //     'username' => 'root',
    //     'password' => '',
    //     'database' => 'pkl62_wilayah_riset3',
    //     'DBDriver' => 'MySQLi',
    //     'DBPrefix' => '',
    //     'pConnect' => false,
    //     'DBDebug'  => (ENVIRONMENT !== 'production'),
    //     'charset'  => 'utf8',
    //     'DBCollat' => 'utf8_general_ci',
    //     'swapPre'  => '',
    //     'encrypt'  => false,
    //     'compress' => false,
    //     'strictOn' => false,
    //     'failover' => [],
    //     'port'     => 3306,
    // ];

    // public $wilayahR4 = [
    //     'DSN'      => '',
    //     'hostname' => 'localhost',
    //     'username' => 'root',
    //     'password' => '',
    //     'database' => 'pkl62_wilayah_riset4',
    //     'DBDriver' => 'MySQLi',
    //     'DBPrefix' => '',
    //     'pConnect' => false,
    //     'DBDebug'  => (ENVIRONMENT !== 'production'),
    //     'charset'  => 'utf8',
    //     'DBCollat' => 'utf8_general_ci',
    //     'swapPre'  => '',
    //     'encrypt'  => false,
    //     'compress' => false,
    //     'strictOn' => false,
    //     'failover' => [],
    //     'port'     => 3306,
    // ];

	// public $wilayahR12 = [
    //     'DSN'      => '',
    //     'hostname' => 'localhost',
    //     'username' => 'root',
    //     'password' => '',
    //     'database' => 'pkl62_wilayah_riset12',
    //     'DBDriver' => 'MySQLi',
    //     'DBPrefix' => '',
    //     'pConnect' => false,
    //     'DBDebug'  => (ENVIRONMENT !== 'production'),
    //     'charset'  => 'utf8',
    //     'DBCollat' => 'utf8_general_ci',
    //     'swapPre'  => '',
    //     'encrypt'  => false,
    //     'compress' => false,
    //     'strictOn' => false,
    //     'failover' => [],
    //     'port'     => 3306,
    // ];

    // public $wilayahSby = [
    //     'DSN'      => '',
    //     'hostname' => 'localhost',
    //     'username' => 'root',
    //     'password' => '',
    //     'database' => 'pkl62_wilayah_surabaya_riset1',
    //     'DBDriver' => 'MySQLi',
    //     'DBPrefix' => '',
    //     'pConnect' => false,
    //     'DBDebug'  => (ENVIRONMENT !== 'production'),
    //     'charset'  => 'utf8',
    //     'DBCollat' => 'utf8_general_ci',
    //     'swapPre'  => '',
    //     'encrypt'  => false,
    //     'compress' => false,
    //     'strictOn' => false,
    //     'failover' => [],
    //     'port'     => 3306,
    // ];

    // public $post = [
    //     'DSN'      => '',
    //     'hostname' => 'localhost',
    //     'username' => 'root',
    //     'password' => '',
    //     'database' => 'pkl62',
    //     'DBDriver' => 'MySQLi',
    //     'DBPrefix' => '',
    //     'pConnect' => false,
    //     'DBDebug'  => (ENVIRONMENT !== 'production'),
    //     'charset'  => 'utf8',
    //     'DBCollat' => 'utf8_general_ci',
    //     'swapPre'  => '',
    //     'encrypt'  => false,
    //     'compress' => false,
    //     'strictOn' => false,
    //     'failover' => [],
    //     'port'     => 3306,
    // ];

    // /**
    //  * This database connection is used when
    //  * running PHPUnit database tests.
    //  *
    //  * @var array
    //  */
    // public $tests = [
    //     'DSN'      => '',
    //     'hostname' => 'localhost',
    //     'username' => 'root',
    //     'password' => '',
    //     'database' => ':memory:',
    //     'DBDriver' => 'SQLite3',
    //     'DBPrefix' => 'db_',  // Needed to ensure we're working correctly with prefixes live. DO NOT REMOVE FOR CI DEVS
    //     'pConnect' => false,
    //     'DBDebug'  => (ENVIRONMENT !== 'production'),
    //     'charset'  => 'utf8',
    //     'DBCollat' => 'utf8_general_ci',
    //     'swapPre'  => '',
    //     'encrypt'  => false,
    //     'compress' => false,
    //     'strictOn' => false,
    //     'failover' => [],
    //     'port'     => 3306,
    // ];

    public function __construct()
    {
        parent::__construct();

        // Ensure that we always set the database group to 'tests' if
        // we are currently running an automated test suite, so that
        // we don't overwrite live data on accident.
        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }
    }
}
