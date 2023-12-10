import axios from "axios";
import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";

function UpdatePage() {
  let { id } = useParams();
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [image, setImage] = useState(null);

  const getDAta = async () => {
    try {
      await axios
        .get(`http://localhost:8080/show-employee/${id}`)
        .then((res) => {
          setName(res.data.data.name);
          setEmail(res.data.data.email);
          setImage(res.data.data.profile_image);
        });
    } catch (er) {
      console.log(er);
    }
  };
  const updateProduct = async (e) => {
    e.preventDefault();
    await axios
      .post(
        `http://localhost:8080/update-employee/${id}`,
        {
          name: name,
          email: email,
          profile_image: image,
          _method: "PUT",
        },
        { headers: { "Content-Type": "multipart/form-data" } }
      )
      .then((res) => console.log(res))
      .catch((res) => console.log(res));
    alert("employee added successful");
  };

  useEffect(() => {
    getDAta();
  }, []);

  const handleChange = (e) => {
    const file = e.target.files[0];
    setImage(file);
  };
  return (
    <div>
      <div className="col-8">
        <form onSubmit={updateProduct}>
          <div className="mb-3">
            <label className="form-label">Name</label>
            <input
              onChange={(e) => setName(e.target.value)}
              value={name}
              type="text"
              className="form-control"
            />
          </div>
          <div className="mb-3">
            <label className="form-label">Email</label>
            <input
              type="email"
              className="form-control"
              onChange={(e) => setEmail(e.target.value)}
              value={email}
            />
          </div>
          <div className="mb-3">
            <label className="form-label">choose profile image</label>
            <input
              className="form-control form-control-sm"
              type="file"
              onChange={handleChange}
            />
          </div>
          <button type="submit" className="btn btn-primary">
            Submit
          </button>
        </form>
      </div>
    </div>
  );
}
export default UpdatePage;
