#include <iostream>
#include <string>
#include <stdio.h>
#include <fstream>
#include <cstdlib>
#include <iomanip>
using namespace std;
/* run this program using the console pauser or add your own getch, system("pause") or input loop */


void print_by_name(string name[], string id[], string exam1[], string exam2[], string exam3[], int num_students);

int print_by_id(string name[], string id[], string exam1[], string exam2[], string exam3[], int num_students);

void edit_student_name(string name[], int position);

void print_list(string name[], string id[], string exam1[], string exam2[], string exam3[], int num_students);

int main(int argc, char** argv) {
	
	ifstream inputFile;
	string name[5] = {};
	string id[5] = {};
	string exam1[5] = {};
	string exam2[5] = {};
	string exam3[5] = {};
	int info = 0;
		
	inputFile.open("Students results.txt");
		
	while(!inputFile.eof())
	{
		inputFile >> id[info];
		inputFile >> name[info];
		inputFile >> exam1[info];
		inputFile >> exam2[info];
		inputFile >> exam3[info];
		
		printf("Student: %s %s \n", id[info].c_str(), name[info].c_str(), exam1[info].c_str(), exam2[info].c_str(), exam3[info].c_str());
			
			
		info++;
	}
	
	int num_students = info;
	inputFile.close();
	
	cout << num_students << " students were loaded..." << endl;
		cout << "\n\n***************************************************" << endl;
		cout << "*****" << setw(19) << " Menu " << setw(19) << "*****" << endl;
		cout << left << "1." << setw(5) << " Find student by name. " << endl;
		cout << left << "2." << setw(5) << " Find student by id. " << endl;
		cout << left << "3." << setw(5) << " Edit a student's name. " << endl;
		cout << left << "4." << setw(5) << " Print all student's information' " << endl;
		cout << left << "5." << setw(5) << " Quit. " << endl;
		
		
	int expression;
	cin >> expression;
	
	switch (expression)
	{
		case 1:
			print_by_name(name, id, exam1, exam2, exam3, num_students);
			break;
			
		case 2:
			print_by_id(name, id, exam1, exam2, exam3, num_students);
			break;
			
			
		case 3:
			{
			
			int position = print_by_id(name, id, exam1, exam2, exam3, num_students);
			edit_student_name(name, position);
			print_list(name, id, exam1, exam2, exam3, num_students);
			break;
		}
		case 4:
			
			print_list(name, id, exam1, exam2, exam3, num_students);
			break;
				
		break;
	}
	
	
	return 0;
}

void print_by_name(string name[], string id[], string exam1[], string exam2[], string exam3[], int num_students)
{
	string given_name;
	cout << "Write client name: " << endl;
	cin >> given_name;
	
	bool found = false;
	
	for(int i = 0; i < num_students; i++)
	{
		if(!name[i].compare(given_name))
		{
			found = true;
			printf("\n The information of the client is: %s %s %s %s %s", id[i].c_str(), name[i].c_str(), exam1[i].c_str(), exam2[i].c_str(), exam3[i].c_str());
		}
	}
}

int print_by_id(string name[], string id[], string exam1[], string exam2[], string exam3[], int num_students)
{
	string given_id;
	cout << "Write client id: " << endl;
	cin >> given_id;
	
	int position = 0;
	bool found = false;
	
	for(int i = 0; i < num_students; i++)
	{
		if(!id[i].compare(given_id))
		{
			found = true;
			position = i;
			printf("\n The information of the client is: %s %s %s %s %s", id[i].c_str(), name[i].c_str(), exam1[i].c_str(), exam2[i].c_str(), exam3[i].c_str());
			
		}
	}
	return 0;
}

void edit_student_name(string name[], int position)
{
	string new_name;
	
	int len = name[position].length();
	
	cout << "\nPlease provide the new name: " << endl;
	cin >> new_name;
	
	cout << "Change name " << name[position] << " by " << new_name << endl;
	
	name[position].replace(0,len,new_name);
}

void print_list(string name[], string id[], string exam1[], string exam2[], string exam3[], int num_students)
{
	cout << "\nClients information: " << endl;
	for (int i = 0; i < num_students; i++)
	{
		printf("\n The information of the client is: %s %s %s %s %s", id[i].c_str(), name[i].c_str(), exam1[i].c_str(), exam2[i].c_str(), exam3[i].c_str());
	}
}