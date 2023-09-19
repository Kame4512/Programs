#include <iostream>
#include <fstream>
#include <string>
#include <cmath>

using namespace std;

int size = 10;

int partition(int array[], int start, int end)
{
    int pivot = array[start];

    int count = 0;

    for(int i = start + 1; i <= end; i++)
    {
        if(array[i] <= pivot)
        {
            count++;
        }

    }

    int pivotIndex = start + count;
    swap(array[pivotIndex], array[start]);

    int i = start, j = end;

    while(i < pivotIndex && j > pivotIndex)
    {
        while(array[i] <= pivot)
        {
            i++;
        }

        while(array[j] > pivot)
        {
            j--;
        }

        if(i < pivotIndex && j > pivotIndex)
        {
            swap(array[i++], array[j--]);
        }
    }

    return pivotIndex;
}


void quickSort(int array[], int start, int end)
{
    if(start >= end)
    {
        return;
    }

    int p = partition(array, start, end);

    quickSort(array, start, p - 1);

    quickSort(array, p + 1, end);
}





int main() 
{
    int num;
    int array[size] = {1, 12000000, 23543345, 54, 45, 56, 327, 78, 81229, 910};

    
    quickSort(array, 0, size - 1);
 
    for (int i = 0; i < size; i++) {
        cout << array[i] << " ";
    }

   

}