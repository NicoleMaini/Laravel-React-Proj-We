import axios from "axios";
import { useState } from "react";
import { Container } from "react-bootstrap";
import Button from "react-bootstrap/Button";
import Form from "react-bootstrap/Form";
import { useNavigate } from "react-router-dom";

function Register() {
  const navigate = useNavigate();

  const [formData, setFormData] = useState({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
  });

  const [errors, setErrors] = useState(null);

  const updateInputValue = e => {
    setFormData(oldData => ({
      ...oldData,
      [e.target.name]: e.target.value, //funzione singola per recuperare tutti i name dei value con i value
    }));
  };

  const submitLogin = e => {
    e.preventDefault();
    console.log(formData);

    axios
      .get("/sanctum/csrf-cookie")
      .then(resp => axios.post("/register", formData))
      .then(resp => {
        navigate("/login");
      })
      .catch(err => {
        setErrors(err.response.data.errors); //gestione degli errori - da implementare con l'interfaccia
      });
  };

  return (
    <Container>
      <Form onSubmit={e => submitLogin(e)} noValidate>
        <Form.Group className="mb-3" controlId="formBasicName">
          <Form.Label>Username</Form.Label>
          <Form.Control
            type="text"
            placeholder="Username"
            name="name"
            onChange={e => updateInputValue(e)}
            vlaue={formData.name}
          />
        </Form.Group>
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

        <Form.Group className="mb-3" controlId="formBasicConfirmPassword">
          <Form.Label>Confirm Password</Form.Label>
          <Form.Control
            type="password"
            placeholder="Confirm Password"
            name="password_confirmation" // come che laravel si aspetta di default
            onChange={e => updateInputValue(e)}
            vlaue={formData.password_confirmation}
          />
        </Form.Group>

        <Button variant="primary" type="submit">
          Submit
        </Button>
      </Form>
    </Container>
  );
}
export default Register;
