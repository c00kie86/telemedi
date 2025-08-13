import React, { useEffect, useState } from 'react';

const currencyCodes = ['EUR', 'USD', 'CZK', 'IDR', 'BRL'];

const Home = () => {
  const [currencies, setCurrencies] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchAll = async () => {
      try {
        const responses = await Promise.all(
          currencyCodes.map(code =>
            fetch(`http://localhost/api/currency?code=${code}`).then(res => res.json())
          )
        );
        setCurrencies(responses);
      } catch (err) {
        setError(err);
      } finally {
        setLoading(false);
      }
    };

    fetchAll();
  }, []);

  return (
    <main className="row-section">
      <section className="container">
        <div className="row mt-5">
          <div className="col-md-8 offset-md-2">
            <h2 className="text-center"><span>Aktualne kursy</span> walut</h2>
            {loading ? (
              <p className="text-center">Ładowanie danych...</p>
            ) : error ? (
              <p className="text-center text-danger">Błąd podczas pobierania danych</p>
            ) : (
              <table className="table table-bordered">
                <thead>
                  <tr>
                    <th>Kod</th>
                    <th>Nazwa</th>
                    <th>Średni kurs</th>
                    <th>Sprzedaż</th>
                    <th>Kupno</th>
                  </tr>
                </thead>
                <tbody>
                  {currencies.map((currencyData, index) => {
                    const rate = currencyData?.rates?.[0];
                    return rate ? (
                      <tr key={index}>
                        <td>{rate.code}</td>
                        <td>{rate.currency}</td>
                        <td>{rate.mid}</td>
                        <td>{rate.sell ?? '—'}</td>
                        <td>{rate.buy ?? '—'}</td>
                      </tr>
                    ) : (
                      <tr key={index}>
                        <td colSpan="5" className="text-center text-muted">Brak danych dla {currencyCodes[index]}</td>
                      </tr>
                    );
                  })}
                </tbody>
              </table>
            )}
          </div>
          <div className="col-md-8 offset-md-2">
            <h2 className="text-center"><span>Dodaj </span> walutę</h2>
            <p className="text-center">Pole dodania waluty:</p>
            <ul>
              <li>Określ kod waluty, różnicę sprzedaży oraz różnice kupna jeżeli dotyczy</li>
              <li>Waluta zostanie dodana do sekcji Aktualne Kursy</li>
            </ul>
          </div>
          <div className="col-md-8 offset-md-2">
            <h2 className="text-center"><span>Kurs historyczny</span> waluty</h2>
            <p className="text-center">Lista ostatnich 14 kursów danej waluty od podanej daty (domyślnie: USD, aktualna data):</p>
            <ul>
              <li>Pole wyboru (wybierz: walute, datę)</li>
            </ul>
          </div>
        </div>
      </section>
    </main>
  );
};

export default Home;