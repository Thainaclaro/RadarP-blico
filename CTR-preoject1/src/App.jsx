import { BrowserRouter,Route, Routes } from 'react-router-dom'
import { Login } from './components/Login'
import Cadastro from './components/cadastro'


function App() {
  return (
     <BrowserRouter>
     <Routes>
        <Route path='/' element ={<Login />} />
        <Route path='/Cadastro' element={<Cadastro/>}/>
     </Routes> 
     </BrowserRouter>
  )
}

export default App
