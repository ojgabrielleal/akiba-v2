# Labels Padrão do Akiba V2

Este documento define as labels usadas no repositório Akiba V2 e o propósito de cada uma.

## Tipo de Issue

| Label | Descrição | Cor |
|-------|-------------|-------|
| `bug` | Relato de erro ou comportamento inesperado | Vermelho |
| `enhancement` | Nova funcionalidade ou melhoria | Verde |
| `refactor` | Melhoria em código existente | Laranja |
| `documentation` | Adição ou melhoria de documentação | Azul |
| `security` | Problema de segurança | Vermelho |
| `performance` | Melhoria de performance | Amarelo |

## Área do Código

| Label | Descrição | Cor |
|-------|-------------|-------|
| `backend` | Alterações em PHP, Laravel ou API | Azul |
| `frontend` | Alterações em Svelte, JavaScript ou CSS | Roxo |
| `database` | Alterações em banco de dados, migrations ou seeders | Marrom |
| `devops` | Alterações em infraestrutura, CI ou deploy | Preto |

## Status

| Label | Descrição | Cor |
|-------|-------------|-------|
| `in-progress` | Trabalho em andamento | Laranja |
| `blocked` | Bloqueado por dependência, decisão ou informação faltante | Vermelho |
| `ready` | Pronto para desenvolvimento | Verde |
| `needs-review` | Aguardando revisão | Amarelo |
| `in-review` | Em revisão no momento | Amarelo |

## Prioridade

| Label | Descrição | Cor |
|-------|-------------|-------|
| `priority-critical` | Bloqueador ou produção quebrada | Vermelho |
| `priority-high` | Alta prioridade | Laranja |
| `priority-medium` | Média prioridade | Amarelo |
| `priority-low` | Baixa prioridade e pode aguardar | Verde |

## Comunidade

| Label | Descrição | Cor |
|-------|-------------|-------|
| `help-wanted` | Procurando ajuda de contribuidores | Amarelo |
| `good-first-issue` | Boa para uma primeira contribuição | Verde |
| `question` | Pergunta | Azul |
| `discussion` | Discussão aberta | Roxo |

## Decisões

| Label | Descrição | Cor |
|-------|-------------|-------|
| `duplicate` | Duplicada de outra issue | Cinza |
| `wontfix` | Não será corrigida | Cinza |
| `invalid` | Inválida ou incorreta | Cinza |
| `needs-more-info` | Precisa de mais informações | Amarelo |

## Como Usar Labels

Ao criar uma issue, inclua uma label de tipo, uma label de área, uma label de prioridade quando aplicável e labels adicionais conforme necessário.

Exemplo para uma nova funcionalidade de autenticação:

- `enhancement`
- `backend`
- `security`
- `priority-high`

Durante a revisão, atualize as labels conforme a issue avança: `ready` -> `in-progress` -> `needs-review` -> fechada.
