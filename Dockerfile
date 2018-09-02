FROM gcc
ADD . /code
WORKDIR /code
RUN gcc -o server server.c
CMD ["./server"]
