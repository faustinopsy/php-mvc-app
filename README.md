# PHP MVC Application

Esta é uma aplicação simples desenvolvida em PHP utilizando o padrão MVC (Model-View-Controller). O objetivo principal é gerenciar dados de usuários com foco em princípios de programação orientada a objetos e boas práticas de design de software. A aplicação implementa funcionalidades de CRUD (Criar, Ler, Atualizar, Excluir) para gerenciamento de usuários com a possibilidade de expandir com outros módulos, utilizando SQLite como banco de dados.
A aplicação agora utiliza uma classe **Entidade** (`User`) para representar os dados do usuário, melhorando o encapsulamento e a organização do código.
---

## Estrutura do Projeto

```
php-mvc-app
├── app
│   ├── Controllers
│   │   ├── UserController.php
│   │   └── ApiUserController.php
│   ├── Models
│   │   └── UserModel.php
│   ├── Entities
│   │   └── UserModel.php
│   ├── Views
│   │   ├── templates
│   │   │   ├── partials
│   │   │   │   ├── header.php
│   │   │   │   └── footer.php
│   │   │   ├── user
│   │   │   │   ├── create.php
│   │   │   │   ├── edit.php
│   │   │   │   └── index.php
│   │   │   └── errors
│   │   │       └── 404.php
│   └── core
│       ├── BaseController.php
│       ├── Router.php
│       ├── View.php
│       ├── Flash.php
│       └── Redirect.php
│   └── Validators
│       └── UserValidator.php
├── config
│   └── database.php
├── public
│   ├── index.php
│   ├── routes.php
│   └── assets
│       ├── css
│       │   └── style.css
│       ├── js
│       │   └── darkmode.js
│       └── images
├── .env.example
├── composer.json
└── README.md
```

---

## Funcionalidades

- **Gerenciamento de Usuários**: Criar, ler, atualizar e excluir registros de usuários.
- **Suporte a API**: Responder a requisições API com dados em formato JSON.
- **Sistema de Rotas**: Gerenciamento de URLs com suporte a parâmetros dinâmicos.
- **Renderização de Views**: Renderização dinâmica de templates com suporte a partials (cabeçalho e rodapé) e uma função helper (`$h`) para escaping de HTML.
- **Mensagens Flash**: Notificações para ações realizadas pelo usuário.
- **Persistência de Formulários**: Mantém os dados preenchidos em formulários (exceto senhas) após erros de validação, usando mensagens flash para "old input".
- **Modo Escuro**: Alternância entre temas claro e escuro com persistência via `localStorage`.
- **Injeção de Dependências**: Uso de classes auxiliares como `UserValidator` para validações específicas.
- **Uso de Entidades**: A classe `UserModel` retorna objetos `User` em vez de arrays, promovendo melhor encapsulamento.

---

## Padrões de Design Utilizados

1. **Princípios SOLID**:
   - **Responsabilidade Única (SRP)**: Cada classe tem uma única responsabilidade. Por exemplo, `UserValidator` é responsável apenas por validações de usuários.
   - **Inversão de Dependência (DIP)**: Controladores dependem de abstrações (como `UserValidator`) em vez de implementações concretas.
   - (Outros princípios como OCP, LSP, ISP também são considerados no design geral).
2. **Composição sobre Herança**:
   - A lógica genérica é centralizada na `BaseController`, enquanto funcionalidades específicas são delegadas a classes auxiliares como `UserValidator`.

3. **Padrão Strategy**:
   - A validação de dados é encapsulada em uma classe separada (`UserValidator`), permitindo a reutilização e substituição de estratégias de validação.

4. **Padrão Dependency Injection**:
   - Classes como `UserValidator` são injetadas nos controladores, facilitando a substituição e os testes unitários.

5. **Padrão Template Method**:
   - A `BaseController` fornece métodos genéricos (`extractAndValidateData`, `jsonResponse`) que podem ser reutilizados ou estendidos por controladores específicos.

6. **Padrão Entity**:
   - A classe `App\Entities\User` representa um registro de usuário, encapsulando seus dados e getters.

---

## Como Funcionam as Mensagens Flash e Redirecionamentos

### Mensagens Flash
As mensagens flash são usadas para exibir notificações temporárias ao usuário, como mensagens de sucesso ou erro. Elas são armazenadas na sessão e removidas automaticamente após serem exibidas.
- **Definir uma Mensagem Flash (Ex: Erro)**:
  ```php
  use App\Core\Flash;

  // A chave da sessão é definida em .env (FLASH_MESSAGE_KEY)
  Flash::setMessage($_ENV['FLASH_MESSAGE_KEY'], ['error' => 'Senha inválida.']);
  ```

- **Exibir Mensagens Flash na View**:
  ```php
  <?php if ($flash = \App\Core\Flash::get($_ENV['FLASH_MESSAGE_KEY'])): ?>
      <?php foreach ($flash as $type => $message): ?>
      <div class="<?php echo $h($type); ?>"> <!-- Usa o helper $h para escapar a classe CSS -->
          <?php echo $h($message); ?> <!-- Usa o helper $h para escapar a mensagem -->
      </div>
      <?php endforeach; ?>
  <?php endif; ?>
  ```
  *(Nota: A variável `$h` é uma função helper passada pelo Controller para aplicar `htmlspecialchars`)*

### Redirecionamentos
A classe `Redirect` é usada para redirecionar o usuário para outra página, com suporte a mensagens flash.

- **Redirecionar com Mensagem Flash e "Old Input" (após erro de validação)**:
  ```php
  use App\Core\Redirect;

  // Passa a mensagem de erro e os dados do $_POST para repopular o formulário
  Redirect::with('/user/create', ['error' => 'Dados inválidos.'], $_POST);
  ```
- **Redirecionar com Mensagem Flash (após sucesso)**:
  ```php
  use App\Core\Redirect;

  Redirect::with('/user/create', ['error' => 'Ocorreu um erro ao criar o usuário.']);
  ```

- **Redirecionar sem Mensagem Flash**:
  ```php
  Redirect::to('/user/index');
  ```

---

## Validações com `UserValidator`

A classe `UserValidator` é responsável por validar os dados de entrada relacionados a usuários. Ela é injetada nos controladores para garantir que as validações sejam centralizadas e reutilizáveis.

- **Exemplo de Validação**:
  ```php
  use App\Validators\UserValidator;
  // $userModel é uma instância de UserModel
  $validator = new UserValidator($userModel);
  $errors = $validator->validate($data);

  if (!empty($errors)) {
      // Lidar com os erros
  }
  ```

- **Regras de Validação**:
  - O nome deve ter entre 3 e 50 caracteres.
  - O e-mail deve ser válido e único.
  - A senha deve ter pelo menos 6 caracteres (obrigatória na criação, opcional na atualização, mas validada se fornecida).

---

## Instalação

1. Clone o repositório:
   ```bash
   git clone https://github.com/faustinopsy/php-mvc-app
   ```

2. Navegue até o diretório do projeto:
   ```bash
   cd php-mvc-app
   ```

3. Instale as dependências usando o Composer:
   ```bash
   composer install
   ```

4. Configure a conexão com o banco de dados no arquivo `config/database.php` e configure o banco SQLite.

5. Crie um arquivo `.env` na raiz do projeto com as variáveis de ambiente necessárias. Use o arquivo `.env.example` como referência.

---

## Uso

- Acesse o arquivo `public/index.php` no navegador para iniciar a aplicação.
- Utilize as rotas fornecidas para gerenciar usuários e interagir com a aplicação.

- Se o php estiver setado nas variáveis de ambiente basta iniciar o servidor embutido dentro da pasta do projeto:

```
php -S localhost:8080 -t public
```

---

## Contribuindo

Sinta-se à vontade para enviar issues ou pull requests para melhorias e correções de bugs.

---

## Licença

Este projeto é open-source e está disponível sob a licença MIT.