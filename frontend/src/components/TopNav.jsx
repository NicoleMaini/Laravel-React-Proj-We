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
          <Nav className="me-auto my-2 my-lg-0" style={{ maxHeight: "100px" }} navbarScroll>
            <Link to="/" className="nav-link">
              Home
            </Link>
            <NavDropdown title="Link" id="navbarScrollingDropdown">
              <Link className="dropdown-item">Action</Link>
              <Link className="dropdown-item">Another action</Link>
              <NavDropdown.Divider />
              <Link className="dropdown-item">Something else here</Link>
            </NavDropdown>
          </Nav>
          {user ? (
            <>
              <span className="me-2">{user.name}</span>
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
