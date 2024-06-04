import axios from "axios";
import { useEffect, useState } from "react";

function DashboardAdmin() {
  const [courses, setCourses] = useState();

  useEffect(() => {
    axios.get("/api/v1/admin-dashboard").then(resp => setCourses(resp.data));
  }, []);
}
export default DashboardAdmin;
