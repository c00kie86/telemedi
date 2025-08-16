import React from 'react';
import { Link, withRouter } from 'react-router-dom';

const Navbar = ({ location }) => {
  const isActive = (path) => location.pathname === path;

  return (
    <>
      <nav className="navbar navbar-expand-md navbar-dark fixed-top bg-primary">
        <section class="container-md">
          <Link className="navbar-brand mb-0 h1 text-white" to="/">€Kantorek</Link>
          <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span className="navbar-toggler-icon"></span>
          </button>
          <div className="navbar-collapse collapse" id="navbarText">
            <ul className="navbar-nav mr-auto">
              <li className="nav-item">
                <Link className={`nav-link ${isActive('/') ? 'active' : ''}`} to="/" aria-current="page"> Home</Link>
              </li>
              <li className="nav-item">
                <Link className={`nav-link ${isActive('/setup-check') ? 'active' : ''}`} to="/setup-check"> Setup Check</Link>
              </li>
            </ul>
          </div>
        </section>
      </nav>
    </>
  );
};

export default withRouter(Navbar);