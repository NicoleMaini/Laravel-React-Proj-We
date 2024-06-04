import axios from "axios";
import { useEffect, useState } from "react";
import { Button, Col, Container, Row } from "react-bootstrap";

function DashboardCustomer() {
  const [iscriptions, setIscriptions] = useState(null);
  const [courses, setCourses] = useState(null);
  const [send, setSend] = useState(false);

  useEffect(() => {
    axios.get("/api/v1/courses ").then(resp => setCourses(resp.data));
    axios.get("/api/v1/costumer-dashboard").then(resp => setIscriptions(resp.data));
  }, []);

  const subscribe = id => {
    axios.put(`api/v1/costumer-dashboard-requiered/${id}`).then(resp => setSend(!send));
  };

  console.log("corsi", courses);
  console.log("Iscri", iscriptions);

  return (
    <Container>
      <Row className="w-100">
        <Col md={6}>
          <h2 className="text-center">Your iscription</h2>
        </Col>
        {/* {iscriptions && i} */}
        <Col md={6}>
          <h2 className="text-center">Open Course</h2>
          {courses &&
            courses.map((course, i) => (
              <>
                <li key={i}>
                  {course.activity.name} {course.id}
                </li>
                <Button
                  onClick={() => {
                    subscribe(course.id);
                  }}
                >
                  {send ? "Required send" : "Subscribe"}
                </Button>
              </>
            ))}
        </Col>
      </Row>
    </Container>
  );
}
export default DashboardCustomer;
