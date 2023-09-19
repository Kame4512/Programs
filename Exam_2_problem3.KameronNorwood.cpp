#include <iostream>
using namespace std;

//add class definitions below this line

class MarbleBag {
  public:
    MarbleBag(int r, int b, int y) {
      red = r;
      blue = b;
      yellow = y;
    }
    int AddRed(int r);
    int AddBlue(int b);
    int AddYellow(int y);
    int RedTotal();
    int BlueTotal();
    int YellowTotal();
    int BagTotal();
    

  private:
    int red;
    int blue;
    int yellow;
};

int MarbleBag::AddRed(int r)
{
	red += r;
	return red;
}

int MarbleBag::AddBlue(int b)
{
	blue += b;
	return blue;
}

int MarbleBag::AddYellow(int y)
{
	yellow += y;
	return yellow;
}

int MarbleBag::RedTotal()
{
	return red;
}

int MarbleBag::BlueTotal()
{
	return blue;
}

int MarbleBag::YellowTotal()
{
	return yellow;
}

int MarbleBag::BagTotal()
{
	return red + blue + yellow;
}


//add class definitions above this line   

int main() {
  
  //DO NOT EDIT code below this line
  
  MarbleBag bag(12, 8, 19);
  bag.AddRed(4);
  bag.AddBlue(12);
  bag.AddYellow(-1);
  bag.AddBlue(-3);
  cout << "There are " << bag.RedTotal() << " red marbles." << endl;
  cout << "There are " << bag.BlueTotal() << " blue marbles." << endl;
  cout << "There are " << bag.YellowTotal() << " yellow marbles." << endl;
  cout << "There are " << bag.BagTotal() << " total marbles." << endl;

  //DO NOT EDIT code above this line
  
  return 0;
  
}