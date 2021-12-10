FROM jjanzic/docker-python3-opencv
RUN apk update \
    apk add \
    build-base \
    postgresql \
    postgresql-dev \
    libpq
RUN mkdir /usr/src/app
WORKDIR /usr/src/app
COPY ./requirements.txt .
RUN pip install -r requirements.txt
ENV PYTHONUNBUFFERED 1
COPY . .