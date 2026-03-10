# Roteiro: Atualização de Factories e Seeders para Posts

**Objetivo:** Garantir que todo post criado pelas Factories e Seeders possua, no mínimo, 3 categorias e 3 referências de pesquisa atreladas a ele.

## Passos para execução:

1. **Atualizar `database/seeders/PostSeeder.php`**
   - No bloco que cria 5 posts para o autor principal:
     - Alterar geração de `PostReference` de 2 para **3**.
     - Alterar geração de `PostCategory` de 2 para **3**.
   - No bloco que cria 15 posts genéricos:
     - Alterar geração de `PostReference` de 1 para **3**.
     - Alterar geração de `PostCategory` de 2 para **3**.

2. **Atualizar `database/factories/PostFactory.php`**
   - Iremos sobrescrever/adicionar o método `configure()` da Factory.
   - Assim, criaremos um gancho `afterCreating` para verificar toda vez que um Post for gerado via Factory (por exemplo, dentro de testes automatizados ou na manipulação via Tinker).
   - O gancho irá verificar a quantidade de referências e categorias atreladas àquele post logo após ele ser criado no banco.
   - Qualquer Post que seja criado com menos de 3 referências ou menos de 3 categorias, receberá novos recortes adicionais gerados magicamente pela Factory até que totalizem 3 de cada.
   - Serão importadas as classes `PostCategory` e `PostReference` no topo do arquivo.

3. **Gerar Relatório em `agent/reports/`**
   - Criação de um `.md` chamado `post_factories_and_seeders_update.md` reportando o que foi mudado.

---
**Status:** Aguardando a aprovação do usuário para iniciar.
