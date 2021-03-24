#ifndef stations_h
#define stations_h

#include"Classes_headers/campus.h"
/****************************************************************
 * Class definition : Stations
 * @author Jaden Kandel, Steven Strange, Nathan Woodzisz
 * **************************************************************/

class Stations {

public:
    int getDoseCount();
    void Alert();
private:
    int dayDoseCount;
    int doses;
    int sID;

};

#endif
