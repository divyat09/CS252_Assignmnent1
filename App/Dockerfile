FROM gcc
FROM ubuntu
RUN apt-get update && apt-get install -y build-essential
COPY ./server.c /code/
COPY ./images/* /code/images/
WORKDIR /code/
RUN gcc -o server server.c
CMD ["./server"]
