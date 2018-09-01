
/* credit @Daniel Scocco */

/****************** CLIENT CODE ****************/

#include <stdio.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <string.h>
#include <arpa/inet.h>




#define SHELLSCRIPT "\
#/bin/bash \n\
firefox file1.html \n\
"


int main(int argc , char * argv[]){
  int clientSocket;
  char buffer[1024];
  // char image[102400]
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
  // recv(clientSocket,buffer,10000,0);


  // printf("Enter file to be read\n");
  // scanf("%s",file_name);
  // send(clientSocket, file_name, 50, 0);
  // recv(clientSocket, buffer, 1024, 0);
  // printf("Data received: %s\n",buffer);
  // FILE *fp = fopen("temp.html", "w+");
  // if (fp != NULL)
  // {
  //     fputs(buffer, fp);
  //     fclose(fp);
  // }  
  // printf("Reading Picture Size\n");

  //read(new_sock, &size, sizeof(int));
  for(int i = 0;i<4;i++)

  {
    char image_name[10];
    char image_count=0;
    if(i==0)
    {
        image_name="A0.jpeg";
        image_count = cars-'0';
    }
    if(i==1)
    {
        image_name="B0.jpeg";
        image_count = cats-'0';
    }
    if(i==2)
    {
        image_name="C0.jpeg";
        image_count = dogs-'0';
    }
    if(i==3)
    {
        image_name="D0.jpeg";
        image_count = trucks-'0';
    }
    for(int j = 0;j<image_count;j++)
    {

      image_name[1]+=j;
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

    }

  }


  
  return 0;
}
