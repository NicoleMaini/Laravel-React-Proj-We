import axios from "axios";
import { useEffect, useState } from "react";
import { Button, Col, Container, Row } from "react-bootstrap";
import { useSelector } from "react-redux";

function DashboardCustomer() {
  const customer_id = useSelector(state => state.user.id);
  console.log(customer_id);

  const [iscriptions, setIscriptions] = useState(null);
  const [courses, setCourses] = useState(null);

  const allCourses = () => {
    axios.get("/api/v1/courses ").then(resp => setCourses(resp.data));
  };

  useEffect(() => {
    allCourses();
    axios.get("/api/v1/costumer-dashboard").then(resp => setIscriptions(resp.data));
  }, []);

  const subscribe = id => {
    axios.put(`api/v1/costumer-dashboard-requiered/${id}`);
    allCourses();
  };

  console.log("corsi", courses);
  console.log("Iscri", iscriptions);

  const buttonText = status => {
    switch (status) {
      case "true":
        return "Accepted";
      case "pending":
        return "Required send";
      case "false":
        return "Rejected";
      default:
        return "Courses close";
    }
  };

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
              <span key={i}>
                <li>
                  {course.activity.name} {course.id}
                </li>
                <Button
                  onClick={() => {
                    subscribe(course.course_id);
                  }}
                >
                  {course.users.some(user => user.user_id === customer_id)
                    ? course.users.map(user => user.user_id === customer_id && buttonText(user.status))
                    : "Subscribe"}
                </Button>
              </span>
            ))}
        </Col>
      </Row>
    </Container>
  );
}
export default DashboardCustomer;
