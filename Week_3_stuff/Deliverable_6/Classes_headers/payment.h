#ifndef payment_h
#define payment_h

#include "Classes_headers/employee.h"

/****************************************************************
 * Class definition : payment
 * @author Jaden Kandel, Steven Strange, Nathan Woodzisz
 * **************************************************************/

class Payment {

public:
    void increasesBalance();
    void decreaseBalance();

private:
    int pID;
    bool isInsurance;

};

#endif
