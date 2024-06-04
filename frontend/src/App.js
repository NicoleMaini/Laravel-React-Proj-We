import { BrowserRouter, Navigate, Route, Routes } from "react-router-dom";
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
import NotFount from "./pages/NotFound";

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
            <Route path="/dasboard-admin" element={<DashboardAdmin />} />
          </Route>
          {/* rotte accessibili se NON sei loggato */}

          <Route element={<GuestRoutes />}>
            <Route path="/login" element={<Login />} />
            <Route path="/register" element={<Register />} />
          </Route>

          <Route path="/404-page-not-found" element={<NotFount />} />
          <Route path="*" element={<Navigate to="/404" />} />
          {/* per ovviare al problema che le pagine effettivamente esistenti non vengono catturate dal path '*' 
          
            <Route path="/404" element={<NotFound />} />
           
            useEffect(() => {
                fetch(`/api/v1/faculties/${id}`)
                .then((res) => {
                    if (!res.ok) navigate('/404');
                    return res.json();})
                .then((data) => setFaculty(data.data));
                }, [id]);

                con axios 
                catch (error) {
                  // Gestisci l'errore, ad esempio reindirizzando a /404
                  navigate('/404');
          */}
        </Routes>
      </BrowserRouter>
    )
  );
}

export default App;
