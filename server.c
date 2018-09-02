/* credit @Daniel Scocco */

/****************** SERVER CODE ****************/

#include <stdio.h>
#include <netinet/in.h>
#include <string.h>
#include <sys/socket.h>
#include <arpa/inet.h>
#include <string.h>

void lower_string(char []);


int main(){
  int welcomeSocket, newSocket;
  char buffer[50];
  char ch,retbuf[1024]; 
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

  /*---- Listen on the socket, with 5 max connection requests queued ----*/
  while(1){
  if(listen(welcomeSocket,5)==0)
    printf("I'm listening\n");
  else
    printf("Error\n");

  /*---- Accept call creates a new socket for the incoming connection ----*/
  addr_size = sizeof serverStorage;
  newSocket = accept(welcomeSocket, (struct sockaddr *) &serverStorage, &addr_size);

  /*---- Send message to the socket of the incoming connection ----*/
  recv(newSocket,buffer,50,0);
  FILE *fp;
  fp = fopen(buffer, "r"); // read mode
 
  if (fp == NULL)
  {
     //perror("Error while opening the file.\n");
     //exit(EXIT_FAILURE);
     send(newSocket, "NO SUCH FILE EXISTS",19,0);
  }else{
  int i=0;
  while((ch = fgetc(fp)) != EOF){
      retbuf[i] = ch;
      i = i+1;
  }
  fclose(fp);
  send(newSocket,retbuf,1024,0);
  //strcpy(buffer,"Hello World\n");
  //lower_string(buffer);
  //send(newSocket,buffer,1024,0);
  }
  
printf("Getting Picture Size\n");
FILE *picture;
picture = fopen("pic.jpg", "r");
int size;
fseek(picture, 0, SEEK_END);
size = ftell(picture);
fseek(picture, 0, SEEK_SET);
//Send Picture Size
printf("Sending Picture Size\n");
printf("PICTURE SIZE %d",size);
//write(sock, &size, sizeof(size));
send(newSocket,&size,sizeof(size),0);
//Send Picture as Byte Array
printf("Sending Picture as Byte Array\n");
char send_buffer[size];
while(!feof(picture)) {
    fread(send_buffer, 1, sizeof(send_buffer), picture);
    printf("%s",send_buffer);
    //write(sock, send_buffer, sizeof(send_buffer));
    send(newSocket,send_buffer, sizeof(send_buffer),0);
    bzero(send_buffer, sizeof(send_buffer));
}
  }
  return 0;
  
}
void lower_string(char s[]) {
   int c = 0;
 
   while (s[c] != '\0') {
      if (s[c] >= 'A' && s[c] <= 'Z') {
         s[c] = s[c] + 32;
      }
      c++;
   }
}

