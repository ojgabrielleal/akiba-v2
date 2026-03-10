# Correção na Autoria de Atividades

**Data:** 09/03/2026
**Hora:** 21:17 (Horário de Brasília)
**Módulo Trabalhado:** Database / Seeders
**Título:** Restrição de autores no ActivitySeeder

## Resumo das Alterações
1.  **Restrição Administrativa em Activities**
    *   No `ActivitySeeder`, a geração dinâmica de autores aleatórios `User::inRandomOrder()->first()` para a model `Activity` foi removida.
    *   Foi consolidado a criação de múltiplas instâncias (15 registros) sendo todas apontadas estritamente para o usuário administrador principal (`User::find(1)`) por meio da diretiva `for()`.
    *   Isso garante que, a partir de agora, as atividades do painel preenchidas no seeding estejam unicamente correlacionadas à conta admin, atendendo aos novos critérios estipulados de visualização e manipulação de relatórios e painéis apenas pelo administrador.

## Resultado Final
✅ Nenhuma atividade extra será preenchida simulando outros usuários no banco de dados. Comando `php artisan migrate:fresh --seed` deverá gerar atividades puramente como admin.
