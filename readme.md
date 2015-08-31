# php -> 5.5.9
# composer


$ php -v
$ php -m

2 php :
    - php ligne de commande
    - php pour apache

$ ls -al /usr/bin | grep php


# // changer le PATH du php :
.bash_history -> export PATH="/Applications/MAMP/bin/php/php5.6.10/bin:$PATH"
                        PATH=/Applications/MAMP/bin/php/php5.6.10/bin:$PATH


# // Installer 'composer' en ligne de commande (sur le site), puis :
    $ mv composer.phar /usr/bin/composer

Applications    =>
framework       => Vendors

# ////////////////////////////////////////////////// INSTALL avec composer //////////////////////////////////////////////////
    1) cd folder/
    2) $ composer create-project laravel/laravel student
    3) token (hidden) : suivre le liens

Allumer le serveur :
#    $ php artisan serve

# ////////////////////////////////////////////////// Mecanisme MVC //////////////////////////////////////////////////
Routing -> controllers (actions)    ->  Classes      -> html - moteur de template (blade)
----------- controller ------------ | -- modeles -- | --------------- views -------------

- ORM (object relation modele) -> 'Eloquant' (comme doctrine chez Symfony)
- 1 table -> 1 objet (entity)


# ////////////////////////////////////////////////// ROUTINGS //////////////////////////////////////////////////
app -> Http -> routes.php

    Route::get('/student/{id}', function ($id) {
        return "Hello $id";
    });


# ////////////////////////////////////////////////// CONTROLLER //////////////////////////////////////////////////
$ php artisan help make:controller
$ php artisan make:controller
$ php artisan make:controller StudentController --plain         -> creer un nouveau controller

connecter une route sur notre controler :
    - fichier controller :
      public function showStudent($id) {
          return "Hello $id";
      }

    - fichier route :
    Route::get('/student/{id}', 'StudentController@showStudent');


# ////////////////////////////////////////////////// VUE (TEMPLATE) //////////////////////////////////////////////////
ressources/views/student.blade.php
- {{$id}}



# ////////////////////////////////////////////////// MODELES //////////////////////////////////////////////////

# ////////// creer 1 bdd : //////////

1) creer une bdd en ligne de commande :
    - $ mysql -u root -p                (mdp: root)
    - $ create database nom_base;

--- OU ---

1) creer une bdd via 'install.sh' (a placer a la racine) :

$ sudo chmod +x install.sh
$ ./install.sh
$ sh install.sh


# ////////// creer 1 table : //////////

    |   connection bdd + affichage :
#   |   $ mysql --user=pierre --password=pierre
#   |   $ show databases;
#   |   $ use name_bdd;
#   |   $ show create table students;


- dans fichier '.env' :
    DB_DATABASE=ecole
    DB_USERNAME=pierre
    DB_PASSWORD=pierre

- dans fichier 'config/database.php' on modifira les configs

# migrate (table)
$ php artisan migrate       (test pour voir si bien connecter a la bdd)

creer un fichier de migration (sans executer (commiter))
// $ php artisan list
   $ php artisan make:migration create_students_table --create=students        // creation d'un fichier dans 'database/migration/2015_08_31....'


Dans '2015_08_31.... .php' :
    - remplir les champs (username, mail...)
    - $ php artisan migrate


# ///// creer 1 entity (class) /////
    va faire toutes les requettes vers la table 'students'
    - creer un modele :
        $ php artisan make:model Student            // 'Student' meme nom que la table mais sans 's'
            -> fichier 'Student.php' generer dans App/


# CREER DES CHAMPS DANS NOYRE TABLE - VIA TINKER (editer du php en ligne de commande) :
    - $ php artisan tinker
    - $ App\Student::all();
    - dans 'Student.php' :
        protected $fillable = [
            'username',
            'mail',
        ];
    - $ App\Student::create(['username' => 'xxx', 'mail' => 'xxx@gmail.com']);
    - $ App\Student::create(['username' => 'yyy', 'mail' => 'yyy@gmail.com']);
    - $ App\Student::create(['username' => 'xxx', 'mail' => 'xxx@gmail.com', 'age' => 22]);

    - $ App\Student::all();         // affiche tous


# CREER DES CHAMPS DANS NOYRE TABLE - VIA CONTROLLER :
    public function show() {
        return Student::all();
    }


# /////////////// RECAP : ///////////////
- $ php artisan make:migration create_tags_table --create=tags                          // creation de la table + fichier '2015_08_31.... .php'
- Dans '2015_08_31.... .php' : remplir les champs (username, mail...)                   // on defini les colonnes de notre table
- $ php artisan migrate                                                                 // envoyer les colonnes de notre table
- $ php artisan make:model Tag              (sans 's')                                  // creation d'un entity (ajouer $fillable dedans)
- creer des champs dans notre table (tinker)                                            // on ajoute des champs dans notre table
    -> $ php artisan tinker
    -> $ App\Tag::create(['tag1' => 'a', 'tag2' => 'b']);








