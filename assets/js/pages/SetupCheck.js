import React, { Component } from "react";
import ImageSVG from '../components/ImageSVG';
import ImageTechStack from '../../svg/techstack.svg';
import axios from "axios";

class SetupCheck extends Component {
  constructor() {
    super();
    this.state = { setupCheck: {}, loading: true };
  }

  getBaseUrl() {
    return "http://localhost";
  }

  componentDidMount() {
    this.checkApiSetup();
  }

  checkApiSetup() {
    const baseUrl = this.getBaseUrl();
    // const baseUrl = "http://localhost";
    axios
      .get(baseUrl + `/api/setup-check?testParam=1`)
      .then((response) => {
        let responseIsOK = response.data && response.data.testParam === 1;
        this.setState({ setupCheck: responseIsOK, loading: false });
      })
      .catch(function (error) {
        console.error(error);
        this.setState({ setupCheck: false, loading: false });
      });
  }

  render() {
    const loading = this.state.loading;
    return (
      <main>
        <section className="container-md">
          <div className="row mt-2">
            <div className="col col-md-8 mx-auto">
              <h2 className="text-center">
                <span>This is a test</span> @ Telemedi
              </h2>

              {loading ? (
                <div className={"text-center"}>
                  <span className="fa fa-spin fa-spinner fa-4x"></span>
                </div>
              ) : (
                <div className={"text-center"}>
                  {this.state.setupCheck === true ? (
                    <h3 className={"text-primary text-bold"}>
                      <strong>React app works!</strong>
                    </h3>
                  ) : (
                    <h3 className={"text-error text-bold"}>
                      <strong>React app doesn't work :(</strong>
                    </h3>
                  )}
                </div>
              )}
              <ImageSVG src={ImageTechStack} width={"100%"} height={"auto"} alt="techstack" />
            </div>
          </div>
        </section>
      </main>
    );
  }
}
export default SetupCheck;
