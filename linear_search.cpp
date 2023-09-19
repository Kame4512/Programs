#include <iostream>
#include <fstream>
#include <string>
#include <cmath>

using namespace std;

int size = 10;


int search(int i, int array[])
{
    bool found = false;
    int place = 0;
    while(place < size && !found)
    {
        if(i == array[place])
        {
            found =  true;
        }
        else
        {
            place++;
        }
    }

    if(found)
    {
        return place;
    }
    else
    {
        return -1;
    }
}



int main() 
{
    int num;
    int array[size] = {10, 50, 40, 14, 90, 32, 54, 12, 70, 20};

    cout << "Enter number: ";
    cin >> num;

    

    cout << search(num, array); 

    

    


    
}