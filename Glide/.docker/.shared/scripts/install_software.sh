#!/bin/sh

apt-get update -yqq && apt-get install -yqq \
    curl \
    dnsutils \
    gdb \
    git \
    htop \
    iproute2 \
    iputils-ping \
    make \
    procps \
    strace \
    sudo \
    sysstat \
    unzip \
    vim \
    wget \
;
