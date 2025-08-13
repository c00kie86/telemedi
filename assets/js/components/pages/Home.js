// ./assets/js/components/pages/Home.js
import React from 'react';

const Home = () => {
  return (
    <>
      <main className="row-section">
        <section className="container">
          <div className="row mt-5">
            <div className="col-md-8 offset-md-2">
              <h2 className="text-center"><span>Aktualne kursy</span> walut</h2>
              <p className="text-center">Listy bieżących kursów sprzedawanych walut:</p>
              <ul>
                <li>Kod waluty</li>
                <li>Nazwa waluty</li>
                <li>Średni kurs</li>
                <li>Kurs sprzedaży</li>
                <li>Kurs kupna (jeżli dotyczy)</li>
                <li>Edycja waluty ???</li>
              </ul>
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
    </>
  );
};

export default Home;
