# Repository Guidelines

Projeto Laravel 13, Livewire, Tailwind CSS 4 e Vite. Alpine deve ser consumido pelo Livewire, sem dependência npm explícita. O app usa rotas em `routes/web.php`, full-page components em `App/Livewire`, services em `App/Services`, rules em `App/Rules`, models em `App/Models` e views em `resources/views/`.

## Mandatory Rules

- Faça mudanças pequenas e coerentes com o código existente.
- Não mova responsabilidades sem necessidade real.
- Não introduza novas dependências sem justificativa clara.
- Preserve a estrutura padrão do Laravel.
- Quando a mudança afetar UI, mantenha o alinhamento com `resources/views/Layout/layout.blade.php`.
- Controllers não devem ser mantidos apenas para retornar view ou chamar service de uma tela Livewire.

## Architecture Pattern

O fluxo padrão da interface é:

```txt
Routes
-> Livewire full-page components
-> Livewire child components
-> Services/Actions
-> Models/Rules
```

Livewire pode:

- receber input;
- validar entrada;
- chamar services;
- emitir eventos;
- controlar feedback visual.

Livewire não deve:

- conter regra de domínio;
- controlar a transação principal;
- criar várias entidades manualmente quando isso pertence a um service;
- interpretar XML profundamente;
- calcular regras de estoque.

Services, Rules e Models continuam concentrando regra de negócio e persistência.

## Controllers

Mantenha controllers apenas para:

- API;
- webhooks;
- downloads/exports;
- callbacks externos;
- streams de arquivo;
- rotas públicas/tradicionais independentes da interface Livewire.

Não crie controller para uma tela só porque ela precisa chamar um service. Se a ação pertence à tela Livewire, use um child component e chame o service diretamente nele.

## Project Structure

- `routes/web.php`: ponto central das rotas da aplicação; os fluxos principais apontam para Livewire full-page components.
- `app/Livewire/`: componentes Livewire organizados por domínio. Full-page components usam nomes com domínio na frente, como `ClientIndex`, `InvoiceShow` e `DispatchCreate`.
- `resources/views/livewire/`: views internas dos componentes Livewire, também nomeadas com domínio quando representam páginas, como `client-index.blade.php`.
- `resources/views/Layout/layout.blade.php`: layout principal compartilhado pelas telas.
- `resources/views/Components/`: componentes Blade reutilizáveis da interface.
- `app/Services/`: regras de negócio maiores, como importação de XML e consumo de itens.
- `app/Rules/`: validações reutilizáveis, como XML de nota fiscal e consumo de estoque.
- `app/Models/`: modelos Eloquent e relacionamentos do domínio, como `Supply`, `Invoice`, `Item`, `Dispatch` e `DispatchItem`.
- `database/migrations/`: schema do banco. As tabelas principais são `supplies`, `invoices`, `items`, `dispatches` e `dispatch_items`.
- `database/seeders/` e `database/factories/`: dados iniciais e fábricas de teste.
- `resources/css/app.css`: entrada do Tailwind, incluindo `@tailwindcss/vite`.
- `resources/js/bootstrap.js`: setup JS auxiliar do Laravel; não deve iniciar Alpine nem substituir o Alpine fornecido pelo Livewire.
- `tests/Feature/`: testes de fluxo HTTP e Livewire que exercitam rotas, componentes, validações e persistência com `RefreshDatabase`.
- `tests/Unit/`: testes focados em unidades isoladas.

## Basic Flow

- A rota recebe a requisição e aponta para um full-page component Livewire.
- O full-page component renderiza a tela e compõe child components quando necessário.
- Child components recebem input de tela, validam e chamam services quando a ação pertence à UI.
- Services executam regras de negócio maiores, transações principais e criação coordenada de entidades.
- Models concentram acesso ao banco e relacionamentos.
- Rules concentram validações reutilizáveis.
- As migrations definem as tabelas que sustentam esses models.
- Os testes em `tests/Feature` simulam esse fluxo com Livewire e fixtures quando necessário.

## Build, Test, and Development Commands

- Instalar dependências e preparar o projeto: `composer setup`
- Subir ambiente local completo: `composer dev`
- Rodar testes: `composer test`
- Rodar a aplicação isoladamente: `php artisan serve`
- Rodar frontend isolado: `npm run dev`
- Gerar build de produção: `npm run build`
- Executar testes diretamente: `php artisan test`
- Executar um filtro de teste específico: `php artisan test --filter NomeDoTeste`
- Formatar código PHP: `vendor/bin/pint`

## Coding Style and Conventions

- Siga o estilo já presente nos arquivos do repo.
- Para novas telas internas, use `Route::get(..., FullPageComponent::class)`.
- Nomeie full-page components com o domínio na frente, como `SupplyIndex`, `InvoiceShow`, `DispatchCreate`.
- Nomeie views Livewire correspondentes com o domínio na frente, como `supply-index.blade.php`, `invoice-show.blade.php`, `dispatch-create.blade.php`.
- Use child components para formulários e ações internas da tela, como `ClientForm`, `SupplyForm` e `InvoiceImportForm`.
- Mantenha nomes de modelos, componentes e views alinhados entre si.
- Use Eloquent, Livewire e recursos nativos do Laravel antes de criar camadas extras.
- Evite comentários óbvios; só deixe comentário quando houver uma regra ou decisão importante.

## Testing Guidelines

- O `phpunit.xml` usa SQLite em memória para testes.
- Testes de unidade ficam em `tests/Unit`.
- Testes de fluxo HTTP e Livewire ficam em `tests/Feature`.
- Quando alterar comportamento de tela, cubra o fluxo no teste mais próximo do usuário.
- Quando alterar banco, models, services, rules ou seeders, valide com testes que usam o estado esperado do schema.
- Antes de concluir uma mudança relevante, rode `composer test`.

## Security and Runtime Notes

- Não commite segredos do `.env`.
- As variáveis de teste já estão isoladas em `phpunit.xml`; não dependa de serviços externos para a suite padrão.
- O ambiente local usa `DB_CONNECTION=sqlite` em memória nos testes, então evite suposições sobre banco persistente.
- Revise arquivos em `storage/`, `vendor/` e `node_modules/` como artefatos gerados, não como código-fonte.

## Change Workflow

1. Entenda o arquivo mais próximo da área afetada antes de editar.
2. Mantenha o diff focado no problema atual.
3. Atualize rota, full-page component, child component, view e teste juntos quando a mudança atingir a tela.
4. Rode a verificação mínima que prova a mudança.
5. Não faça refactor amplo só para "limpar" o arquivo.
6. Remova pastas vazias que sobrarem após remover controllers, requests ou views antigas.

## Reference Points

- Layout principal: `resources/views/Layout/layout.blade.php`
- Rotas: `routes/web.php`
- Entrada CSS: `resources/css/app.css`
- Full-page components: `app/Livewire/`
- Views Livewire: `resources/views/livewire/`

# Workflow

- Sempre criar branch nova para cada tarefa a partir da branch main.
- Nome da branch: `type/scope-descricao` (ex: `feat/auth-login`).
- Nunca trabalhar na main.
- Commits devem seguir Conventional Commits.
- Mensagens de commit devem ser em Português.
- Nunca misturar contextos diferentes no mesmo commit.
- Sempre commitar incrementalmente:
  - mudança pequena -> commit pequeno;
  - não acumular para organizar depois;
  - commits devem agrupar apenas arquivos com dependência direta entre si;
  - quando houver contexto de negócio claro, separar por contexto, por exemplo tudo que envolve Dispatches em um commit próprio.
- Antes de commitar:
  - listar arquivos alterados com o domínio na frente, como `Clientes: routes/web.php`;
  - agrupar por contexto;
  - justificar agrupamento.
- Nunca executar:
  - `git rebase`
  - `git push --force`
  - `git merge`

sem autorização explícita.

- Se houver dúvida de escopo, parar e não commitar.

# Dores e Problemas

- Alpine deve vir do Livewire; não instalar `alpinejs` pelo npm para uso da aplicação.
- Não carregar `resources/js/app.js` nem componentes de assets Alpine no layout ou nas views.
- Views e componentes que usam Alpine devem manter `x-data` no próprio escopo e depender de `@livewireStyles` e `@livewireScripts` no layout global.
- Uploads Livewire são assíncronos: não use `wire:change` para processar arquivo antes do upload temporário terminar. Para import automático, dispare a ação após `livewire-upload-finish` ou use submit explícito.
