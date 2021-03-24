#ifndef appointment_h
#define appointment_h

#include<string>
using std::string;
#include"Classes_headers/patient.h"
#include"Classes_headers/stations.h"
#include"Classes_headers/dose.h"
#include"Classes_headers/medicalProfessional.h"

/****************************************************************
 * Class definition : Appointment
 * @author Jaden Kandel, Steven Strange, Nathan Woodzisz
 * **************************************************************/

class Appointment {
public:
    void createApp();
    void reschedule();
    bool isCancelled();
private:
    bool completed;
    int patientID;
    string date;
    int aID;
    bool canceled;
};

#endif
