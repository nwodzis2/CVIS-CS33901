#ifndef campus_h
#define campus_h

#include "Classes_headers/orderRequest.h"
#include "Classes_headers/employee.h"
#include "Classes_headers/student.h"
#include<algorithm>
#include<list>
using std::list;
/****************************************************************
 * Class definition : campus
 * @author Jaden Kandel, Steven Strange, Nathan Woodzisz
 * **************************************************************/

class Campus {

public:
    int getVaccineCount();
    bool vAvailable;
    bool isRegional;
private:
    list<orderRequest> orderRequests;
    int cID;
    list<Employee> employees;
    list<Student> students;
    int currentVaccineCount;
};

#endif
