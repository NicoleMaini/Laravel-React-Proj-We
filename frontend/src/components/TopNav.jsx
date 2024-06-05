import axios from "axios";
import Button from "react-bootstrap/Button";
import Container from "react-bootstrap/Container";
import Nav from "react-bootstrap/Nav";
import Navbar from "react-bootstrap/Navbar";
import NavDropdown from "react-bootstrap/NavDropdown";
import { useDispatch, useSelector } from "react-redux";
import { Link, useNavigate } from "react-router-dom";
import { LOGOUT } from "../redux/action";

function TopNav() {
  const user = useSelector(state => state.user);

  const dispatch = useDispatch();
  const navigate = useNavigate();

  console.log("sono lo user attuale", user);

  const logout = () => {
    axios
      .post("/logout")
      .then(() => dispatch({ type: LOGOUT }))
      .then(() => navigate("/login"));
  };

  return (
    <Navbar expand="lg" className="bg-body-tertiary">
      <Container fluid>
        <Link className="navbar-brand" to="/">
          Navbar scroll
        </Link>
        <Navbar.Toggle aria-controls="navbarScroll" />
        <Navbar.Collapse id="navbarScroll">
          <Nav className="mx-auto my-2 my-lg-0" style={{ maxHeight: "100px" }} navbarScroll>
            <Link to="/" className="nav-link">
              Home
            </Link>
            {user && (
              <NavDropdown title={user.name} id="navbarScrollingDropdown">
                {user.role === "admin" ? (
                  <>
                    <Link className="dropdown-item" to="/dasboard-admin">
                      Dashboard
                    </Link>
                    <Link className="dropdown-item">Courses</Link>
                    <NavDropdown.Divider />
                    <Link className="dropdown-item">Something else here</Link>
                  </>
                ) : user.role === "customer" ? (
                  <>
                    <Link className="dropdown-item" to="/dasboard-customer">
                      Dashboard
                    </Link>
                    <Link className="dropdown-item">Courses</Link>
                    <NavDropdown.Divider />
                    <Link className="dropdown-item">Something else here</Link>
                  </>
                ) : null}
              </NavDropdown>
            )}
          </Nav>
          {user ? (
            <>
              <Button variant="outline-danger" onClick={logout}>
                Logout
              </Button>
            </>
          ) : (
            <>
              <Link to="/login" className="btn btn-primary">
                Login
              </Link>
              <Link to="/register" className="btn btn-success">
                Sign Up
              </Link>
            </>
          )}
        </Navbar.Collapse>
      </Container>
    </Navbar>
  );
}

export default TopNav;
