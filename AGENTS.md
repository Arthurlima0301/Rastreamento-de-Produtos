# Repository Guidelines

Projeto Laravel 13, Livewire, Tailwind CSS 4 e Vite. Alpine deve ser consumido pelo Livewire, sem dependencia npm explicita. O app usa rotas em `routes/web.php`, controllers em `App/Http/Controllers`, requests em `App/Http/Requests`, services em `App/Services` e views em `resources/views/`.

## Mandatory Rules

- Faça mudancas pequenas e coerentes com o codigo existente.
- Nao mova responsabilidades sem necessidade real.
- Nao introduza novas dependencias sem justificativa clara.
- Preserve a estrutura padrao do Laravel
- Quando a mudanca afetar UI, mantenha o alinhamento com `resources/views/Layout/layout.blade.php`

## Project Structure
- `routes/web.php`: ponto central das rotas da aplicacao; os fluxos principais chamam controllers por nome ou com `Route::resource`.
- `App/Http/Controllers/`: coordena requisicoes HTTP, models, requests, services e retorno das views.
- `App/Http/Requests/`: valida entrada dos formularios e uploads antes de chegar aos controllers.
- `App/Services/`: regras de negocio maiores, como importacao de XML e consumo de itens.
- `App/Models/`: modelos Eloquent e relacionamentos do dominio, como `Insumo`, `NotaFiscal`, `Item`, `Saida` e `SaidaItem`.
- `database/migrations/`: schema do banco. As tabelas principais sao `insumos`, `nota_fiscal`, `items`, `saidas` e `saidas_items`.
- `database/seeders/` e `database/factories/`: dados iniciais e fabricas de teste.
- `resources/css/app.css`: entrada do Tailwind, incluindo `@tailwindcss/vite`
- `resources/js/bootstrap.js`: setup JS auxiliar do Laravel; nao deve iniciar Alpine nem substituir o Alpine fornecido pelo Livewire.
- `resources/views/pages/`: paginas Blade renderizadas por controllers, organizadas por funcionalidade em pastas como `Supplies/`, `Items/`, `Invoices/` e `Dispatches/`.
- `resources/views/Layout/layout.blade.php`: layout principal compartilhado pelas telas.
- `resources/views/Components/`: componentes Blade reutilizaveis da interface.
- `resources/views/livewire/`: views internas dos componentes Livewire.
- `tests/Feature/`: testes de fluxo HTTP que exercitam rotas, controllers, validacoes e persistencia com `RefreshDatabase`.
- `tests/Unit/`: testes focados em unidades isoladas.

## Basic Flow
- A rota recebe a requisicao e aponta para um controller.
- O controller valida entrada com um FormRequest quando necessario e chama models ou services.
- Os models concentram o acesso ao banco e os relacionamentos entre tabelas.
- As migrations definem as tabelas que sustentam esses models.
- As views Blade exibem os dados retornados pelos controllers e usam o layout principal e componentes compartilhados.
- Os testes em `tests/Feature` simulam esse fluxo de ponta a ponta com fixtures quando necessario.

## Build, Test, and Development Commands

- Instalar dependencias e preparar o projeto: `composer setup`
- Subir ambiente local completo: `composer dev`
- Rodar testes: `composer test`
- Rodar a aplicacao isoladamente: `php artisan serve`
- Rodar frontend isolado: `npm run dev`
- Gerar build de producao: `npm run build`
- Executar testes diretamente: `php artisan test`
- Executar um filtro de teste especifico: `php artisan test --filter NomeDoTeste`
- Formatar codigo PHP: `vendor/bin/pint`

## Coding Style and Conventions

- Siga o estilo ja presente nos arquivos do repo.
- Para novas telas, use a mesma abordagem das rotas atuais: `Route::get(..., Controller::class)`.
- Mantenha nomes de modelos, componentes e views alinhados entre si.
- Use Eloquent e recursos nativos do Laravel antes de criar camadas extras.
- Evite comentarios obvios; so deixe comentario quando houver uma regra ou decisao importante.

## Testing Guidelines

- O `phpunit.xml` usa SQLite em memoria para testes.
- Testes de unidade ficam em `tests/Unit`.
- Testes de fluxo HTTP ficam em `tests/Feature`.
- Quando alterar comportamento de tela, cubra o fluxo no teste mais proximo do usuario.
- Quando alterar banco, models ou seeders, valide com testes que usam o estado esperado do schema.
- Antes de concluir uma mudanca relevante, rode `composer test`.

## Security and Runtime Notes

- Nao commite segredos do `.env`.
- As variaveis de teste ja estao isoladas em `phpunit.xml`; nao dependa de servicos externos para a suite padrao.
- O ambiente local usa `DB_CONNECTION=sqlite` em memoria nos testes, entao evite suposicoes sobre banco persistente.
- Revise arquivos em `storage/`, `vendor/` e `node_modules/` como artefatos gerados, nao como codigo-fonte.

## Change Workflow

1. Entenda o arquivo mais proximo da area afetada antes de editar.
2. Mantenha o diff focado no problema atual.
3. Atualize view, componente, rota e teste juntos quando a mudanca atingir a tela.
4. Rode a verificacao minima que prova a mudanca.
5. Nao faça refactor amplo so para "limpar" o arquivo.

## Reference Points

- Layout principal: `resources/views/Layout/layout.blade.php`
- Rotas: `routes/web.php`
- Entrada CSS: `resources/css/app.css`

# Workflow
- Sempre criar branch nova para cada tarefa a partir da branch main.
- Nome da branch: type/scope-descricao (ex: feat/auth-login).
- Nunca trabalhar na main.

- Commits devem seguir Conventional Commits.
- Messagem do commit devem ser em Português

- Nunca misturar contextos diferentes no mesmo commit.

- Sempre commitar incrementalmente:
  - mudança pequena → commit pequeno
  - não acumular para organizar depois
  - commits devem agrupar apenas arquivos com dependencia direta entre si
  - quando houver contexto de negocio claro, separar por contexto (ex: tudo que envolve Dispatches em um commit proprio)

- Antes de commitar:
  - listar arquivos alterados
  - agrupar por contexto
  - justificar agrupamento

- Nunca executar:
  - git rebase
  - git push --force
  - git merge

sem autorização explícita.

- Se houver dúvida de escopo → parar e não commitar.

# Dores e Problemas

- Alpine deve vir do Livewire; nao instalar `alpinejs` pelo npm para uso da aplicacao.
- Nao carregar `resources/js/app.js` nem componentes de assets Alpine no layout ou nas views.
- Views e componentes que usam Alpine devem manter `x-data` no proprio escopo e depender de `@livewireStyles` e `@livewireScripts` no layout global.
