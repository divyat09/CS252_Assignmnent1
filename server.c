/* credit @Daniel Scocco */

/****************** SERVER CODE ****************/

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
  serverAddr.sin_addr.s_addr = inet_addr("127.0.0.1");
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
        printf("Network Error\n");
        break;
      }
      buffer[num] = '\0';
      printf("Message Recevied: %s\n", buffer );

      int i;
      for (i=0;i<4;i++){

        char image_name[10];
        int image_count=0;
        if(i==0)
        {
            strcpy(image_name, "A0.jpg");
            image_count = buffer[0]-'0' ;
        }
        if(i==1)
        {
            strcpy(image_name, "B0.jpg");
            image_count = buffer[1]-'0';
        }
        if(i==2)
        {
            strcpy(image_name, "C0.jpg");
            image_count = buffer[2]-'0';
        }
        if(i==3)
        {
            strcpy(image_name, "D0.jpg");
            image_count = buffer[3]-'0';
        }

        // int x = buffer[i]-'0';
        // int y = 65+i;
        // char c = y; 
        int j;
        for( j = 0;j<image_count;j++)
        {
          image_name[1]++;

        // while(x>0){
          // printf("%d %d\n",x, i);
          // char FileName[2];
          // FileName[0]= c;
          // FileName[1]= x+'0';
          printf("FileName: %s\n", image_name );
          printf("Getting Picture Size\n");
          FILE *picture;
          picture = fopen( image_name, "r");
          int size;
          fseek(picture, 0, SEEK_END);
          size = ftell(picture);
          fseek(picture, 0, SEEK_SET);
          //Send Picture Size
          printf("Sending Picture Size\n");
          printf("PICTURE SIZE %d\n",size);
          //write(sock, &size, sizeof(size));
          
          if (( send(newSocket,&size,sizeof(size),0) )== -1) {
              fprintf(stderr, "Failure Sending Size Message\n");
              close(newSocket);
              exit(-1);
          }
          else {
              printf("Message being sent Size : %d\n",size);
          }

          //Send Picture as Byte Array
          printf("Sending Picture as Byte Array\n");
          char send_buffer[size];
          while(!feof(picture)) {
              fread(send_buffer, 1, sizeof(send_buffer), picture);
              printf("%s",send_buffer);
              //write(sock, send_buffer, sizeof(send_buffer));

              if (( send(newSocket,send_buffer, sizeof(send_buffer),0) )== -1) {
                  fprintf(stderr, "Failure Sending Data Message\n");
                  close(newSocket);
                  exit(-1);
              }
              else {
                  printf("Message being sent Data: %s\n",send_buffer);
              }

              bzero(send_buffer, sizeof(send_buffer));
          }
        }
      }
    }
  }
  return 0;
}

