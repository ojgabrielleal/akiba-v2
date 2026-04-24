# Akiba v2 Standard Labels / Labels Padrao do Akiba v2

## Portugues

Este documento define todos os labels usados no repositorio Akiba v2 e suas finalidades.

### Tipo de issue

| Label | Descricao | Cor |
|-------|-----------|-----|
| `bug` | Relatorio de erro ou comportamento inesperado | Red |
| `enhancement` | Nova funcionalidade ou melhoria | Green |
| `refactor` | Melhoria de codigo existente | Orange |
| `documentation` | Adicao ou melhoria de documentacao | Blue |
| `security` | Problema de seguranca | Red |
| `performance` | Melhoria de performance | Yellow |

### Area do codigo

| Label | Descricao | Cor |
|-------|-----------|-----|
| `backend` | Mudancas em PHP/Laravel/API | Blue |
| `frontend` | Mudancas em Vue/JavaScript/CSS | Purple |
| `database` | Mudancas em banco de dados | Brown |
| `devops` | Mudancas em infraestrutura/CI-CD | Black |
| `documentation` | Melhorias em docs | Blue |

### Status

| Label | Descricao | Cor |
|-------|-----------|-----|
| `in-progress` | Trabalho em andamento | Orange |
| `blocked` | Bloqueada, aguardando algo | Red |
| `ready` | Pronta para ser desenvolvida | Green |
| `needs-review` | Aguardando revisao | Yellow |
| `in-review` | Em processo de revisao | Yellow |

### Prioridade

| Label | Descricao | Cor |
|-------|-----------|-----|
| `priority-critical` | Bloqueador, producao quebrada | Red |
| `priority-high` | Alta prioridade | Orange |
| `priority-medium` | Prioridade media | Yellow |
| `priority-low` | Baixa prioridade, pode esperar | Green |

### Comunidade

| Label | Descricao | Cor |
|-------|-----------|-----|
| `help-wanted` | Procurando ajuda de contribuidores | Yellow |
| `good-first-issue` | Boa para primeiro contribuidor | Green |
| `question` | Duvida ou pergunta | Blue |
| `discussion` | Discussao aberta | Purple |

### Decisoes

| Label | Descricao | Cor |
|-------|-----------|-----|
| `duplicate` | Duplicata de outra issue | Gray |
| `wontfix` | Nao sera corrigido | Gray |
| `invalid` | Invalida ou incorreta | Gray |
| `needs-more-info` | Precisa de mais informacoes | Yellow |

### Como usar labels

Ao criar uma issue, inclua um label de tipo, um label de area, um label de prioridade quando aplicavel, e labels adicionais conforme necessario.

Exemplo para uma nova feature de autenticacao:

- `enhancement`
- `backend`
- `security`
- `priority-high`

Durante a revisao, atualize labels conforme a issue progride: `ready` -> `in-progress` -> `needs-review` -> fechada.

---

## English

This document defines all labels used in the Akiba v2 repository and their purpose.

### Issue type

| Label | Description | Color |
|-------|-------------|-------|
| `bug` | Error report or unexpected behavior | Red |
| `enhancement` | New feature or improvement | Green |
| `refactor` | Improvement to existing code | Orange |
| `documentation` | Documentation addition or improvement | Blue |
| `security` | Security issue | Red |
| `performance` | Performance improvement | Yellow |

### Code area

| Label | Description | Color |
|-------|-------------|-------|
| `backend` | PHP/Laravel/API changes | Blue |
| `frontend` | Vue/JavaScript/CSS changes | Purple |
| `database` | Database changes | Brown |
| `devops` | Infrastructure/CI-CD changes | Black |
| `documentation` | Documentation improvements | Blue |

### Status

| Label | Description | Color |
|-------|-------------|-------|
| `in-progress` | Work in progress | Orange |
| `blocked` | Blocked, waiting for something | Red |
| `ready` | Ready to be developed | Green |
| `needs-review` | Waiting for review | Yellow |
| `in-review` | In review | Yellow |

### Priority

| Label | Description | Color |
|-------|-------------|-------|
| `priority-critical` | Blocker, production is broken | Red |
| `priority-high` | High priority | Orange |
| `priority-medium` | Medium priority | Yellow |
| `priority-low` | Low priority, can wait | Green |

### Community

| Label | Description | Color |
|-------|-------------|-------|
| `help-wanted` | Looking for contributor help | Yellow |
| `good-first-issue` | Good for a first-time contributor | Green |
| `question` | Question | Blue |
| `discussion` | Open discussion | Purple |

### Decisions

| Label | Description | Color |
|-------|-------------|-------|
| `duplicate` | Duplicate of another issue | Gray |
| `wontfix` | Will not be fixed | Gray |
| `invalid` | Invalid or incorrect | Gray |
| `needs-more-info` | Needs more information | Yellow |

### How to use labels

When creating an issue, include one type label, one area label, one priority label when applicable, and any additional labels as needed.

Example for a new authentication feature:

- `enhancement`
- `backend`
- `security`
- `priority-high`

During review, update labels as the issue progresses: `ready` -> `in-progress` -> `needs-review` -> closed.
