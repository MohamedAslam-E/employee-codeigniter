import { BrowserRouter, Routes, Route } from "react-router-dom";
import Admin from "./pages/Admin";
import Employee from "./pages/employee";
import 'bootstrap/dist/css/bootstrap.min.css';
import UpdatePage from "./pages/UpdatePage";

function App() {
  return (
    <>
      <div>
        <BrowserRouter>
          <Routes>
            <Route index element={<Admin />} />
            <Route path="/admin" element={<Admin />} />
            <Route path="/employee" element={<Employee />} />
            <Route path="/update/:id" element={<UpdatePage />} />
          </Routes>
        </BrowserRouter>
      </div>
    </>
  );
}

export default App;
