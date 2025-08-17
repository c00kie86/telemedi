import React from "react";

const Header = () => {
  return (
    <>
      <header>
        <section className="container-md">
          <div className="row pt-16">
            <div className="col col-md-8 mx-auto">
              <svg className="mb-4" viewBox="-345 -72 690 144">
                <title>Tabela wymiany walut | EKantorek</title>
                <desc>Czytelny i funkcjonalny interfejs do prezentacji danych dla pracowników kantoru wymiany walut</desc>
                <path d="M-345 -72 h 690 v 144 h -690 Z" fill="#eef6ff" />
                <text x="-231" y="25" font-size="96" fill="none" stroke="#111" stroke-width="1">Kantorek</text>
                <g transform="translate(0 0)">
                  <circle r="12" fill="#000" />
                  <g fill="none" stroke="#333">
                    <ellipse rx="55" ry="21" />
                    <ellipse rx="55" ry="21" transform="rotate(60, 0, 0)" />
                    <ellipse rx="55" ry="21" transform="rotate(120, 0, 0)" />
                  </g>
                  <g transform="rotate(0, 0, 0)">
                    <circle r="3" fill="#007bff" transform="translate(55)" />
                    <circle r="3" fill="#000" transform="translate(-55)" />
                  </g>
                  <g transform="rotate(30, 0, 0)">
                    <circle r="2" fill="#000" transform="translate(-21)" />
                    <circle r="1" fill="#007bff" transform="translate(21)" />
                  </g>
                  <g transform="rotate(60, 0, 0)">
                    <circle r="3" fill="#666" transform="translate(-55)" />
                    <circle r="6" fill="#666" transform="translate(55)" />
                  </g>
                  <g transform="rotate(90, 0, 0)">
                    <circle r="1" fill="#000" transform="translate(-21)" />
                    <circle r="4" fill="#007bff" transform="translate(21)" />
                  </g>
                </g>
                <text x="-336" y="-96" font-size="188" transform="skewY(-30)">&#8364;</text>
                <text x="40" y="80" font-size="48" transform="skewY(-30)" fill="#007bff">&#8383;</text>
                <text x="-64" y="-48" font-size="48" transform="skewY(-30)">&#8364;</text>
                <text x="32" y="-56" font-size="48" transform="skewY(30)">&#65284;</text>
                <text x="192" y="-64" font-size="192" transform="skewY(30)">&#65284;</text>
              </svg>
            </div>
          </div>
        </section>
      </header>
    </>
  );
}

export default Header;