FROM gcc
COPY ./server.c /code/
COPY ./images/* /code/images/
WORKDIR /code/
RUN gcc -o server server.c
CMD ["./server"]
