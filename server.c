/* credit @Daniel Scocco */

/****************** SERVER CODE ****************/

#include <unistd.h>
#include <stdio.h>
#include <netinet/in.h>
#include <string.h>
#include <sys/socket.h>
#include <arpa/inet.h>
#include <string.h>
#include <stdlib.h>
#define MAXSIZE 102400


int main(){
  int welcomeSocket, newSocket, num;
  char buffer[1024];
  char filedata[MAXSIZE];
  struct sockaddr_in serverAddr;
  struct sockaddr_storage serverStorage;
  socklen_t addr_size;

  /*---- Create the socket. The three arguments are: ----*/
  /* 1) Internet domain 2) Stream socket 3) Default protocol (TCP in this case) */
  welcomeSocket = socket(PF_INET, SOCK_STREAM, 0);

  /*---- Configure settings of the server address struct ----*/
  /* Address family = Internet */
  serverAddr.sin_family = AF_INET;
  /* Set port number, using htons function to use proper byte order */
  serverAddr.sin_port = htons(5432);
  /* Set IP address to localhost */
  serverAddr.sin_addr.s_addr = inet_addr("0.0.0.0");
  /* Set all bits of the padding field to 0 */
  memset(serverAddr.sin_zero, '\0', sizeof serverAddr.sin_zero);

  /*---- Bind the address struct to the socket ----*/
  bind(welcomeSocket, (struct sockaddr *) &serverAddr, sizeof(serverAddr));
  if(listen(welcomeSocket,5)==0)
    printf("I'm listening\n");
  else
    printf("Error\n");  /*---- Listen on the socket, with 5 max connection requests queued ----*/

  while(1){

    /*---- Accept call creates a new socket for the incoming connection ----*/
    addr_size = sizeof serverStorage;
    newSocket = accept(welcomeSocket, (struct sockaddr *) &serverStorage, &addr_size);

    while(1){
      // /*---- Listen on the socket, with 5 max connection requests queued ----*/
      num= recv(newSocket, buffer, 4,0);
      if(num<=0){
        printf("Connection Closed\n");
        break;
      }
      buffer[num] = '\0';
      printf("Query Recevied: %s\n", buffer );

      int i;
      for (i=0;i<4;i++){

        char image_name[20];
        char file_name[10];
        int image_count=0;
        if(i==0)
        {
            strcpy(image_name, "./images/A0.jpg");
            strcpy(file_name, "A0.jpg");
            image_count = buffer[0]-'0' ;
        }
        if(i==1)
        {
            strcpy(image_name, "./images/B0.jpg");
            strcpy(file_name, "B0.jpg");
            image_count = buffer[1]-'0';
        }
        if(i==2)
        {
            strcpy(image_name, "./images/C0.jpg");
            strcpy(file_name, "C0.jpg");
            image_count = buffer[2]-'0';
        }
        if(i==3)
        {
            strcpy(image_name, "./images/D0.jpg");
            strcpy(file_name, "D0.jpg");
            image_count = buffer[3]-'0';
        }

        int j;
        for( j = 0;j<image_count;j++)
        {
          image_name[10]++;
          file_name[1]++;

          FILE *picture;
          picture = fopen( image_name, "r");

          //Send Picture as Byte Array
          char send_buffer[MAXSIZE];
          fread(send_buffer, 1, sizeof(send_buffer), picture);
          printf("%s",send_buffer);

          if (( send(newSocket,send_buffer, sizeof(send_buffer),0) )== -1) {
              fprintf(stderr, "Failure Sending Data Message\n");
              close(newSocket);
              exit(-1);
          }
          else {
              printf("Image Sent Sucessfully: %s\n",send_buffer);
          }

          bzero(send_buffer, sizeof(send_buffer));
          int i[1];
          recv(newSocket, i, sizeof(int), 0);
        }
      }
    }
  }
  return 0;
}

