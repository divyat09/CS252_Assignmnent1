
/* credit @Daniel Scocco */

/****************** CLIENT CODE ****************/

#include <stdio.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <string.h>
#include <arpa/inet.h>
#define MAXSIZE 102400


#define SHELLSCRIPT "\
#/bin/bash \n\
firefox file1.html \n\
"


int main(int argc , char * argv[]){
  int clientSocket, num;
  char buffer[1024];
  char filedata[MAXSIZE];
  struct sockaddr_in serverAddr;
  socklen_t addr_size;

  char cats ='0' ,cars = '0',dogs = '0',trucks = '0';

  // printf("%d",strlen(argv[1]));

  int len = strlen(argv[1]);

  int i = 0;

  while(i<len)
  {
     if(argv[1][i]-'0'>=0 && argv[1][i]-'0'<=4)
     {
         char c = argv[1][i];
         i+=2;
         if(argv[1][i]=='t')
         {
            trucks = c;
         }
         if(argv[1][i]=='d')
         {
            dogs = c;
         }
         if(argv[1][i]=='c')
         {
           i+=2;
           if(argv[1][i]=='t')
           cats = c;
           else
           cars = c;
         }

     }
     i++;
  }

  buffer[0] = cars;
  buffer[1] = cats;
  buffer[2] = dogs;
  buffer[3] = trucks;

  /*---- Create the socket. The three arguments are: ----*/
  /* 1) Internet domain 2) Stream socket 3) Default protocol (TCP in this case) */
  clientSocket = socket(PF_INET, SOCK_STREAM, 0);

  /*---- Configure settings of the server address struct ----*/
  /* Address family = Internet */
  serverAddr.sin_family = AF_INET;
  /* Set port number, using htons function to use proper byte order */
  serverAddr.sin_port = htons(5432);
  /* Set IP address to localhost */
  serverAddr.sin_addr.s_addr = inet_addr("127.0.0.1");
   // Set all bits of the padding field to 0 
  memset(serverAddr.sin_zero, '\0', sizeof serverAddr.sin_zero);

  /*---- Connect the socket to the server using the address struct ----*/
  addr_size = sizeof serverAddr;
  connect(clientSocket, (struct sockaddr *) &serverAddr, addr_size);

  send(clientSocket,buffer,4,0);

  num = recv(clientSocket, filedata, sizeof(filedata), 0);
  if(num<=0){
    printf("Network Error\n");
    exit(-1);
  }
  filedata[num] = '\0';

  FILE *fptr;
  fptr = fopen("file1.jpeg","w+");
  fwrite(filedata, 1, strlen(filedata), fptr);
  fclose(fptr);
  printf(" Data: %s", filedata);

  // system(SHELLSCRIPT);

  /*---- Read the message from the server into the buffer ----*/
  // recv(clientSocket, buffer, 1024, 0);

  // buffer = "2 cars 3 dogs and 4 trucks";

  /*---- Print the received message ----*/

  // printf("Data received: %s",buffer);

  return 0;
}
