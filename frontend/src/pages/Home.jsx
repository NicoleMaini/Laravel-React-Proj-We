import axios from "axios";
import { useEffect, useState } from "react";

function Home() {
  const [activities, setActivities] = useState(null);

  useEffect(() => {
    axios
      .get("/api/v1/activities")
      .then(resp => setActivities(resp.data))
      .catch(error => {
        console.error("Si è verificato un errore:", error);
      });
  }, []);

  console.log(activities);

  return (
    <>
      <h1>Ativities</h1>
      <ul> {activities && activities.map((activity, i) => <li key={i}>{activity.name}</li>)}</ul>
    </>
  );
}
export default Home;
