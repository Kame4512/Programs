#include <iostream>
#include <string>
#include <iomanip>

using namespace std;

class TestGrader
{
private:
	string correct_answer[15];

public:
	void setKey(string[]);
	void grade(string[]);
};


void TestGrader::setKey(string correct[])
{
	for (int x = 0; x < 15; x++)
	{
		correct_answer[x] = correct[x];
	}
}
void TestGrader::grade(string test[])
{
	int right_answer = 0;
	int wrong_answer = 0;
	int count_answer = 0;

	for (int x = 0; x < 15; x++)
	{
		if (test[x] == correct_answer[x])
		{
			right_answer += 1;
			count_answer += 1;
		}
		else if (test[x] != correct_answer[x])
		{
			wrong_answer += 1;
		}
	}

	if (count_answer >= 15)
	{
		cout << "You have passed the driver's license exam" << endl;
	}
	else
	{
		cout << "You have failed the driver's license exam" << endl;
	}

	cout << "You got a total of " << right_answer << " questions right and a total of " << wrong_answer << " questions wrong in the test" << endl;


	cout << "You got questions ";
	for (int x = 0; x < 15; x++)
	{
		if (test[x] != correct_answer[x])
		{
			cout << x + 1 << " ";
		}
	}
	cout << "wrong" << endl;
}



int main()
{
	string correct_answer[15] = { "B", "C", "A", "C", "B", "D", "A", "B", "D", "C", "A", "C", "A", "B", "D"};

	TestGrader exam;

	exam.setKey(correct_answer);


	string yourTest[20];
	int choice;

	do
	{
		for (int x = 0; x < 15; x++)
		{
			cout << "Enter the answer for question " << x + 1 << ": ";
			cin >> yourTest[x];


			while (yourTest[x] > "D"  || yourTest[x] < "A")
			{
				cout << "Please enter from A-D: ";
				cin >> yourTest[x];
			}
		}

		exam.grade(yourTest);

		cout << endl << "Enter -1 to quit, else enter any number to retake the exam: ";
		cin >> choice;

	} while (choice != -1);
	


	return 0;
}