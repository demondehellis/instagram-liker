# Instagram Liker App

Simple automation app for Instagram daily actions. 

## Install

```
git clone git@github.com:demondehellis/instagram-liker.git
cd instagram-liker
docker-compose build
```

## Configure

```
# .env

# 'sessionId' instagram cookie from an authorized browser. 
INSTAGRAM_SESSION_ID=

# Stop tag liking after N iterations, 'false' for endless tag liking. 
INSTAGRAM_LIKES_PER_TAG=1
```

## Run

```
# Run all inside Docker
docker-compose up --abort-on-container-exit
```

## Endless Mode

```
# Enable 'endless' mode in .env
APP_RESTART="always"

# Run all inside Docker
docker-compose up

```