# GitHub Configuration / Configuracoes do GitHub

## Portugues

Este diretorio contem configuracoes e templates para o repositorio Akiba v2.

### Arquivos

#### `ISSUE_TEMPLATE/`

Contem templates para criar issues padronizadas:

- `bug_report.yaml` - Para reportar bugs
- `feature_request.yaml` - Para sugerir novas funcionalidades
- `task.yaml` - Para tarefas gerais
- `refactor.yaml` - Para refatoracoes
- `documentation.yaml` - Para melhorias em documentacao
- `config.yaml` - Configuracao dos templates

#### `pull_request_template.md`

Template padrao para Pull Requests, garantindo que PRs tenham:

- Descricao clara do objetivo
- Testes realizados
- Checklist de verificacao
- Links relacionados

### Labels padronizados

| Label | Cor | Descricao |
|-------|-----|-----------|
| `bug` | Red | Relatorio de bug |
| `enhancement` | Green | Nova feature ou melhoria |
| `documentation` | Blue | Melhorias na documentacao |
| `refactor` | Orange | Refatoracao de codigo |
| `backend` | Blue | Mudancas no backend (PHP/Laravel) |
| `frontend` | Purple | Mudancas no frontend (Vue/JS) |
| `help wanted` | Yellow | Procurando ajuda de contribuidores |
| `duplicate` | Gray | Duplicata de outra issue |
| `wontfix` | Gray | Nao sera corrigido |

### Como usar

#### Para criar uma issue

1. Va em "Issues" -> "New issue"
2. Escolha um dos templates disponiveis
3. Preencha os campos obrigatorios, marcados com `*`
4. Clique em "Submit new issue"

#### Para criar um PR

1. Faca push da sua branch
2. Abra um "New pull request"
3. Descreva as mudancas seguindo o template
4. Preencha o checklist
5. Clique em "Create pull request"

### Documentacao

Para mais informacoes sobre como contribuir, consulte o [CONTRIBUTING.md](../CONTRIBUTING.md).

### Boas praticas

Use titulos de issues com um emoji e um titulo descritivo:

```text
Bug ao carregar posts
Adicionar tema escuro
Refatorar validacao
```

Use secoes claras:

```markdown
## Descricao
[O que?]

## Objetivo
[Por que? Qual problema resolve?]

## Tasks/Passos
- [ ] Passo 1
- [ ] Passo 2
```

Use no minimo 2 labels por issue, categorize por area (`backend`, `frontend`, etc.) e use prioridade quando aplicavel.

---

## English

This directory contains GitHub configuration files and templates for the Akiba v2 repository.

### Files

#### `ISSUE_TEMPLATE/`

Contains templates for standardized issues:

- `bug_report.yaml` - For reporting bugs
- `feature_request.yaml` - For suggesting new features
- `task.yaml` - For general tasks
- `refactor.yaml` - For refactoring work
- `documentation.yaml` - For documentation improvements
- `config.yaml` - Template configuration

#### `pull_request_template.md`

Default Pull Request template, ensuring PRs include:

- A clear goal description
- Tests performed
- Verification checklist
- Related links

### Standard labels

| Label | Color | Description |
|-------|-------|-------------|
| `bug` | Red | Bug report |
| `enhancement` | Green | New feature or improvement |
| `documentation` | Blue | Documentation improvements |
| `refactor` | Orange | Code refactoring |
| `backend` | Blue | Backend changes (PHP/Laravel) |
| `frontend` | Purple | Frontend changes (Vue/JS) |
| `help wanted` | Yellow | Looking for contributor help |
| `duplicate` | Gray | Duplicate of another issue |
| `wontfix` | Gray | Will not be fixed |

### How to use

#### To create an issue

1. Go to "Issues" -> "New issue"
2. Choose one of the available templates
3. Fill in the required fields, marked with `*`
4. Click "Submit new issue"

#### To create a PR

1. Push your branch
2. Open a "New pull request"
3. Describe the changes using the template
4. Fill in the checklist
5. Click "Create pull request"

### Documentation

For more information about contributing, see [CONTRIBUTING.md](../CONTRIBUTING.md).

### Best practices

Use issue titles with an emoji and a descriptive title:

```text
Bug loading posts
Add dark theme
Refactor validation
```

Use clear sections:

```markdown
## Description
[What?]

## Goal
[Why? What problem does it solve?]

## Tasks/Steps
- [ ] Step 1
- [ ] Step 2
```

Use at least 2 labels per issue, categorize by area (`backend`, `frontend`, etc.), and use priority labels when applicable.
