# Repository Guidelines

Projeto Laravel 13, Livewire 4, Flux UI, Tailwind CSS 4 e Vite. Alpine deve ser consumido pelo Livewire, sem dependência npm explícita. O app usa rotas em `routes/web.php`, full-page components em `app/Livewire`, services em `app/Services`, rules em `app/Rules`, models em `app/Models` e views em `resources/views/`.

## Mandatory Rules

- Faça mudanças pequenas e coerentes com o código existente.
- Não mova responsabilidades sem necessidade real.
- Não introduza novas dependências sem justificativa clara.
- Preserve a estrutura padrão do Laravel.
- Quando a mudança afetar UI, mantenha alinhamento com `resources/views/Layout/layout.blade.php`.
- Controllers não devem ser mantidos apenas para retornar view ou chamar service de uma tela Livewire.
- Documentação deve acompanhar mudanças de fluxo, nomes de domínio, comandos e estrutura do projeto.

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
- controlar feedback visual;
- coordenar estado simples de tela.

Livewire não deve:

- conter regra de domínio complexa;
- controlar a transação principal quando houver criação coordenada de entidades;
- criar várias entidades manualmente quando isso pertence a um service;
- interpretar XML profundamente;
- calcular regras de estoque que pertencem a services, rules ou models.

Services, Rules e Models concentram regra de negócio, persistência coordenada e validações reutilizáveis.

## Domain Map

### Clientes, insumos e notas de insumos

- `Client`: cliente associado a insumos.
- `Supply`: insumo cadastrado para controle de estoque.
- `SupplyInvoice`: nota fiscal de insumos importada por XML.
- `SupplyItem`: item de nota fiscal de insumos, com quantidade e saldo.
- `Dispatch` e `DispatchItem`: saída de estoque e itens consumidos.

### Ordens, materiais, bobinas e cargas

- `Order`: ordem de corte/produção.
- `Material`: material esperado em uma ordem.
- `MaterialInvoice`: nota fiscal de material importada por XML.
- `ItemMaterial`: item de material importado e associado a uma ordem/material.
- `Roll`: bobina gerada a partir de um item de material.
- `Machine`: máquina usada no corte.
- `Load`: carga/corte com bobinas vinculadas.

### Cargas

- Cargas são criadas em `LoadCreate` com apoio de `SelectedRollsList`.
- A criação coordenada da carga e vínculo das bobinas usa `App\Services\Loads\CreateLoadService`.
- `LoadShow` exibe e atualiza dados da carga, além de remover bobinas da carga.
- `LoadAddRolls` adiciona bobinas disponíveis a uma carga já criada.
- Uma carga deve respeitar o limite de 6 bobinas.

## Controllers

Mantenha controllers apenas para:

- API;
- webhooks;
- downloads/exports;
- callbacks externos;
- streams de arquivo;
- rotas públicas/tradicionais independentes da interface Livewire.

Não crie controller para uma tela só porque ela precisa chamar um service. Se a ação pertence à tela Livewire, use um component Livewire e chame o service diretamente nele.

## Project Structure

- `routes/web.php`: ponto central das rotas da aplicação; os fluxos principais apontam para Livewire full-page components.
- `app/Livewire/Clients/`: telas e componentes de clientes.
- `app/Livewire/Supplies/`: telas e componentes de insumos.
- `app/Livewire/SupplyInvoices/`: importação, listagem e detalhe de notas fiscais de insumos.
- `app/Livewire/SupplyItems/`: listagem e consulta de itens de insumos.
- `app/Livewire/Dispatches/`: criação, listagem, detalhe e edição de saídas.
- `app/Livewire/Orders/`: criação, listagem, detalhe e edição de ordens.
- `app/Livewire/Materials/`: criação e edição de materiais de ordens.
- `app/Livewire/MaterialInvoices/`: importação, listagem e detalhe de notas fiscais de material.
- `app/Livewire/ItemMaterials/`: listagem, detalhe e edição de itens de material.
- `app/Livewire/Rolls/`: criação, listagem e edição de bobinas.
- `app/Livewire/Machines/`: criação, listagem, detalhe e edição de máquinas.
- `app/Livewire/Loads/`: criação, listagem, detalhe, edição e adição de bobinas em cargas.
- `resources/views/livewire/`: views internas dos componentes Livewire, nomeadas por domínio.
- `resources/views/Layout/layout.blade.php`: layout principal compartilhado pelas telas.
- `resources/views/Components/`: componentes Blade reutilizáveis da interface.
- `app/Services/`: regras de negócio maiores, como importação de XML, consumo de itens e criação de cargas.
- `app/Rules/`: validações reutilizáveis, como XML de notas fiscais e consumo de estoque.
- `app/Models/`: modelos Eloquent e relacionamentos do domínio.
- `database/migrations/`: schema do banco. As tabelas principais incluem `clients`, `supplies`, `supply_invoices`, `supply_items`, `orders`, `materials`, `material_invoices`, `item_materials`, `rolls`, `machines`, `loads`, `dispatches` e `dispatch_items`.
- `database/seeders/` e `database/factories/`: dados iniciais e fábricas de teste.
- `resources/css/app.css`: entrada do Tailwind e Flux UI.
- `resources/js/bootstrap.js`: setup JS auxiliar do Laravel; não deve iniciar Alpine nem substituir o Alpine fornecido pelo Livewire.
- `tests/Feature/`: testes de fluxo HTTP e Livewire com `RefreshDatabase`.
- `tests/Unit/`: testes focados em unidades isoladas.

## Basic Flow

- A rota recebe a requisição e aponta para um full-page component Livewire.
- O full-page component renderiza a tela e compõe child components quando necessário.
- Child components recebem input de tela, validam e chamam services quando a ação pertence à UI.
- Services executam regras de negócio maiores, transações principais e criação coordenada de entidades.
- Models concentram acesso ao banco, casts, accessors, scopes e relacionamentos.
- Rules concentram validações reutilizáveis.
- As migrations definem as tabelas que sustentam esses models.
- Os testes em `tests/Feature` simulam esse fluxo com Livewire e fixtures quando necessário.

## UI and Livewire Notes

- Para novas telas internas, use `Route::get(..., FullPageComponent::class)`.
- Full-page components usam nomes com domínio na frente, como `SupplyIndex`, `MaterialInvoiceShow`, `LoadAddRolls` e `DispatchCreate`.
- Views Livewire correspondentes usam kebab-case por domínio, como `supply-index.blade.php`, `material-invoice-show.blade.php`, `load-add-rolls.blade.php` e `dispatch-create.blade.php`.
- Use child components para formulários e ações internas da tela, como `ClientForm`, `SupplyForm`, `SelectedRollsList` e `SelectedSupplyItemsList`.
- Views e componentes que usam Alpine devem manter `x-data` no próprio escopo e depender de `@livewireStyles` e `@livewireScripts` no layout global.
- Não carregar `resources/js/app.js` nem componentes de assets Alpine no layout ou nas views.
- Uploads Livewire são assíncronos: não use `wire:change` para processar arquivo antes do upload temporário terminar. Para import automático, dispare a ação após `livewire-upload-finish` ou use submit explícito.

## Business Rules

- Uma nota fiscal de insumos ou materiais não pode ser importada mais de uma vez.
- XMLs importados precisam ter estrutura válida e produtos vinculáveis ao cadastro esperado.
- Itens de insumos não podem ser consumidos acima do saldo disponível.
- Quantidades de entrada e saída de insumos aceitam valores decimais.
- Bobinas vinculadas a carga ficam com status `CORTADA`.
- Bobinas removidas de carga voltam para `EM_ESTOQUE`.
- Uma carga não deve conter mais de 6 bobinas.
- Entidades com dependências devem bloquear exclusão quando isso preserva integridade do domínio.

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
- Mantenha nomes de modelos, componentes e views alinhados entre si.
- Use Eloquent, Livewire e recursos nativos do Laravel antes de criar camadas extras.
- Use services quando a ação coordenar múltiplas entidades, transação principal ou regra de domínio relevante.
- Evite comentários óbvios; deixe comentário quando houver uma regra, decisão importante ou quando o padrão local já usa docblock de método.
- Preserve acentuação UTF-8 em documentação e textos de interface.

## Testing Guidelines

- O `phpunit.xml` usa SQLite em memória para testes.
- Testes de unidade ficam em `tests/Unit`.
- Testes de fluxo HTTP e Livewire ficam em `tests/Feature`.
- Quando alterar comportamento de tela, cubra o fluxo no teste mais próximo do usuário.
- Quando alterar banco, models, services, rules ou seeders, valide com testes que usam o estado esperado do schema.
- Antes de concluir uma mudança relevante, rode `composer test` quando viável.
- Para mudanças focadas, rode também o filtro mais próximo, como `php artisan test --filter LoadUpdateTest`.
- Evite SQL específico de MySQL em código exercitado pela suíte padrão; SQLite não suporta funções como `CONCAT()`.

## Security and Runtime Notes

- Não commite segredos do `.env`.
- As variáveis de teste já estão isoladas em `phpunit.xml`; não dependa de serviços externos para a suite padrão.
- O ambiente local usa `DB_CONNECTION=sqlite` em memória nos testes, então evite suposições sobre banco persistente.
- Revise arquivos em `storage/`, `vendor/` e `node_modules/` como artefatos gerados, não como código-fonte.

## Change Workflow

1. Entenda o arquivo mais próximo da área afetada antes de editar.
2. Mantenha o diff focado no problema atual.
3. Atualize rota, full-page component, child component, view e teste juntos quando a mudança atingir a tela.
4. Atualize `README.md` e este `AGENTS.md` quando a mudança alterar estrutura, fluxo, comandos ou regras relevantes.
5. Rode a verificação mínima que prova a mudança.
6. Não faça refactor amplo só para "limpar" o arquivo.
7. Remova pastas vazias que sobrarem após remover controllers, requests ou views antigas.

## Git Workflow

- Sempre criar branch nova para cada tarefa a partir da branch `main`.
- Nome da branch: `type/scope-descricao`, por exemplo `feat/auth-login`.
- Nunca trabalhar na `main`.
- Commits devem seguir Conventional Commits.
- Mensagens de commit devem ser em português.
- Nunca misturar contextos diferentes no mesmo commit.
- Sempre commitar incrementalmente:
  - mudança pequena -> commit pequeno;
  - não acumular para organizar depois;
  - commits devem agrupar apenas arquivos com dependência direta entre si;
  - quando houver contexto de negócio claro, separar por contexto, por exemplo tudo que envolve `Dispatches` em um commit próprio.
- Antes de commitar:
  - listar arquivos alterados com o domínio na frente, como `Clientes: routes/web.php`;
  - agrupar por contexto;
  - justificar agrupamento.
- Nunca executar `git rebase`, `git push --force` ou `git merge` sem autorização explícita.
- Se houver dúvida de escopo, parar e não commitar.

## Known Pain Points

- Alpine deve vir do Livewire; não instalar `alpinejs` pelo npm para uso da aplicação.
- Não carregar `resources/js/app.js` para iniciar Alpine.
- Uploads Livewire não devem ser processados antes do fim do upload temporário.
- A suíte roda em SQLite em memória; queries com função específica de outro banco precisam de alternativa compatível.
- Alguns fluxos antigos ainda podem ter nomes herdados de `Invoice`/`Item`; prefira os nomes atuais `SupplyInvoice`, `SupplyItem`, `MaterialInvoice` e `ItemMaterial`.

## Reference Points

- Layout principal: `resources/views/Layout/layout.blade.php`
- Rotas: `routes/web.php`
- Entrada CSS: `resources/css/app.css`
- Full-page components: `app/Livewire/`
- Views Livewire: `resources/views/livewire/`
- Services: `app/Services/`
- Rules: `app/Rules/`
- Testes de fluxo: `tests/Feature/`
