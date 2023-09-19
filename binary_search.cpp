#include <iostream>
#include <fstream>
#include <string>
#include <cmath>

using namespace std;

int size = 10;

int binarysearch(int array[], int nume)
{
    int first = 0;
    int last = size - 1;
    int mid;

    bool found = false;

    while(first <= last && !found)
    {
        mid = (first + last) / 2;
        if(nume == array[mid])
        {
            found = true;
        }
        else if(array[mid] > nume)
        {
            last = mid - 1;
        }
        else
        {
            first = mid + 1;
        }
    }

    if(found)
    {
        return mid;
    }
    else
    {
        return -1;
    }
    
    
}

int main() 
{
    int num;
    int array[size] = {3, 14, 25, 42, 57, 61, 79, 88, 90, 100};

    
    cout << "Enter number: ";
    cin >> num;

    

    cout << binarysearch(array, num);


   

}