import { useSelector } from "react-redux";
import { Navigate, Outlet } from "react-router-dom";

function AdminRoutes() {
  const user = useSelector(state => state.user);
  console.log(user);
  // outlet coponenete di react router dom che reindirizza alle rotte solo se l'utente è loggato, altrimenti reindirizza al login
  return user && user.role === "admin" ? <Outlet /> : <Navigate to="/login" />;
}
export default AdminRoutes;
