This is managing time spent on projects.

A user can:

- Start counting working time in a project.
- Stop counting.
- Add a time log that he spent but did not start the counter.

This project assumes that:
- The user can work on more than one project at the time

Limitations:

- Tests are not added
- It wouldn't scale since all the calculations for time are made on display time, creating a column with the sum of the time logs would solve the problem.

To use the project:

- Must install PHP and Postgres
- create 2 files:

1. config/autoload/local.php to add the database details

```php
// /config/autoload/local.php
<?php
/**
 * Local Configuration Override
 *
 * This configuration override file is for overriding environment-specific and
 * security-sensitive configuration information. Copy this file without the
 * .dist extension at the end and populate values as needed.
 *
 * @NOTE: This file is ignored from Git by default with the .gitignore included
 * in ZendSkeletonApplication. This is a good practice, as it prevents sensitive
 * credentials from accidentally being committed into version control.
 */

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => 'Doctrine\DBAL\Driver\PDOPgSql\Driver',
                'params' => [
                    'host'     => 'localhost',
                    'port'     => '5432',
                    'user'     => 'user',
                    'password' => 'password',
                    'dbname'   => 'database',
                ]
            ]
        ]
    ],
];
```

2. bootstrap.php to use the CLI for Doctrine

```php
// /bootstrap.php

<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$modelsPath = __DIR__ . "/module/TimeLogger/config/mappings";
$config = Setup::createYAMLMetadataConfiguration([$modelsPath], $isDevMode);

// database configuration parameters
$conn = array(
    'driverClass' => 'Doctrine\DBAL\Driver\PDOPgSql\Driver',
    'params' => [
                    ''host'     => 'localhost',
                    'port'     => '5432',
                    'user'     => 'user',
                    'password' => 'password',
                    'dbname'   => 'database',
                ]
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);
```

To run the application:

you need to create the database:
vendor/bin/doctrine-module orm:schema-tool:create

and then run apache and voila


