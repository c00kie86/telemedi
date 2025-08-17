import React from "react";

const CurrentRates = ({ currencies, loading, error, currencyCodes }) => {
  return (
    <section className="container-md">
      <div className="row pt-2">
        <div className="col col-md-8 mx-auto">
          <h2 className="text-center"><span>Aktualne kursy</span> walut</h2>
          {loading ? (
            <p className="text-center">Ładowanie danych...</p>
          ) : error ? (
            <p className="text-center text-danger">Błąd podczas pobierania danych</p>
          ) : (
            <table className="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Code</th>
                  <th>Name</th>
                  <th>Sell</th>
                  <th>Buy</th>
                  <th>NPB</th>
                </tr>
              </thead>
              <tbody>
                {currencies.map((rate, index) => {
                  const code = currencyCodes[index];
                  return rate ? (
                    <tr key={rate.code}>
                      <td>{rate.code}</td>
                      <td>{rate.currency}</td>
                      <td>{rate.sell ?? ""}</td>
                      <td>{rate.buy ?? ""}</td>
                      <td>{rate.mid}</td>
                    </tr>
                  ) : (
                    <tr key={code}>
                      <td colSpan="5" className="text-center text-muted">Brak danych dla {code}</td>
                    </tr>
                  );
                })}
              </tbody>
            </table>
          )}
        </div>
      </div>
    </section>
  );
};

export default CurrentRates;
