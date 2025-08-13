import React from 'react';
import { Link, withRouter } from 'react-router-dom';

const Navbar = ({ location }) => {
  const isActive = (path) => location.pathname === path;

  return (
    <>
      <nav className="navbar navbar-expand-lg navbar-dark bg-dark">
        <Link className="navbar-brand" to="/">Telemedi Zadanko</Link>
        <div id="navbarText">
          <ul className="navbar-nav mr-auto">
            <li className="nav-item">
              <Link
                className={`nav-link ${isActive('/') ? 'active' : ''}`}
                to="/"
              >
                Home
              </Link>
            </li>
            <li className="nav-item">
              <Link
                className={`nav-link ${isActive('/setup-check') ? 'active' : ''}`}
                to="/setup-check"
              >
                Setup Check
              </Link>
            </li>
          </ul>
        </div>
      </nav>
    </>
  );
};

export default withRouter(Navbar);