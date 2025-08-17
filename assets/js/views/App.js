// ./assets/js/components/App.js
import React from 'react';
import {Route, Switch} from 'react-router-dom';
import Header from '../layout/Header';
import Navbar from '../layout/Navbar';
import Footer from '../layout/Footer';
import Home from '../pages/Home';
import NotFound from '../pages/NotFound';
import SetupCheck from "../pages/SetupCheck";

const App = () => {
  return (
    <>

        <Navbar />
        <Header />
        <Switch>
          <Route exact path="/" component={Home} />
          <Route path="/setup-check" component={SetupCheck} />
          <Route component={NotFound} />
        </Switch>
        <Footer />
    </>
  );
}
export default App;