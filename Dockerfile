FROM debian:stable-slim

RUN apt-get update \
    && apt-get install -y git \
    && apt-get install -y git-ftp

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]