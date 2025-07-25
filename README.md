# 🍽️ QuickMenu

**QuickMenu** é um sistema de cardápio online que permite restaurantes gerenciarem seus menus de forma dinâmica e digital, oferecendo uma experiência moderna para seus clientes via QR Code ou link.

---

## 🚀 Tecnologias Utilizadas

### Backend (API)
- [Laravel 12+](https://laravel.com/)
- PostgreSQL
- Docker / Docker Compose
- Xdebug (ambiente de desenvolvimento)
- Swagger (documentação da API)

### Frontend
- [Vue 3](https://vuejs.org/)
- [Vite](https://vitejs.dev/) (para build rápido)
- Axios (requisições HTTP)
- Pinia 
- PWA
- EM CONSTRUÇÃO 🚧

---

## 🧩 Funcionalidades Principais

- Cadastro de restaurantes
- Gerenciamento de cardápios e categorias
- Criação de pratos com descrição, imagem e preço
- Geração de QR Code para acesso rápido do cardápio
- Interface moderna para o cliente visualizar o menu

---

## ⚙️ Como rodar localmente

### Pré-requisitos

- Docker + Docker Compose
- Node.js (para o frontend)

### Passos

1. Clone a api:

   ```bash
   git clone https://github.com/seu-usuario/quickmenu.git
   ```
   ```bash
   cd quickmenu
   ```
   ```bash
   cp .env.example .env
   ```
   ```bash
   docker-compose up -d --build
   ```
   ```bash
   docker exec -it app-quickmenu-app composer install
   ```
   ```bash
   docker exec -it app-quickmenu-app php artisan key:generate
   ```
   ```bash
   docker exec -it app-quickmenu-app php artisan migrate
   ```
   ```bash
   docker exec -it app-quickmenu-app php artisan l5-swagger:generate
   ```


### Documentação api 
 
 [Swagger UI](http://localhost:8000/api/documentation)


