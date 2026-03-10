# Planejamento: Restrição de Cronogramas em Programas

## Objetivo
Garantir que apenas programas do tipo `private` possam ter cronogramas (`schedules`) associados.

## Alterações Propostas

1. **Factory `ProgramFactory`**:
    - Adicionar estado `private()` para garantir que programas criados com esse estado sejam do tipo `private`.

2. **Seeder `ProgramSeeder`**:
    - Ajustar a lógica para que apenas programas privados recebam cronogramas.

4. **Testes**:
    - Validar que programas `free` lançam exceção ao tentar adicionar cronogramas.
    - Validar que programas `private` funcionam normalmente.

## Cronograma
- Análise e Planejamento (Concluído)
- Implementação (Em andamento)
- Verificação e Relatório Final
