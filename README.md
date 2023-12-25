# Recipes para instalar no Composer/Symfony
```
composer require maker orm migrations profiler form validator security debug
```

# Criação das entidades
```
php .\bin\console make:entity Telefone
 created: src/Entity/Telefone.php
 created: src/Repository/TelefoneRepository.php
```
> Note que nesse passo serão criadas duas classes: a entidade em si e o repositório.

## Definição de relacionamentos com outras entidades
```
 Field type (enter ? to see all types) [string]:
 > relation

 What class should this entity be related to?:
 > Aluno

What type of relationship is this?
 ------------ ------------------------------------------------------------------- 
  Type         Description
 ------------ -------------------------------------------------------------------
  ManyToOne    Each Telefone relates to (has) one Aluno.
               Each Aluno can relate to (can have) many Telefone objects.

  OneToMany    Each Telefone can relate to (can have) many Aluno objects.
               Each Aluno relates to (has) one Telefone.

  ManyToMany   Each Telefone can relate to (can have) many Aluno objects.
               Each Aluno can also relate to (can also have) many Telefone objects.

  OneToOne     Each Telefone relates to (has) exactly one Aluno.
               Each Aluno also relates to (has) exactly one Telefone.
 ------------ -------------------------------------------------------------------

 Relation type? [ManyToOne, OneToMany, ManyToMany, OneToOne]:
 > ManyToOne

 Is the Telefone.aluno property allowed to be null (nullable)? (yes/no) [yes]:
 >

 Do you want to add a new property to Aluno so that you can access/update Telefone 
 objects from it - e.g. $aluno->getTelefones()? (yes/no) [yes]:
 >

 A new property will also be added to the Aluno class so that you can access the 
 related Telefone objects from it.

 New field name inside Aluno [telefone]:
 >

 updated: src/Entity/Telefone.php
 updated: src/Entity/Aluno.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 >


 
  Success! 
 

 Next: When you're ready, create a migration with php bin/console make:migration
```
# Arquivo .env.local
O arquivo `.env.local` pode ser criado para se sobrepor ao arquivo `.env`. Arquivos `.env` não deveriam ser versionados. Aqui, estamos usando o arquivo `.env` como exemplo, mas ele está configurado para usar uma instância do Postgre que não temos no projeto.

Copiando o arquivo `.env` com o nome `.env.local`, configuramos o banco de dados para uma instância local do SQLite que ficará na pasta `var` na raiz do projeto.

```shell
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
# DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=15&charset=utf8"
```
# Migrações

## Criação de migrations do banco de dados
Uma vez que o banco de dados estiver configurado, crie o arquivo de migração do banco de dados com o comando abaixo:

```
php .\bin\console make:migration
 created: migrations/Version20231225220636.php

 
  Success! 
 

 Review the new migration then run it with php bin/console doctrine:migrations:migrate
 See https://symfony.com/doc/current/bundles/DoctrineMigrationsBundle/index.html
```
> Todo arquivo de migração criado é nomeado com o nome `migrations/Version{Ano}{Mês}{Dia}{Hora}{Minuto}{Segundo}`.

## Executando as migrações
Com o comando a seguir
```
php .\bin\console doctrine:migrations:migrate
```
O comando acima executa todas as migrations. Para executar as migrações aos poucos, use os parâmetros `first`, `latest`, `prev`, `current` ou `next`: 

Exemplo usando o parâmetro `first`:
```
 PS D:\temp\symfony> php .\bin\console doctrine:migrations:migrate first 

 WARNING! You are about to execute a migration in database "main" that could result in schema 
 changes and data loss. Are you sure you wish to continue? (yes/no) [yes]:
 >


 [OK] Already at the first version ("0")     
```
Neste exemplo, voltamos para a primeira versão do banco.


# Criando e removendo as entidades do banco de dados
As entidades banco de dados podem ser criadas ou removidas por meio das migrations ou por meio dos comandos do doctrine (`doctrine:schema:create` e `doctrine:schema:drop`). 

Exemplo de como apagar as entidades do banco de dados:

```
PS D:\temp\symfony> php .\bin\console doctrine:schema:drop --force
 Dropping database schema...


 [OK] Database schema dropped successfully!
```
> Note que no comand `php .\bin\console doctrine:schema:drop --force` o parâmetro `force` é obrigatório se quisermos apagar as entidades do banco.

Para criarmos as entidades, usamos: 
```
PS D:\temp\symfony> php .\bin\console doctrine:schema:create

 !
 ! [CAUTION] This operation should not be executed in a production environment!
 ! 

 Creating database schema...


 [OK] Database schema created successfully!
```

# Mais recipes
Instalamos as recipes `form` e `validator` para automatizar a criação dos CRUDs. A recipe `security` (ou `security-csrf`, que tem conflito com a `security`) vai nos fornecer o token CSRF para impedir ataques.

# Criação de CRUDs
Exemplo de criação do CRUD da entidade `Teste` (`php bin\console make:crud Teste`):
```
PS D:\temp\symfony> php .\bin\console make:crud Teste

 Choose a name for your controller class (e.g. TesteController) [TesteController]:
 >

 Do you want to generate tests for the controller?. [Experimental] (yes/no) [no]:
 >

 created: src/Controller/TesteController.php
 created: src/Form/TesteType.php
 created: templates/teste/_delete_form.html.twig
 created: templates/teste/_form.html.twig
 created: templates/teste/edit.html.twig
 created: templates/teste/index.html.twig
 created: templates/teste/new.html.twig
 created: templates/teste/show.html.twig

 
  Success! 
 

 Next: Check your new CRUD by going to /teste/
```
> Note que o comando `make:crud` cria tudo: o formulário para criar e editar a entidade (`TesteType`), o controlador para responder às requisições do navegador (`TesteController`) e as views para cada uma das operações CRUD.

# Path raiz da aplicação
O comando `app.request.getSchemeAndHttpHost()` no Twig retorna a raiz da aplicação. Isso é útil para referenciar arquivos que estão na pasta `public`:
```HTML
<link rel="stylesheet" href="{{ app.request.getSchemeAndHttpHost() }}/node_modules/bootstrap/dist/css/bootstrap.min.css">
```

# Validações dos formulários/types
Cada campo dos formulários/types do Symfony pode possuir validações graças à opção `contraints`. Veja o exemplo de `TelefoneType`: 
```php 
<?php

// Resto do código
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class TelefoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero', options: [
                'constraints' => [
                    new Regex('/\d{2}\s*\d{4,5}[\s-]*\d{4}/', 'Telefone com formato inválido.')
                ],
            ])
            ->add('aluno', EntityType::class, [
                // Resto do código
                'constraints' => [
                    new NotBlank(message: 'Escolha um aluno.'),
                ],
                // Resto do código
            ])
        ;
    }
    // Resto do código
}
```

# Biblioteca JavaScript para autocomplete.
A biblioteca `dselect` facilita para autocompletes de campos HTML `select`. Veja em https://github.com/jarstone/dselect

Nos formulários (Types), modifique o campo `choice_label` para definir qual campo aparecerá no `select` (por padrão, tanto a chave quanto o valor usam a `id` da entidade). Neste caso usaremos o campo `nome` da entidade `Telefone`:
```php
// Resto do código

class TelefoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Resto do código
            ->add('aluno', EntityType::class, [
                'class' => Aluno::class,
                'choice_label' => 'nome',
                'placeholder' => 'Escolha um aluno',
                'constraints' => [
                    new NotBlank(message: 'Escolha um aluno.'),
                ],
                'required' => false, // Desligamos o required para fazer a validação server-side.
            ])
        ;
    }
    // Resto do código
}
```
> Note o paradoxo: existe a constraint `NotBlank`, mas o campo não é obrigatório (`required => false`). Isso é necessário porque a validação pelo cliente não é exibida, o que dificulta o debug.

# Biblioteca JavaScript para multiselect.
A biblioteca `multi-select-tag` cria um campo HTML `select` de seleção multipla. Isso é interessante para relacionamentos muitos para muitos. Veja em https://github.com/habibmhamadi/multi-select-tag .

# Bootstrap 5
Infelizmente, para obter o Bootstrap 5 localmente temos que baixá-lo com `npm install bootstrap`. Existe a recipe `assets` do Symfony, mas ela não é completa para baixar os pacotes do npm.

Para que os formulários gerados pelo Symfony mantenham a aparência do bootstrap, não se esqueça de modificar o arquivo `config/packages/twig.yaml`:
```yaml
twig:
    form_themes: ['bootstrap_5_layout.html.twig']
```

# Recipe Security
A recipe `security` possibilita configurações de autenticação por meio do arquivo de configuração `config/packages/security.yaml`: 

```yaml
security:
    providers:
        users_in_memory: 
            memory: 
                users: 
                    # Notação original
                    # thiago: {
                    #     password: '$2y$13$nEjXK5OnwwIrFSRCD40WF.BpGu6YsSJz.QoyYV78vpd/51alBMNnG', 
                    #     roles: ['ROLE_ADMIN']
                    # }
                    thiago: # Notação alternativa
                        password: '$2y$13$nEjXK5OnwwIrFSRCD40WF.BpGu6YsSJz.QoyYV78vpd/51alBMNnG'
                        roles: ['ROLE_ADMIN']
                    # A senha pode ser obtida por meio do seguinte comando:
                    # PS D:\temp\symfony> php .\bin\console security:hash-password suaSenha
    firewalls:
        main: # Firewall onde é feita a autenticação.
            lazy: true
            provider: users_in_memory # Provedor de autenticação que está em security.providers.

            logout:
                path: /logout # URL para realizar o logout.
            form_login:
                login_path: app_login # Rota para o formulário de login.
                check_path: app_login # Rota para o formulário de login.
                enable_csrf: true # Se true, exige o envio do csrf_token (hidden field).

    access_control: # Mapa das rotas e dos roles que podem acessá-las.
        - { path: ^/curso, roles: ROLE_USER }
        - { path: ^/telefone, roles: ROLE_USER }
        - { path: ^/aluno, roles: ROLE_USER }
        # - { path: ^/admin, roles: ROLE_ADMIN }

    role_hierarchy: # Diz que roles são parte de outras roles.
        # ROLE_ADMIN : ROLE_USER # Sintaxe normal.
        ROLE_ADMIN: # Sintaxe alternativa, permite listar várias roles.
            - ROLE_USER

```
# A role IS_AUTHENTICATED_FULLY
A role `IS_AUTHENTICATED_FULLY` é uma role que não precisa ser declarada: é uma role genérica para qualquer usuário que conseguiu se autenticar na aplicação.

# Formulário e Controller de Login
Não é obrigatória a criação de um FormType para login, mas no exemplo criei um conforme código a seguir.

## FormType de Login
```php
<?php

namespace App\Form;
// Resto do código

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('_username', options: [
                'label' => 'Usuário',
                'constraints' => new NotBlank([
                    'message' => 'O nome de usuário é um campo obrigatório.'
                ]),
            ])
            ->add('_password', PasswordType::class,[
                'label' => 'Senha',
                'constraints' => new NotBlank([
                    'message' => 'Senha é um campo obrigatório.'
                ]),
            ])
        ;
    }

    public function getBlockPrefix() : string
    {
        return '';
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => [
                'novalidate' => 'novalidate', // <form method="post" novalidate="novalidate">
            ]
        ]);
    }
}
```
> Destaque para o método `getBlockPrefix()`: por padrão, os campos dos formulários recebem um prefixo com o nome do FormType. Quando este método retorna string vazia, os campos não recebem prefixo. Isso é importante para a manipulação da requisição de login.
> 
> O formulário de login obrigatoriamente deve enviar os campos `_username` e `_password` (ambos prefixados com o underline). Do contrário, o Symfony não consegue processar o login.

## Controlador do login
Código do `LoginController`:
```php
<?php

namespace App\Controller;

use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\InMemoryUser;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(
        AuthenticationUtils $authenticationUtils,
        Request $request,
    ): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $ultimoUsuario = $authenticationUtils->getLastUsername();
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);

        return $this->render(
            'login/login.html.twig', 
            compact(
                'form', 
                'error', 
                'ultimoUsuario', 
            ),
        );
    }
}
```

## Template Twig do formulário de login
```html
{% extends 'base.html.twig' %}

{% block title %}Faça Login{% endblock %}

{% block body %}
    <h1>Login</h1>
    {{ form_errors(form)}}
    {{ form_start(form)}}
        <input type="hidden" name="_csrf_token" value="{{ csrf_token('authenticate') }}">
        {{ form_row(form._username) }}
        {{ form_errors(form._username) }}
        {{ form_row(form._password) }}
        {{ form_errors(form._password) }}
        <button class="btn btn-success" type="submit">Login</button>
    {{ form_end(form)}}
    {#
        <form method="POST">
            <label for="_username">Usuário</label>
            <input type="text" class="form-control" name="_username">
            <label for="_password">Senha</label>
            <input type="password" class="form-control" name="_password">
            <button class="btn btn-success" type="submit">Login</button>
        </form>
        {{ senha }}
    #}
{% endblock %}
```
> Note o campo `_csrf_token`, cujo valor é obtido da função `csrf_token('autenticate')`. Como a configuração em `security.yaml` habilitou o CSRFToken, este campo precisa ser submetido com o formulário.
> 
> A sessão envolvida por `{# #}` é um exemplo de formulário sem usar o FormType. Note a existência dos campos `_username` e `_password`.

# Exibindo conteúdo no template dependendo de o usuário estar logado ou não
Como testar no template Twig se o usuário está logado? Use a função `is_granted(ROLE_NAME)`, conforme código abaixo do `templates/base.html.twig`:

```html
{% if is_granted('ROLE_USER') %}
    <a class="nav-link" aria-current="page" href="/logout">Logout</a>
{% else %}
    <a class="nav-link" aria-current="page" href="{{ path('app_login') }}">Login</a>
{% endif %}
```
