# **Rep-O-Matic**

---

Create Laravel repositories easily!

# **Table of Contents**

- [Installation](#installation)
- [Basic usage](#basic-usage)
- [Options](#options)
	- [--e](#exceptions)
	- [--m](#model)
	- [--m-fillable](#model-fillable)
	- [--m-hidden](#model-hidden)
	- [--r](#repository)
	- [--n](#migration)
	- [--n-types](#migration-types)
	- [--migrate](#migrate)
	- [--s](#seeder)
	- [--s-instances](#seeder-instances)
	- [--seed](#seed)
- [Usage examples](#usage-examples)
- [Contributing](#contributing)
- [License](#license)


## **Installation**

```sh
composer require alextigaer/rep-o-matic dev-master
```

## **Basic usage**

To create a new repository, just run the command:

```sh
php artisan repo:create RepoName
```

This will create:
- 4 exceptions for the repository: 'RepoNameNotFoundException', 'RepoNameNotCreatedException', 'RepoNameNotUpdatedException' and 'RepoNameNotDeletedException'
- The model file 'RepoName.php' inside the 'Models' directory
- The 'Repositories' directory with 2 directories inside: 'Contracts' and 'RepoName'. The 'Contracts' directory will contain all the repositories' contracts. The 'RepoName' directory will contain all the repositories for 'RepoName'. The command will also bind the contract to the repository's file
- The migration 'create_reponames_table'
- The 'RepoNamesSeeder'. The command will also update the 'DatabaseSeeder' file, adding the line to call 'RepoNamesSeeder'

Execute the command "composer dump-autoload" after an execution to include the new classes into the project

```sh
// You can run the command as following
php artisan repo:create RepoName && composer dump-autoload
```

## **Options**

If you want, you can use these options to customize the creation:

### --e (default=y) <a name="exceptions"></a>

This option allows to choose if the exceptions should be created. The default value is set to 'y'. Other values are not considered

Description:
```sh
{--e=y : Choose whether to create the exceptions, or not [y/n]}
```

Usage:
```sh
// Create the repo files excluding the exceptions
php artisan repo:create RepoName --e=n
```

### --m (default=y) <a name="model"></a>

This option allows to choose if the model should be created. The default value is set to 'y'. Other values are not considered

Description:
```sh
{--m=y : Choose whether to create the model, or not [y/n]}
```

Usage:
```sh
// Create the repo files excluding the model
php artisan repo:create RepoName --m=n
```

### --m-fillable <a name="model-fillable"></a>

The option '--m-fillable' allows to add mass-assignable attributes to the model (and to the migration and the seeder too)

Description:
```sh
{--m-fillable=* : The mass-assignable attributes of the model}
```

Usage:
```sh
// Create the repo files and set 2 model mass-assignable attributes: name and email
php artisan repo:create RepoName --m-fillable=name --m-fillable=email
```

### --m-hidden <a name="model-hidden"></a>

The option '--m-hidden' allows to add hidden attributes to the model (and to the migration and the seeder too)

Description:
```sh
{--m-hidden=* : The hidden attributes of the model}
```

Usage:
```sh
// Create the repo files and set 2 model hidden attributes: password and pin
php artisan repo:create RepoName --m-hidden=password --m-hidden=pin
```

### --r (default=y) <a name="repository"></a>

This option allows to choose if the repository should be created. The default value is set to 'y'. Other values are not considered

Description:
```sh
{--r=y : Choose whether to create the repository, or not [y/n]}
```

Usage:
```sh
// Create the repo files excluding the 'Repositories' folder and its content
php artisan repo:create RepoName --m=n
```

### --n (default=y) <a name="migration"></a>

This option allows to choose if the migration should be created. The default value is set to 'y'. Other values are not considered

Description:
```sh
{--n=y : Choose whether to create the migration, or not [y/n]}
```

Usage:
```sh
// Create the repo files excluding the migration
php artisan repo:create RepoName --n=n
```

### --n-types <a name="migration-types"></a>

The option '--n-types' allows to add the types to the migration columns. If not specified, the command will assign the type 'string' to all of the columns (if --m-fillable and/or --m-hidden are used)

Description:
```sh
{--n-types=* : The columns types of the attributes (check Laravel doc for acceptable values)}
```

Usage:
```sh
// Create the repo files and set: 1 mass-assignable attribute (name), 1 hidden attribute (pin) and set the types of these 2 columns as 'string' and 'integer', respectively
php artisan repo:create RepoName --m-fillable=name --m-hidden=pin --n-types=string --n-types=integer
```

### --migrate (default=n) <a name="migrate"></a>

This option allows to choose if the migrate command should be run. The default value is set to 'n'. Other values are not considered

Description:
```sh
{--migrate=n : Choose whether to run the command migrate, or not [y/n]}
```

Usage:
```sh
// Create the repo files and run the migration after its creation
php artisan repo:create RepoName --migrate=y
```

### --s (default=y) <a name="seeder"></a>

This option allows to choose if the seeder should be created. The default value is set to 'y'. Other values are not considered

Description:
```sh
{--s=y : Choose whether to create the seeder, or not [y/n]}
```

Usage:
```sh
// Create the repo files excluding the seeder
php artisan repo:create RepoName --s=n
```

### --s-instances <a name="seeder-instances"></a>

The option '--s-instances' allows to add some instances to the seeder. If not specified, the command will assign the value 'VALUE' to all of the columns (if --m-fillable and/or --m-hidden are used).
A default separator for the values, the character ',', is set. The syntax to add an instance is: '--s-instances="value_1,value2,...,value_n""'

Description:
```sh
{--s-instances=* : The values of the instances}
```

Usage:
```sh
// Create the repo files and set: 1 mass-assignable attribute (name), 1 hidden attribute (pin) and create 2 instances of 'RepoName'
php artisan repo:create RepoName --m-fillable=name --m-hidden=pin --s-instances="Alex,1234" --s-instances="Georgia,4321"
```

### --seed (default=n) <a name="seed"></a>

This option allows to choose if the seed command should be run. The default value is set to 'n'. Other values are not considered

Description:
```sh
{--seed=n : Choose whether to run the command db:seed, or not [y/n]}
```

Usage:
```sh
// Create the repo files and run the seeding procedure
php artisan repo:create RepoName --seed=y
```

## **Usage examples**

1) Create a repo called 'ExampleOne' with 3 mass-assignable attributes, 1 hidden attribute, column types set and without creating the seeder:
```sh
php artisan repo:create ExampleOne --m-fillable=attr_1 --m-fillable=attr_2 --m-fillable=attr_2 --m-hidden=hidden_1 --n-types=string --n-types=integer --n-types=bigInteger --n-types=geometry --s=n
```
2) Create a repo called 'ExampleTwo' without mass-assignable attributes, 1 hidden attribute, 2 instances and run the seeding:
```sh
php artisan repo:create ExampleTwo --m-hidden=hidden_1 --s-instances="passwordone" --s-instances="passwordtwo" --seed=y
```

## **Contributing**

Feel free to suggest anything! Use pulls or contact me :)

## **License**

Rep-O-Matic is licensed under the MIT license. Made with love, let's share it! :)
