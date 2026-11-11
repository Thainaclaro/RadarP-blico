
import { useState } from "react";
import { useNavigate } from "react-router-dom";
import "../style/Login.css";

export function Login() {
  const navigate = useNavigate();
  const [email, setEmail] = useState("");
  const [senha, setSenha] = useState("");
  const [erro, setErro] = useState("");
  const [carregando, setCarregando] = useState(false);

  async function fazerLogin(event) {
    event.preventDefault();

    setErro("");
    setCarregando(true);

    try {
      const resposta = await fetch(
        "http://localhost:8000/api/usuarios/login.php",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          credentials: "include",
          body: JSON.stringify({ email, senha })
        }
      );

      const dados = await resposta.json();

      if (!resposta.ok) {
        throw new Error(dados.mensagem || "Erro ao entrar.");
      }

      navigate("/Home");

    } catch (error) {
      setErro(error.message);
    } finally {
      setCarregando(false);
    }
  }

  return (
    <main className="container">
      <div className="login-card">

        <h1>Login</h1>

        <form onSubmit={fazerLogin}>

          <div className="campo">
            <input
              type="email"
              name="email"
              placeholder="Digite seu e-mail"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              required
            />
          </div>

          <div className="campo">
            <input
              type="password"
              name="password"
              placeholder="Digite sua senha"
              value={senha}
              onChange={(e) => setSenha(e.target.value)}
              required
            />
          </div>

          {erro && <p>{erro}</p>}

          <input
            id="button-enviar"
            type="submit"
            value={carregando ? "Entrando..." : "Entrar"}
            disabled={carregando}
          />

        </form>

        <div className="links">
          <a href="#">Esqueci minha senha</a>
          <a href="/Cadastro">Criar uma conta</a>
        </div>

      </div>
    </main>
  );
}

