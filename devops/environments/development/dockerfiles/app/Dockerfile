FROM ambientum/php:7.4-nginx

RUN sudo apk upgrade --update && sudo apk add \
  jpegoptim \
  optipng \
  pngquant \
  gifsicle \
  libwebp \
  libwebp-tools \
  nodejs \
  nodejs-npm

USER root
RUN npm install -g svgo
USER ambientum