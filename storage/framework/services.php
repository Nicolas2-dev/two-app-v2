<?php

return array (
  'providers' => 
  array (
    0 => 'Two\\Auth\\AuthServiceProvider',
    1 => 'Two\\Bus\\BusServiceProvider',
    2 => 'Two\\Broadcasting\\BroadcastServiceProvider',
    3 => 'Two\\Cache\\CacheServiceProvider',
    4 => 'Two\\Routing\\RoutingServiceProvider',
    5 => 'Two\\Cookie\\CookieServiceProvider',
    6 => 'Two\\Database\\DatabaseServiceProvider',
    7 => 'Two\\Encryption\\EncryptionServiceProvider',
    8 => 'Two\\Filesystem\\FilesystemServiceProvider',
    9 => 'Two\\Localization\\LocalizationServiceProvider',
    10 => 'Two\\Hashing\\HashServiceProvider',
    11 => 'Two\\Mail\\MailServiceProvider',
    12 => 'Two\\Notifications\\NotificationServiceProvider',
    13 => 'Two\\Packages\\PackageServiceProvider',
    14 => 'Two\\Pagination\\PaginationServiceProvider',
    15 => 'Two\\Queue\\QueueServiceProvider',
    16 => 'Two\\Redis\\RedisServiceProvider',
    17 => 'Two\\Session\\SessionServiceProvider',
    18 => 'Two\\Validation\\ValidationServiceProvider',
    19 => 'Two\\View\\ViewServiceProvider',
    20 => 'Two\\Console\\Forge\\Cache\\ConsoleServiceProvider',
    21 => 'Two\\Console\\TwoConsoleServiceProvider',
    22 => 'Two\\Console\\ForgeServiceProvider',
    23 => 'Two\\Console\\Forge\\Database\\MigrationServiceProvider',
    24 => 'Two\\Console\\Forge\\Database\\SeedingServiceProvider',
    25 => 'Two\\Console\\Forge\\Localization\\ConsoleServiceProvider',
    26 => 'Two\\Console\\Forge\\Notifications\\ConsoleServiceProvider',
    27 => 'Two\\Console\\Forge\\Packages\\ConsoleServiceProvider',
    28 => 'Two\\Console\\Forge\\Routing\\ConsoleServiceProvider',
    29 => 'Two\\Console\\Forge\\Session\\ConsoleServiceProvider',
    30 => 'App\\Providers\\AppServiceProvider',
    31 => 'App\\Providers\\AuthServiceProvider',
    32 => 'App\\Providers\\EventServiceProvider',
    33 => 'App\\Providers\\RouteServiceProvider',
    34 => 'App\\Providers\\BroadcastServiceProvider',
  ),
  'eager' => 
  array (
    0 => 'Two\\Auth\\AuthServiceProvider',
    1 => 'Two\\Broadcasting\\BroadcastServiceProvider',
    2 => 'Two\\Routing\\RoutingServiceProvider',
    3 => 'Two\\Cookie\\CookieServiceProvider',
    4 => 'Two\\Database\\DatabaseServiceProvider',
    5 => 'Two\\Encryption\\EncryptionServiceProvider',
    6 => 'Two\\Filesystem\\FilesystemServiceProvider',
    7 => 'Two\\Packages\\PackageServiceProvider',
    8 => 'Two\\Pagination\\PaginationServiceProvider',
    9 => 'Two\\Session\\SessionServiceProvider',
    10 => 'Two\\Console\\Forge\\Packages\\ConsoleServiceProvider',
    11 => 'App\\Providers\\AppServiceProvider',
    12 => 'App\\Providers\\AuthServiceProvider',
    13 => 'App\\Providers\\EventServiceProvider',
    14 => 'App\\Providers\\RouteServiceProvider',
    15 => 'App\\Providers\\BroadcastServiceProvider',
  ),
  'deferred' => 
  array (
    'Two\\Bus\\Dispatcher' => 'Two\\Bus\\BusServiceProvider',
    'Two\\Bus\\Contracts\\DispatcherInterface' => 'Two\\Bus\\BusServiceProvider',
    'Two\\Bus\\Contracts\\QueueingDispatcherInterface' => 'Two\\Bus\\BusServiceProvider',
    'cache' => 'Two\\Cache\\CacheServiceProvider',
    'cache.store' => 'Two\\Cache\\CacheServiceProvider',
    'memcached.connector' => 'Two\\Cache\\CacheServiceProvider',
    'language' => 'Two\\Localization\\LocalizationServiceProvider',
    'hash' => 'Two\\Hashing\\HashServiceProvider',
    'mailer' => 'Two\\Mail\\MailServiceProvider',
    'swift.mailer' => 'Two\\Mail\\MailServiceProvider',
    'swift.transport' => 'Two\\Mail\\MailServiceProvider',
    'notifications' => 'Two\\Notifications\\NotificationServiceProvider',
    'queue' => 'Two\\Queue\\QueueServiceProvider',
    'queue.worker' => 'Two\\Queue\\QueueServiceProvider',
    'queue.listener' => 'Two\\Queue\\QueueServiceProvider',
    'queue.failer' => 'Two\\Queue\\QueueServiceProvider',
    'command.queue.work' => 'Two\\Queue\\QueueServiceProvider',
    'command.queue.listen' => 'Two\\Queue\\QueueServiceProvider',
    'command.queue.restart' => 'Two\\Queue\\QueueServiceProvider',
    'command.queue.subscribe' => 'Two\\Queue\\QueueServiceProvider',
    'queue.connection' => 'Two\\Queue\\QueueServiceProvider',
    'redis' => 'Two\\Redis\\RedisServiceProvider',
    'validator' => 'Two\\Validation\\ValidationServiceProvider',
    'view' => 'Two\\View\\ViewServiceProvider',
    'view.finder' => 'Two\\View\\ViewServiceProvider',
    'view.engine.resolver' => 'Two\\View\\ViewServiceProvider',
    'template' => 'Two\\View\\ViewServiceProvider',
    'template.compiler' => 'Two\\View\\ViewServiceProvider',
    'markdown' => 'Two\\View\\ViewServiceProvider',
    'markdown.compiler' => 'Two\\View\\ViewServiceProvider',
    'section' => 'Two\\View\\ViewServiceProvider',
    'command.cache.clear' => 'Two\\Console\\Forge\\Cache\\ConsoleServiceProvider',
    'command.cache.forget' => 'Two\\Console\\Forge\\Cache\\ConsoleServiceProvider',
    'command.cache.table' => 'Two\\Console\\Forge\\Cache\\ConsoleServiceProvider',
    'composer' => 'Two\\Console\\TwoConsoleServiceProvider',
    'forge' => 'Two\\Console\\TwoConsoleServiceProvider',
    'command.asset.publish' => 'Two\\Console\\ForgeServiceProvider',
    'command.config.publish' => 'Two\\Console\\ForgeServiceProvider',
    'command.clear-compiled' => 'Two\\Console\\ForgeServiceProvider',
    'command.clear-log' => 'Two\\Console\\ForgeServiceProvider',
    'command.console.make' => 'Two\\Console\\ForgeServiceProvider',
    'command.down' => 'Two\\Console\\ForgeServiceProvider',
    'command.environment' => 'Two\\Console\\ForgeServiceProvider',
    'command.event.make' => 'Two\\Console\\ForgeServiceProvider',
    'command.job.make' => 'Two\\Console\\ForgeServiceProvider',
    'command.key.generate' => 'Two\\Console\\ForgeServiceProvider',
    'command.listener.make' => 'Two\\Console\\ForgeServiceProvider',
    'command.model.make' => 'Two\\Console\\ForgeServiceProvider',
    'command.optimize' => 'Two\\Console\\ForgeServiceProvider',
    'command.policy.make' => 'Two\\Console\\ForgeServiceProvider',
    'command.provider.make' => 'Two\\Console\\ForgeServiceProvider',
    'command.request.make' => 'Two\\Console\\ForgeServiceProvider',
    'command.serve' => 'Two\\Console\\ForgeServiceProvider',
    'command.shared.make' => 'Two\\Console\\ForgeServiceProvider',
    'command.assets-link' => 'Two\\Console\\ForgeServiceProvider',
    'command.up' => 'Two\\Console\\ForgeServiceProvider',
    'command.vendor.publish' => 'Two\\Console\\ForgeServiceProvider',
    'command.view.clear' => 'Two\\Console\\ForgeServiceProvider',
    'command.view.publish' => 'Two\\Console\\ForgeServiceProvider',
    'migrator' => 'Two\\Console\\Forge\\Database\\MigrationServiceProvider',
    'migration.repository' => 'Two\\Console\\Forge\\Database\\MigrationServiceProvider',
    'command.migrate' => 'Two\\Console\\Forge\\Database\\MigrationServiceProvider',
    'command.migrate.rollback' => 'Two\\Console\\Forge\\Database\\MigrationServiceProvider',
    'command.migrate.reset' => 'Two\\Console\\Forge\\Database\\MigrationServiceProvider',
    'command.migrate.refresh' => 'Two\\Console\\Forge\\Database\\MigrationServiceProvider',
    'command.migrate.install' => 'Two\\Console\\Forge\\Database\\MigrationServiceProvider',
    'migration.creator' => 'Two\\Console\\Forge\\Database\\MigrationServiceProvider',
    'command.migrate.make' => 'Two\\Console\\Forge\\Database\\MigrationServiceProvider',
    'command.migrate.status' => 'Two\\Console\\Forge\\Database\\MigrationServiceProvider',
    'seeder' => 'Two\\Console\\Forge\\Database\\SeedingServiceProvider',
    'command.seed' => 'Two\\Console\\Forge\\Database\\SeedingServiceProvider',
    'command.seeder.make' => 'Two\\Console\\Forge\\Database\\SeedingServiceProvider',
    'command.languages.update' => 'Two\\Console\\Forge\\Localization\\ConsoleServiceProvider',
    'command.notification.table' => 'Two\\Console\\Forge\\Notifications\\ConsoleServiceProvider',
    'command.notification.make' => 'Two\\Console\\Forge\\Notifications\\ConsoleServiceProvider',
    'command.controller.make' => 'Two\\Console\\Forge\\Routing\\ConsoleServiceProvider',
    'command.middleware.make' => 'Two\\Console\\Forge\\Routing\\ConsoleServiceProvider',
    'command.route.list' => 'Two\\Console\\Forge\\Routing\\ConsoleServiceProvider',
    'command.session.database' => 'Two\\Console\\Forge\\Session\\ConsoleServiceProvider',
  ),
  'when' => 
  array (
    'Two\\Bus\\BusServiceProvider' => 
    array (
    ),
    'Two\\Cache\\CacheServiceProvider' => 
    array (
    ),
    'Two\\Localization\\LocalizationServiceProvider' => 
    array (
    ),
    'Two\\Hashing\\HashServiceProvider' => 
    array (
    ),
    'Two\\Mail\\MailServiceProvider' => 
    array (
    ),
    'Two\\Notifications\\NotificationServiceProvider' => 
    array (
    ),
    'Two\\Queue\\QueueServiceProvider' => 
    array (
    ),
    'Two\\Redis\\RedisServiceProvider' => 
    array (
    ),
    'Two\\Validation\\ValidationServiceProvider' => 
    array (
    ),
    'Two\\View\\ViewServiceProvider' => 
    array (
    ),
    'Two\\Console\\Forge\\Cache\\ConsoleServiceProvider' => 
    array (
    ),
    'Two\\Console\\TwoConsoleServiceProvider' => 
    array (
    ),
    'Two\\Console\\ForgeServiceProvider' => 
    array (
    ),
    'Two\\Console\\Forge\\Database\\MigrationServiceProvider' => 
    array (
    ),
    'Two\\Console\\Forge\\Database\\SeedingServiceProvider' => 
    array (
    ),
    'Two\\Console\\Forge\\Localization\\ConsoleServiceProvider' => 
    array (
    ),
    'Two\\Console\\Forge\\Notifications\\ConsoleServiceProvider' => 
    array (
    ),
    'Two\\Console\\Forge\\Routing\\ConsoleServiceProvider' => 
    array (
    ),
    'Two\\Console\\Forge\\Session\\ConsoleServiceProvider' => 
    array (
    ),
  ),
);
