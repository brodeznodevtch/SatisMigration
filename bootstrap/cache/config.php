<?php return  [
  'app' => 
   [
    'name' => 'Satis ERP',
    'owner' => 'DevTech S.A. de C.V.',
    'env' => 'local',
    'debug' => true,
    'url' => 'http://satis.test',
    'url_assistance' => 'http://satis.test',
    'timezone' => 'Asia/Kolkata',
    'locale' => 'es',
    'fallback_locale' => 'es',
    'key' => 'base64:wYWxS7/HkkpwIaT3bX6gBj1G7o1vbnmOO+uBIwJr6rw=',
    'cipher' => 'AES-256-CBC',
    'log' => 'daily',
    'log_level' => 'debug',
    'log_max_files' => 30,
    'providers' => 
     [
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Cookie\\CookieServiceProvider',
      6 => 'Illuminate\\Database\\DatabaseServiceProvider',
      7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      10 => 'Illuminate\\Hashing\\HashServiceProvider',
      11 => 'Illuminate\\Mail\\MailServiceProvider',
      12 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      13 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      14 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      15 => 'Illuminate\\Queue\\QueueServiceProvider',
      16 => 'Illuminate\\Redis\\RedisServiceProvider',
      17 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      18 => 'Illuminate\\Session\\SessionServiceProvider',
      19 => 'Illuminate\\Translation\\TranslationServiceProvider',
      20 => 'Illuminate\\Validation\\ValidationServiceProvider',
      21 => 'Illuminate\\View\\ViewServiceProvider',
      22 => 'Laravel\\Tinker\\TinkerServiceProvider',
      23 => 'App\\Providers\\AppServiceProvider',
      24 => 'App\\Providers\\AuthServiceProvider',
      25 => 'App\\Providers\\EventServiceProvider',
      26 => 'App\\Providers\\RouteServiceProvider',
      27 => 'Spatie\\Permission\\PermissionServiceProvider',
      28 => 'Collective\\Html\\HtmlServiceProvider',
      29 => 'Milon\\Barcode\\BarcodeServiceProvider',
      30 => 'App\\Providers\\DropboxServiceProvider',
      31 => 'Barryvdh\\DomPDF\\ServiceProvider',
      32 => 'App\\Providers\\PHPExcelMacroServiceProvider',
    ],
    'aliases' => 
     [
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Arr' => 'Illuminate\\Support\\Arr',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Redis' => 'Illuminate\\Support\\Facades\\Redis',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'Str' => 'Illuminate\\Support\\Str',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Form' => 'Collective\\Html\\FormFacade',
      'Html' => 'Collective\\Html\\HtmlFacade',
      'Carbon' => 'Carbon\\Carbon',
      'DNS1D' => 'Milon\\Barcode\\Facades\\DNS1DFacade',
      'DNS2D' => 'Milon\\Barcode\\Facades\\DNS2DFacade',
      'Datatables' => 'Yajra\\DataTables\\Facades\\DataTables',
      'PDF' => 'Barryvdh\\DomPDF\\Facade',
      'Excel' => 'Maatwebsite\\Excel\\Facades\\Excel',
    ],
    'business' => 'general',
    'price_precision' => '6',
    'clone_product' => true,
    'disable_sql_req_pk' => false,
    'app_version' => 11.22,
    'assistance_employee_url' => 'http://127.0.0.1:8000/api/image-assistance/',
  ],
  'auth' => 
   [
    'defaults' => 
     [
      'guard' => 'web',
      'passwords' => 'users',
    ],
    'guards' => 
     [
      'web' => 
       [
        'driver' => 'session',
        'provider' => 'users',
      ],
      'api' => 
       [
        'driver' => 'token',
        'provider' => 'users',
      ],
    ],
    'providers' => 
     [
      'users' => 
       [
        'driver' => 'eloquent',
        'model' => 'App\\Models\\User',
      ],
    ],
    'passwords' => 
     [
      'users' => 
       [
        'provider' => 'users',
        'table' => 'password_resets',
        'expire' => 60,
      ],
    ],
  ],
  'author' => 
   [
    'vendor' => 'Ultimate Fosters',
    'vendor_url' => 'http://ultimatefosters.com',
    'email' => 'thewebfosters@gmail.com',
    'app_version' => '2.11.4',
    'app_envato_personal_token' => 'ftXs1UtOgdtJFYo7ZcHHv46KH3PgLgch',
    'app_envato_username' => 'thewebfosters',
    'app_envato_product_code' => 21216332,
  ],
  'backup' => 
   [
    'backup' => 
     [
      'name' => 'UltimatePOS',
      'source' => 
       [
        'files' => 
         [
          'include' => 
           [
            0 => 'C:\\Users\\Bayron Rodezno\\OneDrive\\Documentos\\GitHub\\SatisMigration\\storage\\app/public',
          ],
          'exclude' => 
           [
            0 => 'C:\\Users\\Bayron Rodezno\\OneDrive\\Documentos\\GitHub\\SatisMigration\\vendor',
            1 => 'C:\\Users\\Bayron Rodezno\\OneDrive\\Documentos\\GitHub\\SatisMigration\\node_modules',
          ],
          'followLinks' => false,
        ],
        'databases' => 
         [
          0 => 'mysql',
        ],
      ],
      'gzip_database_dump' => false,
      'destination' => 
       [
        'filename_prefix' => '',
        'disks' => 
         [
          0 => 'local',
        ],
      ],
    ],
    'notifications' => 
     [
      'notifications' => 
       [
        'Spatie\\Backup\\Notifications\\Notifications\\BackupHasFailed' => 
         [
          0 => 'mail',
        ],
        'Spatie\\Backup\\Notifications\\Notifications\\UnhealthyBackupWasFound' => 
         [
          0 => 'mail',
        ],
        'Spatie\\Backup\\Notifications\\Notifications\\CleanupHasFailed' => 
         [
          0 => 'mail',
        ],
        'Spatie\\Backup\\Notifications\\Notifications\\BackupWasSuccessful' => 
         [
          0 => 'mail',
        ],
        'Spatie\\Backup\\Notifications\\Notifications\\HealthyBackupWasFound' => 
         [
          0 => 'mail',
        ],
        'Spatie\\Backup\\Notifications\\Notifications\\CleanupWasSuccessful' => 
         [
          0 => 'mail',
        ],
      ],
      'notifiable' => 'Spatie\\Backup\\Notifications\\Notifiable',
      'mail' => 
       [
        'to' => NULL,
      ],
      'slack' => 
       [
        'webhook_url' => '',
        'channel' => NULL,
        'username' => NULL,
        'icon' => NULL,
      ],
    ],
    'monitorBackups' => 
     [
      0 => 
       [
        'name' => 'Satis ERP',
        'disks' => 
         [
          0 => 'local',
        ],
        'newestBackupsShouldNotBeOlderThanDays' => 1,
        'storageUsedMayNotBeHigherThanMegabytes' => 5000,
      ],
    ],
    'cleanup' => 
     [
      'strategy' => 'Spatie\\Backup\\Tasks\\Cleanup\\Strategies\\DefaultStrategy',
      'defaultStrategy' => 
       [
        'keepAllBackupsForDays' => 7,
        'keepDailyBackupsForDays' => 16,
        'keepWeeklyBackupsForWeeks' => 8,
        'keepMonthlyBackupsForMonths' => 4,
        'keepYearlyBackupsForYears' => 2,
        'deleteOldestBackupsWhenUsingMoreMegabytesThan' => 5000,
      ],
    ],
  ],
  'barcode' => 
   [
    'store_path' => 'C:\\Users\\Bayron Rodezno\\OneDrive\\Documentos\\GitHub\\SatisMigration\\public\\/',
  ],
  'broadcasting' => 
   [
    'default' => 'log',
    'connections' => 
     [
      'pusher' => 
       [
        'driver' => 'pusher',
        'key' => '',
        'secret' => '',
        'app_id' => '',
        'options' => 
         [
          'cluster' => NULL,
          'encrypted' => true,
        ],
      ],
      'redis' => 
       [
        'driver' => 'redis',
        'connection' => 'default',
      ],
      'log' => 
       [
        'driver' => 'log',
      ],
      'null' => 
       [
        'driver' => 'null',
      ],
    ],
  ],
  'cache' => 
   [
    'default' => 'file',
    'stores' => 
     [
      'apc' => 
       [
        'driver' => 'apc',
      ],
      'array' => 
       [
        'driver' => 'array',
      ],
      'database' => 
       [
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
      ],
      'file' => 
       [
        'driver' => 'file',
        'path' => 'C:\\Users\\Bayron Rodezno\\OneDrive\\Documentos\\GitHub\\SatisMigration\\storage\\framework/cache/data',
      ],
      'memcached' => 
       [
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
         [
          0 => NULL,
          1 => NULL,
        ],
        'options' => 
         [
        ],
        'servers' => 
         [
          0 => 
           [
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ],
        ],
      ],
      'redis' => 
       [
        'driver' => 'redis',
        'connection' => 'cache',
      ],
      'dynamodb' => 
       [
        'driver' => 'dynamodb',
        'key' => NULL,
        'secret' => NULL,
        'region' => 'us-east-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ],
    ],
    'prefix' => 'satis_erp_cache',
  ],
  'charts' => 
   [
    'default' => 
     [
      'type' => 'line',
      'library' => 'material',
      'element_label' => 'Element',
      'empty_dataset_label' => 'No Data Set',
      'empty_dataset_value' => 0,
      'title' => 'My Cool Chart',
      'height' => 400,
      'width' => 0,
      'responsive' => false,
      'background_color' => 'inherit',
      'colors' => 
       [
      ],
      'one_color' => false,
      'template' => 'material',
      'legend' => true,
      'x_axis_title' => false,
      'y_axis_title' => NULL,
      'loader' => 
       [
        'active' => true,
        'duration' => 500,
        'color' => '#000000',
      ],
    ],
    'templates' => 
     [
      'material' => 
       [
        0 => '#2196F3',
        1 => '#F44336',
        2 => '#FFC107',
      ],
      'red-material' => 
       [
        0 => '#B71C1C',
        1 => '#F44336',
        2 => '#E57373',
      ],
      'indigo-material' => 
       [
        0 => '#1A237E',
        1 => '#3F51B5',
        2 => '#7986CB',
      ],
      'blue-material' => 
       [
        0 => '#0D47A1',
        1 => '#2196F3',
        2 => '#64B5F6',
      ],
      'teal-material' => 
       [
        0 => '#004D40',
        1 => '#009688',
        2 => '#4DB6AC',
      ],
      'green-material' => 
       [
        0 => '#1B5E20',
        1 => '#4CAF50',
        2 => '#81C784',
      ],
      'yellow-material' => 
       [
        0 => '#F57F17',
        1 => '#FFEB3B',
        2 => '#FFF176',
      ],
      'orange-material' => 
       [
        0 => '#E65100',
        1 => '#FF9800',
        2 => '#FFB74D',
      ],
    ],
    'assets' => 
     [
      'global' => 
       [
        'scripts' => 
         [
        ],
      ],
      'canvas-gauges' => 
       [
        'scripts' => 
         [
          0 => 'https://cdn.rawgit.com/Mikhus/canvas-gauges/gh-pages/download/2.1.2/all/gauge.min.js',
        ],
      ],
      'chartist' => 
       [
        'scripts' => 
         [
          0 => 'https://cdnjs.cloudflare.com/ajax/libs/chartist/0.10.1/chartist.min.js',
        ],
        'styles' => 
         [
          0 => 'https://cdnjs.cloudflare.com/ajax/libs/chartist/0.10.1/chartist.min.css',
        ],
      ],
      'chartjs' => 
       [
        'scripts' => 
         [
          0 => 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js',
        ],
      ],
      'fusioncharts' => 
       [
        'scripts' => 
         [
          0 => 'https://static.fusioncharts.com/code/latest/fusioncharts.js',
          1 => 'https://static.fusioncharts.com/code/latest/themes/fusioncharts.theme.fint.js',
        ],
      ],
      'google' => 
       [
        'scripts' => 
         [
          0 => 'https://www.google.com/jsapi',
          1 => 'https://www.gstatic.com/charts/loader.js',
          2 => 'google.charts.load(\'current\', {\'packages\':[\'corechart\', \'gauge\', \'geochart\', \'bar\', \'line\']})',
        ],
      ],
      'highcharts' => 
       [
        'styles' => 
         [
        ],
        'scripts' => 
         [
          0 => 'http://satis.test/plugins/chart/highchart/highcharts.js',
          1 => 'http://satis.test/plugins/chart/highchart/offline-exporting.js',
          2 => 'http://satis.test/plugins/chart/highchart/map.js',
          3 => 'http://satis.test/plugins/chart/highchart/data.js',
          4 => 'http://satis.test/plugins/chart/highchart/world.js',
        ],
      ],
      'justgage' => 
       [
        'scripts' => 
         [
          0 => 'https://cdnjs.cloudflare.com/ajax/libs/raphael/2.2.6/raphael.min.js',
          1 => 'https://cdnjs.cloudflare.com/ajax/libs/justgage/1.2.2/justgage.min.js',
        ],
      ],
      'morris' => 
       [
        'styles' => 
         [
          0 => 'https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css',
        ],
        'scripts' => 
         [
          0 => 'https://cdnjs.cloudflare.com/ajax/libs/raphael/2.2.6/raphael.min.js',
          1 => 'https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js',
        ],
      ],
      'plottablejs' => 
       [
        'scripts' => 
         [
          0 => 'https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js',
          1 => 'https://cdnjs.cloudflare.com/ajax/libs/plottable.js/2.8.0/plottable.min.js',
        ],
        'styles' => 
         [
          0 => 'https://cdnjs.cloudflare.com/ajax/libs/plottable.js/2.2.0/plottable.css',
        ],
      ],
      'progressbarjs' => 
       [
        'scripts' => 
         [
          0 => 'https://cdnjs.cloudflare.com/ajax/libs/progressbar.js/1.0.1/progressbar.min.js',
        ],
      ],
      'c3' => 
       [
        'scripts' => 
         [
          0 => 'https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js',
          1 => 'https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.js',
        ],
        'styles' => 
         [
          0 => 'https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.css',
        ],
      ],
      'echarts' => 
       [
        'scripts' => 
         [
          0 => 'https://cdnjs.cloudflare.com/ajax/libs/echarts/3.6.2/echarts.min.js',
        ],
      ],
      'amcharts' => 
       [
        'scripts' => 
         [
          0 => 'https://cdnjs.cloudflare.com/ajax/libs/amcharts/3.21.2/amcharts.js',
          1 => 'https://cdnjs.cloudflare.com/ajax/libs/amcharts/3.21.2/serial.js',
          2 => 'https://cdnjs.cloudflare.com/ajax/libs/amcharts/3.21.2/plugins/export/export.min.js',
          3 => 'https://cdnjs.cloudflare.com/ajax/libs/amcharts/3.21.2/themes/light.js',
        ],
        'styles' => 
         [
          0 => 'https://cdnjs.cloudflare.com/ajax/libs/amcharts/3.21.2/plugins/export/export.css',
        ],
      ],
    ],
  ],
  'constants' => 
   [
    'langs' => 
     [
      'en' => 
       [
        'full_name' => 'English',
        'short_name' => 'English',
      ],
      'es' => 
       [
        'full_name' => 'Spanish - Español',
        'short_name' => 'Spanish',
      ],
    ],
    'langs_rtl' => 
     [
      0 => 'ar',
    ],
    'document_size_limit' => '12000000',
    'asset_version' => 31,
    'disable_expiry' => false,
    'disable_purchase_in_other_currency' => true,
    'iraqi_selling_price_adjustment' => false,
    'currency_precision' => 2,
    'product_img_path' => 'img',
    'employee_img_path' => 'img/employee',
    'image_size_limit' => '500000',
    'enable_custom_payment_1' => true,
    'enable_custom_payment_2' => false,
    'enable_custom_payment_3' => false,
    'enable_sell_in_diff_currency' => false,
    'currency_exchange_rate' => 1,
  ],
  'database' => 
   [
    'default' => 'mysql',
    'connections' => 
     [
      'sqlite' => 
       [
        'driver' => 'sqlite',
        'url' => NULL,
        'database' => 'satis-erp-demo',
        'prefix' => '',
        'foreign_key_constraints' => true,
      ],
      'mysql' => 
       [
        'driver' => 'mysql',
        'url' => NULL,
        'host' => 'localhost',
        'port' => '3306',
        'database' => 'satis-erp-demo',
        'username' => 'root',
        'password' => 'Myrootpass2023',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
         [
        ],
      ],
      'pgsql' => 
       [
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => 'localhost',
        'port' => '3306',
        'database' => 'satis-erp-demo',
        'username' => 'root',
        'password' => 'Myrootpass2023',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'schema' => 'public',
        'sslmode' => 'prefer',
      ],
      'sqlsrv' => 
       [
        'driver' => 'sqlsrv',
        'url' => NULL,
        'host' => 'localhost',
        'port' => '3306',
        'database' => 'satis-erp-demo',
        'username' => 'root',
        'password' => 'Myrootpass2023',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ],
    ],
    'migrations' => 'migrations',
    'redis' => 
     [
      'client' => 'predis',
      'options' => 
       [
        'cluster' => 'predis',
        'prefix' => 'satis_erp_database_',
      ],
      'default' => 
       [
        'url' => NULL,
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => 0,
      ],
      'cache' => 
       [
        'url' => NULL,
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => 1,
      ],
    ],
  ],
  'datatables' => 
   [
    'search' => 
     [
      'smart' => true,
      'multi_term' => true,
      'case_insensitive' => true,
      'use_wildcards' => false,
    ],
    'index_column' => 'DT_Row_Index',
    'engines' => 
     [
      'eloquent' => 'Yajra\\DataTables\\EloquentDataTable',
      'query' => 'Yajra\\DataTables\\QueryDataTable',
      'collection' => 'Yajra\\DataTables\\CollectionDataTable',
    ],
    'builders' => 
     [
    ],
    'nulls_last_sql' => '%s %s NULLS LAST',
    'error' => NULL,
    'columns' => 
     [
      'excess' => 
       [
        0 => 'rn',
        1 => 'row_num',
      ],
      'escape' => '*',
      'raw' => 
       [
        0 => 'action',
      ],
      'blacklist' => 
       [
        0 => 'password',
        1 => 'remember_token',
      ],
      'whitelist' => '*',
    ],
    'json' => 
     [
      'header' => 
       [
      ],
      'options' => 0,
    ],
  ],
  'debugbar' => 
   [
    'enabled' => false,
    'except' => 
     [
    ],
    'storage' => 
     [
      'enabled' => true,
      'driver' => 'file',
      'path' => 'C:\\Users\\Bayron Rodezno\\OneDrive\\Documentos\\GitHub\\SatisMigration\\storage\\debugbar',
      'connection' => NULL,
      'provider' => '',
    ],
    'include_vendors' => true,
    'capture_ajax' => true,
    'add_ajax_timing' => false,
    'error_handler' => false,
    'clockwork' => false,
    'collectors' => 
     [
      'phpinfo' => true,
      'messages' => true,
      'time' => true,
      'memory' => true,
      'exceptions' => true,
      'log' => true,
      'db' => true,
      'views' => true,
      'route' => true,
      'auth' => true,
      'gate' => true,
      'session' => true,
      'symfony_request' => true,
      'mail' => true,
      'laravel' => false,
      'events' => false,
      'default_request' => false,
      'logs' => false,
      'files' => false,
      'config' => false,
      'cache' => false,
    ],
    'options' => 
     [
      'auth' => 
       [
        'show_name' => true,
      ],
      'db' => 
       [
        'with_params' => true,
        'backtrace' => true,
        'timeline' => false,
        'explain' => 
         [
          'enabled' => false,
          'types' => 
           [
            0 => 'SELECT',
          ],
        ],
        'hints' => true,
      ],
      'mail' => 
       [
        'full_log' => false,
      ],
      'views' => 
       [
        'data' => false,
      ],
      'route' => 
       [
        'label' => true,
      ],
      'logs' => 
       [
        'file' => NULL,
      ],
      'cache' => 
       [
        'values' => true,
      ],
    ],
    'inject' => true,
    'route_prefix' => '_debugbar',
    'route_domain' => NULL,
    'theme' => 'auto',
  ],
  'excel' => 
   [
    'exports' => 
     [
      'chunk_size' => 1000,
      'pre_calculate_formulas' => false,
      'strict_null_comparison' => false,
      'csv' => 
       [
        'delimiter' => ',',
        'enclosure' => '"',
        'line_ending' => '
',
        'use_bom' => false,
        'include_separator_line' => false,
        'excel_compatibility' => false,
      ],
      'properties' => 
       [
        'creator' => '',
        'lastModifiedBy' => '',
        'title' => '',
        'description' => '',
        'subject' => '',
        'keywords' => '',
        'category' => '',
        'manager' => '',
        'company' => '',
      ],
    ],
    'imports' => 
     [
      'read_only' => true,
      'ignore_empty' => false,
      'heading_row' => 
       [
        'formatter' => 'slug',
      ],
      'csv' => 
       [
        'delimiter' => ',',
        'enclosure' => '"',
        'escape_character' => '\\',
        'contiguous' => false,
        'input_encoding' => 'UTF-8',
      ],
      'properties' => 
       [
        'creator' => '',
        'lastModifiedBy' => '',
        'title' => '',
        'description' => '',
        'subject' => '',
        'keywords' => '',
        'category' => '',
        'manager' => '',
        'company' => '',
      ],
    ],
    'extension_detector' => 
     [
      'xlsx' => 'Xlsx',
      'xlsm' => 'Xlsx',
      'xltx' => 'Xlsx',
      'xltm' => 'Xlsx',
      'xls' => 'Xls',
      'xlt' => 'Xls',
      'ods' => 'Ods',
      'ots' => 'Ods',
      'slk' => 'Slk',
      'xml' => 'Xml',
      'gnumeric' => 'Gnumeric',
      'htm' => 'Html',
      'html' => 'Html',
      'csv' => 'Csv',
      'tsv' => 'Csv',
      'pdf' => 'Dompdf',
    ],
    'value_binder' => 
     [
      'default' => 'Maatwebsite\\Excel\\DefaultValueBinder',
    ],
    'transactions' => 
     [
      'handler' => 'db',
    ],
    'temporary_files' => 
     [
      'local_path' => 'C:\\Users\\Bayron Rodezno\\OneDrive\\Documentos\\GitHub\\SatisMigration\\storage\\framework/laravel-excel',
      'remote_disk' => NULL,
      'remote_prefix' => NULL,
      'force_resync_remote' => NULL,
    ],
    'cache' => 
     [
      'driver' => 'memory',
      'batch' => 
       [
        'memory_limit' => 60000,
      ],
      'illuminate' => 
       [
        'store' => NULL,
      ],
    ],
  ],
  'filesystems' => 
   [
    'default' => 'local',
    'cloud' => 's3',
    'disks' => 
     [
      'local' => 
       [
        'driver' => 'local',
        'root' => 'C:\\Users\\Bayron Rodezno\\OneDrive\\Documentos\\GitHub\\SatisMigration\\storage\\app',
      ],
      'public' => 
       [
        'driver' => 'local',
        'root' => 'C:\\Users\\Bayron Rodezno\\OneDrive\\Documentos\\GitHub\\SatisMigration\\storage\\app/public',
        'url' => 'http://satis.test/storage',
        'visibility' => 'public',
      ],
      's3' => 
       [
        'driver' => 's3',
        'key' => NULL,
        'secret' => NULL,
        'region' => NULL,
        'bucket' => NULL,
        'url' => NULL,
      ],
    ],
  ],
  'hashing' => 
   [
    'driver' => 'bcrypt',
    'bcrypt' => 
     [
      'rounds' => 10,
    ],
    'argon' => 
     [
      'memory' => 1024,
      'threads' => 2,
      'time' => 2,
    ],
  ],
  'logging' => 
   [
    'default' => 'stack',
    'channels' => 
     [
      'stack' => 
       [
        'driver' => 'stack',
        'channels' => 
         [
          0 => 'daily',
        ],
        'ignore_exceptions' => false,
      ],
      'single' => 
       [
        'driver' => 'single',
        'path' => 'C:\\Users\\Bayron Rodezno\\OneDrive\\Documentos\\GitHub\\SatisMigration\\storage\\logs/laravel.log',
        'level' => 'debug',
      ],
      'daily' => 
       [
        'driver' => 'daily',
        'path' => 'C:\\Users\\Bayron Rodezno\\OneDrive\\Documentos\\GitHub\\SatisMigration\\storage\\logs/laravel.log',
        'level' => 'debug',
        'days' => 14,
      ],
      'slack' => 
       [
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'critical',
      ],
      'papertrail' => 
       [
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' => 
         [
          'host' => NULL,
          'port' => NULL,
        ],
      ],
      'stderr' => 
       [
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'formatter' => NULL,
        'with' => 
         [
          'stream' => 'php://stderr',
        ],
      ],
      'syslog' => 
       [
        'driver' => 'syslog',
        'level' => 'debug',
      ],
      'errorlog' => 
       [
        'driver' => 'errorlog',
        'level' => 'debug',
      ],
    ],
  ],
  'mail' => 
   [
    'driver' => 'smtp',
    'host' => 'smtp.gmail.com',
    'port' => '587',
    'from' => 
     [
      'address' => 'devtch.envex@gmail.com',
      'name' => 'Satis ERP Notifications',
    ],
    'encryption' => 'tls',
    'username' => 'devtch.envex@gmail.com',
    'password' => 'd7uXR23jTiq75gy',
    'sendmail' => '/usr/sbin/sendmail -bs',
    'markdown' => 
     [
      'theme' => 'default',
      'paths' => 
       [
        0 => 'C:\\Users\\Bayron Rodezno\\OneDrive\\Documentos\\GitHub\\SatisMigration\\resources\\views/vendor/mail',
      ],
    ],
    'log_channel' => NULL,
  ],
  'modules' => 
   [
    'namespace' => 'Modules',
    'stubs' => 
     [
      'enabled' => false,
      'path' => 'C:\\Users\\Bayron Rodezno\\OneDrive\\Documentos\\GitHub\\SatisMigration/vendor/nwidart/laravel-modules/src/Commands/stubs',
      'files' => 
       [
        'start' => 'start.php',
        'routes' => 'Http/routes.php',
        'views/index' => 'Resources/views/index.blade.php',
        'views/master' => 'Resources/views/layouts/master.blade.php',
        'scaffold/config' => 'Config/config.php',
        'composer' => 'composer.json',
        'assets/js/app' => 'Resources/assets/js/app.js',
        'assets/sass/app' => 'Resources/assets/sass/app.scss',
        'webpack' => 'webpack.mix.js',
        'package' => 'package.json',
      ],
      'replacements' => 
       [
        'start' => 
         [
          0 => 'LOWER_NAME',
          1 => 'ROUTES_LOCATION',
        ],
        'routes' => 
         [
          0 => 'LOWER_NAME',
          1 => 'STUDLY_NAME',
          2 => 'MODULE_NAMESPACE',
        ],
        'webpack' => 
         [
          0 => 'LOWER_NAME',
        ],
        'json' => 
         [
          0 => 'LOWER_NAME',
          1 => 'STUDLY_NAME',
          2 => 'MODULE_NAMESPACE',
        ],
        'views/index' => 
         [
          0 => 'LOWER_NAME',
        ],
        'views/master' => 
         [
          0 => 'STUDLY_NAME',
          1 => 'LOWER_NAME',
        ],
        'scaffold/config' => 
         [
          0 => 'STUDLY_NAME',
        ],
        'composer' => 
         [
          0 => 'LOWER_NAME',
          1 => 'STUDLY_NAME',
          2 => 'VENDOR',
          3 => 'AUTHOR_NAME',
          4 => 'AUTHOR_EMAIL',
          5 => 'MODULE_NAMESPACE',
        ],
      ],
      'gitkeep' => true,
    ],
    'paths' => 
     [
      'modules' => 'C:\\Users\\Bayron Rodezno\\OneDrive\\Documentos\\GitHub\\SatisMigration\\Modules',
      'assets' => 'C:\\Users\\Bayron Rodezno\\OneDrive\\Documentos\\GitHub\\SatisMigration\\public\\modules',
      'migration' => 'C:\\Users\\Bayron Rodezno\\OneDrive\\Documentos\\GitHub\\SatisMigration\\database/migrations',
      'generator' => 
       [
        'config' => 
         [
          'path' => 'Config',
          'generate' => true,
        ],
        'command' => 
         [
          'path' => 'Console',
          'generate' => true,
        ],
        'migration' => 
         [
          'path' => 'Database/Migrations',
          'generate' => true,
        ],
        'seeder' => 
         [
          'path' => 'Database/Seeders',
          'generate' => true,
        ],
        'factory' => 
         [
          'path' => 'Database/factories',
          'generate' => true,
        ],
        'model' => 
         [
          'path' => 'Entities',
          'generate' => true,
        ],
        'controller' => 
         [
          'path' => 'Http/Controllers',
          'generate' => true,
        ],
        'filter' => 
         [
          'path' => 'Http/Middleware',
          'generate' => true,
        ],
        'request' => 
         [
          'path' => 'Http/Requests',
          'generate' => true,
        ],
        'provider' => 
         [
          'path' => 'Providers',
          'generate' => true,
        ],
        'assets' => 
         [
          'path' => 'Resources/assets',
          'generate' => true,
        ],
        'lang' => 
         [
          'path' => 'Resources/lang',
          'generate' => true,
        ],
        'views' => 
         [
          'path' => 'Resources/views',
          'generate' => true,
        ],
        'test' => 
         [
          'path' => 'Tests',
          'generate' => true,
        ],
        'repository' => 
         [
          'path' => 'Repositories',
          'generate' => false,
        ],
        'event' => 
         [
          'path' => 'Events',
          'generate' => false,
        ],
        'listener' => 
         [
          'path' => 'Listeners',
          'generate' => false,
        ],
        'policies' => 
         [
          'path' => 'Policies',
          'generate' => false,
        ],
        'rules' => 
         [
          'path' => 'Rules',
          'generate' => false,
        ],
        'jobs' => 
         [
          'path' => 'Jobs',
          'generate' => false,
        ],
        'emails' => 
         [
          'path' => 'Emails',
          'generate' => false,
        ],
        'notifications' => 
         [
          'path' => 'Notifications',
          'generate' => false,
        ],
        'resource' => 
         [
          'path' => 'Transformers',
          'generate' => false,
        ],
      ],
    ],
    'scan' => 
     [
      'enabled' => false,
      'paths' => 
       [
        0 => 'C:\\Users\\Bayron Rodezno\\OneDrive\\Documentos\\GitHub\\SatisMigration\\vendor/*/*',
      ],
    ],
    'composer' => 
     [
      'vendor' => 'twf',
      'author' => 
       [
        'name' => 'The Web Fosters',
        'email' => 'thewebfosters@gmail.com',
      ],
    ],
    'cache' => 
     [
      'enabled' => false,
      'key' => 'laravel-modules',
      'lifetime' => 60,
    ],
    'register' => 
     [
      'translations' => true,
      'files' => 'register',
    ],
  ],
  'paypal' => 
   [
    'mode' => 'sandbox',
    'sandbox' => 
     [
      'username' => '',
      'password' => '',
      'secret' => '',
      'certificate' => '',
      'app_id' => 'APP-80W284485P519543T',
    ],
    'live' => 
     [
      'username' => '',
      'password' => '',
      'secret' => '',
      'certificate' => '',
      'app_id' => '',
    ],
    'payment_action' => 'Sale',
    'currency' => 'USD',
    'billing_type' => 'MerchantInitiatedBilling',
    'notify_url' => '',
    'locale' => '',
    'validate_ssl' => false,
  ],
  'permission' => 
   [
    'models' => 
     [
      'permission' => 'Spatie\\Permission\\Models\\Permission',
      'role' => 'Spatie\\Permission\\Models\\Role',
    ],
    'table_names' => 
     [
      'roles' => 'roles',
      'permissions' => 'permissions',
      'model_has_permissions' => 'model_has_permissions',
      'model_has_roles' => 'model_has_roles',
      'role_has_permissions' => 'role_has_permissions',
    ],
    'column_names' => 
     [
      'model_morph_key' => 'model_id',
    ],
    'display_permission_in_exception' => false,
    'cache' => 
     [
      'expiration_time' => 
      DateInterval::__set_state([
         'y' => 0,
         'm' => 0,
         'd' => 0,
         'h' => 24,
         'i' => 0,
         's' => 0,
         'f' => 0.0,
         'weekday' => 0,
         'weekday_behavior' => 0,
         'first_last_day_of' => 0,
         'invert' => 0,
         'days' => false,
         'special_type' => 0,
         'special_amount' => 0,
         'have_weekday_relative' => 0,
         'have_special_relative' => 0,
      ]),
      'key' => 'spatie.permission.cache',
      'model_key' => 'name',
      'store' => 'default',
    ],
    'cache_expiration_time' => 1440,
  ],
  'pesapal' => 
   [
    'consumer_key' => '',
    'consumer_secret' => '',
    'currency' => 'KES',
    'ipn' => 'PesaPalController@pesaPalPaymentConfirmation',
    'live' => false,
    'callback_route' => 'subscription-confirm',
  ],
  'queue' => 
   [
    'default' => 'sync',
    'connections' => 
     [
      'sync' => 
       [
        'driver' => 'sync',
      ],
      'database' => 
       [
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
      ],
      'beanstalkd' => 
       [
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
      ],
      'sqs' => 
       [
        'driver' => 'sqs',
        'key' => NULL,
        'secret' => NULL,
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'your-queue-name',
        'region' => 'us-east-1',
      ],
      'redis' => 
       [
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
      ],
    ],
    'failed' => 
     [
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ],
  ],
  'services' => 
   [
    'mailgun' => 
     [
      'domain' => NULL,
      'secret' => NULL,
      'endpoint' => 'api.mailgun.net',
    ],
    'postmark' => 
     [
      'token' => NULL,
    ],
    'ses' => 
     [
      'key' => NULL,
      'secret' => NULL,
      'region' => 'us-east-1',
    ],
    'sparkpost' => 
     [
      'secret' => NULL,
    ],
  ],
  'session' => 
   [
    'driver' => 'file',
    'lifetime' => 120,
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => 'C:\\Users\\Bayron Rodezno\\OneDrive\\Documentos\\GitHub\\SatisMigration\\storage\\framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
     [
      0 => 2,
      1 => 100,
    ],
    'cookie' => 'satis_erp_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => false,
    'http_only' => true,
    'same_site' => NULL,
  ],
  'view' => 
   [
    'paths' => 
     [
      0 => 'C:\\Users\\Bayron Rodezno\\OneDrive\\Documentos\\GitHub\\SatisMigration\\resources\\views',
    ],
    'compiled' => 'C:\\Users\\Bayron Rodezno\\OneDrive\\Documentos\\GitHub\\SatisMigration\\storage\\framework\\views',
  ],
  'dompdf' => 
   [
    'show_warnings' => false,
    'orientation' => 'portrait',
    'defines' => 
     [
      'font_dir' => 'C:\\Users\\Bayron Rodezno\\OneDrive\\Documentos\\GitHub\\SatisMigration\\storage\\fonts/',
      'font_cache' => 'C:\\Users\\Bayron Rodezno\\OneDrive\\Documentos\\GitHub\\SatisMigration\\storage\\fonts/',
      'temp_dir' => 'C:\\Users\\BAYRON~1\\AppData\\Local\\Temp',
      'chroot' => 'C:\\Users\\Bayron Rodezno\\OneDrive\\Documentos\\GitHub\\SatisMigration',
      'enable_font_subsetting' => false,
      'pdf_backend' => 'CPDF',
      'default_media_type' => 'screen',
      'default_paper_size' => 'a4',
      'default_font' => 'serif',
      'dpi' => 96,
      'enable_php' => false,
      'enable_javascript' => true,
      'enable_remote' => true,
      'font_height_ratio' => 1.1,
      'enable_html5_parser' => false,
    ],
  ],
  'debug-server' => 
   [
    'host' => 'tcp://127.0.0.1:9912',
  ],
  'datatables-buttons' => 
   [
    'namespace' => 
     [
      'base' => 'DataTables',
      'model' => '',
    ],
    'pdf_generator' => 'snappy',
    'snappy' => 
     [
      'options' => 
       [
        'no-outline' => true,
        'margin-left' => '0',
        'margin-right' => '0',
        'margin-top' => '10mm',
        'margin-bottom' => '10mm',
      ],
      'orientation' => 'landscape',
    ],
    'parameters' => 
     [
      'dom' => 'Bfrtip',
      'order' => 
       [
        0 => 
         [
          0 => 0,
          1 => 'desc',
        ],
      ],
      'buttons' => 
       [
        0 => 'create',
        1 => 'export',
        2 => 'print',
        3 => 'reset',
        4 => 'reload',
      ],
    ],
    'generator' => 
     [
      'columns' => 'id,add your columns,created_at,updated_at',
      'buttons' => 'create,export,print,reset,reload',
      'dom' => 'Bfrtip',
    ],
  ],
  'datatables-html' => 
   [
    'namespace' => 'LaravelDataTables',
    'table' => 
     [
      'class' => 'table',
      'id' => 'dataTableBuilder',
    ],
    'callback' => 
     [
      0 => '$',
      1 => '$.',
      2 => 'function',
    ],
    'script' => 'datatables::script',
    'editor' => 'datatables::editor',
  ],
  'trustedproxy' => 
   [
    'proxies' => NULL,
    'headers' => 30,
  ],
  'tinker' => 
   [
    'commands' => 
     [
    ],
    'dont_alias' => 
     [
      0 => 'App\\Nova',
    ],
  ],
];
