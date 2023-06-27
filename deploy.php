<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config git
set('repository', 'git@github.com:rodezno7/Satis.git');
set('ssh_user', 'deployer');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts
host('devtech-proy-deploy')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '/var/www/satis-erp/html');

/** Override vendors task */
task('deploy:vendors', function () {
    cd('{{release_or_current_path}}');
    run('unzip vendor.zip');
    run('composer dump-autoload');
});

task('artisan:config:cache', function () {
    /** Copy .env file */
    cd('{{deploy_path}}');
    run('cp ../.env shared/');
    
    artisan('config:cache');
});

/** Migrations */
task('artisan:migrate', function () {
    cd('{{release_or_current_path}}');

    // desc('Migrating Optics tables');
    // $log = run('php artisan migrate --force --path=database/optics_migrations');
    // info($log);

    desc('Migrating RRHH tables');
    $log = run('php artisan migrate --force --path=database/rrhh');
    info($log);

    desc('Migrating');
    $log = run('php artisan migrate --force');
    info($log);
});

task('artisan:migrate:status', artisan('migrate:status', ['skipIfNoEnv', 'showOutput']));

/** Disabled artisan route:cache task */
task('artisan:route:cache')
    ->disable();

// Hooks
after('deploy:failed', 'deploy:unlock');