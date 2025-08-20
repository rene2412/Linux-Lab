FROM ubuntu:20.04
ENV DEBIAN_FRONTEND=noninteractive

# Update & install essential packages including ttyd for web terminal
RUN apt update && apt install -y \
    sudo \
    bash \
    coreutils \
    vim \
    nano \
    curl \
    wget \
    net-tools \
    iputils-ping \
    traceroute \
    dnsutils \
    procps \
    htop \
    tree \
    grep \
    sed \
    gawk \
    findutils \
    tar \
    zip \
    unzip \
    man-db \
    less \
    locales \
    build-essential \
    && apt clean

# Install ttyd for web terminal
RUN curl -L https://github.com/tsl0922/ttyd/releases/download/1.7.3/ttyd.x86_64 -o /usr/local/bin/ttyd \
    && chmod +x /usr/local/bin/ttyd

# Set UTF-8 locale
RUN locale-gen en_US.UTF-8  
ENV LANG=en_US.UTF-8  
ENV LANGUAGE=en_US:en  
ENV LC_ALL=en_US.UTF-8  

# Set hostname
RUN echo "Linux-Lab" > /etc/hostname

# Set working directory to home
WORKDIR ~

# Set clean prompt with green color - show current directory
ENV PS1='\[\033[32m\]student@Linux-Lab:\w$ \[\033[0m\]'

# Create useful directories in home
RUN mkdir -p ~/Documents ~/Downloads ~/LinuxLab

# Create command logging script (commands only)
RUN echo '#!/bin/bash' > /usr/local/bin/log-command && \
    echo 'if [ -w /shared/command.txt ]; then' >> /usr/local/bin/log-command && \
    echo '    echo "$(date "+%Y-%m-%d %H:%M:%S") - PWD: $PWD - CMD: $*" >> /shared/command.txt' >> /usr/local/bin/log-command && \
    echo 'fi' >> /usr/local/bin/log-command && \
    chmod +x /usr/local/bin/log-command

# Create session logging script (commands + outputs)
RUN echo '#!/bin/bash' > /usr/local/bin/start-session && \
    echo 'cd ~' >> /usr/local/bin/start-session && \
    echo 'script -f -q /shared/output.txt bash --rcfile ~/.bashrc' >> /usr/local/bin/start-session && \
    chmod +x /usr/local/bin/start-session

# Set up command logging in bashrc, colored prompt, and ensure home directory
RUN echo 'cd ~' >> ~/.bashrc && \
    echo 'export PS1="\[\033[32m\]student@Linux-Lab:\w$ \[\033[0m\]"' >> ~/.bashrc && \
    echo 'trap '\''log-command "$BASH_COMMAND"'\'' DEBUG' >> ~/.bashrc

# Simple entrypoint to set hostname, initialize both log files, and ensure correct directory
RUN echo '#!/bin/bash' > /entrypoint.sh && \
    echo 'hostname Linux-Lab' >> /entrypoint.sh && \
    echo 'mkdir -p /shared' >> /entrypoint.sh && \
    echo 'touch /shared/command.txt /shared/output.txt' >> /entrypoint.sh && \
    echo 'chmod 666 /shared/command.txt /shared/output.txt' >> /entrypoint.sh && \
    echo 'cd ~' >> /entrypoint.sh && \
    echo 'exec "$@"' >> /entrypoint.sh && \
    chmod +x /entrypoint.sh

# Expose port 7681 for web terminal
EXPOSE 7681

# Use entrypoint and start ttyd with session logging for full output capture
ENTRYPOINT ["/entrypoint.sh"]
CMD ["ttyd", "-p", "7681", \
     "--client-option", "fontSize=14", \
     "--client-option", "fontFamily=Monaco,Consolas,monospace", \
     "--client-option", "theme={\"background\":\"#000000\",\"foreground\":\"#ffffff\",\"cursor\":\"#00ff00\"}", \
     "/usr/local/bin/start-session"]
