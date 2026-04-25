# Configuração do GitHub

Este diretório contém arquivos de configuração e templates do GitHub para o repositório Akiba V2.

## Arquivos

### `ISSUE_TEMPLATE/`

Contém templates para issues padronizadas:

- `bug_report.yaml` - relatar bugs ou comportamentos inesperados
- `feature_request.yaml` - sugerir novas funcionalidades ou melhorias
- `task.yaml` - acompanhar tarefas gerais de desenvolvimento ou manutenção
- `refactor.yaml` - propor refatorações de qualidade de código, arquitetura ou performance
- `documentation.yaml` - solicitar adições ou melhorias na documentação
- `config.yaml` - configurar templates de issue e links de contato

### `pull_request_template.md`

Template padrão de pull request. Ele mantém os PRs focados em:

- Um objetivo claro
- Um resumo conciso das alterações
- Instruções de teste
- Um checklist de verificação
- Issues, PRs ou documentação relacionados

### `LABELS.md`

Referência para o sistema de labels do repositório.

## Diretrizes de Idioma

O repositório usa português brasileiro como idioma público principal. Use PT-BR para:

- README e documentação do projeto
- Templates de issues e PRs
- Títulos de issues e PRs
- Mensagens de commit
- Labels e milestones
- Notas de release

Quando houver conteúdo voltado a contribuidores internacionais, mantenha uma versão em inglês separada ou inclua um link claro para a tradução.

## Labels Padrão

| Label | Descrição |
|-------|-------------|
| `bug` | Relato de bug ou comportamento inesperado |
| `enhancement` | Nova funcionalidade ou melhoria |
| `documentation` | Adições ou melhorias de documentação |
| `refactor` | Refatoração de código |
| `backend` | Alterações em PHP, Laravel ou API |
| `frontend` | Alterações em Svelte, JavaScript ou CSS |
| `database` | Alterações em banco de dados, migrations ou seeders |
| `devops` | Alterações em infraestrutura, CI ou deploy |
| `help-wanted` | Procurando ajuda de contribuidores |
| `good-first-issue` | Boa tarefa para uma primeira contribuição |
| `duplicate` | Duplicada de outra issue |
| `wontfix` | Não será corrigida |

## Como Usar

### Criando uma issue

1. Acesse "Issues" -> "New issue".
2. Escolha um dos templates disponíveis.
3. Preencha os campos obrigatórios.
4. Adicione pelo menos uma label de tipo e uma label de área quando possível.
5. Clique em "Submit new issue".

### Criando um pull request

1. Faça push da sua branch.
2. Abra um "New pull request".
3. Descreva as alterações usando o template.
4. Preencha o checklist.
5. Vincule a issue relacionada com `Closes #123` quando aplicável.

## Boas Práticas

Use títulos de issue curtos e descritivos:

```text
Corrigir erro ao carregar posts na home
Adicionar suporte a tema escuro
Refatorar regras de validação de posts
```

Use seções claras ao escrever issues manualmente:

```markdown
## Descrição
[Qual é o problema ou solicitação?]

## Objetivo
[Por que isso importa? Qual problema resolve?]

## Tarefas
- [ ] Passo 1
- [ ] Passo 2
```

Para mais detalhes sobre contribuição, veja [CONTRIBUTING.md](../CONTRIBUTING.md).
