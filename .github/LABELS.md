# 🏷️ Labels Padrão do Akiba v2

Este documento define todos os labels usados no repositório Akiba v2 e suas finalidades.

## 📋 Categorias de Labels

### 🔴 Tipo de Issue

| Label | Descrição | Cor |
|-------|-----------|-----|
| `bug` | Relatório de erro ou comportamento inesperado | 🔴 Red |
| `enhancement` | Nova funcionalidade ou melhoria | 🟢 Green |
| `refactor` | Melhoria de código existente | 🟠 Orange |
| `documentation` | Adição ou melhoria de documentação | 🔵 Blue |
| `security` | Problema de segurança | 🔴 Red |
| `performance` | Melhoria de performance | ⚡ Yellow |

### 🏗️ Área do Código

| Label | Descrição | Cor |
|-------|-----------|-----|
| `backend` | Mudanças em PHP/Laravel/API | 🔵 Blue |
| `frontend` | Mudanças em Vue/JavaScript/CSS | 🟣 Purple |
| `database` | Mudanças em banco de dados | 🟤 Brown |
| `devops` | Mudanças em infraestrutura/CI-CD | 🖤 Black |
| `documentation` | Melhorias em docs | 📘 Blue |

### ⚡ Status

| Label | Descrição | Cor |
|-------|-----------|-----|
| `in-progress` | Trabalho em andamento | 🟠 Orange |
| `blocked` | Bloqueada, aguardando algo | 🔴 Red |
| `ready` | Pronta para ser desenvolvida | 🟢 Green |
| `needs-review` | Aguardando revisão | 🟡 Yellow |
| `in-review` | Em processo de revisão | 🟡 Yellow |

### 🎯 Prioridade

| Label | Descrição | Cor |
|-------|-----------|-----|
| `priority-critical` | Bloqueador, produção quebrada | 🔴 Red |
| `priority-high` | Alta prioridade | 🟠 Orange |
| `priority-medium` | Prioridade média | 🟡 Yellow |
| `priority-low` | Baixa prioridade, pode esperar | 🟢 Green |

### 🤝 Comunidade

| Label | Descrição | Cor |
|-------|-----------|-----|
| `help-wanted` | Procurando ajuda de contribuidores | 🟡 Yellow |
| `good-first-issue` | Boa para primeiro contribuidor | 💚 Green |
| `question` | Dúvida ou pergunta | 🔵 Blue |
| `discussion` | Discussão aberta | 🟣 Purple |

### ❌ Decisões

| Label | Descrição | Cor |
|-------|-----------|-----|
| `duplicate` | Duplicata de outra issue | ⚫ Gray |
| `wontfix` | Não será corrigido | ⚫ Gray |
| `invalid` | Inválida ou incorreta | ⚫ Gray |
| `needs-more-info` | Precisa de mais informações | 🟡 Yellow |

## 📌 Como Usar Labels

### Ao Criar uma Issue

Sempre inclua:

1. **Um label de tipo**: `bug`, `enhancement`, `refactor`, `documentation`
2. **Um label de área**: `backend`, `frontend`, `database`, `devops`
3. **Um label de prioridade** (se aplicável): `priority-high`, `priority-medium`, etc
4. **Labels adicionais** conforme necessário

### Exemplo

Uma nova feature de autenticação deveria ter:
- `enhancement` (tipo)
- `backend` (área)
- `security` (tópico)
- `priority-high` (prioridade)

### Ao Revisar

Você pode atualizar labels conforme a issue progride:
- `ready` → `in-progress` → `needs-review` → fechada
- `blocked` quando há dependências

## 🎯 Gerenciando Labels

### Criar um novo label

Se um novo label for necessário:

1. Vá em Issues → Labels
2. Clique em "New label"
3. Use a convenção de nomenclatura do projeto
4. Adicione uma descrição clara
5. Escolha uma cor consistente

### Padrão de Cores

- 🔴 **Red (#d73a49)**: Crítico, bloqueador, erro
- 🟠 **Orange (#ffa500)**: Alto, em progresso
- 🟡 **Yellow (#ffd700)**: Médio, atenção
- 🟢 **Green (#28a745)**: Baixo, pronto
- 🔵 **Blue (#0366d6)**: Informativo (backend, documentação)
- 🟣 **Purple (#7b3ff2)**: Frontend
- 🖤 **Black (#000000)**: DevOps, infraestrutura
- ⚫ **Gray (#6f42c1)**: Inválido, não será corrigido

## 🔍 Buscando por Labels

Use labels para buscar e filtrar:

```
# Issues abertas de alta prioridade no backend
is:open label:backend label:priority-high

# Bugs que precisam de revisão
is:open label:bug label:needs-review

# Issues prontas para novo contribuidor
is:open label:good-first-issue label:ready

# Tudo bloqueado
is:open label:blocked
```

## 📝 Exemplos

### 🐛 Bug Report

Labels sugeridos:
- `bug`
- `backend` ou `frontend`
- `priority-high` ou `priority-medium`

### 🚀 Feature Request

Labels sugeridos:
- `enhancement`
- `backend` ou `frontend`
- `priority-medium` ou `priority-low`

### 🔧 Refactor

Labels sugeridos:
- `refactor`
- `backend` ou `frontend`
- `priority-low` (geralmente)

### 📚 Documentation

Labels sugeridos:
- `documentation`
- `help-wanted` (se for chamar contribuidores)

---

**Mantenha a consistência nos labels para melhor organização do projeto! 🎯**
