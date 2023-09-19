#include <iostream>
#include <fstream>
#include <string>
#include <cmath>

using namespace std;

int size = 10;

struct node
{
    int data;
    node* link;

};


int search(node* x, int num)
{
    while(x != nullptr)
    {
        if(num == x ->data)
        {
            return x ->data;
            
        }
        else
        {
           x = x ->link;
        }
    }
}


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

    b ->data = 20;
    b ->link = c;

    c ->data = 30;
    c ->link = d;

    d ->data = 40;
    d ->link = e;

    e ->data = 50;
    e ->link = nullptr;

    int x;

    cout << "Enter number: ";
    cin >> x;
    

    cout << search(sear, x);

}