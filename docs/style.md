# UI - Docs

## Container

Envolve o conteúdo centralizado na tela.

```html
<main class="container">
    ...
</main>
```

---

## Form

### Input simples

```html
<label for="email">Email</label>
<input type="email" name="email" id="email" placeholder="seu@email.com" required>
```

### Input com ícone

Use `.input-box` para inputs com ícone à direita (ex: toggle de senha).

```html
<div class="input-box">
    <input type="password" name="password" id="password" placeholder="Digite sua senha">
    <span id="toggle">
        <!-- svg aqui -->
    </span>
</div>
```

### Button

```html
<button type="submit">Entrar</button>
```

### Link

```html
<a href="/register">Não tem conta? Cadastre-se</a>
```