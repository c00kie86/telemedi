import React from 'react';
import LogoDefault from '../../svg/default.svg';

const ImageSVG = ({ src, alt = 'default', ...rest }) => {
  const path = src || LogoDefault;

  return (
    <>
      <img src={path} alt={alt} loading="lazy" {...rest} />
    </>
  );

};

export default ImageSVG;