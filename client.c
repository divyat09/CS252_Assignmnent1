
/* credit @Daniel Scocco */

/****************** CLIENT CODE ****************/

#include <stdio.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <string.h>
#include <arpa/inet.h>
#include <stdlib.h>
int main(){
  int clientSocket;
  char buffer[1024];
  struct sockaddr_in serverAddr;
  socklen_t addr_size;
  char buffer1[1024];
  char file_name[50];  
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
  /* Set all bits of the padding field to 0 */
  memset(serverAddr.sin_zero, '\0', sizeof serverAddr.sin_zero);

  /*---- Connect the socket to the server using the address struct ----*/
  addr_size = sizeof serverAddr;
  connect(clientSocket, (struct sockaddr *) &serverAddr, addr_size);
  //printf("Enter you message to send\n");
  //scanf("%s", &buffer1[0]);
  //send(clientSocket, buffer1, 1024, 0);
  /*---- Read the message from the server into the buffer ----*/
  //recv(clientSocket, buffer, 1024, 0);
   
  /*---- Print the received message ----*/

  //printf("Data received: %s\n",buffer);
  printf("Enter file to be read\n");
  scanf("%s",file_name);
  send(clientSocket, "3214", 4, 0);
  recv(clientSocket, buffer, 1024, 0);
  printf("Data received: %s\n",buffer);
  FILE *fp = fopen("temp.html", "w+");
  if (fp != NULL)
  {
      fputs(buffer, fp);
      fclose(fp);
  }  
  printf("Reading Picture Size\n");

//read(new_sock, &size, sizeof(int));
int size;
recv(clientSocket, &size, sizeof(int), 0);
//printf("Buffer Value %s\n",buffer);
// = atoi(buffer);
//Read Picture Byte Array
printf("Reading Picture Byte Array\n");
printf("Size: %d",size);
char p_array[size];
//read(new_sock, p_array, size);
recv(clientSocket, p_array, size, 0);
printf("Content%s",p_array);
//Convert it Back into Picture
printf("Converting Byte Array to Picture\n");
FILE *image;
image = fopen("c1.jpg", "w");
fwrite(p_array, 1, sizeof(p_array), image);
fclose(image);

  // int status = system("firefox temp.html");
  return 0;
}
