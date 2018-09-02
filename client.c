
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
rm display.html \n\
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

  system(SHELLSCRIPT);

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
  serverAddr.sin_addr.s_addr = inet_addr("0.0.0.0");
   // Set all bits of the padding field to 0 
  memset(serverAddr.sin_zero, '\0', sizeof serverAddr.sin_zero);

  /*---- Connect the socket to the server using the address struct ----*/
  addr_size = sizeof serverAddr;
  connect(clientSocket, (struct sockaddr *) &serverAddr, addr_size);

  send(clientSocket,buffer,4,0);  

  FILE *HTMLDisplay;
  HTMLDisplay = fopen("display.html","ab");
  fprintf( HTMLDisplay, "%s\n", "<html>");
  fprintf( HTMLDisplay, "%s\n", "<body>");
  fclose(HTMLDisplay);


  for( i = 0;i<4;i++)
  {
    char image_name[10];
    int image_count=0;
    if(i==0)
    {
        strcpy(image_name, "A0.jpg");
        image_count = cars-'0';
    }
    if(i==1)
    {
        strcpy(image_name, "B0.jpg");
        image_count = cats-'0';
    }
    if(i==2)
    {
        strcpy(image_name, "C0.jpg");
        image_count = dogs-'0';
    }
    if(i==3)
    {
        strcpy(image_name, "D0.jpg");
        image_count = trucks-'0';
    }

    HTMLDisplay = fopen("display.html","ab");



    fprintf( HTMLDisplay, "%s\n", "<table>");

    if( i==0 && image_count ){
      fprintf( HTMLDisplay, "%s\n", " <h1> Cars </h1>");
    }
    else if( i==1 && image_count ){
      fprintf( HTMLDisplay, "%s\n", "<h1> Cats </h1>");
    }
    else if( i==2 && image_count ){
      fprintf( HTMLDisplay, "%s\n", "<h1> Dogs </h1>");
    }
    else if( i==3 && image_count ){
      fprintf( HTMLDisplay, "%s\n", "<h1> Trucks </h1>");
    }

    fprintf( HTMLDisplay, "%s\n", "<tr>");
    fclose(HTMLDisplay);
  
    int j;
    for( j = 0;j<image_count;j++)
    {

          image_name[1]++;

          char p_array[MAXSIZE];
          num= recv(clientSocket, p_array, MAXSIZE, 0);
          if(num<=0){
            printf("Network Error: Not able to Receive Image\n");
            break;
          }
          p_array[num] = '\0';
          printf("Image Recevied");

          FILE *image;
          printf("%s\n", image_name);
          image = fopen(image_name, "wb");
          fwrite(p_array, 1, sizeof(p_array), image);
          fclose(image);

          HTMLDisplay = fopen("display.html","ab");
          fprintf( HTMLDisplay, "%s\n", "<td>");
          fprintf( HTMLDisplay, "<img src=%s height=\"500\" width=\"500\">\n", image_name);
          fprintf( HTMLDisplay, "%s\n", "</td>");
          fclose(HTMLDisplay);      

          int i[1]={0};
          send(clientSocket, i, sizeof(int), 0);  

    }

  }

  HTMLDisplay = fopen("display.html","ab");
  fprintf( HTMLDisplay, "%s\n", "</tr>");
  fprintf( HTMLDisplay, "%s\n", "</table>");
  fprintf( HTMLDisplay, "%s\n", "</body>");
  fprintf( HTMLDisplay, "%s\n", "</head>");
  fclose(HTMLDisplay);

  return 0;
}
