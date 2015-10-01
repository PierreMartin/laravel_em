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
    1) $ cd folder/
    2) $ composer create-project laravel/laravel student
    3) token (hidden) : suivre le liens

Allumer le serveur :
#    $ php artisan serve
#    $ nohup php artisan serve --port=8888          // lance le serveur en tache de font

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
ressources/views/student/index.blade.php
ressources/views/student/single.blade.php


- {{$id}}


1) Dans le controller :
    public function show() {
        $students = Student::all();                             // lie l'entity 'Student'
        return view('student.index', compact('students') );     // chemin pour envoyer au template // on envoi la variable 'student' -> $student
    }

2a) Dans le template 'afficher all users' :
    <ul>
        @foreach ($students as $student)
            <li>{{ $student->username }}</li>
        @endforeach
    </ul>

2b) Dans le template 'afficher 1 user' :
    {{ $student->username }}


# /////// LAYOUT ///////
1) Dans le parent :
    <div class="container">
        @yield('content', 'default value')
    </div>

    <div class="sidebar">
        @section('sidebar')
            This is the master sidebar
        @show
    </div>


2) Dans l'enfant :
    @extends('layouts.master')              // on charge le template parent (le master)

    @section('sidebar')
        <h2>Nouvelle sidebar !</h2>         // on récupere les blocs des parents et on les remplis
    @endsection

    @section('content')                     // on récupere les blocs des parents et on les remplis
        hjhjhjhjh
    @endsection


# /////// INCLUDES ///////
    1) creer fichier 'main_menu.balde.php' (dans views/partials)
    2) importer ce fichier -> dans le master
        @include('partials.main_menu')







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
#   |   $ show tables;
#   |   $ show create table students;
#   |   $ select * from categories;


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
    use App\Name_entity;        // ne pas oublier d'ajouter le/les use nessessaires

    public function show() {
        return Student::all();
    }


# ///////////////////////////////////////////////////////////////////////////////////////////////////////
# //////////////////////////////////////////// RECAP : //////////////////////////////////////////////////
# ///////////////////////////////////////////////////////////////////////////////////////////////////////
- $ php artisan make:migration create_tags_table --create=tags                  // creation de la table + fichier '2015_08_31.... .php'
- Dans '2015_08_31.... .php' : remplir les champs (username, mail...)           // on defini les colonnes de notre table
- $ php artisan migrate                                                         // envoyer les colonnes de notre table
- $ php artisan make:model Tag              (sans 's')                          // creation d'un entity (ajouer $fillable dedans)
- creer des champs dans notre table (tinker)                                    // on ajoute des champs dans notre table
    a) TINKER :
    -> $ php artisan tinker
    -> $ App\Tag::create(['tag1' => 'a', 'tag2' => 'b']);

    b) OU EN LIGNE DE COMMANDE :
    -> sql$ insert into categories set title='titre 1';


# initialiser migrations (si bugues)
- $ sh install.sh
- $ php artisan migrate

# autre solution pour courte : utiliser way/generators




# ////////////////////// ELOQUENT 1..N - PREPARATION ////////////////////////////
table: 'posts' (secondary)           table: 'categories' (primary)
---------------              |        -----------------
title                        |        title
content                      |
category_id                <----

relation 1..n : relier ces deux table avec une clé secondaire
    1) creer les deux tables dans (php artisan make)
    2) Dans '2015_08_31.... .php' :
        $table->integer('category_id')->unsigned()->nullable();         // relation
        //...
        $table->foreign('category_id')                                  // cle secondaire (la contrainte)
            ->references('id')
            ->on('categories');
        //...
    3) $ php artisan migrate
    4) inserer des champs (dans les deux tables) :
        sql$ insert into categories set title='titre 1';
        sql$ insert into posts (title, category_id) values ('foo', 1), ('bar', 1), ('baz', 1);
        sql$ select * from categories;

        // on veux supprimer la catégorie 1 (mais garder ses posts)
         // $ php artisan migrate:rollback          // reset les dernieres tables
         // $ php artisan migrate
            $ delete from categories where id=1;    // supprime la categorie 1

        $ php artisan make:model Category
        $ php artisan make:model Post

    5) creer des champs (avec tinker) :
        tkr$ App\Category::create(['title' => 'mon titre 1', 'category_id' => 2]);
        tkr$     App\Post::create(['title' => 'mon titre 1', 'category_id' => 2, 'content' => 'jghg hg hg ghfdfgfgfh ghg']);


# ////////////////////// ELOQUENT ////////////////////////////
    Dans Category.php :
        public function posts() {
            return $this->hasMany('App\Post');
        }
    -------
    Dans Post.php :
        public function category() {
            return $this->belongsTo('App\Category');
        }
    ------

    Dans tinker (redemarrer avant) :
        App\Category::find(2)->posts;


creer :
    - route pour afficher all posts
    - template post/index.blade.php
    - sous chaque post, afficher la catégorie (le titre)

    1) controller   :       $ php artisan make:controller PostController --plain
    2) route        :       Route::get('/post', 'PostController@postAll');
    3) template     :       {{ $post->category? $post->category->title : 'pas de catégorie' }}








# ////////////////////////////////////////////////// NODE JS //////////////////////////////////////////////////
a la racine du projet :
    $ sudo npm install --global gulp
    $ sudo npm install gulp --save-dev
    $ sudo npm install gulp-sass
    $ sudo npm install gulp-minify-css gulp-concat gulp-rename
    si on utilise PhpStorm -> Settings -> project Name -> directories -> clique droit sur 'node_modules' -> exclude

    - aller dans 'gulpfile.js'
    $ gulp
    - modifier du css dans 'resources/assets/sass'


# ////////////////////////////////////////////////// DEPENDANCES //////////////////////////////////////////////////
Laravel-debugbar :
    $ composer require barryvdh/laravel-debugbar
    - dans config/app/ :
        1) -> dans 'aliases' ajouter notre service :
            Barryvdh\Debugbar\ServiceProvider::class,

        2) -> dans 'providers' ajouter notre service :
            'Debugbar' => Barryvdh\Debugbar\Facade::class,

    3) $ php artisan vendor:publish


# ////////////////////////////////////////////////// INSTALLER UN COMPOSANT //////////////////////////////////////////////////
    1) installer un composant :
        avec composer  (pour chercher)    ->  $ composer search way/generators
        avec composer  (pour chercher)    ->  $ composer show way/generators

        - avec composer                     ->  $ composer require laracasts/generators --dev
        OU
       - 1) dans fichier 'composer.json' -> ajouter une ligne dans "require": { ... }
       - 2) dans console                 ->  $ composer update

        PUIS
       - dans app/Providers/AppServiceProvider.php     -> mettre le code (https://github.com/laracasts/Laravel-5-Generators-Extended)

   Pour verifier que le composant est bien installé :
        $ php artisan list

# Pour utiliser le composant :
    - on veux creer une nouvelle table 'comments' + l'entity (le modele)
        - id            -> base
        - mail
        - content
        - timestamp     -> base

    1 seul ligne de code :
        - 1a) $ php artisan make:migration:schema create_comments_table --schema="mail:string, content:text"

        OU MIEUX (si on veux lier notre table a une autre, table 'posts') :
        - 1b) $ php artisan make:migration:schema create_comments_table --schema="mail:string, content:text, post_id:integer:unsigned:foreign"

        - 2) php artisan migrate
        - 3) on verifie le sql :
            $ mysql --user=pierre --password=pierre
            $ use ecole;
            $ show create table comments;


    App\Post::create(['title' => 'Titre A', 'content' => 'hghghg hghghsghsgh']);
    App\Post::create(['title' => 'Titre B', 'content' => 'hghghg hghghssssghsgh', 'category_id' => 2]);
    App\Category::create(['title' => 'mon titre 1']);



# ////////////////////////////////////////////////// CONTROLLER ALL //////////////////////////////////////////////////
    methode qui va etre executer partout :
        - fichier 'Controller.php' :
                view::composer('partials.main_menu', function($view) {
                    $view->with('categories', category::all());
                });




# //////////////////////////////////////// ELOQUENT N..N - PREPARATION //////////////////////////////////////////////

créer une table intermédiaire (nommée table pivot) qui sert à mémoriser les clés étrangères

table: 'posts' (secondary)           table: 'posts_categories' (intermédiaire)         table 'categories' (primary)  
---------------              |        -----------------                         |   
title                        |        title                                     |   
content                      |                                                  |   

La table pivot posts_categories contient les clés des deux tables.



# /////////////////////////////////////////// FAKER & SEEDS (CLASSES DE POPULATION) ///////////////////////////////////////////////
    classes de population
    Les données des seeders ne change jamais (comme les tables nommées «rôles» et «utilisateurs» )

    database/seeds/*****Seeder.php

    - le nom du fichier seeders doit correspondre au nom de la table

    - 1) créer 1 nouvelle table nommées 'user' (ici 2 tables pour exemple)
        $ php artisan migrate:make create_roles_table --table=roles --create
     // $ php artisan migrate:make create_users_table --table=users --create


    - 2) creer un seeder
        $ php artisan make:seeder UserTableSeeder
            -> creation de UserTableSeeder.php dans 'seed/'

    - 3) dans UserTableSeeder.php :
        factory(App\User::class, 20)->create();

    - 4) dans 'DatabaseSeeder' :
        $this->call(UserTableSeeder::class);


    4) $ php artisan db:seed
    5) $ php artisan tinker
    4) $ App\user::all();


# ////////////////////////////////////////////////// CRUD & REST //////////////////////////////////////////////////

    1) $ php artisan make:controller NameController
    2) - creer la route :
        Route::resource('/comment', 'CommentController');
    3) pour obtenir la liste des url :
        $ php artisan route:list
    4) coller l'url voulu dans la vu : (exemple 'create')
        Form::open(['url'=>'comment/create/', //...
    5)




# ////////////////////////////////////////////////// FORM //////////////////////////////////////////////////
1) dans 'composer.json' ajouter :
    - "illuminate/html": "^5.0"

2) $ composer update

3) dans config/app.php :

    Illuminate\Html\HtmlServiceProvider::class,

    'Form'      => Illuminate\Html\FormFacade::class,
    'Html'      => Illuminate\Html\HtmlFacade::class,






# ////////////////////////////////////////////////// AUTH //////////////////////////////////////////////////
app/Http/Controller/Auth

- AuthController       -> gestion principal de l'auth
- PasswordController   -> gestion de reinitialisation des mots de passe perdu



- Le modèle : 'user' (deja creer nativement)
- la view   : a creer


1) creer un controller (pour gerer la pge admin)
    $ php artisan make:controller DashboardController --plain

2) creer la route
    Route::get('/auth/login', 'Admin\AuthController@getLogin');

3) middleware :
    - kkchose qui enrobe l'application (sans toucher a l'application) qui permet de faire des redirection

4) securiser le controller (creer une redirection '/auth/login') :
    - public function ____construct() {
        $this->middleware('auth');
    }

5) creer la vue :
    - creer un dossier 'auth'
    - 'login.blade.php'
    - coller le code pour creer le form : http://laravel.com/docs/5.1/authentication#authentication-quickstart

6) creer des login et mot de passe :
    $ mysql -u root -p --database ecole
    quitter $sql
    $ php artisan tinker
    $ App\User::create(['name' => 'pierre', 'email' => 'pierre@gmail.com', 'password' => Hash::make('Pierre')]);

7) dans AuthController :
    //...
    protected $redirectPath = 'dashboard';
    //...... use AuthenticatesAndRegistersUsers, ThrottlesLogins;

8a) dans 'app/Http/middleware/Authenticate.php'
    //...
    return redirect()->guest('dashboard');
    //...

8b) 'app/Http/middleware/RedirectAuthenticated.php' :
    //...
    return redirect('/dashboard');
    //...




9) creer un nouveau controller 'FrontController'
    - nous allons dans un premier temps mettre les méthodes de notre contrôleur PostController dedans et supprimer celui-ci
        -> $ php artisan make:controller FrontController
        -> copier coller les méthodes du controller 'PostController' dans le nouveau

    - Modifiez également les routes pour que tout fonctionne comme avant
        -> Route::get('/post', 'FrontController@postAll');
        -> Route::get('/post/{id}', 'FrontController@postOne');
        -> Route::get('/category/{id}', 'FrontController@postOneByCat');


    - re-créons le contrôleur PostController mais cette fois faites un contrôleur de ressource
        -> $ php artisan make:controller PostController         (sans --plain pour que ca sois un controller de resources)

    - Faites un dossier « front » dans le dossier des vues -> placez les deux vues que l'on avait créé dans 'post' dans ce dossier

10) DashboardController :
    - Créez un layout 'layouts/master_dashboard.blade.php'
    - Créez une view  'dashboard/index.balde.php'


11) LOGOUT :
    Dans route :
        - Route::get('/auth/logout', 'Auth\AuthController@getLogout');

    Dans la view ('master_dashboard.blade.php') :
        - <a href="{{url('auth/logout')}}">logout</a>



12) mise en page de la page 'post'

    1) creer la route   
        - Route::resource('/admin/post', 'PostController');

    2) proteger 'postController' avec un middleware :

        use App\Post;

        public function ____construct()
        {
            $this->middleware('auth');
        }


        public function index()
        {
            $posts = Post::paginate(5);
            return view('post.index', compact('posts') );

        }

        3) la view 'post/index.blade.php' : coper coller le code



# ////////////////////////////////////////////////// FACTORISATIO DES CONTROLLER //////////////////////////////////////////////////
- déplacer 2 controllers (bien namspacer ceux-ci) :
    Controller/admin/DashboardController.php
    Controller/admin/PostController.php


1) changer les routes :
    - Route::get('/dashboard', 'Admin\DashboardController@index');
    - Route::resource('/admin/post', 'Admin\PostController');


2) changer les 2 controllers :
    - namespace App\Http\Controllers\Admin;



# ////////////////////////////////////////////////// POSTS //////////////////////////////////////////////////
Ajouter un champs 'status' a la table 'post' :
    - $table->enum('status', ['published', 'unpublished', 'draft'])->default('unpublished');


Ligne de commandes :
    - $ php artisan migrate:refresh --seed

    ---- OU : ----
    - $ php artisan make:migration alter_posts_table --table=posts
    - $ php artisan migrate


Recreer l'utilisateur pour se connecter a l'admin :
    - php artisan tinker
    - App\User::create(['email' => 'pierre@gmail.com', 'password' => Hash::make('Pierre')] );
    - App\Category::create(['title' => 'Titre 1111'] );
    - App\Post::create(['category_id' => '1', 'title' => 'Titre 1', 'content' => 'hjhjshjx jxshjahoCH KXJKXJK kjkjk'] );



# ////////////////////////////////////////////////// FORMULAIRE - add //////////////////////////////////////////////////
doc : http://laravelcollective.com/docs/5.1/


# 1) dans le modele 'Category' on se fait une requet :
    public function scopeForCreate($query) {
        return $query->select('id', 'title');
    }

# 2) dans PostController :
    public function create()
    {
        $categories = Category::forCreate()->get();
        $cats = [];

        foreach($categories as $category) {
            $cats[$category->id] = $category->title;
        }

        return view('post.create', compact('cats') );
    }


# 3) Toujours dans PostController - creer une macro :

    use Form;
    use \Carbon\Carbon;


    public function ____construct()
    {
        $this->middleware('auth');

        // INPUT DATE :
        Form::macro('published', function() {
            return '<input class="form-control" type="date" name="published_at" value="' . Carbon::now()->toDateString() . '">';
        });

        // INPUT RADIO :
        Form::macro('myRadio', function ($name, ...$args) {
            $attr = '';
            if ( !empty($args) ) {
                foreach ($args as $value) $attr .= " $value ";
            }

            return sprintf('<input type="radio" name="%s" %s >', $name, $attr);
        });
    }

# 4) VIEW : copier coller le code dans 'create.balde.php'


# 5) dans PostController - methode 'store' (permet la gestion apres le click sur 'submit') :


# 6) REGLES DE VALIDATION - creation d'un fichier pour définir les champs en 'required' :
    - $ php artisan make:request PostFormRequest
        -> dans app/http/PostFormRequest.php

    - Dans controller :
        use App\Http\Requests;

        public function store(PostFormRequest $request)
        {
            dd($request->all());
        }

    - Dans PostFormRequest.php :
        public function authorize() {
            return true;
        }

        //....

        public function rules() {
            return [
                'title'         => 'required|string',
                'content'       => 'required|string',
                'status'        => 'required',
                'published_at'  => 'required',
                'category'      => 'required',
            ];
        }

    - pour avoir les message d'erreurs en francais :
        dans PostFormRequest.php :



    - METHODE POUR FORMATER LA DATE AU MOMENT DE L'ENVOI DU FORMULAIRE (AJOUTER POST) dans l'objet 'Post' :
        public function setPublishedAtAttribute($value) {
            $now = Carbon::now();
            $this->attributes['published_at'] = "$value {$now->hour}:{$now->minute}:{$now->second}";
        }



# 6) INSERER LES DONNER DANS LA BASE DE DONNE :
    - dans PostController - store() :

        public function store(Requests\PostFormRequest $request) {
            Post::create($request->all());
            redirect()->to('admin/post')->with('message', trans('student.success'));
        }


# ////////////////////////////////////////////////// COMPOSITION PHP //////////////////////////////////////////////////

# SOLID : Single Responsability Interface Segragation Injection Dependency


class Connexion
{

}

// composition hard coding
class Model
{
    protected $c;

    public function ____construct()
    {
        $this->c = new Connexion;
    }
}

// injection dependency
class Model2
{
    protected $c;

    public function ____construct(Connexion $c)
    {
        $this->c = $c;
    }
}

$model2 = new Model2(new Connexion);
// Dependency injection and interface segregation


interfaces IConnexion{
    function link(); // method public
}


class MySQLConnexion implements IConnexion
{
    public function link()
    {

    }
}

class ElasticSearchConnexion implements IConnexion
{
    public function link()
    {

    }
}

class Model
{
    protected $c;

    public function ____construct()
    {
        $this->c = new Connexion;
    }

    public function all()
    {
        $link = $this->c->link();
    }
}

$model = new Model;

class Model2
{
    protected $c;

    public function ____construct(IConnexion $c)
    {
        $this->c = $c;
    }
}

// easy injection dependencies
$model2 = new Model2(new MySQLConnexion);

$model3 = new Model2(new ElasticSearchConnexion);



# ////////////////////////////////////////////////// CREER UN SERVICE PROVIDER //////////////////////////////////////////////////
    $ php artisan list | grep make

    1) creer :
        $ php artisan make:provider MyHtmlServiceProvider
            -> creation du fichier


    2) coder le service :
        use Balde;

        public function boot()
        {
            Blade::directive('foo', function($expression) {
                return 'foo';
            });
        }


    3) décalrer le service :
        - dans config/app.php :
            'App\Providers\MyHtmlServiceProvider::class,'


    4) appeller le service (dans la vue par exemple) :
        @foo

#/// modifier la variable @foo dans la vue :
    - dans la MyHtmlServiceProvider :
        Blade::extend(function($value) {
            return preg_replace('/\{\?(.+)\?\}/', '<?php ${1} ?>', $value);
        });

    - dans la vue :
        {? $foo = 5; ?}



# /////////////////////// CREER SES PROPRES CLASSES ///////////////////////
    - creer app/Helper/MyHtml.php :    
        voir code dans ce fichier


    - dans providers/MyHtmlServiceProvider.php :
        use App\Helper\MyHtml;

        public function register()
        {
            $this->app->singleton('myHtml', function() {
                return new MyHtml($app);
            });
        }

    - dans la vue :
        {!! App::make('myHtml')->link('hjhjh', 'ggg') !!}
                    // les !! permettent d'annuler le HtmlEntities
                    // singleton -> utilise une variable static (donc appler 1 seul fois si utiliser plusieurs fois)


# /// version raccourci dans la vue = {!! MyHtml::link() !!}
    -



# PATERN FACADE :
// class statcic normal :
    Foo::bar();     

// n'est pas la meme chose que :
    Post::all();     // pattern facade, ce n'est en réalité pas une classe static
        // $post = new Post;
        // $post->all();


# /////////////////////// CREER UN PATERN FACADE ///////////////////////
    - creer 'app/Facade/MyHtml' et coder dans ce fichier
    - dans config/app.php - aliases :
        'MyHtml'    => App\Facade\MyHtml::class,
    - dans la vue :
        {!! MyHtml::link('hjhjh', 'ggg') !!}    // avant on devais mettre :    {!! App::make('myHtml')->link('hjhjh', 'ggg') !!}




# ////////////////////////////////////////////////// AKISMET //////////////////////////////////////////////////
    - creer un fichier de rules pour notre form :
        $ php artisan make:request CommentFormRequest

    - dans le controller, ajouter 'store(Requests\CommentFormRequest $request)'  (et ne pas oublier les use) :

    - key Akismet (clef perso apres avoir creer un compte) : XXXXXXXXXXX
    - $ composer require nickurt/laravel-akismet:dev-master
    - $ php artisan vendor:publish

    - creer un fichier 'config/akismet' :
        return [
            'api_key'  => env('KEY_AKISMET'), // variable défini dans la fichier .env
            'blog_url' => env('URL_AKISMET'),
        ];
    - dans le fichier .env :
        KEY_AKISMET=8edaaafa2377
        URL_AKISMET=http://localhost:8000

    - ajouter un champs 'spam' dans la table 'comment'

    - dans le controller 'CommentController' :
    
        $comment = Comment::create($request->all());
        \Akismet::setCommentContent($request->input('content'))
            ->setCommentAuthorEmail($request->input('email'))
            ->setCommentAuthorUrl($request->url());
        if (\Akismet::isSpam()) {
            $comment->spam = 1;
            $comment->save();
        }



# ////////////////////////////////////////////////// MAILDEV //////////////////////////////////////////////////
    - installer en -g
    - http://localhost:1080/

    - aller dans '.env' :
        MAIL_DRIVER=smtp
        MAIL_HOST=127.0.0.1
        MAIL_PORT=1025
        MAIL_USERNAME=null
        MAIL_PASSWORD=null
        MAIL_ENCRYPTION=false
        MAIL_ACCESS=pierremartin.pro@gmail.com
        MAIL_NAM=pierre

    - creer une route :
        Route::get('mail', function() {
            Mail::send('emails.email', ['name' => 'Pierre'], function($message) {
                $message->from('hicode@hicode.fr', 'Laravel');
                $message->to('pierremartin.pro@gmail.com')->cc('bar@exemple.com');
            });
        });

    - il reste a aller sur http://localhost:8000/mail
    - queueing mail -> mise en attente (sinon bug)







