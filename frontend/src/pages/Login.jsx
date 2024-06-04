import axios from "axios";
import { useState } from "react";
import { Container } from "react-bootstrap";
import Button from "react-bootstrap/Button";
import Form from "react-bootstrap/Form";
import { useDispatch } from "react-redux";
import { LOGIN } from "../redux/action";

function Login() {
  const dispatch = useDispatch();

  const [formData, setFormData] = useState({
    email: "",
    password: "",
  });

  const updateInputValue = e => {
    setFormData(oldData => ({
      ...oldData,
      [e.target.name]: e.target.value, //funzione singola per recuperare tutti i name dei value con i value
    }));
  };

  const submitLogin = e => {
    e.preventDefault();
    console.log(formData);
    // serve per recuperare il token per poter far loggare l'utente
    // all'interno della seconda fetch, quella al login, per passare il csrf token bisogna scrivere, nell'headers
    // 'X-XSRF-TOKEN': getCookie('XSRF-TOKEN')
    axios
      .get("/sanctum/csrf-cookie")
      .then(resp => axios.post("/login", formData)) //sarà il terzo argomento che conterrà gli header, ma come in questo caso, dato che ci servono globalmente, gli diciamo di farlo globalmente: 1-andare in app-js
      .then(() => axios.get("/api/user"))
      .then(resp =>
        dispatch({
          type: LOGIN,
          payload: resp.data,
        })
      )
      .catch(error => {
        console.error("Si è verificato un errore:", error);
      });
  };

  return (
    <Container>
      <Form onSubmit={e => submitLogin(e)} noValidate>
        <Form.Group className="mb-3" controlId="formBasicEmail">
          <Form.Label>Email address</Form.Label>
          <Form.Control
            type="email"
            placeholder="Enter email"
            name="email"
            onChange={e => updateInputValue(e)}
            vlaue={formData.email}
          />
          <Form.Text className="text-muted">We'll never share your email with anyone else.</Form.Text>
        </Form.Group>

        <Form.Group className="mb-3" controlId="formBasicPassword">
          <Form.Label>Password</Form.Label>
          <Form.Control
            type="password"
            placeholder="Password"
            name="password"
            onChange={e => updateInputValue(e)}
            vlaue={formData.password}
          />
        </Form.Group>

        <Button variant="primary" type="submit">
          Submit
        </Button>
      </Form>
    </Container>
  );
}

export default Login;
