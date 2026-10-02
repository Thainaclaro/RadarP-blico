  import '../style/Login.css'

  export function Login(){
      return <> 

    <main class="container">

        <div class="login-card">

            <h1>Login</h1>

            <form action={""} method="Post">

                <div class="campo">
                    <input type="email" name="email" id="email" placeholder="Digite seu Email" required></input>
                </div>

                <div class="campo">
                    <input type="password" name="password" id="password" placeholder="Digite sua senha"required></input>
                </div>
                <input id="button-enviar"type="submit" value="Entrar"/>
            </form>

            <div class="links">
                <a href="#">Esqueci minha senha</a>
                <a href="/Cadastro">Criar uma conta</a>
            </div>

        </div>

    </main>

  </>
  }