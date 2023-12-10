import { useState } from "react";
import Header from "../components/Header";
import SideBar from "../components/SideBar";
import { useEffect } from "react";
import axios from "axios";
import { Link } from "react-router-dom";

function Admin() {
  const [data, setData] = useState([]);

  useEffect(() => {
    fetchData();
  }, []);

  const fetchData = () => {
    axios.get("http://localhost:8080/list-employee").then((res) => {
      setData(res.data.data);
      console.log(data);
    });
  };

  const onDelete = async (id) => {
    if (id) {
      console.log(id);
      await axios.post(
        `http://localhost:8080/delete-employee/${id}`,
        {
          _method: "DELETE",
        },
        { headers: { "Content-Type": "multipart/form-data" } }
      );
      fetchData();
    } else {
      console.log("id is undefined");
      alert("id is undefined");
    }
  };

  return (
    <>
      <Header />
      <div className="container-fluid">
        <div className="row row-offcanvas row-offcanvas-left">
          <SideBar />
          <div className="col">
            <div className="col-12">
              <h5 className="mt-3 mb-3 text-secondary">
                Check More Records of Employees
              </h5>
              <div className="table-responsive">
                <table className="table table-striped">
                  <thead className="thead-light">
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>profile image</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    {data &&
                      data.map((item, index) => (
                        <tr key={index}>
                          <td>{item.id}</td>
                          <td>{item.name}</td>
                          <td>{item.email}</td>
                          <td>
                            {item.profile_image && (
                              <img
                                src={`http://localhost:8080${item.profile_image}`}
                                className="w-[50px]"
                                alt={`Profile of ${item.name}`}
                              />
                            )}
                          </td>
                          <td>
                            <button className="btn bg-primary">
                              <Link to={`/update/${item.id}`}>update</Link>
                            </button>
                            <button
                              onClick={() => onDelete(item.id)}
                              className="btn bg-danger"
                              type="submit"
                            >
                              delete
                            </button>
                          </td>
                        </tr>
                      ))}
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}

export default Admin;
