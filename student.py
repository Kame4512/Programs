#This file will contains the class definition and the implementation of each member function.

class management:
    
   
    student = {
        1: {"name" : "",
            "student id": "",
            "course": ()
                    }        
    }

    new_course = {
        "course code": (),
        "course name": ()        
    }
    
    def __init__(self, name, student_id, courses, code, code_name):
        self.student[1]["name"] = self.name = name
        self.student[1]["student id"] = self.student_id = student_id
        self.student[1]["course"] = self.courses = courses
        self.new_course["course code"] = self.code = code
        self.new_course["course name"] = self.code_name = code_name
  
    def print_course(self):
        print(self.new_course["course code"])
        print(self.new_course["course name"])

 
    def add_student(self):
        i = 1
        name = input("Enter student name: ")
        while i  in self.student.keys():
            i += 1
        self.student.update({i: {"name": "", "student id": "",}})
        self.student[i]["name"] = name

        id = input("Enter student id: ")
        self.student[i]["student id"] = id

        num_of_course = input("enter the number of courses(1 - 4): ")

        num_of_course = int(num_of_course)
        course = []

        x = 0

        while x < num_of_course:
            course_name = input("Enter course name: ")
            course.append(course_name)
            x += 1

        course = tuple(course)
        
        self.student[i]["course"] = course
    
    def enroll_student_in_course(self, number):
        i = 1
        course = []
        while i in self.student.keys():
            if number == self.student[i]["student id"]:
                course = list(self.student[i]["course"])
                
                
                num_of_course = input("enter the number of courses to enroll(1 - 4): ")
                num_of_course = int(num_of_course)

                x = 0
                while x < num_of_course:
                    course_name = input("Enter course name: ")
                    course.append(course_name)
                    x += 1

                self.student[i]["course"] = tuple(course)

            i += 1

    
    def list_all_students(self):
        i = 1
        while i in self.student.keys():
            print(self.student[i]["name"],self.student[i]["student id"])
            i += 1

    def list_all_courses(self):
        i = 0
        while i < 5:
            print(self.new_course["course code"][i], self.new_course["course name"][i])
            i += 1

            
    def view_student_detail(self, number):
        i = 1
        while i in self.student.keys():
            if number == self.student[i]["student id"]:
                print(self.student[i])
            i += 1
        

    def view_course_details(self, code_number):

        i = 0
        while i < 5:
            if code_number == self.new_course["course code"][i]:
                
                

                x = 1
                while x in self.student.keys():

                    

                    s = self.student[x]["course"]

                    
                    
                    t = int(len(self.student[x]["course"]))

                    s = list(self.student[x]["course"])

                    y = 0

                    while y < t:
                        if s[y] == self.new_course["course name"][i]:
                            print(self.new_course["course code"][i], self.new_course["course name"][i], self.student[x]["name"])
                        
                        y += 1

                    x += 1
            i += 1      




                    
            

    






    

    

    

