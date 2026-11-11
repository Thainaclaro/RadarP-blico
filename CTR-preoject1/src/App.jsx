
import { BrowserRouter, Route, Routes } from 'react-router-dom';

import { Login } from './components/Login';
import Cadastro from './components/Cadastro';
import Perfil from './components/Perfil';
import { Home } from './components/Home';
import Concursos from './components/Concursos';

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Login />} />
        <Route path="/Cadastro" element={<Cadastro />} />
        <Route path="/Perfil" element={<Perfil />} />
        <Route path="/Home" element={<Home />} />
        <Route path="/Concursos" element={<Concursos />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;

