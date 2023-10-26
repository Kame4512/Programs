# This file will contain the main program, where the student must test their program.
import student

course_code = ["1101","1201", "1301", "1401", "1501"]
course_code_names = ["English 101", "Algebra 101", "Chemistry 101", "History 101", "Team Sports"]




name = input("Enter name of student: ")
student_id = input("Enter student's id: ")
num_of_course = input("enter the number of courses(1 - 5): ")

num_of_course = int(num_of_course)

course = []

x = 0

while x < num_of_course:
    course_name = input("Enter course name(English 101, Algebra 101, Chemistry 101, History 101, Team Sports): ")
    course.append(course_name)
    x += 1



course = tuple(course)
course_code = tuple(course_code)
course_code_names = tuple(course_code_names)


obj = student.management(name, student_id, course, course_code, course_code_names)

obj.list_all_courses()

obj.add_student()
obj.add_student()

obj.list_all_students()


student_id = input("Enter student's id for enrollment: ")
obj.enroll_student_in_course(student_id)


obj.view_student_detail(student_id)




code_num = input("Enter code number: ")
obj.view_course_details(code_num)