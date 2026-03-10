---
title: Remoção de Comentários em Português
date: 2026-03-10
description: Guia e relatório sobre a varredura e remoção de comentários em português em todo o projeto para padronização internacional.
---

# Relatório de Limpeza: Remoção de Comentários em Português

**Objetivo:** Padronizar a base de código removendo comentários escritos em português, mantendo apenas o código funcional e strings de interface/log destinadas ao usuário final ou integrações externas (Discord).

## Ações Realizadas

### 1. Varredura do Projeto
Foi realizada uma busca global (grep) utilizando expressões regulares para identificar caracteres especiais da língua portuguesa (`áéíóúâêîôûàèìòùãẽĩõũç`) dentro de blocos de comentário (`//`, `/*`, `*`).

### 2. Limpeza de Arquivos
Os seguintes arquivos foram identificados e limpos:

*   **`app/Http/Controllers/Web/Public/HomeProvisoryController.php`**: Removidos comentários sobre tratamento de strings de música, extração de artistas e lógica de banco de dados.
*   **`database/seeders/UserSeeder.php`**: Removidos comentários que descreviam a criação de administradores e usuários comuns.
*   **`database/seeders/OnairSeeder.php`**: Removidos comentários sobre regras de negócios para registros "In Air".
*   **`resources/js/app.js`**: Removidos comentários sobre registro de Service Worker e montagem da aplicação Svelte.

## Considerações de Preservação
Para garantir que a aplicação não perdesse funcionalidade ou contexto para o usuário final, os seguintes itens **NÃO** foram removidos:

*   **Mensagens para Discord**: Conteúdo de webhooks que notificam transmissões ao vivo.
*   **Exceções e Erros**: Mensagens de erro lançadas em `Exceptions` (ex: "Nenhuma música foi selecionada").
*   **Logs de Interface**: Mensagens que aparecem especificamente para o usuário no frontend ou logs operacionais de sistema que descrevem estados em português.

## Resultado Final
O código agora apresenta uma estética mais limpa e profissional, removendo redundâncias de explicação na língua nativa que podem ser interpretadas diretamente pela leitura do código limpo (Clean Code).
