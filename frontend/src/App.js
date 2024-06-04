import { BrowserRouter, Route, Routes } from "react-router-dom";
import "bootstrap/dist/css/bootstrap.min.css";
import "./App.css";
import Home from "./pages/Home";
import Login from "./pages/Login";
import Register from "./pages/Register";
import TopNav from "./components/TopNav";
import axios from "axios";
import { useEffect, useState } from "react";
import { useDispatch } from "react-redux";
import { LOGIN } from "./redux/action";
import UserRoutes from "./protectedRoutes/UserRoutes";
import GuestRoutes from "./protectedRoutes/GuestRoutes";
import DashboardAdmin from "./pages/DashboardAdmin";

function App() {
  const dispatch = useDispatch();
  const [loaded, setLoaded] = useState(false);
  // 2- importiamo axios - queste due linee servono per dire ad axios di settare il cookie col xsrftoken
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;

  // per evitare che al refrescare della pagina, react perda la 'connessione' redux e per tanto il login
  useEffect(() => {
    axios
      .get("/api/user")
      .then(resp =>
        dispatch({
          type: LOGIN,
          payload: resp.data,
        })
      )
      .catch(err => console.log("Utente non loggato", err))
      .finally(() => setLoaded(true));
  }, [dispatch]);

  return (
    loaded && (
      <BrowserRouter>
        <TopNav />
        <Routes>
          <Route path="/" element={<Home />} />

          {/* per proteggere le rotte, si possono fare rotte innestate */}

          {/* rotte accessibili se SEI loggato */}
          <Route element={<UserRoutes />}>
            <Route path="/dasboardAdmin" element={<DashboardAdmin />} />
          </Route>
          {/* rotte accessibili se NON sei loggato */}

          <Route element={<GuestRoutes />}>
            <Route path="/login" element={<Login />} />
            <Route path="/register" element={<Register />} />
          </Route>
        </Routes>
      </BrowserRouter>
    )
  );
}

export default App;
