# Controle de Insumos

Sistema web em Laravel + Livewire para controlar dois fluxos internos:

- entrada, saldo e saída de insumos;
- ordens de corte, materiais, bobinas, máquinas e cargas.

O projeto centraliza cadastros, importação de XML de nota fiscal, conferência de itens, criação de bobinas, montagem de cargas e registro de consumo de estoque.

## Objetivo

Reduzir controles manuais de estoque e produção, mantendo rastreabilidade entre clientes, insumos, notas fiscais, ordens, materiais, bobinas, cargas e saídas.

Fluxos principais:

1. Cadastrar clientes e insumos.
2. Importar XML de notas fiscais de insumos.
3. Registrar itens de insumos e consultar saldo disponível.
4. Registrar saídas de estoque sem permitir consumo acima do saldo.
5. Cadastrar ordens de corte e materiais esperados.
6. Importar XML de notas fiscais de material.
7. Criar bobinas a partir dos itens de material.
8. Criar cargas por máquina, turno e data de corte.
9. Adicionar ou remover bobinas de cargas criadas.

## Tecnologias

- PHP 8.3
- Laravel 13
- Livewire 4
- Flux UI
- Blade
- Tailwind CSS 4
- Vite 8
- MySQL
- SQLite em memória para testes
- PHPUnit 12

## Arquitetura

A interface segue o padrão:

```txt
Routes
-> Livewire full-page components
-> Livewire child components
-> Services/Actions
-> Models/Rules
```

As rotas web apontam diretamente para full-page components Livewire. Controllers não são usados para telas internas que apenas renderizam views ou chamam services.

Services concentram regras maiores e operações coordenadas, como importação de XML, criação de cargas e consumo de itens. Rules concentram validações reutilizáveis.

Controllers ficam reservados para API, webhooks, downloads/exports, callbacks externos, streams de arquivo ou rotas públicas tradicionais independentes da interface Livewire.

## Módulos

### Clientes

- Cadastro, listagem, busca, edição e exclusão.
- Bloqueio de exclusão quando há insumos associados.

### Insumos

- Cadastro, listagem, busca, detalhe, edição e exclusão.
- Associação com cliente.
- Bloqueio de exclusão quando há itens associados.

### Notas fiscais de insumos

- Importação de XML de NF-e por componente Livewire.
- Validação de estrutura do XML.
- Validação de nota duplicada.
- Validação de produtos vinculados a insumos cadastrados.
- Listagem, busca e visualização de itens importados.

### Itens de insumos

- Registro automático a partir do XML.
- Associação entre item, nota fiscal e insumo.
- Controle de quantidade com valores decimais.
- Cálculo de saldo disponível com base nas saídas registradas.
- Busca e consulta de itens.

### Saídas

- Registro de saída de itens de insumos.
- Validação de saldo disponível.
- Registro dos itens consumidos.
- Histórico de saídas.
- Edição dos dados principais da saída.
- Detalhamento dos itens vinculados a cada saída.

### Ordens e materiais

- Cadastro, listagem, busca, detalhe, edição e exclusão de ordens.
- Cadastro e edição de materiais vinculados a ordens.
- Controle de status de ordens.
- Bloqueios de exclusão quando há materiais ou itens dependentes.

### Notas fiscais de material

- Importação de XML de NF-e de material.
- Extração de itens de material.
- Associação com materiais de ordens ativas.
- Listagem, busca e visualização dos itens importados.

### Itens de material e bobinas

- Consulta de itens de material importados.
- Criação de bobinas a partir de itens de material.
- Listagem e edição de bobinas.
- Controle de status da bobina.
- Registro de defeito e peso de defeito.
- Bloqueio de exclusão de bobina já vinculada a carga.

### Máquinas e cargas

- Cadastro, listagem, busca, detalhe, edição e exclusão de máquinas.
- Criação de cargas por máquina, turno e data de corte.
- Seleção de bobinas disponíveis para compor uma carga.
- Limite de 6 bobinas por carga.
- Bobinas adicionadas a uma carga ficam com status `CORTADA`.
- Bobinas removidas de uma carga voltam para `EM_ESTOQUE`.
- Cargas criadas podem receber novas bobinas pela tela de adição de bobinas.

## Regras de negócio

- Uma nota fiscal de insumos ou material não pode ser importada mais de uma vez.
- Um XML só pode ser importado se tiver estrutura válida de NF-e.
- Produtos de XML de insumos precisam existir como insumos cadastrados.
- Produtos de XML de material precisam ser vinculáveis a materiais de ordens ativas.
- Um item de insumo não pode ser consumido acima do saldo disponível.
- Quantidades de entrada e saída aceitam valores decimais.
- O saldo do item de insumo é calculado pela quantidade de entrada menos a soma das saídas registradas.
- Uma carga não deve ultrapassar 6 bobinas.
- Entidades com dependências relevantes bloqueiam exclusão para preservar histórico e integridade.

## Estrutura principal

```txt
app/
|-- Livewire/
|   |-- Clients/
|   |-- Dispatches/
|   |-- ItemMaterials/
|   |-- Loads/
|   |-- Machines/
|   |-- MaterialInvoices/
|   |-- Materials/
|   |-- Orders/
|   |-- Rolls/
|   |-- Supplies/
|   |-- SupplyInvoices/
|   `-- SupplyItems/
|-- Models/
|-- Rules/
|   |-- Dispatches/
|   |-- MaterialInvoices/
|   `-- SupplyInvoices/
`-- Services/
    |-- Dispatches/
    |-- Loads/
    |-- MaterialInvoices/
    `-- SupplyInvoices/

resources/
`-- views/
    |-- Components/
    |-- Layout/
    `-- livewire/
        |-- clients/
        |-- dispatches/
        |-- item-materials/
        |-- loads/
        |-- machines/
        |-- material-invoices/
        |-- materials/
        |-- orders/
        |-- rolls/
        |-- supplies/
        |-- supply-invoices/
        `-- supply-items/
```

## Principais classes

### Livewire

- Clientes: `ClientIndex`, `ClientCreate`, `ClientEdit`, `ClientForm`, `ClientTable`
- Insumos: `SupplyIndex`, `SupplyCreate`, `SupplyShow`, `SupplyEdit`, `SupplyForm`, `SupplyTable`
- Notas de insumos: `SupplyInvoiceIndex`, `SupplyInvoiceShow`, `SupplyInvoiceImportForm`, `SupplyInvoiceTable`
- Itens de insumos: `SupplyItemIndex`, `SupplyItemTable`
- Saídas: `DispatchIndex`, `DispatchCreate`, `DispatchShow`, `DispatchTable`, `SelectedSupplyItemsList`, `EditDispatch`
- Ordens: `OrderIndex`, `OrderCreate`, `OrderShow`, `OrderEdit`, `OrderForm`, `OrderTable`
- Materiais: `MaterialCreate`, `MaterialEdit`
- Notas de material: `MaterialInvoiceIndex`, `MaterialInvoiceShow`, `MaterialInvoiceImportForm`, `MaterialInvoiceTable`
- Itens de material: `ItemMaterialIndex`, `ItemMaterialShow`, `ItemMaterialEdit`, `ItemMaterialTable`
- Bobinas: `RollIndex`, `RollsCreate`, `RollEdit`, `RollTable`
- Máquinas: `MachineIndex`, `MachineCreate`, `MachineShow`, `MachineEdit`, `MachineForm`, `MachineTable`
- Cargas: `LoadIndex`, `LoadCreate`, `LoadShow`, `LoadAddRolls`, `LoadTable`, `SelectedRollsList`, `EditLoad`

### Services

- `ImportSupplyInvoiceFromXMLService`: importa nota fiscal de insumos a partir de XML.
- `ExtractSupplyItems`: extrai e registra itens de insumos.
- `ConsumeSupplyItemsService`: registra consumo de itens em uma saída.
- `ImportMaterialInvoiceFromXMLService`: importa nota fiscal de material a partir de XML.
- `ExtractMaterialItems`: extrai e registra itens de material.
- `CreateLoadService`: cria carga e vincula bobinas selecionadas.

### Rules

- `ValidXMLSupplyInvoice`: valida XML, duplicidade e produtos de nota fiscal de insumos.
- `ValidateConsumeSupplyItems`: valida saldo disponível para consumo.
- `ValidXMLMaterialInvoice`: valida XML, duplicidade e vínculo de materiais.

### Models

- `Client`
- `Supply`
- `SupplyInvoice`
- `SupplyItem`
- `Dispatch`
- `DispatchItem`
- `Order`
- `Material`
- `MaterialInvoice`
- `ItemMaterial`
- `Roll`
- `Machine`
- `Load`

## Banco de dados

Principais tabelas do sistema:

- `clients`
- `supplies`
- `supply_invoices`
- `supply_items`
- `dispatches`
- `dispatch_items`
- `orders`
- `materials`
- `material_invoices`
- `item_materials`
- `rolls`
- `machines`
- `loads`

As quantidades de insumos e saídas usam campos decimais para suportar valores fracionados vindos do XML da nota fiscal.

## Testes

O projeto possui testes automatizados cobrindo fluxos principais, como:

- CRUD de clientes, máquinas, insumos, ordens, materiais e bobinas;
- importação de XML de insumos;
- importação de XML de material;
- bloqueio de XML inválido;
- bloqueio de nota fiscal duplicada;
- bloqueio de XML com produto não cadastrado ou não vinculável;
- registro de saída;
- bloqueio de saída sem saldo suficiente;
- criação de cargas com bobinas;
- edição de dados de carga;
- adição e remoção de bobinas em cargas;
- bloqueio de limite de bobinas por carga;
- buscas com Livewire.

Para executar os testes:

```bash
php artisan test
```

Ou usando o script do Composer:

```bash
composer test
```

Para rodar um teste específico:

```bash
php artisan test --filter LoadUpdateTest
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

Configure o banco de dados no `.env`:

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

## Comandos rápidos

Preparar o projeto:

```bash
composer setup
```

Subir servidor, fila, logs e Vite em paralelo:

```bash
composer dev
```

Rodar a suíte padrão:

```bash
composer test
```

Formatar PHP:

```bash
vendor/bin/pint
```

## Observações de desenvolvimento

- Alpine deve ser usado pelo Livewire; o projeto não deve instalar `alpinejs` para uso da aplicação.
- `resources/js/bootstrap.js` é apenas setup auxiliar do Laravel.
- Não carregar `resources/js/app.js` para iniciar Alpine no layout.
- Uploads Livewire são assíncronos; ações automáticas de importação devem esperar o fim do upload temporário.
- A suíte usa SQLite em memória; código testado deve evitar SQL exclusivo de MySQL sem alternativa compatível.

## Status do projeto

Projeto em desenvolvimento.

Funcionalidades principais já implementadas:

- cadastro e manutenção de clientes;
- cadastro e manutenção de insumos;
- importação de XML de notas de insumos;
- controle de saldo e registro de saídas;
- cadastro e manutenção de ordens e materiais;
- importação de XML de notas de material;
- criação e manutenção de bobinas;
- cadastro e manutenção de máquinas;
- criação, edição e manutenção de cargas;
- adição e remoção de bobinas em cargas criadas;
- testes automatizados dos principais fluxos.

## Autor

Desenvolvido por Arthur Lima.

GitHub: [Arthurlima0301](https://github.com/Arthurlima0301)
