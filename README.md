# Controle de Insumos

Sistema web desenvolvido em Laravel para controle de insumos, notas fiscais, itens importados por XML e registro de saídas de estoque.

O projeto foi criado para resolver um fluxo interno de controle de materiais: cadastrar insumos, importar notas fiscais, consultar saldo disponível e registrar o consumo dos itens com base nas quantidades disponíveis.

## Objetivo

O objetivo do sistema é centralizar o controle de entrada e saída de insumos, reduzindo conferências manuais e evitando consumo acima do saldo disponível.

Fluxo principal:

1. Cadastrar insumos no sistema.
2. Importar XML de nota fiscal.
3. Validar se os produtos da nota existem como insumos cadastrados.
4. Registrar os itens da nota fiscal.
5. Consultar saldo disponível por item.
6. Registrar saídas de estoque.
7. Consultar histórico de notas, itens e saídas.

## Tecnologias utilizadas

- PHP 8.3
- Laravel 13
- Livewire 4
- MySQL
- Blade
- Tailwind CSS
- Vite
- PHPUnit

## Funcionalidades

### Insumos

- Cadastro de insumos.
- Listagem de insumos.
- Busca por nome.
- Validação de dados no cadastro.
- Relacionamento entre insumos e itens de notas fiscais.

### Notas fiscais

- Importação de XML de NF-e.
- Validação da estrutura do XML.
- Validação de nota fiscal duplicada.
- Validação de existência dos insumos antes da importação.
- Listagem de notas fiscais.
- Busca por número da nota.
- Visualização dos itens vinculados à nota fiscal.

### Itens

- Registro automático dos itens importados do XML.
- Associação entre item, nota fiscal e insumo.
- Controle de quantidade com valores decimais.
- Cálculo de saldo disponível com base nas saídas registradas.
- Busca por nome do insumo.
- Filtro de itens com saldo disponível.

### Saídas

- Registro de saída de itens.
- Validação de saldo disponível.
- Registro dos itens consumidos.
- Histórico de saídas.
- Detalhamento dos itens vinculados a cada saída.

### Pedidos

- Base inicial para integrar pedidos ao controle de materiais.
- Vinculo entre pedido e cliente.
- Codigo unico por pedido.

### Materiais

- Base inicial para registrar materiais vinculados a pedidos.
- Controle de item, envio, rolo, medidas, gramatura, expedicao, papel, lote, pacotes e pesos.
- Relacionamento direto com pedidos para futuras etapas de integracao.

## Regras de negócio

- Uma nota fiscal não pode ser importada mais de uma vez.
- Um XML só pode ser importado se tiver estrutura válida de NF-e.
- Os produtos do XML precisam existir previamente como insumos cadastrados.
- Um item não pode ser consumido acima do saldo disponível.
- Quantidades de entrada e saída aceitam valores decimais.
- O saldo do item é calculado pela quantidade de entrada menos a soma das saídas registradas.

## Estrutura principal

```txt
app/
├── Http/
│   ├── Controllers/
│   │   ├── Dispatches/
│   │   ├── Invoices/
│   │   ├── Items/
│   │   └── Supplies/
│   └── Requests/
│       ├── Dispatches/
│       ├── Invoices/
│       └── Supplies/
├── Livewire/
│   ├── Dispatches/
│   ├── Invoices/
│   ├── Items/
│   └── Supplies/
├── Models/
├── Rules/
│   └── Invoices/
└── Services/
    ├── Dispatches/
    └── Invoices/
````

## Principais classes do domínio

### Services

* `ImportInvoiceFromXMLService`: responsável por importar a nota fiscal a partir do XML.
* `ExtractItems`: responsável por extrair e registrar os itens da nota fiscal.
* `ConsumeItemsService`: responsável por registrar o consumo dos itens em uma saída.

### Models

* `Supply`: representa um insumo cadastrado.
* `Invoice`: representa uma nota fiscal importada.
* `Item`: representa um item de uma nota fiscal.
* `Dispatch`: representa uma saída de estoque.
* `DispatchItem`: representa os itens consumidos em uma saída.
* `Order`: representa um pedido vinculado a um cliente.
* `Material`: representa um material vinculado a um pedido.

## Banco de dados

Principais tabelas do sistema:

* `supplies`
* `invoices`
* `items`
* `dispatches`
* `dispatch_items`
* `orders`
* `materials`

As quantidades dos itens e das saídas utilizam campos decimais para suportar valores fracionados vindos do XML da nota fiscal.
Pedidos se relacionam com clientes por `client_id`; materiais se relacionam com pedidos por `order_id`.

## Testes

O projeto possui testes automatizados cobrindo fluxos principais, como:

* importação de XML válido;
* bloqueio de XML inválido;
* bloqueio de nota fiscal duplicada;
* bloqueio de XML com insumo inexistente;
* registro de saída;
* bloqueio de saída sem saldo suficiente;
* consumo com quantidade decimal;
* busca com Livewire;
* edição de nota fiscal;
* CRUD de insumos.

Para executar os testes:

```bash
php artisan test
```

Ou usando o script do Composer:

```bash
composer test
```

## Instalação

Clone o repositório:

```bash
git clone https://github.com/Arthurlima0301/Controle-de-Insumos.git
```

Entre na pasta do projeto:

```bash
cd Controle-de-Insumos
```

Instale as dependências PHP:

```bash
composer install
```

Instale as dependências JavaScript:

```bash
npm install
```

Copie o arquivo de ambiente:

```bash
cp .env.example .env
```

No Windows PowerShell:

```powershell
copy .env.example .env
```

Gere a chave da aplicação:

```bash
php artisan key:generate
```

Configure o banco de dados no arquivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=controle_insumos
DB_USERNAME=root
DB_PASSWORD=
```

Execute as migrations:

```bash
php artisan migrate
```

Compile os assets:

```bash
npm run build
```

Inicie o servidor local:

```bash
php artisan serve
```

Para desenvolvimento com Vite:

```bash
npm run dev
```

## Comando rápido de setup

O projeto possui um script de setup configurado no Composer:

```bash
composer run setup
```

Esse comando instala dependências, prepara o `.env`, gera a chave da aplicação, executa as migrations e compila os assets.

## Rodando o ambiente de desenvolvimento

O projeto também possui script para iniciar servidor, fila, logs e Vite em paralelo:

```bash
composer run dev
```

## Status do projeto

Projeto em desenvolvimento.

Funcionalidades principais já implementadas:

* cadastro de insumos;
* importação de XML;
* validação de nota fiscal;
* listagem de notas;
* listagem de itens;
* cálculo de saldo;
* registro de saídas;
* estrutura inicial de pedidos e materiais;
* testes automatizados dos principais fluxos.
  
## Autor

Desenvolvido por Arthur Lima.

GitHub: [Arthurlima0301](https://github.com/Arthurlima0301)
