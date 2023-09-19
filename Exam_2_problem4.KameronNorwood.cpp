#include <iostream>
using namespace std;

//add class definitions below this line
class Student
{
	private:
		string name;
		int grade;
		int score;
		
	public:
		Student (string n, int g)
		{
			name = n;
			grade = g;
		}
		int StudentStatus(int s);
};

int Student::StudentStatus(int s)
{
	if (s > 65)
	{
		cout << name << " has passed and will go into the next grade level, grade level " << grade + 1 << endl;
	}
	else
	{
		cout << name << " did not pass and will remain in the current grade level, grade level " << grade << endl;
	}
}

//add class definitions above this line

int main() {
  
  //DO NOT EDIT code above this line
  Student alice("Alice", 4);
  alice.StudentStatus(60);
  alice.StudentStatus(90);
  //DO NOT EDIT code above this line
  
  return 0;
  
}
