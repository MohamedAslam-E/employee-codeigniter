import { Link } from "react-router-dom"

function SideBar() {
  return (
    <div className="col-md-3 col-lg-2 sidebar-offcanvas pl-0" id="sidebar" role="navigation" style={{backgroundColor:"#e9ecef"}}>
            <ul className="nav flex-column sticky-top pl-0 pt-5 p-3 mt-3 ">
                <li className="nav-item mb-2 "><Link className="nav-link text-secondary" to="/employee"><i className="fas fa-user font-weight-bold"></i> <span className="ml-3"> Add Employee</span></Link></li>
            </ul>
       </div>
  )
}

export default SideBar