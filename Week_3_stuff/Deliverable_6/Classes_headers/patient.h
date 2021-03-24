#ifndef patient_h
#define patient_h

#include "Classes_headers/appointment.h"
/****************************************************************
 * Class definition : patient
 * @author Jaden Kandel, Steven Strange, Nathan Woodzisz
 * **************************************************************/

class Patient {

public:
    void createApp();
    void rescheduleApp();

private:
    int pID;
    int doseNum;

};

#endif
