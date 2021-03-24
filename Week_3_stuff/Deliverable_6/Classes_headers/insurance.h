#ifndef insurance_h
#define insurance_h

#include "Classes_headers/payment.h"

/****************************************************************
 * Class definition : insurance
 * @author Jaden Kandel, Steven Strange, Nathan Woodzisz
 * **************************************************************/

class Insurance {

public:
    void makePayment();

private:
    int insurID;
    int isAccepted;
    
};

#endif
