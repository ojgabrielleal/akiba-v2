# 📁 Configurações GitHub

Este diretório contém configurações e templates para o repositório Akiba v2.

## 📋 Arquivos

### `ISSUE_TEMPLATE/`

Contém templates para criar issues padronizadas:

- **bug_report.yaml** - 🐛 Para reportar bugs
- **feature_request.yaml** - 🚀 Para sugerir novas funcionalidades
- **task.yaml** - 📋 Para tarefas gerais
- **refactor.yaml** - 🔧 Para refatorações
- **documentation.yaml** - 📚 Para melhorias em documentação
- **config.yaml** - Configuração dos templates

### `pull_request_template.md`

Template padrão para Pull Requests, garante que PRs tenham:
- Descrição clara do objetivo
- Testes realizados
- Checklist de verificação
- Links relacionados

## 🏷️ Labels Padronizados

Os templates usam os seguintes labels:

| Label | Cor | Descrição |
|-------|-----|-----------|
| `bug` | 🔴 Red | Relatório de bug |
| `enhancement` | 🟢 Green | Nova feature ou melhoria |
| `documentation` | 📘 Blue | Melhorias na documentação |
| `refactor` | 🟠 Orange | Refatoração de código |
| `backend` | 🔵 Blue | Mudanças no backend (PHP/Laravel) |
| `frontend` | 🟣 Purple | Mudanças no frontend (Vue/JS) |
| `help wanted` | 🟡 Yellow | Procurando ajuda de contribuidores |
| `duplicate` | ⚫ Gray | Duplicata de outra issue |
| `wontfix` | ⚫ Gray | Não será corrigido |

## 🚀 Como Usar

### Para Criar uma Issue

1. Vá em "Issues" → "New issue"
2. Escolha um dos templates disponíveis
3. Preencha os campos obrigatórios (marcados com *)
4. Clique em "Submit new issue"

### Para Criar um PR

1. Faça push da sua branch
2. Abra um "New pull request"
3. Descreva as mudanças seguindo o template
4. Preencha o checklist
5. Clique em "Create pull request"

## 📖 Documentação

Para mais informações sobre como contribuir, consulte o [CONTRIBUTING.md](../CONTRIBUTING.md)

## 💡 Boas Práticas

### Títulos de Issues

Sempre use um emoji + título descritivo:

```
🐛 Erro ao carregar posts
🚀 Adicionar tema escuro
📋 Refatorar validação
```

### Descrição Estruturada

Use seções claras:

```markdown
## 📌 Descrição
[O quê?]

## 🎯 Objetivo
[Por quê? Qual problema resolve?]

## ✅ Tasks/Passos
- [ ] Passo 1
- [ ] Passo 2
```

### Labels Úteis

- Use **no mínimo 2 labels** por issue
- Sempre categorize por área (**backend**, **frontend**, etc)
- Use prioridade quando aplicável

## 🔧 Manutenção

Estes templates são mantidos pela equipe do projeto. Para sugestões de melhorias, abra uma discussion.
