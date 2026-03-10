# Planejamento: Refatoração da Sincronização de Cronogramas

## Objetivo
Implementar uma lógica robusta de sincronização para os cronogramas (`schedules`) de um programa no `RadioController`, permitindo adicionar, atualizar e remover itens em uma única requisição (Manual Sync).

## Alterações Propostas

1. **Controller `RadioController`**:
    - Refatorar o método `updateProgram` para processar o array `schedules`.
    - Identificar os UUIDs presentes na requisição para manter no banco.
    - Remover registros que não constam mais no array enviado pelo front-end.
    - Utilizar `updateOrCreate` para atualizar registros existentes ou criar novos.

## Cronograma
- Análise e Planejamento (Concluído)
- Implementação da Lógica de Sync (Concluído)
- Verificação e Documentação (Concluído)
