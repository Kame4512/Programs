// Follow the intructions for problem1

#include <iostream>
using namespace std;

//add class definitions below this line
class Fruit
{
	private:
		string name;
		string color;
	public:
		Fruit(string n, string c)
		{
			name = n;
			color = c;
		}
		string GetName();
		string GetColor();
		void SetName(string name);
		void SetColor(string color);
};


string Fruit::GetName()
{
	return name;
}

string Fruit::GetColor()
{
	return color;
}

void Fruit::SetName(string n)
{
	name = n;
}

void Fruit::SetColor(string c)
{
	color = c;
}

//add class definitions above this line


int main() {
  
  //DO NOT EDIT CODE BELOW THIS LINE

  Fruit fruit("apple", "red");
  cout << fruit.GetName() << endl;
  cout << fruit.GetColor() << endl;
  fruit.SetName("orange");
  fruit.SetColor("orange");
  cout << fruit.GetName() << endl;
  cout << fruit.GetColor() << endl;

  //DO NOT EDIT CODE ABOVE THIS LINE
  
  return 0;
  
}