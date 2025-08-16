import React, { useEffect, useState, useMemo } from "react";
import CurrentRates from "../components/CurrentRates";
import HistoricalRates from "../components/HistoricalRates";
import TechStack from "../components/TechStack";
import { subDays, toYYYYMMDD } from "../utils";

const Home = () => {
  const rootElement = document.getElementById("root");

  const currencyCodes = useMemo(() => {
    return rootElement ? JSON.parse(rootElement.dataset.currencyCodes) : [];
  }, [rootElement]);

  const [currentRates, setCurrentRates] = useState([]);
  const [currentLoading, setCurrentLoading] = useState(true);
  const [currentError, setCurrentError] = useState(null);

  const [historicalRates, setHistoricalRates] = useState([]);
  const [historicalLoading, setHistoricalLoading] = useState(false);
  const [historicalError, setHistoricalError] = useState(null);

  useEffect(() => {
    if (currencyCodes.length === 0) {
      setCurrentLoading(false);
      return;
    }

    const fetchAll = async () => {
      try {
        const responses = await Promise.all(
          currencyCodes.map((code) =>
            fetch(`/api/currency?code=${code}`).then((res) => {
              if (!res.ok) {
                throw new Error(`HTTP error! status: ${res.status}`);
              }
              return res.json();
            })
          )
        );
        setCurrentRates(responses);
      } catch (err) {
        setCurrentError(err);
      } finally {
        setCurrentLoading(false);
      }
    };

    fetchAll();

    if (currencyCodes.length > 0) {
      fetchHistoricalRates(currencyCodes[0], toYYYYMMDD(new Date()));
    }
  }, [currencyCodes]);

  const fetchHistoricalRates = async (code, endDate) => {
    setHistoricalLoading(true);
    setHistoricalError(null);
    setHistoricalRates([]);

    try {
      const fetchedRates = [];
      let currentDate = new Date(endDate);
      let daysToCheck = 23;
      let ratesFound = 0;

      for (let i = 0; i < daysToCheck && ratesFound < 14; i++) {
        const formattedDate = toYYYYMMDD(currentDate);
        const res = await fetch(`/api/date?date=${formattedDate}&code=${code}`);

        if (res.ok) {
          const rate = await res.json();
          if (rate && rate.sell !== undefined && rate.sell !== null) {
            fetchedRates.push(rate);
            ratesFound++;
          }
        }

        currentDate = subDays(currentDate, 1);
      }

      setHistoricalRates(fetchedRates);
    } catch (err) {
      setHistoricalError(err);
    } finally {
      setHistoricalLoading(false);
    }
  };

  return (
    <>
      <main>
        <CurrentRates
          currencies={currentRates}
          loading={currentLoading}
          error={currentError}
          currencyCodes={currencyCodes}
        />
        <HistoricalRates
          currencyCodes={currencyCodes}
          onFetch={fetchHistoricalRates}
          historicalRates={historicalRates}
          loading={historicalLoading}
          error={historicalError}
        />
        <TechStack />
      </main>
    </>
  );
};

export default Home;
