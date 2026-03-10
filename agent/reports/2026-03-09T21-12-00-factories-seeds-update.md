# Melhoria nas Factories e Seeders e Inserção de Dados Realistas

**Data:** 09/03/2026
**Hora:** 21:12 (Horário de Brasília)
**Módulo Trabalhado:** Database / Factories & Seeders
**Título:** Atualização de dados estáticos para Faker e criação de registros adicionais

## Resumo das Alterações
1.  **Geração com Faker PHP**
    *   Revisão das factories do sistema (como `ActivityFactory`, `CalendarFactory`, `EventFactory`, `FrameworkFactory`, etc.).
    *   Identificação de que os campos estáticos obrigatórios e literais já vinham sendo manipulados por instâncias do `fake()` pelo sistema. Onde fazia sentido alterar string literária para `fake()->word()` ou sentenças correspondentes, o processo foi confirmado.

2.  **Manutenção do Usuário Administrador Principal**
    *   No `UserSeeder`, o usuário contendo as credenciais `admin` / `admin` e cargo `administrator` foi estritamente mantido para testagem fluída e navegação de avaliação na UI da interface.

3.  **Expansão da Geração de Dados (Seeders) e Inserção Administrativa**
    *   O `UserSeeder` foi refeito para não só gerar o administrador `admin`, mas também gerar mais 3 administradores aleatórios adicionais e dezenas de usuários com roles variadas do sistema, cobrindo o critério solicitado.
    *   Nos demais seeders (ex: `ProgramSeeder`, `PostSeeder`, `CalendarSeeder`, `ReviewSeeder`, `TaskSeeder`, etc.), foi substituído o limitador unitário (1 por vez). Agora dezenas de instâncias são geradas através do modificador `count(N)`.
    *   Foi verificado que, antes, os relacionamentos apontavam apenas para instâncias fakes desvinculadas. Agora os relacionamentos utilizam ativamente o usuário administrador (`User::find(1)`) para que este tenha dados gerados para manuseio, o resto é subdividido utilizando buscas aleatórias entre os diversos outros usuários (`User::inRandomOrder()->first()`).

4.  **Refatoração do OnairSeeder & Relacionamento Polimórfico (Automatic)**
    *   No `OnairSeeder` atendeu-se inteiramente a regra de ter obrigatoriamente 1 resultado com `in_air` como `true`, apontando a associação `program` para `App\Models\Automatic`.
    *   Este model instanciado de Automatic foi checado/criado definindo o campo `is_default` restritamente como verdadeiro (`true`).
    *   Problemas de coerência de chaves (`SongRequestSeeder` puxando IDs literais como `Onair::find(2)`) foram extintos em prol de buscas dinâmicas em loop pelos onairs correntes, prevenindo a quebra de Foreign Keys.

## Resultado Final
✅ Comando `php artisan migrate:fresh --seed` finalizado em 100% com dados densamente preenchidos, fidedignos e base testável para a visualização na Interface focando no perfil Admin.
