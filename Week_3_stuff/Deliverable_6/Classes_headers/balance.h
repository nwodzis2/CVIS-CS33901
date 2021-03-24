#ifndef balance_h
#define balance_h

#include"Classes_headers/campus.h"
/****************************************************************
 * Class definition : balance
 * @author Jaden Kandel, Steven Strange, Nathan Woodzisz
 * **************************************************************/

class Balance {

public:
    double getBalance();
    void increaseBalance();
    void decreaseBalance();
private:
    double balance;
};

#endif
