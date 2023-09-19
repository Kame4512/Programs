#include <iostream>
#include <fstream>
#include <string>
#include <cmath>

using namespace std;

int size = 10;


/*void swap(int *xp, int *yp)
{
    int temp = *xp;
    *xp = *yp;
    *yp = temp;
}*/

void selectionSort(int array[], int n)
{
   int i, j, min;

   for(i = 0; i < n - 1; i++)
   {
        min = i;
        for(j = i + 1; j < n; j++)
        {
            if(array[j] < array[min])
            {
                min = j;
            }
        }

        if(min != i)
        {
            swap(array[min], array[i]);
        }
   }
}
 
//Function to print an array
void printArray(int array[], int size)
{
    int i;
    for (i=0; i < size; i++)
    {
      cout << array[i] << " ";
      
    }
}

int main() 
{
    int num;
    int array[size] = {1, 12000000, 23, 54, 45, 56, 327, 78, 81229, 910};

    selectionSort(array, 10);

    printArray(array, 10);


   

}
