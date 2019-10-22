## Project presentation

The project is a POC made to showcase a new feature. We opted for the Test Driven Development methodology (TDD).

On our platform, we have tools to match photographers with the correct shoots.  
Many photographers want to define a complex intervention area.  
So we will launch an app that enables photographers to draw this intervention area on a map.

The app will do the matching between photographers and upcoming shoots asynchronously.

### Step 1: installing the app
We first need to set the project up on our machine.  
To proceed you will need to be comfortable with using git and composer.

You need PHP >= 7.2 to run the project.

```
git clone ...;
cd test101;
composer install
```
- To use your local environnemnt, launch the following command:
  ```
  php bin/console server:start
  ```
  The website is now accessible at the address http://127.0.0.1:8000/

### Step 2: Development environnement initialisation
You need to initialize the database and load development data:
```
./bin/console doctrine:schema:update --force
./bin/console doctrine:fixture:load
```
You also need to initialize the test database:
```
./bin/console doctrine:database:create --env=test
./bin/console doctrine:schema:update --force --env=test
```

- you can now launch unit tests:
    ```
    ./bin/phpunit --testdox tests/Unit
    ```
- And functionnal tests:
    ```
    ./bin/phpunit --testdox tests/Functional
    ```

### Step 3: Instructions
At each level, you need to implement the methods and pass the tests.  
A level will count as valid only if the tests are valid.  
Use best practices and pay attention to code quality (php-cs-fixer is inside the project).  

ps: you shall not modify tests or add a `class` inside the project unless **explicitly** asked to do so.

# Level 1
### Step 2
We need to load data stored inside a **csv** file.  
The file to import is `./data/interventions_area.csv`.

You need to create a command that will be launched as follow:
```
./bin/console meero:area:import data/interventions_area.csv
```
This command will need to save the data to the project's database.

- Test file:
    - `Meero\Tests\Functional\Command\CmdImportTest`
- Relevant files:
    - `Meero\Command\ImportAreaCommand`
