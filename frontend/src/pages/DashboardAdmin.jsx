import axios from "axios";
import { useEffect, useState } from "react";
import { Button, Container, Table } from "react-bootstrap";

function DashboardAdmin() {
  const [courses, setCourses] = useState([]);
  const [reload, setReload] = useState(true);

  useEffect(() => {
    axios.get("/api/v1/admin-dashboard").then(resp => setCourses(resp.data));
  }, [reload]);

  const accept = (customer_id, course_id) => {
    axios
      .put(`api/v1/admin-dashboard-accept/customer${customer_id}/course${course_id}`)
      .then(resp => setReload(!reload));
  };
  const reject = (customer_id, course_id) => {
    axios
      .put(`api/v1/admin-dashboard-reject/customer${customer_id}/course${course_id}`)
      .then(resp => setReload(!reload));
  };

  return (
    <>
      <h1 className="text-center">Courses</h1>
      <Container>
        <Table>
          <thead>
            <tr>
              <th>#</th>
              <th>User</th>
              <th>Genre</th>
              <th>Email</th>
              <th>Telephone</th>
              <th>Course</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            {courses.length >= 1 &&
              courses.map((course, i) => (
                <tr key={i}>
                  <td>{i}</td>
                  <td>{course.name}</td>
                  <td>{course.genre}</td>
                  <td>{course.email}</td>
                  <td>{course.telephone}</td>
                  <td>{course.courses[0].name}</td>
                  <td>
                    {course.courses[0].status === "true" ? (
                      <>
                        <span className="me-2">Admitted</span>
                        <Button variant="outline-danger" onClick={() => reject(course.id, course.courses[0].id)}>
                          Expel
                        </Button>
                      </>
                    ) : (
                      <>
                        <Button variant="success" onClick={accept}>
                          Accept
                        </Button>
                        <Button variant="outline-danger" onClick={reject}>
                          Reject
                        </Button>
                      </>
                    )}
                  </td>
                </tr>
              ))}
          </tbody>
        </Table>
      </Container>
    </>
  );
}
export default DashboardAdmin;
