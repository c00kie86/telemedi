import React from 'react';
import ImageSVG from './ImageSVG';
import ImageDocker from '../../svg/docker.svg';
import ImageNginx from '../../svg/nginx.svg';
import ImagePHP from '../../svg/php.svg';
import ImageNBP from '../../svg/nbp.svg';
import ImageSymfony from '../../svg/symfony.svg';
import ImageReact from '../../svg/react.svg';
import ImageBootstrap from '../../svg/bootstrap.svg';

const TechStack = () => {
  return (
    <>
      <section>
        <div className="container-md">
          <div className="row pt-2">
            <div className="col col-md-8 mx-auto">
              <h2 className="text-center"><span>Wsparcie</span> technologiczne</h2>
            </div>
          </div>
        </div>
        <div className="container-fluid bg-turbo">
          <div className="container-md">
            <div className="row">
              <div className="col col-md-8 d-flex justify-content-between align-items-center mx-auto gap-2 py-5">
                <ImageSVG className="tech-icon" src={ImageDocker} alt="docker" />
                <ImageSVG className="tech-icon" src={ImageNginx} alt="nginx" />
                <ImageSVG className="tech-icon" src={ImagePHP} alt="php" />
                <ImageSVG className="tech-icon" src={ImageNBP} alt="nbp" />
                <ImageSVG className="tech-icon" src={ImageSymfony} alt="symfony" />
                <ImageSVG className="tech-icon" src={ImageReact} alt="react" />
                <ImageSVG className="tech-icon" src={ImageBootstrap} alt="bootstrap" />
              </div>
            </div>
          </div>
        </div>
      </section>
    </>
  );
};

export default TechStack;