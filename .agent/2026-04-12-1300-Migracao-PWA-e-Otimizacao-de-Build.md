# Migração PWA e Otimização de Build

Esta atualização focou na estruturação profissional do Progressive Web App (PWA) e na otimização da entrega de assets, resolvendo avisos de performance do Vite e garantindo uma base sólida para a instalação do aplicativo em dispositivos móveis.

## 1. Otimização do Build (Chunk Splitting)

O arquivo principal da aplicação (`app.js`) estava excedendo o limite recomendado de 500 kB, o que disparava avisos de performance durante o build e prejudicava o carregamento inicial.

- **Estratégia de Vendor**: Atualizado o `vite.config.js` para utilizar `manualChunks`. Agora, todas as dependências vindas do `node_modules` (como Quill, Axios, Svelte core) são automaticamente separadas em um arquivo `vendor.js`.
- **Resultados**: O bundle principal foi reduzido de ~547 kB para **184 kB**, melhorando a eficiência do cache do navegador e a velocidade de carregamento.

## 2. Implementação Profissional de PWA

A tentativa anterior de PWA (manual e incompleta) foi substituída por uma solução automatizada e robusta utilizando o plugin oficial do Vite.

- **Limpeza de Legado**: Removidos os arquivos manuais `public/manifest.json`, `public/sw.js` e a lógica de registro rudimentar que existia no `app.js`.
- **Integração com VitePWA**: Instalado e configurado o `vite-plugin-pwa` no `vite.config.js`. O plugin agora gerencia a geração do manifesto e do Service Worker (via Workbox) de forma automatizada durante o build.
- **Configuração de Manifesto**: Definido o `manifest.webmanifest` com metadados completos (nome, descrição, cores do tema) e caminhos para ícones maskable. O modo de atualização foi configurado para `autoUpdate`.

## 3. Ajustes de UI e Registro de Serviço

- **Componente Meta**: O `resources/js/config/Meta.svelte` foi atualizado para apontar para o novo arquivo de manifesto gerado pelo plugin.
- **Registro do SW**: O `resources/js/app.js` agora utiliza o módulo virtual `virtual:pwa-register` para realizar o registro imediato do Service Worker, garantindo que as funcionalidades de PWA estejam disponíveis assim que o usuário acessa o site.
- **Estruturas de Assets**: Criado o diretório `public/img/pwa/` para centralizar os ícones necessários para a instalação do app.

## 4. Próximos Passos Obrigatórios

Para que o PWA seja validado como instalável pelos navegadores (Chrome/Edge/Safari), é necessário:
- Adicionar os ícones `192.png` e `512.png` na pasta `public/img/pwa/`.
- Validar a instalação através do painel "Lighthouse" ou "Application" do DevTools.
