---
title: Atualização de Factories e Seeders para Posts
date: 2026-03-09
description: Detalhamento das atualizações em PostSeeder e PostFactory para garantir 3 referências e 3 categorias por Post
---

# Atualização de Factories e Seeders

**Objetivo:** Garantir que todo post criado possua, no mínimo, 3 categorias e 3 referências de pesquisa atreladas a ele, conforme exigido.

## Arquivos Modificados
1. `database/seeders/PostSeeder.php`
2. `database/factories/PostFactory.php`

## Modificações Detalhadas

### 1. Atualização do `PostSeeder.php`
- Localizamos o bloco inicial (criação de 5 posts para o ID 1) e o bloco randômico (15 posts).
- Em ambos os lugares, as instâncias atreladas `has(PostReference::factory()->count(...))` foram configuradas com contagem **3**.
- Da mesma forma, as categorias de `has(PostCategory::factory()->count(...))` também passaram a exigir a contagem **3**.

### 2. Atualização da `PostFactory.php`
- Criamos e implementamos o método `configure()` que provê um gancho `afterCreating` para a instância base do modelo Post.
- Dentro deste _hook_, o código recupera dinamicamente as relações atreladas ao model `categories` e `references` no instante posterior a gravação do Post.
- Se a fábrica detectar que um Post foi instanciado possuindo um montante menor do que a regra preestabelecida de 3 relações, a fábrica utiliza suas respecitvas factories (`PostCategory::factory`, `PostReference::factory`) conectadas a função encadeadora interna `$post->saveMany(...)` na diferença da quantidade atual para preencher as eventuais lacunas restantes. 

## Resultados Esperados
- Qualquer instanciação via _seeders_, interações com o _tinker_, ou rotinas de teste garantem a construção correta de no mínimo 3 categorias e 3 referências para cada novo post criado.
- Nenhum bug de null-pointer deverá ocorrer na edição _frontend_ devido a falta de relações, pois elas são sempre supridas pela Factory.
