import { useSelector } from "react-redux";
import { Navigate, Outlet } from "react-router-dom";

function UserRoutes() {
  const user = useSelector(state => state.user);

  // outlet coponenete di react router dom che reindirizza alle rotte solo se l'utente è loggato, altrimenti reindirizza al login
  return user ? <Outlet /> : <Navigate to="/login" />;
}
export default UserRoutes;
