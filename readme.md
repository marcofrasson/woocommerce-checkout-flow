# WooCommerce Checkout Flow

**Contributors:** marcofrasson, luizbills, juliomaraschin

**Donate link:** https://goflow.digital

**Tags:** checkout, register, woocommerce

**Requires at least:** 4.0

**Tested up to:** 5.0

**Stable tag:** 1.0.1

**Requires PHP:** 5.6

**License:** GPLv3 or later

**License URI:** http://www.gnu.org/licenses/gpl-3.0.html

Add step at checkout to register or login user on WooCommerce

## Description

Adicione um passo no checkout para registrar ou logar o usuário no WooCommerce.

Veja a [demonstração](https://goflow.digital/demo/woocommerce-checkout-flow/) ao vivo com o tema Storefront.

**Recursos**

Os seguintes recursos estão presentes nesse plugin:

* Novo cadastro automático do usuário via ajax
* Envio de senha e outros detalhes via email
* Recuperação de senha facilitada com login e redirecionamento para o checkout via ajax
* Configuração de remoção de mensagens de confirmação
* Configuração de Classe CSS personalizada para o campo e-mail
* Configuração de mensagens customizadas:
  * Mensagem da confirmação de recuperação de senha
  * Mensagem da confirmação de novo cadastro
  * Mensagem de confirmação de e-mail já cadastrado
  * Mensagem recebida por e-mail da confirmação de novo cadastro
  * Mensagem de erro ao tentar fazer login
  * Mensagem de login efetuado com sucesso
  * Mensagem recebida por e-mail da solicitação de redefinição de senha
  * Mensagem de confirmação da redefinição de senha
  * Descrição do formulário de autenticação por e-mail

**Instalação:**

Confira o nosso guia de instalação e configuração na aba [Installation](http://wordpress.org/extend/plugins/woocommerce-checkout-flow/installation/).

**Compatibilidade**

Requer WooCommerce 3.0 ou posterior para funcionar.

**Dúvidas?**

Você pode esclarecer suas dúvidas usando:

- A nossa sessão de [FAQ](http://wordpress.org/extend/plugins/woocommerce-checkout-flow/faq/).
- Utilizando o nosso [fórum no Github](https://github.com/marcofrasson/woocommerce-checkout-flow).
- Criando um tópico no [fórum de ajuda do WordPress](http://wordpress.org/support/plugin/woocommerce-checkout-flow).

## Installation

**Instalação do plugin:**

- Envie os arquivos do plugin para a pasta wp-content/plugins, ou instale usando o instalador de plugins do WordPress.
- Ative o plugin.

**Requerimentos:**

- Requer WooCommerce 3.0 ou posterior para funcionar.
- PHP 5.6 ou superior.

**Configurações do plugin:**

Para configurar algumas mensagens, acessar a aba do "WooCommerce" > "Configurações" > "Avançado" > "WC Checkout Flow"

## Frequently Asked Questions

**Qual é a licença do plugin?**
Este plugin esta licenciado como GPL.

**O que eu preciso para utilizar este plugin?**
WooCommerce 3.0 ou posterior.

**Consigo alterar as mensagens de confirmação e erros?**
Sim, só acessar a aba do "WooCommerce" > "Configurações" > "Avançado" > "WC Checkout Flow"

**Consigo adicionar uma classe no campo do email?**

Sim, só acessar a aba do "WooCommerce" > "Configurações" > "Avançado" > "WC Checkout Flow"

**Consigo remover as mensagens de confirmação?**
Sim, só acessar a aba do "WooCommerce" > "Configurações" > "Avançado" > "WC Checkout Flow"

**E se o usuário não receber o email da senha ou recuperação de senha?**
Utilizamos o padrão construído pelo próprio WooCommerce e WordPress e desas forma o envio dos email será feito com o serviço de SMTP do seu host. Não alteramos essa funcionalidade padrão.

**Após colocar o email, não consigo avançar na próxima página?**
Utilizamos AJAX e Javascript entre os passos que usuário fará, por esse motivo, você deverá verificar se existe alguma incomptabilidade com o seu tema, plugins ou cache do seu servidor.

**Consigo criar automações de recuperação de carrinho com esse plugin?**
Não, porque não faz parte do escopo deste plugin. Mas você poderá usar outros plugins ou sistemas que tenham essa função e adicionar uma classe ao campo do email.

## Screenshots

### 1. Tela inicial do checkout com o campo de email para login ou cadastro. ###
![Tela inicial do checkout com o campo de email para login ou cadastro.](http://ps.w.org/woocommerce-checkout-flow/assets/screenshot-1.png)

### 2. Mensagem por 5 segundos de que foi criado um novo cadastro para o usuário e será redirecionado aos campos padrão do  checkout. ###
![Mensagem por 5 segundos de que foi criado um novo cadastro para o usuário e será redirecionado aos campos padrão do  checkout.](http://ps.w.org/woocommerce-checkout-flow/assets/screenshot-1.png)

### 3. Já é feito login automático nesse novo cadastro e preenchido o campo do email nos detalhes de cobrança. ###
![Já é feito login automático nesse novo cadastro e preenchido o campo do email nos detalhes de cobrança.](http://ps.w.org/woocommerce-checkout-flow/assets/screenshot-1.png)

### 4. Email enviado com a senha do novo cadastro e instruções. ###
![Email enviado com a senha do novo cadastro e instruções.](http://ps.w.org/woocommerce-checkout-flow/assets/screenshot-1.png)

### 5. Caso o usuário já tenha conta, será solicitado o campo da senha para logar. ###
![Caso o usuário já tenha conta, será solicitado o campo da senha para logar.](http://ps.w.org/woocommerce-checkout-flow/assets/screenshot-1.png)

### 6. Mensagem que aparece ao clicar em redefinir senha. ###
![Mensagem que aparece ao clicar em redefinir senha](http://ps.w.org/woocommerce-checkout-flow/assets/screenshot-1.png)

### 7. Email enviado com o link para redefinir a nova senha desse usuário. ###
![Email enviado com o link para redefinir a nova senha desse usuário.](http://ps.w.org/woocommerce-checkout-flow/assets/screenshot-1.png)

### 8. Link é redirecionado ao site com os campos para digitar a nova senha com mínimo de 8 caracteres. ###
![Link é redirecionado ao site com os campos para digitar a nova senha com mínimo de 8 caracteres.](http://ps.w.org/woocommerce-checkout-flow/assets/screenshot-1.png)

### 9. Mensagem de que foi alterada a senha e será redirecionado aos campos padrão do checkout já com o usuário logado. ###
![Mensagem de que foi alterada a senha e será redirecionado aos campos padrão do checkout já com o usuário logado.](http://ps.w.org/woocommerce-checkout-flow/assets/screenshot-1.png)

### 10. Página de configurações do plugin. ###
![Página de configurações do plugin.](http://ps.w.org/woocommerce-checkout-flow/assets/screenshot-1.png)

## Changelog

**1.0.1 - 2019/04/04**
* Pequenos bug fixes.

**1.0.0 - 2019/04/04**
* Lançamento do plugin.

## Upgrade Notice
**1.0.0 - 2019/04/04**
* Lançamento do plugin.
