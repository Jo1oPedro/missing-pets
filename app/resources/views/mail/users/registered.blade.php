@component('mail::message')

    Bem-vindo ao {{ config('app.name') }}!

    Olá {{ $name }},

    Agradecemos por se cadastrar no Missing Pets, a plataforma que te ajuda a encontrar seu pet perdido.

    Com o {{ config('app.name') }}, você pode:

    * Criar um perfil para o seu pet com fotos, informações e características;
    * Compartilhar o perfil do seu pet nas redes sociais e com amigos;
    * Receber notificações se alguém encontrar seu pet;
    * Acessar uma rede de apoio de pessoas que também perderam seus pets.

    Para começar, siga estes passos:

    1. Acesse o site do Missing Pets: https://www.ejsocial.com.
    2. Faça login com seu email e senha.
    3. Crie um post do seu pet.
    4. Compartilhe o seu post nas redes sociais e com amigos.

    Estamos aqui para te ajudar a encontrar seu pet. Se você tiver alguma dúvida, entre em contato conosco pelo email https://www.ejsocial.com/help

@endcomponent
