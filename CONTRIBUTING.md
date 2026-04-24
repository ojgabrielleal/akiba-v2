# 🤝 Contribuindo para Akiba v2

Obrigado por considerar contribuir para Akiba v2! Este documento fornece orientações e instruções sobre como contribuir de forma efetiva.

## 📋 Índice

- [Como Reportar Bugs](#como-reportar-bugs)
- [Como Sugerir Melhorias](#como-sugerir-melhorias)
- [Criando uma Issue](#criando-uma-issue)
- [Padrões de Issues](#padrões-de-issues)
- [Pull Requests](#pull-requests)
- [Convensões de Código](#convenções-de-código)

## 🐛 Como Reportar Bugs

Ao reportar um bug, use o template **Bug Report**. Forneça:

1. **Título claro**: Comece com um emoji (🐛) e descreva o problema sucintamente
   - ✅ `🐛 Erro ao carregar posts na página inicial`
   - ❌ `Algo não funciona`

2. **Descrição detalhada**: Explique o que está acontecendo

3. **Passos para reproduzir**: Liste os passos exatos para replicar o bug

4. **Comportamento esperado**: O que deveria acontecer

5. **Comportamento atual**: O que está acontecendo ao invés

6. **Informações do ambiente**:
   - Navegador e versão
   - Sistema operacional
   - PHP/Laravel versão (se backend)
   - Node.js versão (se frontend)

### Exemplo de Bug Report Bem-Feito

```
Título: 🐛 Erro ao filtrar podcasts por categoria

Descrição:
Quando filtro podcasts por categoria, a página retorna erro 500.

Passos para Reproduzir:
1. Acesse /podcasts
2. Clique no filtro "Categoria"
3. Selecione "Drama"
4. Observe erro na página

Comportamento Esperado:
Deve exibir apenas podcasts da categoria Drama

Comportamento Atual:
Erro 500 - Internal Server Error
```

## ✨ Como Sugerir Melhorias

Use o template **Feature Request** para sugerir novas funcionalidades.

1. **Título com emoji**: Descreva brevemente a feature
   - ✅ `🎨 Adicionar tema escuro à interface`
   - ❌ `Feature nova`

2. **Descrição**: O que é a nova funcionalidade

3. **Objetivo**: Por que é necessária

4. **Benefícios**: Qual valor agrega

5. **Informações adicionais**: Sketches, exemplos, referências

## 📝 Criando uma Issue

Você pode criar uma issue de 5 formas:

### 1. **Bug Report** 🐛
Use quando encontrar um comportamento inesperado ou erro.

### 2. **Feature Request** 🚀
Use para sugerir novas funcionalidades ou melhorias.

### 3. **Task** 📋
Use para tarefas gerais de desenvolvimento ou manutenção.

### 4. **Refactor** 🔧
Use para melhorias de código, performance ou arquitetura.

### 5. **Documentation** 📚
Use para adicionar ou melhorar documentação.

### 6. **Issue em Branco**
Use se nenhum template se adequar (menos recomendado).

## 🏷️ Padrões de Issues

### Títulos

Sempre comece com um emoji relevante:

- 🐛 **Bug**: Erros ou comportamentos inesperados
- 🚀 **Feature**: Novas funcionalidades
- 📋 **Task**: Tarefas gerais
- 🔧 **Refactor**: Melhorias de código
- 📚 **Documentation**: Documentação
- 🎨 **UI/Design**: Mudanças visuais
- ⚡ **Performance**: Otimizações
- 🔒 **Security**: Problemas de segurança
- 🚨 **Urgent**: Issues críticas

### Descrição

Estruture as issues com seções claras:

```markdown
## 📌 Descrição
[Descrição clara do que é a issue]

## 🎯 Objetivo
[O que isso resolve ou melhora?]

## ✅ Tasks (para features/tasks)
- [ ] Tarefa 1
- [ ] Tarefa 2
- [ ] Tarefa 3

## 📝 Notas Adicionais
[Contexto extra, links, etc.]
```

### Labels

Use labels apropriados:

- **backend**: Mudanças no código backend (PHP/Laravel)
- **frontend**: Mudanças no código frontend (Vue/JavaScript)
- **documentation**: Melhorias na documentação
- **enhancement**: Nova feature ou melhoria
- **bug**: Relatório de bug
- **refactor**: Refatoração de código
- **help wanted**: Procurando ajuda
- **wontfix**: Não será corrigido
- **duplicate**: Duplicata de outra issue

## 🚀 Pull Requests

Ao criar um PR:

1. **Vincule a issue**: Use "Closes #123" na descrição
2. **Descreva as mudanças**: O que foi mudado e por quê
3. **Adicione testes**: Se aplicável
4. **Atualize documentação**: Se necessário
5. **Siga os padrões de código**: Veja seção abaixo

### Exemplo de PR

```markdown
## 🎯 Objetivo
Resolve #123 - Adicionar filtro por categoria em podcasts

## 📝 O que mudou?
- Adicionado componente de filtro em PodcastIndex.vue
- Criado método filterByCategory() no PodcastController
- Adicionados testes unitários

## ✅ Checklist
- [x] Testes passam
- [x] Documentação atualizada
- [x] Sem erros de lint
- [x] Testado localmente
```

## 📋 Convenções de Código

### Backend (PHP/Laravel)

- Use PSR-12 para style guide
- Nomes em inglês (variáveis, métodos, classes)
- Use type hints
- Sempre valide inputs
- Use controllers slim, use services para lógica

```php
// ✅ Bom
class PostController extends Controller
{
    public function __construct(private PostService $service) {}
    
    public function store(StorePostRequest $request): JsonResponse
    {
        $post = $this->service->create($request->validated());
        return response()->json($post, 201);
    }
}

// ❌ Ruim
class PostController extends Controller
{
    public function store(Request $request) {
        $post = Post::create($request->all());
        return $post;
    }
}
```

### Frontend (Vue/JavaScript)

- Use PascalCase para componentes
- Use camelCase para variáveis/métodos
- Use const em vez de let/var
- Adicione PropTypes (se não usar TypeScript)
- Mantenha componentes pequenos e reutilizáveis

```vue
<!-- ✅ Bom -->
<template>
  <div class="podcast-card">
    <h2>{{ podcast.title }}</h2>
    <p>{{ truncate(podcast.description, 100) }}</p>
  </div>
</template>

<script setup>
const props = defineProps({
  podcast: {
    type: Object,
    required: true
  }
});

const truncate = (str, len) => str.length > len ? str.slice(0, len) + '...' : str;
</script>
```

### Commits

Use mensagens claras e em inglês:

```bash
# ✅ Bom
git commit -m "feat: add podcast filter by category"
git commit -m "fix: resolve 500 error on category filter"
git commit -m "refactor: extract duplicate code from controllers"
git commit -m "docs: update API documentation"

# ❌ Ruim
git commit -m "fix"
git commit -m "updating stuff"
git commit -m "asdfgh"
```

## 🆘 Precisa de Ajuda?

- 💬 Abra uma **Discussion** para perguntas
- 📖 Confira a **Documentação**
- 🐦 Siga no Twitter para atualizações

---

**Obrigado por contribuir! Você é incrível! 🎉**
