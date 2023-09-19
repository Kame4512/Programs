#include <iostream>
#include <fstream>
#include <string>
#include <cmath>

using namespace std;

struct node
{
    int data;
    node* link;

};

int main() 
{
    node* sear;
    sear = new node;

    

    node* a;
    a = new node;

    node* b;
    b = new node;

    node* c;
    c = new node;

    node* d;
    d = new node;

    node* e;
    e = new node;

    sear = a;


    a ->data = 10;
    a ->link = b;

    b ->data = 55;
    b ->link = c;

    c ->data = 22;
    c ->link = d;

    d ->data = 12;
    d ->link = e;

    e ->data = 90;
    e ->link = nullptr;
    
    int size = 5;
    int array[size] = {105, 90, 45, 100, 6};

    for(int i = 1; i < size; i ++)
    {
        for(int j = 0; j < size - i; j++)
        {
            if(array[j + 1] < array[j])
            {
                swap(array[j], array[j + 1]);
            }
        }
    }

    for(int x = 0; x < size; x++)
    {
        cout << array[x] << " ";
    }
    

    
}