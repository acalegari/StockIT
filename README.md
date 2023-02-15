# StockIT

    Model:

    ->public
        ->assets
            ->css _contains all css used for the different page login, register, home=gallery view, equipement view_
            ->img _check if contains all images uploaded for equipements_ //TODO
            ->js _contains all js files used for modal and client interaction for gallery and equipement view + search bar_ //TODO
    ->src
        ->Controller
            ->EquipementController
            ->HomeController
            ->LoginController
            ->RegistrationController
            ->SecurityController
            ->UserController
        ->DataFixtures
            ->AppFixtures
            ->EquipementsFixtures
        ->Entity
            ->Categories
            ->Equipements
            ->User
        ->Form
            ->RegistrationFormType
            ->UserType
        ->Repository
            ->CategoriesRepository
            ->EquipementsRepository
            ->UserRepository
        ->Security
            ->LoginAuthenticator
        Kernel
    ->templates
        ->equipement
            ->index.html.twig _path has been removed, only user logged can access by clicking on selected product_
        ->home
            ->index.html.twig _path has been removed, only user logged can be access -> redirect after login_
                //Adding information: if user_role = admin connected, 3 buttons are accessible to edit, add and removed select equipement
        ->login
            ->index.html.twig (/login)
        ->registration
            ->register.html.twig (/register)
            //can add a new user -> user_role = user
        ->security
            ->login.html.twig
        ->user
            //not used
        base.html.twig (contains block for: header / footer / modal)

## PREREQUISITE
>PHP version 8.1.0
>Install Wamp server version
>phpMyAdmin Version 5.2

## INSTALLATION
### Install symfony
>add cmd

### Install Doctrine

### Install Composer

## SETUP
### ENV FILE 
#### Update file .env by adding correct information of the DATABASE_URL 'line 27';
>DatabaseName = StockIT

### DATABASE
#### If no changes of the databaseName, run directly the migration
>php bin/console doctrine:migrations:migrate
Otherwise,
1. generate a new migration file
>php bin/console make:migration
2. then, run mugration
>php bin/console doctrine:migrations:migrate

#### Insert data into database using fixtures
>php bin/console doctrine:fixtures:load

