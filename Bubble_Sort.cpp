#include <iostream>
#include <fstream>
#include <string>

using namespace std;



int main() 
{
    int size = 20;
    int array[size] = {4, 0, 7, 5, 3, 99, 15, 39, 81, 12, 1, 4, 56, 11, 83, 8, 2, 7, 19, 20};

    
     //cout << search(array, 5);
     

    for(int a = 1; a < size; a++)
    {
        for(int b = 0; b < size - a; b++)
        {
            if(array[b] > array[b + 1])
            {
                swap(array[b], array[b + 1]);
            }
        }
    }



    for(int z = 0; z < size; z++)
    {
        cout << array[z] << " ";
    }
    
}