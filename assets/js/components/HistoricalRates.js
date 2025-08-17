import React, { useState } from "react";
import { toYYYYMMDD } from "../utils";

const HistoricalRates = ({
  currencyCodes,
  onFetch,
  historicalRates,
  loading,
  error,
}) => {
  const [selectedCode, setSelectedCode] = useState(currencyCodes[0] || "USD");
  const [selectedDate, setSelectedDate] = useState(toYYYYMMDD(new Date()));

  const handleFetch = () => {
    if (selectedCode && selectedDate) {
      onFetch(selectedCode, selectedDate);
    }
  };

  return (
    <section className="container-md">
      <div className="row pt-2">
        <div className="col col-md-8 mx-auto">
          <h2 className="text-center"><span>Historia</span> kursów</h2>
          <div className="card p-4 bg-turbo">
            <div className="row justify-content-center align-items-end g-3">
              <div className="col-md-4 col-xs-auto mb-3">
                <label htmlFor="currency-select" className="form-label">Wybierz walutę:</label>
                <select
                  id="currency-select"
                  className="form-control"
                  value={selectedCode}
                  onChange={(e) => setSelectedCode(e.target.value)}
                >
                  {currencyCodes.map((code) => (
                    <option key={code} value={code}>{code}</option>
                  ))}
                </select>
              </div>
              <div className="col-md-4 col-xs-auto mb-3">
                <label htmlFor="date-select" className="form-label">
                  Wybierz datę początkową:
                </label>
                <input
                  id="date-select"
                  type="date"
                  className="form-control"
                  value={selectedDate}
                  onChange={(e) => setSelectedDate(e.target.value)}
                  max={toYYYYMMDD(new Date())}
                />
              </div>
              <div class="col-md-auto col-xs-auto mb-3">
                <button className="btn btn-primary rounded-4xl" onClick={handleFetch}>Pobierz dane</button>
              </div>
            </div>
          </div>
          <div class="table-responsive-md">
            {loading && <p className="text-center mt-3">Ładowanie danych...</p>}
            {error && (
              <p className="text-center text-danger mt-3">Błąd podczas pobierania danych historycznych.</p>
            )}
            {historicalRates.length > 0 && !loading && !error && (
              <table className="table table-bordered table-hover mt-3">
                <thead>
                  <tr>
                    <th scope="col">Code</th>
                    <th scope="col">Currency</th>
                    <th scope="col">Sell</th>
                    <th scope="col">Buy</th>
                    <th scope="col">NBP</th>
                    <th scope="col">Date</th>
                  </tr>
                </thead>
                <tbody>
                  {historicalRates.map((rate) => (
                    <tr key={rate.effectiveDate}>
                      <td>{rate.code}</td>
                      <td>{rate.currency}</td>
                      <td>{rate.sell ?? ""}</td>
                      <td>{rate.buy ?? ""}</td>
                      <td>{rate.mid}</td>
                      <td>{rate.effectiveDate}</td>
                    </tr>
                  ))}
                </tbody>
              </table>
            )}
          </div>
        </div>
      </div>
    </section>
  );
};

export default HistoricalRates;
